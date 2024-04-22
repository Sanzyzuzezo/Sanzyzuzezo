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
                                                                        <input type="text" name="customer_phone_number"
                                                                            class="phonenumber"
                                                                            placeholder="{{ __('checkout.please_enter') }} {{ __('checkout.phone_number') }}"
                                                                            required />
                                                                    </span>
                                                                    <span class="ec-bill-wrap">
                                                                        <label>{{ __('checkout.address') }}*</label>
                                                                        <input type="text" name="customer_address"
                                                                            class="address"
                                                                            placeholder="{{ __('checkout.address') }}"
                                                                            required />
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>{{ __('checkout.province') }}*</label>
                                                                        <span class="ec-bl-select-inner">
                                                                            <select name="shipping_province"
                                                                                class="ec-bill-select province select-province shipping_province">
                                                                                <option value="">
                                                                                    {{ __('checkout.please_select') }}
                                                                                    {{ __('checkout.province') }}
                                                                                </option>
                                                                                @foreach ($provinces as $row)
                                                                                    <option value="{{ $row->id }}">
                                                                                        {{ $row->title }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <input type="hidden"
                                                                                id="shipping_province_label"
                                                                                name="shipping_province_label">
                                                                        </span>
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>{{ __('checkout.city') }}*</label>
                                                                        <span class="ec-bl-select-inner">
                                                                            <select name="shipping_city"
                                                                                class="ec-bill-select city select-city shipping_city">
                                                                                <option value="">
                                                                                    {{ __('checkout.please_select') }}
                                                                                    {{ __('checkout.city') }}</option>
                                                                            </select>
                                                                            <input type="hidden" id="shipping_city_label"
                                                                                name="shipping_city_label">
                                                                        </span>
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>{{ __('checkout.distric') }}*</label>
                                                                        <span class="ec-bl-select-inner">
                                                                            <select name="shipping_distric"
                                                                                class="ec-bill-select distric select-district shipping_distric">
                                                                                <option value="">
                                                                                    {{ __('checkout.please_select') }}
                                                                                    {{ __('checkout.distric') }}</option>
                                                                            </select>
                                                                            <input type="hidden" id="shipping_distric_label"
                                                                                name="shipping_distric_label">
                                                                        </span>
                                                                    </span>
                                                                    <span class="ec-bill-wrap ec-bill-half">
                                                                        <label>{{ __('checkout.post_code') }}</label>
                                                                        <input name="postalcode" type="text"
                                                                            class="postalcode"
                                                                            placeholder="{{ __('checkout.post_code') }}"/>
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
                        <div class="ec-cart-leftside col-lg-12 col-md-12 pb-4">
                            <div class="ec-cart-content">
                                <div class="ec-cart-inner">
                                    <div class="row">

                                        <div class="table-content cart-table-content">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('checkout.product') }}</th>
                                                        <th class="text-end">{{ __('checkout.price') }}</th>
                                                        <th class="text-end">{{ __('checkout.quantity') }}</th>
                                                        <th class="text-end">Total</th>
                                                        <th>{{ __('checkout.noted') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $subtotal = 0;
                                                    $old_subtotal = 0;
                                                    ?>
                                                    @php $weight_total = 0 @endphp
                                                    @foreach ($cart_data as $key => $data)
                                                        @php $weight_total = $weight_total + $data->berat_produk @endphp
                                                        @php
                                                            $fix_customer_discount = 0;
                                                            $harga_normal_diskon = 0;
                                                            $qty = $quantity[$data->variant_id]['quantity'];
                                                            if (isset(auth()->user()->customer_group_id)) {
                                                                $status_diskon_customer = false; //Update Septi : 8 Juni 2022
                                                                $harga = $data->price;//Update Septi : 8 Juni 2022
                                                                foreach ($discount_customer as $dc) {
                                                                    $discount_brand = json_decode($dc->discount);
                                                                    foreach ($discount_brand as $brand) {
                                                                        if ($data->brand_id === $brand->id) {
                                                                            $harga_normal = $data->price;
                                                                            $harga_normal_diskon = $data->discount_price;
                                                                            $potongan = ($data->price * $brand->discount) / 100;
                                                                            $fix_customer_discount = $data->price - $potongan;
                                                                            if ($fix_customer_discount < $data->discount_price) {
                                                                                $status_diskon_customer = true; //Update Septi : 8 Juni 2022
                                                                                $harga = $fix_customer_discount;
                                                                            } else {
                                                                                if ($data->discount_price > 0) {
                                                                                    $data->discount_price > 0 ? ($harga = $data->discount_price) : ($harga = $data->price);
                                                                                } else {
                                                                                    $status_diskon_customer = true; //Update Septi : 8 Juni 2022
                                                                                    $harga = $fix_customer_discount;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                //Update Septi : 8 Juni 2022
                                                                if ($status_diskon_customer == false) {
                                                                    if ($data->discount_price > 0) {
                                                                        $data->discount_price > 0 ? ($harga = $data->discount_price) : ($harga = $data->price);
                                                                    }
                                                                }
                                                                //End Update Septi : 8 Juni 2022

                                                            } else {
                                                                $data->discount_price > 0 ? ($harga = $data->discount_price) : ($harga = $data->price);
                                                            }
                                                            $harga = isset($harga) ? $harga : ($data->discount_price > 0 ? $data->discount_price : $data->price);
                                                            $subtotal += $harga * $qty;
                                                            $old_subtotal += $data->price * $qty;
                                                        @endphp
                                                        <tr class="cart-list">
                                                            <td data-label="Product" class="ec-cart-pro-name">
                                                                <div class="d-flex flex-row">
                                                                    <div><img class="ec-cart-pro-img"
                                                                            src="{{ img_src($data->image, 'product') }}"
                                                                            alt="" /></div>
                                                                    <div
                                                                        class="d-flex justify-content-start flex-column p-2">
                                                                        <a href="#"
                                                                            class="text-dark fw-bolder text-hover-primary fs-6">{{ strlen($data['name']) > 24 ? substr($data['name'], 0, 25) . '...' : $data['name'] }}</a>
                                                                        <small>{{ $data['variant'] }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td data-label="Price" class="ec-cart-pro-price">
                                                                @if (isset(auth()->user()->customer_group_id) && $harga_normal_diskon > $fix_customer_discount)
                                                                    <span style="text-decoration: line-through;"
                                                                        class="amount">{{ number_format($harga_normal_diskon) }}</span>
                                                                @endif
                                                                <span
                                                                    class="amount text-end">{{ number_format($harga) }}</span>
                                                            </td>
                                                            <td data-label="Quantity" class="ec-cart-pro-qty text-end">
                                                                {{ $qty }}
                                                            </td>
                                                            <td data-label="Total" class="ec-cart-pro-subtotal text-end">
                                                                {{ number_format($harga * $qty) }}
                                                            </td>
                                                            <td class="ec-cart-pro-name">
                                                                <input type="hidden"
                                                                    name="item[{{ $key }}][product_id]"
                                                                    class="product_id" value="{{ $data['id'] }}">
                                                                <input type="hidden"
                                                                    name="item[{{ $key }}][variant_id]"
                                                                    class="variant_id"
                                                                    value="{{ $data['variant_id'] }}">
                                                                <input type="hidden"
                                                                    name="item[{{ $key }}][quantity]"
                                                                    class="quantity" value="{{ $qty }}">
                                                                <input type="hidden"
                                                                    name="item[{{ $key }}][price]"
                                                                    class="price" value="{{ $harga }}">
                                                                <input type="hidden"
                                                                    name="item[{{ $key }}][weight]"
                                                                    class="weight" value="{{ $data->weight }}">
                                                                <input type="hidden"
                                                                    name="item[{{ $key }}][dimensions]"
                                                                    class="dimensions"
                                                                    value="{{ $data->dimensions }}">
                                                                <input type="text" name="item[{{ $key }}][note]"
                                                                    class="form-control noted" value="">
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
                        <div class="ec-cart-rightside col-lg-12 col-md-12">
                            <div class="ec-sidebar-wrap">
                                <div class="ec-sidebar-block">
                                    <div class="ec-sb-title">
                                        <h3 class="ec-sidebar-title">{{ __('checkout.summary') }}</h3>
                                    </div>
                                    <div class="ec-sb-block-content">
                                        <div class="ec-cart-summary-bottom">
                                            <div class="ec-cart-summary">
                                                <div>
                                                    <span class="text-left">+ Sub-Total</span>
                                                    <span class="text-right">Rp.
                                                        <?= number_format($old_subtotal) ?></span>
                                                    <input type="hidden" name="old_subtotal" class="SUBtotal"
                                                        value="{{ $old_subtotal }}">
                                                </div>
                                                <div>
                                                    <span class="text-left">- Diskon</span>
                                                    <span class="text-right">Rp.
                                                        <?= number_format($old_subtotal - $subtotal) ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-left"> Total</span>
                                                    <span class="text-right">Rp. <?= number_format($subtotal) ?></span>
                                                    <input type="hidden" name="order_total" class="total"
                                                        value="{{ $subtotal }}">
                                                </div>
                                                <div>
                                                    <span class="text-left">+
                                                        {{ __('checkout.delivery_charges') }}</span>
                                                    <span class="text-right shipping_cost_text">Rp. 0</span>
                                                    <input type="hidden" name="shipping_cost" class="shipping_cost"
                                                        value="0">
                                                </div>
                                                <div class="ec-cart-summary-total">
                                                    <span
                                                        class="text-left">{{ __('checkout.total_amount') }}</span>
                                                    <span class="text-right total_amount">Rp.
                                                        <?= number_format($subtotal) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (isset(auth()->user()->id))
                            <div class="ec-cart-leftside col-lg-12 col-md-12 mb-5">
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
                                                                                    value="{{ $addres->nama_kota }}"
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
                        <div class="ec-cart-leftside col-lg-12 col-md-12">
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
                                                            <select name="origins"
                                                                class="ec-bill-select origins select-origins">
                                                                {{-- <option value="">Pilih Store</option> --}}
                                                                @foreach ($origins as $origin)
                                                                    <option value="{{ $origin->id }}"
                                                                        data-province_id="{{ $origin->province_id }}"
                                                                        data-city_id="{{ $origin->city_id }}"
                                                                        data-subdistrict_id="{{ $origin->subdistrict_id }}"
                                                                        data-name="{{ $origin->name }}">
                                                                        {{ $origin->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" id="store_name" name="store_name">
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
                                                                <option class="internal_courier" value="internal_courier">
                                                                    Schoko(Sameday)</option>
                                                                @foreach ($couriers as $courier)
                                                                    <option value="{{ $courier->code }}">
                                                                        {{ $courier->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </span>
                                                    </span>
                                                    <span class="ec-bill-wrap ec-bill-half">
                                                        <label>{{ __('checkout.service') }} *</label>
                                                        <span class="ec-bl-select-inner">
                                                            <select name="shipping_service" class="ec-bill-select service">

                                                            </select>
                                                        </span>
                                                    </span>
                                                    <span class="ec-bill-wrap">
                                                        <label>{{ __('checkout.payment') }} *</label><br>
                                                        <span class="ec-new-option">
                                                            <span>
                                                                <input class="payment_method" type="radio"
                                                                    name="payment_method" value="manual_bank_transfer"
                                                                    id="manual_bank_transfer" checked>
                                                                <label
                                                                    for="manual_bank_transfer">{{ __('checkout.manual_bank_transfer') }}</label>
                                                            </span>
                                                            <span>
                                                                <input class="payment_method" type="radio"
                                                                    name="payment_method" value="other" id="other">
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
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ec-cart-leftside col-lg-12 col-md-12 mt-5 text-center">
                            <button class="btn btn-primary col-lg-4 col-6" id="order"
                                type="submit">{{ __('checkout.order') }}</button>
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
                <input type="text" class="postalcode" name="postalcode"
                    placeholder="{{ __('checkout.post_code') }}" />
            </span>
            <span class="ec-bill-wrap">
                <label>{{ __('checkout.full_address') }}*</label>
                <input type="text" name="customer_address" placeholder="{{ __('checkout.full_address') }}" />
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
                    shipping_province: {
                        required: true,
                    },
                    shipping_city: {
                        required: true,
                    },
                    shipping_distric: {
                        required: true,
                    },
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

                                var payment_method = $(".payment_method:checked").val();
                                if (payment_method == "other" && response != "") {

                                    snap.pay(response, {
                                        // Optional
                                        onSuccess: function(result) {
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

                                    console.log(response);

                                } else {
                                    var url = '{{ route('order_history_detail', ':id') }}';
                                    url = url.replace(':id', response);
                                    location.href = url;
                                    console.log(response);
                                    $('#order').css("cursor", "pointer");
                                    $('#order').prop('disabled', false);
                                    //console.log(url);
                                }
                                hideLoader();
                            },
                            error: function(request, status, error) {
                                let params = {
                                    icon: 'error',
                                    title: 'Terjadi kesalahan atau koneksi terputus !'
                                }
                                showAlaret(params);
                                $('#order').css("cursor", "pointer");
                                $('#order').prop('disabled', false);
                                hideLoader();
                            }
                        });
                    }
                }
            });
        });
    </script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-ZXJcCR-TwQv0MHgR"></script>

    <script>
        const internal_courier_price = `{{ $internal_courier_price }}`;

        getOngkirWhenAddessActive();

        $(document).ready(function() {

            $(document).on('change', '.select-origins', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                // showLoader();
                // let origin = dataOrigin();
                // getOngkirWhenAddessActive();
            });

            $(document).on('click', '.addresses', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                // showLoader();
                // let origin = dataOrigin();
                // showHideInternal();
                // const shipping = {
                //     province_id: $(this).data('shipping_province'),
                //     city_id: $(this).data('shipping_city'),
                //     subdistrict_id: $(this).data('shipping_distric'),
                //     origin_province_id: origin.provinsi,
                //     origin_city_id: origin.kota,
                //     origin_subdistrict_id: origin.kecamatan,
                //     courier: $('.courier').val(),
                //     address_id: $(this).data('addres_id'),
                //     weight_total: $('#weight_total').val()
                // }
                // saveAndGetAddressUser(shipping);
            });

            $(document).on('change', '.courier', function(e) {

                e.preventDefault();
                e.stopImmediatePropagation();
                // showLoader();
                // let courier_id = $(this).val();
                // getOngkirWhenAddessActive()
            });

            $(document).on('change', '.service', function(e) {

                e.preventDefault();
                e.stopImmediatePropagation();

                // showLoader();

                // let value = $(this).val();
                // let cost = $(this).find(':selected').data('cost');
                // let estimated = $(this).find(':selected').data('etd');

                // let format = Intl.NumberFormat('en-US');
                // let cost_format = format.format(cost);
                // let total_order = $('.total').val();
                // $('.shipping_cost_text').html('Rp. ' + cost_format);
                // $('.shipping_cost').val(cost);
                // let total_amount = parseInt(total_order) + parseInt(cost)
                // $('.total_amount').html('Rp. ' + format.format(total_amount))

                // hideLoader();

            });

        });

        function getServiceCourier(courier_id) {

            $.ajax({
                url: '{{ route('getServiceCourier') }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    courier_id: courier_id
                },
                success: function(response) {
                    $('.service').empty();
                    response.forEach(index => {
                        let element_address = `<option value="${index.code}"> ${index.title} </option>`;
                        $('.service').append(element_address);
                    });
                    hideLoader();
                },
                error: function(request, status, error) {
                    hideLoader();
                    let params = {
                        icon: 'error',
                        title: 'Terjadi kesalahan atau koneksi terputus !'
                    }
                    showAlaret(params);
                }
            });
        }

        function getOngkirWhenAddessActive() {

            let active_address = $(document).find('.active_address');

            if (active_address.length > 0) {

                let origin = dataOrigin();

                showHideInternal();

                const shipping = {
                    province_id: active_address.find('.shipping_province').val(),
                    city_id: active_address.find('.shipping_city').val(),
                    subdistrict_id: active_address.find('.shipping_distric').val(),
                    origin_province_id: origin.provinsi,
                    origin_city_id: origin.kota,
                    origin_subdistrict_id: origin.kecamatan,
                    courier: $('.courier').val(),
                    address_id: active_address.find('.addres_id').val(),
                    weight_total: $('#weight_total').val()
                }

                getOngkir(shipping);

            } else {
                hideLoader();
                let params = {
                    icon: 'warning',
                    title: 'Silahkan isi atau pilih alamat !'
                }
                showAlaret(params);
            }
        }

        function showHideInternal() {

            let active_address = $(document).find('.active_address');

            const bandungraya = [22, 23, 24, 107];
            let destination_city = active_address.find('.shipping_city').val();
            let internal = $('.courier').find('.internal_courier');

            if (bandungraya.includes(parseInt(destination_city))) {
                internal.show();
            } else {
                internal.hide();
                let selected = $('.courier').find(":selected").val();
                if (selected == 'internal_courier') {
                    $('.courier option:eq(2)').prop('selected', true)
                }
                // console.log(selected);
                // console.log(destination_city);
            }
        }

        function dataOrigin() {
            const origin = {
                provinsi: $('.select-origins').find(':selected').data('province_id'),
                kota: $('.select-origins').find(':selected').data('city_id'),
                kecamatan: $('.select-origins').find(':selected').data('subdistrict_id'),
            }
            return origin;
        }

        function saveAndGetAddressUser(shipping) {
            $.ajax({
                url: '{{ route('save-address') }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    address_id: shipping.address_id,
                    active: 1
                },
                success: function(response) {
                    $('.exiting-address-list').empty();
                    response.forEach(index => {
                        let active_address = index.active == 1 ? "active_address" : "";
                        let background = index.active == 1 ? "background-color: #F7F7F7" : "";
                        let icon_check = index.active == 1 ?
                            '<i class="ecicon eci-check" aria-hidden="true"></i>' : '';

                        let address_input = '';

                        if (index.active == 1) {
                            address_input = `<input type="hidden" value="${index.subdistrict_id}" class="shipping_distric" name="shipping_distric">
                                <input type="hidden" value="${index.kecamatan_name}" class="shipping_distric_label" name="shipping_distric_label">
                                <input type="hidden" value="${index.city_id}" class="shipping_city" name="shipping_city">
                                <input type="hidden" value="${index.city_name}" class="shipping_city_label" name="shipping_city_label">
                                <input type="hidden" value="${index.province_id}" class="shipping_province" name="shipping_province">
                                <input type="hidden" value="${index.province_name}" class="shipping_province_label" name="shipping_province_label">
                                <input type="hidden" value="${index.id}" class="addres_id" name="addres_id">
                                <input type="hidden" value="${index.detail_address}" class="customer_address" name="customer_address">
                                <input type="hidden" value="${index.received_name}" class="customer_name" name="customer_name">

                                `
                        }

                        let element_address = `<div
                            data-shipping_province="${index.province_id}"
                            data-shipping_city="${index.city_id}"
                            data-shipping_distric="${index.subdistrict_id}"
                            data-addres_id="${index.id}"
                            class="card mt-4 addresses ${active_address}" style="width: 100%; ${background}">
                            <div class="card-body">
                                <div class="card-title d-flex">
                                    <h5 style="margin-right: 10px; color: green;"> ${icon_check} </h5>
                                    <h5>Nama Penerima :  ${index.received_name} </h5>
                                </div>
                                <hr style="background-color: #2f4f4f;">
                                <p class="card-text"> ${index.detail_address }</p>
                                <p class="card-text">Kecamatan  ${index.kecamatan_name}   ${index.city_type}   ${index.city_name} ,  ${index.province_name} </p>
                                ` +
                            address_input +
                            `
                            </div>
                        </div>`;
                        $('.exiting-address-list').append(element_address);
                    });
                    getOngkir(shipping);
                },
                error: function(request, status, error) {
                    hideLoader();
                    let params = {
                        icon: 'error',
                        title: 'Terjadi kesalahan atau koneksi terputus !'
                    }
                    showAlaret(params);
                }
            });
        }

        function getOngkir(data) {

            if (typeof data.courier == 'string' && data.courier == 'internal_courier') {
                $(".service").empty();
                $('.service').prop("disabled", true);
                $(".service").css("background-color", "#f5f5f5");
                $(".service").css("cursor", "not-allowed");
                $('.service').val("internal");

                let cost = parseInt(internal_courier_price);
                let format = Intl.NumberFormat('en-US');
                let cost_format = format.format(cost);
                let total_order = $('.total').val();
                $('.shipping_cost_text').html('Rp. ' + cost_format);
                $('.shipping_cost').val(cost);
                let total_amount = parseInt(total_order) + parseInt(cost)
                $('.total_amount').html('Rp. ' + format.format(total_amount))

                hideLoader();
                return
            }

            $.ajax({
                url: '{{ route('get-ongkir') }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    "weight": data.weight_total,
                    "province_id": data.province_id,
                    "city_id": data.city_id,
                    "subdistrict_id": data.subdistrict_id,
                    "origin_province_id": data.origin_province_id,
                    "origin_city_id": data.origin_city_id,
                    "origin_subdistrict_id": data.origin_subdistrict_id,
                    "courier": data.courier,
                },
                dataType: "JSON",
                success: function(data) {
                    hideLoader();
                    let status = data.rajaongkir.status;
                    let destionation = data.rajaongkir;

                    if (status.code == 400) {
                        let params = {
                            icon: 'warning',
                            title: 'Silahkan isi atau pilih alamat !'
                        }
                        showAlaret(params);
                    } else
                    if (status.code == 202) {
                        var url = `{{ route('checkout') }}`;
                        location.href = url;
                    } else {
                        let ongkir = data['rajaongkir']['results'][0];
                        let costs = ongkir['costs'];
                        $(".service").empty();
                        $('.service').prop("disabled", false);
                        $(".service").css("background-color", "#FFF");
                        $(".service").css("cursor", "auto");
                        // showHideInternal();
                        costs.forEach(function(value, index) {

                            let element_service_courier =
                                `<option data-etd="${value['cost'][0]['etd']}" data-cost="${value['cost'][0]['value']}" value="${value.service}"> ${value.description} (${value['cost'][0]['etd']} Hari) </option>`;
                            $('.service').append(element_service_courier);

                            let service_choose = $('.service').val()

                            if (service_choose == value['service']) {

                                let format = Intl.NumberFormat('en-US');
                                let cost_format = format.format(value['cost'][0]['value']);
                                let total_order = $('.total').val();
                                $('.shipping_cost_text').html('Rp. ' + cost_format);
                                $('.shipping_cost').val(value['cost'][0]['value']);
                                let total_amount = parseInt(total_order) + parseInt(value['cost'][0][
                                    'value'
                                ])
                                $('.total_amount').html('Rp. ' + format.format(total_amount))

                            }
                        });
                        store_name = $('.select-origins').find(':selected').data('name');
                        $('#store_name').val(store_name);
                        showHideInternal();
                    }

                },
                error: function(request, status, error) {
                    hideLoader();
                    let params = {
                        icon: 'error',
                        title: 'Terjadi kesalahan atau koneksi terputus !'
                    }
                    showAlaret(params);

                }
            });
        }

        function showAlaret(params = '') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: params.icon,
                title: params.title
            });
        }

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

        $(document).ready(function() {

            $(this).find('#order').off().click(function(e) {
                // e.preventDefault();
                // console.log('MASUK KE SINI');
                store_name = $('.select-origins').find(':selected').data('name');
                $('#store_name').val(store_name);
            });

            $('.payment_method').off().change(function(e) {
                var payment_method = $(this).val();
                if (payment_method == "other") {
                    $(".bank_account-select").hide();
                } else {
                    $(".bank_account-select").show();
                }
            });

            $('.select-province').off().change(function(e) {
                var selected_data = $(this).val();
                var selected_label = $('option:selected', this).text();
                $(".select-city").find('option').not(':first').remove();
                $(".select-district").find('option').not(':first').remove();
                showLoader();
                $.ajax({
                    url: '{{ route('getCities') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        province_id: selected_data
                    },
                    dataType: "JSON",
                    success: function(data) {

                        $('.shipping_cost_text').html('Rp. 0');
                        $('.shipping_cost').val('');
                        $('#shipping_province_label').val(selected_label);
                        const list = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                        const cities = list.rajaongkir.results;
                        cities.forEach(index => {
                            let city_option =
                                `<option value="${index.city_id}">${index.type} ${index.city_name}</option>`;
                            $(".select-city").append(city_option);
                        });
                        hideLoader();
                    }
                });
            });

            $('.select-city').off().change(function(e) {
                var selected_data = $(this).val();
                var selected_label = $('option:selected', this).text();
                $(".select-district").find('option').not(':first').remove();
                showLoader();
                $.ajax({
                    url: '{{ route('getKecamatan') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        city_id: selected_data
                    },
                    dataType: "JSON",
                    success: function(data) {

                        $('.shipping_cost_text').html('Rp. 0');
                        $('.shipping_cost').val('');
                        $('#shipping_city_label').val(selected_label);
                        const list = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                        const districts = list.rajaongkir.results;
                        districts.forEach(index => {
                            let district_option =
                                `<option value="${index.subdistrict_id}">${index.subdistrict_name}</option>`;
                            $(".select-district").append(district_option);
                        });
                        hideLoader();
                    }
                });
            });

            $('.select-district').off().change(function(e) {

                var selected_data = $(this).val();
                var selected_label = $('option:selected', this).text();

                $('#shipping_distric_label').val(selected_label);

                let origin = dataOrigin();

                const data = {
                    province_id: $('.select-province').val(),
                    city_id: $('.select-city').val(),
                    subdistrict_id: selected_data,
                    origin_province_id: origin.provinsi,
                    origin_city_id: origin.kota,
                    origin_subdistrict_id: origin.kecamatan,
                    courier: $('.courier').val(),
                    weight_total: $('#weight_total').val()
                }

                showLoader();

                getOngkir(data)

            });

        });
    </script>
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
