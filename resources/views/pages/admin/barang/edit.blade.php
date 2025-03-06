@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/barangs/{{ $data->id }}" class="mb-5" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Edit Barang</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Barang Information</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Barang</label>
                                        {{-- <input class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" type="text" placeholder="Kategori" required autofocus value="{{ old('kategori', $data->kategori->nama) }}" > --}}
                                        <select class="form-select" name="kategori">
                                            @foreach ($kategories as $kategori)
                                            @if (old('kategori_id', $post->kategori_id) == $kategori->id)
                                                <option value="{{ $kategori->id }}" selected>{{ $kategori->nama }}</option>
                                            @else
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kode</label>
                                        <input class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" type="text" placeholder="Kode" required autofocus value="{{ old('kode', $data->kode) }}" >
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
                                        <label for="example-text-input" class="form-control-label">Satuan</label>
                                        <input class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" type="text" placeholder="Satuan" required autofocus value="{{ old('satuan', $data->satuan) }}" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Harga Beli</label>
                                        <input class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" type="text" placeholder="Harga Beli" required autofocus value="{{ old('harga_beli', $data->harga_beli) }}" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Harga Jual</label>
                                        <input class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" type="text" placeholder="Harga Jual" required autofocus value="{{ old('harga_jual', $data->harga_jual) }}" >
                                    </div>
                                </div>
                            </div>
                            <button href="{{ route('barangs.create') }}" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
