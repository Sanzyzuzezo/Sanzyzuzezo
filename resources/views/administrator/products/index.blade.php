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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Products</h1>
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
                        <li class="breadcrumb-item text-dark">Products</li>
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
                            <div class="w-100 mw-150px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" id="filterstatus">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="non-active">Inactive</option>
                                </select>
                            </div>
                            <!-- <a href="{{ route('admin.products.import') }}" class="btn btn-sm btn-primary">Import Data Product</a> -->
                            <div class="card-toolbar">
                                @if (isAllowed("products", "add"))
                                <a href="{{ route('admin.products.import') }}" class="btn btn-sm btn-light-success">
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
                                @if (isAllowed("products", "add"))
                                <a href="{{ route('admin.products.add') }}" class="btn btn-sm btn-light-primary">
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
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        No
                                    </th>
                                    <th class="min-w-100px">Category</th>
                                    <th class="min-w-70px">Brand</th>
                                    <th class="min-w-200px">Product</th>
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
                <form action="{{ route('admin.products.updateStock') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Update Stock <span id="modal_product_name"></span></h5>

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
                                        <th class="rounded-end text-end">Last Stock</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/products.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var data_products = $('#kt_ecommerce_products_table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: {
                    url: '{{ route('admin.products.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.status = getStatus();
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
                        data: 'stock', 'searchable': false
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
                data_products.search($(this).val()).draw();
            });

            $('#filterstatus').change(function() {
                data_products.search($("#searchdatatable").val()).draw();
            });

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
                            url: "{{ route('admin.products.delete') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,

                            }),
                            success: function() {
                                Swal.fire('Deleted!', 'Data has been deleted',
                                    'success');
                                data_products.ajax.reload(null, false);
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
                            url: "{{ route('admin.products.changeStatus') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                ix: ix,
                                status: changeto,

                            }),
                            success: function() {
                                // Swal.fire('Horray!', 'Status has been changed',
                                //     'success');
                                data_products.ajax.reload(null, false);
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
                    url: "{{ route('admin.products.getDetail') }}",
                    data: ({
                        "_token": "{{ csrf_token() }}",
                        ix: ix

                    }),
                    success: function(result) {
                        $("#modal_product_name").text("- " + result.name);
                        $(".stock-list").remove();
                        $(result.variants).each(function(key, row) {
                            var new_row = '<tr class="stock-list">';
                            new_row += "<td>" + row.sku + "</td><td>" + row.name +
                                "</td><td><input class='form-control withseparator format-number text-end' type='text' name='stock[" +
                                row.id + "]' value='" + row.stock + "'></td>";
                            new_row += '</tr>';
                            $("#showVariations").append(new_row);
                        });

                        $('#kt_modal_1').modal('show')
                    }
                });


            });
        });
    </script>
@endpush
