<?php

namespace Panda\Http\Controllers;

use Panda\Presentation;
use Illuminate\Http\Request;

class PresentationController extends Controller
{
    public function index() {
        $presentations = Presentation::latest()->paginate(10);
        $response = [
            'pagination' => [
                'total' => $presentations->total(),
                'per_page' => $presentations->perPage(),
                'current_page' => $presentations->currentPage(),
                'last_page' => $presentations->lastPage(),
                'from' => $presentations->firstItem(),
                'to' => $presentations->lastItem(),
            ],
            'data' => $presentations
        ];
        return response()->json($response);
    }

    public function search(Request $request)
    {
        $queryString=$request->input('queryString');
        $presentations=Presentation::where('name','like','%'.$queryString.'%')->latest()->paginate(10);
        $response=[
            'pagination'=>[
                'total'=>$presentations->total(),
                'per_page'=>$presentations->perPage(),
                'current_page'=>$presentations->currentPage(),
                'last_page'=>$presentations->lastPage(),
                'from'=>$presentations->firstItem(),
                'to'=>$presentations->lastItem(),
            ],
            'data'=>$presentations
        ];
        return response()->json($response);
    }

    public function combo() {
        $presentations = Presentation::orderBy('name', 'asc')->get();
        return response()->json($presentations);
    }
    
    public function create()
    {
        $presentation = new Presentation;
        return view('presentations.create');
    }
  
    public function store(Request $request) 
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $create = Presentation::create($request->all());
        return response()->json($create);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $edit = Presentation::find($id)->update($request->all());
        return response()->json($edit);
    }

    public function delete($id)
    {
        Presentation::find($id)->delete();
        return response()->json(['done']);
    }
}
