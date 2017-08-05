<?php

namespace App\Http\Controllers;

use App\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{
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

        return $response;
	}
	
	public function create()
   	{
   		$dealer = new Dealer;
      	return view('dealers.create');
   	}
   	public function store(Request $request) {
		$data = new Dealer ();
		$data->ruc = $request->ruc;
		$data->name = $request->name;
		$data->address = $request->address;
		$data->phone = $request->phone;
		$data->save ();
		return $data;
	}
	public function edit(Dealer $dealer)
  {
      return $dealer;
  }
	public function update($id)
	{
		  $edit = Dealer::findOrFail($id)->update();
      return $edit;
	}
	public function delete($id) {
		$data = Dealer::destroy($id);
	}
}
