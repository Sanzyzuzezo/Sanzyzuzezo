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
                    action="{{ route('admin.unit_conversions.update') }}" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label required">Item</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="item_name" class="form-control" id="item_name" placeholder="Item Name" value="{{ $edit->item_name }}" readonly/>
                                            <input type="hidden" name="item_id" id="item_id" class="form-control" value="{{ $edit->item_id }}"/>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <div class="mb-10 fv-row">
                                    <label class="form-label required">Item Variant</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="item_variant_name" class="form-control" id="item_variant_name" placeholder="Item Variant Name" value="{{ $edit->item_variant_name }}" readonly/>
                                            <input type="hidden" name="item_variant_id" id="item_variant_id" class="form-control" value="{{ $edit->item_variant_id }}"/>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Conversion</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="text" min="0" name="new_quantity" class="form-control mb-2" placeholder="New Quantity" value="{{ $edit->new_quantity }}" readonly/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="new_unit" class="form-control mb-2" placeholder="New Unit" value="{{ $edit->new_unit }}" />
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <strong>=</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" min="0" name="quantity" class="form-control withseparator format-number text-end variant-price mb-2" placeholder="Quantity" value="{{ number_format($edit->quantity, 2) }}" />
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control mb-2" placeholder="Unit" id="unit" value="{{ $edit->unit_name }}" readonly/>
                                            <input type="hidden" name="unit_id" id="unit_id" value="{{ $edit->unit_id }}">
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
                                        <input class="form-check-input" type="checkbox" value="1" id="status" name="status" @if($edit->status == 1) checked="checked" @endif />
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
                            <a href="{{ route('admin.unit_conversions') }}" id="kt_ecommerce_add_product_cancel"
                                class="btn btn-light me-5">Cancel</a>
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

            $("#item").change(function(){
                $.ajax({
                    url: "{{ route('admin.unit_conversions.variant-data') }}",
                    data: { 'id' : $("#item option:selected").val() },
                    type: "get",
                    cache: false,
                    async:false,
                    success: function (data) {
                        $('#item_variant').find('option').remove().end();
                        $.each(data, function (i) {
                            $('#item_variant').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                        });
                    }
                });
            });
            
            $("#item_variant").change(function(){
                $.ajax({
                    url: "unit-data",
                    data: { 'id' : $("#item_variant option:selected").val() },
                    type: "get",
                    cache: false,
                    async:false,
                    success: function (data) {
                        $("#unit").val(data.name);
                        $("#unit_id").val(data.id);
                    }
                });
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
        });
    </script>
@endpush
