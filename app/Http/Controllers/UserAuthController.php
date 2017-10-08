<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Panda\Sale;
use Panda\User;

class UserAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getUserAuth()
    {
        // Obtiene el ID del Usuario Autenticado
        $id = Auth::id();
        return response()->json ($id);
    }
    public function getSaleUser($id)
    {
    	//$user = User::join('sales','users.id','=','sales.user_id')->select('users.*')->get();
    	$user = User::find($id);
    	return response()->json ($user['name']);
    }
}
