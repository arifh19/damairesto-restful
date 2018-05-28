<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistika;
class StatistikaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistikas = Statistika::all();
        foreach ($statistikas as $statistika) {
            $statistika->view_statistika = [
                'href' => 'api/v1/statistika/' . $statistika->operatorname,
                'method' => 'GET'
            ];
        }
        $response =  $statistikas;

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
            'table_number' => 'required',
            'date' => 'required',
            'earning' => 'required',
            'information' => 'required',
            'operatorname' => 'required',

        ]);
        $table_number = $request->input('table_number');
        $date = $request->input('date');
        $earning = $request->input('earning');
        $information = $request->input('information');
        $operatorname = $request->input('operatorname');

        $statisika = new Statistika([
            'table_number' => $table_number,
            'date' => $date,
            'earning' => $earning,
            'information' => $information,
            'operatorname' => $operatorname
        ]);

        if($statisika->save()){
            $statisika->view_statisika =[
                'href' => 'api/v1/statistika/' .$statisika->operatorname,
                'method' => 'GET'
            ];
            $message = [
                'msg' => 'Statisika Created',
                'statisika' => $statisika
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
        $statistika = Statistika::all()->where('operatorname', $id);
        $statistika->view_statistikas = [
            'href' => 'api/v1/statistika',
            'method' => 'GET'
        ];

        $response = $statistika;

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

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

