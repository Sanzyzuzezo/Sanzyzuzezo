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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">User Admins</h1>
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
                            <a href="{{ route('admin.user-admins') }}" class="text-muted text-hover-primary">User Admins</a>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Edit</li>
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
                <form id="form_add" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.user-admins.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
                    <input type="hidden" name="id" class="form-control mb-2" placeholder="ID" value="{{ $edit->id }}" />
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">User Group</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="user_group" class="form-select" data-control="select2">
                                        <option value="">Please Select</option>
                                        @foreach ($user_groups as $row)
                                            {
                                            <option value="{{ $row->id }}" {{ $row->id == $edit->user_group_id ? 'selected' : '' }}> {{ $row->name }} </option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="name" class="form-control mb-2" placeholder="Name"
                                        value="{{ $edit->name }}" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">E-mail</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="email" class="form-control mb-2" placeholder="E-mail"
                                        value="{{ $edit->email }}" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Password</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="password" name="password" class="form-control mb-2" placeholder="Password"
                                        value="" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Password Confirmation</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="password" name="password_confirmation" class="form-control mb-2"
                                        placeholder="Password Confirmation" value="" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                {{-- <div class="mb-10 fv-row">
                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                        <input class="form-check-input cashier" type="checkbox" name="cashier" id="cashier" value="1" {{ $edit->cashier != 0 ? 'checked' : '' }}/>
                                        <label class="form-check-label" for="cashier">Is Cashier?</label>
                                    </div>
                                </div>
                                <div class="mb-10 fv-row {{ $edit->cashier != 0 ? '' : 'd-none' }}" id="store">
                                    <label class="form-label required">Store</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="hidden" name="store_id" class="form-control store_id" value="{{ $edit->cashier != 0 ? '$edit->cashier' : '' }}"/>
                                            <input type="text" name="store_name" class="form-control store_name" placeholder="Store Name" value="{{ $edit->store_name }}" readonly/>
                                        </div>
                                        <div class="col-auto store-modal">
                                            <a href="#" class="btn btn-sm btn-primary" id="store-data">
                                                <span class="svg-icon svg-icon-2 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="white"/>
                                                        <path opacity="0.5" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="white"/>
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                        <input class="form-check-input warehouse_pic" type="checkbox" name="warehouse_pic" id="warehouse_pic" value="1" {{ $edit->warehouse_pic != 0 ? 'checked' : '' }}/>
                                        <label class="form-check-label" for="warehouse_pic">Is Warehouse PIC?</label>
                                    </div>
                                </div>
                                <div class="mb-10 fv-row {{ $edit->warehouse_pic != 0 ? '' : 'd-none' }}" id="warehouse">
                                    <label class="form-label required">Warehouse</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="hidden" name="warehouse_id" class="form-control warehouse_id" value="{{ $edit->warehouse_pic != 0 ? '$edit->warehouse_pic' : '' }}"/>
                                            <input type="text" name="warehouse_code" class="form-control warehouse_code" placeholder="Warehouse Code" value="{{ $edit->warehouse_code }}" readonly/>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="warehouse_name" class="form-control warehouse_name" placeholder="Warehouse Name" value="{{ $edit->warehouse_name }}" readonly/>
                                        </div>
                                        <div class="col-auto warehouse-modal">
                                            <a href="#" class="btn btn-sm btn-primary" id="warehouse-data">
                                                <span class="svg-icon svg-icon-2 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="white"/>
                                                        <path opacity="0.5" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="white"/>
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div> --}}
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status"
                                            {{ $edit->status ? 'checked="checked"' : '' }} />
                                        <label class="form-check-label fw-bold text-gray-400 ms-3"
                                            for="status">Active</label>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.user-admins') }}" id="kt_ecommerce_add_user_group_cancel"
                                class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_ecommerce_add_user_admins_submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    
    <div class="modal fade" id="store-data-modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y pt-0 pb-5">
                    <div class="text-center mb-5">
                        <h2>Browse Store</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search" id="searchStoreTable" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="dataStore">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th>No</th>
                                        <th class="min-w-100px">Name</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-store">Select</button>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    
    <div class="modal fade" id="warehouse-data-modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y pt-0 pb-5">
                    <div class="text-center mb-5">
                        <h2>Browse Warehouse</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search" id="searchWarehouseTable" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="dataWarehouse">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th>No</th>
                                        <th class="min-w-70px">Code</th>
                                        <th class="min-w-100px">Name</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-warehouse">Select</button>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    {{-- <script src="{{ asset_administrator('assets/js/custom/user_admins.js') }}"></script> --}}
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(".cashier").change(function() {
            if(this.checked) {
                $('#store').removeClass('d-none');
                console.log('tes');
                validator.addField("store_id", {
                    validators: {
                        notEmpty: {
                            message: 'Store is required'
                        }
                    }
                });
            }else{
                $('#store').addClass('d-none');
            }
        });

        // get data store
        $('#store-data').off().on('click', function () {
            getStore();
            $('#store-data-modal').modal('show');
        });

        function getStore() {
            $('#searchStoreTable').keyup(function(){
                $('#dataStore').DataTable().search($(this).val()).draw();
            });
            $("#dataStore").DataTable().destroy();
            $('#dataStore tbody').remove();
            $('#dataStore').DataTable({
                "searching": true,
                "regex": true,
                "dom": 'lrtip',
                "pagingType": "full_numbers",
                "order": [[0, "desc"]],
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": "<i class='ti-angle-left'></i>",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": "<i class='ti-angle-right'></i>"
                    }
                },
                "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                "language": {
                    "lengthMenu": "_MENU_"
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.user-admins.store-data') }}",
                    "dataType": "JSON",
                    "type": "GET",
                    "data": {
                        datatable: true,
                    },
                },
                'select': {
                    'style': 'single'
                },
                "columns": [
                    {
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    { "data": "name" },
                ]

            });

            var table_store = $('#dataStore').DataTable();

            $('#selectData-store').on('click', function (e, dt, node, config) {
                var rows_selected = table_store.rows( { selected: true } ).data();
                // console.log(rows_selected[0]);
                
                if(rows_selected[0] != undefined){
                    $(".store_id").val(rows_selected[0]['id']);
                    $(".store_name").val(rows_selected[0]['name']);
                }

        		$('#store-data-modal').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });
        }
        
        $(".warehouse_pic").change(function() {
            if(this.checked) {
                $('#warehouse').removeClass('d-none');
                validator.addField("warehouse_id", {
                    validators: {
                        notEmpty: {
                            message: 'Warehouse is required'
                        }
                    }
                });
            }else{
                $('#warehouse').addClass('d-none');
            }
        });

        // get data warehouse
        $('#warehouse-data').off().on('click', function () {
            getWarehouse();
            $('#warehouse-data-modal').modal('show');
        });

        function getWarehouse() {
            $('#searchWarehouseTable').keyup(function(){
                $('#dataWarehouse').DataTable().search($(this).val()).draw();
            });
            $("#dataWarehouse").DataTable().destroy();
            $('#dataWarehouse tbody').remove();
            $('#dataWarehouse').DataTable({
                "searching": true,
                "regex": true,
                "dom": 'lrtip',
                "pagingType": "full_numbers",
                "order": [[0, "desc"]],
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": "<i class='ti-angle-left'></i>",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": "<i class='ti-angle-right'></i>"
                    }
                },
                "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                "language": {
                    "lengthMenu": "_MENU_"
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.user-admins.warehouse-data') }}",
                    "dataType": "JSON",
                    "type": "GET",
                    "data": {
                        datatable: true,
                    },
                },
                'select': {
                    'style': 'single'
                },
                "columns": [
                    {
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    { "data": "code" },
                    { "data": "name" },
                ]

            });

            var table_warehouse = $('#dataWarehouse').DataTable();

            $('#selectData-warehouse').on('click', function (e, dt, node, config) {
                var rows_selected = table_warehouse.rows( { selected: true } ).data();
                // console.log(rows_selected[0]);
                
                if(rows_selected[0] != undefined){
                    $(".warehouse_id").val(rows_selected[0]['id']);
                    $(".warehouse_code").val(rows_selected[0]['code']);
                    $(".warehouse_name").val(rows_selected[0]['name']);
                }

        		$('#warehouse-data-modal').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });
        }

                 // validasi 
         const form = document.getElementById('form_add');

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'user_group': {
                        validators: {
                            notEmpty: {
                                message: 'Please select user group'
                            }
                        }
                    },
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Name is required'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: "E-mail is required",
                            },
                            remote: {
                                message: 'The email is already taken',
                                method: 'POST',
                                url: '{{ route('admin.user-admins.isExistEmail') }}',
                                data: function () {
                                    return {
                                        _token: '{{ csrf_token() }}',
                                        email: $('#email').val(),
                                    };
                                },
                            },
                        },
                    },            
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            },
                            stringLength: {
                                min: 8,
                                message: 'Password must be at least 8 characters long',
                            },
                        }
                    },
                    'password_confirmation': {
                        validators: {
                            notEmpty: {
                                message: 'Password confirmation is required'
                            },
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same',
                            },
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Submit button handler
        const submitButton = document.getElementById('kt_ecommerce_add_user_admins_submit');
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        setTimeout(function () {
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;

                            form.submit(); // Submit form
                        }, 2000);
                    }
                });
            }
        });
</script>
@endpush
