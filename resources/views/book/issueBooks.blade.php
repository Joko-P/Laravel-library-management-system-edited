@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="admin-heading">Peminjaman Buku {{$title}}</h2>
                </div>
                <div class="offset-md-3 col-md-2">
                    <div class="dropdown">
                        <a class="add-new dropdown-toggle" id="dropdownIssuedBooks" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownIssuedBooks">
                            <a class="dropdown-item" href="{{ route('book_issued') }}">Total</a>
                            <a class="dropdown-item" href="{{ route('book_issued.active') }}">Aktif</a>
                            <a class="dropdown-item" href="{{ route('book_issued.late') }}">Aktif Terlambat</a>
                            <a class="dropdown-item" href="{{ route('book_issued.returned_good') }}">Kembali Tepat Waktu</a>
                            <a class="dropdown-item" href="{{ route('book_issued.returned_late') }}">Kembali Terlambat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <a class="add-new" href="{{ route('book_issue.create') }}">Tambah Peminjaman Baru</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="content-table w-100" id="content_table">
                        <thead>
                            <th>No</th>
                            <th class="w-25">Pengunjung</th>
                            <th class="w-25">Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr style='@if (date('Y-m-d') > date($book->return_date->format('Y-m-d')) && $book->issue_status == 'N') background:rgba(255,0,0,0.2 @endif'>
                                    <td>{{ $book->id }}</td>
                                    <td class="text-left">{{ $book->student->name }}</td>
                                    <td class="text-left">{{ $book->book->name }}</td>
                                    <td data-sort="{{$book->issue_date}}">{{ $book->issue_date->format('d M Y') }}</td>
                                    <td data-sort="{{$book->return_date}}">{{ $book->return_date->format('d M Y') }}</td>
                                    <td>
                                        @if ($book->issue_status == 'Y')
                                            <span class='badge badge-success'>Kembali</span>
                                        @else
                                            @if (date('Y-m-d') > date($book->return_date->format('Y-m-d')))
                                                <span class='badge badge-danger'>Terlambat</span>
                                            @else
                                                <span class='badge badge-danger'>Dipinjam</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('book_issue.edit', $book->id) }}" class="btn btn-success">Edit</a>
                                    </td>
                                    {{-- <td class="delete">
                                        <form action="{{ route('book_issue.destroy', $book) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger">Delete</button>
                                            @csrf
                                        </form>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        new DataTable('#content_table', {
            searchHighlight: true,
            language: {
                url: '{{asset('json/id.json')}}'
            },
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'All']
            ],
            order: [[4, 'desc']],
            columns: [
                {searchable:false},
                null,
                null,
                {searchable:false},
                {searchable:false},
                {sortable:false},
                {searchable:false,sortable:false},
            ],
            initComplete: function() {
                $("#content_table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            }
        });
    </script>
@endsection
