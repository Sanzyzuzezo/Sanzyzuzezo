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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Ingredients</h1>
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
                            <a href="{{ route('admin.ingredients') }}" class="text-muted text-hover-primary">Ingredients</a>
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
                    action="{{ route('admin.ingredients.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
                    <input type="hidden" name="id" class="form-control mb-2" placeholder="ID"
                        value="{{ $edit->id }}" id="id" />
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
                                    <label class="form-label required">Item</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="item_name" class="form-control" id="item_name"
                                                placeholder="Item Name" value="{{ $edit->item_name }}" readonly />
                                            <input type="hidden" name="item_id" id="item_id" class="form-control"
                                                value="{{ $edit->item_id }}" />
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-primary" id="triggerItem"
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
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <div class="mb-10 fv-row">
                                    <label class="form-label required">Item Variant</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="item_variant_name" class="form-control"
                                                id="item_variant_name" placeholder="Item Variant Name"
                                                value="{{ $edit->item_variant_name }}" readonly />
                                            <input type="hidden" name="item_variant_id" id="item_variant_id"
                                                class="form-control" value="{{ $edit->item_variant_id }}" />
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-primary" id="triggerItemVariant"
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
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label required">Information</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="row">
                                        <div class="col-12">
                                            <textarea name="information" id="information" cols="30" rows="5" class="form-control"
                                                autocomplete="off">{{ $edit->information }}</textarea>
                                        </div>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status"
                                            name="status" @if ($edit->status == 1) checked="checked" @endif />
                                        <label class="form-check-label fw-bold text-gray-400 ms-3"
                                            for="status">Active</label>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label required">Ingredients</label>
                                    <!--end::Label-->
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="btn btn-sm btn-primary" id="triggerItemForIngredient"
                                            data-bs-toggle="modal">
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
                                                id="ingredients_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr
                                                        class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="w-20px pe-2">
                                                            No
                                                        </th>
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
                                                    <?php $no = 0; ?>
                                                    @foreach ($ingredient_details as $key => $row)
                                                        <tr class="data-ingredient" id="ing{{ $row->item_variant_id }}">
                                                            <input type="hidden"
                                                                name="ingredients[{{ $no }}][id]"
                                                                value="{{ $row->id }}" />
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $row->item_name }}</td>
                                                            <td>
                                                                {{ $row->item_variant_name }}
                                                                <input type="hidden"
                                                                    name="ingredients[{{ $no }}][item_variant_id]"
                                                                    value="{{ $row->item_variant_id }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control text-end format-number withseparator"
                                                                    name="ingredients[{{ $no }}][quantity]"
                                                                    value="{{ number_format($row->quantity, 2, '.', ',') }}">
                                                            </td>
                                                            <?php
                                                            $variant = App\Models\ProductVariant::select(DB::raw('units.name, 0 as id'))
                                                                ->where('product_variants.id', $row->item_variant_id) // <-- Complete the statement
                                                                ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id');
                                                            
                                                            $uk = App\Models\UnitConversion::select(DB::raw('unit_conversions.new_unit as name, unit_conversions.id'))
                                                                ->leftJoin(DB::raw('units'), 'units.id', '=', 'unit_conversions.unit_id')
                                                                ->where('unit_conversions.item_variant_id', $row->item_variant_id);
                                                            
                                                            $unit = $variant->union($uk)->get();
                                                            ?>
                                                            <td>
                                                                <select class="form-select"
                                                                    name="ingredients[{{ $no }}][unit_id]"
                                                                    id="unit{{ $no }}">
                                                                    <option value="">Please Select</option>
                                                                    @foreach ($unit as $unit)
                                                                        <option value="{{ $unit->id }}"
                                                                            {{ $unit->id === $row->unit_id ? 'selected' : '' }}>
                                                                            {{ $unit->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-sm btn-icon btn-light btn-active-light-primary delete-ingredient"
                                                                    id="delete-ingredient{{ $no }}"
                                                                    data-id="{{ $row->id }}"
                                                                    data-ing="{{ $row->item_variant_id }}">
                                                                    <span class="svg-icon svg-icon-2">
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
                                                                    </span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php $no++; ?>
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" class="ingredients-data" name="ingredient"
                                        value="{{ count($ingredient_details) != 0 ? '1' : '' }}">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.ingredients') }}" id="kt_ecommerce_add_product_cancel"
                                class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="ingredients_submit" class="btn btn-primary">
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

    <div class="modal fade" id="item_new_modal" tabindex="-1" aria-hidden="true">
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
                                    id="searchItemModalNewTable" autocomplete="off" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="item_new_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item Name</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="datatable_item_new">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="#" class="btn btn-primary" id="selectData-item_new">Select</a>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
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
                                    id="searchItemVariantsTable" autocomplete="off" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="item_variant_new_datatable">
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
                        <a href="#" class="btn btn-primary" id="selectData-item_variant">Select</a>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="item_variant_for_ingredient_modal" tabindex="-1" aria-hidden="true">
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
                                    id="searchItemVariantForIngredientTable" autocomplete="off" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="item_variant_for_ingredient_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item Name</th>
                                        <th class="min-w-100px">Item Variant Name</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="item_ingredient">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="#" class="btn btn-primary" id="selectData-item_variant_for_ingredient">Select</a>
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
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    {{-- <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/ingredients.js') }}"></script> --}}
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        const form = document.getElementById('form');

        var validator = FormValidation.formValidation(
            form, {
                fields: {
                    'item_id': {
                        validators: {
                            notEmpty: {
                                message: 'Item is required'
                            }
                        }
                    },
                    'item_variant_id': {
                        validators: {
                            notEmpty: {
                                message: 'Item variant is required'
                            }
                        }
                    },
                    'quantity': {
                        validators: {
                            notEmpty: {
                                message: 'Quantity is required'
                            }
                        }
                    },
                    'ingredient': {
                        validators: {
                            notEmpty: {
                                message: 'Ingredient is empty'
                            }
                        }
                    },
                    'information': {
                        validators: {
                            notEmpty: {
                                message: 'information is empty'
                            },
                            remote: {
                                message: 'Data ini sudah dipakai',
                                method: 'POST',
                                url: '/admin/ingredients/isExistInformation',
                                data: function() {
                                    return {
                                        _token: '{{ csrf_token() }}',
                                        information: $('#information').val(),
                                        id: $('#id').val(),
                                    }
                                },
                            },
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        const submitButton = document.getElementById('ingredients_submit');
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (validator) {
                validator.validate().then(function(status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        submitButton.disabled = true;

                        setTimeout(function() {
                            submitButton.removeAttribute('data-kt-indicator');

                            submitButton.disabled = false;

                            form.submit();
                        }, 2000);
                    }
                });
            }
        });



        function resetData() {
            $(".data-ingredient").each(function() {
                var another = this;

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
            });

            var no = $('#ingredients_table tbody').find('tr').length;
            if (no == 0) {
                no = '';
            }
            $('.ingredients-data').val(no);

        }

        $(document).ready(function() {
            resetData();
            // Variable to store checkbox state
            var checkboxStateItem = {};

            // Event delegation for checkboxes
            $('#item_new_datatable').on('click', 'input:checkbox[name="item_id_checkbox"]', function() {
                var $box = $(this);
                var item_newId = $box.val();

                // Update checkbox state
                checkboxStateItem[item_newId] = $box.is(':checked');

                // Uncheck all other checkboxes in the same group
                var group = 'input:checkbox[name="item_id_checkbox"]';
                $(group).not($box).prop('checked', false);
            });

            // Initialize DataTables
            var item_new_datatable = $('#item_new_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            // Reapply the event handler and update checkboxes after each table draw
            item_new_datatable.on('draw', function() {
                // Update checkboxes based on stored state
                $('#item_new_datatable input:checkbox[name="item_id_checkbox"]').each(function() {
                    var $box = $(this);
                    var item_newId = $box.val();

                    if (checkboxStateItem[item_newId]) {
                        $box.prop('checked', true);
                    } else {
                        $box.prop('checked', false);
                    }
                });

                // Clear the state of checkboxes when switching pages
                $('#item_new_datatable input:checkbox').prop('checked', false);
            });

            $('#triggerItem').on('click', function() {
                $('#item_new_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.ingredients.getDataItem') }}',
                    type: "get",
                    data: {
                        customer_id: $('#customer_id').val()
                    },
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#item_new_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="item_new_id"><td><input type="checkbox" class="form-check-input item_id_checkbox" name="item_id_checkbox" id="item_new_id' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="item_new_id' +
                                data[i]
                                .id + '">' + data[i].name +
                                '</label></td></tr>'
                            )).draw(false);

                        });
                        table.draw(false);
                        $('#searchItemModalNewTable').keyup(function() {
                            table.search($(this).val()).draw();
                        });
                    }
                });
            });

            $('#selectData-item_new').on('click', function() {
                var item_id = $('#item_new_datatable').find(
                        'input[type="checkbox"]:checked')
                    .val();

                $.ajax({
                    url: "{{ route('admin.ingredients.getDataItem') }}",
                    data: {
                        id: item_id
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        console.log(data)
                        $('#item_name').val(data.name)
                        $('#item_id').val(data.id)
                        $('#item_variant_name').val('')
                        $('#item_variant_id').val('')

                    }
                });
                if ($('#item_name').val() != "") {
                    $('#triggerItemVariant').removeClass('data_disabled')
                }

                $('#item_new_modal').modal('hide');
            });


            // Variable to store checkbox state
            var checkboxStateItemVariant = {};

            // Event delegation for checkboxes
            $('#item_variant_new_datatable').on('click', 'input:checkbox[name="item_variant_id_checkbox"]',
                function() {
                    var $box = $(this);
                    var item_variantId = $box.val();

                    // Update checkbox state
                    checkboxStateItemVariant[item_variantId] = $box.is(':checked');

                    // Uncheck all other checkboxes in the same group
                    var group = 'input:checkbox[name="item_variant_id_checkbox"]';
                    $(group).not($box).prop('checked', false);
                });

            // Initialize DataTables
            var item_variant_new_datatable = $('#item_variant_new_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip',
            });

            // Reapply the event handler and update checkboxes after each table draw
            item_variant_new_datatable.on('draw', function() {
                // Update checkboxes based on stored state
                $('#item_variant_new_datatable input:checkbox[name="item_variant_id_checkbox"]').each(
                    function() {
                        var $box = $(this);
                        var item_variantId = $box.val();

                        if (checkboxStateItemVariant[item_variantId]) {
                            $box.prop('checked', true);
                        } else {
                            $box.prop('checked', false);
                        }
                    });

                // Clear the state of checkboxes when switching pages
                $('#item_variant_new_datatable input:checkbox').prop('checked', false);
            });

            $('#triggerItemVariant').on('click', function() {
                $('#item_variant_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.ingredients.getDataItemVariant') }}',
                    type: "get",
                    data: {
                        product_id: $('#item_id').val()
                    },
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#item_variant_new_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="item_variant_id"><td><input type="checkbox" class="form-check-input item_variant_id_checkbox" name="item_variant_id_checkbox" id="item_variant_id' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="item_variant_id' +
                                data[i]
                                .id + '">' + data[i].name +
                                '</label></td></tr>'
                            )).draw(false);

                        });
                        table.draw(false);
                        $('#searchItemVariantsTable').keyup(function() {
                            table.search($(this).val()).draw();
                        });
                    }
                });
            });

            $('#selectData-item_variant').on('click', function() {
                var item_variant_id = $('#item_variant_new_datatable').find(
                        'input[type="checkbox"]:checked')
                    .val();

                $.ajax({
                    url: "{{ route('admin.ingredients.getDataItemVariant') }}",
                    data: {
                        product_id: $('#item_id').val(),
                        id: item_variant_id
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        console.log(data)
                        $('#item_variant_name').val(data.name)
                        $('#item_variant_id').val(data.id)
                    }
                });
                if ($('#item_variant_name').val() != "") {
                    $('#triggerItemForIngredient').removeClass('data_disabled');
                }

                $('#item_variant_modal').modal('hide');
            });



            $('#triggerItemForIngredient').on('click', function() {
                $('#item_variant_for_ingredient_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.ingredients.getDataItemVariantIngredient') }}',
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#item_variant_for_ingredient_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="item_variant_for_ingredient_id"><td><input type="checkbox" class="form-check-input item_variant_for_ingredient_id_checkbox" name="item_variant_for_ingredient_id_checkbox" id="item_variant_for_ingredient_id' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="item_variant_for_ingredient_id' +
                                data[i]
                                .id + '">' + data[i].products_name +
                                '</label></td><td><label for="item_variant_for_ingredient_id' +
                                data[i]
                                .id + '">' + data[i].name +
                                '</label></td></tr>'
                            )).draw(false);

                        });
                        table.draw(false);
                        $('#searchItemVariantForIngredientTable').keyup(function() {
                            table.search($(this).val()).draw();
                        });
                    }
                });
            });

            $('#selectData-item_variant_for_ingredient').on('click', function() {
                $('#item_variant_for_ingredient_datatable').find('input[type="checkbox"]:checked').each(
                    function(i) {
                        var number = $('#ingredients_table').find('tr').length;
                        var id = $(this).val();
                        var item_id = $(this).data('item_id');

                        $.ajax({
                            url: "{{ route('admin.ingredients.item-data') }}",
                            data: {
                                item_id: item_id,
                                variant_id: id
                            },
                            type: "get",
                            cache: false,
                            async: false,
                            success: function(data) {
                                if ($('#ing' + id).length == 0) {
                                    $('#get-item-data').append('<tr id="ing' + id +
                                        '" class="data-ingredient"><td>' + number +
                                        '</td><td>' + data.item_name + '</td><td>' +
                                        data.item_variant_name +
                                        '<input type="hidden" name="ingredients[' +
                                        number + '][item_variant_id]" value="' + data
                                        .id +
                                        '"></td><td><input type="text" class="form-control withseparator format-number text-end variant-price mb-2" autocomplete="off" name="ingredients[' +
                                        number +
                                        '][quantity]"></td><td><select class="form-select" name="ingredients[' +
                                        number + '][unit_id]" id="unit' + number +
                                        '"></select></td><td><a href="javascript:void(0)" class="btn btn-sm btn-icon btn-light btn-active-light-primary delete" data-id="' +
                                        id + '" id="delete' +
                                        id +
                                        '" data-bs-toggle="tooltip" data-bs-placement="top"><span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" /></svg></span></a></td></tr>'
                                    );
                                    resetData();
                                }
                            }
                        });
                        $.ajax({
                            url: "{{ route('admin.ingredients.unit-main-data') }}",
                            data: {
                                'id': id
                            },
                            type: "get",
                            cache: false,
                            async: false,
                            success: function(data) {
                                $('#unit' + number).append(
                                    "<option value=''>Please Select</option>");
                            }
                        });
                        $.ajax({
                            url: "{{ route('admin.ingredients.units-data') }}",
                            data: {
                                'id': id
                            },
                            type: "get",
                            cache: false,
                            async: false,
                            success: function(data) {
                                $.each(data, function(i) {
                                    $('#unit' + number).append("<option value='" +
                                        data[i].id + "'>" + data[i].name +
                                        "</option>");
                                });
                            }
                        });

                        $('.delete').on('click', function(e) {
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
                                    $("#ing" + id).remove();
                                    resetData();
                                }
                            });
                        });

                    });

                $('#item_variant_for_ingredient_modal').modal('hide');
            });

            $('.delete-ingredient').on('click', function(e) {
                let ix = $(this).data('id');
                let ing_id = $(this).data('ing');
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
                            type: "DELETE",
                            url: "{{ route('admin.ingredients.deleteDetail') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                                ix: ix,
                            }),
                            success: function(resp) {
                                if (resp.success) {
                                    Swal.fire('Deleted!',
                                        'Data has been deleted',
                                        'success');
                                    $("#ing" + ing_id).remove();
                                    resetData();
                                } else {
                                    Swal.fire('Failed!',
                                        'Deleted data failed', 'error');
                                }
                            },
                            error: function(resp) {
                                Swal.fire("Error!", "Something went wrong.",
                                    "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
