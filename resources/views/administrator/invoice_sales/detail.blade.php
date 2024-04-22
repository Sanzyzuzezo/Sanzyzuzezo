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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Invoice Sales</h1>
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
                            <a href="{{ route('admin.invoice_sales') }}" class="text-muted text-hover-primary">Invoice
                                Sales</a>
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

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">

            <input type="hidden" id="inputId" value="{{$data->id}}">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-xxl ">
                <!--begin::Invoice 2 main-->
                <div class="card">
                    <!--begin::Body-->
                    <div class="card-body p-lg-20">
                        <!--begin::Layout-->
                        <div class="d-flex flex-column flex-xl-row">
                            <!--begin::Content-->
                            <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                                <!--begin::Invoice 2 content-->
                                <div class="mt-n1">
                                    <!--begin::Top-->
                                    <div class="d-flex flex-stack pb-10">
                                        <!--begin::Logo-->
                                        <a href="#">
                                            <img alt="Logo" width="100px"
                                                src="{{ array_key_exists('logo', $settings) ? img_src($settings['logo'], 'settings') : '' }}" />
                                        </a>
                                        <!--end::Logo-->

                                        <!--begin::Action-->
                                        <a href="javascript:void(0)" class="btn btn-sm btn-success" id="triggerExportDetail">Export</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Top-->

                                    <!--begin::Wrapper-->
                                    <div class="m-0">
                                        <!--begin::Label-->
                                        <div class="fw-bold fs-3 text-gray-800 mb-8">Invoice #{{$data->invoice_sales_number}}</div>
                                        <!--end::Label-->

                                        <!--begin::Row-->
                                        <div class="row g-5 mb-11">
                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <!--end::Label-->
                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Issue Date:</div>
                                                <!--end::Label-->

                                                <!--end::Col-->
                                                <div class="fw-bold fs-6 text-gray-800">
                                                    {{ date('d-m-Y', strtotime($data->date)) }}</div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Col-->

                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <!--end::Label-->
                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Due Date:</div>
                                                <!--end::Label-->

                                                <!--end::Info-->
                                                <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center flex-wrap">
                                                    <span
                                                        class="pe-2">{{ date('d-m-Y', strtotime($data->date . ' +7 days')) }}</span>

                                                    <span class="fs-7 text-danger d-flex align-items-center">
                                                        @php
                                                            // Tambahkan 7 hari ke tanggal pembuatan untuk mendapatkan tenggat waktu
                                                            $tanggal_tenggat = date('Y-m-d', strtotime($data->date . ' + 7 days'));
                                                            // Konversi tanggal ke timestamp
                                                            $timestamp_sekarang = strtotime(now());
                                                            $timestamp_tenggat = strtotime($tanggal_tenggat);

                                                            // Hitung selisih waktu dalam detik
                                                            $selisih_detik = $timestamp_tenggat - $timestamp_sekarang;

                                                            // Konversi selisih detik ke hari
                                                            $sisa_hari = floor($selisih_detik / (60 * 60 * 24));
                                                        @endphp
                                                            <span class="bullet bullet-dot bg-danger me-2"></span>
                                                        @if ($data->payment_status === 0)
                                                            Due in {{ $sisa_hari }} days
                                                        @endif
                                                    </span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row g-5 mb-12">
                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <!--end::Label-->
                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Issue For:</div>
                                                <!--end::Label-->

                                                <!--end::Text-->
                                                <div class="fw-bold fs-6 text-gray-800">{{ $data->customer_name }}.</div>
                                                <!--end::Text-->

                                                <!--end::Description-->
                                                <div class="fw-semibold fs-7 text-gray-600">
                                                    {{ $data->customer_phone }} <br />
                                                    {{ $data->customer_address }}
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Col-->

                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <!--end::Label-->
                                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Issued By:</div>
                                                <!--end::Label-->

                                                <!--end::Text-->
                                                <div class="fw-bold fs-6 text-gray-800">CodeLab Inc.</div>
                                                <!--end::Text-->

                                                <!--end::Description-->
                                                <div class="fw-semibold fs-7 text-gray-600">
                                                    9858 South 53rd Ave.<br />
                                                    Matthews, NC 28104
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->


                                        <!--begin::Content-->
                                        <div class="flex-grow-1">
                                            <!--begin::Table-->
                                            <div class="table-responsive border-bottom mb-9">
                                                <table class="table mb-3">
                                                    <thead>
                                                        <tr class="border-bottom fs-6 fw-bold text-muted">
                                                            <th class="min-w-70px pb-2">Image</th>
                                                            <th class="min-w-175px pb-2">Item Variants</th>
                                                            <th class="min-w-70px text-end pb-2">Quantity</th>
                                                            <th class="min-w-100px text-end pb-2">Amount</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($data_detail as $row)
                                                            <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                                <td class="align-items-center text-start pt-6">
                                                                    <img width="50px"
                                                                        src="{{ img_src($row->data_file, 'product') }}"
                                                                        alt="">
                                                                </td>
                                                                <td class="d-flex align-items-center pt-6">
                                                                    {{ $row->nama_item_variant }}
                                                                </td>

                                                                <td class="pt-6">{{ $row->quantity }}</td>
                                                                <td class="pt-6 text-gray-900 fw-bolder">Rp
                                                                    {{ number_format($row->total_payment, 0, ',', '.') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--end::Table-->

                                            <!--begin::Container-->
                                            <div class="d-flex justify-content-end">
                                                <!--begin::Section-->
                                                <div class="mw-300px">
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack mb-3">
                                                        <!--begin::Accountname-->
                                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">Subtotal:</div>
                                                        <!--end::Accountname-->

                                                        <!--begin::Label-->
                                                        <div class="text-end fw-bold fs-6 text-gray-800">Rp
                                                            {{ number_format($data->total_payment_amount, 0, ',', '.') }}
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack mb-3">
                                                        <!--begin::Accountname-->
                                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">TAX 0%</div>
                                                        <!--end::Accountname-->

                                                        <!--begin::Label-->
                                                        <div class="text-end fw-bold fs-6 text-gray-800">Rp 0</div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack mb-3">
                                                        <!--begin::Accountnumber-->
                                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">Subtotal + TAX
                                                        </div>
                                                        <!--end::Accountnumber-->

                                                        <!--begin::Number-->
                                                        <div class="text-end fw-bold fs-6 text-gray-800">Rp
                                                            {{ number_format($data->total_payment_amount, 0, ',', '.') }}
                                                        </div>
                                                        <!--end::Number-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Code-->
                                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">Total</div>
                                                        <!--end::Code-->

                                                        <!--begin::Label-->
                                                        <div class="text-end fw-bold fs-6 text-gray-800">Rp
                                                            {{ number_format($data->total_payment_amount, 0, ',', '.') }}
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Item-->
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Container-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Invoice 2 content-->
                            </div>
                            <!--end::Content-->

                            <!--begin::Sidebar-->
                            <div class="m-0">
                                <!--begin::Invoice 2 sidebar-->
                                <div
                                    class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">
                                    <!--begin::Labels-->
                                    <div class="mb-8">
                                        <span class="badge badge-light-success me-2">Approved</span>
                                        @if ($data->payment_status === 0)
                                            <span class="badge badge-light-warning">Pending Payment</span>
                                        @else
                                            <span class="badge badge-light-success me-2">Already Paid</span>
                                        @endif

                                    </div>
                                    <!--end::Labels-->

                                    <!--begin::Title-->
                                    <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">PAYMENT DETAILS</h6>
                                    <!--end::Title-->

                                    <!--begin::Item-->
                                    <div class="mb-6">
                                        <div class="fw-semibold text-gray-600 fs-7">Information:</div>

                                        <div class="fw-bold text-gray-800 fs-6">{{ $data->payment_information }}</div>
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="mb-6">
                                        <div class="fw-semibold text-gray-600 fs-7">Type Invoice:</div>

                                        <div class="fw-bold text-gray-800 fs-6">
                                            {{ $data->sales_id === 0 ? 'Delivery Note' : 'Sales' }} <br />
                                            {{ $data->sales_id === 0 ? $data->delivery_note_number : $data->sales_number }}
                                        </div>
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    @php
                                        // Tambahkan 7 hari ke tanggal pembuatan untuk mendapatkan tenggat waktu
                                        $tanggal_tenggat = date('Y-m-d', strtotime($data->date . ' + 7 days'));
                                        // Konversi tanggal ke timestamp
                                        $timestamp_sekarang = strtotime(now());
                                        $timestamp_tenggat = strtotime($tanggal_tenggat);

                                        // Hitung selisih waktu dalam detik
                                        $selisih_detik = $timestamp_tenggat - $timestamp_sekarang;

                                        // Konversi selisih detik ke hari
                                        $sisa_hari = floor($selisih_detik / (60 * 60 * 24));
                                    @endphp
                                    <div class="mb-6">
                                        <div class="fw-semibold text-gray-600 fs-7">Payment Term:</div>

                                        <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center">
                                            7 days

                                            @if ($data->payment_status === 0)
                                                <span class="fs-7 text-danger d-flex align-items-center">
                                                    <span class="bullet bullet-dot bg-danger mx-2"></span>

                                                    Due in {{ $sisa_hari }} days
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="mb-15">
                                        <div class="fw-semibold text-gray-600 fs-7 mb-3">Proof of Payment:</div>

                                        <div class="fw-bold text-gray-800 fs-6"><img width="275px"
                                                src="{{ img_src($data->proof_of_payment, 'invoice_sales') }}"
                                                alt=""></div>
                                    </div>
                                    <!--end::Item-->

                                    {{-- <!--begin::Title-->
                                    <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">PROJECT OVERVIEW</h6>
                                    <!--end::Title-->

                                    <!--begin::Item-->
                                    <div class="mb-6">
                                        <div class="fw-semibold text-gray-600 fs-7">Project Name</div>

                                        <div class="fw-bold fs-6 text-gray-800">
                                            SaaS App Quickstarter

                                            <a href="#" class="link-primary ps-1">View Project</a href="#">
                                        </div>
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="mb-6">
                                        <div class="fw-semibold text-gray-600 fs-7">Completed By:</div>

                                        <div class="fw-bold text-gray-800 fs-6">Mr. Dewonte Paul</div>
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="m-0">
                                        <div class="fw-semibold text-gray-600 fs-7">Time Spent:</div>

                                        <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center">
                                            230 Hours

                                            <span class="fs-7 text-success d-flex align-items-center">
                                                <span class="bullet bullet-dot bg-success mx-2"></span>

                                                35$/h Rate
                                            </span>
                                        </div>
                                    </div>
                                    <!--end::Item--> --}}
                                </div>
                                <!--end::Invoice 2 sidebar-->
                            </div>
                            <!--end::Sidebar-->
                        </div>
                        <!--end::Layout-->
                        <!--end::General options-->
                        <div class="d-flex justify-content-start">
                            <!--begin::Button-->
                            <a href="{{ route('admin.invoice_sales') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-secondary me-5">Cancel</a>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Invoice 2 main-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            resetData();
            totalAmount();
            
            $('#triggerExportDetail').on('click', function() {
                let params = [];

                if ($('#inputId').val() != '') {
                    params.push('id=' + $('#inputId').val());
                }

                window.open("{{ route('admin.invoice_sales.exportDetail') }}" + "?" + params.join('&'),
                "_blank");
            });

            $(".input_datepicker_date").flatpickr({
                dateFormat: "d-m-Y",
            });

            // Initialize DataTables
            var item_variant_datatable = $('#item_variant_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip'
            });


            $('#triggerItemVariant').on('click', function() {
                $('#item_variant_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.sales.getDataItemVariant') }}',
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#item_variant_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="item_variant_id"><td><input type="checkbox" class="form-check-input item_variant_id_checkbox" name="item_variant_id_checkbox" id="item_variant_id' +
                                data[i].id + '" value="' + data[i]
                                .id +
                                '" /></td><td><label for="item_variant_id' +
                                data[i]
                                .id + '">' + data[i].nama_item +
                                '</label></td><td><label for="item_variant_id' +
                                data[i]
                                .id + '">' + data[i].nama_item_variant +
                                '</label></td><td><label for="item_variant_id' +
                                data[i]
                                .id + '">' + data[i].stock +
                                '</label></td></tr>'
                            )).draw(false);

                        });
                        table.draw(false);
                    }
                });
            });

            $('#selectData-item_variant').on('click', function() {
                $('#item_variant_datatable').find('input[type="checkbox"]:checked').each(function(i) {
                    var number = $('#bodyTableDataSales').find('tr').length;
                    var id = $(this).val();

                    $.ajax({
                        url: "{{ route('admin.sales.getDataItemVariant') }}",
                        data: {
                            id: id
                        },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(data) {
                            if ($('#row_detail_' + id).length == 0) {
                                $('#bodyTableDataSales').append(
                                    '<tr id="row_detail_' + id +
                                    '" class="row_detail" childidx="0">' +
                                    '<td class="no-item">' + (number + 1) +
                                    '</td>' +
                                    '<td class="img-item"><img width="50px" src="' +
                                    (data.data_file ? (
                                            `{{ asset('administrator/assets/media/products/') }}` +
                                            '/' + data.data_file) :
                                        "http://placehold.it/500x500?text=Not%20Found"
                                    ) + '" alt=""></td>' +
                                    '<td class="nama_item-item">' + data.nama_item +
                                    '</td>' +
                                    '<td class="nama_item_variant-item">' + data
                                    .nama_item_variant + '</td>' +
                                    '<td class="price-item text-end">' +
                                    formatRupiah(data
                                        .price) +
                                    '</td>' +
                                    '<td class="fv-row">' +
                                    '<input type="hidden" class="sales_detail_id-item" name="detail[' +
                                    number + '][sales_detail_id]" value="">' +
                                    '<input type="hidden" class="item_variant_id-item" name="detail[' +
                                    number + '][item_variant_id]" value="' + data
                                    .id + '">' +
                                    '<input type="text" class="form-control text-end quantity-item" name="detail[' +
                                    number + '][quantity]" autocomplete="off">' +
                                    '</td>' +
                                    '<td class="fv-row"><input type="text" name="detail[' +
                                    number +
                                    '][total]" class="form-control bg-secondary total-item text-end" value="Rp 0" readonly></td>' +
                                    '<td>' +
                                    '<a href="javascript:void(0)"' +
                                    'class="btn btn-sm btn-icon btn-light btn-active-light-primary triggerDeleteDetail"' +
                                    'data-id="' + id +
                                    '" data-sales_detail_id="" data-bs-toggle="tooltip" data-bs-placement="top">' +
                                    '<span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" /></svg></span>' +
                                    '</a>' +
                                    '</td>' +
                                    '</tr>'
                                );
                                resetData();
                                totalAmount();
                            }
                        }
                    });
                });

                $('#item_variant_modal').modal('hide');
            })

            var inputSalesNumber = document.getElementsByName("sales_number")[0];
            inputSalesNumber.classList.add("bg-secondary")

            $("#status_sales_number").val(false)

            $('#triggerStatusSalesNumber').off().on('click', function(e) {
                inputSalesNumber.readOnly = !inputSalesNumber.readOnly;
                if (inputSalesNumber.readOnly == false) {
                    inputSalesNumber.classList.remove("bg-secondary")
                } else {
                    inputSalesNumber.classList.add("bg-secondary")

                    let val_sales_number = '{{ $data->sales_number }}';
                    $('#sales_number').val(val_sales_number)
                    $("#status_sales_number").val(false)
                }

                var salesNumberHelp = document.getElementById("salesNumberHelp");
                salesNumberHelp.innerHTML = inputSalesNumber.readOnly ?
                    "Klik tombol 'Ubah' untuk mengisi manual!" :
                    "Klik tombol 'Ubah' untuk mengisi otomatis!";
            });

            function resetData() {
                var index = 0;
                $(".row_detail").each(function() {
                    var another = this;

                    search_index = $(this).attr("childidx");
                    $(this)
                        .find("input,select")
                        .each(function() {
                            this.name = this.name.replace(
                                "[" + search_index + "]",
                                "[" + index + "]"
                            );
                            $(another).attr("childidx", index);
                        });

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

                    $(this).find('.no-item').text((index + 1));

                    $(this).find('.quantity-item').on('keyup', function() {
                        this.value = this.value.replace(/[^0-9]/g, '');
                        let finish = $(this).val(formatNumber($(this).val()));

                        let price = parseRupiah($(another).find('.price-item').text());
                        console.log(price);
                        let parse = parseNumber($(this).val());
                        let quantity = parse;

                        let total = price * quantity;
                        $(another).find('.total-item').val(formatRupiah(total));
                    });

                    $(this).find('.withseparator').on({
                        keyup: function() {
                            formatCurrency($(this));
                        },
                        blur: function() {
                            formatCurrency($(this), "blur");
                        }
                    });

                    $('.triggerDeleteDetail').on('click', function(e) {
                        let id = $(this).data('id');
                        let sales_detail_id = $(this).data('sales-id');
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
                                if (sales_detail_id != '') {
                                    $.ajax({
                                        type: "DELETE",
                                        url: "{{ route('admin.sales.deleteDetail') }}",
                                        data: ({
                                            "_token": "{{ csrf_token() }}",
                                            "_method": 'DELETE',
                                            id: sales_detail_id,
                                        }),
                                        success: function(resp) {
                                            if (resp.success) {
                                                Swal.fire('Deleted!',
                                                    'Data has been deleted',
                                                    'success');
                                                $("#row_detail_" + id).remove();
                                                resetData();
                                                totalAmount();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "{{ route('admin.sales.updateTotalSalesAmount') }}",
                                                    data: ({
                                                        "_token": "{{ csrf_token() }}",
                                                        "_method": 'PUT',
                                                        id: sales_detail_id,
                                                        total_sales_amount: parseRupiah(
                                                            $(
                                                                '#total_sales_amount'
                                                            )
                                                            .text()
                                                        ),
                                                    }),
                                                });
                                            } else {
                                                Swal.fire('Failed!',
                                                    'Deleted data failed',
                                                    'error');
                                            }
                                        },
                                        error: function(resp) {
                                            Swal.fire("Error!",
                                                "Something went wrong.",
                                                "error");
                                        }
                                    });
                                } else {
                                    Swal.fire('Deleted!',
                                        'Data has been deleted',
                                        'success');
                                    $("#row_detail_" + id).remove();
                                    resetData();
                                    totalAmount();
                                }

                            }
                        });
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

                    validator.addField("detail[" + index + "][quantity]", {
                        validators: {
                            notEmpty: {
                                message: 'Quantity is required!'
                            }
                        }
                    });

                    index++;
                });

                var no = $('#bodyTableDataSales').find('tr').length;
                if (no == 0) {
                    no = '';
                }
                $('.jumlah_detail').val(no);
            }

            function formatRupiah(amount) {
                // Use Number.prototype.toLocaleString() to format the number as currency
                return 'Rp ' + Number(amount).toLocaleString('id-ID');
            }

            function parseRupiah(rupiahString) {
                // Remove currency symbol, separators, and parse as integer
                return parseInt(rupiahString.replace(/[^\d]/g, ''));
            }

            function formatNumber(number) {
                // Use Number.prototype.toLocaleString() to format the number as currency
                return Number(number).toLocaleString('id-ID');
            }

            function parseNumber(number) {
                // Remove currency symbol, separators, and parse as integer
                return parseInt(number.replace(/[^\d]/g, ''));
            }

            function totalAmount() {
                $(".row_detail").each(function() {
                    $(this)
                        .find(".quantity-item")
                        .on("keyup", function() {
                            totalAmount();
                        });
                });

                // Pembelian Dengan Permintaan
                total_nominal = 0;
                $(".row_detail").each(function() {
                    nominal = parseRupiah($(this).find(".total-item").val());
                    total_nominal += parseFloat(nominal ? nominal : 0);
                });

                $("#total_sales_amount").text(formatRupiah(total_nominal));
                $("#input_total_sales_amount").val(total_nominal);
            }


        });
    </script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
@endpush
