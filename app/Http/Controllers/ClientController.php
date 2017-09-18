<?php

namespace Panda\Http\Controllers;

use Panda\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $clients=Client::latest()->paginate(10);
        $response=[
            'pagination'=>[
                'total'=>$clients->total(),
                'per_page'=>$clients->perPage(),
                'current_page'=>$clients->currentPage(),
                'last_page'=>$clients->lastPage(),
                'from'=>$clients->firstItem(),
                'to'=>$clients->lastItem(),
            ],
            'data'=>$clients
        ];
        return response()->json($response);
    }
    public function search(Request $request)
    {
        $queryString=$request->input('queryString');
        $clients=Client::where('name','like','%'.$queryString.'%')->latest()->paginate(10);
        $response=[
            'pagination'=>[
                'total'=>$clients->total(),
                'per_page'=>$clients->perPage(),
                'current_page'=>$clients->currentPage(),
                'last_page'=>$clients->lastPage(),
                'from'=>$clients->firstItem(),
                'to'=>$clients->lastItem(),
            ],
            'data'=>$clients
        ];
        return response()->json($response);
    }
    public function searchDNI(Request $request)
    {
        $queryString=$request->input('queryString');
        $clients=Client::where('dni','like','%'.$queryString.'%')->latest()->paginate(3);
        $response=[
            'pagination'=>[
                'total'=>$clients->total(),
                'per_page'=>$clients->perPage(),
                'current_page'=>$clients->currentPage(),
                'last_page'=>$clients->lastPage(),
                'from'=>$clients->firstItem(),
                'to'=>$clients->lastItem(),
            ],
            'data'=>$clients
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
        $client= new Client;
        return view('clients.create');
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
            'dni' => 'required',
            'name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $create = Client::create($request->all());
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
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'dni' => 'required',
            'name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $edit = Client::find($id)->update($request->all());
        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::find($id)->delete();
        return response()->json(['done']);
    }
}
