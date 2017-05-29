<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseAPIController extends Controller
{

    /**
     * Display a listing of the resource.
     * GET /baseapi
     *
     * @return Response
     */
    public function apiIndex()
    {
        return response()->json(
            [
                'success' => false,
                'message' => "method not found",
            ],
            401);
    }

    /**
     * Show the form for creating a new resource.
     * GET /baseapi/create
     *
     * @return Response
     */

    public function apiStore()
    {
        return response()->json(
            [
                'success' => false,
                'message' => "method not found",
            ],
            401);
    }

    /**
     * Display the specified resource.
     * GET /baseapi/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function apiShow($id)
    {
        return response()->json(
            [
                'success' => false,
                'message' => "method not found",
            ],
            401);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /baseapi/{id}/edit
     *
     * @param  int $id
     * @return Response
     */

    public function apiUpdate($id)
    {
        return response()->json(
            [
                'success' => false,
                'message' => "method not found",
            ],
            401);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /baseapi/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function apiDestroy($id)
    {
        return response()->json(
            [
                'success' => false,
                'message' => "method not found",
            ],
            401);
    }

}