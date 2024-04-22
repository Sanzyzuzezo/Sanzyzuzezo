@extends('administrator.layouts.main')
<style>
    #listDataItem th {
        font-weight: bold;
        font-size: 11px;
    }

    .form-label {
        font-weight: bold !important;
        font-size: 14px !important;
    }

    .fv-row text-end align-center fs-5 fw-bold text-dark {
        font-weight: bold !important;
        font-size: 14px !important;
    }
</style>
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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Purchase</h1>
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
                            <a href="{{ route('admin.buys') }}" class="text-muted text-hover-primary">Purchase</a>
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

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger d-flex align-items-center p-5">
                        <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path opacity="0.3"
                                    d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z"
                                    fill="black" />
                                <path
                                    d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Error</h4>
                            <span>{{ $message }}</span>
                        </div>
                        <button type="button"
                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                            data-bs-dismiss="alert">
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2"
                                        rx="1" transform="rotate(-45 7.05025 15.5356)" fill="black" />
                                    <rect x="8.46447" y="7.05029" width="12" height="2" rx="1"
                                        transform="rotate(45 8.46447 7.05029)" fill="black" />
                                </svg>
                            </span>
                        </button>
                    </div>
                @endif

                <form id="form" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.buys.save') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Input group-->
                                <div class="fv-row">
                                    <div class="row mb-5">
                                        <div class="col-md-6 mt-5">
                                            <div class="fv-row">
                                                <label class="form-label required">Date</label>
                                                <input type="text" name="tanggal" placeholder="Date"
                                                    class="form-control kt_datepicker_1 text-end" value="" />
                                                <div class="text-muted fs-7">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-5">
                                            <div class="mb-10 fv-row">
                                                <label class="form-label required">Purchase Number</label>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <input type="text" name="nomor_pembelian"
                                                            placeholder="Purchase Number" id="nomor_pembelian"
                                                            class="form-control bg-secondary" value="{{ $nomor_pembelian }}"
                                                            readonly />
                                                        <input type="hidden" id="status_nomor_pembelian"
                                                            name="status_nomor_pembelian" value="false"
                                                            class="form-control bg-secondary" />
                                                    </div>
                                                    <div class="input-group-append col-auto">
                                                        <button class="btn btn-outline-success" type="button"
                                                            id="btnToggleNomorPembelian">Change</button>
                                                    </div>
                                                </div>
                                                <div class="text-muted fs-7">
                                                    <small class="form-text text-muted">The purchase number can be filled
                                                        in manually or
                                                        automatic</small>
                                                </div>
                                                <div class="text-muted fs-7">
                                                    <small id="nomorPembelianHelp" class="form-text text-muted">Click the
                                                        "Change" button
                                                        to fill in manually!</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-10">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-5">
                                                <label class="form-label required">Warehouse</label>
                                                <select name="gudang" class="form-select" data-control="select2"
                                                    data-hide-search="true" data-placeholder="Please Select">
                                                    <option value="">Please Select</option>
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-muted fs-7">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-5">
                                                <label class="form-label required">Supplier</label>
                                                <select name="supplier" class="form-select" data-control="select2"
                                                    data-hide-search="true" data-placeholder="Please Select">
                                                    <option value="">Please Select</option>
                                                    @foreach ($supplier as $supply)
                                                        <option value="{{ $supply->id }}">{{ $supply->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="text-muted fs-7">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label required">Purchase Detail</label>
                                    <!--end::Label-->
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-sm btn-primary" id="addItem">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                                        height="2" rx="1"
                                                        transform="rotate(-90 11.364 20.364)" fill="black" />
                                                    <rect x="4.36396" y="11.364" width="16" height="2"
                                                        rx="1" fill="black" />
                                                </svg>
                                            </span>
                                            Add Data
                                        </button>
                                    </div>
                                    <!--begin::Input-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                id="listDataItem">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr
                                                        class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-200px">Product</th>
                                                        <th class="min-w-50px">Item Price</th>
                                                        <th class="min-w-50px">Quantity</th>
                                                        <th class="min-w-50px">Unit</th>
                                                        <th class="min-w-70px">Price</th>
                                                        <th class="min-w-70px">Expired</th>
                                                        {{-- <th class="min-w-10px">Upload Bukti Pengeluaran</th> --}}
                                                        <th class="min-w-10px">Action</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600 align-top" id="get-item-data">
                                                    <tr class="item-list" childidx="0" style="position: relative;">
                                                        <td class="fv-row">
                                                            <div class="d-flex flex-row">
                                                                <input type="hidden"
                                                                    class="form-control form-control-sm form-control-solid text-dark mw-100px account_id"
                                                                    placeholder="Id" name="item[0][product_variant_id]"
                                                                    readonly>
                                                                <input type="text"
                                                                    class="form-control form-control-sm form-control-solid text-dark account_nama1 mx-1"
                                                                    placeholder="Product" name="item[0][item_name]"
                                                                    readonly>
                                                                <input type="text"
                                                                    class="form-control form-control-sm form-control-solid text-dark account_nama2 mx-1"
                                                                    placeholder="Variant"
                                                                    name="item[0][item_variant_name]" readonly>
                                                                <button class="btn btn-sm btn-light-primary modalAccount2">
                                                                    <span class="svg-icon svg-icon-4 m-0">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none">
                                                                            <rect opacity="0.5" x="17.0365" y="15.1223"
                                                                                width="8.15546" height="2"
                                                                                rx="1"
                                                                                transform="rotate(45 17.0365 15.1223)"
                                                                                fill="black" />
                                                                            <path
                                                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                                                fill="black" />
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        <td class="fv-row">
                                                            <input type="text"
                                                                class="form-control form-white text-end withseparator format-number harga"
                                                                name="item[0][harga]" data-max="" data-item=""
                                                                data-variant="" required>
                                                        </td>
                                                        <td class="fv-row">
                                                            <input type="text"
                                                                class="form-control form-white text-end withseparator format-number jumlah"
                                                                name="item[0][jumlah]" data-max="" data-item=""
                                                                data-variant="" required>
                                                        </td>
                                                        <td class="fv-row">
                                                            <select class="form-select unit-item" name="item[0][unit]"
                                                                required>
                                                                <option value="">Please Select</option>
                                                            </select>
                                                        </td>
                                                        <td class="fv-row">
                                                            <input type="text"
                                                                class="form-control form-white text-end withseparator format-number total"
                                                                name="item[0][total]" data-max="" data-item=""
                                                                data-variant="" required readonly>
                                                        </td>
                                                        <td class="fv-row">
                                                            <input type="text" name="item[0][expired]"
                                                                placeholder="Expired"
                                                                class="form-control kt_datepicker_2 text-end"
                                                                value="" />
                                                        </td>
                                                        {{-- <td class="fv-row">
                                                            <div>
                                                                <span class="btn btn-icon btn-bg-light btn-file btn-active-color-primary btn-sm me-1 svg-icon svg-icon-muted svg-icon-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                        <path opacity="0.3" d="M4.425 20.525C2.525 18.625 2.525 15.525 4.425 13.525L14.825 3.125C16.325 1.625 18.825 1.625 20.425 3.125C20.825 3.525 20.825 4.12502 20.425 4.52502C20.025 4.92502 19.425 4.92502 19.025 4.52502C18.225 3.72502 17.025 3.72502 16.225 4.52502L5.82499 14.925C4.62499 16.125 4.62499 17.925 5.82499 19.125C7.02499 20.325 8.82501 20.325 10.025 19.125L18.425 10.725C18.825 10.325 19.425 10.325 19.825 10.725C20.225 11.125 20.225 11.725 19.825 12.125L11.425 20.525C9.525 22.425 6.425 22.425 4.425 20.525Z" fill="black"/>
                                                                        <path d="M9.32499 15.625C8.12499 14.425 8.12499 12.625 9.32499 11.425L14.225 6.52498C14.625 6.12498 15.225 6.12498 15.625 6.52498C16.025 6.92498 16.025 7.525 15.625 7.925L10.725 12.8249C10.325 13.2249 10.325 13.8249 10.725 14.2249C11.125 14.6249 11.725 14.6249 12.125 14.2249L19.125 7.22493C19.525 6.82493 19.725 6.425 19.725 5.925C19.725 5.325 19.525 4.825 19.125 4.425C18.725 4.025 18.725 3.42498 19.125 3.02498C19.525 2.62498 20.125 2.62498 20.525 3.02498C21.325 3.82498 21.725 4.825 21.725 5.925C21.725 6.925 21.325 7.82498 20.525 8.52498L13.525 15.525C12.325 16.725 10.525 16.725 9.32499 15.625Z" fill="black"/>
                                                                        </svg>
                                                                    <input type="file" name="item[0][image]" accept="image/jpeg, image/png, image/jpg" onchange="handleFileChange(this)">
                                                                </span>
                                                                <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 showImage"
                                                                data-image="">
                                                                <span class="svg-icon svg-icon-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                        <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                                                                            <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                                                                    </svg>
                                                                </span>
                                                                </a>
                                                            </div>
                                                        </td> --}}
                                                        <td>
                                                            <a href="#"
                                                                class="btn btn-sm btn-icon btn-light btn-active-light-primary removeData">
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24"
                                                                        fill="none">
                                                                        <path
                                                                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                            fill="black" />
                                                                        <path opacity="0.5"
                                                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                            fill="black" />
                                                                        <path opacity="0.5"
                                                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="fw-bold text-gray-600">
                                                    <tr style="position: relative;">
                                                        <td class="fv-row text-end align-center fs-5 fw-bold text-dark"
                                                            colspan="5">
                                                            Total Price
                                                        </td>
                                                        <td class="fv-row" style="width: 120px">
                                                            <input type="text"
                                                                class="form-control form-white text-end withseparator format-number total_keseluruhan"
                                                                name="total_keseluruhan" value="" required readonly>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" class="items-data" name="items">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.buys') }}" id="kt_ecommerce_add_product_cancel"
                                class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="stock_card_submit" class="btn btn-primary">
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

    <table class="template-data" style="display: none;">
        <tr class="template-item-list" childidx="0" style="position: relative;">
            <td class="fv-row">
                <div class="d-flex flex-row">
                    <input type="hidden"
                        class="form-control form-control-sm form-control-solid text-dark mw-100px account_id"
                        placeholder="Nama" name="item[0][product_variant_id]" readonly>
                    <input type="text"
                        class="form-control form-control-sm form-control-solid text-dark account_nama1 mx-1"
                        placeholder="Product" name="item[0][item_name]" readonly>
                    <input type="text"
                        class="form-control form-control-sm form-control-solid text-dark account_nama2 mx-1"
                        placeholder="Variant" name="item[0][item_variant_name]" readonly>
                    <button class="btn btn-sm btn-light-primary modalAccount2">
                        <span class="svg-icon svg-icon-4 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="black" />
                            </svg>
                        </span>
                    </button>
                </div>
            </td>
            <td class="fv-row">
                <input type="text" class="form-control form-white text-end withseparator format-number harga"
                    name="item[0][harga]" data-max="" data-item="" data-variant="" required>
            </td>
            <td class="fv-row">
                <input type="text" class="form-control form-white text-end withseparator format-number jumlah"
                    name="item[0][jumlah]" data-max="" data-item="" data-variant="" required>
            </td>
            <td class="fv-row">
                <select class="form-select unit-item" name="item[0][unit]" required>
                    <option value="">Please Select</option>
                </select>
            </td>
            <td class="fv-row">
                <input type="text" class="form-control form-white text-end withseparator format-number total"
                    name="item[0][total]" data-max="" data-item="" data-variant="" required readonly>
            </td>
            <td class="fv-row">
                <input type="text" name="item[0][expired]" placeholder="Expired"
                    class="form-control kt_datepicker_2 text-end" value="" />
            </td>
            {{-- <td class="fv-row">
                <div>
                    <span class="btn btn-icon btn-bg-light btn-file btn-active-color-primary btn-sm me-1 svg-icon svg-icon-muted svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M4.425 20.525C2.525 18.625 2.525 15.525 4.425 13.525L14.825 3.125C16.325 1.625 18.825 1.625 20.425 3.125C20.825 3.525 20.825 4.12502 20.425 4.52502C20.025 4.92502 19.425 4.92502 19.025 4.52502C18.225 3.72502 17.025 3.72502 16.225 4.52502L5.82499 14.925C4.62499 16.125 4.62499 17.925 5.82499 19.125C7.02499 20.325 8.82501 20.325 10.025 19.125L18.425 10.725C18.825 10.325 19.425 10.325 19.825 10.725C20.225 11.125 20.225 11.725 19.825 12.125L11.425 20.525C9.525 22.425 6.425 22.425 4.425 20.525Z" fill="black"/>
                            <path d="M9.32499 15.625C8.12499 14.425 8.12499 12.625 9.32499 11.425L14.225 6.52498C14.625 6.12498 15.225 6.12498 15.625 6.52498C16.025 6.92498 16.025 7.525 15.625 7.925L10.725 12.8249C10.325 13.2249 10.325 13.8249 10.725 14.2249C11.125 14.6249 11.725 14.6249 12.125 14.2249L19.125 7.22493C19.525 6.82493 19.725 6.425 19.725 5.925C19.725 5.325 19.525 4.825 19.125 4.425C18.725 4.025 18.725 3.42498 19.125 3.02498C19.525 2.62498 20.125 2.62498 20.525 3.02498C21.325 3.82498 21.725 4.825 21.725 5.925C21.725 6.925 21.325 7.82498 20.525 8.52498L13.525 15.525C12.325 16.725 10.525 16.725 9.32499 15.625Z" fill="black"/>
                            </svg>
                        <input type="file" name="item[0][image]" accept="image/jpeg, image/png, image/jpg" onchange="handleFileChange(this)">
                    </span>
                    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 showImage"
                    data-image="">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                                <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                        </svg>
                    </span>
                    </a>
                </div>
            </td> --}}
            <td>
                <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary removeData">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                fill="black" />
                            <path opacity="0.5"
                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                fill="black" />
                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                fill="black" />
                        </svg>
                    </span>
                </a>
            </td>
        </tr>
    </table>
    {{-- <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Gambar Nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" alt="Gambar Nota" class="img-fluid" id="selectedImage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- modal account2 --}}
    <div class="modal fade" id="account-data-modal2" tabindex="-1" aria-hidden="true">
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
                        <h2>Data Product</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchAccountTable2" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="dataAccount2">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th>No</th>
                                        <th class="min-w-100px">Product</th>
                                        <th class="min-w-100px">Variant</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-account2">Select</button>
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
    <script>
        function handleFileChange(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                src = window.URL.createObjectURL(input.files[0]);

                $(input).closest('tr').find('.showImage').attr('data-image', src)
                tambahKlik();
            }
        }

        function tambahKlik() {
            $('.showImage').on('click', function() {
                $('#imageModal').find('img').attr('src', $(this).attr('data-image'));
                $('#imageModal').modal('show');
            });
        }
    </script>
    <script>
        function getAccount2(another) {
            $('#searchAccountTable2').keyup(function() {
                $('#dataAccount2').DataTable().search($(this).val()).draw();
            });
            $("#dataAccount2").DataTable().destroy();
            $('#dataAccount2 tbody').remove();
            $('#dataAccount2').DataTable({
                "searching": true,
                "dom": 'lrtip',
                "pagingType": "full_numbers",
                "order": false,
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": "<i class='ti-angle-left'></i>",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": "<i class='ti-angle-right'></i>"
                    }
                },
                "lengthMenu": [
                    [5, 10, 25, 50],
                    [5, 10, 25, 50]
                ],
                "language": {
                    "lengthMenu": "_MENU_"
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.buys.getDataProduct') }}",
                    "dataType": "JSON",
                    "type": "GET",
                    "data": {
                        datatable: true,
                        supplier: $('.supply').val()
                    },
                },
                'select': {
                    'style': 'single'
                },
                "columns": [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        "data": "item_name"
                    },
                    {
                        "data": "item_variant_name"
                    },
                ]

            });

            var table_account = $('#dataAccount2').DataTable();

            $('#selectData-account2').on('click', function(e, dt, node, config) {
                var rows_selected = table_account.rows({
                    selected: true
                }).data();

                if (rows_selected[0] != undefined) {
                    $(another).find(".account_id").val(rows_selected[0]['id']);
                    $(another).find(".account_nama1").val(rows_selected[0]['item_name']);
                    $(another).find(".account_nama2").val(rows_selected[0]['item_variant_name']);

                    $.ajax({
                        url: "{{ route('admin.buys.getUnit') }}",
                        data: {
                            'id': rows_selected[0]['id']
                        },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(data) {
                            $(another).find('.unit-item').empty()
                            $(another).find('.unit-item').append(
                                "<option value=''>Please Select</option>");
                            for (var i = 0; i < data.length; i++) {
                                $(another).find('.unit-item').append(
                                    `<option value='${data[i].id}'>${data[i].name}</option>`
                                );
                            }
                        }
                    });
                }

                console.log(rows_selected)
                $('#account-data-modal2').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });
        }
    </script>
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/buys.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            resetData();
            $(".kt_datepicker_1").flatpickr({
                dateFormat: "d F Y",
            });

            $('#btnToggleNomorPembelian').off().on('click', function(e) {
                var nomorPembelianInput = document.getElementsByName("nomor_pembelian")[0];
                nomorPembelianInput.readOnly = !nomorPembelianInput.readOnly;
                if (nomorPembelianInput.readOnly == false) {
                    nomorPembelianInput.classList.remove("bg-secondary")
                } else {
                    nomorPembelianInput.classList.add("bg-secondary")
                    $.ajax({
                        url: "{{ route('admin.buys.generate-nomor') }}",
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(data) {
                            $('#nomor_pembelian').val(data)
                        }
                    });

                    $("#status_nomor_pembelian").val(false)
                }

                var nomorPembelianHelp = document.getElementById("nomorPembelianHelp");
                nomorPembelianHelp.innerHTML = nomorPembelianInput.readOnly ?
                    "Click the 'Change' button to fill in the manual!" :
                    "Click the 'Change' button to autofill!";
            });

            $("#nomor_pembelian").keyup(function() {
                let nomor_pembelian = $("#nomor_pembelian").val()
                $.ajax({
                    url: "{{ route('admin.buys.cek-nomor') }}",
                    data: {
                        'nomor_pembelian': nomor_pembelian
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        if (data == 1) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Purchase Number ' +
                                    nomor_pembelian +
                                    ' Has been used!',
                                icon: 'error',
                                confirmButtonText: 'Close'
                            })
                            $("#status_nomor_pembelian").val("")
                        }
                    }
                });
            });

            $('.showImage').on('click', function() {
                $('#imageModal').find('img').attr('src', $(this).data('image'));
                $('#imageModal').modal('show');
            });

            $('#addItem').on('click', function() {
                var tr_clone = $(".template-item-list").clone();

                tr_clone.removeClass('template-item-list');
                tr_clone.addClass('item-list');
                $("#listDataItem").append(tr_clone);


                resetData();
            });

            $('.form-check-input').on('click', function() {
                if ($('.lainnya').is(':checked')) {
                    $('.lain').removeClass('d-none');

                    validator.addField("lain", {
                        validators: {
                            notEmpty: {
                                message: 'Silahkan sebutkan tujuan utama pengeluaran biaya'
                            }
                        }
                    });
                } else {
                    $('.lain').addClass('d-none');

                    validator.removeField("lain", {
                        validators: {}
                    });
                }
            });

            resetData();
            addValidation();

        });

        function resetData() {
            var index = 0;
            $(".item-list").each(function() {
                var another = this;
                search_index = $(this).attr("childidx");
                $(this).find('input,select,textarea').each(function() {
                    this.name = this.name.replace('[' + search_index + ']', '[' + index + ']');
                    $(another).attr("childidx", index);
                });

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
                    // console.log(xx)/
                    return xx;
                }

                $(this).find(".removeData").off().on("click", function() {
                    var existingData = $(another).find('.id-item').val();
                    // console.log(existingData)

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
                            if (existingData != null) {
                                $.ajax({
                                    type: "DELETE",
                                    url: "{{ route('admin.buys.delete-detail') }}",
                                    data: ({
                                        "_token": "{{ csrf_token() }}",
                                        "_method": 'DELETE',
                                        ix: existingData,
                                    }),
                                    success: function(resp) {
                                        removeValidation();
                                        if (resp.success) {
                                            Swal.fire('Deleted!',
                                                'Data has been deleted', 'success');
                                        } else {
                                            Swal.fire('Failed!', 'Deleted data failed',
                                                'error');
                                        }
                                        $(another).remove();

                                        var count_item = $('#get-item-data').find(
                                            '.item-list').length;
                                        if (count_item != 0) {
                                            $(".items-data").val(count_item);
                                        } else {
                                            $(".items-data").val('');
                                        }

                                        getTotal();
                                        resetData();
                                        addValidation();
                                    },
                                    error: function(resp) {
                                        Swal.fire("Error!", "Something went wrong.",
                                            "error");
                                    }
                                });
                            } else {
                                removeValidation();
                                $(another).remove();

                                var count_item = $('#get-item-data').find('.item-list').length;
                                if (count_item != 0) {
                                    $(".items-data").val(count_item);
                                } else {
                                    $(".items-data").val('');
                                }

                                getTotal();
                                resetData();
                                addValidation();
                            }
                        }
                    });
                    // swal({
                    //     title: "Anda yakin?",
                    //     text: "Anda tidak akan dapat memulihkan data ini!",
                    //     type: "warning",
                    //     showCancelButton: true,
                    //     confirmButtonColor: "#DD6B55",
                    //     confirmButtonText: "Ya, Hapus!",
                    //     cancelButtonText: "Batal",
                    //     closeOnConfirm: false
                    // }, function () {

                    //     if (existingData != "") {
                    //         $.ajax({
                    //             type: "POST",
                    //             url: "{{ route('admin.buys.delete-detail') }}",
                    //             data: ({
                    //                 ix: existingData
                    //             }),
                    //             success: function () {

                    //             }
                    //         });
                    //     }

                    //     $(another).remove();

                    //     swal("Berhasil!", "Data berhasil dihapus.", "success");
                    //     resetData()

                    // });
                });



                $(".kt_datepicker_2").flatpickr({
                    dateFormat: "Y-m-d",
                });

                $(this).find(".modalAccount2").off().on("click", function() {
                    getAccount2(another);
                    $('#account-data-modal2').modal('show');
                });

                $(this).find('.currency').on({
                    keyup: function() {
                        formatCurrency($(this));
                    },
                    blur: function() {
                        formatCurrency($(this), "blur");
                    }
                });

                $(this).find(".currency2").on({
                    keyup: function() {
                        formatCurrency2($(this));
                    },
                    blur: function() {
                        formatCurrency2($(this), "blur");
                    }
                });

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

                var count_item = $('#get-item-data').find('.item-list').length;
                if (count_item != 0) {
                    $(".items-data").val(count_item);
                } else {
                    $(".items-data").val('');
                }

                $(".harga").on('keyup', function() {
                    let harga = parseFloat($(this).val().replace(/[^0-9.]/g, ''));
                    let jumlah = parseFloat($(this).closest("tr").find(".jumlah").val().replace(/[^0-9.]/g,
                        ''));
                    let total = isNaN(harga) || isNaN(jumlah) ? 0 : harga * jumlah;
                    let formatter = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                    let total_format = formatter.format(total).replace("IDR", "")
                .trim(); // Menghapus teks 'IDR'
                    $(this).closest("tr").find(".total").val(total_format);

                    let total_keseluruhan = 0;
                    $(this).closest("tbody").find(".total").each(function() {
                        total_keseluruhan += parseFloat($(this).val().replace(/[^0-9.]/g, ''));
                    });
                    let total_keseluruhan_format = formatter.format(total_keseluruhan).replace("IDR", "")
                        .trim(); // Menghapus teks 'IDR'
                    $(".total_keseluruhan").val(total_keseluruhan_format);
                });

                $(".jumlah").on('keyup', function() {
                    let harga = parseFloat($(this).closest("tr").find(".harga").val().replace(/[^0-9.]/g,
                        ''));
                    let jumlah = parseFloat($(this).val().replace(/[^0-9.]/g, ''));
                    let total = isNaN(harga) || isNaN(jumlah) ? 0 : harga * jumlah;
                    let formatter = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                    let total_format = formatter.format(total).replace("IDR", "")
                .trim(); // Menghapus teks 'IDR'
                    $(this).closest("tr").find(".total").val(total_format);

                    let total_keseluruhan = 0;
                    $(this).closest("tbody").find(".total").each(function() {
                        total_keseluruhan += parseFloat($(this).val().replace(/[^0-9.]/g, ''));
                    });
                    let total_keseluruhan_format = formatter.format(total_keseluruhan).replace("IDR", "")
                        .trim(); // Menghapus teks 'IDR'
                    $(".total_keseluruhan").val(total_keseluruhan_format);
                });


                index++;
            });

            if (index == 0) {
                var jumlah_detail = "";
            } else {
                var jumlah_detail = index;
            }

            $(".jumlah_detail").val(jumlah_detail);

            addValidation();
        }

        function getTotal() {
            var total = 0;
            $(".item-list").each(function() {
                total += parseFloat($(this).find('.total').val().replace(/[^0-9.]/g, ''));
            })
            let formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'IDR'
            });
            let total_format = formatter.format(total).replace("IDR", "").trim(); // Menghapus teks 'IDR'
            $(".total_keseluruhan").val(total_format);
        }

        function addValidation() {
            $(".item-list").each(function() {
                index = $(this).attr("childidx");

                validator.addField("item[" + index + "][item_variant_name]", {
                    validators: {
                        notEmpty: {
                            message: 'Product required'
                        }
                    }
                });

                validator.addField("item[" + index + "][harga]", {
                    validators: {
                        notEmpty: {
                            message: 'Item Price required'
                        }
                    }
                });

                validator.addField("item[" + index + "][jumlah]", {
                    validators: {
                        notEmpty: {
                            message: 'Quantity required'
                        }
                    }
                });

                validator.addField("item[" + index + "][unit]", {
                    validators: {
                        notEmpty: {
                            message: 'Unit required'
                        }
                    }
                });

                validator.addField("item[" + index + "][total]", {
                    validators: {
                        notEmpty: {
                            message: 'Price required'
                        }
                    }
                });

                // validator.addField("item[" + index + "][expired]", {
                //     validators: {
                //         notEmpty: {
                //             message: 'Expired required'
                //         }
                //     }
                // });

                // validator.addField("item[" + index + "][image]", {
                //     validators: {
                //         notEmpty: {
                //             message: 'Silahkan upload bukti pengeluaran biaya'
                //         }
                //     }
                // });
            });
        }

        function removeValidation() {
            $(".item-list").each(function() {
                index = $(this).attr("childidx");


                validator.removeField("item[" + index + "][item_variant_name]");

                validator.removeField("item[" + index + "][harga]");

                validator.removeField("item[" + index + "][jumlah]");

                validator.removeField("item[" + index + "][unit]");

                validator.removeField("item[" + index + "][total]");

                //validator.removeField("item[" + index + "][expired]");

                // validator.removeField("item[" + index + "][image]");
            });
        }
    </script>
@endpush
