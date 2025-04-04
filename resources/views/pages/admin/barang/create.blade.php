@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/barangs" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Add Barang</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Barang Information</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kategori</label>
                                        @error('kategoris_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <input class="form-control" type="text" name="kategori" placeholder="Kategori" {{ old('kategori') }}> --}}
                                        <select class="form-select" name="kategoris_id" title="Kategori" onchange="getKodeBarang(this.value);">
                                            @foreach ($kategoris as $kategori)
                                            @if (old('kategoris_id') == $kategori->id)
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
                                        @error('kode')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="kode" placeholder="Kode" readonly value="{{ $kode }}">
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
                                        <label for="example-text-input" class="form-control-label">Satuan</label>
                                        @error('satuans_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <input class="form-control" type="text" name="satuan" placeholder="Satuan" {{ old('satuan') }}> --}}
                                        <select class="form-select" name="satuans_id" title="Satuan" onchange="getKodeBarang(this.value);">
                                            @foreach ($satuans as $satuan)
                                            @if (old('satuans_id') == $satuan->id)
                                                <option value="{{ $satuan->id }}" selected>{{ $satuan->nama }}</option>
                                            @else
                                                <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Harga Beli</label>
                                        @error('harga_beli')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="harga_beli" placeholder="Harga Beli" value="{{ old('harga_beli') }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Harga Jual</label>
                                        @error('harga_jual')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" type="text" name="harga_jual" placeholder="Harga Jual" value="{{ old('harga_jual') }}">
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

@push('js')
<script>
    function getKodeBarang(kategoris_id) {
        $.ajax({
            type:'GET',
            url:'{{ route("barangs.getKodeBarang") }}',
            data:{ kategoris_id: kategoris_id },
            success: function(response) {
                $('#kode').val(response.kode);
            },
            error: function(xhr) {
                console.error("Error loading modal:", xhr.responseText);
            }
        });
    }
</script>
@endpush
