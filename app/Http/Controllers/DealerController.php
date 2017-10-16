<?php

namespace Panda\Http\Controllers;

use Panda\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        return view('dealers.index');
    }    
    public function index() {
		$dealers = Dealer::latest()->paginate(10);
        $response = [
            'pagination' => [
                'total' => $dealers->total(),
                'per_page' => $dealers->perPage(),
                'current_page' => $dealers->currentPage(),
                'last_page' => $dealers->lastPage(),
                'from' => $dealers->firstItem(),
                'to' => $dealers->lastItem(),
            ],
            'data' => $dealers
        ];
        return response()->json($response);
	}
    public function search(Request $request)
    {
        $queryString=$request->input('queryString');
        $dealers=Dealer::where('name','like','%'.$queryString.'%')->latest()->paginate(10);
        $response=[
            'pagination'=>[
                'total'=>$dealers->total(),
                'per_page'=>$dealers->perPage(),
                'current_page'=>$dealers->currentPage(),
                'last_page'=>$dealers->lastPage(),
                'from'=>$dealers->firstItem(),
                'to'=>$dealers->lastItem(),
            ],
            'data'=>$dealers
        ];
        return response()->json($response);
    }

	
	public function create()
    {
        $dealer = new Dealer;
        return view('dealers.create');
    }
  
    public function store(Request $request) 
    {
    	$this->validate($request, [
            'ruc' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $create = Dealer::create($request->all());
        return response()->json($create);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ruc' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $edit = Dealer::find($id)->update($request->all());
        return response()->json($edit);
    }

    public function destroy($id)
    {
        Dealer::find($id)->delete();
        return response()->json(['done']);
    }
    public function combo() {
        $dealers = Dealer::orderBy('name', 'asc')->get();
        return response()->json($dealers);
    }
    public function getDealer($id)
    {
        $dealer = Dealer::find($id);
        return response()->json($dealer['name']);
    }

}
