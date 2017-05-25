<?php

namespace App\Http\Controllers;

use App\Models\VRCategoriesTranslations;
use App\Models\VRLanguages;
use App\Models\VRPagesCategories;
use Illuminate\Http\Request;

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

        $configuration['record'] = VRCategoriesTranslations::find($id)->toArray();

        $configuration['languages'] = VRLanguages::all()->pluck('name', 'id')->toArray();



//        $resourcesTable_id = VRPagesCategories::find($id)->resources_id;
//        $configuration['ingredientImage'] = DTResources::find($resourcesTable_id)->path;

        return view('admin.single', $configuration);
    }
}
