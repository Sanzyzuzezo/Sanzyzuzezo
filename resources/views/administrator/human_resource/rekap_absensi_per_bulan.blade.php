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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Human Resource</h1>
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
                        <li class="text-muted text-hover-primary">Human Resource</li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Rekap Absensi Per Bulan</li>
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
                <!--begin::Products-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" id="searchdatatable"
                                    class="form-control form-control-sm form-control-solid w-250px ps-14"
                                    placeholder="Search" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            @php
                                $bulans = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                $month = \Carbon\Carbon::now()->format('m');
                            @endphp
                            <div class="w-100 mw-150px">
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" id="filter_bulan">
                                    <option value="{{ $month }}">Pilih Bulan</option>
                                    @foreach ($bulans as $i => $value)
                                        <option value="{{ $i+1 }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-100 mw-150px">
                                @php
                                    $year = \Carbon\Carbon::now()->format('Y');
                                    $sub_years = \Carbon\Carbon::now()->subYears(2)->format('Y');
                                @endphp
                                <select class="form-select btn-sm form-select-solid" data-control="select2"
                                    data-hide-search="true" id="filter_tahun">
                                    <option value="{{ $year }}">Pilih Tahun</option>
                                    @for ($sub_years; $sub_years <= $year; $sub_years++)
                                        <option value="{{ $sub_years }}">{{ $sub_years }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-sm btn-light-success" id="exportRekapExcel">
                                    <span class="svg-icon svg-icon-muted svg-icon-2"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                                    </svg></span>
                                Export Excel
                            </a>
                            </div>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="store_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-20px pe-2">No</th>
                                    <th class="min-w-100px">Nama</th>
                                    <th class="min-w-100px">Hadir</th>
                                    <th class="min-w-100px">Sakit</th>
                                    <th class="min-w-100px">Izin</th>
                                    <th class="min-w-100px">Alpha</th>
                                    <th class="min-w-100px">Detail</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Products-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>

@endsection

@push('scripts')
    <script src="{{ asset_administrator('assets/plugins/custom/jstree/jstree.bundle.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var data_store = $('#store_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.human_resource.rekap_absensi_per_bulan.get_data') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.search = $('#searchdatatable').val();
                        d.filter_bulan = $('#filter_bulan').val();
                        d.filter_tahun = $('#filter_tahun').val();
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'absen_hadir'
                    },
                    {
                        data: 'absen_sakit'
                    },
                    {
                        data: 'absen_izin'
                    },
                    {
                        data: 'absen_alpha'
                    },
                    {
                        data: 'action'
                    }
                ],
            });

            $('#searchdatatable').keyup(function() {
                data_store.search($(this).val()).draw();
            })

            $('#filter_bulan').change(function() {
                data_store.search($('#searchdatatable').val()).draw()
            })

            $('#filter_tahun').change(function() {
                data_store.search($('#searchdatatable').val()).draw()
            })

        });
    </script>
    <script>
        $("#exportRekapExcel").click(function (e) {
            e.preventDefault();

            var query = {
                search: $('#searchdatatable').val(),
                filter_bulan: $('#filter_bulan').val(),
                filter_tahun: $('#filter_tahun').val()
            }

            var url = `{{ route("admin.human_resource.rekap_absensi_per_bulan.export") }}`+ '?' + $.param(query)

            // console.log(url);

            window.location = url;

        });
    </script>

@endpush
