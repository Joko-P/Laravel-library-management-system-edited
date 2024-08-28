@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Dashboard</h2>
                </div>
                <div class="offset-md-6 col-md-3">
                    <div class="dropdown">
                        <a class="add-new dropdown-toggle" id="dropdownUser" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hi, {{ auth()->user()->name }}!</a>
                        <div class="dropdown-menu w-100" aria-labelledby="dropdownUser">
                            <a class="dropdown-item" href="{{ route('change_password') }}">Ganti Password</a>
                            <a class="dropdown-item" href="#" onclick="document.getElementById('logoutForm').submit()">Log Out</a>
                        </div>
                        <form method="post" id="logoutForm" action="{{ route('logout') }}">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card w-100" style="margin: 0 auto;">
                        <a href="{{route('book_issued')}}">
                            <div class="card-body text-center">
                                <p class="card-text">{{ number_format($issued_books,0,'','.') }}</p>
                                <h5 class="card-title mb-0">Jumlah Peminjaman<br>(Total)</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card w-100" style="margin: 0 auto;">
                        <a href="{{route('book_issued.active')}}">
                            <div class="card-body text-center">
                                <p class="card-text">{{ number_format($issued_active,0,'','.') }}</p>
                                <h5 class="card-title mb-0">Jumlah Peminjaman<br>(Aktif)</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card w-100" style="margin: 0 auto;">
                        <a href="{{route('book_issued.late')}}">
                            <div class="card-body text-center">
                                <p class="card-text">{{ number_format($issued_late,0,'','.') }}</p>
                                <h5 class="card-title mb-0">Jumlah Peminjaman<br>(Aktif & Terlambat)</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
