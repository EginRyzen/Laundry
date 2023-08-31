@extends('front')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="mb-3">Transaksi Laundry</h3>
                @if (session('pesan'))
                    <span class="alert alert-success my-3"><i class="fas fa-check-circle"></i>  {{ Session('pesan') }}</span>
                @endif
                <form class="mt-3" action="{{ url('laundry/transaksi') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="">Nama Paket</label>
                            <select name="id_paket" id="" class="form-control form-select">
                                @foreach ( $pakets as $paket )
                                        <option value="{{ $paket->id }}">{{ $paket->nama_paket }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="">Member</label>
                            <select name="id_member" id="" class="form-control form-select">
                                @foreach ( $members as $member )
                                    <option value="{{ $member->id }}">{{ $member->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="">Batas Waktu</label>
                            <input type="date" class="form-control" name="batas_waktu" id="">
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="">Tanggal Bayar</label>
                            <input type="date" class="form-control" name="tgl_bayar" id="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="">Biaya Tambahan</label>
                            <input type="number" class="form-control" name="biaya_tambahan" id="">
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="">Diskon</label>
                            <input type="number" class="form-control" name="diskon" id="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="">Pajak</label>
                            <input type="text" class="form-control" name="pajak">
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="">DiBayar</label>
                            <select name="dibayar" id="" class="form-control form-select">
                                <option value="belum_bayar" selected>Belum Di Bayar</option>
                                <option value="bayar">DiBayar</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Keterangan</label>
                        <textarea class="form-control form-control-user" name="keterangan" aria-label="With textarea"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Transaksi</button>
                </form>
            </div>
            <div class="col-md-6">
                <h3>Transaksi Terbaru</h3>
                <table class="table table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Member</th>
                        <th>Tanggal</th>
                        <th>Di Bayar</th>
                    </thead>
                    @php
                        $no=1;
                    @endphp
                    <tbody>
                        @foreach ( $transaksi as $row )
                            <tr>
                                <td>{{ $no++ }}.</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->tgl }}</td>
                                <td>{{ $row->dibayar }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection