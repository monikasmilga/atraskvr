<?php

namespace App\Http\Controllers;

use App\Models\VRRoles;
use Illuminate\Http\Request;

class VRRolesController extends Controller
{
    public function index()
    {

    }

    public function adminIndex()
    {
//

        return view('admin.list');
    }
}
