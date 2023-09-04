@extends('front')

@section('content')
<div class="container">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Outlet</h6>
            @if (session()->has('pesan'))
            <p class="alert alert-danger my-3">{{ session()->get('pesan') }}</p>
        @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Toko</th>
                            <th>Alamat</th>
                            <th>UserName</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ( $users as $user )
                        <tr>
                            <td>{{ $no++ }}.</td>
                            <td><img src="{{ asset('foto/'.$user->foto) }}" alt="" style="width: 50px;border-radius: 50%"></td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td class="text-center">
                                <a href="{{ url('laundry/editpelanggan/'.$user->id) }}" class="mr-2 text-warning" ><i class="fas fa-edit"></i></a>
                                <a href="{{ url('laundry/deletepelanggan/'.$user->id) }}"  class="ml-2 text-danger"><i class="fas fa-trash"></i></a>
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
                                            <a href="{{ url('laundry/editpelanggan/'.$user->id) }}" type="submit" class="btn btn-danger">Yakin</a>
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
</div>
<!-- /.container-fluid -->
@endsection