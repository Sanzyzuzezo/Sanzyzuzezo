@extends('administrator.layouts.main')

@push('css')
    <style>
        .col-white {
            color: #fff !important;
        }
        .stat-1 {
            background-color: #008000 !important;
        }
        .stat-2 {
            background-color: #ff0000 !important;
        }
        .stat-3 {
            background-color: #0000ff !important;
        }
        .stat-4 {
            background-color: #333 !important;
        }
        .stat-99 {
            background-color: #ffa500 !important;
        }

        .fc-day-sat, .fc-day-sun {
            background-color: #ff0000 !important;
        }

        .card-label span {
            font-style: italic;
            font-weight: 700;
        }
        
        .fc-event-time {
            display: none;
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
                        <!--end::Item-->
                        <li class="text-muted text-hover-primary">Rekap Absensi Per Bulan Detail</li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">{{ $karyawan->name }}</li>
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
                        @php
                            $bulan = $data['bulan'];
                            $tahun = $data['tahun'];

                            $date = \Carbon\Carbon::parse($tahun.'-'.$bulan.'-'.'01')->format('F Y');
                        @endphp
                        <div class="card-title">
                            <h3 class="card-label">
                                Detail Data Absensi <span>{{ $date }}</span>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <input type="hidden" id="id_karyawan" value="{{ $karyawan->id }}">
                            <input type="hidden" id="filter_bulan" value="{{ $bulan }}">
                            <input type="hidden" id="filter_tahun" value="{{ $tahun }}">
                            <a href="#" class="btn btn-sm btn-light-success" id="exportRekapExcel">
                                <span class="svg-icon svg-icon-muted svg-icon-2"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                                </svg></span>
                            Export Excel
                            <a href="{{ route('admin.human_resource.rekap_absensi_per_bulan') }}" class="btn btn-sm btn-light-danger" >
                                <span class="svg-icon svg-icon-muted svg-icon-2">
                                    <svg height="512px" id="Layer_1"  version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon points="352,128.4 319.7,96 160,256 160,256 160,256 319.7,416 352,383.6 224.7,256 "/></svg>
                                </span>
                            Back
                        </a>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div id="kt_calendar"></div>
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
    <script>
        var events = '{!! $max_date !!}';

        const element = document.getElementById("kt_calendar");

        // var todayDate = moment().startOf("day");
        // var YM = todayDate.format("YYYY-MM");
        // var TODAY = todayDate.format("YYYY-MM-DD");
        var TODAY = events;

        var calendarEl = document.getElementById("kt_calendar");

        var calendar = new FullCalendar.Calendar(calendarEl, {
            // headerToolbar: {
            //     left: "",
            //     right: "prev,next today",
            //     center: "title",
            // },
            headerToolbar: false,
            weekends: true,
            editable: false,
            height: 800,
            contentHeight: 780,
            aspectRatio: 3,

            nowIndicator: true,
            now: TODAY + "T09:25:00", 

            events: @json($events),
            eventContent: function (info) {
                var element = $(info.el);

                if (info.event.extendedProps && info.event.extendedProps.description) {
                    if (element.hasClass("fc-day-grid-event")) {
                        element.data("content", info.event.extendedProps.description);
                        element.data("placement", "top");
                        KTApp.initPopover(element);
                    } else if (element.hasClass("fc-time-grid-event")) {
                        element.find(".fc-title").append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    } else if (element.find(".fc-list-item-title").lenght !== 0) {
                        element.find(".fc-list-item-title").append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    }
                }
            },
        });

        calendar.render();
    </script>
    <script>
        $("#exportRekapExcel").click(function (e) {
            e.preventDefault();

            var query = {
                bulan: $('#filter_bulan').val(),
                tahun: $('#filter_tahun').val(),
                id_karyawan: $('#id_karyawan').val()
            }

            var url = `{{ route("admin.human_resource.rekap_absensi_per_bulan.detail.export") }}`+ '?' + $.param(query)


            window.location = url;

        });
    </script>
@endpush
