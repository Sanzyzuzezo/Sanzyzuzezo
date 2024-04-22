@extends('administrator.layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Store</h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.store') }}" class="text-muted text-hover-primary">Store
                            </a>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Detail</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <form id="form_add" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.store.update', $store->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $store->id }}" name="id">
                            <div class="card-body pt-0">
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Nama Store</label>
                                    <input type="text" value="{{ $store->name }}" name="name" class="form-control mb-2" placeholder="Nama Store" value="" disabled/>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Store Code</label>
                                    <input type="text" value="{{ $store->code }}" name="code" class="form-control mb-2" placeholder="Store Code" value="" disabled/>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Email</label>
                                    <input type="email" value="{{ $store->email }}" name="email" class="form-control mb-2" placeholder="Email" value="" disabled/>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">No Telphone / HP</label>
                                    <input type="text" value="{{ $store->phone }}" name="phone" class="form-control mb-2" placeholder="No Telphone / HP" value="" disabled/>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <h4 class="mb-10 fv-row">Detail Alamat Store</h4>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Provinsi</label>
                                    <select name="province_id" id="provinsi-id" class="form-select" disabled>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinces as $province)
                                            @if (isset($store->province_id) && $store->province_id == $province->province_id)
                                                <option selected value="{{ $province->province_id }}">{{ $province->title }}</option>
                                            @else
                                                <option value="{{ $province->province_id }}">{{ $province->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="text-muted fs-7"> </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Kabupaten / Kota</label>
                                    <select name="city_id" id="city-id" class="form-select">
                                        <option value="">Pilih Kabupaten / Kota</option>
                                    </select>
                                    <div class="text-muted fs-7"> </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Kecamatan</label>
                                    <select id="subdistrict-id" name="subdistrict_id" class="form-select">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    <div class="text-muted fs-7"> </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Detail Alamat Store</label>
                                    <textarea name="detail_address" id="detail_address" class="form-control mb-2" disabled>{{ $store->detail_address }}</textarea>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Image</label><br>
                                    {{-- @if ($store->image != '')
                                        <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px; line-height: 150px;">
                                            <img src="{{ url('/administrator/assets/media/stores/'.$store->image) }}" alt="">
                                        </div>
                                    @endif --}}
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px;">
                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-light fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            {{-- <span class="btn btn-light btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="image" disabled>
                                            </span> --}}
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status" {{ $store->status == 1 ? 'checked="checked"' : '' }}  disabled/>
                                        <label class="form-check-label fw-bold text-gray-400 ms-3" for="status">Active</label>
                                    </div>
                                    <div class="text-muted fs-7"></div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label required">Warehouse</label>
                                    {{-- <div class="d-flex justify-content-end">
                                        <a href="#" class="btn btn-sm btn-primary" id="ingrdnts" data-bs-toggle="modal" data-bs-target="#items-data" >
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"
                                                    fill="none">
                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                        transform="rotate(-90 11.364 20.364)" fill="black" />
                                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                                </svg>
                                            </span>
                                            Select Warehouse
                                        </a>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="warehouse_table">
                                                <thead>
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="w-20px pe-2">
                                                            No
                                                        </th>
                                                        <th class="min-w-100px">Code</th>
                                                        <th class="min-w-100px">Name</th>
                                                        {{-- <th class="min-w-40px">Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600" id="get-item-data">
                                                    <?php $no=1; ?>
                                                    @foreach ($store_detail as $row)
                                                        <tr id="{{ $row->id }}">
                                                            <input type="hidden" name="warehouse[{{ $no }}][id]" value="{{ $row->id }}" data-id/>
                                                            <td>{{ $no }}</td>
                                                            <td>{{ $row->code }}</td>
                                                            <td>
                                                                {{ $row->name }}
                                                                <input type="hidden" name="warehouse[{{ $no }}][warehouse_id]" value="{{ $row->warehouse_id }}">
                                                            </td>
                                                              {{-- <td>
                                                              <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary delete_item" data-id="{{$row->id}}" id="delete-ix{{ $row->id }}" data-bs-toggle="tooltip" data-bs-placement="top" >  
                                                                    <span class="svg-icon svg-icon-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </td>--}}
                                                        </tr>
                                                        <?php $no++ ?>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" class="warehouse-data" name="warehouse_data" value="{{ $no }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.store') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                            {{-- <button type="submit" id="add_post_category_submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="items-data" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mw-650px">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y pt-0 pb-5">
                    <div class="text-center mb-5">
                        <h2>Browse Warehouse</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="warehouse_data_table">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Code</th>
                                        <th class="min-w-100px">Name</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400">
                                    @foreach ($warehouse as $row)
                                        <tr>
                                            <td>
                                                <input class="form-check-input item_warehouse" id="ing-{{ $row->id }}" type="checkbox" value="{{ $row->id }}" disabled/>
                                            </td>
                                            <td class="min-w-100px"><label for="ing-{{ $row->id }}">{{ $row->code }}</label></td>
                                            <td class="min-w-100px"><label for="ing-{{ $row->id }}">{{ $row->name }}</label></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="#" class="btn btn-primary" id="selectData-warehouse">Select</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/store/store.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    {{-- <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script> --}}
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    {{-- <script src="{{ asset_administrator('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script> --}}

    <script>
    function getCity(params, current_id = null) {
        let province_id = params;
        let actionUrl = `{{ route('getCities') }}`;
        $("#city-id").find('option').not(':first').remove();
        if (province_id != "") {
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    province_id: province_id
                },
                success: function(data) {
                    const list = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                    const cities = list.rajaongkir.results;
                    cities.forEach(index => {
                        if (current_id != null && index.city_id == current_id) {
                            let city_option = `<option selected value="${index.city_id}">${index.type} ${index.city_name}</option>`;
                            $("#city-id").append(city_option);

                        } else {
                            let city_option = `<option value="${index.city_id}">${index.type} ${index.city_name}</option>`;
                            $("#city-id").append(city_option);

                        }
                    });

                    $("#city-id").attr("disabled", true);
                    $("#city-id").css("background-color", "#FFFF").css("cursor", "pointer");

                    $("#subdistrict-id").attr("disabled", true);
                    $("#subdistrict-id").css("background-color", "#e9e7e7").css("cursor", "not-allowed");

                }
            });
        } else {

            $("#city-id").attr("disabled", true);
            $("#city-id").css("background-color", "#e9e7e7").css("cursor", "not-allowed");

            $("#subdistrict-id").attr("disabled", true);
            $("#subdistrict-id").css("background-color", "#e9e7e7").css("cursor", "not-allowed");

        }
    }

    function getKecamatan(params, current_id = null) {
        let city_id = params;
        let actionUrl = `{{ route('getKecamatan') }}`;
        $("#subdistrict-id").find('option').not(':first').remove();
        if (city_id != "") {
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    city_id: city_id
                },
                success: function(data) {
                    const subdistrict = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                    const subdistricts = subdistrict.rajaongkir.results;
                    subdistricts.forEach(index => {
                        if (current_id != null && index.subdistrict_id == current_id) {
                            let subdistrict_option = `<option selected value="${index.subdistrict_id}">${index.subdistrict_name}</option>`;
                            $("#subdistrict-id").append(subdistrict_option);

                        } else {
                            let subdistrict_option = `<option value="${index.subdistrict_id}">${index.subdistrict_name}</option>`;
                            $("#subdistrict-id").append(subdistrict_option);

                        }
                    });

                    $("#subdistrict-id").attr("disabled", true);
                    $("#subdistrict-id").css("background-color", "#FFFF").css("cursor", "pointer");

                }
            });
        } else {

            $("#subdistrict-id").attr("disabled", true);
            $("#subdistrict-id").css("background-color", "#e9e7e7").css("cursor", "not-allowed");

        }
    }

    // $('#provinsi-id').on('change', function (e) {
    //     e.stopImmediatePropagation();
    //     let province_id = $(this).val();
    //     getCity(province_id);
    // });

    // $('#city-id').on('change', function (e) {
    //     e.stopImmediatePropagation();
    //     let city_id = $(this).val();
    //     getKecamatan(city_id);
    // });
    </script>

    @isset($store)
    <script>
        let province_id = `{!! $store->province_id !!}`;
        let city_id = `{!! $store->city_id !!}`;
        let subdistrict_id = `{!! $store->subdistrict_id !!}`;
        getCity(province_id, city_id);
        getKecamatan(city_id, subdistrict_id);
        let image_url = `{{ url('/administrator/assets/media/stores/'.$store->image) }}`;
        $('.fileinput-preview').html(`<img src="${image_url}" alt="">`)

    </script>
    @endisset

    <script type="text/javascript">
        $(document).ready(function() {
            class MyUploadAdapter {
                constructor(loader) {
                    // CKEditor 5's FileLoader instance.
                    this.loader = loader;

                    // URL where to send files.
                    this.url = 'https://example.com/image/upload/path';
                }

                // Starts the upload process.
                upload() {
                    return new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject);
                        this._sendRequest();
                    });
                }

                // Aborts the upload process.
                abort() {
                    if (this.xhr) {
                        this.xhr.abort();
                    }
                }

                // Example implementation using XMLHttpRequest.
                _initRequest() {
                    const xhr = this.xhr = new XMLHttpRequest();

                    xhr.open('POST', this.url, true);
                    xhr.responseType = 'json';
                }

                // Initializes XMLHttpRequest listeners.
                _initListeners(resolve, reject) {
                    const xhr = this.xhr;
                    const loader = this.loader;
                    const genericErrorText = 'Couldn\'t upload file:' + ` ${ loader.file.name }.`;

                    xhr.addEventListener('error', () => reject(genericErrorText));
                    xhr.addEventListener('abort', () => reject());
                    xhr.addEventListener('load', () => {
                        const response = xhr.response;

                        if (!response || response.error) {
                            return reject(response && response.error ? response.error.message :
                                genericErrorText);
                        }

                        // If the upload is successful, resolve the upload promise with an object containing
                        // at least the "default" URL, pointing to the image on the server.
                        resolve({
                            default: response.url
                        });
                    });

                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', evt => {
                            if (evt.lengthComputable) {
                                loader.uploadTotal = evt.total;
                                loader.uploaded = evt.loaded;
                            }
                        });
                    }
                }

                // Prepares the data and sends the request.
                _sendRequest() {
                    const data = new FormData();

                    data.append('upload', this.loader.file);

                    this.xhr.send(data);
                }
            }

            function MyCustomUploadAdapterPlugin(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return new MyUploadAdapter(loader);
                };
            }

        });
    </script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('#warehouse_data_table').DataTable();

            $('#selectData-warehouse').off().on('click', function (e) {
                var no = $('#warehouse_table').find('tr').length;
                $('.warehouse-data').val(no);
                $('#warehouse_data_table').find('input[type="checkbox"]:checked').each(function(i){
                    var number = $('#warehouse_table').find('tr').length;
                    var id = $(this).val();
                    
                    $.ajax({
                        url: "{{ route('admin.store.item-data') }}",
                        data: { 'id' : id },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function (data) {
                            console.log(data)
                            if($('#'+id).length == 0){
                                $('#get-item-data').append('<tr id="'+id+'"><td>'+number+'</td><td>'+data.code+'</td><td>'+data.name+'<input type="hidden" name="warehouse['+number+'][warehouse_id]" value="'+data.id+'"></td><td><a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" id="delete'+id+'" data-bs-toggle="tooltip" data-bs-placement="top"><span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" /></svg></span></a></td></tr>');
                            }
                        }
                    });
                    $('#delete'+id).off().on('click', function (e) {
                        $("#"+id).remove();
                    });

                });
        		$('#items-data').modal('hide');
                $(".item_warehouse").prop('checked', false);
                e.preventDefault();

            });

            // $(".delete_item").off().on('click', function(){
            //     id = $(this).data('id');                
            //     $("#"+id).remove();
            // })
        });

        $('.delete_item').on('click', function (e) {
            e.preventDefault();
            const id = $(this).data('id'); // Perlu di deklarasikan variabel id

            Swal.fire({
                title: 'Konfirmasi',
                text: "Hapus row yang dipilih ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan permintaan AJAX untuk menghapus item
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.store.deleteDetail') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": 'DELETE',
                            id: id,
                        },
                        success: function(response) {
                            // Tindakan yang diambil jika permintaan berhasil
                            if (response.success) {
                                // Hapus elemen HTML dengan ID yang sesuai
                                $("#" + id).remove();
                                Swal.fire('Berhasil!', 'Row berhasil dihapus !', 'success');
                            } else {
                                Swal.fire('Gagal!', 'Gagal menghapus row.', 'error');
                            }
                        },
                        error: function(error) {
                            Swal.fire('Error!', 'Terjadi kesalahan saat menghapus row.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush