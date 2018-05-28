<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pesanan;
use App\Hidangan;
use JWTAuth;

class PesananPelangganController extends Controller
{
    // public function __construct(){
    //     $this->middleware('jwt.auth');
    // }
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
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
        $this->validate($request, [
            'hidangan_kode_hidangan' => 'required',
            'pesanan_id' => 'required',
        ]);

        $pesanan_id = $request->input('pesanan_id');
        $hidangan_kode_hidangan = $request->input('hidangan_kode_hidangan');

        $pesanan = Pesanan::findOrFail($pesanan_id);
        $hidangan = Hidangan::findOrFail($hidangan_kode_hidangan);

        $message = [
            'msg' => 'Anda sudah memesan hidangan ini',
            'user' => $user,
            'hidangan' => $hidangan,
            'unregister' => [
                'href' => 'api/v1/pesanan/' . $hidangan->hidangan_kode_hidangan,
                'method' => 'DELETE',
            ]
        ];

        if($pesanan->hidangans()->where('hidangans.kode_hidangan',$hidangan->hidangan_kode_hidangan)->first()){
            return response()->json($message, 404);
        };

        $hidangan->pesanans()->attach($pesanan);

        $response = [
            'msg' => 'Terima kasih telah memesan',
            'pesanan' => $pesanan,
            'hidangan' => $hidangan,
            'unregister' => [
                'href' => 'api/v1/pesanan/' . $hidangan->kode_hidangan,
                'method' => 'DELETE',
            ]
        ];
        return response()->json($response,201);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->hidangans()->detach();

        $response = [
            'msg' => 'Batal memesan',
            'hidangan' => $hidangan,
            'user' => 'tbd',
            'unregister' => [
                'href' => 'api/v1/pesanan',
                'method' => 'POST',
                'param' => 'pesanan_id', 'hidangan_id'
            ]
        ];
        return response()->json($response,200);
    }
}


