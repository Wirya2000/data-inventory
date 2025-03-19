{{-- <row>
    <div class="col-md-4">
        <button type="button" class="btn btn-block btn-default mb-3" data-bs-toggle="modal" data-bs-target="#modalAddDetailPembelian">Form</button> --}}
        <div class="modal fade" id="modalAddDetailPembelian" tabindex="-1" role="dialog" aria-labelledby="modalAddDetailPembelian" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                <div class="card-header pb-0 text-left">
                    <h3 class="font-weight-bolder text-info text-gradient">Detail Barang</h3>
                    {{-- <p class="mb-0">Enter your email and password to sign in</p> --}}
                </div>
                <div class="card-body">
                    <form method="" action="" enctype="multipart/form-data" role="form text-left">
                        <label>Kategori Barang</label>
                        <div class="input-group mb-3">
                            {{-- <input type="text" class="form-control" placeholder="Kategori Barang" aria-label="Kategori Barang" aria-describedby="kategori-addon"> --}}
                            <select name="kategori_barang" id="kategori_barang" class="form-control combobox-select2">
                                {{-- <option value="all">Semua Kategori</option> --}}
                            </select>
                        </div>
                        <label>Nama Barang</label>
                        <div class="input-group mb-3">
                            {{-- <input type="text" class="form-control" placeholder="Nama Barang" aria-label="Nama Barang" aria-describedby="nama-addon"> --}}
                            <select name="nama_barang" id="nama_barang" class="form-control combobox-select2">

                            </select>
                        </div>
                        <label>Harga Barang</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Harga Barang" aria-label="Harga Barang" aria-describedby="harga-addon" id="harga_barang">
                        </div>
                        {{-- <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div> --}}
                        <div class="text-center">
                            <button type="button" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0" onclick="updateTableDetailPembelian()">Add Barang</button>
                        </div>
                    </form>
                </div>
                {{-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                    <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="javascript:;" class="text-info text-gradient font-weight-bold">Sign up</a>
                    </p>
                </div> --}}
                </div>
            </div>
            </div>
        </div>
        </div>
    {{-- </div>
    </div>
</row> --}}

@push('js')
    <script>

    </script>
@endpush
