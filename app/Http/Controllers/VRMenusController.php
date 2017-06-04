<?php

namespace App\Http\Controllers;

use App\Models\VRLanguages;
use App\Models\VRMenus;
use App\Models\VRMenusTranslations;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
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
        $message = Session()->get('message');
        $configuration['message'] = $message;

        $dataFromModel = new VRMenus();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRMenus::get()->where('deleted_at', '=', null)->toArray();

        $configuration['menus'] = VRMenus::all()->pluck('name', 'id')->toArray();

//        dd($configuration);

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')){
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
        $message = Session()->get('message');
        $configuration['message'] = $message;

        $dataFromModel = new VRMenus();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['parent_id'] = VRMenus::all()->pluck('name', 'id')->toArray();

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

        $message = ['message' => trans('Record added successfully')];

        return redirect()->route('app.menus.create')->with($message);
    }

    public function adminShow($id)
    {
        $dataFromModel = new VRMenus();
        $configuration['record'] = VRMenus::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();
        $configuration['parent_id'] = VRMenus::get()->where('id', '=', (VRMenus::find($id)->parent_id))->pluck('name', 'id')->toArray();

        $dataFromModel2 = new VRMenusTranslations();
        $configuration['fields_translations'] = $dataFromModel2->getFillable();
        unset($configuration['fields_translations'][1]);
        unset($configuration['fields_translations'][2]);

        $configuration['translations'] = VRMenusTranslations::all()->where('menus_id', '=', $id)->toArray();
        $configuration['languages_names'] = VRLanguages::all()->pluck('name', 'id')->toArray();

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $dataFromModel = new VRMenus();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['record'] = VRMenus::find($id)->toArray();

        $configuration['dropdown']['parent_id'] = VRMenus::all()->pluck('name', 'id')->toArray();

        return view('admin.editform', $configuration);
    }

    public function adminUpdate($id)
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
            $configuration['record'] = VRMenus::find($id)->toArray();
            return view('admin.editform', $configuration);
        }

        $record = VRMenus::find($id);

        $record->update($data);

        DB::table('vr_menus_translations')
            ->whereMenus_idAndLanguages_id($id, 'lt')
            ->update([
                'title' => $record->name,
                'slug' => str_slug($record->name, '-'),
                     ]);

        $message = ['message' => trans('Record updated successfully')];

        return redirect()->route('app.menus.index')->with($message);
    }

    public function adminDestroy($id)
    {
        if ( VRMenus::destroy ( $id ) and VRMenusTranslations::where ( 'menus_id' , '=' , $id )->delete () ) {
            return json_encode ( [ "success" => true , "id" => $id ] );

        } elseif ( VRMenus::destroy ( $id ) ) {
            return json_encode ( [ "success" => true , "id" => $id ] );
        }
    }
}