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
                        <!--end::Item-->
                        <li class="text-muted text-hover-primary">Rekap Absensi Per Tahun Detail</li>

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
                        <div class="card-title">
                            <h3 class="card-label">
                                Detail Data Absensi Per Tahun
                            </h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        {{-- <table class="table align-middle table-row-dashed fs-6 gy-5" id="store_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-100px">Bulan</th>
                                    <th class="min-w-100px">Hadir</th>
                                    <th class="min-w-100px">Sakit</th>
                                    <th class="min-w-100px">Izin</th>
                                    <th class="min-w-100px">Alpha</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                                <tbody class="fw-bold text-gray-600">
                                    @foreach($events as $event)
                                        <tr>
                                            <td>{{ $event['start'] }}</td>
                                            <td>{{ $event['presence'] }}</td>
                                            <td>{{ $event['sick'] }}</td>
                                            <td>{{ $event['leave'] }}</td>
                                            <td>{{ $event['alpha'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </tbody>
                            <!--end::Table body-->
                        </table> --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4" style="width: auto; height: 540px; margin-left: 15px;">
                                    <canvas id="myChart" width="900" height="420"></canvas>
                                </div>
                            </div>
                        </div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var labels = [];
    var presenceData = [];
    var sickData = [];
    var leaveData = [];
    var alphaData = [];

    @foreach ($chartData as $data)
        labels.push({{ $data['start'] }});
        presenceData.push({{ $data['presence'] }});
        sickData.push({{ $data['sick'] }});
        leaveData.push({{ $data['leave'] }});
        alphaData.push({{ $data['alpha'] }});
    @endforeach

    const data = {
        labels: labels,
        datasets: [{
            label: 'Hadir',
            data: presenceData,
            backgroundColor: 'rgb(0, 148, 255)'
        }, {
            label: 'Sakit',
            data: sickData,
            backgroundColor: 'rgb(255, 255, 70)'
        }, {
            label: 'Izin',
            data: leaveData,
            backgroundColor: 'rgb(255, 184, 70)'
        }, {
            label: 'Alpha',
            data: alphaData,
            backgroundColor: 'rgb(242, 102, 92)'
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                x: {
                    grid: {
                        drawOnChartArea: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            maintainAspectRatio: false,
            responsive: false
        }
    };

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, config);
</script>

@endpush
