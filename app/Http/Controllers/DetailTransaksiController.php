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
        $user = Auth::user();

        $pakets = Paket::where('id_outlet', $user->id_outlet)->get();

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

            $transaksi = Transaksi::join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->orderBy('transaksis.dibayar', 'DESC')
                ->select(['transaksis.*', 'members.nama'])
                ->get();

            return view('Deatail.select', compact('transaksi'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        $pakets = Paket::where('id_outlet', $user->id_outlet)->get();

        if ($user->role == 'admin') {
            $tglmulai = $request->tglmulai;
            $tglakhir = $request->tglakhir;

            $transaksi = Transaksi::join('members', 'transaksis.id_member', '=', 'members.id')
                // ->where('transaksis.id_outlet', $user->id_outlet)
                ->whereBetween('transaksis.tgl', [$tglmulai, $tglakhir])
                ->select(['transaksis.*', 'members.nama'])
                ->get();

            return view('Deatail.select', compact('transaksi'));
        }
        if ($user->role == 'kasir') {

            $tglmulai = $request->tglmulai;
            $tglakhir = $request->tglakhir;
            $bayar = $request->dibayar;

            if ($tglakhir == null && $tglmulai == null && $bayar == null) {
                return redirect('laundry/transaksidetail');
            }

            $transaksi = Transaksi::join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->where(function ($filter) use ($tglmulai, $tglakhir, $bayar,) {
                    if (empty($bayar)) {
                        $filter->whereBetween('transaksis.tgl', [$tglmulai, $tglakhir])
                            ->orWhere('transaksis.tgl', $tglmulai);
                    } elseif ($bayar) {
                        $filter->orWhere('transaksis.dibayar', $bayar);
                        if ($tglmulai && $tglakhir) {
                            $filter->whereBetween('transaksis.tgl', [$tglmulai, $tglakhir])
                                ->where('transaksis.dibayar', $bayar);
                        } elseif ($tglmulai || $tglakhir) {
                            $filter->where('transaksis.tgl', $tglmulai);
                            $filter->orWhere('transaksis.tgl', $tglakhir);
                            $filter->where('transaksis.dibayar', $bayar);
                        }
                    }
                })
                ->orderBy('transaksis.dibayar', 'DESC')
                ->select(['transaksis.*', 'members.nama'])
                ->get();

            return view('Deatail.select', compact('transaksi'));
        }
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
    public function show($id)
    {
        $auth = Auth::user();
        $transaksi = Transaksi::where('id', $id)->first();

        $alamat = Outlet::where('id', $auth->id_outlet)->first();

        $member = Member::where('id', $transaksi->id_member)->first();

        $struks = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
            ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
            ->where('transaksis.id', $id)
            ->select(['detail_transaksis.*', 'pakets.*', 'transaksis.*'])
            ->get();

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
        $data = Transaksi::join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.id_transaksi')
            ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
            ->join('members', 'transaksis.id_member', '=', 'members.id')
            ->where('transaksis.id', $id)
            ->select(['transaksis.*', 'members.*', 'detail_transaksis.*', 'pakets.*'])
            ->get();
        return view('Deatail.detail', compact('data'));
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

        $data = [
            'status' => $request->status,
        ];

        Transaksi::where('id', $id)->update($data);

        Alert::info('Warning Title', 'Warning Message');


        alert()->info('Trasnsaksi', 'Berhasil Untuk Di Update');
        return redirect('laundry/transaksidetail');
    }

    public function updatebayar(Request $request, $id)
    {
        $total = $request->total;
        $bayar = $request->bayar;

        if ($bayar > $total) {
            $data = [
                'dibayar' => 'bayar',
                'tgl_bayar' => now()
            ];

            Transaksi::where('id', $id)->update($data);
        }

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
