@extends('front')

@section('content')
@section('content')
<div class="container">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data</h1>
    <button class="btn btn-primary my-3" data-toggle="modal" data-target="#outlet">Tambah Data</button>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Outlet</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>OutLet</th>
                            <th>Jenis</th>
                            <th>Nama Paket</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ( $pakets as $paket )
                        <tr>
                            <td>{{ $no++ }}.</td>
                            <td>{{ $paket->nama }}</td>
                            <td>{{ $paket->jenis }}</td>
                            <td>{{ $paket->nama_paket }}</td>
                            <td>{{ $paket->harga }}</td>
                            <td class="text-center">
                                <a href="{{ url('laundry/editpaket/'.$paket->id) }}" class="mr-2 text-warning" ><i class="fas fa-edit"></i></a>
                                <a href="" data-toggle="modal" data-target="#register" class="ml-2 text-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-danger" id="exampleModalLabel">Apakah Anda Yakin Menghapus Akun</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a href="{{ url('laundry/deletepaket/'.$paket->id) }}" type="submit" class="btn btn-danger">Yakin</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="outlet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah OutLet</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ url('laundry/insertpaket') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control form-select" name="id_outlet" id="exampleSelect" placeholder="Select Option">
                                <option value="" disabled selected>Outlet</option>
                                    @foreach ( $outlets as $toko )
                                        <option value="{{ $toko->id }}">{{ $toko->nama }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control form-select" name="jenis" id="exampleSelect" placeholder="Select Option">
                                <option value="" disabled selected>Pilih Jenis</option>
                                    <option value="kiloan">Kiloan</option>
                                    <option value="selimut">Selimut</option>
                                    <option value="kaos">Kaos</option>
                                    <option value="bed_cover">Bed Cover</option>
                                    <option value="lain">Lain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" name="nama_paket"
                              required  placeholder="Nama Paket">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control form-control-user" id="exampleInputEmail" name="harga"
                              required  placeholder="Harga">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
@endsection
@endsection