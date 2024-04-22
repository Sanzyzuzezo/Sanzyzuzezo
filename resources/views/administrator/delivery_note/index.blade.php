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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Delivery Note</h1>
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
                        <li class="breadcrumb-item text-dark">Delivery Note</li>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z"
                                                fill="black" />
                                            <path opacity="0.3"
                                                d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    Filter Data
                                </a>
                            </div>
                            <div class="card-toolbar">
                                @if (isAllowed('delivery_note', 'sales'))
                                    <a href="{{ route('admin.delivery_note.sales') }}" class="btn btn-sm btn-light-primary">
                                        <span class="svg-icon svg-icon-primary svg-icon-2"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Communication/Clipboard-list.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                                <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1"/>
                                                <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1"/>
                                                <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                        Sales Data
                                    </a>
                                @endif
                            </div>
                            {{-- <div class="card-toolbar">
                                @if (isAllowed('delivery_note', 'add'))
                                    <a href="{{ route('admin.delivery_note.add') }}" class="btn btn-sm btn-light-primary">
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                    rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        Add Data
                                    </a>
                                @endif
                            </div> --}}
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <form id="filter_data">
                            <div class="row">
                                <div class="col collapse">
                                    <label class="form-label">Date</label>
                                    <input type="text" class="form-control tanggal bg-secondary" id="tanggal" placeholder="Date"
                                        readonly />
                                </div>
                                <div class="col collapse">
                                    <label class="form-label required">Sales Number</label>
                                    <div class="row">
                                        <div class="col-md-9 col-auto">
                                            <input type="text" name="sales_number" class="form-control bg-secondary"
                                                id="sales_number" placeholder="Sales Number" value="" readonly />
                                            <input type="hidden" name="sales_id" id="sales_id" class="form-control"
                                                value="" />
                                        </div>
                                        <div class="col-md-3 col-auto">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="triggerSales"
                                                data-bs-toggle="modal">
                                                <span class="svg-icon svg-icon-2 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z"
                                                            fill="white" />
                                                        <path opacity="0.5"
                                                            d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z"
                                                            fill="white" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class='col collapse' style="margin-top:7rem;">
                                    <div class="d-flex justify-content-end mt-5 ">
                                        <button type="submit" class="btn btn-sm btn-light-warning collapse">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z"
                                                        fill="black" />
                                                    <path opacity="0.3"
                                                        d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            Search
                                        </button>
                                        &nbsp; &nbsp;
                                        <button type="reset" id="reset-btn"
                                            class="btn btn-sm btn-light-danger collapse" value="Reset">
                                            <span class="svg-icon svg-icon-3">
                                                <svg height="21" viewBox="0 0 21 21" width="21"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        transform="translate(2 2)">
                                                        <path
                                                            d="m12.5 1.5c2.4138473 1.37729434 4 4.02194088 4 7 0 4.418278-3.581722 8-8 8s-8-3.581722-8-8 3.581722-8 8-8" />
                                                        <path d="m12.5 5.5v-4h4" />
                                                    </g>
                                                </svg>
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
                                    <th class="min-w-10px pe-2">
                                        No
                                    </th>
                                    <th class="min-w-100px">Delivery Note Number</th>
                                    <th class="min-w-70px">Date</th>
                                    <th class="min-w-100px">Sales Number</th>
                                    <th class="min-w-100px">License Plate Number</th>
                                    <th class="min-w-100px">Weather</th>
                                    <th class="min-w-100px">Information</th>
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
    
    <div class="modal fade" id="sales_modal" tabindex="-1" aria-hidden="true">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="black" />
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
                        <h2>Browse Sales</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchSalesModal" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="sales_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Sales Number</th>
                                        <th class="min-w-100px">Date</th>
                                        <th class="min-w-100px">Customer</th>
                                        <th class="min-w-100px">Total Sales Amount</th>
                                        <th class="min-w-100px">Information</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="sales_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-sales">Select</button>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#tanggal").daterangepicker({
                // locale: {
                //     format: "DD/MM/YYYY",
                // },
            });
            $('#tanggal').val('').change();


            $(".button_filter_data").click(function() {
                $(".collapse").slideToggle();
            });

            var data_items = $('#kt_ecommerce_items_table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: {
                    url: '{{ route('admin.delivery_note.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.date = getDate();
                        d.sales_number = getSales();
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'delivery_note_number'
                    },
                    {
                        mRender: function(data, type, row, meta) {
                            var date = new Date(row.date);
                            var formattedDate = moment(date).format('DD-MM-YYYY');

                            return formattedDate;
                        },
                        className: "text-center"
                    },
                    {
                        data: 'sales_number'
                    },
                    {
                        data: 'license_plate_number'
                    },
                    {
                        data: 'weather'
                    },
                    {
                        data: 'information'
                    },
                    {
                        data: 'action',
                        'searchable': false
                    }
                ],
            });

            $('#searchdatatable').keyup(function() {
                data_items.search($(this).val()).draw();
            });

            $('#filter_data').submit(function(e) {
                e.preventDefault();
                data_items.search($("#searchdatatable").val()).draw();
            })

            $("#reset-btn").click(function() {
                $('#tanggal').val('').change();
                $("#sales_id").val('').change();
                $("#sales_number").val('').change();
                data_items.search($("#searchdatatable").val()).draw();
            });

            function getDate() {
                return $("#tanggal").val();
            }

            function getSales() {
                return $("#sales_number").val();
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
                            url: "{{ route('admin.delivery_note.delete') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,

                            }),
                            success: function(response) {
                                Swal.fire('Deleted!', response.message,
                                    response.status);
                                data_items.ajax.reload(null, false);
                            },
                            error: function(response) {
                                Swal.fire('Fail!', response.responseJSON.message,
                                    response.responseJSON.status);
                            }
                        });

                    }
                });
            });


            
            // Variable to store checkbox state
            var checkboxStateSales = {};

            // Event delegation for checkboxes
            $('#sales_datatable').on('click', 'input:checkbox[name="sales_id_checkbox"]', function() {
                var $box = $(this);
                var salesId = $box.val();

                // Update checkbox state
                checkboxStateSales[salesId] = $box.is(':checked');

                // Uncheck all other checkboxes in the same group
                var group = 'input:checkbox[name="sales_id_checkbox"]';
                $(group).not($box).prop('checked', false);
            });

            // Initialize DataTables
            var sales_datatable = $('#sales_datatable').dataTable({
                ordering: true,
                searching: true,
                dom: 'lrtip',
            });

            $('#searchSalesModal').keyup(function(){
                $('#sales_datatable').DataTable().search($(this).val()).draw() ;
            });

            // Reapply the event handler and update checkboxes after each table draw
            sales_datatable.on('draw', function() {
                // Update checkboxes based on stored state
                $('#sales_datatable input:checkbox[name="sales_id_checkbox"]').each(function() {
                    var $box = $(this);
                    var salesId = $box.val();

                    if (checkboxStateSales[salesId]) {
                        $box.prop('checked', true);
                    } else {
                        $box.prop('checked', false);
                    }
                });

                // Clear the state of checkboxes when switching pages
                $('#sales_datatable input:checkbox').prop('checked', false);
            });

            $('#triggerSales').on('click', function() {
                $('#sales_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.delivery_note.getSales') }}',
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#sales_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            var informasi = data[i].information !== null ? data[i].information : '';
                            table.row.add($(
                                '<tr class="sales_id"><td><input type="checkbox" class="form-check-input sales_id_checkbox" name="sales_id_checkbox" id="sales_id' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="sales_id' +
                                data[i]
                                .id + '">' + data[i].sales_number +
                                '</label></td><td><label for="sales_id' +
                                data[i]
                                .id + '">' + data[i].date +
                                '</label></td><td><label for="sales_id' +
                                data[i]
                                .id + '">' + data[i].customer_name +
                                '</label></td><td><label for="sales_id' +
                                data[i]
                                .id + '">' + data[i].total_sales_amount +
                                '</label></td><td><label for="sales_id' +
                                data[i]
                                .id + '">' + informasi +
                                '</label></td></tr>'
                            )).draw(false);

                        });
                        table.draw(false);
                    }
                });
            });

            $('#selectData-sales').on('click', function() {
                var sales_id = $('#sales_datatable').find(
                        'input[type="checkbox"]:checked')
                    .val();

                $.ajax({
                    url: "{{ route('admin.delivery_note.getSales') }}",
                    data: {
                        id : sales_id,
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        $('#sales_id').val(data.id)
                        $('#sales_number').val(data.sales_number)
                    }
                });

                $('#sales_modal').modal('hide');
            });

            function formatRupiah(amount) {
                // Use Number.prototype.toLocaleString() to format the number as currency
                return 'Rp ' + Number(amount).toLocaleString('id-ID');
            }

            function parseRupiah(rupiahString) {
                // Remove currency symbol, separators, and parse as integer
                return parseInt(rupiahString.replace(/[^\d]/g, ''));
            }

        });
    </script>
@endpush
