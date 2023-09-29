@extends('front')

@section('content')
    <div class="container">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Detail Pembayaran</h1>
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
                                <th>NoHP</th>
                                <th>Member</th>
                                {{-- <th>BatasPembayaran</th> --}}
                                <th>Tanggal</th>
                                <th>TglBayar</th>
                                <th>Biaya</th>
                                <th>Status</th>
                                <th>Bayar</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($transaksi as $row)
                                <tr>
                                    <td>{{ $no++ }}.</td>
                                    <td>{{ $row->telp }}</td>
                                    <td>{{ $row->nama }}</td>
                                    {{-- <td>{{ $row->batas_waktu }}</td> --}}
                                    <td>{{ $row->tgl }}</td>
                                    <td>{{ $row->tgl_bayar }}</td>
                                    <td>{{ $row->harga * $row->qty + $row->pajak + $row->biaya_tambahan - $row->diskon }}
                                    </td>
                                    <td>{{ $row->status }}</td>
                                    <td>
                                        @if ($row->dibayar == 'bayar')
                                            <button class="btn btn-warning">Lunas</button>
                                        @else
                                            <button class="btn btn-danger">Belum</button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#update{{ $row->id }}"
                                            href="{{ url('laundry/transaksidetail/' . $row->id . '/edit') }}"
                                            class="mr-2 text-warning"><i class="fas fa-edit"></i></a>
                                        <a href="{{ url('laundry/struk/' . $row->id_transaksi) }}" target="_blank"
                                            class="mr-2 text-warning"><i class="fas fa-download fa-sm"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="update{{ $row->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('laundry/transaksidetail/' . $row->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    {{-- <input type="text" value="{{ $row->id }}" name="id_transaksi"> --}}
                                                    <div class="form-group">
                                                        <select name="status" class="form-control">
                                                            <option value="baru"
                                                                {{ $row->status == 'baru' ? 'selected' : '' }}>Baru
                                                            </option>
                                                            <option value="proses"
                                                                {{ $row->status == 'proses' ? 'selected' : '' }}>Proses
                                                            </option>
                                                            <option value="selesai"
                                                                {{ $row->status == 'selesai' ? 'selected' : '' }}>Selesai
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select name="dibayar" class="form-control">
                                                            <option value="belum_bayar"
                                                                {{ $row->dibayar == 'belum_bayar' ? 'selected' : '' }}>
                                                                Belum Bayar</option>
                                                            <option value="bayar"
                                                                {{ $row->dibayar == 'bayar' ? 'selected' : '' }}>Bayar
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-dismiss="modal">Cancel</button>
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
