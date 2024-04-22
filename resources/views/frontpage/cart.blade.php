@extends('frontpage.layouts.main')
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

    @media only screen and (max-width: 767px){
        .ec-cart-content .table-content table thead {
            position: initial !important;
        }
        .n-chk{
            display: none !important;
        }
        .chk-mbl{
            display: block !important;
        }
    }
</style>
@endpush
@section('content')
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
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

<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <?php
            //dd($cart_data);
            ?>
            @if (isset($cart_data))
            {{-- @if (Cookie::get('shopping_cart')) --}}
            @php $total="0" @endphp
            <div class="ec-cart-leftside col-lg-8 col-md-12 ">
                <div class="ec-cart-content">
                    <div class="ec-cart-inner">
                        <div class="row">
                            <form action="#">
                                <div class="table-content cart-table-content">
                                    <table>
                                        @if(count($cart_data) != 0)
                                        <thead>
                                            <tr>
                                                <th class="n-chk" style="width: 30px;"><input type="checkbox" value="" id="checkall" style="width: 17px !important; width: 30px;"></th>
                                                <th class="n-chk">{{ __('cart.Product') }}</th>
                                                <th class="n-chk">{{ __('cart.Price') }}</th>
                                                <th class="n-chk" style="text-align: center;">{{ __('cart.Quantity') }}</th>
                                                <th class="n-chk">{{ __('cart.Total') }}</th>
                                                <th class="n-chk" style="width: 5%;"></th>
                                                <th class="chk-mbl d-none"><input type="checkbox" value="" id="checkall" style="width: 17px !important; width: 30px;"> <label for="checkall" class="m-0 px-3" style="vertical-align: top; padding-top: 14px;">All</label></th>
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
                                                $data->discount_price > 0 ? $harga = $data->discount_price : $harga = $data->price;
                                                if (isset(auth()->user()->customer_group_id) && auth()->user()->customer_group_id > 0) {
                                                    foreach ($discount_customer as $dc) {
                                                        $discount_brand = json_decode($dc->discount);
                                                        foreach ($discount_brand as $brand) {
                                                            if ($data->brand_id === $brand->id) {
                                                                $harga_normal = $data->price;
                                                                $harga_normal_diskon = $data->discount_price;
                                                                $potongan = ($data->price * $brand->discount) / 100;
                                                                $fix_customer_discount = $data->price - $potongan;
                                                                if ($fix_customer_discount < $data->discount_price) {
                                                                    $harga = $fix_customer_discount;
                                                                } else {
                                                                    if ($data->discount_price > 0) {
                                                                        $data->discount_price > 0 ? $harga = $data->discount_price : $harga = $data->price;
                                                                    } else {
                                                                        $harga = $fix_customer_discount;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $data->discount_price > 0 ? $harga = $data->discount_price : $harga = $data->price;
                                                }
                                                $subtotal += $harga * $qty;
                                            @endphp
                                            <tr class="cart-list">
                                                <td>
                                                    <input type="checkbox" id="chck" value="" class="chck" style="width: 17px !important;">
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-row">
                                                        <div><img class="ec-cart-pro-img" src="{{ img_src($data->image, "product") }}" alt="" /></div>
                                                        <div class="d-flex justify-content-start flex-column p-2">
                                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">{{ strlen($data['name']) > 17 ? substr($data['name'], 0, 17).'...' : $data['name'] }}</a>
                                                            <small>{{ $data['variant'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="ec-cart-pro-price"><span class="amount">{{ number_format($harga) }}</span></td>
                                                <td class="ec-cart-pro" style="text-align: center;">
                                                    <div class="cart-qty-plus-minus">
                                                        <input class="cart-plus-minus changeQuantity quantity" type="number" min="1" onkeypress="return hanyaAngka(event)" name="cartqtybutton" value="{{ $qty }}" />
                                                    </div>
                                                    <span style="display: none; font-size: 0.7rem; color: red;">Out of Stock</span>
                                                    <input type="hidden" class="stock" value="{{ $data->stock }}">
                                                </td>
                                                <td class="product-total">{{ number_format($harga*$qty) }}</td>
                                                <td>
                                                    <input type="hidden" class="variant_id cart-variant_id" value="{{ $data['variant_id'] }}" />
                                                    <input type="hidden" class="cart-price" value="{{ $harga }}" />
                                                    <a href="#" class="deleteCart"><i class="ecicon eci-trash-o"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="ec-cart-update-bottom">
                                            <a href="{{ route('catalogues') }}">{{ __('cart.Continue_Shopping') }}</a>
                                            <a href="#" class="btn btn-primary d-none" id="button_checkout">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-cart-rightside col-lg-4 col-md-12">
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
                                        <span class="text-right summary-total">0</span>
                                    </div>
                                    <div class="ec-cart-summary-total">
                                        <span class="text-left">Total Amount</span>
                                        <span class="text-right summary-grandtotal">0</span>
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
            $('.summary-total').text(formatNumber(total.toString()));
            $('.summary-grandtotal').text(formatNumber(total.toString()));
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
            $('.summary-total').text(formatNumber(total.toString()));
            $('.summary-grandtotal').text(formatNumber(total.toString()));
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

    function resetCount() {
        total = 0;
        $(".cart-list").each(function() {
            if ($(this).find('.chck').is(":checked")) {
                var quantity = $(this).find('.quantity').val();
                var price = $(this).find('.cart-price').val();
                var producttotal = parseFloat(quantity) * parseFloat(price);
                var subtotal = parseFloat(quantity) * parseFloat(price);
                total += subtotal;
                $(this).find('.product-total').text(formatNumber(producttotal.toString()));
            }
        });
        $('.summary-total').text(formatNumber(total.toString()));
        $('.summary-grandtotal').text(formatNumber(total.toString()));
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

                if((parseInt(quantity) + 1) > stock){
                    $(this).parent().next().css("display", "block");
                    return;
                } else {
                    $(this).parent().next().css("display", "none");
                }

                var subtotal = parseFloat(quantity) * parseFloat(price);

                $(another).find('.product-total').text(formatNumber(subtotal.toString()));

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

                $(another).find('.product-total').text(formatNumber(subtotal.toString()));
                
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

    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // console.log(xx)/
        return xx;

    }
</script>
@endpush
