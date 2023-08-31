<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Member;
use App\Models\Outlet;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // $tokoh = Outlet::all();

        // $pakets = ;
        // $pakets = Paket::where('id_outlet', $user->id_outlet)->get();

        $members = Member::all();

        if ($user->role == 'admin') {

            $pakets = Paket::all();

            $transaksi = Transaksi::join('members', 'transaksis.id_member', '=', 'members.id')
                // ->where('transaksis.id_outlet', $user->id_outlet)
                ->select(['transaksis.*', 'members.*'])
                ->orderBy('transaksis.created_at', 'desc') // Menentukan tabel untuk kolom created_at
                ->take(5)
                ->get();

            return view('Transaksi.transaksi', compact('pakets', 'members', 'transaksi'));
        }
        if ($user->role == 'kasir') {

            $pakets = Paket::where('id_outlet', $user->id_outlet)->get();

            $transaksi = Transaksi::join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->select(['transaksis.*', 'members.*'])
                ->orderBy('transaksis.created_at', 'desc') // Menentukan tabel untuk kolom created_at
                ->take(5)
                ->get();

            return view('Transaksi.transaksikasir', compact('pakets', 'members', 'transaksi'));
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
        $user = Auth::user();

        if ($user->role == 'admin') {
            $pakets = Paket::where('id', $request->id_paket)->first();
            // $pakets = Paket::where('id_outlet', $user->id_outlet)->find($request->id_paket);

            $data = [
                'id_outlet' => $user->id_outlet,
                'id_member' => $request->id_member,
                'id_user' => $user->id,
                'tgl' => now(),
                'batas_waktu' => $request->batas_waktu,
                'tgl_bayar' => $request->tgl_bayar,
                'biaya_tambahan' => $request->biaya_tambahan,
                'diskon' => $request->diskon,
                'pajak' => $request->pajak,
                // 'status' => $request->status,
                'dibayar' => $request->dibayar,
            ];

            // dd($pakets);

            $total = $pakets->harga + ($request['biaya_tambahan'] + $request['pajak'] - $request['diskon']);

            // dd($total);
            $transaksi = Transaksi::create($data);


            // dd($total);
            DetailTransaksi::create([
                'keterangan' => $request->keterangan,
                'id_paket' => $request->id_paket,
                'id_transaksi' => $transaksi->id,
                'qty' => $total,
            ]);

            return back()->with('pesan', 'Transaksi Yang Anda Lakukan Berhasil');
        }
        if ($user->role == 'kasir') {
            // $pakets = Paket::where('id', $request->id_paket)->first();
            $pakets = Paket::where('id_outlet', $user->id_outlet)->find($request->id_paket);

            $data = [
                'id_outlet' => $user->id_outlet,
                'id_member' => $request->id_member,
                'id_user' => $user->id,
                'tgl' => now(),
                'batas_waktu' => $request->batas_waktu,
                'tgl_bayar' => $request->tgl_bayar,
                'biaya_tambahan' => $request->biaya_tambahan,
                'diskon' => $request->diskon,
                'pajak' => $request->pajak,
                // 'status' => $request->status,
                'dibayar' => $request->dibayar,
            ];

            // dd($pakets);

            $total = $pakets->harga + ($request['biaya_tambahan'] + $request['pajak'] - $request['diskon']);

            // dd($total);
            $transaksi = Transaksi::create($data);


            // dd($total);
            DetailTransaksi::create([
                'keterangan' => $request->keterangan,
                'id_paket' => $request->id_paket,
                'id_transaksi' => $transaksi->id,
                'qty' => $total,
            ]);

            return back()->with('pesan', 'Transaksi Yang Anda Lakukan Berhasil');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->input());
        // Transaksi::where('id', $id)->update([
        //     'tgl_bayar' => now(),
        //     'status' => $request->status,
        //     'dibayar' => $request->dibayar,
        // ]);

        // $data = [
        //     'tgl_bayar' => now(),
        //     'status' => $request->status,
        //     'dibayar' => $request->dibayar,
        // ];

        // dd($id);
        // // dd($data);
        // // dd(DB::getQueryLog());
        // return back()->with('pesan', 'Update Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
