<?php namespace App\Http\Controllers;

use App\Models\VRMenusTranslations;
use Illuminate\Routing\Controller;

class FrontEndController extends Controller
{

    public function frontPage()
    {
        return view('homepage');
    }

    public function experiencePage()
    {
        return view('page');
    }

    /**
     * Display a listing of the resource.
     * GET /frontend
     *
     * @return Response
     */
    public function index()
    {
        $configuration['menus'] = VRMenusTranslations::all()->where('languages_id', '=', 'lt')->toArray();
        return view('frontend.core', $configuration);
    }

    /**
     * Show the form for creating a new resource.
     * GET /frontend/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /frontend
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /frontend/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /frontend/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /frontend/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /frontend/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}