@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'List Karyawan'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Karyawan</h6>
                        <a href="{{ route('users.create') }}" class="btn btn-primary">Add Karyawan</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tableKaryawan" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Username</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No Telp</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Alamat</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Role</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                        {{-- <th class="text-secondary opacity-7"></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->username }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->no_telp }}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>{{ $data->role }}</td>
                                        <td class="align-middle">
                                            {{-- <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                Edit
                                            </a> --}}
                                            <a href="/users/{{ $data->id }}/edit" class="badge bg-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="/users/{{ $data->id }}" method="POST" class="d-inline">
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
        $('#tableKaryawan').DataTable({
            responsive: true
        });
    });
</script>
@endpush
