@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'List Barang'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Barang</h6>
                        <a href="{{ route('barangs.create') }}" class="btn btn-primary">Add Barang</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tableBarang" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kategori</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kode Barang</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama Barang</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Satuan</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Stock</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Minimum Stock</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Harga Beli</th> --}}
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Harga Jual</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                        {{-- <th class="text-secondary opacity-7">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->kategori->nama }}</td>
                                        <td>{{ $data->kode }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->satuan->nama }}</td>
                                        <td>{{ thousand_separator($data->stock) }}</td>
                                        <td>{{ thousand_separator($data->minimum_stock) }}</td>
                                        <td>{{ currency_format($data->harga_jual) }}</td>
                                        <td class="align-middle">
                                            <a href="/barangs/{{ $data->id }}/edit" class="badge bg-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="/barangs/{{ $data->id }}" method="POST" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#tableBarang').DataTable({
            responsive: true
            // language: {
            //     url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            //     paginate: {
            //         first: '«',
            //         previous: '‹',
            //         next: '›',
            //         last: '»'
            //     }
            // }
        });
    });
</script>
@endpush
