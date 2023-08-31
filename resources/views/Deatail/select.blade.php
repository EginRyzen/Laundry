@extends('front')

@section('content')
<div class="container">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Detail Pembayaran</h1>
    {{-- <button class="btn btn-primary my-3" data-toggle="modal" data-target="#row">Tambah Data</button> --}}
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Transaksi</h6>
            @if (session()->has('pesan'))
                <p class="alert alert-danger my-3">{{ session()->get('pesan') }}</p>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Toko</th>
                            <th>Member</th>
                            <th>Batas Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Pemabayaran</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ( $transaksi as $row )
                        <tr>
                            <td>{{ $no++ }}.</td>
                            <td>{{ $row->outlet_nama }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->batas_waktu }}</td>
                            <td>{{ $row->tgl }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $row->dibayar }}</td>
                            <td class="text-center">
                                @if (Auth::user()->role == 'admin')
                                    <a href="{{ url('laundry/transaksidetail/'.$row->id.'/edit') }}"  class="mr-2 text-warning" ><i class="fas fa-edit"></i></a>
                                @endif
                                @if (Auth::user()->role == 'kasir')
                                    <a href="{{ url('laundry/transaksidetailkasir/'.$row->id.'/edit') }}"  class="mr-2 text-warning" ><i class="fas fa-edit"></i></a>
                                @endif
                                {{-- <a href="{{ url('laundry/row/'.$row->id) }}"  class="ml-2 text-danger"><i class="fas fa-trash"></i></a> --}}
                            </td>
                        </tr>
                        <div class="modal fade" id="updatetransaksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ url('laundry/transaksidetail/'.$row->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                        <select name="status" class="form-control">
                                                            <option value="{{ $row->status }}">{{ $row->status }}</option>
                                                            <option value="baru">Baru</option>
                                                            <option value="proses">Proses</option>
                                                            <option value="selesai">Selesai</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select name="dibayar" id="" class="form-control">
                                                            <option value="{{ $row->dibayar }}" selected>{{ $row->dibayar }}</option>
                                                            <option value="belum_bayar">Belum Bayar</option>
                                                            <option value="bayar">Bayar</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Yes</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection