<?php

namespace App\Http\Controllers;

use App\Models\VRPagesCategories;
use Illuminate\Http\Request;

class VRPagesCategoriesController extends Controller
{
    public function adminCreate()
    {
        $dataFromModel = new VRPagesCategories();
//        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['fields'] = ['id'];
        $configuration['tableName'] = $dataFromModel->getTableName();
//        array_push($configuration['fields'], "id");
//        dd($configuration);



        return view('admin.createform2', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

//        dd($data);

        unset($data['_token']);

        VRPagesCategories::create([
            'id' => $data['id']
    ]);

        $dataFromModel = new VRPagesCategories();
//        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['fields'] = ['id'];

        $configuration['tableName'] = $dataFromModel->getTableName();
        return view('admin.createform2', $configuration);
    }
}
