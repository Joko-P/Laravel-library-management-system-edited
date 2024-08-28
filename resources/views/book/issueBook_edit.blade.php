@extends('layouts.app')
@section('content')

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <h2 class="admin-heading">Detail Pengembalian Buku</h2>
                </div>
                <div class="offset-md-4 col-md-3">
                    <a class="add-new" href="{{ url()->previous() }}"><< Kembali</a>
                </div>
            </div>
            <div class="row">
                <form action="{{ route('book_issue.update', $book->id) }}" class="yourform w-100" method="post" autocomplete="off">
                    @csrf
                    <div class="form-group row">
                        <div class="col-4">
                          <label>Nama Peminjam</label>
                        </div>
                        <div class="col-8">
                          <input type="text" class="form-control" name="name"
                              value="{{ $book->student->name }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                          <label>Judul Buku</label>
                        </div>
                        <div class="col-8">
                          <input type="text" class="form-control" name="book_name"
                              value="{{ $book->book->name }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                          <label>Telepon</label>
                        </div>
                        <div class="col-8">
                          <input type="text" class="form-control" name="phone"
                              value="{{ $book->student->phone }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                          <label>Email</label>
                        </div>
                        <div class="col-8">
                          <input type="text" class="form-control" name="email"
                              value="{{ $book->student->email }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                          <label>Tanggal Pinjam</label>
                        </div>
                        <div class="col-8">
                          <input type="text" class="form-control" name="pinjam"
                              value="{{ $book->issue_date->format('d M, Y') }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                          <label>Tanggal Kembali</label>
                        </div>
                        <div class="col-8">
                          <input type="text" class="form-control" name="kembali"
                              value="{{ $book->return_date->format('d M, Y') }}" readonly="readonly">
                        </div>
                    </div>
                    @if ($book->issue_status == 'Y')
                        <div class="form-group row">
                            <div class="col-4">
                            <label>Status</label>
                            </div>
                            <div class="col-8">
                            <input type="text" class="form-control" name="status"
                                value="Sudah Dikembalikan" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                            <label>Dikembalikan Tanggal</label>
                            </div>
                            <div class="col-8">
                            <input type="text" class="form-control" name="return"
                                value="{{ $book->return_day->format('d M, Y') }}" readonly="readonly">
                            </div>
                        </div>
                        @if ($book->return_day->format('Y-m-d') > date($book->return_date->format('Y-m-d')))
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Denda</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="kembali"
                                        value="Rp {{ $book->fines }}" readonly="readonly">
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="form-group row">
                            <div class="col-4">
                            <label>Status</label>
                            </div>
                            <div class="col-8">
                            <input type="text" class="form-control" name="status"
                                value="Belum Dikembalikan" readonly="readonly">
                            </div>
                        </div>
                        @if (date('Y-m-d') > date($book->return_date->format('Y-m-d')))
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Denda</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="kembali"
                                        value="Rp {{ $fine }}" readonly="readonly">
                                </div>
                            </div>
                        @endif
                    @endif
                    @if ($book->issue_status == 'N')
                        <div class="row">
                            <input type='submit' class='btn btn-danger mx-auto w-25' name='save' value='Kembalikan Buku'>
                        </div>                        
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection
