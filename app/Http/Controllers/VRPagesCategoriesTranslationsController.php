<?php

namespace App\Http\Controllers;

use App\Models\VRCategoriesTranslations;
use App\Models\VRLanguages;
use App\Models\VRPagesCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class VRPagesCategoriesTranslationsController extends Controller
{
    public function adminCreate($id)
    {
        $dataFromModel = new VRPagesCategories();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['record'] = VRPagesCategories::find($id)->toArray();

        $dataFromModel2 = new VRCategoriesTranslations();
        $configuration['fields_translations'] = $dataFromModel2->getFillable();
        unset($configuration['fields_translations'][1]);
        unset($configuration['fields_translations'][2]);

        $configuration['translations'] = VRCategoriesTranslations::all()->where('categories_id', '=', $id)->toArray();

        $configuration['languages_names'] = VRLanguages::all()->pluck('name', 'id')->toArray();
        $configuration['languages'] = VRLanguages::all()->pluck('id')->toArray();

        return view('admin.translate', $configuration);
    }

    public function adminStore($id)
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

        $dataFromModel = new VRPagesCategories();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRPagesCategories::get()->toArray();

        $configuration['fullComment'] = $fullComment;

        if(Route::has('app.' . $configuration['tableName'] . '.translations')){
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);

    }

}
