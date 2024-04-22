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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Purchase</h1>
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
                            <a href="{{ route('admin.buys') }}" class="text-muted text-hover-primary">Purchase</a>
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

                <form id="form" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.buys.validasi') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" name="id" id="inputId" class="form-control" placeholder="ID" value="{{ $detail->id }}" />
                    <input type="hidden" name="py_karyawan_id" class="form-control" placeholder="ID" value="{{ Auth::user()->py_karyawan_id; }}" />
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="card card-flush">
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                    <div class="card-toolbar ms-auto">
                                        @if (isAllowed('buys', 'export'))
                                        <a href="{{ route('admin.buys.export-excel-detail', $detail->id)}}" class="btn btn-sm btn-light-success mx-1" >
                                            <span class="svg-icon svg-icon-muted svg-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14V4H6V20H18V8H20V21C20 21.6 19.6 22 19 22Z" fill="black"/>
                                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"/>
                                                </svg>
                                            </span>
                                            Ekspor Excel
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-light-danger mx-1" id="triggerExportPdf">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14V4H6V20H18V8H20V21C20 21.6 19.6 22 19 22Z" fill="black" />
                                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                                </svg>
                                            </span>
                                            Export Pdf
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                        </div>

                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="fs-6">
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="fw-bold">Purchase Number</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-end">
                                                                <span>:</span>
                                                            </td>
                                                            <td>{{ $detail->nomor_pembelian }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fs-6">
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="fw-bold">Date</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-end">
                                                                <span>:</span>
                                                            </td>
                                                            <td>{{ date('d F Y', strtotime($detail->tanggal)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fs-6">
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="fw-bold">Warehouse</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-end">
                                                                <span>:</span>
                                                            </td>
                                                            <td>{{ $detail->warehouse }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fs-6">
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="fw-bold">Supplier</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-end">
                                                                <span>:</span>
                                                            </td>
                                                            <td>{{ $detail->supplier }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                        <div class="d-flex flex-column fv-row">
                                            <span class="fw-bold fs-6 mb-10">Detail Pembelian</span>
                                            <table class="table gy-3 fs-7" style="border: 1px solid;">
                                                <thead style="border: 1px solid; vertical-align: top;">
                                                    <!--begin::Table row-->
                                                    <tr class="fw-bolder bg-light">
                                                        <th class="text-end min-w-50px">Product</th>
                                                        <th class="text-end min-w-50px">Variant</th>
                                                        <th class="text-end min-w-50px">Item Price</th>
                                                        <th class="text-end min-w-50px">Quantity</th>
                                                        <th class="text-end min-w-50px">Unit</th>
                                                        <th class="text-end min-w-50px">Price</th>
                                                        <th class="p-2 text-end min-w-50px">Expired</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold">
                                                    <tbody style="border: 1px solid;">
                                                        @foreach ($items as $data)
                                                            <tr>
                                                                <td class="p-2 text-end">{{ $data['item_name'] }}</td>
                                                                <td class="p-2 text-end">{{ $data['item_variant_name'] }}</td>
                                                                <td class="p-2 text-end">{{ number_format($data['harga']) }}</td>
                                                                <td class="p-2 text-end">{{ number_format($data['jumlah']) }}</td>
                                                                <td class="p-2 text-end">{{ $data['unit'] }}</td>
                                                                <td class="p-2 text-end">{{ number_format($data['total']) }}</td>
                                                                <td class="p-2 text-end">{{ date('Y-F-d', strtotime($data['expired']))}}</td>
                                                            </tr>
                                                        @endforeach
                                                    <tr class="fw-bold fs-6 text-gray-700">
                                                        <th class="text-end" colspan="6">Total Price</th>
                                                        <th class="p-2 text-end">{{number_format($detail->total_keseluruhan) }}</th>
                                                    </tr>
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('admin.buys') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-secondary me-5">Cancel</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#triggerExportPdf').on('click', function() {
                let params = [];

                if ($('#inputId').val() != '') {
                    params.push('id=' + $('#inputId').val());
                }

                window.open("{{ route('admin.buys.exportPdf') }}" + "?" + params.join('&'), "_blank");
            });
        });
    </script>
@endpush
