<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Panda\PurchaseDetail;

class PurchaseDetailController extends Controller
{
    public function find() {
        $purchases = PurchaseDetail::all();
        return response()->json($response);
    }
    public function store(Request $request) 
    {
    	$this->validate($request, [
    		'purchase_id' => 'required' ,
    		'medicine_id' => 'required' ,
    		'quantity' => 'required' ,
    		'price' => 'required' ,
    		'subtotal' => 'required' ,
        ]);
        $create = PurchaseDetail::create($request->all());
        return response()->json($create);
    }

}
