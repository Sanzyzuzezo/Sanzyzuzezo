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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Sales</h1>
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
                            <a href="{{ route('admin.sales') }}" class="text-muted text-hover-primary">Sales</a>
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
                <!--begin::Form-->
                <form id="form" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.sales.update') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="inputId" value="{{ $data->id }}">
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
                                                    value="{{ date('d-m-Y', strtotime($data->date)) }}" />
                                            </div>
                                        </div>
                                        <div class="text-muted fs-7">
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label required">Sales Number</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="sales_number" placeholder="Nomor Pembelian"
                                                    id="sales_number" class="form-control bg-secondary"
                                                    value="{{ $data->sales_number }}" readonly />
                                                <input type="hidden" id="status_sales_number" name="status_sales_number"
                                                    value="false" class="form-control bg-secondary" />
                                            </div>
                                            <div class="input-group-append col-auto">
                                                <button class="btn btn-outline-success" type="button"
                                                    id="triggerStatusSalesNumber">Ubah</button>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-7">
                                            <small class="form-text text-muted">Nomor produksi dapat diisi manual atau
                                                otomatis</small>
                                        </div>
                                        <div class="text-muted fs-7">
                                            <small id="salesNumberHelp" class="form-text text-muted">Klik tombol "Ubah"
                                                untuk mengisi manual!</small>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label required">Customer</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="customer_name" class="form-control bg-secondary"
                                                    id="customer_name" placeholder="Customer Name"
                                                    value="{{ $data->customer_name }}" readonly />
                                                <input type="hidden" name="customer_id" id="customer_id"
                                                    class="form-control" value="{{ $data->customer_id }}" />
                                            </div>
                                            <div class="col-auto">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary"
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
                                        <label class="form-label required">Courier</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="courier_title"
                                                    class="form-control bg-secondary" id="courier_title"
                                                    placeholder="Courier Name" value="{{ $data->courier_title }}"
                                                    readonly />
                                                <input type="hidden" name="courier_id" id="courier_id"
                                                    class="form-control" value="{{ $data->courier_id }}" />
                                            </div>
                                            <div class="col-auto">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal" id="triggerCourier">
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
                                                    autocomplete="off">{{ $data->information }}</textarea>
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
                                        <div class="d-flex justify-content-end">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary"
                                                id="triggerItemVariant">
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
                                                Select Items
                                            </a>
                                        </div>
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                    id="tableDataSales">
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
                                                            <th class="min-w-50px">Unit</th>
                                                            <th class="min-w-100px">Total</th>
                                                            <th class="min-w-40px">Action</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600" id="bodyTableDataSales">
                                                        @foreach ($data_detail as $number => $data)
                                                            <tr id="row_detail_{{ $data['item_variant_id'] }}"
                                                                class="row_detail" childidx="0">
                                                                <td class="no-item">{{ $number + 1 }}</td>
                                                                <td class="img-item"><img width="50px"
                                                                        src="{{ img_src($data['data_file'], 'product') }}"
                                                                        alt="">
                                                                </td>
                                                                <td class="nama_item-item">{{ $data['nama_item'] }}</td>
                                                                <td class="nama_item_variant-item">
                                                                    {{ $data['nama_item_variant'] }}</td>
                                                                <td class="price-item text-end">
                                                                    Rp {{ number_format($data['price'], 0, ',', '.') }}
                                                                </td>
                                                                <td class="fv-row">
                                                                    <input type="hidden" class="sales_detail_id-item"
                                                                        name="detail[{{ $number }}][sales_detail_id]"
                                                                        value="{{ $data['id'] }}">
                                                                    <input type="hidden" class="item_variant_id-item"
                                                                        name="detail[{{ $number }}][item_variant_id]"
                                                                        value="{{ $data['item_variant_id'] }}">
                                                                    <input type="text"
                                                                        class="form-control text-end quantity-item"
                                                                        name="detail[{{ $number }}][quantity]"
                                                                        autocomplete="off"
                                                                        value="{{ number_format($data['quantity'], 0, ',', ',') }}">
                                                                </td>
                                                                <?php
                                                                $variant = App\Models\ProductVariant::select(DB::raw('units.name, 0 as id, 1 as quantity_after_conversion'))
                                                                    ->where('product_variants.id', $data->item_variant_id) // <-- Complete the statement
                                                                    ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id');
                                                                
                                                                $uk = App\Models\UnitConversion::select(DB::raw('unit_conversions.new_unit as name, unit_conversions.id, unit_conversions.quantity as quantity_after_conversion'))
                                                                    ->leftJoin(DB::raw('units'), 'units.id', '=', 'unit_conversions.unit_id')
                                                                    ->where('unit_conversions.item_variant_id', $data->item_variant_id);
                                                                
                                                                $unit = $variant->union($uk)->get();

                                                                foreach ($unit as $val){
                                                                    if ($val->id === $data->unit_id) {
                                                                        $qty_after = $val->quantity_after_conversion;
                                                                    }
                                                                }
                                                                ?>
                                                                <td class="fv-row">
                                                                    <input type="hidden"
                                                                        class="quantity_after_conversion-item"
                                                                        name="detail[{{ $number }}][quantity_after_conversion]"
                                                                        value="{{ floatVal($qty_after) }}">
                                                                    <select class="form-select unit-item"
                                                                        name="detail[{{ $number }}][unit_id]" data-control="select2" data-hide-search="true" data-placeholder="Please Select">
                                                                        <option value="">Please Select</option>
                                                                        @foreach ($unit as $unit)
                                                                            <option value="{{ $unit->id }}"
                                                                                data-quantity_after_conversion="{{ floatVal($unit->quantity_after_conversion) }}"
                                                                                {{ $unit->id === $data->unit_id ? 'selected' : '' }}>
                                                                                {{ $unit->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="fv-row">
                                                                    <input type="text"
                                                                        name="detail[{{ $number }}][total]"
                                                                        class="form-control bg-secondary total-item text-end"
                                                                        value="Rp {{ number_format($data['total'], 0, ',', '.') }}"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0)"
                                                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary triggerDeleteDetail {{ $data_detail->count() === 1 ? 'data_disabled' : '' }}"
                                                                        data-id="{{ $data['item_variant_id'] }}"
                                                                        data-sales-id="{{ $data['id'] }}"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top">
                                                                        <span class="svg-icon svg-icon-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none">
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
                                                                            </svg>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr
                                                            class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <td colspan="6" class="text-end">Jumlah</td>
                                                            <td class="text-end">
                                                                <div id="total_sales_amount">Rp
                                                                    {{ number_format($data->total_sales_amount, 0, ',', '.') }}
                                                                </div><input type="hidden" name="total_sales_amount"
                                                                    value="{{ $data->total_sales_amount }}"
                                                                    id="input_total_sales_amount">
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
                            <a href="{{ route('admin.sales') }}" id="triggerCancelForm"
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

    <div class="modal fade" id="item_variant_modal" tabindex="-1" aria-hidden="true">
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
                                    id="searchItemVariantDatatable" autocomplete="off" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="item_variant_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item Name</th>
                                        <th class="min-w-100px">Item Variant Name</th>
                                        <th class="min-w-50px">Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="item_variant_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-item_variant">Select</button>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
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

    <div class="modal fade" id="courier_modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Browse Courier</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchCourierModal" autocomplete="off" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="courier_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Courier Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="courier_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-courier">Select</button>
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
                            message: "Date is required",
                        },
                    },
                },
                sales_number: {
                    validators: {
                        notEmpty: {
                            message: "Sales number is required",
                        },
                        remote: {
                            message: 'Sales Number is exist',
                            method: 'POST',
                            url: '{{ route('admin.sales.isExistSalesNumber') }}',
                            data: function() {
                                return {
                                    _token: '{{ csrf_token() }}',
                                    sales_number: $('#sales_number').val(),
                                    id: $('#inputId').val(),
                                }
                            },
                        },
                    },
                },
                jumlah_detail: {
                    validators: {
                        notEmpty: {
                            message: "Detail is required is required",
                        },
                    },
                },
                courier_title: {
                    validators: {
                        notEmpty: {
                            message: "Courier is required",
                        },
                    },
                },
                customer_name: {
                    validators: {
                        notEmpty: {
                            message: "Customer is required",
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

            // Initialize DataTables
            var item_variant_datatable = $('#item_variant_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip'
            });


            $('#triggerItemVariant').on('click', function() {
                $('#item_variant_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.sales.getDataItemVariant') }}',
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#item_variant_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="item_variant_id"><td><input type="checkbox" class="form-check-input item_variant_id_checkbox" name="item_variant_id_checkbox" id="item_variant_id' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="item_variant_id' +
                                data[i]
                                .id + '">' + data[i].nama_item +
                                '</label></td><td><label for="item_variant_id' +
                                data[i]
                                .id + '">' + data[i].nama_item_variant +
                                '</label></td><td><label for="item_variant_id' +
                                data[i]
                                .id + '">' + data[i].stock +
                                '</label></td></tr>'
                            )).draw(false);

                        });

                        table.draw(false);
                        $('#searchItemVariantDatatable').keyup(function() {
                            table.search($(this).val()).draw();
                        });
                    }
                });
            });

            $('#selectData-item_variant').on('click', function() {
                $('#item_variant_datatable').find('input[type="checkbox"]:checked').each(function(i) {
                    var number = $('#bodyTableDataSales').find('tr').length;
                    var id = $(this).val();

                    $.ajax({
                        url: "{{ route('admin.sales.getDataItemVariant') }}",
                        data: {
                            id: id
                        },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(data) {
                            if ($('#row_detail_' + id).length == 0) {
                                $('#bodyTableDataSales').append(`
    <tr id="row_detail_${id}" class="row_detail" childidx="0">
        <td class="no-item">${number + 1}</td>
        <td class="img-item"><img width="50px" src="${data.data_file ? (`{{ asset('administrator/assets/media/products/') }}/${data.data_file}`) : "http://placehold.it/500x500?text=Not%20Found"}" alt=""></td>
        <td class="nama_item-item">${data.nama_item}</td>
        <td class="nama_item_variant-item">${data.nama_item_variant}</td>
        <td class="price-item text-end">${formatRupiah(data.price)}</td>
        <td class="fv-row">
            <input type="hidden" class="sales_detail_id-item" name="detail[${number}][sales_detail_id]" value="">
            <input type="hidden" class="item_variant_id-item" name="detail[${number}][item_variant_id]" value="${data.id}">
            <input type="text" class="form-control text-end quantity-item" name="detail[${number}][quantity]" autocomplete="off">
        </td>
        <td class="fv-row">
            <input type="hidden" class="quantity_after_conversion-item" name="detail[${number}][quantity_after_conversion]" value="0">
            <select class="form-select unit-item" name="detail[0][unit_id]" data-control="select2" data-hide-search="true" data-placeholder="Please Select">
                                <option value="">Please Select</option>
                            </select>
        </td>
        <td class="fv-row"><input type="text" name="detail[${number}][total]" class="form-control bg-secondary total-item text-end" value="Rp 0" readonly></td>
        <td>
            <a href="javascript:void(0)" class="btn btn-sm btn-icon btn-light btn-active-light-primary triggerDeleteDetail" data-id="${id}" data-sales-id="" data-sales_detail_id="" data-bs-toggle="tooltip" data-bs-placement="top">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                    </svg>
                </span>
            </a>
        </td>
    </tr>
`);
                                $.ajax({
                                    url: "{{ route('admin.sales.getUnit') }}",
                                    data: {
                                        'id': data.id
                                    },
                                    type: "get",
                                    cache: false,
                                    async: false,
                                    success: function(data) {
                                        $('#row_detail_' + id).find(
                                            '.unit-item').empty()
                                        $('#row_detail_' + id).find(
                                            '.unit-item').append(
                                            "<option value=''>Please Select</option>"
                                            );
                                        for (var i = 0; i < data
                                            .length; i++) {
                                            $('#row_detail_' + id).find(
                                                '.unit-item').append(
                                                `<option value='${data[i].id}' data-quantity_after_conversion="${parseFloat(data[i].quantity_after_conversion)}">${data[i].name}</option>`
                                            );
                                        }
                                    }
                                });
                                resetData();
                                totalAmount();
                            }
                        }
                    });
                });

                $('#item_variant_modal').modal('hide');
            })

            var inputSalesNumber = document.getElementsByName("sales_number")[0];
            inputSalesNumber.classList.add("bg-secondary")

            $("#status_sales_number").val(false)

            $('#triggerStatusSalesNumber').off().on('click', function(e) {
                inputSalesNumber.readOnly = !inputSalesNumber.readOnly;
                if (inputSalesNumber.readOnly == false) {
                    inputSalesNumber.classList.remove("bg-secondary")
                } else {
                    inputSalesNumber.classList.add("bg-secondary")

                    let val_sales_number = '{{ $data->sales_number }}';
                    $('#sales_number').val(val_sales_number)
                    $("#status_sales_number").val(false)
                }

                var salesNumberHelp = document.getElementById("salesNumberHelp");
                salesNumberHelp.innerHTML = inputSalesNumber.readOnly ?
                    "Klik tombol 'Ubah' untuk mengisi manual!" :
                    "Klik tombol 'Ubah' untuk mengisi otomatis!";
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
                    url: '{{ route('admin.sales.getDataCustomer') }}',
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
                    url: "{{ route('admin.sales.getDataCustomer') }}",
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

            // Variable to store checkbox state
            var checkboxStateCourir = {};

            // Event delegation for checkboxes
            $('#courier_datatable').on('click', 'input:checkbox[name="courier_id_checkbox"]', function() {
                var $box = $(this);
                var courierId = $box.val();

                // Update checkbox state
                checkboxStateCourir[courierId] = $box.is(':checked');

                // Uncheck all other checkboxes in the same group
                var group = 'input:checkbox[name="courier_id_checkbox"]';
                $(group).not($box).prop('checked', false);
            });

            // Initialize DataTables
            var courier_datatable = $('#courier_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            // Reapply the event handler and update checkboxes after each table draw
            courier_datatable.on('draw', function() {
                // Update checkboxes based on stored state
                $('#courier_datatable input:checkbox[name="courier_id_checkbox"]').each(function() {
                    var $box = $(this);
                    var courierId = $box.val();

                    if (checkboxStateCourir[courierId]) {
                        $box.prop('checked', true);
                    } else {
                        $box.prop('checked', false);
                    }
                });

                // Clear the state of checkboxes when switching pages
                $('#courier_datatable input:checkbox').prop('checked', false);
            });

            $('#triggerCourier').on('click', function() {
                $('#courier_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.sales.getDataCourier') }}',
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#courier_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="courier"><td><input type="checkbox" class="form-check-input courier_id_checkbox" name="courier_id_checkbox" id="courier_' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="courier_' +
                                data[i]
                                .id + '">' + data[i].title +
                                '</label></td><td><label for="courier'
                            )).draw(false);

                        });
                        table.draw(false);
                        $('#searchCourierModal').keyup(function() {
                            table.search($(this).val()).draw();
                        });
                    }
                });
            });

            $('#selectData-courier').on('click', function() {
                var courier = $('#courier_datatable').find(
                        'input[type="checkbox"]:checked')
                    .val();

                $.ajax({
                    url: "{{ route('admin.sales.getDataCourier') }}",
                    data: {
                        id: courier,
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        $('#courier_id').val(data.id)
                        $('#courier_title').val(data.title)
                    }
                });

                $('#courier_modal').modal('hide');
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
                        this.value = this.value.replace(/[^0-9]/g, '');
                        let finish = $(this).val(formatNumber($(this).val()));

                        let price = parseRupiah($(another).find('.price-item').text());
                        // console.log(price);
                        let parse = parseNumber($(this).val());
                        let quantity = parse;
                        let quantity_after_conversion = $(another).find(
                            '.quantity_after_conversion-item').val();

                        let total = price * quantity * quantity_after_conversion;
                        $(another).find('.total-item').val(formatRupiah(total));
                    });

                    $(this).find('.quantity-item').on('keyup', function() {
                        this.value = this.value.replace(/[^0-9]/g, '');
                        let finish = $(this).val(formatNumber($(this).val()));

                        let price = parseRupiah($(another).find('.price-item').text());
                        // console.log(price);
                        let parse = parseNumber($(this).val());
                        let quantity = parse;
                        let quantity_after_conversion = $(another).find(
                            '.quantity_after_conversion-item').val();

                        let total = price * quantity * quantity_after_conversion;
                        $(another).find('.total-item').val(formatRupiah(total));
                        resetData()
                        totalAmount()
                    });

                    $(this).find('.unit-item').on('change', function() {
                        let qty = $(this).find('option:selected').data('quantity_after_conversion');
                        $(another).find('.quantity_after_conversion-item').val(qty)
                        let price = parseRupiah($(another).find('.price-item').text());
                        // console.log(price);
                        let parse = parseNumber($(another).find('.quantity-item').val());
                        let quantity = parse;
                        let quantity_after_conversion = $(this).find('option:selected').data(
                            'quantity_after_conversion');

                        let total = price * quantity * quantity_after_conversion;
                        $(another).find('.total-item').val(formatRupiah(total));
                        resetData()
                        totalAmount()
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
                        let sales_detail_id = $(this).data('sales-id');
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
                                if (sales_detail_id != '') {
                                    $.ajax({
                                        type: "DELETE",
                                        url: "{{ route('admin.sales.deleteDetail') }}",
                                        data: ({
                                            "_token": "{{ csrf_token() }}",
                                            "_method": 'DELETE',
                                            id: sales_detail_id,
                                        }),
                                        success: function(response) {
                                            console.log(response)
                                            Swal.fire('Deleted!',
                                                response.message,
                                                response.status);
                                            $("#row_detail_" + id).remove();
                                            resetData();
                                            totalAmount();
                                            $.ajax({
                                                type: "POST",
                                                url: "{{ route('admin.sales.updateTotalSalesAmount') }}",
                                                data: ({
                                                    "_token": "{{ csrf_token() }}",
                                                    "_method": 'PUT',
                                                    id: sales_detail_id,
                                                    total_sales_amount: parseRupiah(
                                                        $(
                                                            '#total_sales_amount'
                                                        )
                                                        .text()
                                                    ),
                                                }),
                                            });
                                        },
                                        error: function(response) {
                                            console.log(response)
                                            Swal.fire("Error!",
                                                response.responseJSON
                                                .message,
                                                response.responseJSON.status
                                            );
                                        }
                                    });
                                } else {
                                    Swal.fire('Deleted!',
                                        'Data has been deleted',
                                        'success');
                                    $("#row_detail_" + id).remove();
                                    resetData();
                                    totalAmount();
                                }
                                trLengthDataDisabled(another)
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
                        // console.log(xx)/
                        return xx;

                    }

                    validator.addField("detail[" + index + "][quantity]", {
                        validators: {
                            notEmpty: {
                                message: 'Quantity is required!'
                            },
                            between: {
                                min: 1,
                                max: 9999,
                                message: `Quantity must be greater than 0 !`,
                            }
                        }
                    });

                    validator.addField("detail[" + index + "][unit_id]", {
                        validators: {
                            notEmpty: {
                                message: 'Unit is required!'
                            }
                        }
                    });
                    
                    index++;
                });

                var no = $('#bodyTableDataSales').find('tr').length;
                if (no == 0) {
                    no = '';
                }
                $('.jumlah_detail').val(no);
            }

            function formatRupiah(amount) {
                // Use Number.prototype.toLocaleString() to format the number as currency
                return 'Rp ' + Number(amount).toLocaleString('id-ID');
            }

            function parseRupiah(rupiahString) {
                // Remove currency symbol, separators, and parse as integer
                return parseInt(rupiahString.replace(/[^\d]/g, ''));
            }

            function formatNumber(number) {
                // Use Number.prototype.toLocaleString() to format the number as currency
                return Number(number).toLocaleString('id-ID');
            }

            function parseNumber(number) {
                // Remove currency symbol, separators, and parse as integer
                return parseInt(number.replace(/[^\d]/g, ''));
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

                $("#total_sales_amount").text(formatRupiah(total_nominal));
                $("#input_total_sales_amount").val(total_nominal);
            }

        });

        function trLengthDataDisabled(another) {
            var number = $('#bodyTableDataSales').find('tr').length;

            if (number <= 1) {
                $(another).find('.triggerDeleteDetail').addClass('data_disabled')
            }
        }
    </script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
@endpush
