@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Tambah Penerbit</h2>
            </div>
            <div class="offset-md-6 col-md-3">
              <a class="add-new" href="{{ url()->previous() }}"><< Kembali</a>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourform" action="{{ route('publisher.store') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label>Nama Penerbit</label>
                        <input type="text" class="form-control @error('name') isinvalid @enderror" placeholder="Publisher Name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <input type="submit" name="save" class="btn btn-danger mx-auto w-50" value="Simpan" required>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
