<?php

namespace App\Http\Controllers;

use App\Models\VRLanguages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if(Route::has('app.' . $configuration['tableName'] . '.translations')){
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
        $dataFromModel = new VRLanguages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        $dataFromModel = new VRLanguages();
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

        VRLanguages::create([
                           'id' => $data['id']
                       ]);

        $configuration['comment'] = ['message' => trans('Record added successfully')];

        return view('admin.createform', $configuration);
    }
}
