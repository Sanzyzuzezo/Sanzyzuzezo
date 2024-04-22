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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Adjusment</h1>
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
                            <a href="{{ route('admin.adjusment') }}" class="text-muted text-hover-primary">Adjusment</a>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z" fill="black"/>
                                <path d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z" fill="black"/>
                            </svg>
                        </span>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Error</h4>
                            <span>{{ $message }}</span>
                        </div>
                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                            <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="black"/>
                                    <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="black"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                @endif

                <form id="form" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.adjusment.save') }}" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label required">Date</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="date" class="form-control kt_datepicker_1" placeholder="Date" value=""/>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label required">Warehouse</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="hidden" name="warehouse_id" class="form-control warehouse_id" value=""/>
                                            <input type="text" name="warehouse_code" class="form-control warehouse_code" placeholder="Warehouse Code" value="" readonly/>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="warehouse_name" class="form-control warehouse_name" placeholder="Warehouse Name" value="" readonly/>
                                        </div>
                                        <div class="col-auto warehouse-modal">
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
                                                        <th class="min-w-100px">SKU Variant</th>
                                                        <th class="min-w-100px">Item Variant Name</th>
                                                        <th class="min-w-30px">Current Stock</th>
                                                        <th class="min-w-30px">New Stock</th>
                                                        <th class="min-w-30px">Difference</th>
                                                        <th class="min-w-100px">Note</th>
                                                        <th class="min-w-30px">Action</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600" id="get-item-data">
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" class="adjusment-data" name="adjusments">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.adjusment') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="adjusment_submit" class="btn btn-primary">
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
                                        <th class="min-w-150px">Item Name</th>
                                        <th class="min-w-70px">SKU Variant</th>
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
            <td class="sku_variant"></td>
            <td class="item_variant_name"></td>
            <td>
                <input type="text" class="form-control form-white text-end withseparator format-number current_stock" name="item[0][current_stock]" readonly>
            </td>
            <td>
                <input type="hidden" class="item_id" name="item[0][item_id]">
                <input type="hidden" class="item_variant_id" name="item[0][item_variant_id]">
                <input type="text" class="form-control form-white text-end withseparator format-number new_stock" name="item[0][new_stock]">
            </td>
            <td>
                <input type="text" class="form-control form-white text-end withseparator format-number difference" name="item[0][difference]">
            </td>
            <td>
                <input type="text" class="form-control" name="item[0][note]">
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
@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/adjusment.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var count_item = $('#get-item-data').find('.item-list').length;
            if(count_item != 0){
                $(".adjusment-data").val(count_item);
                $(".warehouse-modal").addClass('d-none');
            }else{
                $(".adjusment-data").val('');
                $(".warehouse-modal").removeClass('d-none');
            }

            $(".kt_datepicker_1").flatpickr({
                dateFormat: "d-m-Y",
            });
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
                                    url: "{{ route('admin.adjusment.delete-detail') }}",
                                    data: ({
                                        "_token": "{{ csrf_token() }}",
                                        "_method": 'DELETE',
                                        ix: existingData,
                                    }),
                                    success: function(resp){
                                        if(resp.success){
                                            Swal.fire('Deleted!', 'Data has been deleted', 'success');
                                        }else{
                                            Swal.fire('Failed!', 'Deleted data failed', 'error');
                                        }
                                        $(another).remove();

                                        var count_item = $('#get-item-data').find('.item-list').length;
                                        if(count_item != 0){
                                            $(".adjusment-data").val(count_item);
                                            $(".warehouse-modal").addClass('d-none');
                                        }else{
                                            $(".adjusment-data").val('');
                                            $(".warehouse-modal").removeClass('d-none');
                                        }

                                        resetData();
                                    },
                                    error: function (resp) {
                                        Swal.fire("Error!", "Something went wrong.", "error");
                                    }
                                });
                            }else{
                                $(another).remove();

                                var count_item = $('#get-item-data').find('.item-list').length;
                                if(count_item != 0){
                                    $(".adjusment-data").val(count_item);
                                    $(".warehouse-modal").addClass('d-none');
                                }else{
                                    $(".adjusment-data").val('');
                                    $(".warehouse-modal").removeClass('d-none');
                                }
                                
                                resetData();
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
                    //             url: "{{ route('admin.adjusment.delete-detail') }}",
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
                
                $(this).find(".new_stock").keyup(function(e) {
                    current_stock = parseInt($(another).find(".current_stock").val().indexOf(',') >= 3 ? $(another).find(".current_stock").val().split('.')[0] : $(another).find(".current_stock").val().replace(/[^0-9\.]/g, ''));
                    new_stock = parseInt($(another).find(".new_stock").val().indexOf(',') >= 3 ? $(another).find(".new_stock").val().split('.')[0] : $(another).find(".new_stock").val().replace(/[^0-9\.]/g, ''));
                    var difference_val =  new_stock - current_stock ;
                    let difference = parseInt(difference_val);
                    let format = Intl.NumberFormat('en-US');
                    let difference_format = format.format(difference);
                    if(isNaN(parseFloat(difference_format))){
                        $(another).find(".difference").val('');
                    }else{
                        $(another).find(".difference").val(difference_format);
                    }
                });
                
                $(this).find(".difference").keyup(function(e) {
                    current_stock = parseInt($(another).find(".current_stock").val().indexOf(',') >= 3 ? $(another).find(".current_stock").val().split('.')[0] : $(another).find(".current_stock").val().replace(/[^0-9\.]/g, ''));
                    difference = parseInt($(another).find(".difference").val().indexOf(',') >= 3 ? $(another).find(".difference").val().split('.')[0] : $(another).find(".difference").val().replace(/[^0-9\.]/g, ''));
                    var news_stock_val = current_stock + difference;
                    let new_stock = parseInt(news_stock_val);
                    let format = Intl.NumberFormat('en-US');
                    let new_stock_format = format.format(new_stock);
                    if(isNaN(parseFloat(new_stock_format))){
                        $(another).find(".new_stock").val('');
                    }else{
                        $(another).find(".new_stock").val(new_stock_format);
                    }
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
                $('#dataWarehouse').DataTable().search($(this).val()).draw();
            });
            $("#dataWarehouse").DataTable().destroy();
            $('#dataWarehouse tbody').remove();
            $('#dataWarehouse').DataTable({
                "searching": true,
                "regex": true,
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
                    "url": "{{ route('admin.adjusment.warehouse-data') }}",
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
                }

        		$('#warehouse-data-modal').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });
        }
        
        // get data item
        $('#item-data').off().on('click', function () {
            if ($(".warehouse_id").val() == "") {
                Swal.fire('Oops!', 'Please select warehouse', 'warning');
            }else{
                getItem();
                $('#item-data-modal').modal('show');
            }
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
                    "url": "{{ route('admin.adjusment.item-data') }}",
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
                    { "data": "sku_variant" },
                    { "data": "item_variant_name" },
                    {
                        render: function(data, type, row, meta) {
                            if(row.current_stock == null){
                                return '0';
                            }else{
                                return meta.settings.fnFormatNumber(row.current_stock);
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
                        tr_clone.find(".item_id").val(this['item_id']);
                        tr_clone.find(".item_name").text(this['item_name']);
                        tr_clone.find(".sku_variant").text(this['sku_variant']);
                        tr_clone.find(".item_variant_name").text(this['item_variant_name']);
                        if(this['current_stock'] == null){
                            tr_clone.find(".current_stock").val('0');
                            tr_clone.find(".difference").attr('readonly', true);
                        }else{
                            let current_stock = parseInt(this['current_stock']);
                            let format = Intl.NumberFormat('en-US');
                            let current_stock_format = format.format(current_stock);
                            tr_clone.find(".current_stock").val(current_stock_format);
                        }

                        tr_clone.removeClass('template-item-list');
                        tr_clone.addClass('item-list');
                        $("#listDataItem").append(tr_clone);
            
                        var count_item = $('#get-item-data').find('.item-list').length;
                        if(count_item != 0){
                            $(".adjusment-data").val(count_item);
                            $(".warehouse-modal").addClass('d-none');
                        }else{
                            $(".adjusment-data").val('');
                            $(".warehouse-modal").removeClass('d-none');
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
