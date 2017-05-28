<?php

namespace App\Http\Controllers;

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

        //take image

        //take categories

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
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['pages_categories_id']=VRPagesCategories::all()->pluck('name', 'id')->toArray();

        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        $data['cover_image_id'] = request()->file('image');

        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();
        $configuration['dropdown']['pages_categories_id']=VRPagesCategories::all()->pluck('name', 'id')->toArray();

        $missingValues= '';
        foreach($configuration['fields'] as $key=> $value) {
            if ($value == 'pages_categories_id'){}
            elseif (!isset($data['cover_image_id'])) {
                $missingValues = 'Please add cover image' . ',';
            }
//            elseif (!isset($data[$value])) {
//                $missingValues = $missingValues . ' ' . $value . ',';
//            }
        }
        if ($missingValues != ''){
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
//        $configuration['record'] = VRPages::find($id)->where('id', '=', $id)->with(['category'])->get()->toArray();
        $configuration['record'] = VRPages::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $resourcesTable_id = VRPages::find($id)->cover_image_id;
        $configuration['coverImage'] = VRResources::find($resourcesTable_id)->path;

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['pages_categories_id']=VRPagesCategories::all()->pluck('name', 'id')->toArray();


        $configuration['record'] = VRPages::find($id)->toArray();

        return view('admin.editform', $configuration);
    }

    public function adminUpdate($id)
    {
        $data = request()->all();

        $dataFromModel = new VRPages();
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
            $configuration['record'] = VRPages::find($id)->toArray();
            return view('admin.editform', $configuration);
        }

        $record = VRPages::find($id);

        $record->update($data);

        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRPages::get()->toArray();

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')){
            $configuration[ 'translationExist' ] = true;
        }

        $configuration['fullComment'] = 'Record updated successfully';

        return view('admin.list', $configuration);
    }

    public function adminDestroy($id)
    {
        if(VRPages::destroy($id) and VRPagesTranslations::where('menus_id', '=', $id)->delete())
        {
            return json_encode(["success" => true, "id" => $id]);
        }
    }













    /**
     * Display a listing of the resource.
     * GET /pages
     *
     * @return Response
     */
    public function adminIndexnereik()
    {
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRPages::get()->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if(Route::has('app.' . $configuration['tableName'] . '.translations')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);
    }

    /**
     * Show the form for creating a new resource.
     * GET /pages/create
     *
     * @return Response
     */
    public function adminCreatenereik()
    {
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();


        return view('admin.createform', $configuration);
    }

    /**
     * Store a newly created resource in storage.
     * POST /pages
     *
     * @return Response
     */
    public function adminStorenereik()
    {
        $data = request()->all();

        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['pads_id']=DTPads::all()->pluck('name', 'id')->toArray();
        $configuration['dropdown']['cheeses_id']=DTCheeses::all()->pluck('name', 'id')->toArray();
        $configuration['checkbox']['ingredients']=DTIngredients::all()->pluck('name', 'id')->toArray();

        $configuration['cache'] = cache()->get('super-ingredient');

        unset($configuration['fields'][6]);
        array_push($configuration['fields'], "ingredients");
        array_push($configuration['fields'], "comment");

        $missingValuesNot= '';
        $missingValues= '';
        foreach($configuration['fields'] as $key=> $value) {
            if ($value == 'kuku'){}
            elseif ($value == 'calories'){}
            elseif ($value == 'user_id'){}

            elseif (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }

            elseif ($value == 'ingredients' and sizeOf($data[$value]) > 3)
            {
                $configuration['error'] = ['message' => trans("Please add up to 3 ingredients")];
                return view('admin.createform', $configuration);
            }
        }
        if ($missingValues  != $missingValuesNot){
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            return view('admin.createform', $configuration);
        }

        $pad_calories = array_sum(DB::table('dt_pads')->where('id', '=', $data['pads_id'])->select('calories')->get()->pluck('calories')->toArray());
        $cheeses_calories = array_sum(DB::table('dt_cheeses')->where('id', '=', $data['cheeses_id'])->select('calories')->get()->pluck('calories')->toArray());

        $ingredients_calories = 0;
        foreach ($data['ingredients'] as $ingredient)
        {
            $ingredient_calories = DB::table('dt_ingredients')->where('id', '=', $ingredient)->select('calories')->get()->pluck('calories')->toArray();
            $ingredients_calories+= array_sum($ingredient_calories);
        }

        $data['calories'] = $pad_calories + $cheeses_calories + $ingredients_calories;

        $record = VRPages::create($data);

        $record->connection()->sync($data['ingredients']);

        $configuration['comment'] = ['message' => trans(substr($configuration['tableName'], 0, -1) . ' added successfully')];
        return view('admin.createform',  $configuration);

    }

    /**
     * Display the specified resource.
     * GET /pages/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function adminShownereik($id)
    {
        $dataFromModel = new VRPages();

        $configuration['record'] = VRPages::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();


        return view('admin.single', $configuration);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /pages/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function adminEditnereik($id)
    {
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['pads_id']=DTPads::all()->pluck('name', 'id')->toArray();
        $configuration['dropdown']['cheeses_id']=DTCheeses::all()->pluck('name', 'id')->toArray();
        $configuration['checkbox']['ingredients']=DTIngredients::all()->pluck('name', 'id')->toArray();

        $configuration['record'] = VRPages::find($id)->toArray();
        $configuration['pizza'] = VRPages::find($id);

        $configuration['pizzas_ingredients']= $configuration['pizza']->pizzasConnections->pluck('ingredients_id')->toArray();

        unset($configuration['fields'][6]);
        array_push($configuration['fields'], "ingredients");
        array_push($configuration['fields'], "comment");

        return view('admin.editform', $configuration);

    }

    /**
     * Update the specified resource in storage.
     * PUT /pages/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function adminUpdatenereik($id)
    {
        $data = request()->all();

        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['dropdown']['pads_id']=DTPads::all()->pluck('name', 'id')->toArray();
        $configuration['dropdown']['cheeses_id']=DTCheeses::all()->pluck('name', 'id')->toArray();
        $configuration['checkbox']['ingredients']=DTIngredients::all()->pluck('name', 'id')->toArray();

        unset($configuration['fields'][6]);
        array_push($configuration['fields'], "ingredients");
        array_push($configuration['fields'], "comment");

        $missingValuesNot= '';
        $missingValues= '';
        foreach($configuration['fields'] as $key=> $value) {
            if ($value == 'comment'){}
            elseif ($value == 'calories'){}
            elseif ($value == 'user_id'){}

            elseif (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }

            elseif ($value == 'ingredients' and sizeOf($data[$value]) > 3)
            {
                $configuration['error'] = ['message' => trans("Please add up to 3 ingredients")];
                return view('admin.createform', $configuration);
            }
        }
        if ($missingValues  != $missingValuesNot){
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            return view('admin.createform', $configuration);
        }

        $pad_calories = array_sum(DB::table('dt_pads')->where('id', '=', $data['pads_id'])->select('calories')->get()->pluck('calories')->toArray());
        $cheeses_calories = array_sum(DB::table('dt_cheeses')->where('id', '=', $data['cheeses_id'])->select('calories')->get()->pluck('calories')->toArray());

        $ingredients_calories = 0;
        foreach ($data['ingredients'] as $ingredient)
        {
            $ingredient_calories = DB::table('dt_ingredients')->where('id', '=', $ingredient)->select('calories')->get()->pluck('calories')->toArray();
            $ingredients_calories+= array_sum($ingredient_calories);
        }

        $data['calories'] = $pad_calories + $cheeses_calories + $ingredients_calories;

        $record = VRPages::find($id);
        $data = request()->all();
        $record->update($data);

        $record->connection()->sync($data['ingredients']);

        $configuration['comment'] = ['message' => trans(substr($configuration['tableName'], 0, -1) . ' update successfull')];
        return view('admin.createform',  $configuration);

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /pages/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function adminDestroynereik($id)
    {
        if (VRPages::destroy($id)) {
            return json_encode(["success" => true, "id" => $id]);
        }
    }

}