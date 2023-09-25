@extends('front')

@section('content')
    <div class="container">
        <div class="card">
            <h3 class="text-center py-3">Transaksi</h3>
            <form action="{{ url('laundry/belipaket') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-2 mt-2">
                        <span class="ml-3">Add Paket</span>
                    </div>
                    <div class="col-md-4">
                        <select name="id_paket" id="" class="form-control form-select">
                            <option value="" disabled selected>---- Pilih Paket ---</option>
                            @foreach ($pakets as $paket)
                                <option value="{{ $paket->id }}">{{ $paket->nama_paket }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="jumlah" placeholder="--- Jumlah Paket ----" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                    <div class="col-md-5">
                        @if (session('pesan'))
                            <p class="alert alert-success my-3"><i class="fas fa-check-circle"></i> {{ session('pesan') }}
                            </p>
                        @endif
                    </div>
                </div>
            </form>
            <div class="row mb-5">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $total = 0;
                            @endphp
                            @if (session()->has('cart'))
                                @foreach (session('cart') as $id => $menu)
                                    @php
                                        $total = $total + $menu['jumlah'] * $menu['harga'];
                                    @endphp
                                    <tr>
                                        <td>{{ $no++ }}.</td>
                                        <td>{{ $menu['nama_paket'] }}</td>
                                        <td class="text-lg"> <a href="{{ url('laundry/kurang/' . $menu['id']) }}"
                                                class="text-decoration-none text-warning font-weight-bold text-lg">[-] </a>
                                            {{ $menu['jumlah'] }}
                                            <a href="{{ url('laundry/tambah/' . $menu['id']) }}"
                                                class="text-decoration-none text-success font-weight-bold text-lg">[+]</a>
                                        </td>
                                        <td>{{ $menu['harga'] }}</td>
                                        <td>
                                            {{ $menu['jumlah'] * $menu['harga'] }}
                                        </td>
                                        <td>
                                            <a href="{{ url('laundry/hapus/' . $menu['id']) }}"
                                                class="text-danger font-weight-bold"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-center font-weight-bold">Jumlah :</td>
                                    <td colspan="2">{{ $total }}</td>
                                </tr>
                            @else
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <form action="{{ url('laundry/transaksi') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="total" id="totals" value="{{ $total }}"
                    onkeyup="pesan();">
                <div class="row px-3">

                    {{-- <div class="col-md-2 mt-1">
                        <label for="">DiBayar : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" name="dibayar" class="form-control">
                    </div> --}}
                    <div class="col-md-2 mt-1">
                        <label for="">Member : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <select name="id_member" id="" class="form-control form-select">
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-1">
                        <label for="">Biaya Tambahan : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input class="form-control" type="number" name="biaya_tambahan" id="tambahan" onkeyup="pesan();">
                    </div>
                    <div class="col-md-2 mt-1">
                        <label for="">Discount : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input class="form-control" type="number" name="diskon" id="discount" onkeyup="pesan();">
                    </div>
                    <div class="col-md-2 mt-1">
                        <label for="">Pembayaran : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="number" name="dibayar" id="dibayar" class="form-control" onkeyup="pesan();">
                    </div>
                    <div class="col-md-2 mt-1">
                        <label for="" class="form-label">Keterangan : </label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <textarea class="form-control form-control-user" name="keterangan" aria-label="With textarea"></textarea>
                    </div>
                </div>
                {{-- <p class=" px-3">Total Harga Belum Termasuk Pajak : {{ $total }}</p> --}}
                <div class="row px-3">

                    {{-- Total Harga --}}
                    {{-- <input type="text" name="totalharga" id="totalinput"> --}}
                    <div class="col-md-2">
                        <span for="">Jumlah Keseluruhan : </span>
                        <span for="">Kembalian : </span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <span type="text" disabled name="jumlah" value="" id="totalSpan"></span><br>
                        <span type="text" name="" value="" id="kembali"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="mt-1">
                            <button class="float-right btn btn-success" target="_blank" type="submit">Transaksi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function pesan() {
            var total = parseFloat(document.getElementById('totals').value);
            var tambahan = parseFloat(document.getElementById('tambahan').value) || 0;
            var discount = parseFloat(document.getElementById('discount').value) || 0;
            var dibayar = parseFloat(document.getElementById('dibayar').value) || 0;
            var pajak = 0.11; // 11%

            var totalBiaya = total + tambahan - discount;
            var totalPajak = totalBiaya * pajak;
            var jumlah = totalBiaya + totalPajak;

            if (dibayar > 0) {
                var kembalian = dibayar - jumlah;
            }

            var totalSpan = document.getElementById('totalSpan');
            var kembali = document.getElementById('kembali');

            if (isNaN(kembalian)) {
                kembalian = 0;
            }

            kembali.innerHTML = 'Rp. ' + Math.ceil(kembalian);
            totalSpan.innerHTML = 'Rp. ' + Math.ceil(jumlah);
        }
    </script>
@endsection
