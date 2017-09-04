<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Panda\Medicine;
use Panda\PurchaseDetail;

class PurchaseDetailController extends Controller
{
    public function find() {
        $detail = PurchaseDetail::all();
        return response()->json($detail);
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
       // $medicine = Medicine::find('medicine_id');
       // $medicine['stock'] = $medicine['stock'] + 'quantity';

        $create = PurchaseDetail::create($request->all());
        return response()->json($create);
    }
    public function updateStock($id)
    {
        $detail = PurchaseDetail::find($id);
        $medicine = Medicine::find($detail['medicine_id']);
        //->update( $medicine->stock = $medicine['stock'] + $detail['quantity']);
        
       // return response()->json($medicine);
       return  $medicine->stock = $medicine['stock'] + $detail['quantity'];
    }

}
