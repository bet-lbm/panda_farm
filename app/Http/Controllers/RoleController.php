<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role; 


class RoleController extends Controller
{
    public function index()
    {
    	$roles = Role::all();
    	return $roles;
    }
}
