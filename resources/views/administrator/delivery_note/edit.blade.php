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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Delivery Note</h1>
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
                            <a href="{{ route('admin.delivery_note') }}" class="text-muted text-hover-primary">Delivery
                                Note</a>
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
                <!--begin::Form-->
                <form id="form" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.delivery_note.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="sales_number" id="inputSalesNumber"
                        value="{{ request()->input('sales_number') }}">
                    <input type="hidden" name="id" id="inputId" value="{{ $data->id }}">
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
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
                                                <input type="text" name="date"
                                                    class="form-control input_datepicker_date" placeholder="Date"
                                                    value="{{ date('d-m-Y', strtotime($data->date)) }}"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="text-muted fs-7">
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label required">Delivery Note Number</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="delivery_note_number"
                                                    placeholder="Nomor Surat Jalan" id="delivery_note_number"
                                                    class="form-control bg-secondary"
                                                    value="{{ $data->delivery_note_number }}" readonly />
                                                <input type="hidden" id="status_delivery_note_number"
                                                    name="status_delivery_note_number" value="false"
                                                    class="form-control bg-secondary" />
                                            </div>
                                            <div class="input-group-append col-auto">
                                                <button class="btn btn-outline-success" type="button"
                                                    id="triggerStatusDeliveryNoteNumber">Ubah</button>
                                            </div>
                                        </div>
                                        <div class="text-muted fs-7">
                                            <small class="form-text text-muted">Nomor surat jalan dapat diisi manual atau
                                                otomatis</small>
                                        </div>
                                        <div class="text-muted fs-7">
                                            <small id="DeliveryNoteNumberHelp" class="form-text text-muted">Klik tombol
                                                "Ubah"
                                                untuk mengisi manual!</small>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label required">License Plate</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="license_plate_number"
                                                    placeholder="License Plate Number" id="license_plate_number"
                                                    value="{{ $data->license_plate_number }}" class="form-control"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <label class="form-label">Weather</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="weather" placeholder="Weather" id="weather"
                                                    value="{{ $data->weather }}" class="form-control"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="form-label">Information</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea name="information" id="information" cols="30" rows="5" class="form-control"
                                                    autocomplete="off">{{ $data->information }}</textarea>
                                            </div>
                                        </div>
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">
                                        </div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="form-label required">Item Variants</label>
                                        <!--end::Label-->
                                        <div class="d-flex justify-content-end">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary"
                                                id="triggerItemVariant">
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
                                                    id="tableDataSales">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr
                                                            class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-20px">No</th>
                                                            <th class="min-w-100px">Warehouse</th>
                                                            <th class="min-w-100px">Image</th>
                                                            <th class="min-w-100px">Item Name</th>
                                                            <th class="min-w-100px">Item Variant Name</th>
                                                            <th class="min-w-50px">Stock</th>
                                                            <th class="min-w-50px">Quantity Sales</th>
                                                            <th class="min-w-50px">Quantity Remaining</th>
                                                            <th class="min-w-50px">Quantity</th>
                                                            <th class="min-w-40px">Action</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600" id="bodyTableDetail">
                                                        @if (!empty($data_detail))
                                                            @foreach ($data_detail as $key => $detail)
                                                                <tr id="row_detail_{{ $detail['item_variant_id'] }}"
                                                                    class="row_detail" childidx="{{ $key }}">
                                                                    <input type="hidden"
                                                                        class="delivery_note_detail_id-item"
                                                                        name="detail[{{ $key }}][delivery_note_detail_id]"
                                                                        value="{{ $detail['id'] }}">
                                                                    <td class="no-item">{{ $key + 1 }}</td>
                                                                    <td class="warehouse-item">
                                                                        {{ $detail['nama_warehouse'] }}
                                                                        <input type="hidden" class="warehouse_id-item"
                                                                            name="detail[{{ $key }}][warehouse_id]"
                                                                            value="{{ $detail['warehouse_id'] }}">
                                                                    </td>
                                                                    <td class="img-item">
                                                                        <img width="50px"
                                                                            src="{{ $detail->data_file ? asset('administrator/assets/media/products/') . '/' . $detail->data_file : 'http://placehold.it/500x500?text=Not%20Found' }}"
                                                                            alt="">
                                                                    </td>
                                                                    <td class="nama_item-item">{{ $detail['nama_item'] }}
                                                                    </td>
                                                                    <td class="nama_item_variant-item">
                                                                        {{ $detail['nama_item_variant'] }}
                                                                        <input type="hidden" class="item_variant_id-item"
                                                                            name="detail[{{ $key }}][item_variant_id]"
                                                                            value="{{ $detail['item_variant_id'] }}">
                                                                    </td>
                                                                    <td class="stock-item text-end">
                                                                        {{ floatVal($detail['stock']) }}
                                                                        <input type="hidden" class="stock_id-item"
                                                                            name="detail[{{ $key }}][stock_id]"
                                                                            value="{{ $detail['stock_id'] }}">
                                                                    </td>
                                                                    <td class="quantity_sales-item text-end">
                                                                        {{ floatVal($detail['quantity_sales']) }}</td>
                                                                    <td
                                                                        class="quantity_remaining-item quantity_remaining-item-{{ $detail['item_variant_id'] }} text-end">
                                                                    </td>
                                                                    <td class="quantity-item text-end fv-row">
                                                                        <input type="text"
                                                                            class="form-control qty-input quantity-item text-end"
                                                                            name="detail[{{ $key }}][quantity]"
                                                                            value="{{ floatVal($detail['quantity']) }}"
                                                                            autocomplete="off">
                                                                        <input type="hidden"
                                                                            class="form-control unit_id-item text-end"
                                                                            name="detail[{{$key}}][unit_id]"
                                                                            value="{{$detail['unit_id']}}">
                                                                    </td>
                                                                    <td>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-sm btn-icon btn-light btn-active-light-primary triggerDeleteDetail {{ $data_detail->count() === 1 ? 'data_disabled' : '' }}"
                                                                            data-id="{{ $detail['item_variant_id'] }}"
                                                                            data-delivery_note_detail_id="{{ $detail['id'] }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top">
                                                                            <span class="svg-icon svg-icon-2">
                                                                                <span class="svg-icon svg-icon-2"><svg
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        viewBox="0 0 24 24"
                                                                                        fill="none">
                                                                                        <path
                                                                                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                            fill="black" />
                                                                                        <path opacity="0.5"
                                                                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                            fill="black" />
                                                                                        <path opacity="0.5"
                                                                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                            fill="black" />
                                                                                    </svg></span>
                                                                            </span>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                        </div>
                                        <input type="hidden" class="jumlah_detail" name="jumlah_detail">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card header-->
                            </div>
                            <!--end::General options-->
                        </div>

                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.delivery_note') }}" id="triggerCancelForm"
                                class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="triggerSubmit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>

    <div class="modal fade" id="stock_item_variant_modal" tabindex="-1" aria-hidden="true">
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
                                    id="searchItemVariantDatatable" />
                            </div>
                            <table class="table align-middle table-row-dashed datatable fs-6 gy-5"
                                id="stock_item_variant_datatable">
                                <thead>
                                    <tr class="text-start text-gray-600 fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-100px">Warehouse</th>
                                        <th class="min-w-100px">Item Name</th>
                                        <th class="min-w-100px">Item Variant Name</th>
                                        <th class="min-w-50px">Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-400" id="item_variant_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end mb-5">
                        <button type="button" class="btn btn-primary" id="selectData-stock_item_variant">Select</button>
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
    <script type="text/javascript">
        // Define form element
        const form = document.getElementById("form");

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(form, {
            fields: {
                date: {
                    validators: {
                        notEmpty: {
                            message: "Date is required",
                        },
                    },
                },
                delivery_note_number: {
                    validators: {
                        notEmpty: {
                            message: "Delivery Note Number is required",
                        },
                        remote: {
                            message: 'Delivery Note Number is exist',
                            method: 'POST',
                            url: '{{ route('admin.delivery_note.isExistDeliveryNoteNumber') }}',
                            data: function() {
                                return {
                                    _token: '{{ csrf_token() }}',
                                    delivery_note_number: $('#delivery_note_number').val(),
                                    id: $('#inputId').val(),
                                }
                            },
                        },
                    },
                },
                license_plate_number: {
                    validators: {
                        notEmpty: {
                            message: "Licesnse Plate is required is required",
                        },
                    },
                },
                jumlah_detail: {
                    validators: {
                        notEmpty: {
                            message: "Detail is required is required",
                        },
                    },
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: "",
                }),
            },
        });

        // Submit button handler
        const submitButton = document.getElementById("triggerSubmit");
        submitButton.addEventListener("click", function(e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function(status) {
                    if (status == "Valid") {
                        let stat = true;

                        if (stat == true) {
                            // Show loading indication
                            submitButton.setAttribute("data-kt-indicator", "on");

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;

                            // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            setTimeout(function() {
                                // Remove loading indication
                                submitButton.removeAttribute("data-kt-indicator");

                                // Enable button
                                submitButton.disabled = false;

                                form.submit(); // Submit form
                            }, 2000);
                        } else {
                            return false;
                        }
                    }
                });
            }
        });

        $(document).ready(function() {
            resetData();
            $(".input_datepicker_date").flatpickr({
                dateFormat: "d-m-Y",
            });

            $('#bodyTableDetail').each(function() {
                let item_variant_id = $(this).find('.item_variant_id-item').val();
                let qty = $(this).find('.qty-input').val();
                $.ajax({
                    url: "{{ route('admin.delivery_note.sisaPengiriman') }}",
                    data: {
                        sales_number: "{{ request()->input('sales_number') }}",
                        item_variant_id: item_variant_id
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(response) {
                        let classqtyrmn =
                            '.quantity_remaining-item-' +
                            item_variant_id;
                        $(classqtyrmn).text((parseInt(response) + parseInt(qty)));
                    }
                });
            });

            // Initialize DataTables
            var stock_item_variant_datatable = $('#stock_item_variant_datatable').dataTable({
                ordering: false,
                searching: true,
                dom: 'lrtip'
            });


            $('#triggerItemVariant').on('click', function() {
                $('#stock_item_variant_modal').modal('show');

                $.ajax({
                    url: '{{ route('admin.delivery_note.getDataStock') }}',
                    data: {
                        sales_number: "{{ request()->input('sales_number') }}"
                    },
                    type: "get",
                    cache: false,
                    async: false,
                    success: function(data) {
                        var table = $('#stock_item_variant_datatable').DataTable();
                        table.clear();
                        table.rows().remove().draw();
                        $.each(data, function(i) {
                            table.row.add($(
                                '<tr class="stock_id"><td><input type="checkbox" class="form-check-input stock_id_checkbox" name="stock_id_checkbox" id="stock_id' +
                                data[i].stock_id + '" value="' + data[i]
                                .stock_id +
                                '" /></td><td><label for="stock_id' +
                                data[i]
                                .stock_id + '">' + data[i].nama_warehouse +
                                '</label></td><td><label for="stock_id' +
                                data[i]
                                .stock_id + '">' + data[i].nama_item +
                                '</label></td><td><label for="stock_id' +
                                data[i]
                                .stock_id + '">' + data[i].nama_item_variant +
                                '</label></td><td><label for="stock_id' +
                                data[i]
                                .stock_id + '">' + parseFloat(data[i].stock) +
                                '</label></td></tr>'
                            )).draw(false);

                        });
                        table.draw(false);
                    }
                });
            });

            $('#selectData-stock_item_variant').on('click', function() {
                $('#stock_item_variant_datatable').find('input[type="checkbox"]:checked').each(function(i) {
                    var number = $('#bodyTableDetail').find('tr').length;
                    var id = $(this).val();

                    $.ajax({
                        url: "{{ route('admin.delivery_note.getDataStock') }}",
                        data: {
                            sales_number: "{{ request()->input('sales_number') }}",
                            id: id
                        },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(data) {
                            console.log($('#row_detail_' + data.id).length);
                            if ($('#row_detail_' + data.id).length == 0) {
                                let img_url = data.data_file;
                                $('#bodyTableDetail').append(
                                    `<tr id="row_detail_${data.id}" class="row_detail" childidx="0">
        <input type="hidden" class="form-control delivery_note_detail_id-item text-end" name="detail[${number}][delivery_note_detail_id]" value="" autocomplete="off">
        <td class="no-item">${number + 1}</td>
        <td class="warehouse-item">
            ${data.nama_warehouse}
            <input type="hidden" class="warehouse_id-item" name="detail[${number}][warehouse_id]" value="${data.warehouse_id}">
        </td>
        <td class="img-item">
            <img width="50px" src="${img_url ? `{{ asset('administrator/assets/media/products/') }}/${img_url}` : 'http://placehold.it/500x500?text=Not%20Found'}" alt="">
        </td>
        <td class="nama_item-item">${data.nama_item}</td>
        <td class="nama_item_variant-item">
            ${data.nama_item_variant}
            <input type="hidden" class="item_variant_id-item" name="detail[${number}][item_variant_id]" value="${data.id}">
        </td>
        <td class="stock-item text-end">
            ${parseFloat(data.stock)}
            <input type="hidden" class="stock_id-item" name="detail[${number}][stock_id]" value="${data.stock_id}">
        </td>
        <td class="quantity_sales-item text-end">${parseFloat(data.quantity_sales)}</td>
        <td class="quantity_remaining-item quantity_remaining-item-${data.id} text-end"></td>
        <td class="quantity-item text-end fv-row">
            <input type="text" class="form-control quantity-item text-end" name="detail[${number}][quantity]" autocomplete="off">
            <input type="hidden" class="form-control unit_id-item text-end" name="detail[${number}][unit_id]" value="${data.unit_id}">
        </td>
        <td>
            <a href="javascript:void(0)" class="btn btn-sm btn-icon btn-light btn-active-light-primary triggerDeleteDetail" data-id="${data.id}" data-delivery_note_detail_id="" data-bs-toggle="tooltip" data-bs-placement="top">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                    </svg>
                </span>
            </a>
        </td>
    </tr>`
                                );

                                $.ajax({
                                    url: "{{ route('admin.delivery_note.sisaPengiriman') }}",
                                    data: {
                                        sales_number: "{{ request()->input('sales_number') }}",
                                        item_variant_id: data.id
                                    },
                                    type: "get",
                                    cache: false,
                                    async: false,
                                    success: function(response) {
                                        let classqtyrmn =
                                            '.quantity_remaining-item-' +
                                            data.id;
                                        $(classqtyrmn).text(response);
                                    }
                                });
                                resetData();
                            }
                        }
                    });
                });

                $('#stock_item_variant_modal').modal('hide');
            })

            $('#triggerStatusDeliveryNoteNumber').off().on('click', function(e) {
                var inputDeliveryNoteNumber = document.getElementsByName("delivery_note_number")[0];
                inputDeliveryNoteNumber.readOnly = !inputDeliveryNoteNumber.readOnly;
                if (inputDeliveryNoteNumber.readOnly == false) {
                    inputDeliveryNoteNumber.classList.remove("bg-secondary")
                } else {
                    inputDeliveryNoteNumber.classList.add("bg-secondary")

                    $('#delivery_note_number').val('{{ $data->delivery_note_number }}')

                    $("#status_delivery_note_number").val(false)
                }

                var DeliveryNoteNumberHelp = document.getElementById("DeliveryNoteNumberHelp");
                DeliveryNoteNumberHelp.innerHTML = inputDeliveryNoteNumber.readOnly ?
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

                    validator.addField("detail[" + index + "][quantity]", {
                        validators: {
                            notEmpty: {
                                message: 'Quantity is required!'
                            }
                        }
                    });

                    $(this).find('.quantity-item').on('keyup', function() {
                        if (this.value !== undefined) { // Check if the value is defined
                            this.value = this.value.replace(/[^0-9]/g, '');
                        }
                        let quantity = parseInt($(this).val());
                        let stock = parseInt($(another).find('.stock-item').text());
                        let quantity_sales = parseInt($(another).find('.quantity_sales-item')
                            .text());
                        let quantity_remaining = parseInt($(another).find(
                                '.quantity_remaining-item')
                            .text());
                        if (quantity > quantity_sales) {
                            $(this).val('');
                            Swal.fire('Failed!',
                                'Quantity is not greater than Quantity Sales',
                                'error');
                        } else if (quantity > quantity_remaining) {
                            $(this).val('');
                            Swal.fire('Failed!',
                                'Quantity is not greater than Quantity Remaining',
                                'error');
                        } else if (quantity > stock) {
                            $(this).val('');
                            Swal.fire('Failed!',
                                'Quantity is not greater than Stock',
                                'error');
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

                    $('.triggerDeleteDetail').on('click', function(e) {
                        let id = $(this).data('id');
                        let delivery_note_detail_id = $(this).data('delivery_note_detail_id');
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
                                if (delivery_note_detail_id != '') {
                                    $.ajax({
                                        type: "DELETE",
                                        url: "{{ route('admin.delivery_note.deleteDetail') }}",
                                        data: ({
                                            "_token": "{{ csrf_token() }}",
                                            "_method": 'DELETE',
                                            id: delivery_note_detail_id,
                                        }),
                                        success: function(response) {
                                            Swal.fire('Deleted!',
                                                response.message,
                                                response.status);
                                            $("#row_detail_" + id).remove();
                                            resetData();
                                        },
                                        error: function(response) {
                                            Swal.fire('Failed!',
                                                response.responseJSON
                                                .message,
                                                response.responseJSON.status
                                            );
                                        }
                                    });
                                } else {
                                    Swal.fire('Deleted!',
                                        'Data has been deleted',
                                        'success');
                                    $("#row_detail_" + id).remove();
                                    resetData();
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

                var no = $('#bodyTableDetail').find('tr').length;
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

        });
    </script>
    <script src="{{ asset_administrator('assets/plugins/custom/form-jasnyupload/fileinput.min.js') }}"></script>
@endpush
