<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('front');
// });

Route::get('/', [FrontController::class, 'login']);
Route::post('postlogin', [AuthController::class, 'postlogin']);
Route::get('logout', [FrontController::class, 'logout']);
// Route::get('register', [FrontController::class, 'register']);


Route::group(['prefix' => 'laundry', 'middleware' => ['auth']], function () {

    //Admin
    Route::get('dasbord', [FrontController::class, 'dasbord']);
    Route::resource('transaksidetail', DetailTransaksiController::class);

    Route::resource('transaksi', TransaksiController::class);
    Route::resource('member', MemberController::class);
    Route::get('belipaket', [TransaksiController::class, 'belipaket']);
    Route::get('tambah/{id}', [TransaksiController::class, 'tambah']);
    Route::get('kurang/{id}', [TransaksiController::class, 'kurang']);
    Route::get('hapus/{id}', [TransaksiController::class, 'hapus']);

    Route::group(['middleware' => ['CekLogin:admin']], function () {
        // Register
        Route::get('registeradmin', [FrontController::class, 'registeradmin']);
        Route::post('postregisteradmin', [AuthController::class, 'postregisteradmin']);

        // Outlet
        Route::get('selectoutlet', [OutletController::class, 'index']);
        Route::post('insertoutlet', [OutletController::class, 'store']);
        Route::get('delete/{id}', [OutletController::class, 'delete']);
        Route::get('edit/{id}', [OutletController::class, 'edit']);
        Route::post('update/{id}', [OutletController::class, 'update']);

        //Paket
        Route::get('selectpaket', [PaketController::class, 'index']);
        Route::post('insertpaket', [PaketController::class, 'store']);
        Route::get('editpaket/{id}', [PaketController::class, 'edit']);
        Route::post('updatepaket/{id}', [PaketController::class, 'update']);
        Route::get('deletepaket/{id}', [PaketController::class, 'show']);

        //Pelanggan
        Route::get('selectpelanggan', [AuthController::class, 'index']);
        Route::get('editpelanggan/{id}', [AuthController::class, 'editpelanggan']);
        Route::post('updatepelanggan/{id}', [AuthController::class, 'updatepelanggan']);
        Route::get('deletepelanggan/{id}', [AuthController::class, 'deletepelanggan']);

        //Member

        // Transaksi

        // Detail
    });

    Route::group(['middleware' => ['CekLogin:kasir']], function () {
        Route::post('postregisterkasir', [AuthController::class, 'postregisteradmin']);
        Route::get('registerkasir', [FrontController::class, 'registerkasir']);

        // Route::resource('transaksikasir', TransaksiController::class);

        // Route::resource('transaksidetailkasir', DetailTransaksiController::class);
    });

    //Kasir


    //Owner
});
