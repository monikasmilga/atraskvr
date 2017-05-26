<?php

namespace App\Http\Controllers;

use App\Models\VRLanguages;
use Illuminate\Http\Request;

class VRLanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /pages categories
     *
     * @return Response
     */

    public function adminIndex()
    {
        $dataFromModel = new VRLanguages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRLanguages::get()->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("Create some " . $configuration['tableName'] . ", then go to list")];
            return view('admin.list', $configuration);
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
        $dataFromModel = new VRLanguages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.createform2', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        VRLanguages::create($data);

        $dataFromModel = new VRLanguages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.createform2', $configuration);
    }
}
