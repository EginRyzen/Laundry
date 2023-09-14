<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Out Generate</title>
</head>
<style>
    h1 {
        text-align: center;
    }

    .container {
        max-width: 1200px;
        /* Lebar maksimum container */
        margin: 0 auto;
        /* Margin otomatis untuk rata tengahkan container */
        padding: 20px;
        /* Padding di dalam container (opsional) */
        box-sizing: border-box;
        /* Memastikan lebar dan tinggi container tidak termasuk margin dan padding */
    }

    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #b5b1a5;
        color: #000;
    }
</style>

<body>

    <h1>Generate Laporan</h1>

    <div class="container">
        <table id="customers">
            <tr>
                <th>No</th>
                <th>Member</th>
                <th>Toko</th>
                <th>Alamat</th>
                <th>Nama Paket</th>
                <th>Tanggal</th>
                <th>Tanggal Bayar</th>
                <th>Status</th>
                <th>Qty</th>
            </tr>
            @php
                $no = 1;
            @endphp
            <tr>
                @foreach ($generates as $generate)
            <tr>
                <td>{{ $no++ }}.</td>
                <td>{{ $generate->member }}</td>
                <td>{{ $generate->nama }}</td>
                <td>{{ $generate->alamat }}</td>
                <td>{{ $generate->nama_paket }}</td>
                <td>{{ $generate->tgl }}</td>
                <td>{{ $generate->tgl_bayar }}</td>
                <td>{{ $generate->status }}</td>
                <td>{{ $generate->qty }}</td>
            </tr>
            @endforeach
            </tr>
        </table>
    </div>
</body>

</html>
