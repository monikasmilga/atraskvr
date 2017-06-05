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
        $message = Session()->get('message');
        $configuration['message'] = $message;

        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRPages::get()->where('deleted_at', '=', null)->toArray();

        $configuration['coverImages'] = VRResources::all()->pluck('path', 'id')->toArray();

        $configuration['categories'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();

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
        $message = Session()->get('message');
        $configuration['message'] = $message;

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
        $newVRResourcesController = new VRUploadController();
        $record = $newVRResourcesController->upload($resource, null);
        $data['cover_image_id'] = $record->id;

        VRPages::create($data);

        $message = ['message' => trans('Record added successfully')];

        return redirect()->route('app.pages.create')->with($message);
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

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['record'] = VRPages::find($id)->toArray();

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();

//        $resourcesTable_id = VRPages::find($id)->cover_image_id;
//        $configuration['coverImage'] = VRResources::find($resourcesTable_id)->path;

        return view('admin.editform', $configuration);
    }

    public function adminUpdate($id)
    {
        $data = request()->all();

        $data['cover_image_id'] = request()->file('image');

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

        $resource = request()->file('image');
        $newVRResourcesController = new VRUploadController();
        $resourceId = VRPages::find($id)->cover_image_id;
        $record = $newVRResourcesController->upload($resource, $resourceId);
        $data['cover_image_id'] = $record->id;

        $record = VRPages::find($id);

        $record->update($data);

        DB::table('vr_pages_translations')
            ->wherePages_idAndLanguages_id($id, 'lt')
            ->update([
                         'title' => $record->name,
                         'slug' => str_slug($record->name, '-'),
                     ]);

        $message = ['message' => trans('Record updated successfully')];

        return redirect()->route('app.pages.index')->with($message);
    }

    public function adminDestroy($id)
    {
        if (VRPages::destroy($id) and VRResources::find(VRPages::find($id)->cover_image_id)->delete()){

            if(VRPagesTranslations::where('pages_id', '=', $id)->delete()){
                return json_encode(["success" => true, "id" => $id]);
            }

            else {
                return json_encode(["success" => true, "id" => $id]);
            }
        }
    }
}