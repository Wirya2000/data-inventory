@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/users/{{ $data->id }}" class="mb-5" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Edit Karyawan</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Karyawan Information</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control @error('username') is-invalid @enderror" id="username" name="username" type="text" placeholder="Username" required autofocus value="{{ old('username', $data->username) }}" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Password</label>
                                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="text" placeholder="Password" required autofocus value="{{ old('password', $data->password) }}" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="text" placeholder="Email" required autofocus value="{{ old('email', $data->email) }}" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" type="text" placeholder="Nama" required autofocus value="{{ old('nama', $data->nama) }}" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">No Telp</label>
                                        <input class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" type="text" placeholder="no_telp" required autofocus value="{{ old('no_telp', $data->no_telp) }}" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Alamat</label>
                                        <input class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" type="text" placeholder="alamat" required autofocus value="{{ old('alamat', $data->alamat) }}" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Role</label>
                                        {{-- <input class="form-control @error('role') is-invalid @enderror" id="role" name="role" type="text" placeholder="Role" required autofocus value="{{ old('role', $data->alamat) }}" > --}}
                                        <select class="form-select" name="role">
                                            @if (old('role', $data->role) == "admin")
                                                <option value="admin" selected>admin</option>
                                                <option value="kasir">kasir</option>
                                            @elseif (old('role', $data->role) == "kasir")
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
