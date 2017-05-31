<?php

namespace App\Http\Controllers;

use App\Models\VRCategoriesTranslations;
use App\Models\VRLanguages;
use App\Models\VRPagesCategories;
use App\Models\VRPagesCategoriesTranslations;
use App\Models\VRPagesTranslations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

        $configuration['list_data'] = VRPagesCategories::get()->where('deleted_at', '=', null)->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
        $dataFromModel = new VRPagesCategories();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        $dataFromModel = new VRPagesCategories();
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

//        VRPagesCategories::create([
//            'id' => $data['id']
//        ]);

        VRPagesCategories::create($data);

        $configuration['comment'] = ['message' => trans('Record added successfully')];

        return view('admin.createform', $configuration);
    }

    public function adminShow($id)
    {
        $dataFromModel = new VRPagesCategories();
        $configuration['record'] = VRPagesCategories::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $dataFromModel2 = new VRPagesCategoriesTranslations();
        $configuration['fields_translations'] = $dataFromModel2->getFillable();
        unset($configuration['fields_translations'][1]);
        unset($configuration['fields_translations'][2]);

        $configuration['translations'] = VRPagesCategoriesTranslations::all()->where('categories_id', '=', $id)->toArray();
        $configuration['languages_names'] = VRLanguages::all()->pluck('name', 'id')->toArray();

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $dataFromModel = new VRPagesCategories();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['record'] = VRPagesCategories::find($id)->toArray();

        return view('admin.editform', $configuration);
    }

    public function adminUpdate($id)
    {
        $data = request()->all();

        $dataFromModel = new VRPagesCategories();
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
            $configuration['record'] = VRPagesCategories::find($id)->toArray();
            return view('admin.editform', $configuration);
        }

        $record = VRPagesCategories::find($id);

        $record->update($data);

        $configuration['list_data'] = VRPagesCategories::get()->toArray();

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')){
            $configuration[ 'translationExist' ] = true;
        }

        $configuration['comment'] = ['message' => trans('Record updated successfully')];

        return view('admin.list', $configuration);
    }

    public function adminDestroy($id)
    {
        if (VRPagesCategories::destroy($id) and VRPagesCategoriesTranslations::where('categories_id', '=', $id)->delete())
        {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}
