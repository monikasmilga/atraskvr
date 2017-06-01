<?php

namespace App\Http\Controllers;

use App\Models\VRResources;

class VRResourceController extends Controller
{

    public function adminIndex()
    {
        $resources['list_data'] = VRResources::get()->toArray();

        $modelData = new VRResources();
        $configuration['tableName'] = 'resources';
        $configuration['id'] = VRResources::get()->pluck('id', 'id');
        $configuration['fields'] = $modelData->getFillable();

        return view('admin.list', $configuration, $resources);

    }

    protected function adminCreate()
    {
        $dataFromModel = new VRResources();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();


        return view('admin.createform', $configuration);
    }

    protected function adminStore(array $data = null)
    {
        $resource = request()->file('images');
//        dd(request()->all());
        $imgIds = [];
        foreach($resource as $image) {
            $uploadController = new VRUploadController();
            $record = $uploadController->upload($image);
            $imgIds[] = $record->id;
        }


//        if(request()->title != null)
             return  $imgIds;
//        else
//            return redirect()->route('app.resources.index');
    }

    public function getResourceStore()
    {
        return $this->adminStore();
    }

}
