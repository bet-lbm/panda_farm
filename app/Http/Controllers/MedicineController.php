<?php

namespace Panda\Http\Controllers;

use Illuminate\Http\Request;
use Panda\Medicine;

class MedicineController extends Controller
{
	public function index() {
		$medicines = Medicine::latest()->paginate(10);
        $response = [
            'pagination' => [
                'total' => $medicines->total(),
                'per_page' => $medicines->perPage(),
                'current_page' => $medicines->currentPage(),
                'last_page' => $medicines->lastPage(),
                'from' => $medicines->firstItem(),
                'to' => $medicines->lastItem(),
            ],
            'data' => $medicines  ];
        return response()->json($response);
	}

    public function search(Request $request)
    {
        $queryString=$request->input('queryString');
        $medicines=Medicine::where('name','like','%'.$queryString.'%')->latest()->paginate(10);
        $response=[
            'pagination'=>[
                'total'=>$medicines->total(),
                'per_page'=>$medicines->perPage(),
                'current_page'=>$medicines->currentPage(),
                'last_page'=>$medicines->lastPage(),
                'from'=>$medicines->firstItem(),
                'to'=>$medicines->lastItem(),
            ],
            'data'=>$medicines
        ];
        return response()->json($response);
    }

    public function create()
    {
        return view('medicines.create');
    }
	
    public function store(Request $request) 
    {
    	$this->validate($request, [
            'batch'  => 'required',
    		'name'  => 'required',
    		'description'  => 'required',
            'presentation_id' => 'required',
            'type'  => 'required',
            'component'  => 'required',
            'concentration'  => 'required',
            'stock'  => 'required',
            'purchase_price'  => 'required',
            'sale_price'  => 'required',
            'igv'  => 'required',
            'expiration_date'  => 'required',
            'production_date'  => 'required',
        ]);
        $create = Medicine::create($request->all());
        return response()->json($create);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'batch'  => 'required',
            'name'  => 'required',
            'description'  => 'required',
            'presentation_id' => 'required',
            'type'  => 'required',
            'component'  => 'required',
            'concentration'  => 'required',
            'stock'  => 'required',
            'purchase_price'  => 'required',
            'sale_price'  => 'required',
            'igv'  => 'required',
            'production_date'  => 'required',
            'expiration_date'  => 'required',
        ]);
        $edit = Medicine::find($id)->update($request->all());
        return response()->json($edit);
    }

    public function destroy($id)
    {
        Medicine::find($id)->delete();
        return response()->json(['done']);
    }
    public function combo() {
        $medicines = Medicine::orderBy('name', 'asc')->get();
        return response()->json($medicines);
    }
}
