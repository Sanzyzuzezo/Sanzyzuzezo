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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Production</h1>
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
                        <li class="breadcrumb-item text-dark">Production</li>
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
                                @if (isAllowed('produksi', 'export'))
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
                                @if (isAllowed('produksi', 'add'))
                                    <a href="{{ route('admin.produksi.add') }}" class="btn btn-sm btn-light-primary">
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
                                    <label class="form-label required">Warehouse</label>
                                    <div class="row">
                                        <div class="col-md-9 col-auto">
                                            <input type="text" name="warehouse_nama" class="form-control bg-secondary"
                                                id="warehouse_nama" placeholder="Warehouse Name" value=""
                                                readonly />
                                            <input type="hidden" name="warehouse_id" id="warehouse_id"
                                                class="form-control" value="" />
                                        </div>
                                        <div class="col-md-3 col-auto">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary"
                                                id="triggerWarehouse"
                                                data-url="{{ route('admin.produksi.getDataWarehouse') }}"
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
                                <div class="col collapse">
                                    <label class="form-label required">Item</label>
                                    <div class="row">
                                        <div class="col-md-9 col-auto">
                                            <input type="text" name="item_nama" class="form-control bg-secondary"
                                                id="item_nama" placeholder="Item Name" value="" readonly />
                                            <input type="hidden" name="item_id" id="item_id" class="form-control"
                                                value="" />
                                        </div>
                                        <div class="col-md-3 col-auto">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="triggerItem"
                                                data-url="{{ route('admin.produksi.getDataItem') }}"
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
                                <div class="col collapse">
                                    <label class="form-label required">Variant</label>
                                    <div class="row">
                                        <div class="col-md-9 col-auto">
                                            <input type="text" name="variant_nama" class="form-control bg-secondary"
                                                id="variant_nama" placeholder="Variant Name" value="" readonly />
                                            <input type="hidden" name="variant_id" id="variant_id" class="form-control"
                                                value="" />
                                        </div>
                                        <div class="col-md-3 col-auto">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary data_disabled"
                                                id="triggerVariant"
                                                data-url="{{ route('admin.produksi.getDataVariant') }}"
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
                                    <th class="min-w-100px">No Production</th>
                                    <th class="min-w-70px">Date</th>
                                    <th class="min-w-100px">Warehouse</th>
                                    <th class="min-w-100px">Item</th>
                                    <th class="min-w-100px">Variant</th>
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
                <form action="{{ route('admin.items.updateStock') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Update Stock <span id="modal_item_name"></span></h5>

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

    <div class="modal fade" id="warehouse_modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Browse Gudang</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchWarehouseModal" autocomplete="off"/>
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="warehouse_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Code</th>
                                        <th class="min-w-100px">Name</th>
                                        <th class="min-w-100px">PIC</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="warehouse_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="javascript:void(0)" class="btn btn-primary" id="selectData-Warehouse">Select</a>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="item_modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Browse Items</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchItemModal" autocomplete="off"/>
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5 table-bordered"
                                id="item_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item Name</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="item_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="javascript:void(0)" class="btn btn-primary" id="selectData-Item">Select</a>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="variant_modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Browse Item Variants</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchVariantModal" autocomplete="off"/>
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="variant_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item Variant Name</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="variant_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="javascript:void(0)" class="btn btn-primary" id="selectData-Variant">Select</a>
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
                    url: '{{ route('admin.produksi.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.warehouse_id = getWarehouse();
                        d.item_id = getItem();
                        d.variant_id = getVariant();
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'no_production'
                    },
                    {
                        mRender: function(data, type, row, meta) {
                            var date = new Date(row.date);
                            var formattedDate = moment(date).format('DD-MM-YYYY');

                            return formattedDate;
                        },
                        "className": "text-center"
                    },
                    {
                        data: 'nama_warehouse'
                    },
                    {
                        data: 'nama_item'
                    },
                    {
                        data: 'nama_item_variant',
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

            $('#warehouse_nama').keyup(function() {
                data_items.search($("#searchdatatable").val()).draw();
            });
            
            $('#item_nama').keyup(function() {
                data_items.search($("#searchdatatable").val()).draw();
            });

            $('#variant_nama').keyup(function() {
                data_items.search($("#searchdatatable").val()).draw();
            });

            $('#filter_data').submit(function(e) {
                e.preventDefault();
                data_items.search($("#searchdatatable").val()).draw();
            })

            $("#reset-btn").click(function() {
                $('#warehouse_id').val('').change();
                $('#warehouse_nama').val('').change();
                $('#item_id').val('').change();
                $('#item_nama').val('').change();
                $('#variant_id').val('').change();
                $('#variant_nama').val('').change();
                data_items.search($("#searchdatatable").val()).draw();
            });

            function getWarehouse() {
                return $("#warehouse_id").val();
            }

            function getItem() {
                return $("#item_id").val();
            }

            function getVariant() {
                return $("#variant_id").val();
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
                            url: "{{ route('admin.produksi.delete') }}",
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
            var checkboxStateWarehouse = {};

            // Event delegation for checkboxes
            $('#warehouse_datatable').on('click', 'input:checkbox[name="warehouse_checkbox"]', function() {
                var $box = $(this);
                var warehouseId = $box.val();

                // Update checkbox state
                checkboxStateWarehouse[warehouseId] = $box.is(':checked');

                // Uncheck all other checkboxes in the same group
                var group = 'input:checkbox[name="warehouse_checkbox"]';
                $(group).not($box).prop('checked', false);
            });

            // Initialize DataTables
            var warehouse_datatable = $('#warehouse_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            // Reapply the event handler and update checkboxes after each table draw
            warehouse_datatable.on('draw', function() {
                // Update checkboxes based on stored state
                $('#warehouse_datatable input:checkbox[name="warehouse_checkbox"]').each(function() {
                    var $box = $(this);
                    var warehouseId = $box.val();

                    if (checkboxStateWarehouse[warehouseId]) {
                        $box.prop('checked', true);
                    } else {
                        $box.prop('checked', false);
                    }
                });

                // Clear the state of checkboxes when switching pages
                $('#warehouse_datatable input:checkbox').prop('checked', false);
            });

            $('#triggerWarehouse').on('click', function() {
                $('#warehouse_modal').modal('show');

                $.ajax({
                    url: "{{ route('admin.produksi.getDataWarehouse') }}",
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#warehouse_datatable').DataTable();

                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="warehouse"><td><input type="checkbox" class="form-check-input warehouse_checkbox" name="warehouse_checkbox" id="warehouse' +
                                data[i].id + '" value="' + data[i].id +
                                '" /></td><td><label for="warehouse' + data[i]
                                .id + '">' + data[i].code +
                                '</label></td><td><label for="warehouse' + data[
                                    i]
                                .id + '">' + data[i].name +
                                '</label></td><td><label for="warehouse' + data[
                                    i]
                                .id + '">' + data[i].pic +
                                '</label></td></tr>'
                            )).draw(false);

                            $('#searchWarehouseModal').keyup(function() {
                                table.search($(this).val()).draw();
                            });

                            $("#warehouse" + data[i].id).on('click', function() {
                                var $box = $(this);
                                if ($box.is(":checked")) {
                                    var group =
                                        "input:checkbox[name='warehouse_checkbox']";
                                    $(group).prop("checked", false);
                                    $box.prop("checked", true);
                                } else {
                                    $box.prop("checked", false);
                                }
                            });

                        });

                        $('#selectData-Warehouse').click(function() {
                            var warehouse_id = $('#warehouse_datatable').find(
                                    'input[type="checkbox"]:checked')
                                .val();

                            $.ajax({
                                url: "{{ route('admin.produksi.getDataWarehouse') }}",
                                data: {
                                    'id': warehouse_id,
                                },
                                type: "get",
                                cache: false,
                                async: false,
                                success: function(data) {
                                    $('#warehouse_nama').val(data
                                        .name)
                                    $('#warehouse_id').val(data.id)
                                }
                            });
                            disableVariant()
                            $('#warehouse_modal').modal('hide');
                        })
                    }
                });
            });
            
            
            // Variable to store checkbox state
            var checkboxStateItem = {};

            // Event delegation for checkboxes
            $('#item_datatable').on('click', 'input:checkbox[name="item_checkbox"]', function() {
                var $box = $(this);
                var itemId = $box.val();

                // Update checkbox state
                checkboxStateItem[itemId] = $box.is(':checked');

                // Uncheck all other checkboxes in the same group
                var group = 'input:checkbox[name="item_checkbox"]';
                $(group).not($box).prop('checked', false);
            });

            // Initialize DataTables
            var item_datatable = $('#item_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            // Reapply the event handler and update checkboxes after each table draw
            item_datatable.on('draw', function() {
                // Update checkboxes based on stored state
                $('#item_datatable input:checkbox[name="item_checkbox"]').each(function() {
                    var $box = $(this);
                    var itemId = $box.val();

                    if (checkboxStateItem[itemId]) {
                        $box.prop('checked', true);
                    } else {
                        $box.prop('checked', false);
                    }
                });

                // Clear the state of checkboxes when switching pages
                $('#item_datatable input:checkbox').prop('checked', false);
            });

            $('#triggerItem').on('click', function() {
                $('#item_modal').modal('show');

                $.ajax({
                    url: "{{ route('admin.produksi.getDataItem') }}",
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#item_datatable').DataTable();

                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="item"><td><input type="checkbox" class="form-check-input item_checkbox" name="item_checkbox" id="item' +
                                data[i].id + '" value="' + data[i].id +
                                '" /></td><td><label for="item' + data[i]
                                .id + '">' + data[i].name +
                                '</label></td></tr>'
                            )).draw(false);

                            $('#searchItemModal').keyup(function() {
                                table.search($(this).val()).draw();
                            });

                            $("#item" + data[i].id).on('click', function() {
                                var $box = $(this);
                                if ($box.is(":checked")) {
                                    var group =
                                        "input:checkbox[name='item_checkbox']";
                                    $(group).prop("checked", false);
                                    $box.prop("checked", true);
                                } else {
                                    $box.prop("checked", false);
                                }
                            });

                        });

                        $('#selectData-Item').click(function() {
                            var item_id = $('#item_datatable').find(
                                    'input[type="checkbox"]:checked')
                                .val();

                            $.ajax({
                                url: "{{ route('admin.produksi.getDataItem') }}",
                                data: {
                                    'id': item_id,
                                },
                                type: "get",
                                cache: false,
                                async: false,
                                success: function(data) {
                                    $('#item_nama').val(data
                                        .name)
                                    $('#item_id').val(data.id)
                                }
                            });
                            disableVariant()
                            $('#item_modal').modal('hide');
                        })
                    }
                });
            });
            

            // Variable to store checkbox state
            var checkboxStateVariant = {};

            // Event delegation for checkboxes
            $('#variant_datatable').on('click', 'input:checkbox[name="variant_checkbox"]', function() {
                var $box = $(this);
                var variantId = $box.val();

                // Update checkbox state
                checkboxStateVariant[variantId] = $box.is(':checked');

                // Uncheck all other checkboxes in the same group
                var group = 'input:checkbox[name="variant_checkbox"]';
                $(group).not($box).prop('checked', false);
            });

            // Initialize DataTables
            var variant_datatable = $('#variant_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            // Reapply the event handler and update checkboxes after each table draw
            variant_datatable.on('draw', function() {
                // Update checkboxes based on stored state
                $('#variant_datatable input:checkbox[name="variant_checkbox"]').each(function() {
                    var $box = $(this);
                    var variantId = $box.val();

                    if (checkboxStateVariant[variantId]) {
                        $box.prop('checked', true);
                    } else {
                        $box.prop('checked', false);
                    }
                });

                // Clear the state of checkboxes when switching pages
                $('#variant_datatable input:checkbox').prop('checked', false);
            });

            $('#triggerVariant').on('click', function() {
                $('#variant_modal').modal('show');

                $.ajax({
                    url: "{{ route('admin.produksi.getDataVariant') }}",
                    data : {
                        product_id : $('#item_id').val(),
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#variant_datatable').DataTable();

                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="variant"><td><input type="checkbox" class="form-check-input variant_checkbox" name="variant_checkbox" id="variant' +
                                data[i].id + '" value="' + data[i].id +
                                '" /></td><td><label for="variant' + data[i]
                                .id + '">' + data[i].name +
                                '</label></td></tr>'
                            )).draw(false);

                            $('#searchVariantModal').keyup(function() {
                                table.search($(this).val()).draw();
                            });

                            $("#variant" + data[i].id).on('click', function() {
                                var $box = $(this);
                                if ($box.is(":checked")) {
                                    var group =
                                        "input:checkbox[name='variant_checkbox']";
                                    $(group).prop("checked", false);
                                    $box.prop("checked", true);
                                } else {
                                    $box.prop("checked", false);
                                }
                            });

                        });

                        $('#selectData-Variant').click(function() {
                            var variant_id = $('#variant_datatable').find(
                                    'input[type="checkbox"]:checked')
                                .val();

                            $.ajax({
                                url: "{{ route('admin.produksi.getDataVariant') }}",
                                data: {
                                    product_id : $('#item_id').val(),
                                    id : variant_id,
                                },
                                type: "get",
                                cache: false,
                                async: false,
                                success: function(data) {
                                    $('#variant_nama').val(data
                                        .name)
                                    $('#variant_id').val(data.id)
                                }
                            });

                            $('#variant_modal').modal('hide');
                        })
                    }
                });
            });

            $('#triggerExport').on('click', function() {
                let params = [];

                if ($('#warehouse_id').val() != '') {
                    params.push('warehouse_id=' + $('#warehouse_id').val());
                }

                if ($('#item_id').val() != '') {
                    params.push('item_id=' + $('#item_id').val());
                }

                if ($('#variant_id').val() != '') {
                    params.push('variant_id=' + $('#variant_id').val());
                }

                if ($('#searchdatatable').val() != '') {
                    params.push('search_datatable=' + $('#searchdatatable').val());
                }

                window.open("{{ route('admin.produksi.export') }}" + "?" + params.join('&'), "_blank");
            });


        });

        function disableVariant(){
            if ($('#item_id').val() != "") {
                $('#triggerVariant').removeClass('data_disabled');
            }
        }
    </script>
@endpush
