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

        if(is_array($resource))
        {
            foreach($resource as $image) {
                $uploadController = new VRUploadController();
                $record = $uploadController->upload($image, null);
                $imgIds[] = $record->id;
            }

        }
        if(request()->pages_categories_id != null)
             return  $imgIds;
        else
            return redirect()->route('app.resources.index');
    }

    public function getResourceStore()
    {
        return $this->adminStore();
    }


    public function adminShow($id)
    {
        $dataFromModel = new VRResources();
        $configuration['record'] = VRResources::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['mediaInfo']['mime_type'] = $configuration['record']['mime_type'];

        $configuration['image'] = VRResources::find($id)->path;

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $dataFromModel = new VRPagesCategories();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['record'] = VRPagesCategories::find($id)->toArray();

        return view('admin.editform', $configuration);
    }

    public function adminUpdate($id)
    {
        $data = request()->all();

        $dataFromModel = new VRPagesCategories();
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
            $configuration['record'] = VRPagesCategories::find($id)->toArray();
            return view('admin.editform', $configuration);
        }

        $record = VRPagesCategories::find($id);

        $record->update($data);

        $configuration['list_data'] = VRPagesCategories::get()->toArray();

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')){
            $configuration[ 'translationExist' ] = true;
        }

        $configuration['comment'] = ['message' => trans('Record added successfully')];

        return view('admin.list', $configuration);
    }

    public function adminDestroy($id)
    {
        if (VRPagesCategories::destroy($id) and VRPagesCategoriesTranslations::where('categories_id', '=', $id)->delete())
        {
            return json_encode(["success" => true, "id" => $id]);
        }
    }

}
