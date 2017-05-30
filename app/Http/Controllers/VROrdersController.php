<?php

namespace App\Http\Controllers;

use App\Models\VROrders;
use App\Models\VRPagesCategories;
use Illuminate\Support\Facades\Route;

class VROrdersController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Function displays all Orders existing in data base
     */
    public function adminIndex()
    {
        $dataFromModel = new VROrders();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VROrders::get()->where('deleted_at', '=', null)->toArray();

        return view('admin.list', $configuration);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Function shows Order creating form
     */
    public function adminCreate()
    {
        $dataFromModel = new VROrders();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();
        $configuration['dropdown']['status'] = $dataFromModel->all();

//TODO figure out how to show ENUM values in dropdown of "STATUS" field

        return view('admin.createform', $configuration);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Function takes Order data from Order create form and stores to data base
     */
    public function adminStore()
    {
        $data = request()->all();

        $dataFromModel = new VROrders();
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

        VROrders::create($data);

        $configuration['comment'] = ['message' => trans('Record added successfully')];

        return view('admin.createform', $configuration);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Displays details of only one Order found in data base by ID
     */
    public function adminShow($id)
    {
        $dataFromModel = new VROrders();
        $configuration['record'] = VROrders::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();
        $configuration['translations'] = [];

        return view('admin.single', $configuration);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Shows editing form of one Order found in data base by ID
     */
    public function adminEdit($id)
    {
        $dataFromModel = new VROrders();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['record'] = VROrders::find($id)->toArray();

        return view('admin.editform', $configuration);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Updates data of one Order in data base by ID, checks if all fields are filled
     */
    public function adminUpdate($id)
    {
        $data = request()->all();

        $dataFromModel = new VROrders();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $missingValues = '';
        foreach ($configuration['fields'] as $key => $value) {
            if (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }
        }
        if ($missingValues != '') {
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            $configuration['record'] = VRPagesCategories::find($id)->toArray();
            return view('admin.editform', $configuration);
        }

        $record = VROrders::find($id);
        $record->update($data);

        $configuration['list_data'] = VROrders::get()->toArray();
        $configuration['comment'] = ['message' => trans('Record added successfully')];

        return view('admin.list', $configuration);
    }

    public function adminDestroy($id)
    {
        if (VROrders::destroy($id))
        {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}
