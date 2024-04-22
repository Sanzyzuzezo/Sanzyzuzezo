@extends('administrator.layouts.main')

@section('content')
    <style>
        /* * {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        outline: 1px solid lime;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        box-sizing: border-box;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } */

        .card-header {
            background-color: white;
            border-radius: 10px !important;
            background-image: url({{ asset_administrator('assets/media/dashboard/Vector.svg') }});
            background-repeat: no-repeat;
            background-size: 200px 300px;
            display: flex;
            padding: 5em 3em;
            box-shadow: 0px 8px 24px 0px rgba(149, 157, 165, 0.20);
        }

        .card-header .title {
            font-size: 3.5em;
            font-weight: 500;
        }

        .card-header .sub-title {
            color: gray;
        }

        .section-card-1 {
            display: flex;
            flex-direction: column
        }

        .sub-section-card {
            background-color: white;
            border-radius: 8px;
            padding: 1em;
            box-shadow: 0px 8px 24px 0px rgba(149, 157, 165, 0.20);
        }

        .section-card-2 {
            display: flex;
            flex-direction: column;
            background-color: white;
            border-radius: 8px;
            padding: 1em;
            background-repeat: no-repeat;
            background-position: right;
            background-image: url({{ asset_administrator('assets/media/dashboard/bg_item.svg') }});
            box-shadow: 0px 8px 24px 0px rgba(149, 157, 165, 0.20);
        }


        .section-card-2>*>.icon {
            display: inline-flex;
            padding: 0.5em;
            background-color: #EBEEFF;
            border-radius: 4px;

        }

        #pendapatan {
            background-color: white;
            padding: 2em 1em;
            background-image: url({{ asset_administrator('assets/media/dashboard/bg_pendapatan.svg') }});
            background-position: right;
            background-repeat: no-repeat;
        }

        #pendapatan>*>.icon {
            display: inline-flex;
            padding: 0.5em;
            background-color: #DFFFEE;
            border-radius: 4px;
        }

        #transaksi {
            background-color: white;
            padding: 2em 1em;
            background-image: url({{ asset_administrator('assets/media/dashboard/bg_transaksi.svg') }});
            background-position: right;
            background-repeat: no-repeat;
        }

        #transaksi>*>.icon {
            display: inline-flex;
            padding: 0.5em;
            background-color: #F6F1FF;
            border-radius: 4px;
        }

        .section-card-3 {
            width: 100%;
            display: flex;
            flex-direction: column;
            background-color: white;
            border-radius: 8px;
            padding: 1em;
            box-shadow: 0px 8px 24px 0px rgba(149, 157, 165, 0.20);
        }

        .section-card-3>*>.icon {
            display: inline-flex;
            padding: 0.5em;
            background-color: #EEF0FF;
            border-radius: 4px;

        }

        table.dataTable td {
            /* background-color: red; */
            padding: 0.5em !important;
        }

        .card-best-seller {
            width: 50.5%;
            background-color: white;
            padding: 1em;
            border-radius: 8px;
            box-shadow: 0px 8px 24px 0px rgba(149, 157, 165, 0.20);
        }

        .card-stock-minim {
            background-color: white;
            padding: 1em;
            width: 48%;
            border-radius: 8px;
            box-shadow: 0px 8px 24px 0px rgba(149, 157, 165, 0.20);
        }

        .item-stock-minim {
            z-index: 2 !important;
            background: #EEB400;
            display: flex;
            border-radius: 8px;
            border-bottom-right-radius: 0px;
            height: 18em;
            margin-top: 1em;
        }

        .item-stock-minim .img {
            background-color: white;
            display: flex;
            border-radius: 8px;
            justify-content: center;
            align-items: center;
            padding: 0.5em;
            margin: auto 0;
            margin-left: 1em;
        }

        .item-stock-minim .title {
            background-color: white;
            border-radius: 5px;
            font-weight: 600;
            padding: 0.5em;
            text-transform: uppercase;
        }

        .item-stock-minim .sub-title {
            color: white;
        }


        .item-stock-minim img {
            width: 10em;
            height: 10em;
            object-fit: contain;
        }

        .img-stock {
            position: absolute;
            width: 18em;
            height: 18em;
            bottom: 0%;
            /* margin-left: 15em; */
        }

        .badge-out-of-stock {
            padding: 0.2em 0.6em;
            display: flex;
            align-items: center;
            background-color: white;
            position: absolute;
            z-index: 10;
            border-radius: 8px;
            top: 0%;
            left: 1em;
            box-shadow: 0px 5px 15px 0px rgba(0, 0, 0, 0.20);
            /* width: 20em; */
        }

        .badge-out-of-stock img {
            width: 1em !important;
            height: 1em;
        }

        .owl-stage-outer {
            padding-top: 1em;
        }

        /*  */

        .best-seller {
            background-color: white;
            padding: 1em;
            border-radius: 8px;
            box-shadow: 0px 8px 24px 0px rgba(149, 157, 165, 0.20);
        }

        .best-seller {
            z-index: 2 !important;
            background: #47BE7D;
            display: flex;
            border-radius: 8px;
            height: 18em;
            width: 100%;
            margin-top: 1em;
        }

        .best-seller .img {
            background-color: white;
            display: flex;
            border-radius: 8px;
            justify-content: center;
            align-items: center;
            padding: 0.5em;
            margin: auto 0;
            margin-left: 1em;
        }

        .best-seller .title {
            background-color: white;
            border-radius: 5px;
            font-weight: 600;
            padding: 0.5em;
            text-transform: uppercase;
        }

        .best-seller .sub-title {
            color: white;
        }


        .best-seller img {
            width: 10em;
            height: 10em;
            object-fit: contain;
        }

        .img-stock {
            position: absolute;
            width: 18em;
            height: 18em;
            bottom: 0%;
            margin-left: 15.7em;
        }

        .badge-out-of-stock {
            padding: 0.2em 0.6em;
            display: flex;
            align-items: center;
            background-color: white;
            position: absolute;
            z-index: 10;
            border-radius: 8px;
            top: 0%;
            left: 1em;
            box-shadow: 0px 5px 15px 0px rgba(0, 0, 0, 0.20);
        }

        .badge-out-of-stock img {
            width: 2em !important;
            height: 2em;
            margin-right: 0.5em;
        }

        /* promo berakhir */
        .promo-berakhir {
            background-color: white;
            border-radius: 8px;
            padding: 1em;
            box-shadow: 0px 8px 24px 0px rgba(149, 157, 165, 0.20);

        }

        .promo-berakhir .head {
            padding: 1em 0em;
        }

        .promo-berakhir .head img {
            background-color: #FFF7DA;
            padding: 0.5em;
            border-radius: 4px;
        }

        .promo-berakhir .card {
            border-radius: 4px;
            border: 1px solid #F1BC00;
            background: #FFF;
            padding: 1.5em;
            margin-top: 1em;
        }

        .promo-berakhir .card .tipe-promo {
            border-radius: 2px;
            background: #F4F4F4;
            display: inline-flex;
            padding: 0.5em;
        }

        /* promo sekarang */
        .promo-berlangsung {
            background-color: white;
            border-radius: 8px;
            padding: 1em;
            box-shadow: 0px 8px 24px 0px rgba(149, 157, 165, 0.20);

        }

        .promo-berlangsung .head {
            padding: 1em 0em;
        }

        .img-promo-berlangsung {
            background-color: #E0FFEE;
            padding: 0.5em;
            border-radius: 4px;
        }

        .promo-berlangsung .card {
            border-radius: 4px;
            border: 1px solid #47BE7D;
            background: #FFF;
            padding: 1.5em;
            margin-top: 1em;
        }

        .promo-berlangsung .card .tipe-promo {
            border-radius: 2px;
            background: #F4F4F4;
            display: inline-flex;
            padding: 0.5em;
        }

        #myChart2 {
            width: 100%;
            height: 10vh;
        }
    </style>
    <div id="layoutSidenav_content">
        <div class="container">
            {{-- section header --}}
            <div class="card-header">
                <div class="align-self-center">
                    <div class="title">
                        Selamat Datang <span style="text-decoration: underline;"> {{ $user->name }}</span>
                        di dashboard kami 👋
                    </div>
                    <div class="sub-title">
                        Bersama-sama, mari kita jelajahi dan manfaatkan semua yang <br> telah kami siapkan untuk memenuhi
                        kebutuhan
                        Anda.
                    </div>
                </div>
                <div class="">
                    <img src="{{ asset_administrator('assets/media/dashboard/hero-icon.png') }}">
                </div>
            </div>
            {{-- section 1 Jumlah Pendapatan,Transaksi,Item Terjual,Report Tabel --}}
            <div class="d-flex my-5 py-5 gap-5">
                <div class="section-card-1 gap-5 col-3">
                    <div class="sub-section-card" id="pendapatan">
                        <div class="d-flex align-items-center">
                            <div class="icon">
                                <img src="{{ asset_administrator('assets/media/dashboard/icon_pendapatan.svg') }}"
                                    alt="">
                            </div>
                            <strong class="ms-2">
                                Jumlah Pendapatan <br>Hari ini
                            </strong>
                        </div>
                        <div style="margin-top:2em;">
                            @if ($totalOrders1->total == 0)
                                <div class="fs-2"> <strong> Rp. 0 </strong></div>
                            @else
                                <div class="fs-2"> <strong>
                                        {{ 'Rp.' . number_format($totalOrders1->total) . ',-' }} </strong></div>
                            @endif
                        </div>
                    </div>
                    <div class="sub-section-card" id="transaksi">
                        <div class="d-flex align-items-center">
                            <div class="icon">
                                <img src="{{ asset_administrator('assets/media/dashboard/icon_transaksi.svg') }}"
                                    alt="">
                            </div>
                            <strong class="ms-2">
                                Jumlah Transaksi <br> Hari ini
                            </strong>
                        </div>
                        <div style="margin-top:2em;">
                            @if ($totalOrders->id_count == 0)
                                <label class="small text-white">0</label>
                            @else
                                <p class="small text-white fw-bolder">
                                    {{ $totalOrders->id_count . ' Transaksi' }}
                                </p>
                            @endif
                            @if ($totalOrders->id_count == 0)
                                <div class="fs-2 d-flex"> <strong> 0 <span
                                            style="font-size: 0.7em; color:gray; align-items:center;">0 Transaksi</span>
                                    </strong>
                                </div>
                            @else
                                <div class="fs-2"> <strong
                                        style="font-size: 0.7em; font-weight:600; color:gray; align-items:center;">
                                        <span style="color: black;"> {{ $totalOrders->id_count . ' Transaksi' }} </span>
                                    </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="section-card-2 col-2">
                    <div class="d-flex align-items-center">
                        <div class="icon">
                            <img src="{{ asset_administrator('assets/media/dashboard/icon_item.svg') }}" alt="">
                        </div>
                        <strong class="ms-2">
                            Jumlah Item Terjual <br>Hari ini
                        </strong>

                    </div>
                    <div class="mt-auto">
                        @if ($totalOrdersItems->quantity == 0)
                            <div class="fs-2 d-flex"> <strong> 0 <span
                                        style="font-size: 0.7em; color:gray; align-items:center;">0 Item</span>
                                </strong>
                            </div>
                        @else
                            <div class="fs-2 d-flex"><span
                                    style="font-size: 0.7em; font-weight:500; color:gray; align-items:center;">
                                    {{ $totalOrdersItems->quantity . ' Items' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="section-card-3">
                    <div class="d-flex align-items-center">
                        <div class="icon">
                            <img src="{{ asset_administrator('assets/media/dashboard/icon_report.svg') }}" alt="">
                        </div>
                        <strong class="ms-2">
                            Report Pembelian Terbanyak
                        </strong>
                    </div>
                    <table class="table align-middle table-row-dashed fs-6 gy-5 " id="report_pembelian">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-20px mx-2">No</th>
                                <th class="min-w-100px">Nama Pelanggan</th>
                                <th class="min-w-100px">Jumlah Transaksi</th>
                                <th class="min-w-100px">Jumlah Nominal</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600 nowrap stripe">
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
            </div>
            {{-- Section 2 Promo Yang berlangsung dan promo yang akan berakhir --}}
            <div class="my-5 py-5 d-flex gap-5">
                <div class="col-6 card-stock-minim ">
                    <div class="owl-carousel" id="carousel-1">
                        @foreach ($notification as $notif)
                            <div class="mt-5">
                                <div class="badge-out-of-stock">
                                    <img src="{{ asset_administrator('assets/media/dashboard/icon_out_of_stock.svg') }}"
                                        alt="">
                                    <strong>Barang Segera Habis</strong>
                                </div>
                                <div class="item-stock-minim me-5">
                                    {{-- <img src="{{url('img_src($image->data_file, 'product')')}}" alt=""> --}}
                                    <div class="img">
                                        <img src="{{ img_src($notif->image, 'product') }}" alt="">
                                    </div>
                                    <div style="padding: 3.5em 1em;">
                                        <div class="title">{{ $notif->product_name }}</div>
                                        <div class="sub-title" style="margin-top: 1.5em;">{{ $notif->variant_name }}
                                        </div>
                                        <div class="sub-title">Stok Sekarang : {{ floatVal($notif->stock) }}</div>
                                    </div>
                                </div>
                                <img src="{{ asset_administrator('assets/media/dashboard/img_stock_habis.svg') }}"
                                    alt="" class="img-stock">
                            </div>
                        @endforeach
                        @if (count($notification) <= 0)
                            <div class="d-flex flex-stack py-0">
                                <div class="d-flex center">
                                    <div class="fw-bolder">Tidak Ada Product Dibawah Stok Minimal</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-6 card-best-seller">
                    <div class="owl-carousel" id="carousel-2">
                        @foreach ($hot as $item)
                            <div class="mt-5">
                                <div class="badge-out-of-stock">
                                    <img src="{{ asset_administrator('assets/media/dashboard/icon_best_seller.svg') }}"
                                        alt="">
                                    <strong>Barang Terlaris</strong>
                                </div>
                                <div class="best-seller me-5">
                                    {{-- <img src="{{url('img_src($image->data_file, 'product')')}}" alt=""> --}}
                                    <div class="img">
                                        <img src="{{ img_src($item->image, 'product') }}" alt="">
                                    </div>
                                    <div style="padding: 3.5em 1em;">
                                        <div class="title">{{ $item->product_name }}</div>
                                        <div class="sub-title" style="margin-top: 1.5em;">{{ $item->variant_name }}
                                        </div>
                                        <div class="sub-title">Stok Sekarang : {{ floatVal($item->stock) }}</div>
                                    </div>
                                </div>
                                <img src="{{ asset_administrator('assets/media/dashboard/img_best_seller.svg') }}"
                                    alt="" class="img-stock">
                            </div>
                        @endforeach
                        @if (count($hot) <= 0)
                            <div class="d-flex flex-stack py-0">
                                <div class="d-flex center">
                                    <div class="fw-bolder">Tidak Ada Product Dibawah Stok Minimal</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="my-5 py-5 d-flex gap-5">
                <div class="promo-berakhir col-6">
                    <div class="head">
                        <img src="{{ asset_administrator('assets/media/dashboard/icon_promo_akan_berakhir.svg') }}"
                            alt="" class="me-2">
                        <strong>
                            Promo Yang Akan Berakhir
                        </strong>
                    </div>
                    @foreach ($promotion as $promo)
                        <div class="card">
                            <div class="">
                                <div class="d-flex justify-content-between">
                                    <div class="tipe-promo"> <strong> Tipe Promo :
                                            {{ $promo->type == 'reguler' ? 'Reguler' : 'Flash Sale' }} </strong></div>
                                    <img src="{{ asset_administrator('assets/media/dashboard/icon_promo_akan_berakhir.svg') }}"
                                        alt="" style="border: 1px solid #E2E2E2; border-radius:4px;padding:5px;">
                                </div>
                                {{-- @dd($promo) --}}
                                <div class="my-3">
                                    <strong> {{ 'Judul Promo : ' . $promo->title }}</strong>
                                    <div class="">
                                        <p>{{ $promo->note }}</p>
                                        @php
                                            $targetDate = new DateTime('2023-11-30 12:00:00');
                                            $now = new DateTime();
                                            $diff = $now->diff($targetDate);
                                            echo 'Promo Berakhir Dalam ' . $diff->format('%d Hari, %h Jam');
                                        @endphp
                                        {{-- {{ floor($promo->end_date) - time() / (60 * 60 * 24) }} --}}
                                        {{-- {{ 'Tanggal Akhir Promo : ' . date('j F Y h:i A', strtotime($promo->end_date)) }} --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if (count($promotion) <= 0)
                        <div class="d-flex flex-stack py-0">
                            <div class="d-flex center">
                                <div class="fw-bolder">Tidak Ada Promo</div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="promo-berlangsung col-6">
                    <div class="head">
                        <img src="{{ asset_administrator('assets/media/dashboard/icon_promo_sekarang.svg') }}"
                            alt="" class="me-2">
                        <strong>
                            Promo Yang Akan Berakhir
                        </strong>
                    </div>
                    <div class="owl-carousel" id="carousel-3">
                        @foreach ($promotion1 as $promo)
                            <div class="card">
                                <div class="">
                                    <div class="d-flex justify-content-between">
                                        <div class="tipe-promo"> <strong> Tipe Promo :
                                                {{ $promo->type == 'reguler' ? 'Reguler' : 'Flash Sale' }} </strong></div>
                                        <img src="{{ asset_administrator('assets/media/dashboard/icon_promo_sekarang.svg') }}"
                                            alt=""
                                            style="border: 1px solid #E2E2E2; border-radius:4px;padding:5px; width:3em;">
                                    </div>
                                    {{-- @dd($promo) --}}
                                    <div class="my-3">
                                        <strong> {{ 'Judul Promo : ' . $promo->title }}</strong>
                                        <div class="">
                                            <p>{{ $promo->note ?? '' }}</p>
                                            @php
                                                $targetDate = new DateTime('2023-11-30 12:00:00');
                                                $now = new DateTime();
                                                $diff = $now->diff($targetDate);
                                                echo 'Promo Berakhir Dalam ' . $diff->format('%d Hari, %h Jam');
                                            @endphp
                                            {{-- {{ floor($promo->end_date) - time() / (60 * 60 * 24) }} --}}
                                            {{-- {{ 'Tanggal Akhir Promo : ' . date('j F Y h:i A', strtotime($promo->end_date)) }} --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if (count($promotion1) <= 0)
                            <div class="d-flex flex-stack py-0">
                                <div class="d-flex center">
                                    <div class="fw-bolder">Tidak Ada Promo</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- grafik --}}
            <div class="col-12 mx-0 px-0">
                <div class="card mb-4" id="chart-area">
                    <div class="d-flex p-5">
                        <img src="{{ asset_administrator('assets/media/dashboard/icon_grafik.svg') }}" alt=""
                            style="width:3em; background-color:#D7F1FF; border-radius:4px;padding:0.2em;">
                        <div class="ms-auto">
                            <div id="minggu" class="btn btn-sm bg-secondary">Minggu</div>
                            <div id="bulan" class="btn btn-sm bg-secondary">Bulan</div>
                            <div id="tahun" class="btn btn-sm bg-secondary">Tahun</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <label class="fs-6 text-gray-800" style="text-align: center; font-weight: bold;">Total
                            Pendapatan Perbulan</label>
                    </div>
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var array = []
        var total = []
        $(document).ready(function() {
            var data_store = $('#report_pembelian').DataTable({
                processing: true,
                serverSide: true,
                sort: false,
                paging: false,
                info: false,
                ajax: {
                    url: '{{ route('admin.dashboard.getReportBuying') }}',
                    dataType: "JSON",
                    type: "GET",
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'customer'
                    },
                    {
                        data: 'id_count'
                    },
                    {
                        data: 'total'
                    },
                    // {
                    //     "render": function(data, type, row) {
                    //         return row.status
                    //     }
                    // }
                ],
            });

            changeChart("bulan");
            // setChart(array, total);


            $('#minggu').on('click', function() {
                array = [];
                total = [];
                changeChart("minggu");
                setChart(array, total);
            })

            $('#bulan').on('click', function() {
                array = [];
                total = [];
                changeChart("bulan");
                setChart(array, total);
            })

            $('#tahun').on('click', function() {
                array = [];
                total = [];
                changeChart("tahun");
                setChart(array, total);
            })
            $("#carousel-1").owlCarousel({
                items: 3, // Number of items to show
                loop: true, // Infinite loop
                margin: 50, // Margin between items
                responsive: {
                    0: {
                        items: 1 // Number of items to show on smaller screens
                    },
                }
            });

            $("#carousel-2").owlCarousel({
                items: 1, // Number of items to show
                loop: false, // Infinite loop
                margin: 50, // Margin between items
                responsive: {
                    0: {
                        items: 1 // Number of items to show on smaller screens
                    },
                }
            });

            $("#carousel-3").owlCarousel({
                items: 1, // Number of items to show
                loop: false, // Infinite loop
                margin: 50, // Margin between items
                responsive: {
                    0: {
                        items: 1 // Number of items to show on smaller screens
                    },
                }
            });
        });


        function changeChart(filter) {
            $.ajax({
                url: "{{ route('admin.dashboard.getChartBuying') }}",
                method: 'GET',
                data: {
                    waktu: filter
                },
                success: function(response) {
                    $("#myChart2").remove();
                    $("#chart-area").append("<canvas id='myChart2'></canvas>")
                    response.data.map((item, index) => {
                        if (response.data.length > 30) {
                            array.push(item.date)
                        }
                        array.push(index + 1)
                        total.push(item.total ?? 0)
                    })
                    setChart(array, total)
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText);
                }
            });
        }



        function setChart(array, total) {
            const gradient = document.getElementById('myChart2').getContext('2d').createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(44, 76, 245, 1)');
            gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

            const data2 = {
                labels: array,
                datasets: [{
                    label: 'Total Pendapatan',
                    data: total,
                    backgroundColor: gradient, // Use the gradient here
                    borderColor: 'rgba(44, 76, 245, 1)',
                    borderWidth: 3,
                    fill: true
                }, {
                    barPercentage: 0.5,
                    barThickness: 6,
                    maxBarThickness: 8,
                    minBarLength: 2,
                }]
            };

            const config2 = {
                type: 'line',
                data: data2,
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
                            display: false
                        }
                    },
                    maintainAspectRatio: false,
                    responsive: false
                }
            };

            const ctx2 = document.getElementById('myChart2').getContext('2d');
            new Chart(ctx2, config2);
        }
    </script>
@endpush
