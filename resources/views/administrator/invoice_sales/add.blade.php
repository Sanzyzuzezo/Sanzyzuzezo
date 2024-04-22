@extends('administrator.layouts.main')

@push('css')
    <style>
        .data_disabled {
            background-color: #aba8a8 !important;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
@endpush

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
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.invoice_sales') }}" class="text-muted text-hover-primary">Invoice
                                Sales</a>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Add</li>
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
                <!--begin::Form-->
                <form id="form" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.invoice_sales.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
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
                                        <label class="form-label required">Date</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="date"
                                                    class="form-control input_datepicker_date" placeholder="Date"
                                                    value="{{ date('d-m-Y', strtotime(now())) }}" />
                                            </div>
                                        </div>
                                        <div class="text-muted fs-7">
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label required">Invoice Sales Number</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="invoice_sales_number"
                                                    placeholder="Nomor Invoice" id="invoice_sales_number"
                                                    class="form-control bg-secondary" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label required">Customer</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="customer_name" class="form-control bg-secondary"
                                                    id="customer_name" placeholder="Customer Name" value=""
                                                    readonly />
                                                <input type="hidden" name="customer_id" id="customer_id"
                                                    class="form-control" value="" />
                                            </div>
                                            <div class="col-auto">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary" title="Search"
                                                    data-bs-toggle="modal" id="triggerCustomer">
                                                    <span class="svg-icon svg-icon-2 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
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
                                        <div class="text-muted fs-7">
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label required">Invoice Type</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-select" id="invoice_type" name="invoice_type" data-control="select2" data-hide-search="true" data-placeholder="Please Select">
                                                    <option value="">Please Select</option>
                                                    <option value="sales">Sales</option>
                                                    <option value="delivery_note">Delivery Note</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-7">
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row d-none" id="fieldSales">
                                        <label class="form-label required">Sales</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="sales_number"
                                                    class="form-control bg-secondary" id="sales_number"
                                                    placeholder="Sales Number" value="" readonly />
                                                <input type="hidden" name="sales_id" id="sales_id"
                                                    class="form-control" value="" />
                                            </div>
                                            <div class="col-auto">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary data_disabled"
                                                    title="Search" data-bs-toggle="modal" id="triggerSales">
                                                    <span class="svg-icon svg-icon-2 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
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
                                        <div class="text-muted fs-7">
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row d-none" id="fieldDeliveryNote">
                                        <label class="form-label required">Delivery Note</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="delivery_note_number"
                                                    class="form-control bg-secondary" id="delivery_note_number"
                                                    placeholder="Delivery Note Number" value="" readonly />
                                                <input type="hidden" name="delivery_note_id" id="delivery_note_id"
                                                    class="form-control" value="" />
                                            </div>
                                            <div class="col-auto">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary data_disabled"
                                                    title="Search" data-bs-toggle="modal" id="triggerDeliveryNote">
                                                    <span class="svg-icon svg-icon-2 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
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
                                        <div class="text-muted fs-7">
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="form-label">Information</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea name="information" id="information" cols="30" rows="5" class="form-control"
                                                    autocomplete="off"></textarea>
                                            </div>
                                        </div>
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
                                        <label class="form-label required">Item Variants</label>
                                        <!--end::Label-->
                                        <div class="d-flex justify-content-end d-none">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary" title="Reload"
                                                id="triggerReload">
                                                <span
                                                    class="svg-icon svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/keen/releases/2021-04-21-040700/theme/demo2/dist/../src/media/svg/icons/General/Update.svg--><svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="5" height="5" />
                                                            <path
                                                                d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z"
                                                                fill="#000000" fill-rule="nonzero" />
                                                        </g>
                                                    </svg><!--end::Svg Icon--></span>
                                            </a>
                                        </div>
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                    id="tableDataInvoiceSales">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr
                                                            class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-20px">No</th>
                                                            <th class="min-w-100px">Image</th>
                                                            <th class="min-w-100px">Item Name</th>
                                                            <th class="min-w-100px">Item Variant Name</th>
                                                            <th class="min-w-100px">Price</th>
                                                            <th class="min-w-50px">Quantity</th>
                                                            <th class="min-w-100px">Total</th>
                                                            <th class="min-w-40px">Action</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600" id="bodyTableDataInvoiceSales">

                                                    </tbody>
                                                    <tfoot>
                                                        <tr
                                                            class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <td colspan="6" class="text-end">Jumlah</td>
                                                            <td class="text-end">
                                                                <div id="total_payment_amount">Rp 0</div><input
                                                                    type="hidden" name="total_payment_amount"
                                                                    id="input_total_payment_amount">
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                        </div>
                                        <input type="hidden" class="jumlah_detail" name="jumlah_detail">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card header-->
                            </div>
                            <!--end::General options-->
                        </div>

                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.invoice_sales') }}" id="triggerCancelForm"
                                class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="triggerSubmit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
                <!--end::Form-->
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
                                    id="searchCustomerModal" autocomplete="off"/>
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
                                    id="searchSalesModal" autocomplete="off"/>
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="sales_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Sales Number</th>
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

    <div class="modal fade" id="delivery_note_modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Browse Delivery Note</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchDeliveryNoteModal" autocomplete="off"/>
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="delivery_note_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Delivery Note Number</th>
                                        <th class="min-w-100px">Sales Number</th>
                                        <th class="min-w-100px">Information</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="delivery_note_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-delivery_note">Select</button>
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
        // Define form element
        const form = document.getElementById("form");

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(form, {
            fields: {
                date: {
                    validators: {
                        notEmpty: {
                            message: "Date is required !",
                        },
                    },
                },
                invoice_type: {
                    validators: {
                        notEmpty: {
                            message: "Please select invoice type !",
                        },
                    },
                },
                customer_id: {
                    validators: {
                        notEmpty: {
                            message: "Please select customer !",
                        },
                    },
                },
                invoice_sales_number: {
                    validators: {
                        notEmpty: {
                            message: "Invoice Sales number is required !",
                        },
                        remote: {
                            message: 'Invoice Sales Number is exist',
                            method: 'POST',
                            url: '{{ route('admin.invoice_sales.isExistInvoiceSalesNumber') }}',
                            data: function() {
                                return {
                                    _token: '{{ csrf_token() }}',
                                    invoice_sales_number: $('#invoice_sales_number').val(),
                                }
                            },
                        },
                    },
                },
                jumlah_detail: {
                    validators: {
                        notEmpty: {
                            message: "Detail is required !",
                        },
                    },
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: "",
                }),
            },
        });

        // Submit button handler
        const submitButton = document.getElementById("triggerSubmit");
        submitButton.addEventListener("click", function(e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function(status) {
                    if (status == "Valid") {
                        let stat = true;

                        if (stat == true) {
                            // Show loading indication
                            submitButton.setAttribute("data-kt-indicator", "on");

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;

                            // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            setTimeout(function() {
                                // Remove loading indication
                                submitButton.removeAttribute("data-kt-indicator");

                                // Enable button
                                submitButton.disabled = false;

                                form.submit(); // Submit form
                            }, 2000);
                        } else {
                            return false;
                        }
                    }
                });
            }
        });

        $(document).ready(function() {
            resetData();
            totalAmount();


            $(".input_datepicker_date").flatpickr({
                dateFormat: "d-m-Y",
            });

            var inputInvoiceSalesNumber = document.getElementsByName("invoice_sales_number")[0];
            inputInvoiceSalesNumber.classList.add("bg-secondary")
            $.ajax({
                url: "{{ route('admin.invoice_sales.generateInvoiceSalesNumber') }}",
                type: "get",
                cache: false,
                async: false,
                success: function(data) {
                    $('#invoice_sales_number').val(data)
                }
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

                        let type = $('#invoice_type').val();
                        if (type !== '') {
                            if (type === 'sales') {
                                $('#triggerSales').removeClass('data_disabled');
                            } else if (type === 'delivery_note') {
                                $('#triggerDeliveryNote').removeClass('data_disabled');
                            }
                        }

                    }
                });

                $('#customer_modal').modal('hide');
            });

            $('#invoice_type').on('change', function() {
                let type = $(this).val();
                let customer_id = $('#customer_id').val();
                var number = $('#bodyTableDataInvoiceSales').find('tr').length;
                if (type === 'sales') {
                    if (customer_id !== '') {
                        $('#triggerSales').removeClass('data_disabled');
                    }
                    $('#delivery_note_id').val('');
                    $('#delivery_note_number').val('');
                    $('#fieldSales').removeClass('d-none');
                    $('#fieldDeliveryNote').addClass('d-none');
                    $('#bodyTableDataInvoiceSales').empty()
                    resetData();
                    totalAmount();
                    cloneSales();
                } else if (type === 'delivery_note') {
                    if (customer_id !== '') {
                        $('#triggerDeliveryNote').removeClass('data_disabled');
                    }
                    $('#sales_id').val('');
                    $('#sales_number').val('');
                    $('#fieldSales').addClass('d-none');
                    $('#fieldDeliveryNote').removeClass('d-none');
                    $('#bodyTableDataInvoiceSales').empty()
                    resetData();
                    totalAmount();
                    cloneDeliveryNote();
                } else {
                    $('#triggerDeliveryNote').removeClass('data_disabled');
                    $('#triggerSales').removeClass('data_disabled');

                    $('#fieldSales').addClass('d-none');
                    $('#fieldDeliveryNote').addClass('d-none');
                    $('#bodyTableDataInvoiceSales').empty()
                    resetData();
                    totalAmount();


                    $('#sales_id').val('');
                    $('#sales_number').val('');
                    $('#delivery_note_id').val('');
                    $('#delivery_note_number').val('');
                }
            });


            $('#triggerReload').on('click', function() {
                let type = $('#invoice_type').val();
                if (type === 'sales') {
                    cloneSales();
                } else if (type === 'delivery_note') {
                    cloneDeliveryNote();
                }
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
                ordering: false,
                searching: true,
                dom: 'lrtip',
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
                    url: '{{ route('admin.invoice_sales.getDataSales') }}',
                    type: "get",
                    data: {
                        customer_id: $('#customer_id').val()
                    },
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#sales_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="sales_id"><td><input type="checkbox" class="form-check-input sales_id_checkbox" name="sales_id_checkbox" id="sales_id' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="sales_id' +
                                data[i]
                                .id + '">' + data[i].sales_number +
                                '</label></td><td><label for="sales_id' +
                                data[i]
                                .id + '">' + (data[i].information ? data[i]
                                    .information : 'No Information') +
                                '</label></td></tr>'
                            )).draw(false);

                        });
                        table.draw(false);
                        $('#searchSalesModal').keyup(function() {
                            table.search($(this).val()).draw();
                        });
                    }
                });
            });

            $('#selectData-sales').on('click', function() {
                var sales_id = $('#sales_datatable').find(
                        'input[type="checkbox"]:checked')
                    .val();

                $.ajax({
                    url: "{{ route('admin.invoice_sales.getDataSales') }}",
                    data: {
                        id: sales_id,
                        customer_id: $('#customer_id').val()
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        $('#sales_id').val(data.id)
                        $('#sales_number').val(data.sales_number)
                        cloneSales()
                    }
                });

                $('#sales_modal').modal('hide');
            });

            // Variable to store checkbox state
            var checkboxStateDeliveryNote = {};

            // Event delegation for checkboxes
            $('#delivery_note_datatable').on('click', 'input:checkbox[name="delivery_note_id_checkbox"]',
                function() {
                    var $box = $(this);
                    var delivery_noteId = $box.val();

                    // Update checkbox state
                    checkboxStateDeliveryNote[delivery_noteId] = $box.is(':checked');

                    // Uncheck all other checkboxes in the same group
                    var group = 'input:checkbox[name="delivery_note_id_checkbox"]';
                    $(group).not($box).prop('checked', false);
                });

            // Initialize DataTables
            var delivery_note_datatable = $('#delivery_note_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            // Reapply the event handler and update checkboxes after each table draw
            delivery_note_datatable.on('draw', function() {
                // Update checkboxes based on stored state
                $('#delivery_note_datatable input:checkbox[name="delivery_note_id_checkbox"]').each(
                    function() {
                        var $box = $(this);
                        var delivery_noteId = $box.val();

                        if (checkboxStateDeliveryNote[delivery_noteId]) {
                            $box.prop('checked', true);
                        } else {
                            $box.prop('checked', false);
                        }
                    });

                // Clear the state of checkboxes when switching pages
                $('#delivery_note_datatable input:checkbox').prop('checked', false);
            });

            $('#triggerDeliveryNote').on('click', function() {
                $('#delivery_note_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.invoice_sales.getDataDeliveryNote') }}',
                    type: "get",
                    data: {
                        customer_id: $('#customer_id').val()
                    },
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#delivery_note_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="delivery_note_id"><td><input type="checkbox" class="form-check-input delivery_note_id_checkbox" name="delivery_note_id_checkbox" id="delivery_note_id' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="delivery_note_id' +
                                data[i]
                                .id + '">' + data[i].delivery_note_number +
                                '</label></td><td><label for="delivery_note_id' +
                                data[i]
                                .id + '">' + data[i].sales_number +
                                '</label></td><td><label for="delivery_note_id' +
                                data[i]
                                .id + '">' + (data[i].information ? data[i]
                                    .information : 'No Information') +
                                '</label></td></tr>'
                            )).draw(false);

                        });
                        table.draw(false);
                        $('#searchDeliveryNoteModal').keyup(function() {
                            table.search($(this).val()).draw();
                        });
                    }
                });
            });

            $('#selectData-delivery_note').on('click', function() {
                var delivery_note_id = $('#delivery_note_datatable').find(
                        'input[type="checkbox"]:checked')
                    .val();

                $.ajax({
                    url: "{{ route('admin.invoice_sales.getDataDeliveryNote') }}",
                    data: {
                        id: delivery_note_id,
                        customer_id: $('#customer_id').val()
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        $('#delivery_note_id').val(data.id)
                        $('#delivery_note_number').val(data.delivery_note_number)

                        cloneDeliveryNote()
                    }
                });

                $('#delivery_note_modal').modal('hide');
            });

            function resetData() {
                var index = 0;
                $(".row_detail").each(function() {
                    var another = this;

                    search_index = $(this).attr("childidx");
                    $(this)
                        .find("input,select")
                        .each(function() {
                            this.name = this.name.replace(
                                "[" + search_index + "]",
                                "[" + index + "]"
                            );
                            $(another).attr("childidx", index);
                        });

                    $(this).find(".format-number").keydown(function(e) {
                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e
                                .keyCode == 65 && (e
                                    .ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 &&
                                e.keyCode <=
                                40)) {
                            return;
                        }
                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 ||
                                e.keyCode >
                                105)) {
                            e.preventDefault();
                        }
                    });

                    $(this).find('.no-item').text((index + 1));

                    $(this).find('.quantity-item').on('keyup', function() {
                        let thisval = this;
                        this.value = this.value.replace(/[^0-9]/g, '');
                        let finish = $(this).val(formatNumber($(this).val()));

                        let price = parseRupiah($(another).find('.price-item').text());
                        let parse = parseNumber($(this).val());
                        let quantity = parse;
                        let first_quantity = $(another).find('.first_quantity-item').val()
                        // if (quantity > first_quantity && quantity === 0) {
                        //     $(thisval).val('');
                        //     $(another).find('.message_quantity-item').text(
                        //         `quantity tidak boleh lebih dari ${first_quantity}`)
                        //     resetData();
                        //     totalAmount();
                        //     return false;
                        // } else {
                        //     $(another).find('.message_quantity-item').text('')
                        // }
                        let total = price * quantity;
                        $(another).find('.total-item').val(formatRupiah(total));
                    });

                    $(this).find('.withseparator').on({
                        keyup: function() {
                            formatCurrency($(this));
                        },
                        blur: function() {
                            formatCurrency($(this), "blur");
                        }
                    });

                    $('.triggerDeleteDetail').on('click', function(e) {
                        let id = $(this).data('id');
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
                                Swal.fire('Deleted!',
                                    'Data has been deleted',
                                    'success');
                                $("#row_detail_" + id).remove();
                                resetData();
                                totalAmount();
                            }
                        });
                    });

                    function formatCurrency(input, blur) {
                        // appends $ to value, validates decimal side
                        // and puts cursor back in right position.

                        // get input value
                        var input_val = input.val();

                        // don't validate empty input
                        if (input_val === "") {
                            return;
                        }

                        // original length
                        var original_len = input_val.length;

                        // initial caret position
                        var caret_pos = input.prop("selectionStart");

                        // check for decimal
                        if (input_val.indexOf(".") >= 0) {

                            // get position of first decimal
                            // this prevents multiple decimals from
                            // being entered
                            var decimal_pos = input_val.indexOf(".");

                            // split number by decimal point
                            var left_side = input_val.substring(0, decimal_pos);
                            var right_side = input_val.substring(decimal_pos);

                            // add commas to left side of number
                            left_side = formatNumber(left_side);

                            // validate right side
                            right_side = formatDecimal(right_side);

                            // On blur make sure 2 numbers after decimal
                            if (blur === "blur") {
                                right_side += "00";
                            }

                            // Limit decimal to only 2 digits
                            right_side = right_side.substring(0, 2);

                            // join number by .
                            input_val = "" + left_side + "." + right_side;

                        } else {
                            // no decimal entered
                            // add commas to number
                            // remove all non-digits
                            input_val = formatNumber(input_val);
                            input_val = "" + input_val;

                            // final formatting
                            if (blur === "blur") {
                                input_val += ".00";
                            }
                        }

                        // send updated string to input
                        input.val(input_val);

                        // put caret back in the right position
                        var updated_len = input_val.length;
                        caret_pos = updated_len - original_len + caret_pos;
                        input[0].setSelectionRange(caret_pos, caret_pos);
                    }

                    function formatNumber(n) {
                        // format number 1000000 to 1,234,567
                        var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                        return xx;

                    }

                    // Assuming first_quantity is already defined
                    let first_quantity = parseFloat($(another).find('.first_quantity-item').val());

                    validator.addField("detail[" + index + "][quantity]", {
                        validators: {
                            notEmpty: {
                                message: 'Quantity is required!'
                            },
                            between: {
                                min: 1,
                                max: first_quantity,
                                message: `Quantity must be greater than 0 and not greater than ${first_quantity}!`,
                            }
                        },
                    });





                    index++;
                });

                var no = $('#bodyTableDataInvoiceSales').find('tr').length;
                if (no == 0) {
                    no = '';
                }
                $('.jumlah_detail').val(no);
            }

            validator.registerValidator('greaterThanZero', function(value) {
                // Convert value to a number (assuming quantity is a numeric field)
                const quantity = parseFloat(value);

                // Check if the quantity is greater than 0
                if (quantity <= 0) {
                    return {
                        valid: false,
                        message: 'Quantity must be greater than 0!'
                    };
                }

                return {
                    valid: true,
                    message: ''
                };
            });

            function formatRupiah(amount) {
                // Use Number.prototype.toLocaleString() to format the number as currency
                return 'Rp ' + Number(amount).toLocaleString('id-ID');
            }

            function parseRupiah(rupiahString) {
                // Remove currency symbol, separators, and parse as integer
                const parsedValue = parseInt(rupiahString.replace(/[^\d]/g, ''));
                return isNaN(parsedValue) ? 0 : parsedValue;
            }

            function formatNumber(number) {
                // Use Number.prototype.toLocaleString() to format the number as currency
                return Number(number).toLocaleString('id-ID');
            }

            function parseNumber(number) {
                // Remove currency symbol, separators, and parse as integer
                // Replace dot only if it exists in the number
                const parsedValue = parseInt(number.replace(/[^\d]/g, ''));
                return isNaN(parsedValue) ? 0 : parsedValue;
            }

            function totalAmount() {
                $(".row_detail").each(function() {
                    $(this)
                        .find(".quantity-item")
                        .on("keyup", function() {
                            totalAmount();
                        });
                });

                // Pembelian Dengan Permintaan
                total_nominal = 0;
                $(".row_detail").each(function() {
                    nominal = parseRupiah($(this).find(".total-item").val());
                    total_nominal += parseFloat(nominal ? nominal : 0);
                });

                $("#total_payment_amount").text(formatRupiah(total_nominal));
                $("#input_total_payment_amount").val(total_nominal);
            }

            function showLoadingSpinner() {
                // Add code to show loading spinner here
                // For example, you can append a loading element to the body
                $('#bodyTableDataInvoiceSales').append('<div class="loading-spinner">Loading...</div>');
            }

            function hideLoadingSpinner() {
                // Add code to hide loading spinner here
                // For example, you can remove the loading element
                $('.loading-spinner').remove();
            }


            function cloneDeliveryNote() {
                $('#bodyTableDataInvoiceSales').empty()
                var number = $('#bodyTableDataInvoiceSales').find('tr').length;
                let delivery_note_id = $('#delivery_note_id').val();
                if (delivery_note_id !== '') {
                    showLoadingSpinner()
                    $.ajax({
                        url: "{{ route('admin.invoice_sales.getDataDeliveryNoteDetail') }}",
                        data: {
                            delivery_note_id: delivery_note_id,
                        },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(datas) {
                            hideLoadingSpinner()
                            datas.map(data => {
                                let item_variant_id = data
                                    .item_variant_id;
                                if ($('#row_detail_' + item_variant_id)
                                    .length == 0) {

                                    let img_url = data.data_file;
                                    let sum = data.quantity - data.quantity_sum
                                    if (sum != 0) {
                                        $('#bodyTableDataInvoiceSales')
                                            .append(`
                                                    <tr id="row_detail_${item_variant_id}" class="row_detail" childidx="0">
                                                        <td class="no-item">${number + 1}</td>
                                                        <td class="img-item"><img width="50px" src="${img_url ? `{{ asset('administrator/assets/media/products/') }}/${img_url}` : 'http://placehold.it/500x500?text=Not%20Found'}" alt=""></td>
                                                        <td class="nama_item-item">${data.nama_item}</td>
                                                        <td class="nama_item_variant-item">${data.nama_item_variant}</td>
                                                        <td class="price-item text-end">${formatRupiah(data.price)}</td>
                                                        <td class="fv-row">
                                                            <input type="hidden" class="item_variant_id-item" name="detail[${number}][item_variant_id]" value="${data.item_variant_id}">
                                                            <input type="hidden" class="first_quantity-item" value="${sum}">
                                                            <input type="text" class="form-control quantity-item text-end" value="${sum}" name="detail[${number}][quantity]" autocomplete="off">
                                                        </td>
                                                        <td class="fv-row">
                                                            <input type="text" name="detail[${number}][total]" class="form-control bg-secondary total-item text-end" value="${formatRupiah(parseFloat(data.price) * sum)}" readonly>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-icon btn-light btn-active-light-primary triggerDeleteDetail" data-id="${item_variant_id}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                                <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" /></svg></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                `);
                                        resetData();
                                        totalAmount();
                                    }
                                }
                            });
                        }
                    });
                }
            }

            function cloneSales() {
                $('#bodyTableDataInvoiceSales').empty()
                var number = $('#bodyTableDataInvoiceSales').find('tr').length;
                let sales_id = $('#sales_id').val();
                if (sales_id !== '') {
                    showLoadingSpinner()
                    $.ajax({
                        url: "{{ route('admin.invoice_sales.getDataSalesDetail') }}",
                        data: {
                            sales_id: sales_id,
                        },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(datas) {
                            hideLoadingSpinner()
                            datas.map(data => {
                                let item_variant_id = data
                                    .item_variant_id;
                                if ($('#row_detail_' + item_variant_id)
                                    .length == 0) {

                                    let img_url = data.data_file;
                                    let sum = data.quantity - data.quantity_sum
                                    if (sum != 0) {
                                        $('#bodyTableDataInvoiceSales')
                                            .append(`
                                                    <tr id="row_detail_${item_variant_id}" class="row_detail" childidx="0">
                                                        <td class="no-item">${number + 1}</td>
                                                        <td class="img-item"><img width="50px" src="${img_url ? `{{ asset('administrator/assets/media/products/') }}/${img_url}` : 'http://placehold.it/500x500?text=Not%20Found'}" alt=""></td>
                                                        <td class="nama_item-item">${data.nama_item}</td>
                                                        <td class="nama_item_variant-item">${data.nama_item_variant}</td>
                                                        <td class="price-item text-end">${formatRupiah(data.price)}</td>
                                                        <td class="fv-row">
                                                            <input type="hidden" class="item_variant_id-item" name="detail[${number}][item_variant_id]" value="${data.item_variant_id}">
                                                            <input type="hidden" class="first_quantity-item" value="${sum}">
                                                            <input type="text" class="form-control quantity-item text-end" value="${sum}" name="detail[${number}][quantity]" autocomplete="off">
                                                        </td>
                                                        <td class="fv-row">
                                                            <input type="text" name="detail[${number}][total]" class="form-control bg-secondary total-item text-end" value="${formatRupiah(data.price * sum)}" readonly>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-icon btn-light btn-active-light-primary triggerDeleteDetail" data-id="${item_variant_id}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                                <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" /></svg></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                `);
                                        resetData();
                                        totalAmount();
                                    }
                                }
                            });
                        }
                    });
                }
            }

        });
    </script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
@endpush
