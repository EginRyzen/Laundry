@extends('front')

@section('content')
    <style>
        .flex-container-1 {
            display: flex;
            margin-top: 10px;
        }

        .flex-container-1>div {
            text-align: left;
        }

        .flex-container-1 .right {
            text-align: right;
            width: 40%;
        }

        .flex-container-1 .left {
            width: 60%;
            margin-left: 20%;
        }

        ul {
            display: contents;
        }

        ul li {
            display: block;
            font-size: 16px;
            font-weight: bold;
        }

        p {
            font-weight: bold;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="height: 70vh">
                    <div class="p-3">
                        <p>Nama : {{ $data[0]['nama'] }} </p>
                        <p>No_hp : {{ $data[0]['telp'] }} </p>
                        <p>Alamat : {{ $data[0]['alamat'] }} </p>
                        <p>Status : @if ($data[0]['dibayar'] == 'bayar')
                                Sudah Bayar
                            @else
                                Belum Bayar
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="p-3">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                    $total = 0;
                                @endphp
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $no++ }}.</td>
                                        <td>{{ $row->nama_paket }}</td>
                                        <td>{{ $row->qty }}</td>
                                        <td>{{ $row->harga }}</td>
                                        @php
                                            $subtotal = $row->qty * $row->harga;
                                            $total += $subtotal;
                                        @endphp
                                        <td>{{ $subtotal }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-center font-weight-bold">Jumlah :</td>
                                    <td colspan="2">{{ $total }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="flex-container-1">
                            <div class="left">
                                <ul>
                                    <li>BiayaTambahan</li>
                                    <li class="py-4">Diskon</li>
                                    <li>Pajak</li>
                                    <li class="py-4">Total</li>
                                    <li>Bayar</li>
                                    <li class="mt-4">Kembali</li>
                                </ul>
                            </div>
                            <div class="right">
                                <ul>
                                    <form action="{{ url('laundry/updatebayar/' . $data[0]['id_transaksi']) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <li>
                                            <input type="text" value="{{ $data[0]['biaya_tambahan'] }} "
                                                class="form-control" readonly>
                                        </li>
                                        <li class="py-2"><input type="text" value=" {{ $data[0]['diskon'] }} "
                                                class="form-control" readonly></li>
                                        <li><input type="text" value="{{ $data[0]['pajak'] }} " class="form-control"
                                                readonly></li>
                                        <li class="py-2">
                                            <input type="text" name="total"
                                                value="{{ $data[0]['biaya_tambahan'] + $total + $data[0]['pajak'] - $data[0]['diskon'] }}"
                                                class="form-control" id="total" readonly onkeyup="pesan();">
                                        </li>
                                        <li>
                                            <input type="number" id="bayar" name="bayar" class="form-control"
                                                onkeyup="pesan();">
                                        </li>
                                        <li class="py-2">
                                            <input type="number" name="kembali" id="kembali" class="form-control"
                                                readonly>
                                        </li>
                                        <li>
                                            <button class="btn btn-primary" disabled id="btn">Bayar</button>
                                        </li>
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function pesan() {
            var total = parseFloat(document.getElementById('total').value);
            var dibayar = parseFloat(document.getElementById('bayar').value) || 0;
            var btn = document.querySelector('li #btn');

            if (dibayar >= total) {
                btn.removeAttribute('disabled');
            } else {
                btn.setAttribute('disabled', 'disabled');
            }
            var jadikembali = dibayar - total;
            var kembali = document.getElementById('kembali');

            kembali.value = Math.ceil(jadikembali);

        }
    </script>
@endsection
