<?php namespace App\Http\Controllers;

use App\Models\VRLanguages;
use App\Models\VRPages;
use App\Models\VRPagesCategories;
use App\Models\VRPagesTranslations;
use App\Models\VRResources;
use Illuminate\Routing\Controller;
use Ramsey\Uuid\Uuid;

class VRPagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET /vrpages
	 *
	 * @return Response
	 */
	public function index()
	{

	}

    /**
     * Display a listing of the resource.
     * GET /vrpages
     *
     * @return Response
     */
    public function adminIndex()
    {
        return view ('admin.index');
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /vrpages/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

    /**
     * Show the form for creating a new resource.
     * GET /vrpages/create
     *
     * @return Response
     */
    public function adminCreate()
    {
        $dataFromModel = new VRPages();

        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();
        //$configuration['list'] = VRPages::get()->toArray;

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('count', 'id')->toArray();
        $configuration['dropdown']['cover_image_id'] = VRResources::all()->pluck('path', 'id')->toArray();

        array_push ($configuration['fields'],'title') ;

        $configuration['dropdown']['languages_id'] = VRLanguages::all()->pluck( 'name', 'id')->toArray();
        array_push ($configuration['fields'],'languages_id');

        array_push ($configuration['fields'],'description_short') ;
        array_push ($configuration['fields'],'description_long') ;

        return view ('admin.pageform', $configuration);
    }

	/**
	 * Store a newly created resource in storage.
	 * POST /vrpages
	 *
	 * @return Response
	 */
	public function store()
	{
        //
	}

    /**
     * Store a newly created page in data base.
     * Creates slug automatically out of title given in form
     * POST /vrpages
     *
     * @return Response
     */
    public function adminStore()
    {
        $data = request()->all();
        $dataFromModel = new VRPages();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();


        $configuration['dropdown']['cover_image_id'] = VRResources::all()->pluck('path', 'id')->toArray();
        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('count', 'id')->toArray();

        array_push ($configuration['fields'],'title') ;
        $configuration['dropdown']['languages_id'] = VRLanguages::all()->pluck( 'name', 'id')->toArray();
        array_push ($configuration['fields'],'languages_id');
        array_push ($configuration['fields'],'description_short') ;
        array_push ($configuration['fields'],'description_long') ;

        $record = VRPages::create($data);

        $data['pages_id']=$record['id'];

        $title = $data['title'];
        $data['slug']=str_slug($title, '-');

        VRPagesTranslations::create($data);

        $configuration['comment'] = ['message' => trans(substr($configuration['tableName'], 0, -1) . ' added successfully')];

        return view('admin.pageform',  $configuration);
    }

	/**
	 * Display the specified resource.
	 * GET /vrpages/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /vrpages/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /vrpages/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
        //TODO find from VRPagesTranslations find record by $record->id && $data->languages_id
        //TODO if exists -> update
        //TODO if not exists -> create translation
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /vrpages/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}