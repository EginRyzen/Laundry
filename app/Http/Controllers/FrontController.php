<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Paket;
use App\Models\Member;
use App\Models\Outlet;
use Barryvdh\DomPDF\PDF;
use App\Models\DetailTransaksi;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
// use PDF;

class FrontController extends Controller
{
    public function login()
    {
        return view('Login.login');
    }

    public function register()
    {
        return view('Login.register');
    }

    public function dasbord()
    {
        $user = Auth::user();

        // $toko = Outlet::all();

        // $harga = DetailTransaksi::all()->sum('qty');

        // $auth = User::all();
        if ($user->role == 'admin') {
            $users = User::count();
            $member = Member::count();
            $outlet = Outlet::count();

            $harga = DetailTransaksi::all()->sum('qty');

            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();

            return view('dasbord', compact('generates', 'users', 'harga', 'member', 'outlet'));
        }
        if ($user->role == 'kasir') {
            $users = User::where('id_outlet', $user->id_outlet)->count();
            $member = Member::count();
            $outlet = Outlet::where('id', $user->id_outlet)->count();

            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();

            $harga = $generates->sum('qty');

            return view('dasbord', compact('generates', 'users', 'harga', 'member', 'outlet'));
        }
        if ($user->role == 'owner') {
            $users = User::where('id_outlet', $user->id_outlet)->count();
            $member = Member::count();
            $outlet = Outlet::where('id', $user->id_outlet)->count();

            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();

            $harga = $generates->sum('qty');

            return view('dasbord', compact('generates', 'users', 'harga', 'member', 'outlet'));
        }
    }


    public function logout()
    {
        session()->flush();
        Auth::logout();

        return redirect('/');
    }

    public function registeradmin()
    {
        $data = Outlet::all();

        return view('Register.registeradmin', compact('data'));
    }

    public function registerkasir()
    {
        $data = Outlet::all();

        return view('Register.registerkasir', compact('data'));
    }

    public function generatepdf()
    {
        $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
            ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
            ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
            ->join('members', 'transaksis.id_member', '=', 'members.id')
            ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
            // ->whereNull('detail_transaksis.deleted_at')
            ->get();
        return view('printpdf', compact('generates'));
    }

    public function downloadpdf()
    {
        $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
            ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
            ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
            ->join('members', 'transaksis.id_member', '=', 'members.id')
            ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
            // ->whereNull('detail_transaksis.deleted_at')
            ->get();

        // $pdf = app('dompdf');
        // $pdf = app('dompdf.wrapper')->loadView('printpdf', compact('generates'));
        $pdf = FacadePdf::loadView('printpdf', compact('generates'))->setOption(['defaultFont' => 'sans-serif']);;


        return $pdf->download('laporan.pdf');
    }
}
