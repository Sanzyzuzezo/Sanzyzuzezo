@extends('frontpage-schoko.layouts.main')
@push('style')
    <style>
        .addresses:hover {
            background-color: #d7d7d7;
            cursor: pointer;
        }

        .padd-form {
            padding: 0 !important;
        }

        .error {
            color: red !important;
            font-weight: normal !important;
            font-style: italic !important;
            font-size: small !important;
            margin-bottom: 0px !important;
        }
        .noted{
            width: 200px !important;
        }
        .th-product{
            width: 250px;
        }
        .product-checkout{
            font-size: 11pt;
        }
        .product-variant{
            font-size: 9pt;
        }
        .product-price{
            font-size: 10pt;
        }

        @media only screen and (max-width: 767px){
            .ec-cart-pro-name{
                display: block !important;
            }
            .ec-cart-pro-subtotal{
                float: right !important;
            }
            .ec-cart-pro-price{
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }
    </style>
@endpush
@section('content')
    <!-- <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Checkout</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a
                                        href="{{ route('home') }}">{{ __('checkout.Home') }}</a></li>
                                <li class="ec-breadcrumb-item active">Checkout</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    @if (!isset(auth()->user()->id))
        <section class="checkout_page ec-page-content">
            <div class="container">
                <div class="row">
                    <div class="ec-checkout-leftside col-lg-12 col-md-12 ">
                        <div class="ec-checkout-content">
                            <div class="ec-checkout-inner">
                                <div class="ec-checkout-wrap margin-bottom-30 padding-bottom-3">
                                    <div class="ec-checkout-block ec-check-bill">
                                        <div class="ec-bl-block-content">
                                            <h3 class="ec-checkout-title">{{ __('checkout.customer') }}</h3>
                                            <div class="ec-check-bill-form px-3">
                                                <span class="ec-new-option">
                                                    <span>
                                                        <input type="radio" onclick="register()" id="account1"
                                                            name="radio-group" checked>
                                                        <label
                                                            for="account1">{{ __('checkout.register_account') }}</label>
                                                    </span>
                                                    <span>
                                                        <input type="radio" onclick="guest()" id="account2"
                                                            name="radio-group">
                                                        <label for="account2">{{ __('checkout.guest_account') }}</label>
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="ec-check-bill-form px-3">
                                                <div id="register_form">
                                                    <span class="ec-bill-wrap padd-form ec-bill-half margin-bottom-30">
                                                        <a href="{{ route('login') }}"><button class="btn btn-primary mb-3">Login</button></a>
                                                    </span>
                                                    <!-- <form id="form_login" class="px-3">
                                                        @csrf
                                                        <span class="ec-bill-wrap padd-form mb-3">
                                                            <label>Email*</label>
                                                            <input type="text" class="mb-0 email_login" name="email"
                                                                placeholder="{{ __('checkout.please_enter') }} Email"
                                                                required />
                                                        </span><br /><br />
                                                        <span class="ec-bill-wrap padd-form mb-3">
                                                            <label>{{ __('checkout.password') }}*</label>
                                                            <input type="password" class="mb-0 password" name="password"
                                                                placeholder="{{ __('checkout.please_enter') }} {{ __('checkout.password') }}"
                                                                required />
                                                        </span><br /><br />
                                                        <span class="ec-bill-wrap padd-form ec-bill-half margin-bottom-30">
                                                            <button class="btn btn-primary mb-3" type="submit"
                                                                id="btnLogin">Login</button>
                                                        </span>
                                                    </form> -->
                                                </div>
                                                <div id="guest_form" class="active_address" style="display: none">
                                                    <form id="form">
                                                        @csrf
                                                        <div class="ec-checkout-block ec-check-bill px-3">
                                                            <div class="ec-bl-block-content">
                                                                <div class="ec-check-bill-form">
                                                                    <span class="ec-bill-wrap">
                                                                        <label>{{ __('checkout.name') }}*</label>
                                                                        <input type="text" name="customer_name"
                                                                            class="customer_name"
                                                                            placeholder="{{ __('checkout.please_enter') }} {{ __('checkout.name') }}"
                                                                            required />
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>Email*</label>
                                                                        <input type="text" name="customer_email"
                                                                            class="email"
                                                                            placeholder="{{ __('checkout.please_enter') }} Email" required/>
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>{{ __('checkout.phone_number') }}*</label>
                                                                        <input type="text" name="customer_phone_number" class="phonenumber" placeholder="{{ __('checkout.please_enter') }} {{ __('checkout.phone_number') }}" required />
                                                                    </span>
                                                                    <span class="ec-bill-wrap">
                                                                        <label>{{ __('checkout.address') }}*</label>
                                                                        <input type="text" name="customer_address" class="address" placeholder="{{ __('checkout.address') }}" required />
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>{{ __('checkout.province') }}*</label>
                                                                        <span class="ec-bl-select-inner">
                                                                            <select name="shipping_province" class="ec-bill-select province select-province shipping_province">
                                                                                <option value=""> {{ __('checkout.please_select') }} {{ __('checkout.province') }} </option>
                                                                                @foreach ($provinces as $row)
                                                                                    <option title="{{ $row->title }}" value="{{ $row->id }}"> {{ $row->title }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <input type="hidden" id="shipping_province_label" name="shipping_province_label">
                                                                        </span>
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>{{ __('checkout.city') }}*</label>
                                                                        <span class="ec-bl-select-inner">
                                                                            <select name="shipping_city" class="ec-bill-select city select-city shipping_city">
                                                                                <option value=""> {{ __('checkout.please_select') }} {{ __('checkout.city') }}</option>
                                                                            </select>
                                                                            <input type="hidden" id="shipping_city_label" name="shipping_city_label">
                                                                        </span>
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>{{ __('checkout.distric') }}*</label>
                                                                        <span class="ec-bl-select-inner">
                                                                            <select name="shipping_distric"
                                                                                class="ec-bill-select distric select-district shipping_distric">
                                                                                <option value=""> {{ __('checkout.please_select') }} {{ __('checkout.distric') }}</option>
                                                                            </select>
                                                                            <input type="hidden" id="shipping_distric_label" name="shipping_distric_label">
                                                                        </span>
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>{{ __('checkout.post_code') }}*</label><br>
                                                                        <div id="list-postal-code"></div>
                                                                        <br>
                                                                        <br>
                                                                        <input name="postalcode" type="text" readonly id="postalcode" class="postalcode"/>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <form id="form">
            @csrf
    @endif
    <section class="ec-page-content">
        <div class="container">
            <div class="row">
                @if (isset($cart_data))
                    @if (Cookie::get('shopping_order'))
                        @php $total="0" @endphp
                        <div class="ec-cart-leftside col-lg-12 col-md-12 mb-2">
                            <div class="ec-cart-content">
                                <div class="ec-cart-inner">
                                    <div class="container">
                                        <div class="row">
                                            <div class="table-content cart-table-content p-0 overflow-visible">
                                                <table>
                                                    <tbody>
                                                        <?php
                                                            $subtotal = 0;
                                                            $old_subtotal = 0;
                                                            $weight_total = 0;
                                                            $qty = 0;
                                                        ?>
                                                        @foreach ($cart_data as $key => $data)
                                                            @php $weight_total = $weight_total + $data->berat_produk @endphp
                                                            @php
                                                                $qty = $quantity[$data->variant_id]['quantity'];
                                                                $harga = $data->price;
                                                                $discount = '';
                                                                if($data->discount_price != null){
                                                                    $discount = $data->discount_price;
                                                                    $harga = $data->discount_price;
                                                                }
                                                                $subtotal += $harga * $qty;
                                                                $old_subtotal += $data->price * $qty;
                                                            @endphp
                                                            <tr class="cart-list">
                                                                <td data-label="Product">
                                                                    <div class="row">
                                                                        <div class="col-lg-3 col-4">
                                                                            <img class="" src="{{ img_src($data->image, 'product') }}" alt=""/>
                                                                        </div>
                                                                        <div class="col-lg-9 col-8">
                                                                            <div>
                                                                                <a href="#" class="text-dark fw-bolder text-hover-primary product-checkout">{{ $data['name'] }}</a>
                                                                            </div>
                                                                            <div>
                                                                                <small class="product-variant">{{ $data['variant'] }}</small>
                                                                            </div>
                                                                            <div class="row product-price">
                                                                                <div class="col-lg-6">
                                                                                    @if ($discount != '')
                                                                                        <span style="text-decoration: line-through;" class="amount">Rp. {{ number_format($data->price) }}</span><br/>
                                                                                    @endif
                                                                                    <span class="amount text-end">Rp. {{ number_format($harga) }}</span>
                                                                                    x {{ $qty }}
                                                                                </div>
                                                                                <div class="col-lg-6 ec-cart-pro-subtotal text-end">
                                                                                    Rp. {{ number_format($harga * $qty) }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" name="item[{{ $key }}][note]" class="form-control form-control-sm px-2 my-2" placeholder="Noted" value="" style="height: 20px !important">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="item[{{ $key }}][product_id]" class="product_id" value="{{ $data['id'] }}">
                                                                    <input type="hidden" name="item[{{ $key }}][variant_id]" class="variant_id" value="{{ $data['variant_id'] }}">
                                                                    <input type="hidden" name="item[{{ $key }}][quantity]" class="quantity" value="{{ $qty }}">
                                                                    <input type="hidden" name="item[{{ $key }}][price]" class="price" value="{{ $data->price }}">
                                                                    <input type="hidden" name="item[{{ $key }}][discount_price]" class="discount_price" value="{{ $discount }}">
                                                                    <input type="hidden" name="item[{{ $key }}][weight]" class="weight" value="{{ $data->weight }}">
                                                                    <input type="hidden" name="item[{{ $key }}][dimensions]" class="dimensions" value="{{ $data->dimensions }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <input type="hidden" id="weight_total" class="weight_total"
                                                            value="{{ $weight_total }}">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (isset(auth()->user()->id))
                            <div class="ec-cart-leftside col-lg-12 col-md-12 my-2">
                                <div class="ec-sidebar-wrap">
                                    <div class="ec-sidebar-block">
                                        <div class="ec-checkout-wrap margin-bottom-30 padding-bottom-3">
                                            <div class="ec-checkout-block ec-check-bill">
                                                <h3 class="ec-checkout-title">{{ __('checkout.billing_details') }}</h3>
                                                <div class="ec-bl-block-content">
                                                    <span class="ec-bill-option">
                                                        <span>
                                                            <input type="radio" id="exiting-address"
                                                                onclick="showExitingAddress()" name="radio-group" checked>
                                                            <label
                                                                for="exiting-address">{{ __('checkout.existing_address') }}</label>
                                                        </span>
                                                        <span>
                                                            <input type="radio" id="new-address" onclick="showNewAddress()"
                                                                name="radio-group">
                                                            <label
                                                                for="new-address">{{ __('checkout.new_address') }}</label>
                                                        </span>
                                                    </span>
                                                    <div class="shipping-address-customer">
                                                        <div class="ec-check-bill-form exiting-address exiting-address-list"
                                                            style="padding: 0 15px;">
                                                            @if (count($addresses) > 0)
                                                                @foreach ($addresses as $addres)
                                                                    <div data-shipping_province="{{ $addres->province_id }}"
                                                                        data-shipping_city="{{ $addres->city_id }}"
                                                                        data-shipping_distric="{{ $addres->id_kecamatan }}"
                                                                        data-addres_id="{{ $addres->id }}"
                                                                        class="card mt-4 addresses {{ $addres->active == 1 ? 'active_address' : '' }}"
                                                                        style="width: 100%; {{ $addres->active == 1 ? 'background-color: #F7F7F7' : '' }}">
                                                                        <div class="card-body">
                                                                            <div class="card-title d-flex">
                                                                                @if ($addres->active == 1)
                                                                                    <h5
                                                                                        style="margin-right: 10px; color: green;">
                                                                                        <i class="ecicon eci-check"
                                                                                            aria-hidden="true"></i></h5>
                                                                                @endif
                                                                                <h5>Nama Penerima :
                                                                                    {{ $addres->received_name }}</h5>
                                                                            </div>
                                                                            <hr style="background-color: #2f4f4f;">
                                                                            <p class="card-text">
                                                                                {{ $addres->detail_address }}</p>
                                                                            <p class="card-text">Kecamatan
                                                                                {{ $addres->nama_kecamatan }}
                                                                                {{ $addres->type_kota }}
                                                                                {{ $addres->nama_kota }},
                                                                                {{ $addres->nama_provinsi }}</p>
                                                                            @if ($addres->active == 1)
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->id_kecamatan }}"
                                                                                    class="existingaddress shipping_distric"
                                                                                    name="shipping_distric">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->nama_kecamatan }}"
                                                                                    class="existingaddress shipping_distric_label"
                                                                                    name="shipping_distric_label">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->city_id }}"
                                                                                    class="existingaddress shipping_city"
                                                                                    name="shipping_city">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->type_kota.' '.$addres->nama_kota }}"
                                                                                    class="existingaddress shipping_city_label"
                                                                                    name="shipping_city_label">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->province_id }}"
                                                                                    class="existingaddress shipping_province"
                                                                                    name="shipping_province">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->nama_provinsi }}"
                                                                                    class="existingaddress shipping_province_label"
                                                                                    name="shipping_province_label">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->id }}"
                                                                                    class="existingaddress addres_id"
                                                                                    name="addres_id">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->detail_address }}"
                                                                                    class="existingaddress customer_address"
                                                                                    name="customer_address">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->received_name }}"
                                                                                    class="existingaddress customer_name"
                                                                                    name="customer_name">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->postal_code }}"
                                                                                    class="existingaddress shipping_postal_code_label"
                                                                                    name="postalcode">
                                                                                <input type="hidden"
                                                                                    value="{{ $addres->phone }}"
                                                                                    name="customer_phone_number">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="customer_email"
                                                                        value="{{ $addres->email_customer }}" />
                                                                @endforeach
                                                            @else
                                                                <div class="alert alert-warning" role="alert">
                                                                    {{ __('checkout.note_address') }} <a
                                                                        href="{{ route('create-address') }}">{{ __('checkout.fill_in_address') }}!</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="ec-cart-leftside col-lg-12 col-md-12 my-2">
                            <div class="ec-sidebar-wrap">
                                <div class="ec-sidebar-block">
                                    <div class="ec-checkout-wrap margin-bottom-30">
                                        <div class="ec-checkout-block ec-check-bill">
                                            <h3 class="ec-checkout-title">Checkout</h3>
                                            <div class="ec-bl-block-content">
                                                <div class="ec-check-bill-form">
                                                    <span class="ec-bill-wrap">
                                                        <label>{{ __('checkout.store') }} *</label>
                                                        <span class="ec-bl-select-inner">
                                                            <select name="origins" class="ec-bill-select select-origins">
                                                                {{-- @foreach ($origins as $origin)
                                                                    <option value="{{ $origin->id }}"
                                                                        data-province_id="{{ $origin->province_id }}"
                                                                        data-city_id="{{ $origin->city_id }}"
                                                                        data-subdistrict_id="{{ $origin->subdistrict_id }}"
                                                                        data-name="{{ $origin->name }}">
                                                                        {{ $origin->name }}
                                                                    </option>
                                                                @endforeach --}}
                                                            </select>
                                                            <input type="hidden" id="store_id" name="store_id">
                                                            <input type="hidden" id="store_name" name="store_name">
                                                            <input type="hidden" id="origin_name" name="origin[name]">
                                                            <input type="hidden" id="origin_coordinate" name="origin[coordinate]">
                                                            <input type="hidden" id="origin_postal_code" name="origin[postal_code]">
                                                            <input type="hidden" id="origin_address" name="origin[address]">
                                                            <input type="hidden" id="origin_contact_phone" name="origin[contact_phone]">
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="ec-check-bill-form">
                                                    <span class="ec-bill-wrap">
                                                        <label>{{ __('checkout.noted') }}</label>
                                                        <input type="text" class="order_noted" name="order_noted" />
                                                    </span>
                                                    <span class="ec-bill-wrap ec-bill-half">
                                                        <label>{{ __('checkout.courier') }} *</label>
                                                        <span class="ec-bl-select-inner">
                                                            <select name="shipping_courier" class="ec-bill-select courier">
                                                                <option value=""> Pilih Kurir</option>

                                                            </select>
                                                        </span>
                                                    </span>
                                                    <input type="hidden" name="shipping_service" class="courier-service">
                                                    {{-- <span class="ec-bill-wrap ec-bill-half">
                                                        <label>{{ __('checkout.service') }} *</label>
                                                        <span class="ec-bl-select-inner">
                                                            <select name="shipping_service" class="ec-bill-select service">

                                                            </select>
                                                        </span>
                                                    </span> --}}
                                                    {{-- <span class="ec-bill-wrap">
                                                        <label>{{ __('checkout.payment') }} *</label><br>
                                                        <span class="ec-new-option">
                                                            <span>
                                                                <input class="payment_method" type="radio" name="payment_method" value="manual_bank_transfer" id="manual_bank_transfer" checked>
                                                                <label for="manual_bank_transfer">{{ __('checkout.manual_bank_transfer') }}</label>
                                                            </span>
                                                            <span>
                                                                <input class="payment_method" type="radio" name="payment_method" value="other" id="other" checked>
                                                                <label for="other">{{ __('checkout.others') }}</label>
                                                            </span>
                                                        </span>
                                                    </span>
                                                    <br><br>
                                                    <span class="ec-bill-wrap bank_account-select">
                                                        <label>{{ __('checkout.bank_account') }} *</label>
                                                        <span class="ec-bl-select-inner">
                                                            <select name="bank_account"
                                                                class="ec-bill-select bank_account">
                                                                @foreach ($bank_accounts as $row)
                                                                    <option value="{{ $row->id }}">
                                                                        {{ $row->bank_name . ' - ' . $row->account_number . ' an ' . $row->account_owner }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </span>
                                                    </span> --}}
                                                    <input class="payment_method" type="radio" name="payment_method" value="other" id="other" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ec-cart-rightside col-lg-12 col-md-12 my-2">
                            <div class="ec-sidebar-wrap">
                                <div class="ec-sidebar-block">
                                    <div class="ec-sb-title">
                                        <h3 class="ec-sidebar-title">{{ __('checkout.summary') }}</h3>
                                    </div>
                                    <div class="ec-sb-block-content">
                                        <div class="ec-cart-summary-bottom">
                                            <div class="ec-cart-summary">
                                                <div>
                                                    <span class="text-left">Sub-Total</span>
                                                    <span class="text-right">Rp.
                                                        <?= number_format($old_subtotal) ?></span>
                                                    <input type="hidden" name="old_subtotal" class="SUBtotal"
                                                        value="{{ $old_subtotal }}">
                                                </div>
                                                <div class="text-red">
                                                    <span class="text-left">Diskon</span>
                                                    <span class="text-right">Rp.
                                                        <?= number_format($old_subtotal - $subtotal) ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-left">Total <label style="font-size: 11px">({{ $qty }} Items)</label></span>
                                                    <span class="text-right">Rp. <?= number_format($subtotal) ?></span>
                                                    <input type="hidden" name="order_total" class="total"
                                                        value="{{ $subtotal }}">
                                                </div>
                                                <div>
                                                    <span class="text-left">{{ __('checkout.delivery_charges') }} <label style="font-size: 11px">({{number_format($weight_total)}} gr)</label></span>
                                                    <span class="text-right shipping_cost_text">Rp. 0</span>
                                                    <input type="hidden" name="shipping_cost" class="shipping_cost" value="0">
                                                    <input type="hidden" name="shipping_waybill" class="shipping_waybill" value="0">
                                                </div>
                                                <div class="ec-cart-summary-total">
                                                    <span class="text-left">{{ __('checkout.total_amount') }}</span>
                                                    <span class="text-right total_amount">Rp.
                                                        <?= number_format($subtotal) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ec-cart-leftside col-lg-12 col-md-12 my-2 text-center">
                            <input type="hidden" id="cust_id" value="{{ isset(auth()->user()->id) ? auth()->user()->id : '' }}">
                            <input type="hidden" id="snap_token" value="">
                            <button class="btn btn-primary col-lg-4 col-6" id="order" type="submit">{{ __('checkout.payment') }}</button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </section>
    </form>
    @php $setting = Layout::getLayout() @endphp
    @php $origins = ''; @endphp
    <div class="address-hide" style="display: none;">
        <div class="ec-check-bill-form new-address">
            <span class="ec-bill-wrap ec-bill-half">
                <label>{{ __('checkout.recipient_name') }}*</label>
                <input type="text" class="customer_name" name="customer_name"
                    placeholder="{{ __('checkout.please_enter') }} {{ __('checkout.recipient_name') }}" required />
            </span>
            <span class="ec-bill-wrap ec-bill-half">
                <label>{{ __('checkout.province') }}*</label>
                <span class="ec-bl-select-inner">
                    <select name="shipping_province" class="ec-bill-select province select-province">
                        <option value="">{{ __('checkout.please_select') }} {{ __('checkout.province') }}</option>
                        @foreach ($provinces as $row)
                            <option value="{{ $row->id }}">{{ $row->title }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" class="shipping_province" id="shipping_province_label"
                        name="shipping_province_label">
                </span>
            </span>
            <span class="ec-bill-wrap ec-bill-half">
                <label>{{ __('checkout.city') }}*</label>
                <span class="ec-bl-select-inner">
                    <select name="shipping_city" class="ec-bill-select city select-city shipping_city">
                        <option value="">{{ __('checkout.please_select') }} {{ __('checkout.city') }}</option>
                    </select>
                    <input type="hidden" id="shipping_city_label" name="shipping_city_label">
                </span>
            </span>
            <span class="ec-bill-wrap ec-bill-half">
                <label>{{ __('checkout.distric') }}*</label>
                <span class="ec-bl-select-inner">
                    <select name="shipping_distric" class="ec-bill-select distric select-district shipping_distric">
                        <option value="">{{ __('checkout.please_select') }} {{ __('checkout.distric') }}</option>
                    </select>
                    <input type="hidden" id="shipping_distric_label" name="shipping_distric_label">
                </span>
            </span>
            <span class="ec-bill-wrap ec-bill-half">
                <label>{{ __('checkout.post_code') }}</label>
                <div id="list-postal-code"></div>
                <br>
                <br>
                <input type="text" class="postalcode" name="postalcode" id="postalcode" readonly placeholder="{{ __('checkout.post_code') }}" />
            </span>
            <span class="ec-bill-wrap">
                <label>{{ __('checkout.full_address') }}*</label>
                <input type="text" name="customer_address" placeholder="{{ __('checkout.full_address') }}" />
            </span>
            <span class="ec-bill-wrap">
                <label>{{ __('checkout.no_telepon') }}*</label>
                <input type="text" name="no_telepon" placeholder="{{ __('checkout.no_telepon') }}" />
            </span>
            <span class="ec-bill-wrap">
                <label>{{ __('checkout.email') }}*</label>
                <input type="text" name="customer_address_email" placeholder="{{ __('checkout.email') }}" />
            </span>
        </div>
    </div>
    @php
    $settings = Layout::getLayout();
    $min_purchase = $settings['settings']['min_purchase'];
    $internal_courier_price = $settings['settings']['internal_courier_price'];
    @endphp
@endsection
@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script>

        const showAlaret = (params) => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: params.icon,
                title: params.title
            });
        }

        const showAlert = (params) => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                didClose: (toast) => {
                    return window.location.href = '{{ url("/") }}';
                },
            })

            Toast.fire({
                icon: params.icon,
                title: params.title
            });
        }

        $(document).ready(function() {
            $("#form_login").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email"
                    },
                    password: {
                        required: "Please enter password"
                    }
                }
            });

            $('#form_login').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                $('#btnLogin').css("cursor", "not-allowed");
                $('#btnLogin').prop('disabled', true);
                showLoader();
                $.ajax({
                    url: '{{ route('login') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        email: $(".email_login").val(),
                        password: $(".password").val(),
                    },
                    success: function(response) {
                        location.reload();
                        hideLoader();
                    },
                    error: function(request, status, error) {
                        hideLoader();
                        let params = {
                            icon: 'error',
                            title: 'Terjadi kesalahan atau koneksi terputus !'
                        }
                        showAlaret(params);
                        $('#btnLogin').css("cursor", "pointer");
                        $('#btnLogin').prop('disabled', false);
                    }
                });
            });

            $("#form").validate({
                rules: {
                    customer_name: {
                        required: true,
                    },
                    email: {
                        email: true,
                    },
                    customer_email: {
                        email: true,
                    },
                    customer_phone_number: {
                        required: true,
                    },
                    customer_address: {
                        required: true,
                    },
                    no_telepon: {
                        required: true,
                    },
                    customer_address_email: {
                        required: true,
                    },
                    shipping_province: {
                        required: true,
                    },
                    shipping_city: {
                        required: true,
                    },
                    shipping_distric: {
                        required: true,
                    },
                    shipping_courier: {
                        required: true,
                    }
                },
                messages: {
                    customer_name: {
                        required: "Please enter customer name"
                    },
                    email: {
                        required: "Please enter email"
                    },
                    customer_email: {
                        required: "Please enter email"
                    },
                    password: {
                        required: "Please enter password"
                    },
                    customer_phone_number: {
                        required: "Please enter customer phone number"
                    },
                    customer_address: {
                        required: "Please enter customer address"
                    },
                    no_telepon: {
                        required: "Please enter address phone number"
                    },
                    customer_address_email: {
                        required: "Please enter address email"
                    },
                    shipping_province: {
                        required: "Please choose shipping province"
                    },
                    shipping_city: {
                        required: "Please choose shipping city"
                    },
                    shipping_distric: {
                        required: "Please choose shipping distric"
                    },
                    shipping_postal_code: {
                        required: "Please enter shipping postal code"
                    },
                    shipping_courier: {
                        required: "Please choose shipping courier"
                    },
                },
                ignore: "",
                submitHandler: function () {
                    let min_purchase = `{{ $min_purchase }}`;

                    $('#order').css("cursor", "not-allowed");
                    // $('#order').prop('disabled', true);
                    // showLoader();

                    var index = 0;  
                    var total = $('.total').val();
                    var order_noted = $('.order_noted').val();
                    var name = $('.customer_name').val();
                    var email = $('.email').val();
                    var phone = $('.phonenumber').val();
                    var courier = $('.courier').val();
                    var service = $('.service').val();
                    var address = $('.customer_address').val();
                    var province = $('.shipping_province').val();
                    var city = $('.shipping_city').val();
                    var distric = $('.shipping_distric').val();

                    let payment_method = $(".payment_method:checked").val();


                    if (parseInt(total) < parseInt(min_purchase) && payment_method == "other") {
                        let min_price = parseInt(min_purchase).toLocaleString();
                        let params = {
                            icon: 'warning',
                            title: 'Minimal pembelian untuk pembayaran Rp. ' + min_price
                        }
                        showAlaret(params);
                        $('#order').css("cursor", "pointer");
                        $('#order').prop('disabled', false);
                        hideLoader();
                        return false;
                    }

                    if (name == '' && address == '' && province == '' && city == '' && distric == '') {
                        let params = {
                            icon: 'error',
                            title: 'Terjadi kesalahan atau koneksi terputus !'
                        }
                        showAlaret(params);
                        $('#order').css("cursor", "pointer");
                        $('#order').prop('disabled', false);
                        hideLoader();
                        return false;
                    } else {
                        // '/checkout-order'
                        $.ajax({
                            url: `{{ route('checkout-order') }}`,
                            type: 'POST',
                            data: $('#form').serialize(),
                            success: function(response) {

                                // console.log(response);

                                var payment_method = $(".payment_method:checked").val();
                                // console.log(payment_method);
                                if (payment_method == "other" && response != "") {

                                    $("#snap_token").val(response.invoice);

                                    snap.pay(response.invoice, {
                                        // Optional
                                        onSuccess: function(result) {
                                            // console.log(response);
                                            if ($('#cust_id').val() != '') {
                                                location.href = result.finish_redirect_url;
                                            }else{
                                                let params = {icon: 'success', title: 'Pesanan berhasil! Silahkan cek email anda untuk info lebih lanjut.'}
                                                showAlert(params)
                                                var url = '{{ url('order-history/:id/:token_code') }}';
                                                url = url.replace(':token_code', response.token);
                                                url = url.replace(':id', response.invoice_number);
                                                location.href = url;
                                            }
                                        },
                                        // Optional
                                        onPending: function(result) {
                                            if ($('#cust_id').val() != '') {
                                                location.href = result.finish_redirect_url;
                                            }else{
                                                let params = {icon: 'success', title: 'Pesanan berhasil! Silahkan cek email anda untuk info lebih lanjut.'}
                                                showAlert(params)
                                                var url = '{{ url('order-history/:id/:token_code') }}';
                                                url = url.replace(':token_code', response.token);
                                                url = url.replace(':id', response.invoice_number);
                                                location.href = url;
                                            }
                                        },
                                        // Optional
                                        onError: function(result) {
                                            if ($('#cust_id').val() != '') {
                                                location.href = result.finish_redirect_url;
                                            }else{
                                                location.href = '{{ url("/") }}'
                                            }
                                        }
                                    });

                                    // console.log(response);

                                } else {
                                    if(response.customer_id != null){
                                        var url = '{{ route('order_history_detail', ':id') }}';
                                    }else{
                                        var url = '{{ url('order-history/:id/:token_code') }}';
                                        url = url.replace(':token_code', response.token);
                                    }
                                    url = url.replace(':id', response.invoice);
                                    location.href = url;
                                    // console.log(response);
                                    $('#order').css("cursor", "pointer");
                                    $('#order').prop('disabled', false);
                                    //console.log(url);
                                }
                                hideLoader();
                            },
                            error: function(request, status, error, response) {
                                let params = {
                                    icon: 'error',
                                    title: 'Terjadi kesalahan atau koneksi terputus !'
                                }
                                showAlaret(params);

                                $('#order').css("cursor", "pointer");
                                $('#order').prop('disabled', false);
                                hideLoader();

                                if($("#snap_token").val() != ''){
                                    console.log($("#snap_token").val());
                                    // snap.pay($("#snap_token").val(), {
                                    //     // Optional
                                    //     onSuccess: function(result) {
                                    //         location.href = result.finish_redirect_url;
                                    //     },
                                    //     // Optional
                                    //     onPending: function(result) {
                                    //         location.href = result.finish_redirect_url;
                                    //     },
                                    //     // Optional
                                    //     onError: function(result) {
                                    //         location.href = result.finish_redirect_url;
                                    //     }
                                    // });
                                }
                            }
                        });
                    }
                }
            });
        });
    </script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>

        function register() {
            var x = document.getElementById("register_form");
            var y = document.getElementById("guest_form");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
            }
        }

        function guest() {
            var y = document.getElementById("register_form");
            var x = document.getElementById("guest_form");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
            }
        }

        function showExitingAddress() {

            let child = $(".shipping-address-customer").find(".new-address");
            if (child.length > 0) {
                let new_address = $(".address-hide").children();
                $(".shipping-address-customer").html(new_address);
                $(".address-hide").html(child);
            }
        }

        function showNewAddress() {

            let child = $(".shipping-address-customer").find(".exiting-address");
            if (child.length > 0) {
                let new_address = $(".address-hide").children();
                $(".shipping-address-customer").html(new_address);
                $(".address-hide").html(child);
                $('.existingaddress').val('');
            }
        }
    </script>
    @include('frontpage-schoko.script')
