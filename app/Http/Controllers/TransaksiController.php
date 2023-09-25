<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Paket;
use App\Models\Member;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Models\Outlet;
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
                'jumlah' => $request->jumlah,
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
        if ($cart[$id]['jumlah']) {
            $cart[$id]['jumlah']--;
            session()->put('cart', $cart);
        } else {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back();
    }

    public function hapus($id)
    {
        $cart = session()->get('cart');
        unset($cart[$id]);
        session()->put('cart', $cart);

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
            // $outlets = Outlet::all();

            return view('Transaksi.transaksi', compact('pakets', 'members'));
        }
        if ($user->role == 'kasir') {

            $pakets = Paket::where('id_outlet', $user->id_outlet)->get();

            return view('Transaksi.transaksi', compact('pakets', 'members'));
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

        $today = Carbon::now();
        $batas = $today->addDays(4);
        $totalharga = $request->totalharga;
        $dibayar = $request->dibayar;
        $pajak = 0.11;
        $total = $request->total;
        $tambahan = $request->biaya_tambahan;
        $diskon = $request->diskon;
        $jadipajak = ($total + $tambahan + $diskon) * $pajak;
        $invoice = date('YmdHis');


        if ($dibayar >= $totalharga) {
            $data = [
                'id_outlet' => $user->id_outlet,
                'id_member' => $request->id_member,
                'id_user' => $user->id,
                'tgl' => now(),
                'batas_waktu' => now(),
                'tgl_bayar' => now(),
                'biaya_tambahan' => $tambahan,
                'diskon' => $diskon,
                'pajak' =>  $jadipajak,
                'dibayar' => 'bayar',
                'kode_invoice' => $invoice,
            ];
            // dd($data);
        } else {
            $data = [
                'id_outlet' => $user->id_outlet,
                'id_member' => $request->id_member,
                'id_user' => $user->id,
                'tgl' => now(),
                'batas_waktu' => $batas,
                'biaya_tambahan' => $tambahan,
                'diskon' => $diskon,
                'pajak' => $jadipajak,
                'dibayar' => 'belum_bayar',
                'kode_invoice' => $invoice,

            ];

            // dd($data);
        }

        $transaksis = Transaksi::create($data);

        $number = 0;

        foreach (session('cart') as $value) {
            // $harga = $value['harga'];
            // $jumlah = $value['jumlah'];
            // $subtotal = ($harga * $jumlah) + $request->biaya_tambahan - $request->diskon; // Calculate subtotal for the value
            // $number += $subtotal * $pajak;
            // $total = $number + $subtotal;
            // $hasil = round($total);

            // dd($hasil);
            $bayar = [
                'keterangan' => $request->keterangan,
                'id_paket' => $value['id'],
                'id_transaksi' => $transaksis->id,
                'qty' => $value['jumlah'],
            ];

            DetailTransaksi::create($bayar);
        }

        session()->forget('cart');

        $member = Member::where('id', $request->id_member)->first();
        $alamat = Outlet::where('id', $transaksis->id_outlet)->first();
        $transaksi = Transaksi::where('id', $transaksis->id)->first();
        $struks = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
            ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
            ->where('transaksis.id', $transaksis->id)
            ->select(['detail_transaksis.*', 'pakets.*', 'transaksis.*'])
            ->get();

        // dd($struk);

        return view('struk', compact('member', 'struks', 'alamat', 'transaksi'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */

    public function struk()
    {
        return view('struk');
    }
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
