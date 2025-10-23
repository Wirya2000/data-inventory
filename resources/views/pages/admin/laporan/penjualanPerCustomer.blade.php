@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tables'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Laporan Penjualan Per Customer</h6>
                        {{-- <a href="{{ route('kategoris.create') }}" class="btn btn-primary">Add Kategori</a> --}}
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row px-4">
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('reports.penjualanRekap') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start_date">Tanggal Mulai</label>
                                            <input type="date" id="start_date" name="start_date"
                                                class="form-control datepicker"
                                                value="{{ $startDate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="end_date">Tanggal Selesai</label>
                                            <input type="date" id="end_date" name="end_date"
                                                class="form-control datepicker"
                                                value="{{ $endDate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                            <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
                            <div class="table-responsive p-0">
                                <table id="table-display" class="table table-striped table-hover table-bordered align-items-center mb-0">
                                    <thead style="background-color: #fb6340; color: #FFFFFF" class="text-center">
                                        <tr>
                                            <th class="text-uppercase text-xxs font-weight-bolder">No</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Nama Customer</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Total Transaksi</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Total Pembelian (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporan as $penjualan)
                                            <tr>
                                                <td>{{ $penjualan->tanggal }}</td>
                                                <td>{{ $penjualan->nama_customer }}</td>
                                                <td>{{ $penjualan->total_transaksi }}</td>
                                                <td>{{ number_format($penjualan->total_pembelian, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });

            new DataTable('#table-display', {
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                }
            });
        });
    </script>
@endpush
