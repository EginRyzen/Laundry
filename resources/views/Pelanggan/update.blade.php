@extends('front')

@section('content')
    <div class="container">
        <h3>Update Data</h3>
        <div class="row">
            <div class="col-5">
                <form action="{{ url('laundry/updatepelanggan/'.$users->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('PUT') --}}
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Toko</label>
                        <select class="form-control form-select" name="id_outlet" id="exampleSelect" placeholder="Select Option">
                            @foreach ($tokos as $toko )
                            <option @if($toko->id == $users->id_outlet) selected @endif value="{{ $toko->id }}">
                                {{ $toko->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                            <label for="" class="form-label">Nama</label>
                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" value="{{ $users->nama }}" name="nama" 
                         placeholder="Name OutLet">
                    </div>
                    <div class="form-group mb-3">
                            <label for="" class="form-label">UserName</label>
                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" value="{{ $users->username }}" name="username" 
                         placeholder="Name OutLet">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Role</label>
                        <select class="form-control form-select" name="role" id="exampleSelect" placeholder="Select Option">
                                <option value="{{ $users->role }}" selected>{{ $users->role }}</option>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                                <option value="owner">Owner</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" value="{{ $users->email }}" name="email" 
                         placeholder="Name OutLet">
                    </div>
                    <div class="form-group mb-3">
                            <label for="" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-user" id="exampleInputEmail" name="password" 
                         placeholder="Name OutLet">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection