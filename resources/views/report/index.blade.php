@extends("layouts.app")
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Laporan</h2>
                </div>
                <div class="offset-md-6 col-md-3">
                    {{-- <a class="add-new" href="{{ url()->previous() }}"><< Kembali</a> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card w-100">
                        <a href="{{ route('reports.weekly_report') }}">
                            <div class="card-body text-center">
                                <h5 class="card-title mb-0">Laporan Mingguan</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card w-100">
                        <a href="{{ route('reports.monthly_report') }}">
                            <div class="card-body text-center">
                                <h5 class="card-title mb-0">Laporan Bulanan</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card w-100">
                        <a href="{{ route('reports.yearly_report') }}">
                            <div class="card-body text-center">
                                <h5 class="card-title mb-0">Laporan Tahunan</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
