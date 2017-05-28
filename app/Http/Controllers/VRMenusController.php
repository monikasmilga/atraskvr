<?php

namespace App\Http\Controllers;

use App\Models\VRLanguages;
use App\Models\VRMenus;
use App\Models\VRMenusTranslations;
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
        $dataFromModel = new VRMenus();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRMenus::get()->toArray();

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
        $dataFromModel = new VRMenus();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        $dataFromModel = new VRMenus();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $missingValues= '';
        foreach($configuration['fields'] as $key=> $value) {
            if ($value == 'parent_id'){}
            elseif (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }
        }
        if ($missingValues != ''){
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            return view('admin.createform', $configuration);
        }

        VRMenus::create($data);

        $configuration['comment'] = ['message' => trans('Record added successfully')];

        return view('admin.createform', $configuration);
    }

    public function adminShow($id)
    {
        $dataFromModel = new VRMenus();
        $configuration['record'] = VRMenus::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.single', $configuration);
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
        if (VRMenus::destroy( $id)) {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}