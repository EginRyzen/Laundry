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

    public function belipaket(Request $request)
    {
        $id = $request->id_paket;

        // dd($id);
        $paket = Paket::where('id', $id)->first();

        // dd($paket);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['jumlah']++;
        } else {
            $cart[$id] = [
                'id' => $id,
                'id_outlet' => $paket->id_outlet,
                'jenis' => $paket->jenis,
                'nama_paket' => $paket->nama_paket,
                'harga' => $paket->harga,
                'jumlah' => 1,
            ];
        }

        session()->put('cart', $cart);
        return back();
    }

    public function tambah($id)
    {
        $cart = session()->get('cart');
        $cart[$id]['jumlah']++;
        session()->put('cart', $cart);

        return back();
    }

    public function kurang($id)
    {
        $cart = session()->get('cart');
        if ($cart[$id]['jumlah'] > 1) {
            $cart[$id]['jumlah']--;
            session()->put('cart', $cart);
        } else {
            unset($cart['idd']);
            session()->put('cart', $cart);
        }
        return back();
    }

    public function hapus($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back();
    }


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

            return view('Transaksi.transaksi', compact('pakets', 'members', 'transaksi'));
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

        $number = 0;

        // $pakets = Paket::where('id', $request->id_paket)->first();
        // $pakets = Paket::where('id_outlet', $user->id_outlet)->find($request->id_paket);

        if ($data = $request->dibayar == 'bayar') {
            $data = [
                'id_outlet' => $user->id_outlet,
                'id_member' => $request->id_member,
                'id_user' => $user->id,
                'tgl' => now(),
                'batas_waktu' => $request->batas_waktu,
                'tgl_bayar' => now(),
                'biaya_tambahan' => $request->biaya_tambahan,
                'diskon' => $request->diskon,
                // 'pajak' => $request->pajak,
                // 'status' => $request->status,
                'dibayar' => $request->dibayar,

            ];
        } else if ($data = $request->dibayar == 'belum_bayar') {
            $data = [
                'id_outlet' => $user->id_outlet,
                'id_member' => $request->id_member,
                'id_user' => $user->id,
                'tgl' => now(),
                'batas_waktu' => $request->batas_waktu,
                // 'tgl_bayar' => now(),
                'biaya_tambahan' => $request->biaya_tambahan,
                'diskon' => $request->diskon,
                // 'pajak' => $request->pajak,
                // 'status' => $request->status,
                'dibayar' => $request->dibayar,

            ];
        }

        // dd($data);

        $transaksi = Transaksi::create($data);

        foreach (session('cart') as $key => $value) {
            $total = $number + $value['harga'] * $value['jumlah'] + ($request['biaya_tambahan'] - $request['diskon']);

            // dd($total);


            // dd($total);
            $bayar = [
                'keterangan' => $request->keterangan,
                'id_paket' => $value['id'],
                'id_transaksi' => $transaksi->id,
                'qty' => $total,
            ];

            // dd($bayar);

            DetailTransaksi::create($bayar);
        }

        session()->forget('cart');
        return back()->with('pesan', 'Transaksi Yang Anda Lakukan Berhasil');
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
