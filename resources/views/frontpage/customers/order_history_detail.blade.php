@extends('frontpage.layouts.main')
@section('title')
Invoice - {{ $order->invoice_number }}
@endsection
@push('style')
    <style>
        .error {
            color: red !important;
            font-weight: normal !important;
            font-style: italic !important;
            font-size: small !important;
            margin-bottom: 0px !important;
        }
    </style>
@endpush
@section('content')
    <style>
        .printThis {
            display: none;
        }

        @media print {
            .noPrint {
                display: none;
            }

            .printThis {
                display: inline-block;
            }

            .logo-print {
                width: 291px;
                height: 109px;
                display: list-item;
                list-style-image: url('{{ asset_frontpage('assets/images/logo/logo.png') }}');
                list-style-position: inside;
            }
        }

    </style>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ __('order_history.user_profile') }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">{{ __('order_history.home') }}</a></li>
                                <li class="ec-breadcrumb-item active">Invoice</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- User invoice section -->
    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row">
                @if ($order_billing->status == 'unpaid' && $order->status == 'waiting_for_payment' && $order_billing->payment_method == 'manual_bank_transfer')
                <div class="ec-shop-rightside col-lg-12 col-md-12">
                    <div class="alert alert-warning" role="alert">
                        {{ __('order_history.invalid_alert') }}
                    </div>
                </div>
                @endif
                @include('frontpage.customers.sidebar')

                <div class="ec-shop-rightside col-lg-9 col-md-12">

                    <div class="ec-vendor-dashboard-card mb-10">
                        <div class="ec-vendor-card-header">
                            <h5>Invoice</h5>
                            <div class="ec-header-btn">
                                <a class="btn btn-lg btn-secondary printInvoice" href="#"
                                    onclick="printDiv('printarea')">{{ __('order_history.print') }}</a>
                                {{-- <a class="btn btn-lg btn-primary" href="#">Export</a> --}}
                            </div>
                        </div>
                        <div class="ec-vendor-card-body padding-b-0" id="printarea">
                            <div class="page-content">
                                <div class="page-header text-blue-d2">
                                    <span class="printThis"><strong>INVOICE</strong></span>
                                    <img src="{{ asset_frontpage('assets/images/logo/logo.png') }}" alt="Site Logo">
                                </div>

                                <div class="container px-0">
                                    <div class="row mt-4">
                                        <div class="col-lg-12">
                                            <hr class="row brc-default-l1 mx-n1 mb-4" />
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="my-2">
                                                        <span class="text-sm text-grey-m2 align-middle">{{ __('order_history.To') }} : </span>
                                                        <span
                                                            class="text-600 text-110 text-blue align-middle">{{ $order->customer_id != null ? $order->customer_name : $order->name }}</span>
                                                    </div>
                                                    <div class="text-grey-m2">
                                                        <div class="my-2"><b class="text-600">{{ __('order_history.Phone') }} :
                                                            </b>{{ $order->customer_id != null ? $order->customer_phone : $order->phone }}
                                                        </div>
                                                        <div class="my-2"><b class="text-600">{{ __('order_history.Payment') }}
                                                                :
                                                            </b>
                                                            <?php
                                                            if ($order_billing == true):
                                                                $billing = (array) json_decode($order_billing->data);
                                                                if ($order_billing->payment_method == 'manual_bank_transfer') {
                                                                    echo '<br>Manual Bank Transfer<br>';
                                                                    echo strtoupper($billing['bank_name'] . ' - ' . $billing['account_number'] . ' an ' . $billing['account_owner']);
                                                                } else {
                                                                    if (array_key_exists('payment_type', $billing)) {
                                                                        echo '<br>' . ucwords(str_replace('_', ' ', $billing['payment_type'])) . ' (Virtual Acccount)<br>';
                                                                        if ($billing['payment_type'] == 'bank_transfer') {
                                                                            foreach ($billing['va_numbers'] as $row) {
                                                                                echo strtoupper($row->bank . ' - ' . $row->va_number);
                                                                            }
                                                                        } elseif ($billing['payment_type'] == 'cstore') {
                                                                            echo strtoupper($billing['store'] . ' - ' . $billing['payment_code']);
                                                                        }
                                                                    } else {
                                                                        echo 'Other';
                                                                    }
                                                                }
                                                            endif;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.col -->

                                                <div
                                                    class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                                    <hr class="d-sm-none" />
                                                    <div class="text-grey-m2">

                                                        <div class="my-2"><span class="text-600 text-90">Status : </span>
                                                            @if ($order->status == 'processed')
                                                                {{ __('order_history.Processed') }}
                                                                <div class="badge badge-light-primary">{{ __('order_history.Processed') }}</div>
                                                            @elseif($order->status == 'waiting_for_confirmation')
                                                                {{ __('order_history.Waiting_For_Confirmation') }}
                                                                <div class="badge badge-light-danger">{{ __('order_history.Waiting_For_Confirmation') }}</div>
                                                            @elseif($order->status == 'shipping')
                                                                {{ __('order_history.Shipping') }}
                                                                <div class="badge badge-light-info">{{ __('order_history.Shipping') }}</div>
                                                            @elseif($order->status == 'finished')
                                                                {{ __('order_history.Finished') }}
                                                                <div class="badge badge-light-success">{{ __('order_history.Finished') }}</div>
                                                            @elseif($order->status == 'complain')
                                                                {{ __('order_history.Complain') }}
                                                                <div class="badge badge-light-danger">{{ __('order_history.Complain') }}</div>
                                                            @else
                                                                {{ __('order_history.Waiting_For_Payment') }}
                                                                <div class="badge badge-light-warning">{{ __('order_history.Waiting For Payment') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="my-2"><span class="text-600 text-90">{{ __('order_history.Issue_Date') }} :
                                                        </span>
                                                            {{ date('d M Y - h:i:s', strtotime($order->transaction_date)) }}
                                                        </div>

                                                        <div class="my-2"><span class="text-600 text-90">{{ __('order_history.Store') }} :
                                                            </span>
                                                            {{ $store_name }}
                                                        </div>

                                                        <div class="my-2"><span class="text-600 text-90">{{ __('order_history.Invoice_Number') }} :
                                                            </span>#{{ $order->invoice_number }}</div>

                                                        <div class="my-2"><b class="text-600">{{ __('order_history.Courier') }} :</b>
                                                            {{ $order_shipping->courier }}
                                                        </div>

                                                        <div class="my-2"><b class="text-600">{{ __('order_history.ReceivedName') }} :</b>
                                                            @php
                                                                $address = json_decode($order_shipping->address);
                                                                echo $address[0]->reveived_name;
                                                            @endphp
                                                        </div>

                                                        <div class="my-2"><b class="text-600">{{ __('order_history.Address') }} :</b>
                                                            @php
                                                                $address = json_decode($order_shipping->address);
                                                                echo $address[0]->address."<br>";
                                                                echo $address[0]->province." - ".$address[0]->city." - ".$address[0]->distric." - ".$address[0]->postalcode;
                                                            @endphp
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>

                                            <div class="mt-4">

                                                <div class="text-95 text-secondary-d3">
                                                    <div class="ec-vendor-card-table">
                                                        <table class="table ec-table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{ __('order_history.SKU') }}</th>
                                                                    <th scope="col">{{ __('order_history.Product') }}</th>
                                                                    <th class="text-end" scope="col">{{ __('order_history.Qty') }}</th>
                                                                    <th class="text-end" scope="col">{{ __('order_history.Price') }}</th>
                                                                    <th class="text-end" scope="col">{{ __('order_history.Discount') }}</th>
                                                                    <!-- <th></th> -->
                                                                    <th class="text-end" scope="col">{{ __('order_history.Total') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($order_items as $item)
                                                                    @php
                                                                        $fix_customer_discount = 0;
                                                                        $harga_normal_diskon = 0;
                                                                        if (isset(auth()->user()->customer_group_id)) {
                                                                            $status_diskon_customer = false;
                                                                            $harga = $item->price;//Update Septi : 8 Juni 2022
                                                                            foreach ($discount_customer as $dc) {
                                                                                $discount_brand = json_decode($dc->discount);
                                                                                foreach ($discount_brand as $brand) {
                                                                                    if ($item->brand_id === $brand->id) {
                                                                                        $harga_normal = $item->price;
                                                                                        $harga_normal_diskon = $item->discount_price;
                                                                                        $potongan = ($item->price * $brand->discount) / 100;
                                                                                        $fix_customer_discount = $item->price - $potongan;
                                                                                        if ($fix_customer_discount < $item->discount_price) {
                                                                                            $status_diskon_customer = true;
                                                                                            $harga = $fix_customer_discount;
                                                                                        } else {
                                                                                            if ($item->discount_price > 0) {
                                                                                                $item->discount_price > 0 ? ($harga = $item->discount_price) : ($harga = $item->price);
                                                                                            } else {
                                                                                                $status_diskon_customer = true;
                                                                                                $harga = $fix_customer_discount;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }

                                                                            if ($status_diskon_customer == false) {
                                                                                if ($item->discount_price > 0) {
                                                                                    $item->discount_price > 0 ? ($harga = $item->discount_price) : ($harga = $item->price);
                                                                                }
                                                                            }

                                                                        } else {
                                                                            $item->discount_price > 0 ? ($harga = $item->discount_price) : ($harga = $item->price);
                                                                        }
                                                                        $harga = isset($harga) ? $harga : ($item->discount_price > 0 ? $item->discount_price : $item->price);
                                                                    @endphp
                                                                    <tr>
                                                                        <th>
                                                                            <span>{{ $item->sku }}</span>
                                                                        </th>
                                                                        <td>
                                                                            <span>

                                                                                <a href="#"
                                                                                    class="text-dark fw-bolder text-hover-primary fs-6">{{ $item->product_name }}</a><br>
                                                                                <small>Variant :
                                                                                    {{ $item->variant_name }}</small><br>
                                                                                <small>{{ __('order_history.Noted') }} :
                                                                                    {{ $item->noted }}</small><br>

                                                                            </span>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <span>{{ number_format($item->quantity, 0, '.', ',') }}</span>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <span>{{ number_format($item->price, 0, '.', ',') }}</span>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <span>{{ number_format($item->price - $harga, 0, '.', ',') }}</span>
                                                                            @if(($item->price - $harga) > 0 )
                                                                                @if($item->discount_price > 0)
                                                                                    <small class="badge bg-danger">Discount Product</small>
                                                                                @else
                                                                                    <small class="badge bg-danger">Discount Customer</small>
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <span>{{ number_format($harga * $item->quantity, 0, '.', ',') }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td class="border-none" colspan="4">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color" colspan="1">
                                                                        <span><strong>Sub Total</strong></span>
                                                                    </td>
                                                                    <td class="border-color text-end">
                                                                        <span>{{ number_format($order->total, 0, '.', ',') }}</span>
                                                                    </td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td class="border-none" colspan="4">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color" colspan="1">
                                                                        <span><strong>{{ __('order_history.Discount') }}
                                                                                ({{ $order->discount_order }}%)</strong></span>
                                                                    </td>
                                                                    <td class="border-color text-end">
                                                                        <span>{{ number_format(($order->total * $order->discount_order) / 100, 0, '.', ',') }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border-none" colspan="4">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color" colspan="1">
                                                                        <span><strong>{{ __('order_history.Discount') }} {{ __('order_history.Customer') }}
                                                                                ({{ $order->discount_customer }}%)</strong></span>
                                                                    </td>
                                                                    <td class="border-color text-end">
                                                                        <span>{{ number_format(($order->total * $order->discount_customer) / 100, 0, '.', ',') }}</span>
                                                                    </td>
                                                                </tr> --}}
                                                                <tr>
                                                                    <?php $order_shipping == true ? ($cost = $order_shipping->cost) : ($cost = 0); ?>
                                                                    <td class="border-none" colspan="4">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color" colspan="1">
                                                                        <span><strong>{{ __('order_history.Shipping_Cost') }}</strong></span>
                                                                    </td>
                                                                    <td class="border-color text-end">
                                                                        <span>{{ number_format($cost, 0, '.', ',') }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border-none m-m15" colspan="4"><b class="text-600">{{ __('order_history.Note') }} :</b><span
                                                                            class="note-text-color">{{ $order->note }}</span>
                                                                    </td>
                                                                    <td class="border-color m-m15" colspan="1">
                                                                        <span><b>Grand Total</b></span>
                                                                    </td>
                                                                    <td class="border-color m-m15 text-end">
                                                                        <span><b>{{ number_format($order->total -($order->total * $order->discount_order) / 100 -($order->total * $order->discount_customer) / 100 +$cost,0,'.',',') }}</b></span>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->status == 'waiting_for_payment' && $order_billing->payment_method == 'manual_bank_transfer')
                        <form id="form_add" class="form d-flex flex-column flex-lg-row"
                            action="{{ route('payment_confirmation') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <input type="hidden" name="id" class="form-control mb-2" placeholder="ID"
                                value="{{ $order->id }}" />
                            <!-- Begin Payment Confirm -->
                            <div class="ec-vendor-dashboard-card">
                                <div class="ec-vendor-card-header">
                                    <h5>{{ __('order_history.Payment_Confirmation') }}</h5>
                                    <div class="ec-header-btn">
                                    </div>
                                </div>
                                <div class="ec-vendor-card-body padding-b-0">
                                    <div class="page-content">
                                        <div class="container px-0">

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">{{ __('order_history.File_Attachment') }}</label><br>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="file" name="file_attachment" class="form-control"
                                                    placeholder="File attachment" value="" required/>

                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Button-->
                                            <button type="submit" id="" class="btn btn-primary mb-5">
                                                <span class="indicator-label">Save</span>
                                            </button>
                                            <!--end::Button-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Payment Confirm -->
                        </form>
                    @endif
                    @if ($order->status == 'shipping')
                    <h3>Informasi Pengiriman</h3>
                    <table class="table table-striped mt-3 table-manifest">
                        <thead>
                            <tr>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- End User invoice section -->
@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            $("#form_add").validate({
                messages: {
                    file_attachment: {
                        required: "Please upload file"
                    }
                }
            });
        });
    </script>
    @if ($order->status == 'shipping')
    <script>
        $(document).ready(function() {

            let url = `{{ url('/') }}`;
            let courier = `{{ $order_shipping->courier }}`
            let resi = `{{ $order_shipping->resi }}`
            $.ajax({
                method: "POST",
                url: url+"/get-waybill",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'courier': courier,
                    'waybill': resi
                },
                success: function (response) {
                    let waybill = (typeof response == "string") ? jQuery.parseJSON(response) : response;
                    let result = waybill.rajaongkir.result
                    let status = waybill.rajaongkir.status
                    let query = waybill.rajaongkir.query

                    let manifest = result.manifest
                    manifest.forEach(index => {
                        let district_option = `<tr>
                                                    <th scope="row">${index.manifest_description} dari ${index.city_name}</th>
                                                    <td>${index.manifest_date} - ${index.manifest_time}</td>
                                                </tr>`;
                        let manifest = $(".table-manifest tbody");
                        manifest.append(district_option);
                    });
                }
            });
        });
    </script>
    @endif
    <script type="text/javascript">

        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<html><head><title></title><style>.col-sm-6{-webkit-box-flex: 0;-ms-flex: 0 0 auto;flex: 0 0 auto;width: 50%;}.text-600 {font-weight: 700;} .page-header img {width: 130px;}</style></head><body>" +
                divElements + "</body></html>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;


        }
    </script>
@endpush
