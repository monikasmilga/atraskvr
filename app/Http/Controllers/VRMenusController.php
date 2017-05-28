<?php

namespace App\Http\Controllers;

use App\Models\VRLanguages;
use App\Models\VRMenu;
use App\Models\VRMenuTranslations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class VRMenusController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /menus
     *
     * @return Response
     */

    public function adminIndex()
    {
        $dataFromModel = new VRMenu();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRMenu::get()->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if(Route::has('app.' . $configuration['tableName'] . '.translations')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
        $dataFromModel = new VRMenu();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        $dataFromModel = new VRMenu();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $missingValues= '';
        foreach($configuration['fields'] as $key=> $value) {
            if (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }
        }
        if ($missingValues != ''){
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            return view('admin.createform', $configuration);
        }

        VRMenu::create([
            'id' => $data['id']
        ]);

        $configuration['comment'] = ['message' => trans('Record added successfully')];

        return view('admin.createform', $configuration);
    }

    public function adminCreateTranslations($id)
    {
        $dataFromModel = new VRMenu();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['record'] = VRMenu::find($id)->toArray();

        $dataFromModel2 = new VRMenuTranslations();
        $configuration['fields_translations'] = $dataFromModel2->getFillable();
        unset($configuration['fields_translations'][1]);
        unset($configuration['fields_translations'][2]);

        $configuration['translations'] = VRMenuTranslations::all()->where('categories_id', '=', $id)->toArray();

        $configuration['languages_names'] = VRLanguages::all()->pluck('name', 'id')->toArray();
        $configuration['languages'] = VRLanguages::all()->pluck('id')->toArray();

        return view('admin.translate', $configuration);
    }

    public function adminStoreTranslations($id)
    {
        $data = request()->all();

        $dataFromModel = new VRMenuTranslations();
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
                        VRMenuTranslations::create($record);
                        $comment[$name] = $name . ' translation added to database';
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
            $fullComment = $fullComment . $comment[$name] .'. ';
        }

        $dataFromModel = new VRMenu();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRMenu::get()->toArray();

        $configuration['fullComment'] = $fullComment;

        if(Route::has('app.' . $configuration['tableName'] . '.translations')){
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);

    }

    public function adminShow($id)
    {
        return('adminShow');

    }

    public function adminEdit($id)
    {
        return('adminEdit');

    }

    public function adminUpdate($id)
    {
        return('adminUpdate');

    }

    public function adminDestroy($id)
    {
        if (VRMenu::destroy($id)) {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}