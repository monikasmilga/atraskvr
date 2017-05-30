<?php

namespace App\Http\Controllers;

use App\Models\VRLanguages;
use App\Models\VRPages;
use App\Models\VRPagesCategories;
use App\Models\VRPagesTranslations;
use App\Models\VRResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class VRPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /menus
     *
     * @return Response
     */
    public function adminIndex()
    {
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRPages::get()->where('deleted_at', '=', null)->toArray();

        //take cover images
        $configuration['coverImages'] = VRResources::all()->pluck('path', 'id')->toArray();


        //TODO take categories

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if (Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration['translationExist'] = true;
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();

        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        $data['cover_image_id'] = request()->file('image');

        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();
        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();

        $missingValues = '';
        foreach ($configuration['fields'] as $key => $value) {
            if ($value == 'pages_categories_id') {
            } elseif (!isset($data['cover_image_id'])) {
                $missingValues = 'Please add cover image' . ',';
            }
//            elseif (!isset($data[$value])) {
//                $missingValues = $missingValues . ' ' . $value . ',';
//            }
        }

        if ($missingValues != '') {
            $missingValues = substr($missingValues, 0, -1);
            $configuration['error'] = ['message' => trans($missingValues)];
            return view('admin.createform', $configuration);
        }

        $resource = request()->file('image');
        $newDTResourcesController = new VRUploadController();
        $record = $newDTResourcesController->upload($resource);
        $data['cover_image_id'] = $record->id;

        VRPages::create($data);

        $configuration['comment'] = ['message' => trans('Record added successfully')];

        return view('admin.createform', $configuration);
    }

    public function adminShow($id)
    {
        $dataFromModel = new VRPages();
        $configuration['record'] = VRPages::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $pagesCategoriesId = VRPages::find($id)->pages_categories_id;
        $configuration['category'] = VRPagesCategories::find($pagesCategoriesId)->name;

        $resourcesTable_id = VRPages::find($id)->cover_image_id;
        $configuration['coverImage'] = VRResources::find($resourcesTable_id)->path;

        $dataFromModel2 = new VRPagesTranslations();
        $configuration['fields_translations'] = $dataFromModel2->getFillable();
        unset($configuration['fields_translations'][1]);
        unset($configuration['fields_translations'][2]);

        $configuration['translations'] = VRPagesTranslations::all()->where('pages_id', '=', $id)->toArray();
        $configuration['languages_names'] = VRLanguages::all()->pluck('name', 'id')->toArray();

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();


        $configuration['record'] = VRPages::find($id)->toArray();

        return view('admin.editform', $configuration);
    }

    public function adminUpdate($id)
    {
        $data = request()->all();

        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $missingValues = '';
        foreach ($configuration['fields'] as $key => $value) {
            if ($value == 'parent_id') {
            } elseif (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }
        }
        if ($missingValues != '') {
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            $configuration['record'] = VRPages::find($id)->toArray();
            return view('admin.editform', $configuration);
        }

        $record = VRPages::find($id);

        $record->update($data);

        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRPages::get()->toArray();

        if (Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration['translationExist'] = true;
        }

        $configuration['fullComment'] = 'Record updated successfully';

        return view('admin.list', $configuration);
    }

    public function adminDestroy($id)
    {
        if (VRPages::destroy($id) and VRPagesTranslations::where('menus_id', '=', $id)->delete()) {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}