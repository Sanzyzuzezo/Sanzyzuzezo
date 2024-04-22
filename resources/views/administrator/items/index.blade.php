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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Items</h1>
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
                        <li class="breadcrumb-item text-dark">Items</li>
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
                <!--begin::Products-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                            transform="rotate(45 17.0365 15.1223)" fill="black" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" id="searchdatatable"
                                    class="form-control form-control-sm form-control-solid w-250px ps-14"
                                    placeholder="Search" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            {{-- <div class="w-100 mw-150px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" id="filterstatus">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="non-active">Inactive</option>
                                </select>
                            </div> --}}
                            <div class="card-toolbar">
                                <a class="btn btn-sm btn-light-warning button_filter_data">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/><path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/></svg>
                                    </span>
                                    Filter Data
                                </a>
                            </div>
                            <!-- <a href="{{ route('admin.items.import') }}" class="btn btn-sm btn-primary">Import Data Item</a> -->
                            <div class="card-toolbar">
                                @if (isAllowed("items", "add"))
                                <a href="{{ route('admin.items.import') }}" class="btn btn-sm btn-light-success">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <path opacity="0.3"
                                                d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14V4H6V20H18V8H20V21C20 21.6 19.6 22 19 22Z"
                                                fill="black" />
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                        </svg>
                                    </span>
                                    Import Data
                                </a>
                                @endif
                            </div>
                            <div class="card-toolbar">
                                @if (isAllowed("items", "add"))
                                <a href="{{ route('admin.items.add') }}" class="btn btn-sm btn-light-primary">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                transform="rotate(-90 11.364 20.364)" fill="black" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                        </svg>
                                    </span>
                                    Add Data
                                </a>
                                @endif
                            </div>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <form id="filter_data">
                            <div class="row">
                                <div class="col-6 collapse">
                                    <label class="form-label collapse">Category</label>
                                    <select name="category" id="get_category" class="form-select category collapse" data-control="select2"
                                        data-placeholder="Select an option">
                                        <option value="">Please Select</option>
                                        @foreach ($category as $row){
                                            <option value="{{ $row->id }}"> {{ $row->name }} </option>
                                        }
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col collapse">
                                    <label class="form-label collapse">Status</label>
                                    <div class="w-100 mw-150px">
                                    <select class="form-select btn-sm form-select-solid collapse" data-control="select2"
                                        data-hide-search="true" id="filterstatus">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="non-active">Inactive</option>
                                    </select>
                                     </div>
                                </div>
                                <div class='col mt-3 collapse'>
                                    <div class="d-flex justify-content-end mt-5 ">
                                        <button type="submit" class="btn btn-sm btn-light-warning collapse">
                                            <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/><path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/></svg>
                                            </span>
                                            Search
                                </button>
                                &nbsp; &nbsp; 
                                <button type="reset" id="reset-btn" class="btn btn-sm btn-light-danger collapse" value="Reset">
                                    <span class="svg-icon svg-icon-3">
                                        <svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 2)"><path d="m12.5 1.5c2.4138473 1.37729434 4 4.02194088 4 7 0 4.418278-3.581722 8-8 8s-8-3.581722-8-8 3.581722-8 8-8"/><path d="m12.5 5.5v-4h4"/></g></svg>
                                    </span>
                                    Reset
                                </button>
                                    </div>
                                </div>
                            </div>
                           
                        </form>
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_items_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        No
                                    </th>
                                    <th class="min-w-100px">Category</th>
                                    <th class="min-w-70px">Brand</th>
                                    <th class="min-w-200px">Item</th>
                                    <th class="min-w-70px">Stock</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-70px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Products-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- <form action="{{ route('admin.items.updateStock') }}" method="POST"> --}}
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Stock Products Variants</h5>
                        {{-- <span id="modal_item_name"></span> --}}

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table align-middle gs-0 gy-4" id="showVariations">
                                <thead>
                                    <tr class="fw-bolder text-muted bg-light">
                                        <th class="ps-4 rounded-start">SKU</th>
                                        <th class="">Name</th>
                                        <th class="">Last Stock</th>
                                        <th class="rounded-end">Warehouse</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        {{-- <button type="submit" class="btn btn-primary">Save changes</button> --}}
                    </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/items.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".button_filter_data").click(function() {
                $(".collapse").slideToggle();
            });

            var data_items = $('#kt_ecommerce_items_table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: {
                    url: '{{ route('admin.items.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.status = getStatus();
                        d.category = getCategory();  
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'category_name'
                    },
                    {
                        data: 'brand_name'
                    },
                    {
                        data: 'name_package'
                    },
                    {
                        data: 'total_stock', 'searchable': false
                    },
                    {
                        "render": function(data, type, row) {
                            return row.status
                        }
                    },
                    {
                        data: 'action', 'searchable': false
                    }
                ],
            });

            $('#searchdatatable').keyup(function() {
                data_items.search($(this).val()).draw();
            });

            $('#filterstatus').change(function() {
                data_items.search($("#searchdatatable").val()).draw();
            });

            $('#filter_data').submit(function(e){
                e.preventDefault();
                data_items.search($("#searchdatatable").val()).draw();
            })

            $("#reset-btn").click(function() {
                $('#get_category').val('').change();
            });

            function getCategory(){
                return $("#get_category").val();
            }

            function getStatus() {
                return $("#filterstatus").val();
            }

            $(this).find(".format-number").keydown(function(e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && (e
                        .ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <=
                        40)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
                        105)) {
                    e.preventDefault();
                }
            });

            $(this).find('.withseparator').on({
                keyup: function() {
                    formatCurrency($(this));
                },
                blur: function() {
                    formatCurrency($(this), "blur");
                }
            });

            //Delete Confirmation
            $(document).on('click', '.delete', function(event) {
                var ix = $(this).data('ix');
                Swal.fire({
                    html: 'Are you sure delete this data?',
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Ok, got it!",
                    cancelButtonText: 'Nope, cancel it',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.items.delete') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,

                            }),
                            success: function() {
                                Swal.fire('Deleted!', 'Data has been deleted',
                                    'success');
                                data_items.ajax.reload(null, false);
                            }
                        });

                    }
                });
            });

            //Change Status Confirmation
            $(document).on('click', '.changeStatus', function(event) {
                var ix = $(this).data('ix');
                if ($(this).is(':checked')) {
                    var status = "inactive";
                    var changeto = "active";
                } else {
                    var status = "active"
                    var changeto = "inactive";
                }
                Swal.fire({
                    html: 'Are you sure change status to ' + changeto + '?',
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Ok, got it!",
                    cancelButtonText: 'Nope, cancel it',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.items.changeStatus') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                ix: ix,
                                status: changeto,

                            }),
                            success: function() {
                                // Swal.fire('Horray!', 'Status has been changed',
                                //     'success');
                                data_items.ajax.reload(null, false);
                            }
                        });

                    } else {
                        if (status == "active") {
                            $(this).prop("checked", true);
                        } else {
                            $(this).prop("checked", false);
                        }
                    }
                });
            });

            //Update stock
            $(document).on('click', '.updateStock', function(event) {
                var ix = $(this).data('ix');
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.items.getDetail') }}",
                    data: ({
                        "_token": "{{ csrf_token() }}",
                        ix: ix

                    }),
                    // success: function(result) {
                    //     $("#modal_item_name").text("- " + result.name);
                    //     $(".stock-list").remove();
                    //     $(result).each(function(key, row) {
                    //         var new_row = '<tr class="stock-list">';
                    //         new_row += "<td>" + row.sku + "</td><td>" + row.name +
                    //             "</td><td>" + row.total_stock + "</td><td>" + row.warehouse_name +
                    //             "</td>";
                    //         new_row += '</tr>';
                    //         $("#showVariations").append(new_row);
                    //     });

                    //     $('#kt_modal_1').modal('show')
                    // }
                    success: function(result) {
                        $("#modal_item_name").text("- " + result.name);
                        $(".stock-list").remove();

                        result.forEach(function(row) {
                            var stock = row.total_stock ? row.total_stock : 0;
                            var warehouse = row.warehouse_name ? row.warehouse_name : '';
                            var new_row = '<tr class="stock-list">';
                            new_row += "<td>" + row.sku + "</td><td>" + row.name +
                                "</td><td style='text-align: center;'>" + stock + "</td><td>" + warehouse +
                                "</td>";
                            new_row += '</tr>';
                            $("#showVariations").append(new_row);
                        });

                        $('#kt_modal_1').modal('show');
                    }
                });


            });
        });

        @if(session('warning'))
            $(document).ready(function() {
                Swal.fire({
                    icon: 'warning',
                    text: '{{ session('warning') }}',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: "btn btn-primary",
                    }
                });
            });
      
    @endif
    </script>
@endpush
