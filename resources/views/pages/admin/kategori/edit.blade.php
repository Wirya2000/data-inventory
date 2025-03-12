@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/kategoris/{{ $data->id }}" class="mb-5" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Edit Kategori</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Kategori Information</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kode Kategori</label>
                                        <input class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" type="text" placeholder="Kode" required autofocus value="{{ old('kode', $data->kode) }}" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama Kategori</label>
                                        <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" type="text" placeholder="Nama" required autofocus value="{{ old('nama', $data->nama) }}" >
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
