<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Models\Paket;
use Illuminate\Support\Facades\Auth;

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

        // $harga = DetailTransaksi::all()->sum('qty');

        // $auth = User::all();
        if ($user->role == 'admin') {
            $users = User::count();

            $harga = DetailTransaksi::all()->sum('qty');

            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();

            return view('dasbord', compact('generates', 'users', 'harga'));
        }
        if ($user->role == 'kasir') {
            $users = User::count();

            $harga = DetailTransaksi::all()->sum('qty');

            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();

            return view('dasbord', compact('generates', 'users', 'harga'));
        }
        if ($user->role == 'owner') {
            $user = User::count();

            $generates = DetailTransaksi::join('transaksis', 'detail_transaksis.id_transaksi', '=', 'transaksis.id')
                ->join('pakets', 'detail_transaksis.id_paket', '=', 'pakets.id')
                ->join('outlets', 'pakets.id_outlet', '=', 'outlets.id')
                ->join('members', 'transaksis.id_member', '=', 'members.id')
                ->where('transaksis.id_outlet', $user->id_outlet)
                ->select('detail_transaksis.*', 'transaksis.*', 'pakets.*', 'outlets.*', 'members.nama as member')
                // ->whereNull('detail_transaksis.deleted_at')
                ->get();

            return view('dasbord', compact('generates', 'user'));
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
}
