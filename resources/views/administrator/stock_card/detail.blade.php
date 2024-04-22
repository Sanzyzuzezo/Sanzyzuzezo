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
                <form id="form" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data">
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
                                    <label class="form-label">Date</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="date" class="form-control kt_datepicker_1" value="{{ date('d-m-Y', strtotime($detail->date)) }}" readonly/>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Transaction Type</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-select transaction_type" name="transaction_type" disabled>
                                                <option value="in" {{ $detail->transaction_type == 'in' ? 'selected' : '' }}>In</option>
                                                <option value="out" {{ $detail->transaction_type == 'out' ? 'selected' : '' }}>Out</option>
                                                <option value="move_location" {{ $detail->transaction_type == 'move_location' ? 'selected' : '' }}>Move Location</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="form-label">Warehouse</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="warehouse_code" class="form-control warehouse_code" placeholder="Warehouse Code" value="{{ $detail->warehouse_code }}" readonly/>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="warehouse_name" class="form-control warehouse_name" placeholder="Warehouse Name" value="{{ $detail->warehouse_name }}" readonly/>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <div class="mb-10 fv-row destination_form" style="{{ $detail->transaction_type == 'move_location' ? 'display: block' : 'display: none' }}">
                                    <label class="form-label">Destination Warehouse</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="destination_warehouse_code" class="form-control destination_warehouse_code" placeholder="Warehouse Code" value="{{ $destination_warehouse != null ? $destination_warehouse->code : '' }}" readonly/>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="destination_warehouse_name" class="form-control destination_warehouse_name" placeholder="Warehouse Name" value="{{ $destination_warehouse != null ? $destination_warehouse->name : '' }}" readonly/>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                    </div>
                                </div>
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Items</label>
                                    <!--end::Label-->
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
                                                            <td>{{ $row->item_name }}</td>
                                                            <td>
                                                                {{ $row->item_variant_name }}
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control text-end" name="item[{{ $no }}][quantity]" value="{{ number_format($row->quantity, 2) }}" readonly>
                                                            </td>
                                                            <?php
                                                                $unit = App\Models\UnitConversion::select(DB::raw('unit_conversions.new_unit as name, unit_conversions.id'))
                                                                                        ->where("unit_conversions.item_variant_id", $row->item_variant_id)
                                                                                        ->where("unit_conversions.status", 1)
                                                                                        ->get();
                                                            ?>
                                                            <td>
                                                                <select class="form-select" name="item[{{ $no }}][unit_id]" id="unit{{ $no }}" disabled>
                                                                    <option value="0" {{ $row->unit_id == 0 ? 'selected' : '' }}>{{ $row->unit_name }}</option>
                                                                    @foreach ($unit as $unit)
                                                                        <option value="{{ $unit->id }}" {{ $unit->id == $row->unit_id ? 'selected' : ''  }}>{{ $unit->name }}</option>
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
                            <!--end::Card header-->
                        </div>
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.stock_card') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            {{-- <button type="submit" id="stock_card_submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button> --}}
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
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".transaction_type").change(function(){
                if($(".transaction_type option:selected").val() == 'move_location'){
                    $(".destination_form").css({"display": "block"});
                }else{
                    $(".destination_form").css({"display": "none"});
                }
            });

            resetData();
        });

        function resetData() {
            var index = 0;
            $(".item-list").each(function () {
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
                                    url: "{{ route('admin.stock_card.delete-detail') }}",
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

                                        resetData();
                                    },
                                    error: function (resp) {
                                        Swal.fire("Error!", "Something went wrong.", "error");
                                    }
                                });
                            }else{
                                $(another).remove();

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

            if (index == 0) {
                var jumlah_detail = "";
            } else {
                var jumlah_detail = index;
            }

            $(".jumlah_detail").val(jumlah_detail);

        }
    </script>
@endpush
