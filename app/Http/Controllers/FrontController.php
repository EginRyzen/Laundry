<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Paket;
use App\Models\Member;
use App\Models\Outlet;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailTransaksi;
// use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
// use PDF;

class FrontController extends Controller
{
    public function login()
    {
        if (Auth::user()) {
            return redirect('laundry/dasbord')->with('pesan', 'Anda Masih Login,Silahkan LogOut Terlebih Dahulu!!!!');
        }

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
        $user = Auth::user();

        if ($user->role == 'admin') {
            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();
            return view('printpdf', compact('generates'));
        }
        if ($user->role == 'kasir') {
            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();
            return view('printpdf', compact('generates'));
        }
    }

    public function downloadpdf()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();

            $pdf = Pdf::loadView('printpdf', compact('generates'));

            return $pdf->download('laporan.pdf');
        }
        if ($user->role == 'kasir') {
            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();

            $pdf = Pdf::loadView('printpdf', compact('generates'));

            return $pdf->download('laporan.pdf');
        }
    }
}
