@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="admin-heading">Reset Password</h2>
                </div>
                <div class="offset-md-5 col-md-3">
                    <a class="add-new" href="{{ url()->previous() }}"><< Kembali</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="yourform" action="{{ route('change_password') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>Password Sekarang</label>
                            <input type="password" class="form-control" name="c_password" value=""
                                required>
                            @error('c_password')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" class="form-control" name="password" value="" required>
                            @error('password')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" value="" required>
                        </div>
                        <input type="submit" class="btn btn-danger" value="Update" required>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
