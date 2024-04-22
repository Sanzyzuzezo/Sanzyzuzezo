@extends('frontpage-schoko.layouts.main')
@push('styles')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    table{
        table-layout: fixed;
    }
    .th-product{
        width: 250px;
    }
    .th-price{
        width: 70px;
    }
    .th-qty{
        width: 100px;
    }
    .th-total{
        width: 70px;
    }
    .th-act{
        width: 50px;
    }
</style>
@endpush
@section('content')
<div class="sticky-header-next-sec ec-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Cart</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">{{ __('cart.Home') }}</a></li>
                            <li class="ec-breadcrumb-item active">Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
    <div class="container">
        <div class="row">
            <?php
                if (isset(auth()->user()->id)) {
            ?>
            <div class="ec-shop-leftside ec-vendor-sidebar col-lg-12 col-md-12 section-space-mb">
                <div class="ec-sidebar-wrap">
                    <div class="ec-sidebar-block">
                        <div class="ec-vendor-block">
                            <div class="ec-vendor-block-items">
                                <ul>
                                    <li><a href="{{ route('profile') }}">{{ __('profile.user_profile') }}</a></li>
                                    <li><a href="{{ route('address') }}">{{ __('profile.address') }}</a></li>
                                    <li><a href="{{ route('order_history') }}">{{ __('profile.transaction') }}</a></li>
                                    <li><a href="{{ route('cart') }}">Cart</a></li>
                                    <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
            @if (isset($cart_data))
            {{-- @if (Cookie::get('shopping_cart')) --}}
            @php $total="0" @endphp
            <div class="ec-cart-leftside col-lg-12 col-md-12 ">
                <div class="ec-cart-content">
                    <div class="ec-cart-inner">
                        <div class="row">
                            <form action="#">
                                <div class="table-content cart-table-content p-0 overflow-visible">
                                    <table>
                                        @if(count($cart_data) != 0)
                                        <thead>
                                            <tr>
                                                <!-- <th style="width: 30px;"><input type="checkbox" value="" id="checkall" style="width: 17px !important; width: 30px;"></th>
                                                <th>{{ __('cart.Product') }}</th>
                                                <th>{{ __('cart.Price') }}</th>
                                                <th style="text-align: center;">{{ __('cart.Quantity') }}</th>
                                                <th>{{ __('cart.Total') }}</th>
                                                <th style="width: 5%;"></th> -->
                                                <th class="n-chk" style="width: 20px;">
                                                    <div class="row">
                                                        <div class="col-1"><input type="checkbox" value="" id="checkall" style="width: 17px !important; width: 30px;"> </div>
                                                        <div class="col-9 d-flex align-items-center"> {{ __('cart.Select_All') }}</div>
                                                    </div>
                                                </th>
                                                {{-- <th class="n-chk th-product">{{ __('cart.Product') }}</th>
                                                <th class="n-chk th-price">{{ __('cart.Price') }}</th>
                                                <th class="n-chk th-qty" style="text-align: center;">{{ __('cart.Quantity') }}</th>
                                                <th class="n-chk th-total">{{ __('cart.Total') }}</th>
                                                <th class="n-chk th-act"></th>
                                                <th class="chk-mbl d-none"><input type="checkbox" value="" id="checkall" style="width: 17px !important; width: 30px;"> <label for="checkall" class="m-0 px-3" style="vertical-align: top; padding-top: 14px;">All</label></th> --}}
                                            </tr>
                                        </thead>
                                        @endif
                                        <tbody>
                                            <?php $subtotal = 0; ?>
                                            @foreach ($cart_data as $key => $data)
                                            @php
                                                if (isset(auth()->user()->customer_group_id)) {
                                                    $qty = $data['quantity'];
                                                }else{
                                                    $qty = $quantity[$data->variant_id]['quantity'];
                                                }
                                                $harga = $data->price;
                                                if($data->discount_price != null){
                                                    $harga = $data->discount_price;
                                                }
                                                $subtotal += $harga * $qty;
                                            @endphp
                                             <tr class="cart-list">
                                                <td data-label="Product">
                                                    <div class="row">
                                                        <div class="col-lg-1 col-1" style="padding-right: 0px;">
                                                            <input type="checkbox" id="chck" value="" class="chck" style="width: 17px !important;">
                                                        </div>
                                                        <div class="col-lg-3 col-3">
                                                            <img class="" src="{{ img_src($data->image, 'product') }}" alt=""/>
                                                        </div>
                                                        <div class="col-lg-7 col-7 px-0">
                                                            <div>
                                                                <a href="#" class="text-dark fw-bolder text-hover-primary" style="font-size: 12px;">{{ $data['name'] }}</a>
                                                            </div>
                                                            <div>
                                                                <small class="product-variant" style="font-size: 10px;">{{ $data['variant'] }}</small>
                                                            </div>
                                                            <div class="row product-price d-flex align-items-center">
                                                                <div class="col-4 pr-0">
                                                                    <span class="amount text-end" style="font-size: 11px;">Rp. {{ number_format($harga) }}</span>
                                                                    {{-- <span class="amount text-end" style="font-size: 11px;">Rp. {{ $data->stock_promo > $qty ? number_format($harga) : number_format($data->price) }}</span> --}}
                                                                </div>
                                                                <div class="col-2 px-0 mx-1">
                                                                    <div class="cart-qty-plus-minus" style="width:60px; height:25px">
                                                                        <input class="cart-plus-minus changeQuantity quantity" style="font-size: 11px;" type="number" min="1" onkeypress="return hanyaAngka(event)" name="cartqtybutton" value="{{ $qty }}" />
                                                                    </div>
                                                                    <span style="display: none; font-size: 0.7rem; color: red;">Out of Stock</span>
                                                                    <input type="hidden" class="stock" value="{{ $data->stock_promo <= 0 ? $data->stock : $data->stock_promo }}">
                                                                </div>
                                                                <div class="col-4 ml-4 product-total text-end px-0" style="font-size: 11px;">
                                                                    Rp. {{ number_format($harga * $qty) }}
                                                                </div>
                                                                <span class="out-of-stock d-none" style="font-size: 0.7rem; color: red;"><br/>The remaining stock for this promotional item is {{ $data->stock_promo }}. Please purchase the remaining amount you need in the next transaction !</span>
                                                                    <input type="hidden" class="variant_id cart-variant_id" value="{{ $data['variant_id'] }}" />
                                                                    <input type="hidden" class="cart-price" value="{{ $harga }}" />
                                                                    <input type="hidden" class="discount-price" value="{{ $data->discount_price }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 col-1" style="padding-left: 5px">
                                                            <a href="#" class="deleteCart"><svg style="color: red" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16"> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" fill="red"></path> </svg></a>
                                                        </div>
                                                    </div>
                                                </td>
                                             </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row px-3">
                                    <div class="col-lg-12">
                                        <div class="ec-cart-update-bottom py-3">
                                            <a href="{{ route('catalogues') }}">Continue Shopping</a>
                                        </div>
                                        <div class="ec-cart-update-bottom pt-0 pb-3">
                                            <a href="#" class="btn btn-primary d-none" id="button_checkout">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-cart-rightside col-lg-12 col-md-12">
                <div class="ec-sidebar-wrap">
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Summary</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-cart-summary-bottom">
                                <div class="ec-cart-summary">
                                    <div>
                                        <span class="text-left">Sub-Total</span>
                                        <span class="text-right summary-total"> Rp. 0</span>
                                    </div>
                                    <div class="ec-cart-summary-total">
                                        <span class="text-left">Total Amount</span>
                                        <span class="text-right summary-grandtotal">Rp. 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;
        return true;
    }

    $(document).ready(function() {
        /*----------------------------- Cart Page Qty Plus Minus Button  ------------------------------ */
        var CartQtyPlusMinus = $(".cart-qty-plus-minus");
        CartQtyPlusMinus.append('<div class="ec_cart_qtybtn"><div class="inc ec_qtybtn">+</div><div class="dec ec_qtybtn">-</div></div>');
        resetData();

        $('#checkall').on('change', function() {
            if ($("#checkall").is(":checked")) {
                $('input:checkbox').prop('checked', true);
                $('#button_checkout').removeClass("d-none");
            } else {
                $('input:checkbox').prop('checked', false);
                $('#button_checkout').addClass("d-none");
            }

            total = 0;
            $(".cart-list").each(function() {
                if ($(this).find('.chck').is(":checked")) {
                    var quantity = $(this).find('.quantity').val();
                    var price = $(this).find('.cart-price').val();
                    var producttotal = parseFloat(quantity) * parseFloat(price);
                    var subtotal = parseFloat(quantity) * parseFloat(price);
                    total += subtotal;
                }
            });
            $('.summary-total').text('Rp. '+formatNumber(total.toString()));
            $('.summary-grandtotal').text('Rp. '+formatNumber(total.toString()));
        });

        $('.chck').on('change', function() {
            $(".chck").each(function() {
                if ($(this).find(".chck").is(":checked")) {
                    $('#checkall').prop('checked', true);
                } else {
                    $('#checkall').prop('checked', false);
                }
            });

            if ($(".chck").is(":checked")) {
                $('#button_checkout').removeClass("d-none");
            } else {
                $('#button_checkout').addClass("d-none");
            }

            total = 0;
            $(".cart-list").each(function() {
                if ($(this).find('.chck').is(":checked")) {
                    var quantity = $(this).find('.quantity').val();
                    var price = $(this).find('.cart-price').val();
                    var producttotal = parseFloat(quantity) * parseFloat(price);
                    var subtotal = parseFloat(quantity) * parseFloat(price);
                    total += subtotal;
                }
            });
            $('.summary-total').text('Rp. '+formatNumber(total.toString()));
            $('.summary-grandtotal').text('Rp. '+formatNumber(total.toString()));
        });
    });

    $('#button_checkout').on('click', function(e) {
        var data_item = [];
        let error = false;
        $(".cart-list").each(function() {
            var another = this;
            var variant_id = $(another).find('.variant_id').val();
            var quantity = $(another).find('.quantity').val();
            let stock = $(another).find('.stock').val();

            if ($(this).find('.chck').is(":checked")) {

                if (parseInt(quantity) > parseInt(stock)) {
                    let params = {icon: 'warning', title: 'Out of Stock !'}
                    showAlert(params)
                    error = true;
                }

                data_item.push({variant_id:variant_id, quantity:quantity});
                // console.log("checked");
            } else {
                // console.log("unchecked");
            }

            e.preventDefault();
        });

        if(error === false){
            $.ajax({
                url: "/select-cart",
                method: "DELETE",
                xhrFields: {
                    withCredentials: true
                },
                crossDomain: true,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "data" : data_item,
                },success: function() {
                    window.location.href = 'checkout';
                }
            });
        }

    });

    function showAlert (params = '') {
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

    function resetData() {

        var index = 0;
        $(".cart-list").each(function() {
            var another = this;

            $(this).find('.changeQuantity').off().keyup(function(e) {
                e.preventDefault();
                console.log($(this).val());
                var variant_id = $(another).find('.variant_id').val();
                var quantity = $(another).find('.quantity').val();
                var price = $(another).find('.cart-price').val();

                let stock = $(this).parent().next().next().val();

                if(parseInt(quantity) > parseInt(stock)){
                    if($(another).find('.discount-price').val() > 0){
                        $(another).find('.out-of-stock').removeClass('d-none');
                    }

                    $(this).parent().next().css("display", "block");
                    return;
                } else {
                    $(this).parent().next().css("display", "none");
                        $(another).find('.out-of-stock').addClass('d-none');
                }

                var subtotal = parseFloat(quantity) * parseFloat(price);

                $(another).find('.ec-cart-pro-subtotal').text(formatNumber(subtotal.toString()));
                $(another).find('.product-total').text('Rp. '+formatNumber(subtotal.toString()));

                $.ajax({
                    url: '/update-cart',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'variant_id': variant_id,
                        'quantity': quantity
                    },success: function() {
                        resetCount();
                    }
                });

            });

            $(this).find('.deleteCart').off().click(function(e) {
                e.preventDefault();

                var variant_id = $(another).find('.variant_id').val();

                $.ajax({
                    url: '/delete-cart',
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'variant_id': variant_id
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            });

            $(this).find(".cart-qty-plus-minus .ec_cart_qtybtn .ec_qtybtn").off().on("click", function() {
                let stock = $(this).parent().parent().parent().find('.stock').val();
                var $cartqtybutton = $(this);
                var CartQtyoldValue = $cartqtybutton.parent().parent().find("input").val();
                if((parseInt(CartQtyoldValue) + 1) > stock && $cartqtybutton.text() === "+"){
                    // alert(CartQtyoldValue+' = '+stock)
                    return;
                }

                if ($cartqtybutton.text() === "+") {
                    var CartQtynewVal = parseFloat(CartQtyoldValue) + 1;
                } else {

                    if (CartQtyoldValue > 1) {
                        var CartQtynewVal = parseFloat(CartQtyoldValue) - 1;
                    } else {
                        CartQtynewVal = 1;
                    }
                }
                $cartqtybutton.parent().parent().find("input").val(CartQtynewVal);
                var variant_id = $(another).find('.variant_id').val();
                var quantity = CartQtynewVal;
                var price = $(another).find('.cart-price').val();
                var subtotal = parseFloat(quantity) * parseFloat(price);

                $(another).find('.product-total').text('Rp. '+formatNumber(subtotal.toString()));

                $.ajax({
                    url: '/update-cart',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'variant_id': variant_id,
                        'quantity': quantity
                    },
                    success: function() {
                        resetCount();
                    }
                });


            });

        });
    }

    function resetCount() {
        total = 0;
        $(".cart-list").each(function() {
            if ($(this).find('.chck').is(":checked")) {
                var quantity = $(this).find('.quantity').val();
                var price = $(this).find('.cart-price').val();
                var producttotal = parseFloat(quantity) * parseFloat(price);
                var subtotal = parseFloat(quantity) * parseFloat(price);
                total += subtotal;
                $(this).find('.product-total').text('Rp. '+formatNumber(producttotal.toString()));
            }
        });
        $('.summary-total').text('Rp. '+formatNumber(total.toString()));
        $('.summary-grandtotal').text('Rp. '+formatNumber(total.toString()));
    }

    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // console.log(xx)/
        return xx;

    }
</script>
@endpush
