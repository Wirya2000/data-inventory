@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/users" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Add Karyawan</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Karyawan Information</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        @error('username')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="username" placeholder="Username" value="{{ old('username') }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email</label>
                                        @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama</label>
                                        @error('nama')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="nama" placeholder="Nama" value="{{ old('nama') }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">No_telp</label>
                                        @error('no_telp')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="no_telp" placeholder="No_telp" value="{{ old('no_telp') }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Alamat</label>
                                        @error('alamat')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="alamat" placeholder="Alamat" value="{{ old('alamat') }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Role</label>
                                        @error('role')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <input class="form-control" type="text" name="role" placeholder="Role" {{ old('role') }}> --}}
                                        <select class="form-select" name="role">
                                            @if (old('role') == "admin")
                                                <option value="admin" selected>admin</option>
                                                <option value="kasir">kasir</option>
                                            @elseif (old('role') == "kasir")
                                                <option value="admin">admin</option>
                                                <option value="kasir" selected>kasir</option>
                                            @else
                                                <option value="admin">admin</option>
                                                <option value="kasir">kasir</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button href="{{ route('users.create') }}" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
