@extends('administrator.layouts.main')

@section('content')
@if($edit->canceled_at == null)
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
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.stock_card') }}" class="text-muted text-hover-primary">Stock Card</a>
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
                <form id="form" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.stock_card.update') }}" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label required">Date</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="date" class="form-control kt_datepicker_1" value="{{ date('d-m-Y', strtotime($edit->date)) }}"/>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label required">Transaction Type</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-select" value="{{ $edit->transaction_type }}" disabled >
                                                <option value="in" {{ $edit->transaction_type == 'in' ? 'selected' : '' }}>In</option>
                                                <option value="out" {{ $edit->transaction_type == 'out' ? 'selected' : '' }}>Out</option>
                                                <option value="move_location" {{ $edit->transaction_type == 'move_location' ? 'selected' : '' }}>Move Location</option>
                                                <option value="transfer_to_store" {{ $edit->transaction_type == 'transfer_to_store' ? 'selected' : '' }}>Transfer To Store</option>
                                            </select>
                                            <input type="hidden" class="transaction_type" name="transaction_type" value="{{ $edit->transaction_type }}">
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label required">Warehouse</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="hidden" name="warehouse_id" class="form-control warehouse_id" value="{{ $edit->warehouse_id }}"/>
                                            <input type="text" name="warehouse_code" class="form-control warehouse_code" placeholder="Warehouse Code" value="{{ $edit->warehouse_code }}" readonly/>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="warehouse_name" class="form-control warehouse_name" placeholder="Warehouse Name" value="{{ $edit->warehouse_name }}" readonly/>
                                        </div>
                                        <div class="col-auto warehouse-modal d-none">
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
                                </div>
                                <div class="mb-10 fv-row destination_form" style="{{ $edit->transaction_type == 'move_location' ? 'display: block' : 'display: none' }}">
                                    <label class="form-label required">Destination Warehouse</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="hidden" name="destination_warehouse_id" class="form-control destination_warehouse_id" value="{{ $destination_warehouse != null ? $destination_warehouse->id : '' }}"/>
                                            <input type="text" name="destination_warehouse_code" class="form-control destination_warehouse_code" placeholder="Warehouse Code" value="{{ $destination_warehouse != null ? $destination_warehouse->code : '' }}" readonly/>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="destination_warehouse_name" class="form-control destination_warehouse_name" placeholder="Warehouse Name" value="{{ $destination_warehouse != null ? $destination_warehouse->name : '' }}" readonly/>
                                        </div>
                                        <div class="col-auto destination-warehouse-modal d-none">
                                            <a href="#" class="btn btn-sm btn-primary" id="destination-warehouse-data">
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
                                    <label class="required form-label">Status</label>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status" {{ $edit->status == 1 ? 'checked="checked"' : '' }}/>
                                        <label class="form-check-label fw-bold text-gray-400 ms-3" for="status">Active</label>
                                    </div>
                                </div>
                                <div class="mb-10 fv-row store_form" style="{{ $edit->transaction_type == 'transfer_to_store' ? 'display: block' : 'display: none' }}">
                                    <label class="form-label required">Store</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="hidden" name="store_id" class="form-control store_id" value="{{ $store != null ? $store->id : '' }}"/>
                                            <input type="text" name="store_name" class="form-control store_name" placeholder="Store Name" value="{{ $store != null ? $store->name : '' }}" readonly/>
                                        </div>
                                        <div class="col-auto store-modal {{ $stock_card_detail->count() >= 1 ? 'd-none' : '' }}">
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
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label required">Items</label>
                                    <!--end::Label-->
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="btn btn-sm btn-primary" id="item-data">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"
                                                    fill="none">
                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                        transform="rotate(-90 11.364 20.364)" fill="black" />
                                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                                </svg>
                                            </span>
                                            Select Items
                                        </a>
                                    </div>
                                    <!--begin::Input-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listDataItem">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-100px">Item Name</th>
                                                        <th class="min-w-100px">Item Variant Name</th>
                                                        <th class="min-w-50px">Quantity</th>
                                                        <th class="min-w-100px">Unit</th>
                                                        <th class="min-w-40px">Action</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600" id="get-item-data">
                                                    <?php $no=0; ?>
                                                    @foreach ($stock_card_detail as $row)
                                                        <?php $no++ ?>
                                                        <tr class="item-list" childidx="0" style="position: relative;" id="item{{ $no }}">
                                                            <input type="hidden" name="item[0][id]" value="{{ $row->id }}" />
                                                            <td>{{ $row->item_name }}</td>
                                                            <td>
                                                                {{ $row->item_variant_name }}
                                                                <input type="hidden" class="item_variant_id item-variant-id" name="item[0][item_variant_id]" value="{{ $row->item_variant_id }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-white text-end withseparator format-number quantity" name="item[0][quantity]" autocomplete="off" value="{{ (float) $row->quantity }}" data-max="{{ $row->stock }}" data-item="{{ $row->item_name }}" data-variant="{{ $row->item_variant_name }}" {{ $row->canceled_at == null ? '' : 'disabled'}}>
                                                                <input type="hidden" class="qty-data" name="item[0][old_quantity]" value="{{ $row->quantity_after_conversion }}">
                                                            </td>
                                                            <?php
                                                                $unit = App\Models\UnitConversion::select(DB::raw('unit_conversions.new_unit as name, unit_conversions.id'))
                                                                                        ->where("unit_conversions.item_variant_id", $row->item_variant_id)
                                                                                        ->where("unit_conversions.status", 1)
                                                                                        ->get();
                                                            ?>
                                                            <td>
                                                                <select class="form-select unit-option" name="item[0][unit_id]" id="unit{{ $no }}" {{ $row->canceled_at == null ? '' : 'disabled'}}>
                                                                    <option value="0" {{ $row->unit_id == 0 ? 'selected' : '' }}>{{ $row->unit_name }}</option>
                                                                    @foreach ($unit as $unit)
                                                                        <option value="{{ $unit->id }}" {{ $unit->id == $row->unit_id ? 'selected' : ''  }}>{{ $unit->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" class="unit-id" value="{{ $row->unit_id }}">
                                                            </td>
                                                            <td>
                                                                <input type="hidden" class="id-item" value="{{ $row->id }}">
                                                                @if($row->canceled_at == null)
                                                                    <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary removeData">
                                                                        <span class="svg-icon svg-icon-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                                            </svg>
                                                                        </span>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" class="stock_card-data" name="stock_cards">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.stock_card') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
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
                                        <th class="min-w-100px">Code</th>
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
    
    <div class="modal fade" id="destination-warehouse-data-modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Browse Destination Warehouse</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search" id="searchDestinationWarehouseTable" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="dataDestinationWarehouse">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th>No</th>
                                        <th class="min-w-100px">Code</th>
                                        <th class="min-w-100px">Name</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-destination-warehouse">Select</button>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
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
    
    <div class="modal fade" id="item-data-modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Browse Item</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search" id="searchItemTable" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="dataItem">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th>No</th>
                                        <th class="min-w-100px">Item Name</th>
                                        <th class="min-w-100px">Item Variant Name</th>
                                        <th class="min-w-50px">Stock</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-item">Select</button>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <table class="template-data" style="display: none;">
        <tr class="template-item-list" childidx="0" style="position: relative;">
            <td class="px-0 item_name"></td>
            <td class="px-0 item_variant_name"></td>
            <td>
                <input type="hidden" class="item_variant_id" name="item[0][item_variant_id]">
                <input type="text" class="form-control form-white text-end withseparator format-number new_qty quantity" name="item[0][quantity]" autocomplete="off" data-max="" data-item="" data-variant="">
                <input type="hidden" class="qty-data" name="item[0][old_quantity]" value="0">
            </td>
            <td>
                <select class="form-select unit-data" name="item[0][unit_id]">
                    <option class="unit_main"></option>
                </select>
            </td>
            <td>
                <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary removeData">
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
    </table>
@endif
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/stock_card.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var count_item = $('#get-item-data').find('.item-list').length;
            if(count_item != 0){
                $(".stock_card-data").val(count_item);
                $(".warehouse-modal").addClass('d-none');
                $(".destination-warehouse-modal").addClass('d-none');
                $(".store-modal").addClass('d-none');
            }else{
                $(".stock_card-data").val('');
                $(".warehouse-modal").removeClass('d-none');
                $(".destination-warehouse-modal").removeClass('d-none');
                $(".store-modal").removeClass('d-none');
            }
            
            $(".kt_datepicker_1").flatpickr({
                dateFormat: "d-m-Y",
            });

            resetData();
        });

        function resetData() {
            var index = 0;
            $(".item-list").each(function () {
        		var another = this;
                search_index = $(this).attr("childidx");
                $(this).find('input,select').each(function () {
                    this.name = this.name.replace('[' + search_index + ']', '[' + index + ']');
                    $(another).attr("childidx", index);
                });

                $(this).find('.quantity').each(function(){
                    var data_max = $(this).data('max');
                    var data_item = $(this).data('item');
                    var data_variant = $(this).data('variant');
                    validator.addField("item[" + index + "][quantity]", {
                        validators: {
                            notEmpty: {
                                message: 'Quantity is required'
                            },
                            between: {
                                min: 1,
                                max: data_max,
                                message: data_item+' - '+data_variant+' Out Of Stock!'
                            },
                        }
                    });
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

                $(this).find(".removeData").off().on("click", function () {
                    var existingData = $(another).find('.id-item').val();
                    var itemVariantId = $(another).find('.item-variant-id').val();
                    var transactionType = $('.transaction_type').val();
                    var warehouseId = $('.warehouse_id').val();
                    var quantity = $(another).find('.qty-data').val();
                    var unitId = $(another).find('.unit-id').val();
                    var destinationWarehouseId = $('.destination_warehouse_id').val();
                    var storeId = $('.store_id').val();
                    // console.log(existingData)
                    
                    if(transactionType == 'in' || transactionType == 'out'){
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
                            if (existingData != null) {
                                $.ajax({
                                    type: "DELETE",
                                    url: "{{ route('admin.stock_card.delete-detail') }}",
                                    data: ({
                                        "_token": "{{ csrf_token() }}",
                                        "_method": 'DELETE',
                                        ix: existingData,
                                        item_variant_id: itemVariantId,
                                        transaction_type: transactionType,
                                        warehouse_id: warehouseId,
                                        quantity: quantity,
                                        unit_id: unitId,
                                        destination_warehouse_id: destinationWarehouseId,
                                        store_id: storeId,
                                    }),
                                    success: function(resp){
                                        if(transactionType == 'in' || transactionType == 'out'){
                                            if(resp.success){
                                                Swal.fire('Deleted!', 'Data has been deleted', 'success');
                                            }else{
                                                Swal.fire('Failed!', 'Deleted data failed', 'error');
                                            }

                                            $(another).remove();
                                        }else{
                                            if(resp.success){
                                                Swal.fire('Canceled!', 'Data has been canceled', 'success');
                                            }else{
                                                Swal.fire('Failed!', 'Canceled data failed', 'error');
                                            }

                                            $(another).find('.quantity').attr('disabled', true);
                                            $(another).find('.unit-option').attr('disabled', true);
                                            $(another).find('.removeData').remove();
                                        }
                                        
                                        resetData();
                                        
                                        var count_item = $('#get-item-data').find('.item-list').length;
                                        if(count_item != 0){
                                            $(".stock_card-data").val(count_item);
                                            $(".warehouse-modal").addClass('d-none');
                                            $(".destination-warehouse-modal").addClass('d-none');
                                            $(".store-modal").addClass('d-none');
                                        }else{
                                            $(".stock_card-data").val('');
                                            $(".warehouse-modal").removeClass('d-none');
                                            $(".destination-warehouse-modal").removeClass('d-none');
                                            $(".store-modal").removeClass('d-none');
                                        }
                                    },
                                    error: function (resp) {
                                        console.log(resp);
                                        Swal.fire("Error!", "Something went wrong.", "error");
                                    }
                                });
                            }else{
                                $(another).remove();

                                resetData();

                                var count_item = $('#get-item-data').find('.item-list').length;
                                if(count_item != 0){
                                    $(".stock_card-data").val(count_item);
                                    $(".warehouse-modal").addClass('d-none');
                                    $(".destination-warehouse-modal").addClass('d-none');
                                    $(".store-modal").addClass('d-none');
                                }else{
                                    $(".stock_card-data").val('');
                                    $(".warehouse-modal").removeClass('d-none');
                                    $(".destination-warehouse-modal").removeClass('d-none');
                                    $(".store-modal").removeClass('d-none');
                                }
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
                    //             url: "{{ route('admin.stock_card.delete-detail') }}",
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

                $(this).find('.currency').on({
                    keyup: function () {
                        formatCurrency($(this));
                    },
                    blur: function () {
                        formatCurrency($(this), "blur");
                    }
                });

                $(this).find(".currency2").on({
                    keyup: function () {
                        formatCurrency2($(this));
                    },
                    blur: function () {
                        formatCurrency2($(this), "blur");
                    }
                });

                $(this).find(".format-number").keydown(function (e) {
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) { return; }
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) { e.preventDefault(); }
                });

                index++;
            });
        }

        // get data warehouse
        $('#warehouse-data').off().on('click', function () {
            getWarehouse();
            $('#warehouse-data-modal').modal('show');
        });

        function getWarehouse() {
            $('#searchWarehouseTable').keyup(function(){
                $('#dataWarehouse').DataTable().search($(this).val()).draw() ;
            });
            $("#dataWarehouse").DataTable().destroy();
            $('#dataWarehouse tbody').remove();
            $('#dataWarehouse').DataTable({
                "searching": true,
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
                    "url": "{{ route('admin.stock_card.warehouse-data') }}",
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
                    
                    $(".destination_warehouse_id").val('');
                    $(".destination_warehouse_code").val('');
                    $(".destination_warehouse_name").val('');
                }

        		$('#warehouse-data-modal').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });
        }
        
        // get data destination warehouse
        $('#destination-warehouse-data').off().on('click', function () {
            getDestinationWarehouse();
            $('#destination-warehouse-data-modal').modal('show');
        });

        function getDestinationWarehouse() {
            $('#searchDestinationWarehouseTable').keyup(function(){
                $('#dataDestinationWarehouse').DataTable().search($(this).val()).draw() ;
            });
            $("#dataDestinationWarehouse").DataTable().destroy();
            $('#dataDestinationWarehouse tbody').remove();
            $('#dataDestinationWarehouse').DataTable({
                "searching": true,
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
                    "url": "{{ route('admin.stock_card.destination-warehouse-data') }}",
                    "dataType": "JSON",
                    "type": "GET",
                    "data": {
                        id: $(".warehouse_id").val(),
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

            var table_destination_warehouse = $('#dataDestinationWarehouse').DataTable();

            $('#selectData-destination-warehouse').on('click', function (e, dt, node, config) {
                var rows_selected = table_destination_warehouse.rows( { selected: true } ).data();
                // console.log(rows_selected[0]['code']);

                if(rows_selected[0] != undefined){
                    $(".destination_warehouse_id").val(rows_selected[0]['id']);
                    $(".destination_warehouse_code").val(rows_selected[0]['code']);
                    $(".destination_warehouse_name").val(rows_selected[0]['name']);
                }

                $('#destination-warehouse-data-modal').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });
        }
        
        // get data store
        $('#store-data').off().on('click', function () {
	        if ($(".warehouse_id").val() == "") {
                Swal.fire('Oops!', 'Please select warehouse', 'warning');
            }else{
                getStore();
                $('#store-data-modal').modal('show');
            }
        });

        function getStore() {
            $('#searchStoreTable').keyup(function(){
                $('#dataStore').DataTable().search($(this).val()).draw() ;
            });
            $("#dataStore").DataTable().destroy();
            $('#dataStore tbody').remove();
            $('#dataStore').DataTable({
                "searching": true,
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
                    "url": "{{ route('admin.stock_card.store-data') }}",
                    "dataType": "JSON",
                    "type": "GET",
                    "data": {
                        id: $(".store_id").val(),
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
                // console.log(rows_selected[0]['code']);

                if(rows_selected[0] != undefined){
                    $(".store_id").val(rows_selected[0]['id']);
                    $(".store_name").val(rows_selected[0]['name']);
                }

                $('#store-data-modal').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });
        }

        // get data item
        $('#item-data').off().on('click', function () {
            getItem();
            $('#item-data-modal').modal('show');
        });

        function getItem() {
            $('#searchItemTable').keyup(function(){
                $('#dataItem').DataTable().search($(this).val()).draw() ;
            });
            $("#dataItem").DataTable().destroy();
            $('#dataItem tbody').remove();
            $('#dataItem').DataTable({
                "searching": true,
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
                    "url": "{{ route('admin.stock_card.item-data') }}",
                    "dataType": "JSON",
                    "type": "GET",
                    "data": {
                        warehouse_id: $(".warehouse_id").val(),
                        datatable: true,
                    },
                },
                'select': {
                    'style': 'multi'
                },
                "columns": [
                    {
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    { "data": "item_name" },
                    { "data": "item_variant_name" },
                    {
                        render: function(data, type, row, meta) {
                            if(row.stock == null){
                                return '0';
                            }else{
                                return meta.settings.fnFormatNumber(parseFloat(row.stock));
                            }
                        },
                    },
                ]

            });

            var table_item = $('#dataItem').DataTable();

            $('#selectData-item').on('click', function (e, dt, node, config) {
                var rows_selected = table_item.rows( { selected: true } ).data();

                $.each(rows_selected, function () {
                    daftar_item = new Array();
                    $('#listDataItem').find('.item_variant_id').each(function (ind, value) {
                        daftar_item[ind] = this.value;
                    });
                    var exist_item = daftar_item.indexOf(this['item_variant_id'].toString());
                    
                    
        			if (parseInt(exist_item) == -1) {
                        var tr_clone = $(".template-item-list").clone();

                        tr_clone.find(".item_variant_id").val(this['item_variant_id']);
                        tr_clone.find(".item_name").text(this['item_name']);
                        tr_clone.find(".item_variant_name").text(this['item_variant_name']);
                        tr_clone.find(".unit_main").val('0');
                        tr_clone.find(".unit_main").text(this['unit_name']);
                        tr_clone.find(".new_qty").attr("data-max", this['stock']);
                        tr_clone.find(".new_qty").attr("data-item", this['item_name']);
                        tr_clone.find(".new_qty").attr("data-variant", this['item_variant_name']);
                        
                        if(this['item_variant_id'] != null){
                            $.ajax({
                                url: "{{ route('admin.stock_card.unit-data') }}",
                                data: { 'item_variant_id' : this['item_variant_id'] },
                                type: "get",
                                cache: false,
                                async: false,
                                success: function (data) {
                                    var option = "";
                                    $.each(data, function (i) {
                                        option += "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
                                    });
                                    tr_clone.find(".unit-data").append(option);
                                }
                            });
                        }

                        tr_clone.removeClass('template-item-list');
                        tr_clone.addClass('item-list');
                        $("#listDataItem").append(tr_clone);
                        
                        var count_item = $('#get-item-data').find('.item-list').length;
                        if(count_item != 0){
                            $(".stock_card-data").val(count_item);
                            $(".warehouse-modal").addClass('d-none');
                            $(".destination-warehouse-modal").addClass('d-none');
                            $(".store-modal").addClass('d-none');
                        }else{
                            $(".stock_card-data").val('');
                            $(".warehouse-modal").removeClass('d-none');
                            $(".destination-warehouse-modal").removeClass('d-none');
                            $(".store-modal").removeClass('d-none');
                        }

                        resetData();
                    }

                });

        		$('#item-data-modal').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });
        }
    </script>
@endpush
