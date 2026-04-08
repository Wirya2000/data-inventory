@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Laporan Penjualan Harian'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Laporan Penjualan Harian</h6>
                        {{-- <a href="{{ route('kategoris.create') }}" class="btn btn-primary">Add Kategori</a> --}}
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row px-4">
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('reports.penjualanHarian') }}" class="mb-3">
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
                                            <th class="text-uppercase text-xxs font-weight-bolder">Tanggal</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Jumlah Transaksi</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Total Barang Terjual</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Subtotal</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Discount</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Grand Total</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Rata-rata per Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporan as $harian)
                                            <tr>
                                                <td>{{ $harian->tanggal }}</td>
                                                <td>{{ $harian->jumlah_transaksi }}</td>
                                                <td>{{ $harian->total_barang }}</td>
                                                <td>{{ number_format($harian->total_subtotal, 0, ',', '.') }}</td>
                                                <td>{{ number_format($harian->total_diskon, 0, ',', '.') }}</td>
                                                <td>{{ number_format($harian->total_grand, 0, ',', '.') }}</td>
                                                <td>{{ number_format($harian->rata_rata_transaksi, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-weight: bold; background-color: #f6f9fc">
                                            <td colspan="2" class="text-end">TOTAL</td>
                                            <td>{{ $laporan->sum('total_barang') }}</td>
                                            <td>{{ number_format($laporan->sum('total_subtotal'), 0, ',', '.') }}</td>
                                            <td>{{ number_format($laporan->sum('total_diskon'), 0, ',', '.') }}</td>
                                            <td>{{ number_format($laporan->sum('total_grand'), 0, ',', '.') }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
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
