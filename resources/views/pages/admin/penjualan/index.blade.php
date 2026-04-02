@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'List Penjualan'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Penjualan</h6>
                        <a href="{{ route('penjualans.create') }}" class="btn btn-primary">Add Penjualan</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tablePenjualan" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal Beli</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Karyawan</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Customer</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                        {{-- <th class="text-secondary opacity-7"></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->tanggal }}</td>
                                        <td>{{ $data->user->nama }}</td>
                                        <td>{{ $data->customer->nama }}</td>
                                        <td class="align-middle">
                                            {{-- <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                Edit
                                            </a> --}}
                                            <a href="/penjualans/{{ $data->id }}/edit" class="badge bg-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="/penjualans/{{ $data->id }}" method="POST" class="d-inline">
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
        $('#tablePenjualan').DataTable({
            responsive: true
        });
    });
</script>
@endpush
