@extends('administrator.layouts.main')

@push('css')
    <style>
    .text-right {
    text-align: right;
	}
    </style>
@endpush

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Orders</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Orders</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                            transform="rotate(45 17.0365 15.1223)" fill="black" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <input type="text" data-kt-ecommerce-category-filter="search"
                                    class="form-control form-control-sm form-control-solid w-250px ps-14"
                                    placeholder="Search" id="searchdatatable" />
                            </div>
                        </div>
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <div class="w-100 mw-150px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Status" id="filterstatus">
                                    <option value=" ">All Status</option>
                                    <option value="waiting_for_payment">Waiting For Payment</option>
                                    <option value="processed">Processed</option>
                                    <option value="shipping">Shipping</option>
                                    <option value="finished">Finished</option>
                                    <option value="complain">Complain</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                            <div class="w-200px mw-200px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" id="filterpayment">
                                    <option value="all">All Payment Method</option>
                                    <option value="manual_bank_transfer">Manual Bank Transfer</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                            <a href="#" class="btn btn-sm btn-light-danger mx-2" onclick="printOrders('printarea')">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path opacity="0.3"
                                            d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14V4H6V20H18V8H20V21C20 21.6 19.6 22 19 22Z"
                                            fill="black" />
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                    </svg>
                                </span>
                                PDF
                            </a>
                            <a href="{{ route('admin.order.export') }}" class="btn btn-sm btn-light-success mx-2">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path opacity="0.3"
                                            d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14V4H6V20H18V8H20V21C20 21.6 19.6 22 19 22Z"
                                            fill="black" />
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                    </svg>
                                </span>
                                Excel
                            </a>
                            <div class="d-flex justify-content-end align-items-center d-none" id="button_update">
                                @if (isAllowed('orders', 'updateStatus'))
                                    <button type="button" class="btn btn-sm btn-light-success me-3" id="updateStatusSelected">Update Status Selected</button>
                                    <button type="button" class="btn btn-sm btn-light-success me-3" id="printResi">Print Resi</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="orders-table">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="w-25px">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" id="checkall" type="checkbox"
                                                    data-kt-check="true"
                                                    data-kt-check-target="#orders-table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-50px">Invoice Number</th>
                                        <th class="min-w-120px">Customer Name</th>
                                        <th class="min-w-50px">Status</th>
                                        <th class="min-w-70px">Shipping</th>
                                        <th class="min-w-70px">No Resi</th>
                                        <th class="min-w-80px">Payment</th>
                                        <th class="min-w-100px">Grand Total</th>
                                        <th class="min-w-100px">Confirm</th>
                                        <th class="min-w-50px">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid d-none" id="printarea">
            <div id="kt_content_container" class="container-xxl">
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <h2>Orders Data</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="order-table">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">Invoice Number</th>
                                        <th class="min-w-120px">Customer Name</th>
                                        <th class="min-w-50px">Status</th>
                                        <th class="min-w-70px">Shipping</th>
                                        <th class="min-w-70px">No Resi</th>
                                        <th class="min-w-80px">Payment</th>
                                        <th class="min-w-100px">Grand Total</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update_status" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bolder">Update Status</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" enctype="multipart/form-data"
                        action="{{ route('admin.orders.update-status') }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="fv-row mb-5">
                            <label class="fs-5 fw-bold form-label mb-5">Status:</label>
                            <select data-control="select2" name="status" class="form-select form-select-solid"
                                id="update-status" onchange="statusChange()">
                                <option value="">-- Please Choose --</option>
                                <option value="waiting_for_payment">Waiting For Payment</option>
                                <option value="waiting_for_confirmation">Waiting For Confirmation</option>
                                <option value="processed">Processed</option>
                                <option value="shipping">Shipping</option>
                                <option value="finished">Finished</option>
                                <option value="complain">Complain</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <div id="message"></div>
                        <div class="fv-row mb-10">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="selectedOrder">
                                <thead>
                                    <tr class="border-bottom fs-6 fw-bolder">
                                        <th class="min-w-50px">Invoice Number</th>
                                        <th class="min-w-50px">Customer Name</th>
                                        <th class="min-w-40px">Status</th>
                                        <th id="courier"></th>
                                        <th id="waybill"></th>
                                        <th id="resi"></th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Save Changes</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="content d-flex flex-column flex-column-fluid" id="printresiarea">
        <div class="post d-flex flex-column-fluid">
            <div id="kt_content_container" class="container-xxl">
                <div class="card">
                    <div class="card-body p-lg-20" id="tag_container">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function printOrders(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
			document.title = 'Orders Data';
            document.body.innerHTML =
                "<html><head><title></title><style>.col-lg-8{-webkit-box-flex: 0;-ms-flex: 0 0 auto;flex: 0 0 auto; width: 69%} .col-lg-4{-webkit-box-flex: 0;-ms-flex: 0 0 auto;flex: 0 0 auto; width:29%; background-color: rgba(245,248,250,.5)!important;}</style></head><body><div class='row'>" +
                divElements + "</div></body></html>";
            //console.log(divElements);

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
        function statusChange() {

            if (document.getElementById("update-status").value == 'shipping') {
                document.getElementById("courier").innerHTML = 'Courier';
                document.getElementById("waybill").innerHTML = 'Waybill';
                document.getElementById("resi").innerHTML = 'No Resi';

                var index = 0;
                $(".selectedrow").each(function() {
                    var selector_select = $(this).find(".id-order").val();

                    var courier_value = $(this).find(".courier-order").val();
                    $(this).find(".courier").html(courier_value);

                    var waybill_value = $(this).find(".waybill-order").val();
                    var waybill_option = "<select class='form-select waybill-value' name='waybill-" + selector_select + "' onchange='waybillChange()'>"+(waybill_value == '1' ? "<option value='1'>Automatic</option>" : "")+"<option value='0'>Manual</option></select>";
                    $(this).find(".waybill").html(waybill_option);

                    var resi_value = $(this).find(".resi-order").val();
                    var shipping = "<input type='text' name='resi-" + selector_select + "' value='" + resi_value +"' class='form-control resi-number' " + (waybill_value == '1' ? "disabled" : "") + "/>";
                    $(this).find(".resi").html(shipping);
                })
            } else {
                document.getElementById("courier").innerHTML = '';
                document.getElementById("waybill").innerHTML = '';
                document.getElementById("resi").innerHTML = '';

                var index = 0;
                $(".selectedrow").each(function() {
                    var selector_select = $(this).find(".id-order").val();

                    $(this).find(".courier").html("");
                    $(this).find(".waybill").html("");

                    var resi_value = $(this).find(".resi-order").val();
                    var shipping = "<input type='text' name='resi-" + selector_select + "' value='" + resi_value +"' class='form-control resi-number'/>";
                    $(this).find(".resi").html("");
                })
            }

        }

        function waybillChange() {
            $(".selectedrow").each(function() {
                var waybill_value = $(this).find(".waybill-value").val();
                if (waybill_value == '1') {
                    $(this).find(".resi-number").attr('disabled','disabled');
                }else{
                    $(this).find(".resi-number").removeAttr('disabled');
                }
            });
        }

        $(document).ready(function() {
            var data_order = $('#order-table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                ajax: {
                    url: "orders-data",
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.status = getStatus();
                        d.payment_method = getPayment();
                    }
                },
                columns: [
                    {
                        data: 'invoice_number',
                        name: 'invoice_number',
                        render: function(data, type, row) {
                            return "<a href='orders/detail/" + row.id +
                                "' class='text-gray-800 text-hover-primary fs-5 fw-bolder'>" + row
                                .invoice_number + "</a>"
                        },
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if (row.status == 'waiting_for_confirmation') {
                                return '<div class="badge badge-light-warning">Waiting For Confirmation</div>'
                            } else if (row.status == 'processed') {
                                return '<div class="badge badge-light-primary">Processed</div>'
                            } else if (row.status == 'shipping') {
                                return '<div class="badge badge-light-info">Shipping</div>'
                            } else if (row.status == 'finished') {
                                return '<div class="badge badge-light-success">Finished</div>'
                            } else if (row.status == 'complain') {
                                return '<div class="badge badge-light-danger">Complain</div>'
                            } else if (row.status == 'failed') {
                                return '<div class="badge badge-light-danger">Failed</div>'
                            } else {
                                return '<div class="badge badge-light-warning">Waiting For Payment</div>'
                            }
                        }
                    },
                    {
                        data: 'courier',
                        name: 'order_shippings.courier'
                    },
                    {
                        data: 'resi',
                        name: 'order_shippings.resi',
                        render: function(data, type, row) {
                            if (row.new_resi == null) {
                                return row.resi
                            } else {
                                return row.new_resi
                            }
                        },
                    },
                    {
                        data: 'payment_method',
                        name: 'order_billings.data',
                        render: function(data, type, row) {
                            if (row.payment_method != null) {
                                return '<div class="text-capitalize">' + row.payment_method +
                                    '</div>'
                            } else {
                                return '-'
                            }
                        },
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.total+row.cost);
                        },
                        className: "text-right"
                    }
                ]
            });

            var table_order = $('#order-table').DataTable();

            var data_orders = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: {
                    url: "orders-data",
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.status = getStatus();
                        d.payment_method = getPayment();
                    }
                },
                columns: [{
                        render: function(data, type, row) {
                            return '<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input check-status" type="checkbox" id="check" value="1" /></div>'
                        },
                    },
                    {
                        data: 'invoice_number',
                        name: 'invoice_number',
                        render: function(data, type, row) {
                            return "<a href='orders/detail/" + row.id +
                                "' class='text-gray-800 text-hover-primary fs-5 fw-bolder'>" + row
                                .invoice_number + "</a>"
                        },
                    },
                    {
                        data: 'cust_name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if (row.status == 'waiting_for_confirmation') {
                                return '<div class="badge badge-light-warning">Waiting For Confirmation</div>'
                            } else if (row.status == 'processed') {
                                return '<div class="badge badge-light-primary">Processed</div>'
                            } else if (row.status == 'shipping') {
                                return '<div class="badge badge-light-info">Shipping</div>'
                            } else if (row.status == 'finished') {
                                return '<div class="badge badge-light-success">Finished</div>'
                            } else if (row.status == 'complain') {
                                return '<div class="badge badge-light-danger">Complain</div>'
                            } else if (row.status == 'failed') {
                                return '<div class="badge badge-light-danger">Failed</div>'
                            } else {
                                return '<div class="badge badge-light-warning">Waiting For Payment</div>'
                            }
                        }
                    },
                    {
                        data: 'courier',
                        name: 'order_shippings.courier',
                        render: function(data, type, row) {
                            if (row.status_shipping == 'delivered') {
                                return row.courier+'<br/><div class="badge badge-light-success">Delivered</div>'
                            } else if (row.status_shipping == 'cancelled') {
                                return row.courier+'<br/><div class="badge badge-light-danger">Cancelled</div>'
                            } else if(row.status_shipping != null){
                                return row.courier+'<br/><div class="badge badge-light-warning text-capitalize">'+row.status_shipping+'</div>'
                            }else{
                                return row.courier
                            }
                        }
                    },
                    {
                        data: 'resi',
                        name: 'order_shippings.resi',
                        render: function(data, type, row) {
                            if (row.new_resi == null) {
                                return row.resi
                            } else {
                                return row.new_resi
                            }
                        },
                    },
                    {
                        data: 'payment_method',
                        name: 'order_billings.data',
                        render: function(data, type, row) {
                            if (row.payment_method != null) {
                                return '<div class="text-capitalize">' + row.payment_method +
                                    '</div>'
                            } else {
                                return '-'
                            }
                        },
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.total-(row.total*row.discount_order/100)-(row.total*row.discount_customer/100)+row.cost);
                            // return meta.settings.fnFormatNumber(row.total+row.cost);
                        },
                        className: "text-right"
                    },
                    {
                        data: 'confirm',  'searchable': false
                    },
                    {
                        'searchable': false,
                        render: function(data, type, row) {
                            return "<a href='orders/detail/" + row.id +
                                "' class='btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1'><span class='svg-icon svg-icon-3'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'><path d='M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z' fill='black'/><path opacity='0.3' d='M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z' fill='black'/></svg></span></a>"
                        }
                    },
                ]
            });

            var table_orders = $('#orders-table').DataTable();

            $('#updateStatusSelected').on('click', function(e) {
                var rows_selected = $(table_orders.$('input[type="checkbox"]:checked').map(function() {
                    return $(this).closest('tr');
                }));

                $(".selectedrow").remove();

                $.each(rows_selected, function() {
                    var data = table_orders.row(this).data();

                    if (data.status == 'processed') {
                        var status = '<div class="badge badge-light-primary">Processed</div>'
                    } else if (data.status == 'shipping') {
                        var status = '<div class="badge badge-light-info">Shipping</div>'
                    } else if (data.status == 'finished') {
                        var status = '<div class="badge badge-light-success">Finished</div>'
                    } else if (data.status == 'complain') {
                        var status = '<div class="badge badge-light-danger">Complain</div>'
                    } else if (data.status == 'failed') {
                        var status = '<div class="badge badge-light-danger">Failed</div>'
                    } else {
                        var status = '<div class="badge badge-light-warning">Waiting For Payment</div>'
                    }

                    if (data.courier != null) {
                        var courier = data.courier;
                    } else {
                        var courier = '';
                    }

                    if (data.instant_waybill != null) {
                        var instant_waybill = data.instant_waybill;
                    } else {
                        var instant_waybill = '';
                    }

                    if (data.resi != null) {
                        var resi = data.resi;
                    } else {
                        var resi = '';
                    }

                    var row_data =
                        "<tr class='selectedrow'><td><input type='hidden' class='id-order' name='id[]' value='" +
                        data.id + "' />" + data.invoice_number + "</td><td>" + data.cust_name + "</td><td>" + status +
                        "</td><td class='courier'></td><input type='hidden' class='courier-order' value='" + courier + "'>"+
                        "<td class='waybill'></td><input type='hidden' class='waybill-order' value='" + instant_waybill + "' />"+
                        "<td class='resi'></td><input type='hidden' class='resi-order' value`='" + resi + "' /></tr>";

                    $("#selectedOrder").append(row_data);
                });
                $("#update_status").modal("show");

                e.preventDefault();
            });

            $('#printResi').on('click', function(e) {
                var rows_selected = $(table_orders.$('input[type="checkbox"]:checked').map(function() {
                    return $(this).closest('tr');
                }));

                $('#tag_container').empty();

                $.each(rows_selected, function() {
                    var data = table_orders.row(this).data();
                    $.ajax({
                        url: 'orders/resi/'+data.id,
                        type: 'GET',
                        data: {
                            id: data.id
                        },
                        datatype: 'HTML',
                        success: function (data) {
                            $('#tag_container').append(data);
                        }
                    }).fail(function(jqXHR, ajaxOptions, thrownError) {
                        alert('No response from server');
                    });
                });

                //Get the HTML of div
                var divElements = document.getElementById("printresiarea").innerHTML;
                //Get the HTML of whole page
                var oldPage = document.body.innerHTML;

                //Reset the page's HTML with div's HTML only
                document.title = "Resi";
                document.body.innerHTML = "<html><head><title></title><style>.col-lg-8{-webkit-box-flex: 0;-ms-flex: 0 0 auto;flex: 0 0 auto; width: 69%} .col-lg-4{-webkit-box-flex: 0;-ms-flex: 0 0 auto;flex: 0 0 auto; width:29%; background-color: rgba(245,248,250,.5)!important;}</style></head><body><div class='row'>" + divElements + "</div></body></html>";
                // console.log(divElements);

                //Print Page
                // window.print();
                setTimeout(print, 3000);

                //Restore orignal HTML
                // document.body.innerHTML = oldPage;

                e.preventDefault();
            });

            function print() {
                window.print();
                window.location.reload(true);
            }

            $('#searchdatatable').keyup(function() {
                data_orders.search($(this).val()).draw();
            })

            $('#filterstatus').change(function() {
                data_orders.search($("#searchdatatable").val()).draw();
            })

            function getStatus() {
                return $("#filterstatus").val();
            }

            $('#filterpayment').change(function() {
                data_orders.search($("#searchdatatable").val()).draw();
            })

            function getPayment() {
                return $("#filterpayment").val();
            }

            $("#orders-table tbody").on("change", 'input[type="checkbox"]', function(e) {
                var rows_selected = $(table_orders.$('input[type="checkbox"]:checked').map(function() {
                    return $(this).closest('tr');
                }));
                // console.log(rows_selected);
                if (rows_selected.length > 0) {
                    $('#button_update').removeClass("d-none");
                } else {
                    $('#button_update').addClass("d-none");
                }
            })

            $('#checkall').on('change', function() {
                if ($("#checkall").is(":checked")) {
                    $('#button_update').removeClass("d-none");
                } else {
                    $('#button_update').addClass("d-none");
                }
            });

            //Delete Confirmation
            $(document).on('click', '.paymentConfirm', function(event) {
                var ix = $(this).data('ix');
                var attachment = $(this).data('attachment');
                // console.log(attachment)
                Swal.fire({
                    html: '<img src="'+attachment+'" class="img img-responsive" style="max-width:200px">',
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Valid",
                    cancelButtonText: 'Invalid',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.order.confirm_payment') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'PUT',
                                ix: ix,
                                status: 'paid'

                            }),
                            success: function() {
                                Swal.fire('Horay!', 'Payment is valid', 'success');
                                data_orders.ajax.reload(null, false);
                            }
                        });

                    } else {

                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.order.confirm_payment') }}",
                            data: ({
                                "_token": "{{ csrf_token() }}",
                                "_method": 'PUT',
                                ix: ix,
                                status: 'unpaid'

                            }),
                            success: function() {
                                Swal.fire('Not Valid!', 'Payment is Invalid', 'warning');
                                data_orders.ajax.reload(null, false);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
