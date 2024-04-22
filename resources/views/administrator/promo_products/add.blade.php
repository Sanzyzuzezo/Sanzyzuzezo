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
                    class="page-title d-flex align-products-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex align-products-center text-dark fw-bolder fs-3 my-1">Promo Products</h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <!--begin::productItem-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::productItem-->
                        <!--begin::productItem-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::productItem-->
                        <!--begin::productItem-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.promo_products') }}" class="text-muted text-hover-primary">Promo
                                Products</a>
                        </li>
                        <!--begin::productItem-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::productItem-->
                        <!--begin::productItem-->
                        <li class="breadcrumb-item text-dark">Add</li>
                        <!--end::productItem-->
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
                    <div class="alert alert-danger d-flex align-products-center p-5">
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

                <form id="form" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.promo_products.save') }}" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label required">Promo Type</label>
                                    <select class="form-select" name="promo_type" data-control="select2" data-hide-search="true" data-placeholder="Please Select">
                                        <option value="">Please Select</option>
                                        <option value="flash_sale">Flash Sale</option>
                                        <option value="reguler">Reguler</option>
                                    </select>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label required">Title</label>
                                    <input type="text" name="title" placeholder="Title" class="form-control"
                                        value="" />
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label required">Start At</label>
                                            <input type="text" name="start_at" class="form-control" id="kt_datepicker_5" value="" />
                                            <div class="text-muted fs-7">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label required">Start Date</label>
                                            <input type="text" name="start_date" class="form-control start_date" id="kt_datepicker_3" value="" readonly/>
                                            <div class="text-muted fs-7">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label required">End Date</label>
                                            <input type="text" name="end_date" class="form-control end_date" id="kt_datepicker_4" value="" readonly/>
                                            <div class="text-muted fs-7">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="mb-10 fv-row">
                                    <label class="form-label">Discount</label>
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input discount_type" type="checkbox" value="1" id="discount_type" name="discount_type" checked />
                                                <label class="form-check-label fw-bold text-gray-400 ms-3 discount_label" for="discount_type">Percentage (%)</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="discount_value" min="1" max="100" class="form-control discount_value format-number withseparator" value="" />
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div> --}}
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label required">Products</label>
                                    <!--end::Label-->
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="btn btn-sm btn-primary" id="product-data">
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
                                            Select Products
                                        </a>
                                    </div>
                                    <!--begin::Input-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                id="listDataProduct">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr
                                                        class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-100px">Product Name</th>
                                                        <th class="min-w-100px">SKU</th>
                                                        <th class="min-w-100px">Variant Name</th>
                                                        <th class="min-w-50px">Price</th>
                                                        <th class="min-w-50px">Discount</th>
                                                        <th class="min-w-50px">After Discount Price</th>
                                                        {{-- <th class="min-w-40px">Current Stock</th>
                                                        <th class="min-w-40px">Promotion Stock</th> --}}
                                                        <th class="min-w-40px">Action</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600" id="get-product-data">
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" class="promo-product-data" name="promo_products">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <div class="mb-10 fv-row">
                                    <div class="row">
                                        <label class="form-label">Banner</label>
                                    </div>
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-empty" data-kt-image-input="true"
                                        style="background-image: url({{ asset_administrator('assets/media/avatars/default.jpg') }})">
                                        <!--begin::Image preview wrapper-->
                                        <div class="image-input-wrapper w-125px h-125px"></div>
                                        <!--end::Image preview wrapper-->

                                        <!--begin::Edit button-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Change image">
                                            <i class="bi bi-pencil-fill fs-7"></i>

                                            <!--begin::Inputs-->
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="image" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Edit button-->

                                        <!--begin::Cancel button-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Cancel avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Cancel button-->

                                        <!--begin::Remove button-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            data-bs-dismiss="click" title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove button-->
                                    </div>
                                    <!--end::Image input-->
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Status</label>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" id="status"
                                            name="status" checked="checked" />
                                        <label class="form-check-label fw-bold text-gray-400 ms-3"
                                            for="status">Active</label>
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Note</label>
                                    <textarea name="note" class="form-control"></textarea>
                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.promo_products') }}" id="kt_ecommerce_add_product_cancel"
                                class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="promo-product_submit" class="btn btn-primary">
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

    <div class="modal fade" id="product-data-modal" tabindex="-1" aria-hidden="true">
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
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
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
                        <h2>Browse Product</h2>
                    </div>
                    <div class="mb-5">
                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="col-lg-4 mt-5" style="float: right !important">
                                <input type="text" class="form-control form-control-sm" placeholder="Search"
                                    id="searchProductTable" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5" id="dataProduct">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th>No</th>
                                        <th class="min-w-100px">Product Name</th>
                                        <th class="min-w-100px">Variant Name</th>
                                        {{-- <th class="min-w-50px">Stock</th> --}}
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-product">Select</button>
                        <!--end::List-->
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <table class="template-data" style="display: none;" >
        <tr class="template-product-list" childidx="0" style="position: relative;">
            <td class="px-0 product_name"></td>
            <td class="px-0 sku"></td>
            <td class="px-0 variant_name"></td>
            <td class="px-0 price text-end"></td>
            <td class="fv-row">
                <div class="col-auto">
                    <div class="form-check form-switch form-check-custom form-check-solid mb-1">
                        <input class="form-check-input discount_type_product" type="checkbox" value="1" id="product[0][discount_type_product]" name="product[0][discount_type_product]" />
                        <label class="form-check-label fw-bold text-gray-400 ms-3 discount_label_product" for="product[0][discount_type_product]">Percentage (%)</label>
                    </div>
                    <input type="text" class="form-control form-white text-end discount_value_product format-number withseparator" name="product[0][discount_value_product]" data-max="" required>
                </div>
            </td>
            <td class="px-0 after_discount_price text-end">
            </td>
            {{-- <td class="px-0 stock text-end"></td> --}}
            <td class="fv-row">
                <input type="hidden" class="product_id" name="product[0][product_id]">
                <input type="hidden" class="variant_id" name="product[0][variant_id]">
                {{-- <input type="hidden" class="current_stock" name="product[0][current_stock]"> --}}
                <input type="hidden" class="after_discount_price_value" name="product[0][after_discount_price]">
                {{-- <input type="text" class="form-control form-white text-end promotion_stock format-number withseparator" name="product[0][promotion_stock]" data-max="" required> --}}
            </td>
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
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/promo-product.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#kt_datepicker_3").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });

            $("#kt_datepicker_5").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });

            $(this).find('.end_date').on('click', function(){
                if($(".start_date").val() == ''){
                    Swal.fire('Warning!', 'Please place a date!', 'info');
                }
            })

            $(this).find('.start_date').on('change', function(){
                $("#kt_datepicker_4").flatpickr({
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    minDate: $(this).val()
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

            var count_product = $('#get-product-data').find('.product-list').length;
            if (count_product != 0) {
                $(".promo-product-data").val(count_product);
            } else {
                $(".promo-product-data").val('');
            }

            $(".kt_datepicker_1").flatpickr({
                dateFormat: "d-m-Y",
            });

            $(".discount_type").on("click", function() {
                if ($('input.discount_type').is(':checked')) {
                    $(".discount_label").text('Percentage (%)');

                    $(".product-list").find('input.discount_type_product').each(function() {
                        $(this).attr("checked", "checked");
                        $(this).prop("checked", true);
                        $(".discount_label_product").text('Percentage (%)');
                    });
                } else {
                    $(".discount_label").text('Amount');

                    $(".product-list").find('input.discount_type_product').each(function() {
                        $(this).removeAttr("checked");
                        $(this).prop("checked", false);
                        $(".discount_label_product").text('Amount');
                    });
                }
            });

            resetData();
        });

        function resetData() {
            var index = 0;
            $(".product-list").each(function() {
                var another = this;
                search_index = $(this).attr("childidx");

                $(this).find('input,select').each(function() {
                    this.name = this.name.replace('[' + search_index + ']', '[' + index + ']');
                    this.id = this.id.replace('[' + search_index + ']', '[' + index + ']');

                    $(another).attr("childidx", index);
                });


                var old_for = $(this).find('.discount_label_product').attr("for");
                new_for = old_for.replace('[' + search_index + ']', '[' + index + ']');
                $(this).find('.discount_label_product').attr("for", new_for);

                $(".discount_type").on("click", function() {
                    if($(".discount_type_product").is(':checked')){
                        $(another).find(".after_discount_price").text($(another).find(".price").text() - ($(another).find(".price").text() * $(".discount_value").val() / 100));
                        $(another).find(".after_discount_price_value").val($(another).find(".price").text() - ($(another).find(".price").text() * $(".discount_value").val() / 100));
                    }else{
                        $(another).find(".after_discount_price").text($(another).find(".price").text() - $(".discount_value").val());
                        $(another).find(".after_discount_price_value").val($(another).find(".price").text() - $(".discount_value").val());
                    }
                });

                // $(".discount_value").on("keyup", function() {
                //     $(".discount_value_product").val($(".discount_value").val());
                //     if($(".discount_type_product").is(':checked')){
                //         $(another).find(".after_discount_price").text($(another).find(".price").text() - ($(another).find(".price").text() * $(".discount_value").val() / 100));
                //         $(another).find(".after_discount_price_value").val($(another).find(".price").text() - ($(another).find(".price").text() * $(".discount_value").val() / 100));
                //     }else{
                //         $(another).find(".after_discount_price").text($(another).find(".price").text() - $(".discount_value").val());
                //         $(another).find(".after_discount_price_value").val($(another).find(".price").text() - $(".discount_value").val());
                //     }
                // });

                $(this).find(".discount_type_product").on("click", function() {
                    if($(this).is(':checked')){
                        $(another).find(".after_discount_price").text($(another).find(".price").text() - ($(another).find(".price").text() * $(another).find(".discount_value_product").val() / 100));
                        $(another).find(".after_discount_price_value").val($(another).find(".price").text() - ($(another).find(".price").text() * $(another).find(".discount_value_product").val() / 100));
                    }else{
                        $(another).find(".after_discount_price").text($(another).find(".price").text() - $(another).find(".discount_value_product").val());
                        $(another).find(".after_discount_price_value").val($(another).find(".price").text() - $(another).find(".discount_value_product").val());
                    }
                });
                $(this).find(".discount_value_product").on("keyup", function() {
                    var discountTypeProductChecked = $(another).find(".discount_type_product").is(':checked');
                    var price = parseFloat($(another).find(".price").text().replace(/[^0-9.-]+/g, ''));
                    var discountValue = parseFloat($(this).val().replace(/[^0-9.-]+/g, ''));

                    if (discountTypeProductChecked) {
                        // Percentage Discount Calculation
                        $(another).find(".after_discount_price").text(price - (price * discountValue / 100));
                        $(another).find(".after_discount_price_value").val(price - (price * discountValue / 100));
                    } else {
                        // Amount Discount Calculation
                        $(another).find(".after_discount_price").text(price - discountValue);
                        $(another).find(".after_discount_price_value").val(price - discountValue);
                    }
                });

                $(this).find("input.discount_type_product").on("click", function() {
                    if ($(this).is(':checked')) {
                        $(another).find(".discount_label_product").text('Percentage (%)');
                    } else {
                        $(another).find(".discount_label_product").text('Amount');
                    }
                });

                // $(this).find('input.promotion_stock').on('keyup', function(){
                //     maxval = parseFloat($(another).find('.stock').text());
                //     input = parseFloat($(this).val());
                //     console.log(input);
                //     console.log(maxval);
                //     if(input > maxval){
                //         $(this).val(0);
                //         Swal.fire('Warning!', 'Promotion stock greater than stock!', 'info');
                //     }
                // });

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
                    var existingData = $(another).find('.id-product').val();
                    // console.log(existingData)
                    console.log('tes');

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
                                    url: "{{ route('admin.promo_products.delete-detail') }}",
                                    data: ({
                                        "_token": "{{ csrf_token() }}",
                                        "_method": 'DELETE',
                                        ix: existingData,
                                    }),
                                    success: function(resp) {
                                        if (resp.success) {
                                            Swal.fire('Deleted!',
                                                'Data has been deleted', 'success');
                                        } else {
                                            Swal.fire('Failed!', 'Deleted data failed',
                                                'error');
                                        }
                                        $(another).remove();

                                        var count_product = $('#get-product-data').find(
                                            '.product-list').length;
                                        if (count_product != 0) {
                                            $(".promo-product-data").val(count_product);
                                        } else {
                                            $(".promo-product-data").val('');
                                        }

                                        resetData();
                                    },
                                    error: function(resp) {
                                        Swal.fire("Error!", "Something went wrong.",
                                            "error");
                                    }
                                });
                            } else {
                                $(another).remove();

                                var count_product = $('#get-product-data').find('.product-list')
                                    .length;
                                if (count_product != 0) {
                                    $(".promo-product-data").val(count_product);
                                } else {
                                    $(".promo-product-data").val('');
                                }

                                resetData();
                            }
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

                index++;
            });

            if (index == 0) {
                var jumlah_detail = "";
            } else {
                var jumlah_detail = index;
            }

            $(".jumlah_detail").val(jumlah_detail);

            addValidation();

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
        }

        // get data product
        $('#product-data').off().on('click', function() {
            getProduct();
            $('#product-data-modal').modal('show');
        });

        function addValidation(){
            $(".product-list").each(function() {
                index = $(this).attr("childidx");
                $(this).find('.discount_value_product').each(function() {
                    var data_max = $(this).data('max');
                    validator.addField("product[" + index + "][discount]", {
                        validators: {
                            notEmpty: {
                                message: 'Discount is required'
                            },
                            between: {
                                min: 1,
                                max: data_max,
                                message: 'Discount cannot be more than the price'
                            },
                        }
                    });
                });
                // validator.addField("product[" + index + "][promotion_stock]", {
                //     validators: {
                //         notEmpty: {
                //             message: 'Promotion Stock is required'
                //         }
                //     }
                // });
                validator.addField("product[" + index + "][discount_value_product]", {
                    validators: {
                        notEmpty: {
                            message: 'Discount is required'
                        }
                    }
                });
            });
        }

        function getProduct() {
            $('#searchProductTable').keyup(function() {
                $('#dataProduct').DataTable().search($(this).val()).draw();
            });
            $("#dataProduct").DataTable().destroy();
            $('#dataProduct tbody').remove();
            $('#dataProduct').DataTable({
                "searching": true,
                "dom": 'lrtip',
                "pagingType": "full_numbers",
                "order": [
                    [0, "desc"]
                ],
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
                    "url": "{{ route('admin.promo_products.product-data') }}",
                    "dataType": "JSON",
                    "type": "GET",
                    "data": {
                        datatable: true,
                    },
                },
                'select': {
                    'style': 'multi'
                },
                "columns": [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        "data": "product_name"
                    },
                    {
                        "data": "variant_name"
                    },
                    // {
                    //     render: function(data, type, row, meta) {
                    //         if (row.stock == null) {
                    //             return '0';
                    //         } else {
                    //             return meta.settings.fnFormatNumber(row.stock);
                    //         }
                    //     },
                    // },
                ]

            });

            var table_product = $('#dataProduct').DataTable();

            $('#selectData-product').on('click', function(e, dt, node, config) {
                var rows_selected = table_product.rows({
                    selected: true
                }).data();

                $.each(rows_selected, function() {
                    daftar_product = new Array();
                    $('#listDataProduct').find('.variant_id').each(function(ind, value) {
                        daftar_product[ind] = this.value;
                    });
                    var exist_product = daftar_product.indexOf(this['variant_id'].toString());


                    if (parseInt(exist_product) == -1) {
                        var tr_clone = $(".template-product-list").clone();
                        var discount_value = $(".discount_value").val();

                        tr_clone.find(".product_id").val(this['product_id']);
                        tr_clone.find(".variant_id").val(this['variant_id']);
                        tr_clone.find(".product_name").text(this['product_name']);
                        tr_clone.find(".sku").text(this['sku']);
                        tr_clone.find(".price").text(this['price']);
                        tr_clone.find(".variant_name").text(this['variant_name']);

                        tr_clone.find(".discount_value_product").attr("data-max", this['price']);
                        tr_clone.find(".discount_value_product").val();
                        if ($('.discount_type').is(':checked')) {
                            tr_clone.find("input.discount_type_product").attr("checked", "checked");
                            tr_clone.find(".after_discount_price").text(this['price'] - (this['price'] *
                                discount_value / 100));
                            tr_clone.find(".after_discount_price_value").val(this['price'] - (this[
                                'price'] * discount_value / 100));
                        } else {
                            tr_clone.find(".discount_label_product").text("Amount");
                            tr_clone.find(".after_discount_price").text(this['price'] - (discount_value));
                            tr_clone.find(".after_discount_price_value").val(this['price'] - (
                                discount_value));
                        }

                        // tr_clone.find(".stock").text(this['stock']);
                        // tr_clone.find(".current_stock").val(this['stock']);
                        // tr_clone.find(".promotion_stock").attr("data-max", this['price']);

                        tr_clone.removeClass('template-product-list');
                        tr_clone.addClass('product-list');

                        $("#listDataProduct").append(tr_clone);

                        var count_product = $('#get-product-data').find('.product-list').length;
                        if (count_product != 0) {
                            $(".promo-product-data").val(count_product);
                        } else {
                            $(".promo-product-data").val('');
                        }

                        resetData();
                    }

                });

                $('#product-data-modal').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });
        }
    </script>
@endpush
