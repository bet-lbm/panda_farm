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

    public function create()
    {
        $medicine = new Medicine;
        return view('medicines.create');
    }
	
    public function store(Request $request) 
    {
    	$this->validate($request, [
    		'batch'  => 'required',
    		'type'  => 'required',
    		'name'  => 'required',
    		'component'  => 'required',
    		'concentration'  => 'required',
    		'expiration_date'  => 'required',
    		'production_date'  => 'required',
    		'description'  => 'required',
    		'stock'  => 'required',
    		'purchanse_price'  => 'required',
    		'sale_price'  => 'required',
    		'igv'  => 'required',
        ]);
        $create = Medicine::create($request->all());
        return response()->json($create);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'batch'  => 'required',
    		'type'  => 'required',
    		'name'  => 'required',
    		'component'  => 'required',
    		'concentration'  => 'required',
    		'expiration_date'  => 'required',
    		'production_date'  => 'required',
    		'description'  => 'required',
    		'stock'  => 'required',
    		'purchanse_price'  => 'required',
    		'sale_price'  => 'required',
    		'igv'  => 'required',
        ]);
        $edit = Medicine::find($id)->update($request->all());
        return response()->json($edit);
    }
}
