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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Invoice Sales</h1>
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
                        <li class="breadcrumb-item text-dark">Invoice Sales</li>
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
                                @if (isAllowed('sales', 'export'))
                                    <a href="javascript:void(0)" class="btn btn-sm btn-light-success" id="triggerExport">
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3"
                                                    d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14V4H6V20H18V8H20V21C20 21.6 19.6 22 19 22Z"
                                                    fill="black" />
                                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                            </svg>
                                        </span>
                                        Export Data
                                    </a>
                                @endif
                            </div>
                            <div class="card-toolbar">
                                @if (isAllowed('sales', 'add'))
                                    <a href="{{ route('admin.invoice_sales.add') }}" class="btn btn-sm btn-light-primary">
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
                            </div>
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
                                    <input type="text" class="form-control tanggal bg-secondary" id="tanggal"
                                        placeholder="Date" readonly />
                                </div>
                                <div class="col collapse">
                                    <label class="form-label required">Customer</label>
                                    <div class="row">
                                        <div class="col-md-9 col-auto">
                                            <input type="text" name="customer_name" class="form-control bg-secondary"
                                                id="customer_name" placeholder="Customer Name" value="" readonly />
                                            <input type="hidden" name="customer_id" id="customer_id"
                                                class="form-control" value="" />
                                        </div>
                                        <div class="col-md-3 col-auto">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary"
                                                id="triggerCustomer" data-bs-toggle="modal">
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
                                <div class="col collapse">
                                    <label class="form-label required">Type</label>
                                    <select class="form-select btn-sm form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Status" id="filterType">
                                        <option value=" ">All Type</option>
                                        <option value="sales">Sales</option>
                                        <option value="delivery_note">Delivery Note</option>
                                    </select>
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
                                    <th class="min-w-100px">Invoice Sales Number</th>
                                    <th class="min-w-70px">Date</th>
                                    <th class="min-w-70px">invoice Type</th>
                                    <th class="min-w-100px">Customer</th>
                                    <th class="min-w-100px" style="text-align: left!important;">Total Payment Amount</th>
                                    <th class="min-w-100px" style="text-color: !important;">Payment Status</th>
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

    <div class="modal fade" id="customer_modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Browse Customer</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchCustomerModal" autocomplete="off" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="customer_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Customer Name</th>
                                        <th class="min-w-100px">Customer Group</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="customer_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-customer">Select</button>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="proof_of_payment_modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Upload Proof of Payment</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Image</label><br>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput"
                                        style="width: 100%; height: 150px;">
                                        <img id="preview_image" src="">
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn btn-light fileinput-exists"
                                            data-dismiss="fileinput">Remove</a> --}}
                                        <span class="btn btn-light btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Select image</span>
                                            <input type="file" name="image" id="inputImage">
                                        </span>
                                    </div>
                                </div>
                                <div class="text-muted fs-7">
                                </div>
                            </div>
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Information</label><br>
                                <input type="text" name="information_payment" id="inputInformationInformation"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-secondary mx-1" id="cancel-Proof_of_payment">Void</button>
                        <button type="button" class="btn btn-primary" id="upload-Proof_of_payment">Upload</button>
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
                    url: '{{ route('admin.invoice_sales.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.date = getDate();
                        d.customer_id = getCustomer();
                        d.typeInvoice = getTypeInvoice();
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'invoice_sales_number'
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
                        mRender: function(data, type, row, meta) {
                            let btn = ''
                            if (row.sales_id === 0) {
                                btn += 'Delivery Note'
                            } else {
                                btn += 'Sales'
                            }

                            return btn
                        },
                        className: "text-center"
                    },
                    {
                        data: 'customer_name'
                    },
                    {
                        mRender: function(data, type, row, meta) {
                            return formatRupiah(row.total_payment_amount);
                        },
                        className: "text-end"
                    },
                    {
                        data: 'payment_status',
                        className: "text-center"
                    },
                    {
                        data: 'action',
                        'searchable': false
                    }
                ],
            });

            $(document).on('click', '.triggerProofPayment', function(event) {
                var ix = $(this).data('ix');
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.invoice_sales.getDataInvoiceSales') }}",
                    data: ({
                        "_token": "{{ csrf_token() }}",
                        "_method": 'GET',
                        id: ix,
                    }),
                    success: function(response) {
                        $('#inputInformationInformation').val(response.data
                        .payment_information);
                        $('.fileinput-preview img').prop('src', response.data
                            .proof_of_payment !== null ? (
                                '{{ url('/') }}/administrator/assets/media/invoice_sales/' +
                                response.data.proof_of_payment) : '');
                        if (response.data.payment_status === 0) {                      
                            $('#cancel-Proof_of_payment').addClass('d-none')                      
                        }else {
                            $('#cancel-Proof_of_payment').removeClass('d-none')
                        }
                    },
                    error: function(response) {
                        Swal.fire('Fail!', response,
                            'error');
                    }
                });
                $('#upload-Proof_of_payment').val(ix)
                $('#cancel-Proof_of_payment').val(ix)
                $('#proof_of_payment_modal').modal('show');
            });

            $('#upload-Proof_of_payment').on('click', function() {
                let ix = $(this).val();

                // Create FormData object
                var formData = new FormData();

                // Append file data
                formData.append('image', $('#inputImage')[0].files[0]);

                // Append other form data
                formData.append('id', ix);
                formData.append('information', $('#inputInformationInformation').val());

                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "{{ route('admin.invoice_sales.uploadProofofPayment') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    type: "POST", // Use POST for file uploads
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting contentType
                    cache: false,
                    success: function(data) {
                        // Handle success
                        $('#inputInformationInformation').val('');
                        $('#inputImage').val('');
                        $('.fileinput-preview img').prop('src', '');
                        Swal.fire('Success!', 'Data has been updloaded',
                            'success');
                        $('#proof_of_payment_modal').modal('hide');
                        data_items.ajax.reload(null, false);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        $('#inputInformationInformation').val('');
                        $('#inputImage').val('');
                        Swal.fire('Fail!', JSON.parse(xhr.responseText).message,
                            'error');
                        console.error(JSON.parse(xhr.responseText));
                        data_items.ajax.reload(null, false);
                    }
                });

            });

            $('#cancel-Proof_of_payment').on('click', function() {
                let ix = $(this).val();

                // Create FormData object
                var formData = new FormData();

                // Append other form data
                formData.append('id', ix);

                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "{{ route('admin.invoice_sales.cancelProofofPayment') }}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    type: "POST", // Use POST for file uploads
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting contentType
                    cache: false,
                    success: function(data) {
                        // Handle success
                        $('#inputInformationInformation').val('');
                        $('#inputImage').val('');
                        $('.fileinput-preview img').prop('src', '');
                        Swal.fire('Success!', 'Data has been void',
                            'success');
                        $('#proof_of_payment_modal').modal('hide');
                        data_items.ajax.reload(null, false);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        $('#inputInformationInformation').val('');
                        $('#inputImage').val('');
                        Swal.fire('Fail!', JSON.parse(xhr.responseText).message,
                            'error');
                        console.error(JSON.parse(xhr.responseText));
                        data_items.ajax.reload(null, false);
                    }
                });

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
                $('#customer_id').val('').change();
                $('#filterType').val('').change();
                $('#customer_name').val('').change();
                data_items.search($("#searchdatatable").val()).draw();
            });

            function getDate() {
                return $("#tanggal").val();
            }

            function getCustomer() {
                return $("#customer_id").val();
            }

            function getTypeInvoice() {
                return $("#filterType").val();
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
                            url: "{{ route('admin.invoice_sales.delete') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,

                            }),
                            success: function() {
                                Swal.fire('Deleted!', 'Data has been deleted',
                                    'success');
                                data_items.ajax.reload(null, false);
                            },
                            error: function() {
                                Swal.fire('Fail!', 'data failed to delete',
                                    'error');
                            }
                        });

                    }
                });
            });



            // Variable to store checkbox state
            var checkboxStateCustomer = {};

            // Event delegation for checkboxes
            $('#customer_datatable').on('click', 'input:checkbox[name="customer_id_checkbox"]', function() {
                var $box = $(this);
                var customerId = $box.val();

                // Update checkbox state
                checkboxStateCustomer[customerId] = $box.is(':checked');

                // Uncheck all other checkboxes in the same group
                var group = 'input:checkbox[name="customer_id_checkbox"]';
                $(group).not($box).prop('checked', false);
            });

            // Initialize DataTables
            var customer_datatable = $('#customer_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            // Reapply the event handler and update checkboxes after each table draw
            customer_datatable.on('draw', function() {
                // Update checkboxes based on stored state
                $('#customer_datatable input:checkbox[name="customer_id_checkbox"]').each(function() {
                    var $box = $(this);
                    var customerId = $box.val();

                    if (checkboxStateCustomer[customerId]) {
                        $box.prop('checked', true);
                    } else {
                        $box.prop('checked', false);
                    }
                });

                // Clear the state of checkboxes when switching pages
                $('#customer_datatable input:checkbox').prop('checked', false);
            });

            $('#triggerCustomer').on('click', function() {
                $('#customer_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.invoice_sales.getDataCustomer') }}',
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#customer_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="customer_id"><td><input type="checkbox" class="form-check-input customer_id_checkbox" name="customer_id_checkbox" id="customer_id' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="customer_id' +
                                data[i]
                                .id + '">' + data[i].name +
                                '</label></td><td><label for="customer_id' +
                                data[i]
                                .id + '">' + data[i].customer_group_name +
                                '</label></td></tr>'
                            )).draw(false);

                        });
                        table.draw(false);
                        $('#searchCustomerModal').keyup(function() {
                            table.search($(this).val()).draw();
                        });
                    }
                });
            });

            $('#selectData-customer').on('click', function() {
                var customer_id = $('#customer_datatable').find(
                        'input[type="checkbox"]:checked')
                    .val();

                $.ajax({
                    url: "{{ route('admin.invoice_sales.getDataCustomer') }}",
                    data: {
                        id: customer_id,
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        $('#customer_id').val(data.id)
                        $('#customer_name').val(data.name)
                    }
                });

                $('#customer_modal').modal('hide');
            });

            $('#triggerExport').on('click', function() {
                let params = [];

                if ($('#tanggal').val() != '') {
                    params.push('date=' + $('#tanggal').val());
                }

                if ($('#customer_id').val() != '') {
                    params.push('customer_id=' + $('#customer_id').val());
                }

                if ($('#searchdatatable').val() != '') {
                    params.push('search_datatable=' + $('#searchdatatable').val());
                }

                if ($('#filterType').val() != '') {
                    params.push('typeInvoice=' + $('#filterType').val());
                }

                window.open("{{ route('admin.invoice_sales.export') }}" + "?" + params.join('&'),
                "_blank");
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
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
@endpush
