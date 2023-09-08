<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Out Generate</title>
</head>
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
{{--
<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}"> --}}

<link href="{{ url('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<body>
    <div class="container py-3">
        <h3 class="text-dark text-center font-weight-bold py-2">Generate Laporan</h3>
        <div class="table-responsive mx-auto text-center">
            <table class="table table-bordered">
                <thead>
                    <th>No</th>
                    <th>Member</th>
                    <th>Toko</th>
                    <th>Alamat</th>
                    <th>Nama Paket</th>
                    <th>Tanggal</th>
                    <th>Tanggal Bayar</th>
                    <th>Status</th>
                    <th>Qty</th>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    {{-- <!-- Page level custom scripts -->
      <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
      <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script> --}}

    <!-- Table -->
    <script src="{{ url('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>
</body>

</html>
