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
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.produksi') }}" class="text-muted text-hover-primary">Production</a>
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
                <form id="form" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.produksi.update') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$edit->id}}">
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
                                                <input type="text" name="date" class="form-control kt_datepicker_1"
                                                    placeholder="Date" value="{{ date('d-m-Y', strtotime($edit->date)) }}" />
                                            </div>
                                        </div>
                                        <div class="text-muted fs-7">
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label required">Production Number</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="nomor_produksi" placeholder="Nomor Pembelian"
                                                    id="nomor_produksi" class="form-control bg-secondary"
                                                    value="{{ $edit->no_production }}" readonly />
                                                <input type="hidden" id="status_nomor_produksi"
                                                    name="status_nomor_produksi" value="false"
                                                    class="form-control bg-secondary" />
                                            </div>
                                            <div class="input-group-append col-auto">
                                                <button class="btn btn-outline-success" type="button"
                                                    id="btnToggleNomorProduksi">Ubah</button>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-7">
                                            <small class="form-text text-muted">Nomor produksi dapat diisi manual atau
                                                otomatis</small>
                                        </div>
                                        <div class="text-muted fs-7">
                                            <small id="nomorProduksiHelp" class="form-text text-muted">Klik tombol "Ubah"
                                                untuk mengisi manual!</small>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Warehouse</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="gudang_name" class="form-control bg-secondary"
                                                    id="gudang_name" placeholder="Warehouse Name"
                                                    value="{{ $edit->nama_warehouse }}" readonly />
                                                <input type="hidden" name="gudang_id" id="gudang_id" class="form-control"
                                                    value="{{ $edit->id_warehouse }}" />
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="btn btn-sm btn-primary data_disabled" id="gudang-data"
                                                    data-url="{{ route('admin.produksi.gudang-data') }}"
                                                    data-bs-toggle="modal">
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
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Item Variant</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="item_variant_name"
                                                    class="form-control bg-secondary" id="item_variant_name"
                                                    placeholder="Item Variant Name"
                                                    value="{{ $edit->nama_product_variant }}" readonly />
                                                <input type="hidden" name="item_variant_id" id="item_variant_id"
                                                    class="form-control" value="{{ $edit->id_product_variant }}" />
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="btn btn-sm btn-primary data_disabled" id="item-variant-data"
                                                    data-url="{{ route('admin.produksi.variant-data') }}"
                                                    data-bs-toggle="modal">
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
                                        <label class="form-label">Ingredient</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="ingredient_information"
                                                    class="form-control bg-secondary" id="ingredient_information"
                                                    placeholder="Ingredient Information" value="{{$edit->ingredient_information}}" readonly />
                                                <input type="hidden" name="ingredient_id" id="ingredient_id"
                                                    class="form-control" value="{{$edit->ingredient_id}}" />
                                            </div>
                                            <div class="col-auto">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary data_disabled"
                                                    id="triggerIngredient">
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
                                        <label class="form-label required">Information</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea name="information" id="information" cols="30" rows="5" class="form-control">{{$edit->information}}</textarea>
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
                                        <label class="form-label">Warehouse Ingredient</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="warehouse_ingredient_name" class="form-control bg-secondary"
                                                    id="warehouse_ingredient_name" value="{{ $edit->warehouse_ingredient_name }}" placeholder="Warehouse Name" value="" readonly />
                                                <input type="hidden" name="warehouse_ingredient_id" id="warehouse_ingredient_id" class="form-control"
                                                    value="" />
                                            </div>
                                            <div class="col-auto">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary data_disabled" id="triggerWarehouseIngredient"
                                                    data-url="{{ route('admin.produksi.gudang-data') }}"
                                                    data-bs-toggle="modal">
                                                    <span class="svg-icon svg-icon-2 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                            <path
                                                                d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z"
                                                                fill="white"item_variant_id />
                                                            <path opacity="0.5"
                                                                d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z"
                                                                fill="white" />
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Production Quantity</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="jumlah_produksi"
                                                    class="form-control text-end bg-secondary" id="jumlah_produksi"
                                                    value="{{ $edit->production_quantity }}" readonly/>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-7">
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="form-label">Ingredients</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                    id="ingredients_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr
                                                            class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="w-20px pe-2">
                                                                No
                                                            </th>
                                                            <th class="min-w-80px">Item Name</th>
                                                            <th class="min-w-80px">Item Variant Name</th>
                                                            <th class="w-150px">Quantity</th>
                                                            <th class="w-50px">Unit</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600" id="get-item-data">
                                                        @foreach ($production_detail as $key => $row)
                                                            <tr id="ingredient_{{ $key }}"
                                                                class="data-ingredient" data-index="{{ $key }}">
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{$row->nama_item}}</td>
                                                                <td class="item_variant_name_{{ $key }}">{{$row->nama_item_variant}}</td>
                                                                <td><input type="text"
                                                                        class="form-control withseparator format-number text-end bg-secondary quantity_{{ $key }}"
                                                                        name="ingredients[{{ $key }}][quantity]"
                                                                        value="{{$row->quantity}}" readonly="">
                                                                    <input type="hidden"
                                                                        class="form-control withseparator format-number text-end quantity_act_{{ $key }}"
                                                                        value="2">
                                                                    <input type="hidden"
                                                                        class="form-control item_variant_id_{{ $key }}"
                                                                        value=""
                                                                        name="ingredients[{{ $key }}][item_variant_id]">
                                                                </td>
                                                                <td>{{$row->unit_name}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                        </div>
                                        <input type="hidden" class="ingredients-data" name="ingredient">
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
                            <a href="{{ route('admin.produksi') }}" id="kt_ecommerce_add_product_cancel"
                                class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
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

    <div class="modal fade" id="gudang-modal" tabindex="-1" aria-hidden="true">
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
                                    id="searchItemVariantsTable" autocomplete="off"/>
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="gudang_data_table">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Code</th>
                                        <th class="min-w-100px">Name</th>
                                        <th class="min-w-100px">PIC</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="gudang_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="#" class="btn btn-primary" id="selectData-Gudang">Select</a>
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
                                    id="searchItemsTable" autocomplete="off"/>
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5 table-bordered"
                                id="items_data_table">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item Name</th>
                                        <th class="min-w-100px">Brands</th>
                                        <th class="min-w-100px">Category</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="#" class="btn btn-primary" id="selectData-item">Select</a>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="item-variant-data-modal" tabindex="-1" aria-hidden="true">
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
                                    id="searchItemVariantsTable" autocomplete="off"/>
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="item_variants_data_table">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item Variant Name</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="item_variant_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="#" class="btn btn-primary"
                            data-url-ingredient="{{ route('admin.produksi.ingredient-data') }}"
                            id="selectData-item-variant">Select</a>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="stok-modal" tabindex="-1" aria-hidden="true">
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
                        <h2>Browse Stok Item</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchItemVariantsTable" autocomplete="off"/>
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="stok_data_table">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item Variant Name</th>
                                        <th class="min-w-100px">Warehouse</th>
                                        <th class="min-w-100px">Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="stok_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="#" class="btn btn-primary" id="selectData-Stock">Select</a>
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
    {{-- <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/products.js') }}"></script> --}}
    <script type="text/javascript">
        // Define form element
        const form = document.getElementById("form");

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(form, {
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: "Product name is required",
                        },
                    },
                },
                category: {
                    validators: {
                        notEmpty: {
                            message: "Please select category",
                        },
                    },
                },
                brand: {
                    validators: {
                        notEmpty: {
                            message: "Please select brand",
                        },
                    },
                },
                "variants[0][sku]": {
                    validators: {
                        notEmpty: {
                            message: "SKU is required",
                        },
                    },
                },
                "variants[0][name]": {
                    validators: {
                        notEmpty: {
                            message: "Name is required",
                        },
                    },
                },
                "variants[0][weight]": {
                    validators: {
                        notEmpty: {
                            message: "Weight is required",
                        },
                    },
                },
                "variants[0][price]": {
                    validators: {
                        notEmpty: {
                            message: "Price is required",
                        },
                    },
                },
                "variants[0][minimal_stock]": {
                    validators: {
                        notEmpty: {
                            message: "Minimal Stock is required",
                        },
                    },
                },
                "variants[0][stock]": {
                    validators: {
                        notEmpty: {
                            message: "Stock is required",
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
        const submitButton = document.getElementById("kt_ecommerce_add_product_submit");
        submitButton.addEventListener("click", function(e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function(status) {
                    if (status == "Valid") {
                        let stat = true;
                        $(".data-ingredient").each(function() {
                            let index = $(this).data("index");
                            let stok;
                            $.ajax({
                                url: "{{ route('admin.produksi.getStock') }}",
                                data: {
                                    'variant_id': $(this).find('.item_variant_id_'+index).val(),
                                    'warehouse_id': $('#gudang_id').val(),
                                },
                                type: "get",
                                cache: false,
                                async: false,
                                success: function(response) {
                                    stok = parseInt(response.stock)
                                }
                            });
                            var item_variant_name = $(
                                ".item_variant_name_" + index
                            ).text();

                            if (
                                parseInt(stok) < parseInt($(".quantity_" + index).val())
                            ) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Stok item variant " +
                                        item_variant_name +
                                        " tidak mencukupi!",
                                    icon: "error",
                                    confirmButtonText: "Close",
                                });

                                stat = false;
                                return false;
                            }

                            if (stok == "") {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Silahkan pilih stok item variant " +
                                        item_variant_name +
                                        " terlebih dahulu!",
                                    icon: "error",
                                    confirmButtonText: "Close",
                                });

                                stat = false;
                                return false;
                            }
                        });

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

            $(".kt_datepicker_1").flatpickr({
                dateFormat: "d-m-Y",
            });

            $('#gudang_data_table').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            $('#items_data_table').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            $('#item_variants_data_table').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip'
            });

            $('#stok_data_table').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip'
            });

            $('#btnToggleNomorProduksi').off().on('click', function(e) {
                var nomorProduksiInput = document.getElementsByName("nomor_produksi")[0];
                nomorProduksiInput.readOnly = !nomorProduksiInput.readOnly;
                if (nomorProduksiInput.readOnly == false) {
                    nomorProduksiInput.classList.remove("bg-secondary")
                } else {
                    nomorProduksiInput.classList.add("bg-secondary")
                    
                    $('#nomor_produksi').val('{{$edit->no_production}}')

                    $("#status_nomor_produksi").val(false)
                }

                var nomorProduksiHelp = document.getElementById("nomorProduksiHelp");
                nomorProduksiHelp.innerHTML = nomorProduksiInput.readOnly ?
                    "Klik tombol 'Ubah' untuk mengisi manual!" :
                    "Klik tombol 'Ubah' untuk mengisi otomatis!";
            });

            $("#nomor_produksi").keyup(function() {
                let no_produksi = $("#nomor_produksi").val()
                $.ajax({
                    url: "{{ route('admin.produksi.cek-nomor') }}",
                    data: {
                        'no_produksi': no_produksi
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        if (data == 1) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Nomor Produksi ' +
                                    no_produksi +
                                    ' sudah ada!',
                                icon: 'error',
                                confirmButtonText: 'Close'
                            })
                            $("#status_nomor_produksi").val("")
                        }
                    }
                });
            });

            $('#gudang-data').off().on('click', function(e) {
                let url = $(this).data('url');
                $('#gudang-modal').modal('show');
                $.ajax({
                    url: url,
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#gudang_data_table').DataTable();

                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="item"><td><input type="checkbox" class="form-check-input list_item_name" name="list_item_name" id="item' +
                                data[i].id + '" value="' + data[i].id +
                                '" /></td><td><label for="gudang' + data[i]
                                .id + '">' + data[i].code +
                                '</label></td><td>' + data[i].name +
                                '</td><td>' + data[i].pic +
                                '</td></tr>'
                            )).draw(false);

                            $("#item" + data[i].id).on('click', function() {
                                var $box = $(this);
                                if ($box.is(":checked")) {
                                    var group =
                                        "input:checkbox[name='list_item_name']";
                                    $(group).prop("checked", false);
                                    $box.prop("checked", true);
                                } else {
                                    $box.prop("checked", false);
                                }

                                $('#selectData-Gudang').attr('data-id', data[i]
                                    .id).attr('data-gudang', data[i].name);
                            });

                        });

                        $('#selectData-Gudang').click(function() {
                            let id = $(this).data('id');
                            let gudang = $(this).data('gudang');
                            $('#gudang_id').val(id)
                            $('#gudang_name').val(gudang)

                            $('#gudang-modal').modal('hide');
                        })
                    }
                });
                e.preventDefault();
            });

            $('#item-data').off().on('click', function(e) {
                $('#item-data-modal').modal('show');
                $.ajax({
                    url: "{{ route('admin.produksi.item-data') }}",
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        console.log(data)
                        var table = $('#items_data_table').DataTable();

                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="item"><td><input type="checkbox" class="form-check-input list_item_name" name="list_item_name" id="item' +
                                data[i].id + '" value="' + data[i].id +
                                '" /></td><td><label for="variant' + data[i]
                                .id + '">' + data[i].name +
                                '</label></td><td>' + data[i].brands.name +
                                '</td><td>' + data[i].categories.name +
                                '</td></tr>'
                            )).draw(false);

                            $("#item" + data[i].id).on('click', function() {
                                var $box = $(this);
                                if ($box.is(":checked")) {
                                    var group =
                                        "input:checkbox[name='list_item_name']";
                                    $(group).prop("checked", false);
                                    $box.prop("checked", true);
                                } else {
                                    $box.prop("checked", false);
                                }

                                $('#selectData-item').attr('data-id', data[i]
                                    .id).attr('data-item', data[i].name);
                            });

                        });

                        $('#selectData-item').click(function() {
                            let id = $(this).data('id');
                            let item = $(this).data('item');
                            $('#item_id').val(id)
                            $('#item_name').val(item)

                            $('#item-data-modal').modal('hide');
                        })
                    }
                });
                e.preventDefault();
            });

            $('#item-variant-data').off().on('click', function(e) {
                let url = $(this).data('url');
                $('#item-variant-data-modal').modal('show');

                var id = $('#gudang_id').val()

                $.ajax({
                    url: url,
                    data: {
                        'id': id
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#item_variants_data_table').DataTable();

                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="item_variants"><td><input type="checkbox" class="form-check-input" name="list_item_variant_name" id="variant' +
                                data[i].id + '" value="' + data[i].id +
                                '" /></td><td><label for="variant' + data[i]
                                .id + '">' + data[i].name + '</label></td></tr>'
                            )).draw(false);

                            $("#variant" + data[i].id).on('click', function() {
                                var $box = $(this);
                                if ($box.is(":checked")) {
                                    var group =
                                        "input:checkbox[name='list_item_variant_name']";
                                    $(group).prop("checked", false);
                                    $box.prop("checked", true);
                                } else {
                                    $box.prop("checked", false);
                                }

                                $('#selectData-item-variant').attr('data-id',
                                        data[i]
                                        .id).attr('data-item', data[i].name)
                                    .attr('data-supplier_name', data[i]
                                        .supplier_name).attr('data-supplier_id',
                                        data[i].supplier_id);
                            });
                        });


                    }
                });

                $('#selectData-item-variant').click(function() {
                    let id = $(this).data('id');
                    let item = $(this).data('item');
                    let index = 0;
                    let number = 1;
                    let url = $(this).data('url-ingredient');

                    $('#item_variant_name').val(item)
                    $('#item_variant_id').val(id)

                    $.ajax({
                        url: url,
                        data: {
                            'id': id
                        },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(data) {
                            $.each(data, function(i) {
                                $('#get-item-data').append(
                                    `<tr id="ingredient_` + index +
                                    `" class="data-ingredient" data-index="` +
                                    index + `">` +
                                    `<td>` + number + `</td>` +
                                    `<td>` + data[i].item_name + `</td>` +
                                    `<td class="item_variant_name_` +
                                    index + `">` + data[i]
                                    .item_variant_name + `</td>` +
                                    `<td>` +
                                    `<input type="text" class="form-control withseparator format-number text-end bg-secondary quantity_` +
                                    index + `" name="ingredients[` + index +
                                    `][quantity]" value="" readonly>` +
                                    `<input type="hidden" class="form-control withseparator format-number text-end quantity_act_` +
                                    index + `" value="` + data[i]
                                    .quantity_after_conversion + `">` +
                                    `<input type="hidden" class="form-control item_variant_id_` +
                                    index +
                                    `" value="" name="ingredients[` +
                                    index + `][item_variant_id]">` +
                                    `</td>` +
                                    `<td>` + data[i].unit_name + `</td>` +
                                    `</tr>`
                                );

                                number++;
                                index++;
                                resetData();
                            });
                        }

                    });

                    $('#item-variant-data-modal').modal('hide');
                })
                e.preventDefault();
            });

            $("#jumlah_produksi").keyup(function() {
                $(".data-ingredient").each(function() {

                    let index = $(this).data("index");
                    let quantity_act = $(".quantity_act_" + index).val();
                    let stok;
                    $.ajax({
                        url: "{{ route('admin.produksi.getStock') }}",
                        data: {
                            'variant_id': $(this).find('.item_variant_id_'+index).val(),
                            'warehouse_id': $('#gudang_id').val(),
                        },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(response) {
                            stok = parseInt(response.stock)
                        }
                    });
                    let jumlah_produksi = $("#jumlah_produksi").val();
                    var item_variant_name = $('.item_variant_name_' + index).text();

                    if (jumlah_produksi > 0) {
                        let total = quantity_act * jumlah_produksi
                        $(".quantity_" + index).val(total);
                    } else {
                        $(".quantity_" + index).val("");
                    }

                    if (parseInt(stok) < parseInt($(".quantity_" + index).val())) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Stok item variant ' +
                                item_variant_name +
                                ' tidak mencukupi!',
                            icon: 'error',
                            confirmButtonText: 'Close'
                        })
                        $(".stok_" + index).val("");
                    }
                })
            })

            function addValidation() {
                index = 0;
                validator.addField("gudang_name", {
                    validators: {
                        notEmpty: {
                            message: 'Please select warehouse'
                        }
                    }
                });

                validator.addField("item_variant_name", {
                    validators: {
                        notEmpty: {
                            message: 'Please select variant item'
                        }
                    }
                });

                validator.addField("jumlah_produksi", {
                    validators: {
                        notEmpty: {
                            message: 'Please select production quantity'
                        }
                    }
                });

                validator.addField("status_nomor_produksi", {
                    validators: {
                        notEmpty: {
                            message: 'Production number is available!'
                        }
                    }
                });

            }

            function resetData() {
                $(".data-ingredient").each(function() {
                    var another = this;

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

                    $(this)
                        .find(".stokData")
                        .off()
                        .on("click", function() {
                            let item_variant_id = $(this).data("item_variant_id");
                            let index = $(this).data("index");
                            let jumlah_produksi = $("#jumlah_produksi").val();
                            let stok = "";
                            let warehouse_id = "";

                            if (jumlah_produksi.length < 1) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Silahkan isi jumlah produksi terlebih dahulu ',
                                    icon: 'error',
                                    confirmButtonText: 'Close'
                                })

                                return false
                            }

                            $("#stok-modal").modal("show");

                            $.ajax({
                                url: "{{ route('admin.produksi.stok-data') }}",
                                data: {
                                    'item_variant_id': item_variant_id
                                },
                                type: "get",
                                cache: false,
                                async: false,
                                success: function(data) {
                                    var table = $('#stok_data_table').DataTable();

                                    table.rows().remove().draw();
                                    $.each(data, function(i) {
                                        table.row.add($(
                                            '<tr class="item_stok"><td><input type="checkbox" class="form-check-input" name="list_item_stok" id="stok' +
                                            data[i].id + '" value="' + data[
                                                i].id +
                                            '" /></td><td><label for="stok' +
                                            data[i]
                                            .id + '">' + data[i]
                                            .variant_name +
                                            '</label></td><td><label for="stok' +
                                            data[i]
                                            .id + '">' + data[i]
                                            .warehouse_name +
                                            '</label></td><td><label for="stok' +
                                            data[i]
                                            .id + '">' + data[i].stock +
                                            '</label></td></tr>'
                                        )).draw(false);

                                        $("#stok" + data[i].id).on('click',
                                            function() {
                                                var $box = $(this);
                                                if ($box.is(":checked")) {
                                                    var group =
                                                        "input:checkbox[name='list_item_stok']";
                                                    $(group).prop("checked",
                                                        false);
                                                    $box.prop("checked", true);
                                                } else {
                                                    $box.prop("checked", false);
                                                }
                                                stok = data[i].stock
                                                warehouse_id = data[i]
                                                    .warehouse_id
                                            });
                                    });
                                }
                            });

                            $('#selectData-Stock').click(
                                function(e) {

                                    var data_min = $(
                                        '.quantity_' +
                                        index).val();
                                    var item_variant_name = $(
                                            '.item_variant_name_' +
                                            index)
                                        .text();

                                    if (parseInt(stok) < parseInt(data_min)) {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Stok item variant ' +
                                                item_variant_name +
                                                ' tidak mencukupi!',
                                            icon: 'error',
                                            confirmButtonText: 'Close'
                                        })

                                        $('#stok-modal')
                                            .modal(
                                                'hide');
                                        e
                                            .preventDefault();
                                    } else {

                                        $('.stok_' +
                                                index)
                                            .val(stok)

                                        $('.warehouse_id_' +
                                                index)
                                            .val(warehouse_id)

                                        $('.item_variant_id_' +
                                                index)
                                            .val(item_variant_id)

                                        $('#stok-modal')
                                            .modal(
                                                'hide');
                                        e
                                            .preventDefault();
                                    }

                                })
                        });
                });

                addValidation();
            }

        });
    </script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
@endpush
