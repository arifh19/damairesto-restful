<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hidangan;

class HidanganController extends Controller
{
    // public function __construct(){
    //     $this->middleware('jwt.auth');
    //     // $this->middleware('jwt.auth',
    //     // ['except' => ['index','show']]
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hidangans = Hidangan::all();
        foreach ($hidangans as $hidangan) {
            $hidangan->view_hidangan = [
                'href' => 'api/v1/hidangan/' . $hidangan->id,
                'method' => 'GET'
            ];
        }
        $response = [
            'msg' => 'List Hidangan',
            'hidangans' => $hidangans
        ];

        return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nama_hidangan' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'waktu' => 'required',
        //    'user_id' => 'required',

        ]);
        $nama_hidangan = $request->input('nama_hidangan');
        $deskripsi = $request->input('deskripsi');
        $stok = $request->input('stok');
        $harga = $request->input('harga');
        $waktu = $request->input('waktu');
        //$user_id = $request->input('user_id');

        $hidangan = new Hidangan([
            'nama_hidangan' => $nama_hidangan,
            'deskripsi' => $deskripsi,
            'stok' => $stok,
            'harga' => $harga,
            'waktu' => $waktu
        ]);

        if($hidangan->save()){
           // $hidangan->users()->attach($user_id);
            $hidangan->view_hidangan =[
                'href' => 'api/v1/hidangan/' .$hidangan->id,
                'method' => 'GET'
            ];
            $message = [
                'msg' => 'Hidangan Created',
                'hidangan' => $hidangan
            ];
            return response()->json($message,201);
        }

        $response = [
            'msg' => 'Error during creation',
        ];
        return response()->json($response,404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hidangan = Hidangan::with('pesanans')->where('id', $id)->firstOrFail();
        $hidangan->view_hidangans = [
            'href' => 'api/v1/hidangan',
            'method' => 'GET'
        ];
        $response = [
            'message' => 'Hidangan information',
            'hidangan' => $hidangan
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nama_hidangan' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'waktu' => 'required',
            //'user_id' => 'required',
        ]);
        $nama_hidangan = $request->input('nama_hidangan');
        $deskripsi = $request->input('deskripsi');
        $stok = $request->input('stok');
        $harga = $request->input('harga');
        $waktu = $request->input('waktu');
        //$user_id = $request->input('user_id');

        $hidangan = Hidangan::with('pesanans')->findOrFail($id);

        // if(!$hidangan->pesanans()->where('users.id', $user_id)->first()){
        //     return response()->json(['msg'=>'user not registered for hidangan, update not successful'],401);
        // };

        $hidangan->nama_hidangan = $nama_hidangan;
        $hidangan->deskripsi = $deskripsi;
        $hidangan->stok = $stok;
        $hidangan->harga = $harga;
        $hidangan->waktu = $waktu;

        if(!$hidangan->update()){
            return response()->json([
                'msg' => 'Error during update'
            ], 404);
        }
        $hidangan->view_hidangan =[
            'href' => 'api/v1/hidangan' . $hidangan->id,
            'method' => 'GET'
        ];

        $response = [
            'msg' => 'Hidangan Updated',
            'hidangan' => $hidangan
        ];

        return response()->json($response,200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hidangan = Hidangan::findOrFail($id);
        $pesanans = $hidangan->pesanans;
        $hidangan->pesanans()->detach();
        if(!$hidangan->delete()){
            foreach ($pesanans as $pesanan){
                $hidangan->pesanans()->attach($pesanan_id);
            }
            return response()->json([
                'message' => 'Deletion Failed'
            ], 404);
        }
        $response = [
            'message' => 'Hidangan deleted',
            'create' => [
                'href' => 'api/v1/hidangan',
                'method' => 'POST',
                'params' => 'nama_hidangan, deskripsi, stok, harga, waktu'
            ]
        ];
        return response()->json($response, 200);
    }
}
