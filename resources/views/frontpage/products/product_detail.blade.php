@extends('frontpage.layouts.main')

@section('content')
    <div class="ec-side-cart-overlay"></div>

    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ __('product.Product_Detail') }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route("home") }}">{{ __('product.Home') }}</a></li>
                                <li class="ec-breadcrumb-item"><a href="{{ route("catalogues") }}">{{ __('product.Catalogues') }}</a></li>
                                <li class="ec-breadcrumb-item active">{{ $detail->name }}</li>
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
                <div class="ec-pro-rightside ec-common-rightside col-lg-9 order-lg-last col-md-12 order-md-first">
                    <div class="single-pro-block">
                        <div class="single-pro-inner">
                            <div class="row">
                                <div class="single-pro-img">
                                    <div class="single-product-scroll">
                                        <div class="single-product-cover">

                                            @foreach ($detail->images as $row)
                                                <div class="single-slide zoom-image-hover">
                                                    <img class="img-responsive"
                                                        src="{{ img_src($row->data_file, 'product') }}" alt="">
                                                </div>
                                            @endforeach

                                        </div>
                                        <div class="single-nav-thumb">
                                            @foreach ($detail->images as $row)
                                                <div class="single-slide zoom-image-hover">
                                                    <img class="img-responsive"
                                                        src="{{ img_src($row->data_file, 'product') }}" alt="">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="single-pro-desc">
                                    <div class="single-pro-content">
                                        <span>{{ $detail->category_name }} - {{ $detail->brand_name }}</span>
                                        <h5 class="ec-single-title">{{ $detail->name }}</h5>
                                        <div class="ec-single-desc">{!! $detail->description !!}
                                        </div>
                                        <div class="ec-single-price-stoke border-bottom-0">
                                            <div class="ec-single-price">
                                                <span class="ec-single-ps-title">{{ __('product.Price') }}</span>
                                                @php
                                                    $harga = $detail->variants[0]->price;
                                                    if ($detail->variants[0]->discount_price > 0 ) {
                                                        $harga = $detail->variants[0]->discount_price;
                                                    }
                                                @endphp

                                                @if ($detail->variants[0]->discount_price > 0 )
                                                    <span class="old-price" id="old_price" style="text-decoration: line-through;">Rp.
                                                        {{ number_format($detail->variants[0]->price, 0, '.', ',') }}</span>
                                                @endif

                                                <span class="new-price" id="price">Rp.
                                                    {{ number_format($harga, 0, '.', ',') }}</span>
                                            </div>
                                            <div class="ec-single-stoke">
                                                <span class="ec-single-ps-title">{{ __('product.Stock') }}</span>
                                                <span
                                                    class="ec-single-sku" id="stock">{{ number_format($detail->variants[0]->stock, 0, '.', ',') }}</span>
                                            </div>
                                        </div>
                                        <div class="ec-pro-variation">
                                            <div class="ec-pro-variation-inner ec-pro-variation-size ec-pro-size">
                                                <span>Variations</span>
                                                <div class="ec-pro-variation-content">
                                                    <table>
                                                        <thead>

                                                        </thead>
                                                        <?php $no = 1; ?>
                                                        @foreach ($detail->variants as $row)
                                                        @if ($row->stock > 0)
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
                                                                            class="badge bg-light text-secondary changeVariant {{ $variant_selected }}"
                                                                            data-ix="{{ $row->id }}"
                                                                            data-tooltip="{{ $row->name }}"
                                                                            data-stock="{{$row->stock}}"
                                                                            >{{ $row->name }}
                                                                        </a>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <?php $no++; ?>
                                                        @endif
                                                        @endforeach

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-single-qty border-bottom-0">
                                            <input type="hidden" name="variant_id" class="variant_id" value="{{ $detail->variants[0]->id }}" />
                                            <div class="qty-plus-minus">
                                                <input class="qty-input" id="quantity" type="number" min="1" max="{{ $detail->variants[0]->stock }}" onkeypress="return hanyaAngka(event)" name="ec_qtybtn" value="1" />
                                            </div>
                                            <div class="ec-single-cart">
                                                <button class="add-to-cart-btn btn btn-primary">{{ __('product.Add_To_Cart') }}</button>
                                            </div>
                                            <div class="ec-single-wishlist">
                                                <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ec-pro-leftside ec-common-leftside col-lg-3 order-lg-first col-md-12 order-md-last">
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">{{ __('product.Category') }}</h3>
                            </div>
                            @foreach($categories as $category)
                            <div class="ec-sb-block-content">
                                <ul>
                                    <li>
                                        <div class="ec-sidebar-block-item"><a href="{{ route("category_detail",$category->id) }}">{{ $category->name }}</a></div>
                                        <ul style="display: block;">
                                            @foreach($category->childCategories as $sub)
                                            <li>
                                                <div class="ec-sidebar-sub-item"><a href="{{ route("category_detail",$sub->id) }}">{{ $sub->name }}<span></span></a>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section ec-releted-product section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">{{ __('product.Related_products') }}</h2>
                        <h2 class="ec-title">{{ __('product.Related_products') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row margin-minus-b-30">
                @foreach($related_products as $row)
                @if ($row->total_stock > 0)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content prdct">
                    <div class="ec-product-inner product_data">
                        <div class="ec-pro-image-outer">
                            <div class="ec-pro-image">
                                <a href="{{ route('catalogues.detail', $row->id) }}">
                                    <img class="main-image" src="{{ img_src($row->data_file, 'product') }}" alt="Product" />
                                </a>
                                @if ($row->total_stock > 0)
                                    <a title="Add To Cart" class="quickview add-to-cart"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                    <div class="ec-pro-actions">
                                        <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                    </div>
                                @else
                                    <span class="flags">
                                        <span style="background-color: red;" class="sale">{{ __('product.empty') }}</span>
                                    </span>
                                @endif
                                <input type="hidden" name="variant_id" class="variant_id" value="{{ $row->variant_id }}" />
                                {{-- <span class="percentage">20%</span> --}}
                            </div>
                        </div>
                        <div class="ec-pro-content">
                            <span>{{ $row->category_name }}</span>
                            <h5 class="ec-pro-title"><a href="{{ route('catalogues.detail', $row->id) }}">{{ $row->name }}</a></h5>
                            <div class="ec-pro-list-desc">{!! $row->description !!}</div>
                            <span class="ec-price">
                                {{-- <span class="old-price">Rp. 25.000</span> --}}
                                <span class="new-price">Rp.
                                    {{ $row->total_variant > 1 && $row->min_price != $row->max_price? number_format($row->min_price, 0, '.', ',') . ' - ' . number_format($row->max_price, 0, '.', ','): number_format($row->price, 0, '.', ',') }}</span>
                            </span>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
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
            // console.log(user)
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
                    // console.log(variant_id);
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
                        $('#ec_quickview_modal').modal('show');
                    }
                });
            });

            $(document).on('click', '.changeVariant', function(event) {
                event.preventDefault();
                var ix = $(this).data('ix');
                $(".changeVariant").removeClass("active-variant");
                $(this).addClass("active-variant");
                $.ajax({
                    type: "POST",
                    url: "{{ route('catalogues.getDetailVariant') }}",
                    data: ({
                        "_token": "{{ csrf_token() }}",
                        ix: ix,
                    }),
                    datatype: 'JSON',
                    success: function(data) {
                        let harga = data.price
                        if (data.discount_price > 0) {
                            harga = data.discount_price
                            $('#old_price').text("Rp. "+formatNumber(data.price.toString()));
                        } else {
                            $('#old_price').text("");
                        }
                        $("#price").text("Rp. "+formatNumber(harga.toString()));
                        $("#stock").text((data.stock.toString()));
                        $(".variant_id").val(data.id);
                    }
                });
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
                var quantity = $('#quantity').val();
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
                        'quantity': quantity
                    },
                    success: function() {
                        $("#stock").text(parseInt(stock) - parseInt(quantity));
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
    background-color: #EDD20D !important;
    color: #000 !important;
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
