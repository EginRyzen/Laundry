@extends('front')

@section('content')
    <div class="container">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Detail Pembayaran</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <form action="{{ url('laundry/transaksidetail/create') }}" method="GET" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-2">
                            <h6 class="m-0 font-weight-bold mt-1">Data Transaksi</h6>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tglmulai" class="form-control">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" name="tglakhir" class="form-control">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Dibayar</label>
                            <select name="dibayar" class="form-control">
                                <option value="" disabled selected>---- Pilih ---</option>
                                <option value="bayar">
                                    Sudah Bayar
                                </option>
                                <option value="belum_bayar">
                                    Belum Bayar
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 mt-4 p-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ url('laundry/transaksidetail') }}" type="submit" class="btn btn-warning">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Member</th>
                                <th>Outlet</th>
                                <th>TanggalTransaksi</th>
                                <th>BatasPembayaran</th>
                                <th>TglBayar</th>
                                <th>Status</th>
                                <th>Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($transaksi as $row)
                                <tr>
                                    <td>{{ $no++ }}.</td>
                                    <td><a href="{{ url('laundry/transaksidetail/' . $row->id . '/edit') }}"
                                            class="font-weight-bold"><u>{{ $row->nama }}</u></a></td>
                                    <td>{{ $row->id_outlet }}</td>
                                    <td>{{ $row->tgl }}</td>
                                    <td>{{ $row->batas_waktu }}</td>
                                    <td>{{ $row->tgl_bayar }}</td>
                                    <td>
                                        <form action="{{ url('laundry/transaksidetail/' . $row->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <select name="status" class="form-control" onchange="this.form.submit()">
                                                <option value="baru" {{ $row->status == 'baru' ? 'selected' : '' }}>
                                                    Baru
                                                </option>
                                                <option value="proses" {{ $row->status == 'proses' ? 'selected' : '' }}>
                                                    Proses
                                                </option>
                                                <option value="selesai" {{ $row->status == 'selesai' ? 'selected' : '' }}>
                                                    Selesai
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        @if ($row->dibayar == 'bayar')
                                            <button class="btn btn-warning">Lunas</button>
                                        @else
                                            <button class="btn btn-danger">Belum</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->
@endsection
