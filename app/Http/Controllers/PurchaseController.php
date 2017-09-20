<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Panda\Medicine;
use Panda\Purchase;
use Panda\PurchaseDetail;

class PurchaseController extends Controller
{
    public function index() {
		$purchases = Purchase::orderBy('code', 'des')->paginate(5);
        $response = [
            'pagination' => [
                'total' => $purchases->total(),
                'per_page' => $purchases->perPage(),
                'current_page' => $purchases->currentPage(),
                'last_page' => $purchases->lastPage(),
                'from' => $purchases->firstItem(),
                'to' => $purchases->lastItem(),
            ],
            'data' => $purchases  ];
        return response()->json($response);
	}
    public function search(Request $request)
    {
        $queryString=$request->input('queryString');
        $purchases=Purchase::where('code','like','%'.$queryString.'%')->latest()->paginate(5);
        $response=[
            'pagination'=>[
                'total'=>$purchases->total(),
                'per_page'=>$purchases->perPage(),
                'current_page'=>$purchases->currentPage(),
                'last_page'=>$purchases->lastPage(),
                'from'=>$purchases->firstItem(),
                'to'=>$purchases->lastItem(),
            ],
            'data'=>$purchases
        ];
        return response()->json($response);
    }
    public function report(Request $request){
        $date1=$request->input('date1');
        $date2=$request->input('date2');
        $purchases=Purchase::whereBetween('date', array($date1,$date2))->latest()->paginate(5);
        $response=[
            'pagination'=>[
                'total'=>$purchases->total(),
                'per_page'=>$purchases->perPage(),
                'current_page'=>$purchases->currentPage(),
                'last_page'=>$purchases->lastPage(),
                'from'=>$purchases->firstItem(),
                'to'=>$purchases->lastItem(),
            ],
            'data'=>$purchases
        ];
        return response()->json($response);   
    }

    public function create()
    {
        return view('purchases.create');
    }
	
    public function store(Request $request) 
    {
    	$this->validate($request, [
    		'code' => 'required',
    		'dealer_id' => 'required',
    		'laboratory_id' => 'required',
    		'date' => 'required',
    		'total_price' => 'required',
        ]);
        $create = Purchase::create($request->all());
        return response()->json($create);
    }

    public function code(){
        $max = Purchase::count();
        if ($max > 0) {
            $row = explode('-',Purchase::max('code'), 2);
            $cod = $row[1];
            $sig = $cod+1;
            $Strsig = (string)$sig;
            $formato = "C-".str_pad($Strsig, "5", "0", STR_PAD_LEFT);
            
        } 
        else {
            $sig = 1;
            $Strsig = (string)$sig;
            $formato = "C-".str_pad($Strsig,"5","0",STR_PAD_LEFT);
        }
        
        return $formato;
    }

    public function showDetails($id)
    {
        $detail = PurchaseDetail::where('purchase_id', $id)->get();
        return response()-> json($detail);
    }

}
