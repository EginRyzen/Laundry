@extends('front')

@section('content')
    <div class="container">
        <div class="card">
            <h3 class="text-center py-3">Transaksi</h3>
            <form action="{{ url('laundry/belipaket') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-2 mt-2">
                        <span class="ml-3">Add Paket</span>
                    </div>
                    <div class="col-md-7">
                        <select name="id_paket" id="" class="form-control form-select" onchange="this.form.submit()">
                            <option value="" disabled selected>---- Pilih Paket ---</option>
                            @foreach($pakets as $paket)
                            <option value="{{ $paket->id}}">{{ $paket->nama_paket }}</option>
                            @endforeach
                        </select>                    
                    </div>
                    <div class="col-md-5">
                        @if (session('pesan'))
                    <p class="alert alert-success my-3"><i class="fas fa-check-circle"></i>  {{ session('pesan') }}</p>
                    @endif
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                                @if (session()->has('cart'))
                                @foreach (session('cart') as $id => $menu)
                                <tr>
                                    <td>{{ $no++ }}.</td>
                                    <td>{{ $menu['nama_paket'] }}</td>
                                    <td class="text-lg"> <a href="{{ url('laundry/kurang/'.$menu['id']) }}" class="text-decoration-none text-warning font-weight-bold text-lg">[-] </a>
                                        {{ $menu['jumlah'] }} 
                                        <a href="{{ url('laundry/tambah/'.$menu['id']) }}" class="text-decoration-none text-success font-weight-bold text-lg">[+]</a></td>
                                    <td>{{ $menu['harga'] }}</td>
                                    <td>
                                        {{ $menu['jumlah']*$menu['harga'] }}
                                    </td>
                                    <td>
                                        <a href="{{ url('laundry/hapus/'.$menu['id']) }}" class="text-danger font-weight-bold"><i class="fa fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                    
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <form action="{{ url('laundry/transaksi') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row px-3">
                    <div class="col-md-2 mt-1">
                        <label for="">DiBayar : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <select name="dibayar" id="" class="form-control form-select">
                            <option value="belum_bayar" selected>Belum Di Bayar</option>
                            <option value="bayar">DiBayar</option>
                        </select>
                    </div>
                    <div class="col-md-2 mt-1">
                        <label for="">Member : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <select name="id_member" id="" class="form-control form-select">
                            @foreach ( $members as $member )
                            <option value="{{ $member->id }}">{{ $member->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-2 mt-1">
                        <label for="">Biaya Tambahan : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input class="form-control" type="number" name="biaya_tambahan" id="">
                    </div>
                    <div class="col-md-2 mt-1">
                        <label for="">Discount : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input class="form-control" type="number" name="diskon" id="">
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-2 mt-1">
                        <label for="">BatasWaktu : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input class="form-control" type="date" name="batas_waktu" id="">
                    </div>
                    <div class="col-md-2 mt-1">
                        <label for="" class="form-label">Keterangan</label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <textarea class="form-control form-control-user" name="keterangan" aria-label="With textarea"></textarea>
                    </div>
                </div>
                <div class="row pr-3">
                    <div class="col-md-12 mb-3">
                        <div class="mt-1">
                            <button class="float-right btn btn-success" type="submit">Transaksi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection