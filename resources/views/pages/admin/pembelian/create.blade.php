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
                                <h5 class="mb-0">Add Pembelian</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Pembelian Information</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tanggal Pembelian</label>
                                        @error('tanggal_beli')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <input class="form-control" type="text" name="tanggal_beli" placeholder="tanggal_beli" {{ old('tanggal_beli') }}> --}}
                                        <input type="date" id="tanggal_beli" name="tanggal_beli" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Karyawan</label>
                                        @error('kategori')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <input class="form-control" type="text" name="kategori" placeholder="Kategori" {{ old('kategori') }}> --}}
                                        <select class="form-select" name="user">
                                            @foreach ($users as $user)
                                            @if (old('user_id') == $user->id)
                                                <option value="{{ $user->id }}" selected>{{ $user->nama }}</option>
                                            @else
                                                <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Supplier</label>
                                        @error('kategori')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <input class="form-control" type="text" name="kategori" placeholder="Kategori" {{ old('kategori') }}> --}}
                                        <select class="form-select" name="supplier">
                                            @foreach ($suppliers as $supplier)
                                            @if (old('supplier_id') == $supplier->id)
                                                <option value="{{ $supplier->id }}" selected>{{ $supplier->nama }}</option>
                                            @else
                                                <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card mb-4">
                                        <div class="card-header pb-0">
                                            <h6>Pembelian</h6>
                                            <a class="btn btn-primary"  href="javascript:void(0);" onclick="getAddDetailPembelian()">Add Pembelian</a>
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
                                                                Tanggal</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Karyawan</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Supplier</th>
                                                            <th class="text-secondary opacity-7"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- @foreach ($datas as $data) --}}
                                                        {{-- <tr>
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div class="d-flex flex-column justify-content-center">
                                                                        <p class="text-xs text-primary mb-0">{{ $loop->iteration }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div class="d-flex flex-column justify-content-center">
                                                                        <p class="text-xs text-primary mb-0">{{ $data->tanggal }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div class="d-flex flex-column justify-content-center">
                                                                        <p class="text-xs text-primary mb-0">{{ $data->user->nama }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div class="d-flex flex-column justify-content-center">
                                                                        <p class="text-xs text-primary mb-0">{{ $data->supplier->nama }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle"> --}}
                                                                {{-- <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                                    Edit
                                                                </a> --}}
                                                                {{-- <a href="/pembelians/{{ $data->id }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                                                                <form action="/pembelians/{{ $data->id }}" method="POST" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><span data-feather="x-circle"></span></button>
                                                                </form>
                                                            </td>
                                                        </tr> --}}
                                                        {{-- @endforeach --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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

@push('js')
    <script>
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
                },
                error: function(xhr) {
                    console.error("Error loading modal:", xhr.responseText);
                }
            });
        }

        function updateTableDetailPembelian() {
            var formEl = document.forms.createForm;
            var formData = new FormData(formEl);
            $.ajax({
                type:'POST',
                url:'{{ route("pembelians.addDetailPembelian") }}',
                data:'_token= <?php echo csrf_token() ?>',
                success: function(data){
                if (data.status==200){
                    var newData = `<tr id="tr_`+data.id+`">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-primary mb-0">{{ $loop->iteration }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td id="td_kode_`+data.id+`">
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-primary mb-0">`+formData.get('kode')+`</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td id="td_nama_`+data.id+`">
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-primary mb-0">`+formData.get('nama')+`</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td id="td_price_`+data.id+`">
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-primary mb-0">`+formData.get('price')+`</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td id="td_discount_`+data.id+`">
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-primary mb-0">`+formData.get('discount')+`</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td id="td_quantity_`+data.id+`">
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-primary mb-0">`+formData.get('quantity')+`</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td id="td_subtotal_`+data.id+`">
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-primary mb-0">`+formData.get('subtotal')+`</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <a href="/pembelians/{{ $data->id }}/edit" class="badge bg-warning"><span data-feather="edit"></span></a>
                                        <form action="/pembelians/{{ $data->id }}" method="POST" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><span data-feather="x-circle"></span></button>
                                        </form>
                                    </td>
                                </tr>`

                    $('#table-body').append(newData);
                }
                clearInput();
                $('#pesan').show();
                $('#pesan').html(data.msg);
                setTimeout(function() {
                    $("#pesan").hide();
                }, 5000);

                $('body').removeClass('modal-open');
                $('#modalCreate').modal('hide');
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
                }else{
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
    </script>
@endpush
