<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Driver\PDOConnection;
use Illuminate\Http\Request;
use App\Pesanan;
use App\Antrian;
use App\Hidangan;

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
        // foreach ($Pesanans as $Pesanan) {
        //     $Pesanan->view_Pesanan = [
        //         'href' => 'api/v1/pesanan/' . $Pesanan->id,
        //         'method' => 'GET'
        //     ];
        // }
        // $response = [
        //     'Pesanans' => $Pesanans
        // ];
        $response = $Pesanans;

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
            'kode_hidangan' => 'required',
            'nomor_meja' => 'required',
            'nama_pelanggan' => 'required',
            'kuantitas' => 'required',
            'informasi' => 'required',
        //    'user_id' => 'required',

        ]);
        $kode_hidangan = $request->input('kode_hidangan');
        $nomor_meja = $request->input('nomor_meja');
        $nama_pelanggan = $request->input('nama_pelanggan');
        $kuantitas = $request->input('kuantitas');
        $antrian = $request->input('informasi');
        //$totalAntrian = Antrian::get();
        if($kuantitas<=5) $pengali=5;
        else if($kuantitas<=10) $pengali=10;
        else $pengali=15;
        $informasi = ceil(($antrian/3))*$pengali;

    //    // $setinformasi = DB::select('Call GetInformasi(5,6,?)');
    //    // $informasi =$setinformasi;
    //     //    $results = DB::select('CALL GetInformasi(10,"aaa",100,6,5)');
    //     DB::select(DB::raw("CALL GetInformasi($hidangan_id,$nomor_meja,'$nama_pelanggan', $kuantitas,$totalAntrian,5)"));

        $Pesanan = new Pesanan([
            'kode_hidangan' => $kode_hidangan,
            'nomor_meja' => $nomor_meja,
            'nama_pelanggan' => $nama_pelanggan,
            'kuantitas' => $kuantitas,
            'informasi' => $informasi,
        ]);

        if($Pesanan->save()){
            $Pesanan->hidangans()->attach($kode_hidangan);
            $Pesanan->view_pesanan =[
                'href' => 'api/v1/pesanan/' .$Pesanan->id,
                'method' => 'GET'
            ];
            $message = [
                'msg' => 'Pesanan Created',
                'Pesanan' => $Pesanan
            ];
            return response()->json($message,201);
        }

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
       $pesanan = Pesanan::all()->where('nomor_meja', $id);
        //$pesanan = Pesanan::with('pesanans')->where('hidangan_kode_hidangan', $id)->firstOrFail();
        $pesanan->view_hidangans = [
            'href' => 'api/v1/hidangan',
            'method' => 'GET'
        ];
        $response = $pesanan;

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
    {//::with('pesanans')->where('kode_hidangan', $id)->firstOrFail()
        $pesanan = Pesanan::where('nomor_meja', $id)->firstOrFail();
        $hidangans = $pesanan->hidangans;
        $pesanan->hidangans()->detach();
        if(!$pesanan->delete()){
            foreach ($hidangans as $hidangan){
                $pesanan->hidangans()->attach($kode_hidangan);
            }
            return response()->json([
                'message' => 'Deletion Failed'
            ], 404);
        }
        $response = [
            'message' => 'Pesanan deleted',
            'create' => [
                'href' => 'api/v1/pesanan',
                'method' => 'POST',
                'params' => 'kode_hidangan, nomor_meja, nama_pelanggan, kuantitas, informasi'
            ]
        ];
        return response()->json($response, 200);
    }
}
