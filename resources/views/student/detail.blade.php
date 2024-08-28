@extends('layouts.app')
@section('content')
<style>
  label {
    margin: 0;
    align-self: center;
  }
  div.yourform div div {
    display: grid;
  }
</style>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="admin-heading">Detail Peminjam</h2>
                </div>
                <div class="offset-md-5 col-md-3">
                    <a class="add-new" href="{{ url()->previous() }}"><< Kembali</a>
                </div>
            </div>
            <div class="row">
                <div class="w-100 yourform">
                  <div class="form-group row">
                    <div class="col-4">
                      <label>NIK</label>
                    </div>
                    <div class="col-8">
                      <input type="text" class="form-control" placeholder="NIK" name="NIK"
                          value="{{ $student->NIK }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-4">
                      <label>Nama Peminjam</label>
                    </div>
                    <div class="col-8">
                      <input type="text" class="form-control" placeholder="Student Name" name="name"
                          value="{{ $student->name }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-4">
                      <label>Alamat</label>
                    </div>
                    <div class="col-8">
                      <input type="text" class="form-control" placeholder="Address" name="address"
                          value="{{ $student->address }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-4">
                      <label>Jenis Kelamin</label>
                    </div>
                    <div class="col-8">
                      <input type="text" class="form-control" placeholder="Gender" name="gender"
                          value="{{ $student->gender == 'L' ? "Laki - Laki" : "Perempuan" }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-4">
                      <label>Telepon</label>
                    </div>
                    <div class="col-8">
                      <input type="text" class="form-control" placeholder="Phone" name="phone"
                          value="{{ $student->phone}}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-4">
                      <label>Email</label>
                    </div>
                    <div class="col-8">
                      <input type="text" class="form-control" placeholder="Email" name="email"
                          value="{{ $student->email}}" disabled>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row pt-4">
              <div class="col-md-4">
                  <h2 class="admin-heading">History Peminjaman</h2>
              </div>
              <div class="offset-md-5 col-md-3">
              </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <table class="content-table w-100" id="content_table">
                  <thead>
                      <th>No</th>
                      <th class="w-25">Judul Buku</th>
                      <th>Tgl Pinjam</th>
                      <th>Tgl Kembali</th>
                      <th>Kembali</th>
                      <th>Status</th>
                      <th>Edit</th>
                  </thead>
                  <tbody>
                      @foreach ($books as $book)
                          <tr style='@if (date('Y-m-d') > date($book->return_date->format('Y-m-d')) && $book->issue_status == 'N') background:rgba(255,0,0,0.2 @endif'>
                              <td>{{ $book->id }}</td>
                              <td class="text-left">{{ $book->book->name }}</td>
                              <td data-sort="{{$book->issue_date}}">{{ $book->issue_date->format('d M Y') }}</td>
                              <td data-sort="{{$book->return_date}}">{{ $book->return_date->format('d M Y') }}</td>
                              <td style={{$book->return_day>$book->return_date ? "background:rgba(255,0,0,0.2" : "background:rgba(0,255,0,0.2"}} data-sort="{{$book->return_day}}">{{$book->return_day->format('d M Y')}}</td>
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
              {searchable:false},
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