<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Driver\PDOConnection;
use Illuminate\Http\Request;
use App\Pesanan;
use App\Antrian;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Pesanans = Pesanan::all();
        foreach ($Pesanans as $Pesanan) {
            $Pesanan->view_Pesanan = [
                'href' => 'api/v1/pesanan/' . $Pesanan->id,
                'method' => 'GET'
            ];
        }
        $response = [
            'msg' => 'List Pesanan',
            'Pesanans' => $Pesanans
        ];

        return response()->json($response,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'hidangan_id' => 'required',
            'nomor_meja' => 'required',
            'nama_pelanggan' => 'required',
            'kuantitas' => 'required',
        //    'user_id' => 'required',

        ]);
        $hidangan_id = $request->input('hidangan_id');
        $nomor_meja = $request->input('nomor_meja');
        $nama_pelanggan = $request->input('nama_pelanggan');
        $kuantitas = $request->input('kuantitas');
        $informasi = $request->input('');
        //$totalAntrian = Antrian::get();
        $totalAntrian = DB::table('antrians')->get();

       // $setinformasi = DB::select('Call GetInformasi(5,6,?)');
       // $informasi =$setinformasi;
        //    $results = DB::select('CALL GetInformasi(10,"aaa",100,6,5)');
        DB::select(DB::raw("CALL GetInformasi($hidangan_id,$nomor_meja,'$nama_pelanggan', $kuantitas,$totalAntrian,5)"));

        $Pesanan = new Pesanan([
            'hidangan_id' => $hidangan_id,
            'nomor_meja' => $nomor_meja,
            'nama_pelanggan' => $nama_pelanggan,
            'kuantitas' => $kuantitas,
            'informasi' => $informasi,
        ]);

        // if($Pesanan->save()){
        //     //$Pesanan->hidangans()->attach($hidangan_id);
        //     $Pesanan->view_pesanan =[
        //         'href' => 'api/v1/pesanan/' .$Pesanan->id,
        //         'method' => 'GET'
        //     ];
        //     $message = [
        //         'msg' => 'Pesanan Created',
        //         'Pesanan' => $Pesanan
        //     ];
        //     return response()->json($message,201);
        // }

            $message = [
                'msg' => 'Pesanan Created',
                'Pesanan' => $Pesanan
            ];
            return response()->json($message,201);
        //return response()->json($response,404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pesanan = Pesanan::all()->where('id', $id);
        $pesanan->view_hidangans = [
            'href' => 'api/v1/hidangan',
            'method' => 'GET'
        ];
        $response = [
            'message' => 'Pesanan information',
            'pesanan' => $pesanan
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
