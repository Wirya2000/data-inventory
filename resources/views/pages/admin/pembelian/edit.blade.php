@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    {{-- <div class="card shadow-lg mx-4 card-profile-bottom"> --}}
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/pembelians" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Edit Pembelian</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Pembelian Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tanggal Pembelian</label>
                                        @error('tanggal_beli')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <input class="form-control" type="text" name="tanggal_beli" placeholder="tanggal_beli" {{ old('tanggal_beli') }}> --}}
                                        <input type="date" id="tanggal_beli" name="tanggal_beli" class="form-control" value="{{ old('tanggal_beli', $data->tanggal_beli) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Karyawan</label>
                                        @error('kategori')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <input class="form-control" type="text" name="kategori" placeholder="Kategori" {{ old('kategori') }}> --}}
                                        <select class="form-select" name="users_id">
                                            @foreach ($users as $user)
                                            @if (old('users_id', $user->id) == $data->users_id)
                                                <option value="{{ $user->id }}" selected>{{ $user->nama }}</option>
                                            @else
                                                <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Supplier</label>
                                        @error('kategori')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <input class="form-control" type="text" name="kategori" placeholder="Kategori" {{ old('kategori') }}> --}}
                                        <select class="form-select" name="suppliers_id">
                                            @foreach ($suppliers as $supplier)
                                            @if (old('suppliers_id') == $supplier->id)
                                                <option value="{{ $supplier->id }}" selected>{{ $supplier->nama }}</option>
                                            @else
                                                <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mb-4 max-height">
                                        <div class="card-header pb-0">
                                            <h6>Detail Barang</h6>
                                            <a class="btn btn-primary"  href="javascript:void(0);" onclick="getAddDetailPembelian();">Add Detail</a>
                                            <div id="modalContainer"></div>
                                        </div>
                                        <div class="card-body px-0 pt-0 pb-2">
                                            <div class="table-responsive p-0">
                                                <table class="table align-items-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                No</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Kode Barang</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Nama Barang</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Harga</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Quantity</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Subtotal</th>
                                                            <th class="text-secondary opacity-7"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body">
                                                        @foreach($data->barangs as $i => $barang)
                                                            <tr id="tr_{{ $barang->id }}">
                                                                <td>
                                                                    <div class="d-flex px-2 py-1">
                                                                        <div class="d-flex flex-column justify-content-center">
                                                                            <p class="text-xs text-primary mb-0">{{ $i+1 }}</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td id="td_kode_{{ $barang->id }}">
                                                                    <div class="d-flex px-2 py-1">
                                                                        <div class="d-flex flex-column justify-content-center">
                                                                            <p class="text-xs text-primary mb-0">{{ $barang->kode }}</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td id="td_nama_{{ $barang->id }}">
                                                                    <div class="d-flex px-2 py-1">
                                                                        <div class="d-flex flex-column justify-content-center">
                                                                            <p class="text-xs text-primary mb-0">{{ $barang->nama }}</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td id="td_price_{{ $barang->id }}">
                                                                    <div class="d-flex px-2 py-1">
                                                                        <div class="d-flex flex-column justify-content-center">
                                                                            <p class="text-xs text-primary mb-0">{{ number_format($barang->pivot->harga_satuan, 0, ',', '.') }}</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td id="td_quantity_{{ $barang->id }}">
                                                                    <div class="d-flex px-2 py-1">
                                                                        <div class="d-flex flex-column justify-content-center">
                                                                            <input class="form-control"
                                                                                type="text"
                                                                                name="jumlah[{{ $barang->id }}]"
                                                                                id="input_jumlah_{{ $barang->id }}"
                                                                                placeholder="Jumlah"
                                                                                data-barang-id="{{ $barang->id }}"
                                                                                data-harga="{{ $barang->pivot->harga_satuan }}"
                                                                                value="{{ $barang->pivot->jumlah }}">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td id="td_subtotal_{{ $barang->id }}">
                                                                    <div class="d-flex px-2 py-1">
                                                                        <div class="d-flex flex-column justify-content-center">
                                                                            <p class="text-xs" id="subtotal_{{ $barang->id }}">
                                                                                {{ number_format(($barang->pivot->jumlah*$barang->pivot->harga_satuan), 0, ',', '.') }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <button type="button" class="badge bg-danger border-0"
                                                                            onClick="deleteBarang({{ $barang->id }})"
                                                                            data-id="{{ $barang->id }}">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5"><strong>Total</strong></td>
                                                            <td><strong id="total_amount">0</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
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
        // $(document).ready(function() {
            function getAddDetailPembelian() {
                $.ajax({
                    type:'POST',
                    url:'{{ route("pembelians.showAddDetailPembelian") }}',
                    data:'_token= <?php echo csrf_token() ?>',
                    success: function(response) {
                        // Ensure we extract the modal content if it's inside 'msg'
                        let modalHtml = response.msg ? response.msg : response;

                        // Inject the modal into the page
                        $('#modalContainer').html(modalHtml);

                        // Show the modal using Bootstrap's modal function
                        $('#modalAddDetailPembelian').modal('show');
                        dataKategoriBarang();
                    },
                    error: function(xhr) {
                        console.error("Error loading modal:", xhr.responseText);
                    }
                });
            }

            // $('.combobox-select2').select2();
            function dataKategoriBarang() {
                $.ajax({
                    type:'GET',
                    url:'{{ route("getDataKategoriBarang") }}',
                    data:'_token= <?php echo csrf_token() ?>',
                    success: function(data){
                        if (data.status==200){
                            var newData = `<option value="-">Pilih Kategori Barang</option>`;
                            data.message.forEach(d => {
                                newData += `<option value="`+d.id+`">`+d.nama+`</option>`
                            });
                            $('#kategori_barang').html(newData);
                        }
                    },
                    error: function(xhr){
                    }
                    });
            }

            function getDataListBarang(kategori_id) {
                $.ajax({
                    type:'GET',
                    url:'{{ route("getDataListBarang") }}',
                    data:{
                        _token: '<?php echo csrf_token() ?>',
                        kategori_id: kategori_id
                    },
                    success: function(data){
                        if (data.status==200){
                            var newData = `<option value="-">Pilih Barang</option>`;
                            data.message.forEach(d => {
                                newData += `<option value="`+d.id+`" onchange="updateBarangPrice(`+d.id+`)">`+d.nama+`</option>`
                            });
                            $('#nama_barang').html(newData);
                        }
                    },
                    error: function(xhr){
                    }
                });
            }

            function updateTableDetailPembelian() {
                var formEl = document.forms.addDetailForm;
                var formData = new FormData(formEl);
                $.ajax({
                    type:'POST',
                    url: `{{ url('pembelians/addDetailPembelian') }}/${document.getElementById('nama_barang').value}`,
                    data:'_token= <?php echo csrf_token() ?>',
                    success: function(data){
                        if (data.status==200){
                            if (data.message == "Item added to cart!") {
                                var d = data.data;
                                var newData = `<tr id="tr_`+d.id+`">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-xs text-primary mb-0">1</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="td_kode_`+d.id+`">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-xs text-primary mb-0">`+d.kode+`</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="td_nama_`+d.id+`">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-xs text-primary mb-0">`+d.nama+`</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="td_price_`+d.id+`">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-xs text-primary mb-0">`+d.harga_beli.toLocaleString()+`</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="td_quantity_`+d.id+`">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <input class="form-control" type="text" name="input_jumlah_`+ d.id +`" id="input_jumlah_`+ d.id +`" placeholder="Jumlah" data-barang-id="` + d.id + `" data-harga="` + d.harga_beli + `" value="1">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="td_subtotal_`+d.id+`">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-xs" id="subtotal_` + d.id + `" text-primary mb-0">`+d.harga_beli.toLocaleString()+`</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <button type="button" class="badge bg-danger border-0" onClick="deleteBarang(` + d.id + `)" data-id="` + d.id + `">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>`;
                                $('#table-body').append(newData);
                                calculateTotal();
                            } else {
                                let d = data.data;
                                $(`#input_jumlah_${d.id}`).val(d.jumlah);
                                let subtotal = d.jumlah * d.harga_beli;
                                $(`#subtotal_${d.id}`).html(subtotal.toLocaleString());
                            }
                            // clearInput();
                            $('#pesan').show();
                            $('#pesan').html(data.msg);
                            setTimeout(function() {
                                $("#pesan").hide();
                            }, 5000);

                            // $('body').removeClass('modal-open');
                            $('#modalAddDetailPembelian').modal('hide');
                            $('#modalCreate').modal('hide');

                        }
                    },
                    error: function(xhr){
                        if (xhr.status == 422){
                            data = JSON.parse(xhr.responseText);
                            clearError("modalCreate");
                            for (var k in data.errors){
                                $("#modalCreate .alert ul").append(`<li>`+data.errors[k][0]+`</li>`);
                            }
                            $("#modalCreate .alert").show();
                            const element = document.getElementById("modalCreate").getElementsByClassName("alert")[0];
                            element.scrollIntoView();
                        } else{
                            data = JSON.parse(xhr.responseText);
                            $('#error').show();
                            $('#error').html(data.msg);
                            setTimeout(function() {
                                $("#error").hide();
                            }, 5000);
                            $('body').removeClass('modal-open');
                        }
                    }
                });
            }

            function updateHarga(barang_id) {
                $.ajax({
                    type:'GET',
                    url:`{{ url("pembelians/getDataHargaBeli") }}/${document.getElementById('nama_barang').value}`,
                    data:{
                        _token: '<?php echo csrf_token() ?>',
                        barang_id: barang_id
                    },
                    success: function(data){
                        if (data.status==200){
                            let d = data.message;
                            $('#harga_barang').val(d.toLocaleString());
                        }
                    },
                    error: function(xhr){
                    }
                });
            }

            function deleteBarang(barang_id) {
                $.ajax({
                    type:'DELETE',
                    url:'removeFromCart/' + barang_id,
                    data:{
                        _token: '<?php echo csrf_token() ?>',
                    },
                    success: function(data){
                        if (data.status==200){
                            let d = data.message;
                            // $('#harga_barang').val(d.toLocaleString());
                            $('#tr_' + barang_id).remove();
                            calculateTotal();
                        }
                    },
                    error: function(xhr){
                        // ambil message error dari server
                        let res = xhr.responseJSON;
                        if (res && res.msg) {
                            alert("Error: " + res.msg);
                        } else {
                            alert("Terjadi kesalahan pada server");
                        }
                    }
                });
            }

            $(document).on('change', 'input[id^="input_jumlah_"]', function () {
                let jumlah = $(this).val(); // Get new jumlah value
                let barang_id = $(this).data('barang-id'); // Get barang ID
                let harga_satuan = $(this).data('harga'); // Get harga

                if (jumlah < 1) {
                    jumlah = 1; // Prevent negative values
                    $(this).val(1);
                }

                // Send AJAX request to update backend
                $.ajax({
                    type: 'POST',
                    url: '{{ route("pembelians.updateJumlah") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        barang_id: barang_id,
                        jumlah: jumlah
                    },
                    success: function (response) {
                        console.log('Jumlah updated:', response);
                        let total_harga = jumlah * harga_satuan; // Calculate new total price
                        $('#subtotal_' + barang_id).text(total_harga.toLocaleString()); // Update UI
                        calculateTotal();
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr);
                    }
                });
            });

            function calculateTotal() {
                let total = 0;
                let harga = 0;
                document.querySelectorAll("[id^='subtotal_']").forEach(cell => {
                    harga = parseFloat(cell.textContent.replace(/\./g, ''), 10);
                    total += harga;
                });
                document.getElementById("total_amount").textContent = total.toLocaleString();
            }

            calculateTotal();
        // });
    </script>
@endpush
