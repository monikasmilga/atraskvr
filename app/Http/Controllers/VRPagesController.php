<?php

namespace App\Http\Controllers;

use App\Models\VRLanguages;
use App\Models\VRPages;
use App\Models\VRPagesCategories;
use App\Models\VRPagesResourcesConnections;
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

//function to pull connected files from pages_resources_connections
    public function mediaFiles($id)
    {
        $config['mediaFilesShow'] = VRpages::with('resourceImage','pagesConnectedImages')->where('id', '=', $id)->get()->toArray();
        if(isset($config['mediaFilesShow']))
        {
            foreach($config['mediaFilesShow'] as $mediaFiles)
            {
                foreach($mediaFiles['pages_connected_images'] as $mediaFile)
                {
                    $connectedMediaData[] = $mediaFile['resources_connected_images'];
                    $config['connectedMediaData'] = $connectedMediaData;
                    if($mediaFile['resources_connected_images']['mime_type'] == "image/jpeg" || "image/png")
                    {
                        $config['image'][] = $mediaFile['resources_connected_images']['path'];
                    }
                    if($mediaFile['resources_connected_images']['mime_type'] == "video/mp4")
                    {
                        $config['video'][] = $mediaFile['resources_connected_images']['path'];
                    }
                }
            }
        }
        return $config;
    }


    public function adminCreate()
    {
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('id', 'id')->toArray();
        $configuration['dropdown']['cover_image'] = VRResources::all()->pluck('path', 'id')->toArray();

        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {

        $data = request()->all();


        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();
        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('id', 'id')->toArray();

        $missingValues = '';
        foreach ($configuration['fields'] as $key => $value) {
            if ($value == 'pages_categories_id') {
            } elseif (!isset($data['cover_image_id'])) {
                $missingValues = 'Please add cover image' . ',';
            }
            elseif (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }
        }

        if ($missingValues != '') {
            $missingValues = substr($missingValues, 0, -1);
            $configuration['error'] = ['message' => trans($missingValues)];
            return view('admin.createform', $configuration);
        }

        $allData = VRPages::create($data)->toArray();

        $resourceStore = new VRResourceController();
        $resource_id = $resourceStore->getResourceStore($allData);

        $configuration['comment'] = ['message' => trans('Record added successfully')];

        foreach($resource_id as $id) {

            VRPagesResourcesConnections::create([
                'pages_id' => $allData['id'],
                'resources_id' => $id
            ]);
        }
        return redirect()->route('app.pages.index');
    }

    public function adminShow($id)
    {
        $dataFromModel = new VRPages();
        $configuration['record'] = VRPages::find($id)->toArray();

        $configuration['mediaInfo'] = VRResources::find($configuration['record']['cover_image_id'])->toArray();

        $configuration['tableName'] = $dataFromModel->getTableName();

        $pagesCategoriesId = VRPages::find($id)->pages_categories_id;
        $configuration['category'] = VRPagesCategories::find($pagesCategoriesId)->name;

        $resourcesTable_id = VRPages::find($id)->cover_image_id;
        $configuration['image'] = VRResources::find($resourcesTable_id)->path;

        $dataFromModel2 = new VRPagesTranslations();
        $configuration['fields_translations'] = $dataFromModel2->getFillable();
        unset($configuration['fields_translations'][1]);
        unset($configuration['fields_translations'][2]);

        $configuration['translations'] = VRPagesTranslations::all()->where('pages_id', '=', $id)->toArray();
        $configuration['languages_names'] = VRLanguages::all()->pluck('name', 'id')->toArray();


        $configuration['connectedMediaDataArrays'] = $this-> mediaFiles($id);
        $configuration['connectedMediaDataArrays']['connectedMediaData'];



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

        $configuration['list_data'] = VRPages::get()->where('deleted_at', '=', null)->toArray();

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')){
            $configuration[ 'translationExist' ] = true;
        }

        $configuration['comment'] = ['message' => trans('Record updated successfully')];

        return view('admin.list', $configuration);
    }

    public function adminDestroy($id)
    {
        if (VRPages::destroy($id) and VRPagesTranslations::where('menus_id', '=', $id)->delete()) {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}