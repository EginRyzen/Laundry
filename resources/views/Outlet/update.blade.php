@extends('front')

@section('content')
    <div class="container">
        <h3>Update Data</h3>
        <div class="row">
            <div class="col-5">
                <form action="{{ url('laundry/update/'.$tokos->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                            <label for="" class="form-label">Nama</label>
                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" value="{{ $tokos->nama }}" name="nama" 
                         placeholder="Name OutLet">
                    </div>
                    <div class="form-group mb-3">
                            <label for="" class="form-label">ALamat</label>
                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" value="{{ $tokos->alamat }}" name="alamat" 
                         placeholder="Name OutLet">
                    </div>
                    <div class="form-group mb-3">
                            <label for="" class="form-label">Telpon</label>
                            <input type="number" class="form-control form-control-user" id="exampleInputEmail" value="{{ $tokos->telp }}" name="telp" 
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