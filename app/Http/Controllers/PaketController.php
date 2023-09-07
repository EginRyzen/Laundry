<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Paket;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pakets = Paket::join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
            ->select(['outlets.*', 'pakets.*'])->get();

        $tokos = Outlet::all();

        return view('Paket.select', compact('pakets', 'tokos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Paket::create([
            'id_outlet' => $request->id_outlet,
            'jenis' => $request->jenis,
            'nama_paket' => $request->nama_paket,
            'harga' => $request->harga,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Paket::where('id', '=', $id)->first();
        $data->delete();

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $pakets = Paket::where('id', $id)->first();
        // $jenis = Paket::all();
        $tokos = Outlet::all();
        return view('Paket.update', compact('pakets', 'tokos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // $data = Paket::find($id);
        // if ($data) {
        //     $data->id_outlet = $request->id_outlet;
        //     $data->jenis = $request->jenis;
        //     $data->nama_paket = $request->nama_paket;
        //     $data->harga = $request->harga;
        //     $data->save();
        //     // dd($data);
        // }
        Paket::where('id', $id)->update([
            'id_outlet' => $request->id_outlet,
            'jenis' => $request->jenis,
            'nama_paket' => $request->nama_paket,
            'harga' => $request->harga,
        ]);

        // dd($request->input());

        return redirect('laundry/selectpaket');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paket $paket)
    {
        //
    }
}
