@extends('layouts.app')
@section('content')

    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Daftar Buku</h2>
                </div>
                <div class="offset-md-4 col-md-2">
                    <div class="dropdown">
                        <a class="add-new dropdown-toggle" id="dropdownBookFilter" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownBookFilter">
                            <a class="dropdown-item" href="{{ route('books') }}">Total</a>
                            <a class="dropdown-item" href="{{ route('books.available') }}">Tersedia</a>
                            <a class="dropdown-item" href="{{ route('books.borrowed') }}">Terpinjam</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <a class="add-new" href="{{ route('book.create') }}">Tambah Buku</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">{{$errors->first('title')}}</h4>
                                <p>{{$errors->first('msg')}}<p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(@session()->has('title'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">{{session()->get('title')}}</h4>
                                <p>{{session()->get('msg')}}<p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <table class="content-table w-100" id="content_table">
                        <thead>
                            <tr>
                                <th class="w-auto">No.</th>
                                <th class="w-25">Judul Buku</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td class="id">{{ $book->id }}</td>
                                    <td class="text-left">{{ $book->name }}</td>
                                    <td>{{ $book->category->name }}</td>
                                    <td>{{ $book->auther->name }}</td>
                                    <td>{{ $book->publisher->name }}</td>
                                    <td>
                                        @if ($book->in_stock > 0)
                                            <span class='badge badge-success'>{{$book->in_stock}} Tersedia</span>
                                        @else
                                            <span class='badge badge-danger'>Dipinjam</span>
                                        @endif
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('book.edit', $book) }}" class="btn btn-success">Edit</a>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('book.destroy', $book) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger delete-book">Delete</button>
                                            @csrf
                                        </form>
                                    </td>
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
            orderCellsTop: true,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'All']
            ],
            order: [[1, 'asc']],
            columns: [
                {searchable:false},
                null,
                {sortable:false},
                {sortable:false},
                {sortable:false},
                {sortable:false},
                {searchable:false,sortable:false},
                {searchable:false,sortable:false}
            ],
            initComplete: function() {
                $("#content_table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
        });
    </script>
@endsection
