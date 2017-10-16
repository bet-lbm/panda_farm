<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Panda\Medicine;
use Panda\SaleDetail;

class SaleDetailController extends Controller
{
   public function store(Request $request) 
    {
        $this->validate($request, [
            'sale_series' => 'required',
            'sale_number' => 'required',
            'medicine_id' => 'required',
            'medicine_name' => 'required',
            'quantity' => 'required',
            'sale_price' => 'required',
            'discount' => 'required',
            'subtotal' => 'required' ,
        ]);
       $create = SaleDetail::create($request->all());
        return response()->json($create);
    }

    public function updateStock()
    {
        $detail = SaleDetail::get()->last();
        $medicine = Medicine::find($detail['medicine_id']);
        $medicine->stock = $medicine['stock'] - $detail['quantity'];
        $medicine->update();
        return  response()->json($medicine);
    }
}