@endpush

@push('styles')
    <style>
        .ec-new-option {
            float: left;
            margin-bottom: 27px !important;
        }

        .ec-check-bill-form {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-flow: row wrap;
            flex-flow: row wrap;
            margin: 0 -15px;
        }

        [type="radio"] {
            background-color: transparent;
            border: 1px solid #ededed;
            color: #444444;
            font-size: 14px;
            margin-bottom: 16px;
            padding: 0 15px;
            width: 100%;
            outline: none;
        }

        [type=radio]:checked+label {
            position: relative;
            padding-left: 26px;
            cursor: pointer;
            line-height: 16px;
            display: inline-block;
            color: #777777;
            letter-spacing: 0;
        }

        [type=radio]:not(:checked)+label {
            position: relative;
            padding-left: 26px;
            cursor: pointer;
            line-height: 16px;
            display: inline-block;
            color: #777777;
            letter-spacing: 0;
        }

        [type=radio]:not(:checked) {
            position: absolute;
            left: -9999px;
        }

        [type=radio]:checked {
            position: absolute;
            left: -9999px;
        }

        [type=radio]:checked+label:before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 16px;
            height: 16px;
            border: 1px solid #ddd;
            border-radius: 100%;
            background: #ffffff;
            border: 1px solid #edd20d;
        }

        [type=radio]:checked+label:after {
            content: "";
            width: 8px;
            height: 8px;
            background: #edd20d;
            position: absolute;
            top: 4px;
            left: 4px;
            border-radius: 100%;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        [type=radio]:not(:checked)+label:before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 16px;
            height: 16px;
            border: 1px solid #ddd;
            border-radius: 100%;
            background: #ffffff;
        }

        [type=radio]:not(:checked)+label:after {
            content: "";
            width: 8px;
            height: 8px;
            background: #edd20d;
            position: absolute;
            top: 4px;
            left: 4px;
            border-radius: 100%;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
            opacity: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
        }
    </style>
@endpush
