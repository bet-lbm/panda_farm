<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Panda\Sale;

class SaleController extends Controller
{
    public function bill()
    {
        return view('sale.bill');
    }
    public function invoce()
    {
        return view('sale.invoce');
    }
    public function index() {
		$sales = Sale::orderBy('code', 'des')->paginate(5);
        $response = [
            'pagination' => [
                'total' => $sales->total(),
                'per_page' => $sales->perPage(),
                'current_page' => $sales->currentPage(),
                'last_page' => $sales->lastPage(),
                'from' => $sales->firstItem(),
                'to' => $sales->lastItem(),
            ],
            'data' => $sales  ];
        return response()->json($response);
	}
	public function store(Request $request) 
    {
    	$this->validate($request, [
    		'series' => 'required',
    		'number' => 'required',
    		'tipo' => 'required',
    		'cliente_id' => 'required',
    		'user_id' => 'required',
    		'date' => 'required',
    		'subtotal' => 'required',
    		'igv' => 'required',
    		'total'  => 'required',
        ]);
        $create = Sale::create($request->all());
        return response()->json($create);
    }
    public function numberInvoce(){
        $max = Sale::where('type','like','factura')->count();
        if ($max > 0) {
            $row = Sale::get()->where('type','like','factura')->max('number');
            $cod = $row + 1;
            $Strsig = (string)$cod;
            $formato = str_pad($Strsig, "7", "0", STR_PAD_LEFT);
        } 
        else {
            $sig = 1;
            $Strsig = (string)$sig;
            $formato = str_pad($Strsig,"7","0",STR_PAD_LEFT);
        }
        return response()->json($formato);
    }
    public function numberBill(){
        $max = Sale::where('type','like','boleta')->count();
        if ($max > 0) {
            $row = Sale::get()->where('type','like','boleta')->max('number');
            $cod = $row + 1;
            $Strsig = (string)$cod;
            $formato = str_pad($Strsig, "7", "0", STR_PAD_LEFT);
        } 
        else {
            $sig = 1;
            $Strsig = (string)$sig;
            $formato = str_pad($Strsig,"7","0",STR_PAD_LEFT);
        }
        return response()->json($formato);
    }
}
