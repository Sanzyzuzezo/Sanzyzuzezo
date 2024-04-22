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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Unit Conversions</h1>
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
                            <a href="{{ route('admin.unit_conversions') }}" class="text-muted text-hover-primary">Unit Conversions</a>
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
                <form id="form" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.unit_conversions.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                                            <input type="text" name="item_name" class="form-control" id="item_name" placeholder="Item Name" value="" readonly/>
                                            <input type="hidden" name="item_id" id="item_id" class="form-control" value=""/>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-primary" id="item-data" data-bs-toggle="modal" data-bs-target="#item-data-modal">
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
                                <!--end::Input group-->
                                <div class="mb-10 fv-row">
                                    <label class="form-label required">Item Variant</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="item_variant_name" class="form-control" id="item_variant_name" placeholder="Item Variant Name" value="" readonly/>
                                            <input type="hidden" name="item_variant_id" id="item_variant_id" class="form-control" value=""/>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-primary data_disabled" id="item-variant-data" data-bs-toggle="modal" data-bs-target="#item-variant-data-modal">
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
                                    <label class="form-label required">Conversion</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="text" min="0" name="new_quantity" class="form-control mb-2" placeholder="New Quantity" value="1" readonly/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="new_unit" class="form-control mb-2" placeholder="New Unit" value="" />
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <strong>=</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" min="0" name="quantity" class="form-control withseparator format-number text-end variant-price mb-2" placeholder="Quantity" value="" />
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control mb-2" placeholder="Unit" id="unit" readonly/>
                                            <input type="hidden" name="unit_id" id="unit_id" value="">
                                        </div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status" checked="checked" />
                                        <label class="form-check-label fw-bold text-gray-400 ms-3" for="status">Active</label>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.unit_conversions') }}"
                                id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="unit_conversions_submit" class="btn btn-primary">
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
                        <h2>Browse Items</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search" id="searchItemsTable" />
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
                                            <td><input class="form-check-input item_ingredients" id="{{ $row->id }}" name="list_item_name" type="checkbox" value="{{ $row->id }}" /></td>
                                            <td value="{{ $row->id }}"><label for="{{ $row->id }}">{{ $row->name }}</label></td>
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
                        <h2>Browse Item Variants</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search" id="searchItemVariantsTable" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="item_variants_data_table">
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
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/unit_conversions.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
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
            
            function formatNumber(n) {
                // format number 1000000 to 1,234,567
                var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                // console.log(xx)/
                return xx;

            }
            
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
            
            $('#searchItemsTable').keyup(function(){
                $('#items_data_table').DataTable().search($(this).val()).draw() ;
            });
            $('#selectData-item').off().on('click', function (e) {
                var id = $('#items_data_table').find('input[type="checkbox"]:checked').val();
                $.ajax({
                    url: "item-data-select",
                    data: { 'id' : id },
                    type: "get",
                    cache: false,
                    async:false,
                    success: function (data) {
                        $('#item_name').val(data.item_name);
                        $('#item_id').val(data.item_id);
                        $('#item_variant_name').val('');
                        $('#item_variant_id').val('');
                    }
                });
                
                $.ajax({
                    url: "variant-data",
                    data: { 'id' : id },
                    type: "get",
                    cache: false,
                    async:false,
                    success: function (data) {
                        var table = $('#item_variants_data_table').DataTable();

                        table.rows().remove().draw();
                        $.each(data, function (i) {                            
                            table.row.add($('<tr class="item_variants"><td><input type="checkbox" class="form-check-input" name="list_item_variant_name" id="variant' + data[i].id + '" value="' + data[i].id + '" /></td><td><label for="variant' + data[i].id + '">' + data[i].name + '</label></td></tr>')).draw(false);
                
                            $("#variant"+data[i].id).on('click', function() {
                                var $box = $(this);
                                if ($box.is(":checked")) {
                                    var group = "input:checkbox[name='list_item_variant_name']";
                                    $(group).prop("checked", false);
                                    $box.prop("checked", true);
                                } else {
                                    $box.prop("checked", false);
                                }
                            });
                        });
                    }
                });
                
                if ($('#item_name').val() != "") {
                    $('#item-variant-data').removeClass('data_disabled')
                }
                
        		$('#item-data-modal').modal('hide');
                e.preventDefault();
            });
            
            $('#searchItemVariantsTable').keyup(function(){
                $('#item_variants_data_table').DataTable().search($(this).val()).draw();
            });
            $('#selectData-item-variant').off().on('click', function (e) {
                var id = $('#item_variants_data_table').find('input[type="checkbox"]:checked').val();

                $.ajax({
                    url: "unit-data",
                    data: { 'id' : id },
                    type: "get",
                    cache: false,
                    async:false,
                    success: function (data) {
                        $('#item_variant_name').val(data.name);
                        $('#item_variant_id').val(data.id);
                        $('#unit').val(data.unit_name);
                        $('#unit_id').val(data.unit_id);
                    }
                });
                                
        		$('#item-variant-data-modal').modal('hide');
                e.preventDefault();
            });
            
            $("input:checkbox[name='list_item_name']").on('click', function() {
                var $box = $(this);
                if ($box.is(":checked")) {
                    var group = "input:checkbox[name='list_item_name']";
                    $(group).prop("checked", false);
                    $box.prop("checked", true);
                } else {
                    $box.prop("checked", false);
                }
            });
        });
    </script>
@endpush
