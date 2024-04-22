@extends('frontpage-schoko.layouts.main')
@php $navbar = Layout::getLayout() @endphp

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
                list-style-image: url('{{ img_src($navbar['settings']['logo'], 'logo') }}');
                list-style-position: inside;
            }
        }

        table {
            table-layout: fixed !important;
        }

        .th-sku {
            width: 100px;
        }

        .th-product {
            width: 200px;
        }

        .th-qty {
            width: 60px;
        }

        .th-price {
            width: 80px;
        }

        .th-discount {
            width: 80px;
        }

        .th-total {
            width: 80px;
        }

        /* css - timeline */
        .tl-item .avatar {
            z-index: 2
        }

        .circle {
            border-radius: 500px
        }

        .timeline {
            position: relative;
            border-color: rgba(160, 175, 185, .15);
            padding: 0;
            margin: 0
        }

        .tl-item {
            border-radius: 3px;
            position: relative;
            display: -ms-flexbox;
            display: flex
        }

        .tl-item>* {
            padding: 10px
        }

        .tl-item .avatar {
            z-index: 2
        }

        .tl-item:last-child .tl-dot:after {
            display: none
        }

        .tl-item.active .tl-dot:before {
            border-color: #7f3c18;
        }

        .tl-item:last-child .tl-dot:after {
            display: none
        }

        .tl-item.active .tl-dot:before {
            border-color: #7f3c18;
        }

        .tl-dot {
            position: relative;
            border-color: rgba(160, 175, 185, .15)
        }

        .tl-dot:after,
        .tl-dot:before {
            content: '';
            position: absolute;
            border-color: inherit;
            border-width: 2px;
            border-style: solid;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            top: 15px;
            left: 50%;
            transform: translateX(-50%)
        }

        .tl-dot:after {
            width: 0;
            height: auto;
            top: 25px;
            bottom: -15px;
            border-right-width: 0;
            border-top-width: 0;
            border-bottom-width: 0;
            border-radius: 0
        }

        tl-item.active .tl-dot:before {
            border-color: #7f3c18;
            box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
        }

        .tl-dot {
            position: relative;
            border-color: rgba(160, 175, 185, .15)
        }

        .tl-dot:after,
        .tl-dot:before {
            content: '';
            position: absolute;
            border-color: inherit;
            border-width: 2px;
            border-style: solid;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            top: 15px;
            left: 50%;
            transform: translateX(-50%)
        }

        .tl-dot:after {
            width: 0;
            height: auto;
            top: 25px;
            bottom: -15px;
            border-right-width: 0;
            border-top-width: 0;
            border-bottom-width: 0;
            border-radius: 0
        }

        .tl-content p:last-child {
            margin-bottom: 0
        }

        .tl-date {
            font-size: .85em;
        }

        .avatar {
            position: relative;
            line-height: 1;
            border-radius: 500px;
            white-space: nowrap;
            font-weight: 700;
            border-radius: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            border-radius: 500px;
            box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15)
        }

        .b-brown {
            border-color: #7f3c18!important;
        }

        .status-tracking{
            font-weight: bold;
            text-transform: capitalize;
        }

        .modal-header{
            justify-content: space-between !important;
        }

        @media (min-width: 576px){
            .modal-dialog {
                max-width: 500px !important;
                margin: 28px auto;
            }
        }

        .img-invoice{
            width: 50px !important;
        }
        .noted-product{
            font-size: 10px !important;
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
                                <li class="ec-breadcrumb-item"><a
                                        href="{{ url('/') }}">{{ __('order_history.home') }}</a></li>
                                <li class="ec-breadcrumb-item active">Invoice</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <section class="ec-page-content ec-vendor-uploads ec-user-account">
        <div class="container">
            @include('frontpage-schoko.customers.sidebar')
        </div>
    </section>

    <!-- User invoice section -->
    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row">
                @if ($order_billing->status == 'unpaid' &&
                    $order->status == 'waiting_for_payment' &&
                    $order_billing->payment_method == 'manual_bank_transfer')
                    <div class="ec-shop-rightside col-lg-12 col-md-12">
                        <div class="alert alert-warning" role="alert">
                            {{ __('order_history.invalid_alert') }}
                        </div>
                    </div>
                @endif

                <div class="ec-shop-rightside col-lg-12 col-md-12">

                    <div class="ec-vendor-dashboard-card mb-10">
                        <div class="ec-vendor-card-header">
                            <h5>Invoice</h5>
                            <div class="ec-header-btn">
                                @if ($order->status == 'shipping')
                                    <a class="btn btn-lg btn-secondary" href="#" data-bs-toggle="modal" data-bs-target="#tracking_modal">{{ __('order_history.tracking') }}</a>
                                @endif
                                <a class="btn btn-lg btn-secondary printInvoice" href="#" onclick="printDiv('printarea')">{{ __('order_history.print') }}</a>

                                <?php
                                    if ($order->status == 'waiting_for_payment' && $order_billing->payment_method != 'manual_bank_transfer') {
                                        $billing = (array) json_decode($order_billing->data);
                                        if(isset($billing['snap_token'])){
                                ?>
                                    <input type="hidden" value="{{ $billing['snap_token'] }}" id="snap_token">
                                    <a class="btn btn-lg btn-primary" id="payment" href="#">{{ __('order_history.Payment') }}</a>
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="ec-vendor-card-body padding-b-0" id="printarea">
                            <div class="page-content">
                                <div class="page-header text-blue-d2 text-center">
                                    <span class="printThis"><strong>INVOICE</strong></span><br/>
                                    <img class="logo-print" src="{{ img_src($navbar['settings']['logo'], 'logo') }}" alt="Site Logo">
                                </div>

                                <div class="container px-0">
                                    <div class="row mt-4">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="my-2">
                                                        <span
                                                            class="text-sm text-grey-m2 align-middle">{{ __('order_history.To') }}
                                                            : </span>
                                                        <span
                                                            class="text-600 text-110 text-blue align-middle">{{ $order->customer_id != null ? $order->customer_name : $order->name }}</span>
                                                    </div>
                                                    <div class="text-grey-m2">
                                                        @if($order->customer_id != null)
                                                            <div class="my-2"><b class="text-600">{{ __('order_history.ReceivedName') }} :</b>
                                                                @php
                                                                    $address = json_decode($order_shipping->address);
                                                                    echo $address[0]->reveived_name;
                                                                @endphp
                                                            </div>
                                                        @endif
                                                        <div class="my-2"><b
                                                                class="text-600">{{ __('order_history.Phone') }} :
                                                            </b>{{ $order->customer_id != null ? $order->customer_phone : $order->phone }}
                                                        </div>
                                                        <div class="my-2"><b
                                                                class="text-600">{{ __('order_history.Payment') }}
                                                                :
                                                            </b>
                                                            <?php
                                                                if ($order_billing == true):
                                                                    $billing = (array) json_decode($order_billing->data);
                                                                    if ($order_billing->payment_method != 'manual_bank_transfer') {
                                                                        getPaymentDetail($billing);
                                                                    }
                                                                endif;
                                                            ?>
                                                        </div>

                                                        <div class="my-2"><span class="text-600 text-90">{{ __('order_history.Issue_Date') }} :
                                                        </span>
                                                            {{ date('d M Y - h:i:s', strtotime($order->transaction_date)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.col -->

                                                <div
                                                    class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                                    <hr class="d-sm-none" />
                                                    <div class="text-grey-m2">

                                                        <div class="my-2"><span class="text-600 text-90">{{ __('order_history.Invoice_Number') }} :
                                                            </span>#{{ $order->invoice_number }}</div>

                                                        <div class="my-2"><span class="text-600 text-90">{{ __('order_history.resi_number') }} :
                                                            </span>{{ $order_shipping->new_resi == null ? $order_shipping->resi : $order_shipping->new_resi }}</div>

                                                        <div class="my-2"><span class="text-600 text-90">Status : </span>
                                                            <span class="status-order">
                                                                @if ($order->status == 'processed')
                                                                    {{ __('order_history.Processed') }}
                                                                @elseif($order->status == 'waiting_for_confirmation')
                                                                    {{ __('order_history.Waiting_For_Confirmation') }}
                                                                @elseif($order->status == 'shipping')
                                                                    {{ __('order_history.Shipping') }}
                                                                @elseif($order->status == 'finished')
                                                                    {{ __('order_history.Finished') }}
                                                                @elseif($order->status == 'complain')
                                                                    {{ __('order_history.Complain') }}
                                                                @elseif($order->status == 'failed')
                                                                    Failed
                                                                @else
                                                                    {{ __('order_history.Waiting_For_Payment') }}
                                                                @endif
                                                            </span>
                                                        </div>

                                                        <div class="my-2"><span class="text-600 text-90">{{ __('order_history.Store') }} :
                                                            </span>
                                                            {{ $store_name }}
                                                        </div>

                                                        <div class="my-2"><b class="text-600">{{ __('order_history.Courier') }} :</b>
                                                            {{ $order_shipping->courier }}
                                                        </div>

                                                        <div class="my-2"><b class="text-600">{{ __('order_history.Address') }} :</b>
                                                            @php
                                                                $address = json_decode($order_shipping->address);
                                                                echo $address[0]->address . '<br>';
                                                                echo $address[0]->province . ' - ' . $address[0]->city . ' - ' . $address[0]->distric . ' - ' . $address[0]->postalcode;
                                                            @endphp
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>

                                            <div class="mt-4">

                                                <div class="text-95 text-secondary-d3">
                                                    <div class="ec-vendor-card-table overflow-visible">
                                                        <table>
                                                            <tbody>
                                                                @php
                                                                    $weight_total = 0;
                                                                    $qty = 0;
                                                                @endphp
                                                                @foreach ($order_items as $item)
                                                                    @php
                                                                        $weight_total += $item->weight;
                                                                        $qty += $item->quantity;

                                                                        $harga = $item->discount_product > 0 ? $item->discount_product : $item->price;
                                                                    @endphp
                                                                    <tr class="cart-list">
                                                                        <td data-label="Product" width="25%" class="align-top">
                                                                            <div class="pr-2">
                                                                                <img class="" src="{{ img_src($item->image, 'product') }}" alt=""/>
                                                                            </div>
                                                                        </td>
                                                                        <td data-label="Product" colspan="2">
                                                                            <div>
                                                                                <a href="#" class="text-dark fw-bolder text-hover-primary product-checkout">{{ $item->product_name }}</a>
                                                                            </div>
                                                                            <div>
                                                                                <small class="product-variant">{{ $item->variant_name }}</small>
                                                                            </div>
                                                                            <div class="row">
                                                                                @if ($item->discount_product > 0 )
                                                                                    <span class="old-price" id="old_price" style="text-decoration: line-through;">
                                                                                        Rp. {{ number_format($item->price, 0, '.', ',') }}
                                                                                    </span>
                                                                                @endif
                                                                                <div class="d-flex justify-content-between">
                                                                                    <div>
                                                                                        <span>Rp. {{ number_format($harga, 0, '.', ',') }}</span>
                                                                                        x {{ number_format($item->quantity, 0, '.', ',') }}
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="ec-cart-pro-subtotal text-end">
                                                                                            Rp. {{ number_format($harga * $item->quantity) }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @if($item->noted != '')
                                                                                <div class="noted-product">
                                                                                    Noted: <br/> {{ $item->noted }}
                                                                                </div>
                                                                            @endif
                                                                            <br/><br/>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                {{-- <tr>
                                                                    <td class="border-none">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color">
                                                                        <span><strong>Sub Total</strong></span>
                                                                    </td>
                                                                    <td class="border-color text-end">
                                                                        <span>Rp. {{ number_format($order->old_total, 0, '.', ',') }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border-none">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color">
                                                                        <span>
                                                                            <strong>{{ __('order_history.Discount') }}
                                                                            </strong>
                                                                        </span>
                                                                    </td>
                                                                    <td class="border-color text-end">
                                                                        <span>{{ number_format($order->old_total - $order->total, 0, '.', ',') }}</span>
                                                                    </td>
                                                                </tr> --}}
                                                                <tr>
                                                                    <td class="border-none">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color">
                                                                        <span><strong>Total</strong> <label style="font-size: 11px">({{ $qty }} Items)</label></span>
                                                                    </td>
                                                                    <td class="border-color text-end">
                                                                        <span>Rp. {{ number_format($order->total, 0, '.', ',') }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <?php $order_shipping == true ? ($cost = $order_shipping->cost) : ($cost = 0); ?>
                                                                    <td class="border-none">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color">
                                                                        <span><strong>{{ __('order_history.Shipping_Cost') }}</strong> <label style="font-size: 11px">({{ $weight_total != 0 ? number_format($weight_total).' gr' : '' }})</label></span>
                                                                    </td>
                                                                    <td class="border-color text-end">
                                                                        <span>Rp. {{ number_format($cost, 0, '.', ',') }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border-none">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color m-m15">
                                                                        <span><strong>Grand Total</strong></span>
                                                                    </td>
                                                                    <td class="border-color m-m15 text-end">
                                                                        <span>Rp. {{ number_format($order->total - ($order->total * $order->discount_order) / 100 - ($order->total * $order->discount_customer) / 100 + $cost, 0, '.', ',') }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border-none m-m15" colspan="3">
                                                                        {{ $order->note ? 'Noted:' : '' }}
                                                                        <span class="note-text-color">{{ $order->note }}</span>
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
                                                <label
                                                    class="form-label">{{ __('order_history.File_Attachment') }}</label><br>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="file" name="file_attachment" class="form-control"
                                                    placeholder="File attachment" value="" />

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
                        <div class="float-right">
                            <a class="btn btn-lg btn-secondary swal-order" href="#">{{ __('order_history.order_accepted') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- End User invoice section -->

    <div class="modal fade bs-example-modal-lg" id="tracking_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="ec-quick-title">{{ __('order_history.tracking') }}</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-pro-content">
                            <div id="resi-tracking"></div>
                            <div class="timeline py-3 block" id="trackings">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        $(document).ready(function() {
            let url = `{{ url('/') }}`;
            let resi = `{{ $order_shipping->new_resi == null ? $order_shipping->resi : $order_shipping->new_resi }}`;
            let courier = `{{ $order_shipping->courier }}`;
            let id = `{{ $order->id }}`;
            let invoice_number = `{{ $order->invoice_number }}`;
            $.ajax({
                method: "POST",
                url: url + "/trackings",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'resi': resi,
                    'courier': courier
                },
                success: function(response) {
                    const obj = JSON.parse(response);
                    const history = obj.history;
                    $("#resi-tracking").append('Resi: '+obj.waybill_id);
                    $.each(history, function(i, value) {
                        $("#trackings").append('<div class="tl-item"><div class="tl-dot b-brown"></div><div class="tl-content"><h6 class="status-tracking m-0">'+value.status.replace('_', ' ')+'</h6><div class="note-tracking">'+value.note+'</div><div class="tl-date text-muted date-tracking">'+value.updated_at+'</div></div></div>');
                    });
                }
            });

            $('.swal-order').on('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Your order has been received?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            url: url + "/order-received",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': id,
                                'invoice_number': invoice_number,
                            },
                            success: function(){
                                $('.swal-order').remove();
                                $('.status-order').text('{{ __('order_history.Finished') }}');
                                Swal.fire(
                                    'Thank You',
                                    'Order has been received!',
                                    'success'
                                )
                            },
                            error: function(){
                                Swal.fire(
                                    'Error',
                                    'Cannot accepted order!',
                                    'error'
                                )
                            }
                        });
                    }
                })
            });

            let token = $("#snap_token").val();

            $("#payment").off().click(function(e) {
                snap.pay(token, {
                    // Optional
                    onSuccess: function(result) {
                        // console.log(response);
                        location.href = result.finish_redirect_url;
                    },
                    // Optional
                    onPending: function(result) {
                        location.href = result.finish_redirect_url;
                    },
                    // Optional
                    onError: function(result) {
                        location.href = result.finish_redirect_url;
                    }
                });
            });
        });
    </script>
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
