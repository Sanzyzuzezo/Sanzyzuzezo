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
                        <li class="breadcrumb-item text-dark">Detail</li>
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
                                        <input type="text" name="item_name" class="form-control bg-secondary"
                                            id="item_name" placeholder="Item Name" value="{{ $detail->item_name }}"
                                            readonly />
                                        <input type="hidden" name="item_id" id="item_id" class="form-control"
                                            value="{{ $detail->item_id }}" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <div class="mb-10 fv-row">
                                <label class="form-label required">Item Variant</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="item_variant_name" class="form-control bg-secondary"
                                            id="item_variant_name" placeholder="Item Variant Name"
                                            value="{{ $detail->item_variant_name }}" readonly />
                                        <input type="hidden" name="item_variant_id" id="item_variant_id"
                                            class="form-control" value="{{ $detail->item_variant_id }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="form-label required">Information</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="row">
                                    <div class="col-12">
                                        <textarea name="information" id="information" cols="30" rows="5" class="form-control" disabled>{{ $detail->information }}</textarea>
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
                                        name="status" @if ($detail->status == 1) checked="checked" @endif
                                        disabled />
                                    <label class="form-check-label fw-bold text-gray-400 ms-3" for="status">Active</label>
                                </div>
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">
                                </div>
                                <!--end::Description-->
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Label-->
                                <label class="form-label required">Ingredients</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="ingredients_table">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                    <th class="w-20px pe-2">
                                                        No
                                                    </th>
                                                    <th class="min-w-100px">Item Name</th>
                                                    <th class="min-w-100px">Item Variant Name</th>
                                                    <th class="min-w-50px">Quantity</th>
                                                    <th class="min-w-100px">Unit</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600" id="get-item-data">
                                                <?php $no = 0; ?>
                                                @foreach ($ingredient_details as $row)
                                                    <?php $no++; ?>
                                                    <tr class="ingredients" id="ingredient{{ $no }}">
                                                        <input type="hidden" name="ingredients[{{ $no }}][id]"
                                                            value="{{ $row->id }}" />
                                                        <td>{{ $no }}</td>
                                                        <td>{{ $row->item_name }}</td>
                                                        <td>
                                                            {{ $row->item_variant_name }}
                                                            <input type="hidden"
                                                                name="ingredients[{{ $no }}][item_variant_id]"
                                                                value="{{ $row->item_variant_id }}">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control text-end bg-secondary"
                                                                name="ingredients[{{ $no }}][quantity]"
                                                                value="{{ number_format($row->quantity, 2) }}" readonly>
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
                                                                id="unit{{ $no }}" disabled>
                                                                <option value="">Please Select</option>
                                                                @foreach ($unit as $unit)
                                                                    <option value="{{ $unit->id }}"
                                                                        {{ $unit->id == $row->unit_id ? 'selected' : '' }}>
                                                                        {{ $unit->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                    </div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    <!--end::General options-->
                </div>
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="{{ route('admin.ingredients') }}" id="kt_ecommerce_add_product_cancel"
                    class="btn btn-light me-5">Cancel</a>
                <!--end::Button-->
            </div>
            <!--end::Card header-->
        </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
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
                                    id="searchItemsTable" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="items_data_table">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item Name</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400">
                                    @foreach ($items as $row)
                                        <tr>
                                            <td><input class="form-check-input item_ingredients" id="{{ $row->id }}"
                                                    name="list_item_name" type="checkbox" value="{{ $row->id }}" />
                                            </td>
                                            <td value="{{ $row->id }}"><label
                                                    for="{{ $row->id }}">{{ $row->name }}</label></td>
                                        </tr>
                                    @endforeach
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
                                    id="searchItemVariantsTable" />
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
                                    @foreach ($item_variants as $row)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-check-input item_variants"
                                                    name="list_item_variant_name" id="variant{{ $row->id }}"
                                                    value="{{ $row->id }}" />
                                            </td>
                                            <td><label for="variant{{ $row->id }}">{{ $row->name }}</label></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="#" class="btn btn-primary" id="selectData-item-variant">Select</a>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="items-data" tabindex="-1" aria-hidden="true">
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
                                    id="searchIngredientsTable" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="ingredients_data_table">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Item</th>
                                        <th class="min-w-100px">Item Variant</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="item_ingredient">
                                    @foreach ($item_ingredients as $row)
                                        <tr>
                                            <td>
                                                <input class="form-check-input item_ingredients"
                                                    id="ing-{{ $row->id }}" type="checkbox"
                                                    value="{{ $row->id }}" />
                                            </td>
                                            <td class="min-w-100px"><label
                                                    for="ing-{{ $row->id }}">{{ $row->item_name }}</label></td>
                                            <td class="min-w-100px"><label
                                                    for="ing-{{ $row->id }}">{{ $row->item_variant_name }}</label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <a href="#" class="btn btn-primary" id="selectData-ingredients">Select</a>
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
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
@endpush
