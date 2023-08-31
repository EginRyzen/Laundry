<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Laundry <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('laundry/dasbord') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    @if (Auth::user()->role == 'kasir')
            <li class="nav-item active">
        <a class="nav-link" href="{{ url('laundry/transaksikasir') }}">
            <i class="fas fa-money-check"></i>
            <span>Transaksi</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('laundry/transaksidetailkasir') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Detail Transaksi</span></a>
    </li>
    @endif
    @if (Auth::user()->role == 'admin')
            <li class="nav-item active">
        <a class="nav-link" href="{{ url('laundry/transaksi') }}">
            <i class="fas fa-money-check"></i>
            <span>Transaksi</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('laundry/transaksidetail') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Detail Transaksi</span></a>
    </li>
    @endif

    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Pelanggan
    </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user"></i>
            <span>User</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Registrasi Pelanggan</h6>
                @if (Auth::user()->role == 'admin')
                    <a class="collapse-item" href="{{ url('laundry/registeradmin') }}">Admin</a>
                @endif
                @if (Auth::user()->role == 'kasir')
                    <a class="collapse-item" href="{{ url('laundry/registerkasir') }}">Kasir</a>
                @endif
            </div>
        </div>
    </li> --}}
    @if (Auth::user()->role == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ url('laundry/registeradmin') }}">
            <i class="fas fa-user-plus"></i>
            <span>Register Pelanggan</span></a>
    </li>
    @endif
    @if (Auth::user()->role == 'kasir')
    <li class="nav-item">
        <a class="nav-link" href="{{ url('laundry/member') }}">
            <i class="fas fa-users"></i>
            <span>Member/Pelanggan</span></a>
    </li>
    @endif
    @if (Auth::user()->role == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ url('laundry/selectoutlet') }}">
            <i class="fas fa-home"></i>
            <span>Outlet</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('laundry/selectpaket') }}">
            <i class="fas fa-luggage-cart"></i>
            <span>Paket</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('laundry/selectpelanggan') }}">
            <i class="fas fa-user-tie"></i>
            <span>All User</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('laundry/member') }}">
            <i class="fas fa-users"></i>
            <span>Member/Pelanggan</span></a>
    </li>
    @endif

{{-- 
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages1"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages1" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> --}}

    <!-- Divider -->
    {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>