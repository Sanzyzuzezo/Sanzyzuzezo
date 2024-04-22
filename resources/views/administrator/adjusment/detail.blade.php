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
                
                <form id="form" class="form d-flex flex-column flex-lg-row"
                    action="#" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label">Warehouse</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="hidden" name="warehouse_id" class="form-control warehouse_id" value="{{ $detail->warehouse_id }}"/>
                                            <input type="text" name="warehouse_code" class="form-control warehouse_code" placeholder="Warehouse Code" value="{{ $detail->warehouse_code }}" readonly/>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="warehouse_name" class="form-control warehouse_name" placeholder="Warehouse Name" value="{{ $detail->warehouse_name }}" readonly/>
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
                                                        <th class="min-w-100px">SKU Variant</th>
                                                        <th class="min-w-100px">Item Variant Name</th>
                                                        <th class="min-w-50px">Current Stock</th>
                                                        <th class="min-w-50px">New Stock</th>
                                                        <th class="min-w-50px">Difference</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600" id="get-item-data">
                                                    <?php $no=0; ?>
                                                    @foreach ($adjusment_detail as $row)
                                                        <?php $no++ ?>
                                                        <tr class="item-list" childidx="0" style="position: relative;" id="item{{ $no }}">
                                                            <td class="px-0">{{ $row->item_name }}</td>
                                                            <td>{{ $row->sku_variant }}</td>
                                                            <td>
                                                                {{ $row->item_variant_name }}
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-white text-end withseparator format-number current_stock" name="item[{{ $no }}][current_stock]" value="{{ number_format($row->current_stock, 2) }}" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-white text-end withseparator format-number new_stock" name="item[{{ $no }}][new_stock]" value="{{ number_format($row->new_stock, 2) }}" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-white text-end withseparator format-number difference" name="item[{{ $no }}][difference]" value="{{ number_format($row->difference, 2) }}" readonly>
                                                            </td>
                                                        </tr>
                                                    @endforeach
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
                                <a href="{{ route('admin.adjusment') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-secondary me-5">Cancel</a>
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
    <script src="{{ asset_administrator('assets/js/custom/apps/ecommerce/catalog/adjusment.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/documentation.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/search.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/custom/documentation/forms/select2.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var count_item = $('#get-item-data').find('.item-list').length;
            if(count_item !=0){
                $(".adjusment-data").val(count_item);
            }else{
                $(".adjusment-data").val('');
            }

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
                                        if(count_item !=0){
                                            $(".adjusment-data").val(count_item);
                                        }else{
                                            $(".adjusment-data").val('');
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
                                if(count_item !=0){
                                    $(".adjusment-data").val(count_item);
                                }else{
                                    $(".adjusment-data").val('');
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
                    current_stock = parseInt($(another).find(".current_stock").val().indexOf(',') >= 3 ? $(another).find(".current_stock").val().split(',')[0] : $(another).find(".current_stock").val().replace(/[^0-9\.]/g, ''));
                    new_stock = parseInt($(another).find(".new_stock").val().indexOf(',') >= 3 ? $(another).find(".new_stock").val().split(',')[0] : $(another).find(".new_stock").val().replace(/[^0-9\.]/g, ''));
                    var difference_val = current_stock - new_stock;
                    let difference = parseInt(difference_val);
                    let format = Intl.NumberFormat('en-US');
                    let difference_format = format.format(difference);
                    $(another).find(".difference").val(difference_format);
                });
                
                $(this).find(".difference").keyup(function(e) {
                    current_stock = parseInt($(another).find(".current_stock").val().indexOf(',') >= 3 ? $(another).find(".current_stock").val().split(',')[0] : $(another).find(".current_stock").val().replace(/[^0-9\.]/g, ''));
                    difference = parseInt($(another).find(".difference").val().indexOf(',') >= 3 ? $(another).find(".difference").val().split(',')[0] : $(another).find(".difference").val().replace(/[^0-9\.]/g, ''));
                    var news_stock_val = current_stock - difference;
                    let new_stock = parseInt(news_stock_val);
                    let format = Intl.NumberFormat('en-US');
                    let new_stock_format = format.format(new_stock);
                    $(another).find(".new_stock").val(new_stock_format);
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
                        tr_clone.find(".sku_variant").text(this['sku_variant']);
                        tr_clone.find(".item_variant_name").text(this['item_variant_name']);
                        if(this['current_stock'] == null){
                            tr_clone.find(".current_stock").val('0');
                        }else{
                            tr_clone.find(".current_stock").val(this['current_stock']);
                        }

                        tr_clone.removeClass('template-item-list');
                        tr_clone.addClass('item-list');
                        $("#listDataItem").append(tr_clone);
            
                        var count_item = $('#get-item-data').find('.item-list').length;
                        if(count_item !=0){
                            $(".adjusment-data").val(count_item);
                        }else{
                            $(".adjusment-data").val('');
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