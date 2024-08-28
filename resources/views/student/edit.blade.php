@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="admin-heading">Update Peminjam</h2>
                </div>
                <div class="offset-md-5 col-md-3">
                    <a class="add-new" href="{{ url()->previous() }}"><< Kembali</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="yourform" action="{{ route('student.update', $student->id) }}" method="post"
                        autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>Nama Peminjam</label>
                            <input type="text" class="form-control" placeholder="Student Name" name="name"
                                value="{{ $student->name }}" required>
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control" placeholder="Address" name="address"
                                value="{{ $student->address }}" required>
                            @error('address')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender" class="form-control">
                                @if ($student->gender == 'L')
                                    <option value="L" selected>Laki - Laki</option>
                                @else
                                    <option value="P" selected>Perempuan</option>
                                @endif
                            </select>
                            @error('gender')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" class="form-control" placeholder="NIK" name="NIK"
                                value="{{ $student->class }}" required>
                            @error('NIK')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="phone" class="form-control" placeholder="Phone" name="phone"
                                value="{{ $student->phone }}" required>
                            @error('phone')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email" name="email"
                                value="{{ $student->email }}" required>
                            @error('email')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <input type="submit" name="save" class="btn btn-danger mx-auto w-50" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
