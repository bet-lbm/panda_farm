<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Panda\Sale;
use Panda\SaleDetail;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        return view('sales.index');
    }
    public function bill()
    {
        return view('sales.bill');
    }
    public function invoce()
    {
        return view('sales.invoce');
    }
    public function getCancel()
    {
        return view('sales.cancel');
    }
    public function index() {
		$sales = Sale::where('enabled',1)->orderBy('created_at', 'desc')->paginate(5);
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
    public function search(Request $request)
    {
        $queryString=$request->input('queryString');
        $sales=Sale::where('number','like','%'.$queryString.'%')->latest()->paginate(5);
        $response=[
            'pagination'=>[
                'total'=>$sales->total(),
                'per_page'=>$sales->perPage(),
                'current_page'=>$sales->currentPage(),
                'last_page'=>$sales->lastPage(),
                'from'=>$sales->firstItem(),
                'to'=>$sales->lastItem(),
            ],
            'data'=>$sales
        ];
        return response()->json($response);
    }
	public function store(Request $request) 
    {
    	$this->validate($request, [
    		'series' => 'required',
    		'number' => 'required',
    		'type' => 'required',
    		'client_id' => 'required',
    		'user_id' => 'required',
    		'date' => 'required',
    		'subtotal' => 'required',
    		'igv' => 'required',
    		'total_price'  => 'required',
        ]);
        $create = Sale::create($request->all());
        return response()->json($create);
    }
    public function numberInvoce(){
        $max = Sale::where('type','like','F')->count();
        if ($max > 0) {
            $row = Sale::get()->where('type','like','F')->max('number');
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
        $max = Sale::where('type','like','B')->count();
        if ($max > 0) {
            $row = Sale::get()->where('type','like','B')->max('number');
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
    public function showDetails($series,$number)
    {
        $detail = SaleDetail::where('sale_series','=',$series)
            ->where('sale_number','=', $number)->get();
        return response()-> json($detail);
    }
    public function show($series,$number)
    {
        $sale = Sale::where('series','=',$series)
                -> where('number','=', $number)
                -> where('enabled',1)
                -> first();
        return response()-> json($sale);
    }
    public function cancelSale($series,$number)
    {
        $sale = Sale::where('series',$series)
                -> where('number', $number)
                -> where('enabled',1)
                -> first();
        
        $sale->enabled = 0;
        $sale->update();
        return response()-> json($sale);
    }
}
