<?php

namespace App\Http\Controllers;

use App\Models\VRCategoriesTranslations;
use App\Models\VRLanguages;
use App\Models\VRPagesCategories;
use App\Models\VRPagesTranslations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VRPagesCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /pages categories
     *
     * @return Response
     */

    public function adminIndex()
    {
        $dataFromModel = new VRPagesCategories();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRPagesCategories::get()->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("Create some " . $configuration['tableName'] . ", then go to list")];
            return view('admin.list', $configuration);
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
        $dataFromModel = new VRPagesCategories();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.createform2', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        VRPagesCategories::create([
            'id' => $data['id']
    ]);

        $dataFromModel = new VRPagesCategories();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.createform2', $configuration);
    }

    public function adminShow($id)
    {
        $dataFromModel = new VRPagesCategories();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['record'] = VRPagesCategories::find($id)->toArray();


        $dataFromModel2 = new VRCategoriesTranslations();
        $configuration['fields_translations'] = $dataFromModel2->getFillable();
        unset($configuration['fields_translations'][1]);
        unset($configuration['fields_translations'][2]);

        $categories_id = $id;

        $configuration['translations'] = VRCategoriesTranslations::all()->where('categories_id', '=', $categories_id)->toArray();

        $configuration['languages_names'] = VRLanguages::all()->pluck('name', 'id')->toArray();
        $configuration['languages'] = VRLanguages::all()->pluck('id')->toArray();

//        dd($configuration);

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $data = request()->all();

        dd($data);

//        $dataFromModel = new VRPagesCategories();
//        $configuration['fields'] = $dataFromModel->getFillable();
//        $configuration['tableName'] = $dataFromModel->getTableName();
//
//        $configuration['dropdown']['pads_id']=DTPads::all()->pluck('name', 'id')->toArray();
//        $configuration['dropdown']['cheeses_id']=DTCheeses::all()->pluck('name', 'id')->toArray();
//        $configuration['checkbox']['ingredients']=DTIngredients::all()->pluck('name', 'id')->toArray();
//
//        $configuration['record'] = VRPages::find($id)->toArray();
//        $configuration['pizza'] = VRPages::find($id);
//
//        $configuration['pizzas_ingredients']= $configuration['pizza']->pizzasConnections->pluck('ingredients_id')->toArray();
//
//        unset($configuration['fields'][6]);
//        array_push($configuration['fields'], "ingredients");
//        array_push($configuration['fields'], "comment");
//
//        return view('admin.editform', $configuration);
//
    }

    public function adminUpdate($id)
    {
        $data = request()->all();

        $dataFromModel = new VRCategoriesTranslations();
        $fields = $dataFromModel->getFillable();

        unset($fields[1]);
        unset($fields[2]);

        $languages = VRLanguages::all()->pluck('name', 'id')->toArray();

        $fullComment = '';

        foreach ($languages as $language_id => $name)
        {
            foreach ($fields as $field)
            {
                $key = $field . "_" . $language_id;
                $record[$field] = $data[$key];
                if(!$record[$field]){
                    $comment[$name] = $name . ' translation fields not full filed, the operation aborted';
                }
            }

            $record['categories_id'] = $id;
            $record['languages_id'] = $language_id;

            if(!isset($comment[$name]))
            {

            DB::beginTransaction();
            try {
                $recordExist = DB::table('vr_categories_translations')
                    ->whereCategories_idAndLanguages_id($id, $language_id)
                    ->first();

                    if(!$recordExist) {
                        VRCategoriesTranslations::create($record);
                        $comment[$name] = $name . ' translation added to the table';
                    } elseif ($recordExist) {
                        DB::table('vr_categories_translations')
                            ->whereCategories_idAndLanguages_id($id, $language_id)
                            ->update($record);
                        $comment[$name] = $name . ' translation updated';
                    }

            } catch(Exception $e) {
                DB::rollback();
                throw new Exception($e);
            }
            DB::commit();

            }

            $fullComment = $fullComment . '<br>' . $comment[$name];

        }

        dd($fullComment);
    }
}
