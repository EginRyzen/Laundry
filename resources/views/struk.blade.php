<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        .container {
            width: 300px;
            position: absolute;
            left: 50%;
            /* width:200px;
            height:200px; */
            transform: translate(-50%, -0%);
        }

        .header {
            margin: 0;
            text-align: center;
        }

        h2,
        p {
            margin: 0;
        }

        .flex-container-1 {
            display: flex;
            margin-top: 10px;
        }

        .flex-container-1>div {
            text-align: left;
        }

        .flex-container-1 .right {
            text-align: right;
            width: 200px;
        }

        .flex-container-1 .left {
            width: 200px;
        }

        .flex-container {
            width: 300px;
            display: flex;
        }

        .flex-container>div {
            -ms-flex: 1;
            /* IE 10 */
            flex: 1;
        }

        ul {
            display: contents;
        }

        ul li {
            display: block;
        }

        hr {
            border-style: dashed;
        }

        a {
            text-decoration: none;
            text-align: center;
            padding: 10px;
            background: #00e676;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header" style="margin-bottom: 30px;">
            <h2>{{ $alamat->nama }}</h2>
            <small>{{ $alamat->alamat }}
            </small>
        </div>
        <hr>
        <div class="flex-container-1">
            <div class="left">
                <ul>
                    <li>Kasir</li>
                    <li>No Order</li>
                    <li>Customer</li>
                    <li>Tanggal</li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li>{{ Auth::user()->nama }}</li>
                    <li> {{ $transaksi->kode_invoice }} </li>
                    <li> {{ $member->nama }} </li>
                    <li> {{ date('d-m-Y') }} </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="flex-container" style="margin-bottom: 10px; text-align:right;">
            <div style="text-align: left;">Nama Product</div>
            <div>Harga/Qty</div>
            <div>Total</div>
        </div>
        @php
            $total = 0;
        @endphp
        @foreach ($struks as $struk)
            @php
                $total = $total + $struk->harga * $struk->qty;
            @endphp
            <div class="flex-container" style="text-align: right;">
                <div style="text-align: left;">{{ $struk->nama_paket }}</div>
                <div>Rp.{{ number_format($struk->harga, 0, ',', '.') }}*{{ $struk->qty }} </div>
                <div>Rp.{{ number_format($struk->harga * $struk->qty, 0, ',', '.') }}</div>
            </div>
            <br>
        @endforeach
        <hr>
        <div class="flex-container" style="text-align: right; margin-top: 10px;">
            <div>
                <ul>
                    <li>Diskon</li>
                    <li>Biaya Tambahan</li>
                    <li>Pajak</li>
                    <li>Total Biaya</li>
                </ul>
            </div>
            <div style="text-align: right;">
                <ul>
                    <li>Rp. {{ number_format($struk->diskon, 0, ',', '.') }} </li>
                    <li>Rp. {{ number_format($struk->biaya_tambahan, 0, ',', '.') }}</li>
                    <li>Rp. {{ number_format($struk->pajak, 0, ',', '.') }}</li>
                    <li>Rp.
                        {{ number_format($total + $struk->biaya_tambahan - $struk->diskon + $struk->pajak, 0, ',', '.') }}
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="header" style="margin-top: 50px;">
            <h3>Terimakasih</h3>
            <p>Silahkan berkunjung kembali</p>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.print();
        }, 500);
        window.onfocus = function() {
            setTimeout(function() {
                window.close();
            }, 10000);
        }
    </script>
</body>

</html>
