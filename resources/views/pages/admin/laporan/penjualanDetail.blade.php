@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Laporan Penjualan Detail'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Laporan Penjualan Detail</h6>
                        {{-- <a href="{{ route('kategoris.create') }}" class="btn btn-primary">Add Kategori</a> --}}
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row px-4">
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('reports.penjualanDetail') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="barang_id">Barang</label>
                                            <select id="barang_id" name="barang_id" class="form-control">
                                                <option value="">-- Semua --</option>
                                                @foreach ($barangs as $barang)
                                                    <option value="{{ $barang->id }}" {{ $barangId == $barang->id ? 'selected' : '' }}>{{ $barang->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="customer_id">Customer</label>
                                            <select id="customer_id" name="customer_id" class="form-control">
                                                <option value="">-- Semua --</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ $customerId == $customer->id ? 'selected' : '' }}>{{ $customer->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="start_date">Dari Tanggal</label>
                                            <input type="date" id="start_date" name="start_date"
                                                class="form-control datepicker"
                                                value="{{ $startDate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="end_date">Hingga Tanggal</label>
                                            <input type="date" id="end_date" name="end_date"
                                                class="form-control datepicker"
                                                value="{{ $endDate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                            </form>
                            <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
                            <div class="table-responsive p-0">
                                <table id="table-display" class="table table-striped table-hover table-bordered align-items-center mb-0">
                                    <thead style="background-color: #fb6340; color: #FFFFFF" class="text-center">
                                        <tr>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Tanggal</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">No Transaksi</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Customer</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Barang</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Jumlah</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Harga Satuan</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Subtotal Item</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Discount Transaksi</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder">Grand Total Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporan as $penjualan)
                                            @forelse ($penjualan->details as $detail)
                                                <tr>
                                                    <td>{{ $penjualan->tanggal }}</td>
                                                    <td>{{ $penjualan->id }}</td>
                                                    <td>{{ $penjualan->customer->nama ?? $penjualan->nama_customer }}</td>
                                                    <td>{{ $detail->barang->nama }}</td>
                                                    <td>{{ $detail->jumlah }}</td>
                                                    <td>{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($penjualan->discount, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($penjualan->grand_total, 0, ',', '.') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada detail</td>
                                                </tr>
                                            @endforelse
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
