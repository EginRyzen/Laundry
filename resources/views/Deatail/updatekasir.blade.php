@extends('front')

@section('content')
<div class="container">
    <h3>Update Transaksi</h3>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ url('laundry/transaksidetailkasir/'.$data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')  
                <div class="modal-body">
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option value="{{ $data->status }}">{{ $data->status }}</option>
                                <option value="baru">Baru</option>
                                <option value="proses">Proses</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="dibayar" id="" class="form-control">
                                <option value="{{ $data->dibayar }}" selected>{{ $data->dibayar }}</option>
                                <option value="belum_bayar">Belum Bayar</option>
                                <option value="bayar">Bayar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-secondary" type="button">Cancel</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection