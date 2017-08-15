<?php

namespace Panda\Http\Controllers;

use Panda\Laboratory;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Laboratory::find($id);
        return $data;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Laboratory::find($id)->delete();
        return response()->json(['done']);
    }
}
