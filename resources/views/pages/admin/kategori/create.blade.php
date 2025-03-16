@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/kategoris" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Add Kategori</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Kategori Information</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kode Kategori</label>
                                        @error('kode')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="kode" placeholder="Kode" value="{{ old('kode') }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama Kategori</label>
                                        @error('nama')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="nama" placeholder="Nama" value="{{ old('nama') }}">
                                    </div>
                                </div>
                            </div>
                            <button href="{{ route('kategoris.create') }}" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
