@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <h2 class="admin-heading text-center">Laporan Peminjaman Mingguan</h2>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-2 col-md-8">
                    <div class="message">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h6 class="alert-heading">{{$errors->first('title')}}</h6>
                                <p>{{$errors->first('msg')}}<p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(@session()->has('title'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">{{session()->get('title')}}</h4>
                                <p>{{session()->get('msg')}}<p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="offset-md-4 col-md-4">
                    <form class="yourform mb-5" action="{{ route('reports.weekly_generate') }}" target="" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                            @error('date')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">Pilih hari terakhir, laporan akan dibuat 7 hari ke belakang.</small>
                        </div>
                        <input type="submit" class="w-100 btn btn-danger" name="search_date" value="Buat Laporan">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
