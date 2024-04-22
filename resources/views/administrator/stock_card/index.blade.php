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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Stock Card</h1>
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
                        <li class="breadcrumb-item text-dark">Stock Card</li>
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
                            <div class="w-100 mw-200px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" id="filtertransactiontype">
                                    <option value="">All Transaction Type</option>
                                    <option value="in">In</option>
                                    <option value="out">Out</option>
                                    <option value="move_location">Move Location</option>
                                    <option value="transfer_to_store">Transfer To Store</option>
                                </select>
                            </div>
                            <div class="w-100 mw-150px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" id="filterstatus">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="non-active">Inactive</option>
                                    <option value="canceled">Cancel</option>
                                </select>
                            </div>
                            <div class="card-toolbar">
                                @if (isAllowed("stock_card", "add"))
                                <a href="{{ route('admin.stock_card.add') }}" class="btn btn-sm btn-light-primary">
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
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_stock_card_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-20px pe-2">
                                        No
                                    </th>
                                    <th class="min-w-100px">Date</th>
                                    <th class="min-w-100px">Transaction Type</th>
                                    <th class="min-w-100px">Warehouse</th>
                                    <th class="min-w-50px">Status</th>
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
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/jstree/jstree.bundle.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var data_stock_card = $('#kt_ecommerce_stock_card_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.stock_card.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.transaction_type = getTransactionType();
                        d.status = getStatus();
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        render: function(data, type, row) {
                            if(row.transaction_type == 'in'){
                                return '<div class="badge badge-light-success">In</div>'
                            }else if(row.transaction_type == 'out'){
                                return '<div class="badge badge-light-danger">Out</div>'
                            }else if(row.transaction_type == 'move_location'){
                                return '<div class="badge badge-secondary">Move Location</div>'
                            }else if(row.transaction_type == 'transfer_to_store'){
                                return '<div class="badge badge-secondary">Transfer To Store</div>'
                            }
                        }
                    },
                    {
                        data: 'warehouse_name',
                        name: 'warehouse_name'
                    },
                    {
                        render: function(data, type, row) {
                            if(row.canceled_at == null){
                                if(row.status == 1){
                                    return '<div class="badge badge-light-success">Active</div>'
                                }else{
                                    return '<div class="badge badge-light-danger">In Active</div>'
                                }
                                // return '<div class="badge badge-light-success">Active</div>'
                            }else{
                                return '<div class="badge badge-light-danger">Cancel</div>'
                            }
                            
                            // if(row.status == 1){
                            //     return '<div class="badge badge-light-success">Active</div>'
                            // }else{
                            //     return '<div class="badge badge-light-danger">In Active</div>'
                            // }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        'searchable': false,
                        render: function(data, type, row) {
                            var btn = "";
                            @if (isAllowed("stock_card", "add"))
                                if(row.canceled_at == null){
                                    btn += "<a href='stock_card/detail/"+row.id+"' class='btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1'><span class='svg-icon svg-icon-3'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'><path d='M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z' fill='black'/><path opacity='0.3' d='M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z' fill='black'/></svg></span></a><a href='stock_card/edit/"+row.id+"' class='btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1'><span class='svg-icon svg-icon-3'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'><path opacity='0.3' d='M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z' fill='black' /><path d='M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z' fill='black' /></svg></span></a><a href='#' data-ix='"+row.id+"' data-transactiontype='"+row.transaction_type+"' data-warehouseid='"+row.warehouse_id+"' data-destinationwarehouseid='"+row.destination_warehouse_id+"' data-storeid='"+row.store_id+"' data-status='"+row.canceled_at+"' class='btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete'><span class='svg-icon svg-icon-3'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'><path d='M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z' fill='black' /><path opacity='0.5' d='M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z' fill='black' /><path opacity='0.5' d='M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z' fill='black' /></svg></span></a>";
                                }else{
                                    btn += "<a href='stock_card/detail/"+row.id+"' class='btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1'><span class='svg-icon svg-icon-3'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'><path d='M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z' fill='black'/><path opacity='0.3' d='M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z' fill='black'/></svg></span></a>";
                                }
                            @endif
                            return btn;
                        }
                    }
                ],
            });

            $('#searchdatatable').keyup(function() {
                data_stock_card.search($(this).val()).draw();
            })

            $('#filtertransactiontype').change(function() {
                data_stock_card.search($("#searchdatatable").val()).draw();
            })

            $('#filterstatus').change(function() {
                data_stock_card.search($("#searchdatatable").val()).draw();
            })

            function getStatus() {
                return $("#filterstatus").val();
            }

            function getTransactionType() {
                return $("#filtertransactiontype").val();
            }
            
            //Delete Confirmation
            $(document).on('click', '.delete', function(event) {
                var ix = $(this).data('ix');
                var transaction_type = $(this).data('transactiontype');
                var status = $(this).data('status');
                var warehouseId = $(this).data('warehouseid');
                var destinationWarehouseId = $(this).data('destinationwarehouseid');
                var storeId = $(this).data('storeid');

                if(transaction_type == 'in' || transaction_type == 'out'){
                    var remove = 'delete';
                }else{
                    var remove = 'cancel';
                }

                Swal.fire({
                    html: 'Are you sure '+remove+' this data?',
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
                            url: "{{ route('admin.stock_card.delete') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,
                                transaction_type: transaction_type,
                                warehouse_id: warehouseId,
                                destination_warehouse_id: destinationWarehouseId,
                                store_id: storeId,
                            }),
                            success: function(resp){
                                if(transaction_type == 'in' || transaction_type == 'out'){
                                    if(resp.success){
                                        Swal.fire('Deleted!', 'Data has been deleted', 'success');
                                    }else{
                                        Swal.fire('Failed!', 'Deleted data failed', 'error');
                                    }
                                }else{
                                    if(resp.success){
                                        Swal.fire('Canceled!', 'Data has been canceled', 'success');
                                    }else{
                                        Swal.fire('Failed!', 'Canceled data failed', 'error');
                                    }
                                }

                                data_stock_card.ajax.reload(null, false);
                            },
                            error: function (resp) {
                                Swal.fire("Error!", "Something went wrong.", "error");
                                data_stock_card.ajax.reload(null, false);
                            }
                        });
                    }
                });
            });

        });

        $('#kt_docs_jstree_basic').jstree({
            "core": {
                "themes": {
                    "responsive": false
                }
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder"
                },
                "file": {
                    "icon": "fa fa-file"
                }
            },
            "plugins": ["types"]
        });
    </script>
@endpush
