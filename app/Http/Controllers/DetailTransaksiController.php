<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Member;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;

class DetailTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // $tokoh = Outlet::where('id', $user->id_outlet);

        $pakets = Paket::where('id_outlet', $user->id_outlet)->get();

        // $members = Member::all();

        if ($user->role == 'admin') {
            $transaksi = Transaksi::join('members', 'transaksis.id_member', '=', 'members.id')
                ->join('outlets', 'transaksis.id_outlet', '=', 'outlets.id')
                // ->where('transaksis.id_outlet', $user->id_outlet)
                ->select(['transaksis.*', 'members.nama', 'outlets.nama as outlet_nama'])
                ->get();

            return view('Deatail.select', compact('transaksi'));
        }

        if ($user->role == 'kasir') {

            $transaksi = Transaksi::join('members', 'transaksis.id_member', '=', 'members.id')
                ->join('outlets', 'transaksis.id_outlet', '=', 'outlets.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->select(['transaksis.*', 'members.nama', 'outlets.nama as outlet_nama'])
                ->get();

            return view('Deatail.select', compact('transaksi'));
        }
    }

    public function generate()
    {
        // $user = Auth::user();

        $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
            ->join('pakets', 'detail_transaksis.id_peket', '=', 'pakets.id')
            ->select(['detail_transaksis.*', 'transaksis.*', 'pakets.*'])
            ->get();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailTransaksi  $detailTransaksi
     * @return \Illuminate\Http\Response
     */
    public function show(DetailTransaksi $detailTransaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailTransaksi  $detailTransaksi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $data = Transaksi::where('id', '=', $id)->first();

            return view('Deatail.update', compact('data'));
        }
        if ($user->role == 'kasir') {
            $data = Transaksi::where('id', '=', $id)->first();

            return view('Deatail.updatekasir', compact('data'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailTransaksi  $detailTransaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = Auth::user();

        if ($user->role == 'admin') {
            Transaksi::where('id', $id)->update([
                'tgl_bayar' => now(),
                'status' => $request->status,
                'dibayar' => $request->dibayar,
            ]);

            return redirect('laundry/transaksidetail')->with('pesan', 'Update Berhasil');
        }
        if ($user->role == 'kasir') {
            Transaksi::where('id', $id)->update([
                'tgl_bayar' => now(),
                'status' => $request->status,
                'dibayar' => $request->dibayar,
            ]);

            return redirect('laundry/transaksidetailkasir')->with('pesan', 'Update Berhasil');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailTransaksi  $detailTransaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailTransaksi $detailTransaksi)
    {
        //
    }
}
