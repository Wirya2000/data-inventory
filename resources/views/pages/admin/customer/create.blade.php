@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/customers" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Add Customer</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Customer Information</p>
                            <div class="row">
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
                                        <label for="example-text-input" class="form-control-label">Alamat</label>
                                        @error('alamat')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="alamat" placeholder="Alamat" value="{{ old('alamat') }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">No Telp</label>
                                        @error('no_telp')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="no_telp" placeholder="No Telp" value="{{ old('no_telp') }}">
                                    </div>
                                </div>
                            </div>
                            <button href="{{ route('customers.create') }}" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
