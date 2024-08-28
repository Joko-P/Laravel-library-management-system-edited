@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="admin-heading">Daftar Peminjam</h2>
                </div>
                <div class="offset-md-5 col-md-3">
                    <a class="add-new" href="{{ route('student.create') }}">Tambah Peminjam</a>
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
                            <th>No</th>
                            <th class="w-25">Nama Peminjam</th>
                            <th>J. Kel.</th>
                            <th>Telp.</th>
                            <th>E-Mail</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td class="id">{{ $student->id }}</td>
                                    <td class="text-left">{{ $student->name }}</td>
                                    <td>@if ($student->gender == "L")
                                        Laki - Laki
                                    @else
                                        Perempuan
                                    @endif</td>
                                    <td>{{ $student->phone }}</td>
                                    <td class="text-left">{{ $student->email }}</td>
                                    <td class="view">
                                        <a href="{{ route('student.detail', $student) }}>" class="btn btn-primary">View</a>
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('student.edit', $student) }}>" class="btn btn-success">Edit</a>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('student.destroy', $student->id) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger delete-student">Delete</button>
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
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
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
            order: [[1, 'asc']],
            columns: [
                {searchable:false},
                null,
                {sortable:false},
                {sortable:false},
                {sortable:false},
                {searchable:false,sortable:false},
                {searchable:false,sortable:false},
                {searchable:false,sortable:false},
            ],
            initComplete: function() {
                $("#content_table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            }
        });
    </script>
@endsection
