@extends('front')

@section('content')
    <div class="container">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Data</h1>
        <button class="btn btn-primary my-3" data-toggle="modal" data-target="#member">Tambah Data</button>
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
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telp</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $no++ }}.</td>
                                    <td>{{ $member->nama }}</td>
                                    <td>{{ $member->alamat }}</td>
                                    <td>{{ $member->telp }}</td>
                                    <td>{{ $member->jenis_kelamin }}</td>
                                    <td class="text-center d-flex">
                                        <a href="" data-toggle="modal" data-target="#update"
                                            class="mr-2 text-warning"><i class="fas fa-edit"></i></a>
                                        <a href="{{ url('laundry/member/' . $member->id) }}" onclick="return hapus()"
                                            class="ml-2 text-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="update" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update Member</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('laundry/member/' . $member->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="exampleInputEmail" value="{{ $member->nama }}"
                                                            name="nama" required placeholder="Name OutLet">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="exampleInputEmail" value="{{ $member->alamat }}"
                                                            name="alamat" required placeholder="Address">
                                                    </div>
                                                    <div class="mb-3 form-check">
                                                        <div class="row">
                                                            <div class="col-1">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="jenis_kelamin" value="L">
                                                                <label class="form-check-label">L</label>
                                                            </div>
                                                            <div class="col-1">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="jenis_kelamin" value="P">
                                                                <label class="form-check-label">P</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control form-control-user"
                                                            id="exampleInputEmail" value="{{ $member->telp }}"
                                                            name="telp" required placeholder="Telephone">
                                                    </div>
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
        <div class="modal fade" id="member" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah OutLet</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('laundry/member') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                                    name="nama" required placeholder="Name OutLet">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                                    name="alamat" required placeholder="Address">
                            </div>
                            <div class="mb-3 form-check">
                                <div class="row">
                                    <div class="col-1">
                                        <input type="checkbox" class="form-check-input" name="jenis_kelamin"
                                            value="L">
                                        <label class="form-check-label">L</label>
                                    </div>
                                    <div class="col-1">
                                        <input type="checkbox" class="form-check-input" name="jenis_kelamin"
                                            value="P">
                                        <label class="form-check-label">P</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="exampleInputEmail"
                                    name="telp" required placeholder="Telephone">
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

    <script>
        function hapus() {
            var konfirmasi = confirm("Apakah Anda yakin ingin menghapus Member ini?");
            if (konfirmasi === true) {
                alert('Member Telah Terhapus');
            } else {
                alert('Batal Untuk Di Terhapus');
                return false;
            }
        }
    </script>
    <!-- /.container-fluid -->
@endsection
