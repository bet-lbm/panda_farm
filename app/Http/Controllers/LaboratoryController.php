<?php

namespace Panda\Http\Controllers;

use Panda\Laboratory;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        return view('laboratories.index');
    }

    public function index()
    {
        $laboratories=Laboratory::latest()->paginate(10);
        $response=[
            'pagination'=>[
                'total'=>$laboratories->total(),
                'per_page'=>$laboratories->perPage(),
                'current_page'=>$laboratories->currentPage(),
                'last_page'=>$laboratories->lastPage(),
                'from'=>$laboratories->firstItem(),
                'to'=>$laboratories->lastItem(),
            ],
            'data'=>$laboratories

        ];
        return response()->json($response);
    }

    public function search(Request $request)
    {
        $queryString=$request->input('queryString');
        $laboratories=Laboratory::where('name','like','%'.$queryString.'%')->latest()->paginate(10);
        $response=[
            'pagination'=>[
                'total'=>$laboratories->total(),
                'per_page'=>$laboratories->perPage(),
                'current_page'=>$laboratories->currentPage(),
                'last_page'=>$laboratories->lastPage(),
                'from'=>$laboratories->firstItem(),
                'to'=>$laboratories->lastItem(),
            ],
            'data'=>$laboratories
        ];
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $laboratory= new Laboratory;
        return view('laboratories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'health_code' => 'required',
            'authorization' => 'required',
            'phone' => 'required',
        ]);
        $create = Laboratory::create($request->all());
        return response()->json($create);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'health_code' => 'required',
            'authorization' => 'required',
            'phone' => 'required',
        ]);
        $edit = Laboratory::find($id)->update($request->all());
        return response()->json($edit);
    }

    public function destroy($id)
    {
        Laboratory::find($id)->delete();
        return response()->json(['done']);
    }
    public function combo() {
        $laboratories = Laboratory::orderBy('name', 'asc')->get();
        return response()->json($laboratories);
    }
    public function getLaboratory($id)
    {
        $laboratory = Laboratory::find($id);
        return response()->json($laboratory['name']);
    }
}
