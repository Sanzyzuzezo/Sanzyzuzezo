@extends('frontpage-schoko.layouts.main')

@section('content')
<div class="ec-side-cart-overlay"></div>

<div class="row">
    <div class="col-lg-12">
        <div class="single-product-cover">
            @foreach ($detail->images as $row)
                {{-- <?php echo json_encode($row) ?>
                <?php die() ?> --}}
                <img class="gambar-detail" src="{{ img_src($row->data_file, 'product') }}" alt="product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';">
            @endforeach
        </div>
        <div class="single-nav-thumb">
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <div class="col-lg-12">
            <section class="section ec-instagram-section module">
                <div class="container mx-1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="single-pro-content p-0">
                                <b class="category-product-title m-0">{{ $detail->category_name }} - {{ $detail->brand_name }}</b>
                                <div class="product-title">
                                    {{ $detail->name }}
                                </div>
                                <div class="py-2 border-bottom">
                                    @php
                                        $harga = $detail->variants[0]->price;
                                        $discount = '';
                                        if($detail->discount_price > 0 ){
                                            $harga = $detail->discount_price;
                                            $discount = $detail->discount_price;
                                        }
                                        foreach ($promotion as $data_promotion){
                                            foreach ($data_promotion->promotion_product as $data){
                                                echo "<input type='hidden' class='promotion_stock' value='$data->promotion_stock'>";
                                            }
                                        }
                                    @endphp
                                    <div class="ec-single-price-stoke border-bottom-0 m-0 p-0">
                                        <div class="ec-single-price">
                                            @if ($discount > 0 )
                                                <span class="old-price" id="old_price" style="text-decoration: line-through;">Rp.
                                                    {{ number_format($detail->variants[0]->price, 0, '.', ',') }}</span>
                                            @endif
                                            <span class="ec-price mb-0">
                                                <span class="new-price" id="price">Rp. {{ number_format($harga, 0, '.', ',') }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="my-2">
                                        <!-- TAG DISKON -->
                                        {{-- <span class="custome-flags" id="sale">
                                            <span class="diskon">SALE</span>
                                        </span> --}}
                                        @foreach ($new_products as $row)
                                            @if ($row->id == $detail->id)
                                                <!-- TAG BARU -->
                                                <span class="custome-flags">
                                                    <span class="baru">NEW</span>
                                                </span>
                                            @endif
                                        @endforeach
                                        <!-- TAG HABIS -->
                                        <span class="custome-flags {{ $detail->variants[0]->stock > 0 ? 'd-none' : ''}}" id="empty">
                                            <span class="habis">EMPTY</span>
                                        </span>
                                        <div class="stock mt-1">
                                            <button class="stock-left-list stock-left-list-detail px-3">Stock Left</button>
                                            <button id="stock" class="stock-right-list stock-right-list-detail px-3">{{ number_format($detail->stock_promo > 0 ? $detail->stock_promo :  $detail->variants[0]->stock, 0, '.', ',') }} Pcs</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="ec-pro-variation m-0 py-2">
                                    <div class="ec-pro-variation-inner ec-pro-variation-size ec-pro-size">
                                        <div class="product-title">Variations</div>
                                        <div class="ec-pro-variation-content">
                                            <table>
                                                <thead>

                                                </thead>
                                                <?php $no = 1; ?>
                                                @foreach ($detail->variants as $row)
                                                    <?php
                                                    if($no == 1){
                                                        $variant_selected = "active-variant";
                                                    }else{
                                                        $variant_selected = "";
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <span class="">
                                                                <a
                                                                    href="#"
                                                                    class="badge changeVariant {{ $variant_selected }}"
                                                                    data-ix="{{ $row->id }}"
                                                                    data-tooltip="{{ $row->name }}"
                                                                    data-stock="{{$row->stock}}"
                                                                    >{{ $row->name }}
                                                                </a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <?php $no++; ?>
                                                @endforeach

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-title my-2">Product Detail</div>
                                <div class="ec-single-desc">
                                    {!! $detail->description !!}
                                </div>
                                {{-- <div class="ec-single-qty"> --}}
                                    <input type="hidden" name="variant_id" class="variant_id" value="{{ $detail->variants[0]->id }}" />
                                    {{-- <div class="ec-single-wishlist m-0">
                                        <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                    </div>
                                    <div class="qty-plus-minus mx-2">
                                        <input class="qty-input" id="quantity" type="number" min="1" max="{{ $detail->variants[0]->stock }}" onkeypress="return hanyaAngka(event)" name="ec_qtybtn" value="1" />
                                    </div>
                                    <div class="ec-single-cart m-0">
                                        <a href="#" class="ec-btn-group add-to-cart-btn" title="Add To Cart"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@include('frontpage-schoko.products.product_recipe')

@include('frontpage-schoko.products.product_related')

<div class="ec-nav-shop ec-nav-shop-size">
    <a class="align-self-center compare" data-product_id="{{ $row->id }}" style="padding-left:20px;">
        <img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" data-product_id="{{ $row->id }}">
        Add to Wishlist
    </a>
    {{-- <a class="align-self-center">
        Share
    </a> --}}
    <a class="align-self-center add-to-cart-btn" style="padding-right:20px;">
        <img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" />
        Add to Cart
    </a>
</div>

<div class="addtocart-toast d-none">
    <div class="cart-desc">{{ __('product.add_alert') }}</div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var promotion_stock = $('.promotion_stock').val();
        if(promotion_stock > 0){
            var variant_id = $(".variant_id").val();
            $.ajax({
                type: "POST",
                url: "{{ route('catalogues.getDetailVariant') }}",
                data: ({
                    "_token": "{{ csrf_token() }}",
                    ix: variant_id,
                }),
                datatype: 'JSON',
                success: function(data) {
                    if(data.promotion_price != null){
                        var harga = data.promotion_price
                    }else{
                        var harga = data.price
                    }

                    $("#price").text("Rp. "+formatNumber(harga.toString()));

                    if(data.promotion_stock != null){
                        $("#stock").text((data.promotion_stock.toString())+" Pcs");
                    }else{
                        $("#stock").text((data.stock.toString())+" Pcs");
                    }

                    $(".variant_id").val(data.id);
                }
            });
        }

        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))

            return false;
            return true;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on("click", ".compare", function (e) {

            e.preventDefault();
            e.stopImmediatePropagation();

            let product_id = $(this).data('product_id');
            saveWishList(product_id);

        });

        function refreshToken() {
            let csrfToken = $('[name="csrf-token"]').attr('content');
            $.get('refresh-csrf').done(function(data){
                $('meta[name="csrf-token"]').attr("content", data);
            });
        }

        function saveWishList(params) {
            refreshToken();
            $(document).css("cursor", "progress");
            $.ajax({
                url: '{{ route('catalogues.wishlist') }}',
                type: 'POST',
                data: {
                    product_id: params
                },
                dataType: "JSON",
                success: function(response) {
                    $(document).css("cursor", "auto");
                    if(response.status == false) {
                        const { value: formValues } = Swal.fire({
                            toast: true,
                            title: 'Login untuk menembahkan wishlist!',
                            showCancelButton: true,
                            showConfirmButton: false,
                            width: 600,
                            html:
                                '<form id="form-login" action="#">' +
                                    '<input style="margin: 0; width: 100%; margin-bottom: 19px;" id="email" type="email" class="swal2-input">' +
                                    '<input style="margin: 0; width: 100%;" id="password" type="password" class="swal2-input">' +
                                    `<input id="product_id" value="${params}" type="hidden">` +
                                    '<br>'+
                                    '<br>'+
                                    '<button type="submit" style="margin: 0; width: 100%; border-radius: 4px;" class="btn-primary swal2-styled" aria-label="" style="display: block;">Login</button>'+
                                    '<span> or </span>'+
                                    '<button type="button" style="margin: 0; width: 100%; border-radius: 4px;" class="btn-secondary google swal2-styled" aria-label="" style="display: block;">Login by Google</button>'+
                                '</form>',
                            focusConfirm: true
                        });
                    } else {;
                        if (response.insert == true) {
                            let params = {icon: 'success', title: 'Berhasil ditambahkan ke wishlist'}
                            $('#count-cart').html(response.count)
                            showAlaret(params)
                            return false;
                        }else {
                            let params = {icon: 'warning', title: 'Produk ini sudah ditambahkan'}
                            showAlaret(params)
                            return false;
                        }
                    }
                },error: function (request, status, error) {
                    $(document).css("cursor", "auto");
                    let params = {icon: 'error', title: 'Terjadi kesalahan atau koneksi terputus'}
                    showAlaret(params);
                    return false;
                }
            });

        }

        $(document).on("click", ".google", function (e) {
            let google_url = `{{ '/auth/redirect'}}`;
            location.href = google_url;
        });

        $(document).on("submit", "#form-login", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            const user = {
                email : document.getElementById('email').value,
                password : document.getElementById('password').value,
                product_id : document.getElementById('product_id').value,
            }
            console.log(user)
            if (user.email == '' || user.password == '') {
                let params = {icon: 'error', title: 'Email atau password salah'}
                showAlaret(params);
                return false;
            } else {
                login(user)
            }
        });

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

        function login(params) {
            refreshToken();
            if (params.email == '' || params.password == '') {
                let params = {icon: 'error', title: 'Email atau password salah'}
                showAlaret(params)
                return false;
            }

            $.ajax({
                url: '{{ route('login') }}',
                type: 'POST',
                data: {
                    email: params.email,
                    password: params.password
                },
                dataType: "JSON",
                success: function(response) {
                    window.location.href = window.location.pathname + window.location.search + window.location.hash;
                    // saveWishList(params.product_id);
                },
                error: function (request, status, error) {
                    let params = {icon: 'error', title: 'Email atau password salah'}
                    showAlaret(params)
                    return false;
                }
            });

        }

        $(document).ready(function() {
            var index = 0;
            $(".prdct").each(function() {
                var another = this;

                $(this).find('.add-to-cart').off().click(function(e) {
                    e.preventDefault();
                    var variant_id = $(another).find('.variant_id').val();

                    $.ajax({
                        url: "/add-to-cart",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'variant_id': variant_id,
                            'quantity': '1'
                        },
                        success: function() {
                            let params = {icon: 'success', title: 'Berhasil ditambahkan ke keranjang'}
                            showAlaret(params)
                            cartload()
                        }
                    });
                    console.log(variant_id);
                });

            });

            $(document).on('click', '.quickview-product', function(event) {
                var ix = $(this).data('ix');
                $.ajax({
                    type: "POST",
                    url: "{{ route('catalogues.getDetail') }}",
                    data: ({
                        "_token": "{{ csrf_token() }}",
                        ix: ix,
                    }),
                    success: function(data) {
                        var slide_image = "";
                        slide_image +=
                            '<div class="qty-slide"><img class="img-responsive" src="{{ route('catalogues') }}" alt=""></div>';
                        $('.ec-quick-title').html(data.name);
                        console.log()
                        $('#ec_quickview_modal').modal('show');
                    }
                });
            });

            $(document).on('click', '.changeVariant', function(event) {
                event.preventDefault();
                var ix = $(this).data('ix');
                $(".changeVariant").removeClass("active-variant");
                $(this).addClass("active-variant");
                var promotion_stock = $('.promotion_stock').val();
                if(promotion_stock > 0){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('catalogues.getDetailVariant') }}",
                        data: ({
                            "_token": "{{ csrf_token() }}",
                            ix: ix,
                        }),
                        datatype: 'JSON',
                        success: function(data) {
                            old_price = 0;
                            if(data.promotion_price != null){
                                var harga = data.promotion_price
                                var old_price = data.price
                            }else{
                                var harga = data.price
                            }
                            $('#old_price').text("Rp. "+formatNumber(old_price.toString()))
                            $("#price").text("Rp. "+formatNumber(harga.toString()));

                            if(data.promotion_stock != null){
                                $("#stock").text((data.promotion_stock.toString())+" Pcs");
                            }else{
                                $("#stock").text((data.stock.toString())+" Pcs");
                            }

                            $(".variant_id").val(data.id);
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

            $('.add-to-cart-btn').click(function (e) {
                e.preventDefault();

                var variant_id = $('.variant_id').val();
                var quantity = 1;
                let stock = $('#stock').text();

                if (quantity <= 0) {
                    let params = {icon: 'warning', title: 'Silahkan masukan jumlah !'}
                    showAlert(params)
                    return false;
                }

                if (parseInt(quantity) > parseInt(stock)) {
                    let params = {icon: 'warning', title: 'Melebihi batas stok !'}
                    showAlert(params)
                    return false;
                }

                $.ajax({
                    url: "/add-to-cart",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'variant_id': variant_id,
                        'quantity': 1
                    },
                    success: function() {
                        let params = {icon: 'success', title: 'Berhasil ditambahkan ke keranjang'}
                        showAlaret(params)
                        cartload()
                    }
                });
            });
        });

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // console.log(xx)/
            return xx;

        }
    </script>
@endpush

@push("styles")
<style>
.active-variant{
    background-color: #fbcd0a !important;
}

.single-pro-content .ec-single-desc p{
    margin-bottom: 12px;
    color: #777;
    font-size: 14px;
    letter-spacing: 0;
    word-break: break-all;
    line-height: 1.7;
    font-family: "Montserrat";
    font-weight: normal;
}
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
</style>
@endpush
