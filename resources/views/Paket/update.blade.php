@extends('front')

@section('content')
    <div class="container">
        <h3>Update Data</h3>
        <div class="row">
            <div class="col-5">
                <form action="{{ url('laundry/updatepaket/'.$pakets->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('PUT') --}}
                    <div class="form-group mb-3">
                        <select class="form-control form-select" name="id_outlet" id="exampleSelect" placeholder="Select Option">
                            @foreach ($tokos as $toko )
                            <option @if($toko->id == $pakets->id_outlet) selected @endif value="{{ $toko->id }}">
                                {{ $toko->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                            <label for="" class="form-label">Nama Paket</label>
                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" value="{{ $pakets->nama_paket }}" name="nama_paket" 
                         placeholder="Name OutLet">
                    </div>
                    <div class="form-group mb-3">
                        <select class="form-control form-select" name="jenis" id="exampleSelect" placeholder="Select Option">
                                <option value="{{ $pakets->jenis }}" selected>{{ $pakets->jenis }}</option>
                                <option value="kiloan">Kiloan</option>
                                <option value="selimut">Selimut</option>
                                <option value="kaos">Kaos</option>
                                <option value="bed_cover">Bed Cover</option>
                                <option value="lain">Lain</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                            <label for="" class="form-label">Harga</label>
                            <input type="number" class="form-control form-control-user" id="exampleInputEmail" value="{{ $pakets->harga }}" name="harga" 
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