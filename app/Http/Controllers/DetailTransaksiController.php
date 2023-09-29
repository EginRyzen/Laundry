<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Member;
use App\Models\Outlet;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DetailTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (!Auth::check()) {
        //     redirect('/');
        // }

        $user = Auth::user();

        // $tokoh = Outlet::where('id', $user->id_outlet);

        $pakets = Paket::where('id_outlet', $user->id_outlet)->get();

        // $members = Member::all();

        if ($user->role == 'admin') {
            $transaksi = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('outlets', 'transaksis.id_outlet', '=', 'outlets.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                // ->where('transaksis.id_outlet', $user->id_outlet)
                ->select(['transaksis.*', 'members.nama', 'outlets.nama as outlet_nama', 'detail_transaksis.*', 'pakets.*'])
                ->get();

            return view('Deatail.select', compact('transaksi'));
        }
        if ($user->role == 'kasir') {

            $transaksi = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('outlets', 'transaksis.id_outlet', '=', 'outlets.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->orderBy('transaksis.dibayar', 'DESC')
                ->select(['transaksis.*', 'members.nama', 'members.telp', 'outlets.nama as outlet_nama', 'detail_transaksis.*', 'pakets.*'])
                ->get();

            return view('Deatail.select', compact('transaksi'));
        }
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
    public function show($id_transaksi)
    {
        $auth = Auth::user();
        $transaksi = Transaksi::where('id', $id_transaksi)->first();

        $alamat = Outlet::where('id', $auth->id_outlet)->first();

        $member = Member::where('id', $transaksi->id_member)->first();

        // dd($member);

        $struks = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
            ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
            ->where('transaksis.id', $id_transaksi)
            ->select(['detail_transaksis.*', 'pakets.*', 'transaksis.*'])
            ->get();

        // dd($struks);

        return view('struk', compact('member', 'struks', 'alamat', 'transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailTransaksi  $detailTransaksi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Transaksi::where('id', '=', $id)->first();

        return view('Deatail.update', compact('data'));
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

        if ($request->dibayar == 'belum_bayar') {
            Transaksi::where('id', $id)->update([
                'tgl_bayar' => null,
                'status' => $request->status,
                'dibayar' => $request->dibayar,
            ]);
        }
        if ($request->dibayar == 'bayar') {
            Transaksi::where('id', $id)->update([
                'tgl_bayar' => now(),
                'status' => $request->status,
                'dibayar' => $request->dibayar,
            ]);
        }
        Alert::info('Warning Title', 'Warning Message');


        alert()->info('Trasnsaksi', 'Berhasil Untuk Di Update');
        return redirect('laundry/transaksidetail');
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
