<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Panda\Medicine;
use Panda\PurchaseDetail;

class PurchaseDetailController extends Controller
{
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

    public function updateStock()
    {
        $detail = PurchaseDetail::get()->last();
        $medicine = Medicine::find($detail['medicine_id']);
        $medicine->stock = $medicine['stock'] + $detail['quantity'];
        $medicine->update();
        return  response()->json($medicine);
    }

}
