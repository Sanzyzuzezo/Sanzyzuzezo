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
            <div class="card-header mb-5">
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
            {{-- section content --}}
            <div class="card-header">
                <div class="row">
                <div class="align-self-center col-sm-12">
                    <div class="title">
                        Atur User Admin General
                    </div>
                </div>
                <div class="col-sm-12">
                    <a href="{{ route('admin.user-admins') }}" class="btn btn-primary">
                        <span class="indicator-label">Settings</span>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection