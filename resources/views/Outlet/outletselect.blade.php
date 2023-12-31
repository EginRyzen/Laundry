@extends('front')

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
                                <th>Name</th>
                                <th>Alamat</th>
                                <th>Telp</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($tokos as $toko)
                                <tr>
                                    <td>{{ $no++ }}.</td>
                                    <td>{{ $toko->nama }}</td>
                                    <td>{{ $toko->alamat }}</td>
                                    <td>{{ $toko->telp }}</td>
                                    <td class="text-center">
                                        <a href="" data-toggle="modal" data-target="#update{{ $toko->id }}"
                                            class="mr-2 text-warning"><i class="fas fa-edit"></i></a>
                                        <a href="{{ url('laundry/delete/' . $toko->id) }}" class="ml-2 text-danger"
                                            data-confirm-delete="true"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>

                                {{-- ModalUpadte --}}
                                <div class="modal fade" id="update{{ $toko->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-muted" id="exampleModalLabel">Update Toko</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('laundry/update/' . $toko->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    {{-- <input type="text" value="{{ $toko->id }}" name="id_transaksi"> --}}
                                                    <div class="form-group mb-3">
                                                        <label for="" class="form-label">Nama</label>
                                                        <input type="text" class="form-control form-control-user"
                                                            id="exampleInputEmail" value="{{ $toko->nama }}"
                                                            name="nama" placeholder="Name OutLet">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="" class="form-label">ALamat</label>
                                                        <input type="text" class="form-control form-control-user"
                                                            id="exampleInputEmail" value="{{ $toko->alamat }}"
                                                            name="alamat" placeholder="Name OutLet">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="" class="form-label">Telpon</label>
                                                        <input type="number" class="form-control form-control-user"
                                                            id="exampleInputEmail" value="{{ $toko->telp }}"
                                                            name="telp" placeholder="Name OutLet">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Yes</button>
                                                    </div>
                                            </form>
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
                    <form action="{{ url('laundry/insertoutlet') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                                    name="nama" required placeholder="Name OutLet">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control form-control-user" name="alamat" placeholder="Alamat"></textarea>
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
    <!-- /.container-fluid -->
    {{-- <script>
        function hapus() {
            var konfirmasi = confirm("Apakah Anda yakin ingin menghapus Outlet ini?");
            if (konfirmasi === true) {
                alert("Telah Terhapus");
            } else {
                alert("Batal Untuk Di Hapus");
                return false;
            }
        }
    </script> --}}
@endsection
