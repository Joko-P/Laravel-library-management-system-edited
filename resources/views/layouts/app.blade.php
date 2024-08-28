<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Sistem Manajemen Perpustakaan') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{asset('favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }} "> <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css')}}"> <!-- Bootstrap-Table -->
    <link rel="stylesheet" href="{{ asset('css/dataTables.searchHighlight.css')}}"> <!-- Bootstrap Table Highlight -->
</head>

<body>
    <div id="header">
        <!-- HEADER -->
        <div class="container">
            <div class="row">
                <div class="offset-md-4 col-md-4">
                    <div class="logo">
                        <a href="{{ route('dashboard') }}"><img src="{{ asset('images/library.png') }}"></a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /HEADER -->
    <nav class="site-header">
        <div id="menubar">
            <!-- Menu Bar -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="menu">
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('authors') }}">Penulis</a></li>
                            <li><a href="{{ route('publishers') }}">Penerbit</a></li>
                            <li><a href="{{ route('categories') }}">Kategori</a></li>
                            <li><a href="{{ route('books') }}">Buku</a></li>
                            <li><a href="{{ route('students') }}">Peminjam</a></li>
                            <li><a href="{{ route('book_issued.active') }}">Peminjaman</a></li>
                            <li><a href="{{ route('reports') }}">Laporan</a></li>
                            <li><a href="{{ route('settings') }}">Pengaturan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- /Menu Bar -->
    </nav>
    

    @yield('content')

    <!-- FOOTER -->
    <div id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span>© Copyright {{ now()->format("Y") }} <a href="https://www.yahoobaba.net">YahooBaba 😎</a></span>
                </div>
            </div>
        </div>
    </div>
    <!-- /FOOTER -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js')}}"></script>
    <script src="{{ asset('js/dataTables.searchHighlight.min.js')}}"></script>
    <script src="{{ asset('js/chart.js')}}"></script>
    <script src="{{ asset('js/chartjs-plugin-datalabels.js')}}"></script>
    <script src="{{ asset('js/chartjs-color.min.js')}}"></script>
    <script src="{{ asset('js/jquery.highlight.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
