@extends('frontpage-schoko.layouts.main')

@section('content')

@foreach($promotion as $data)
    <div class="container my-4 promotion_data">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12" id="tag_container">
                <div class="d-flex justify-content-between section-text-title">
                    <div class="section-title m-0">
                        <h2 class="ec-bg-title p-0">{{ $data->title }}</h2>
                        <h2 class="ec-title p-0">{{ $data->title }}</h2>
                    </div>
                    @if($data->start_date < date("Y-m-d H:i:s"))
                        <div class="section-title m-0">
                            <label class="product-title text-uppercase mx-2">Ends In</label>
                            <p class="d-none time">{{ $data->end_date }}</p>
                            <p class="ec-title p-0 promo-time"></p>
                        </div>
                    @else
                        <div class="section-title m-0">
                            <label class="product-title text-uppercase mx-2">Coming Soon</label>
                        </div>
                    @endif
                </div>
                @foreach ($flash_sale as $row)
                    @if ($data->id == $row->promotion_id && $row->promotion_stock > 0)
                        <div class="section ec-catalog-multi-vendor">
                            <div class="container">
                                <div class="row">
                                    <div class="ec_cat_content prdct">
                                        <div class="ec-product-inner" style="margin-top:20px;">
                                            <div class="row-custom" style="vertical-align:middle;">
                                                <div class="row-column">
                                                    <div class="ec-pro-image custom-image" style="margin: auto;">
                                                        <a href="{{ route('catalogues.detail', $row->id) }}">
                                                            <img class="custom-size" src="{{ $row->image != null ? img_src($row->image, 'product') : img_src('default.jpg', '') }}" alt="Product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';">
                                                        </a>
                                                        <!-- TAG DISKON -->
                                                        <span class="custome-flags">
                                                            <span class="diskon">SALE</span>
                                                        </span>
                                                        @if ($row->total_stock > 0)
                                                            <a title="Add To Cart" class="quickview getVariant" data-product_id="{{ $row->id }}"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            <div class="ec-pro-actions">
                                                                <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            </div>
                                                        @else
                                                            <!-- TAG HABIS -->
                                                            <span class="custome-flags">
                                                                <span class="habis">EMPTY</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row-column">
                                                    <div class="product-info">
                                                    <div class="ec-pro-content pt-0">
                                                        <b class="category-product-title m-0">{{ $row->category }}</b>
                                                        <div class="product-title mb-2">
                                                            <a href="{{ route('catalogues.detail', $row->id) }}">{{Str::limit($row->name, 38, $end='...')}}</a>
                                                        </div>
                                                        @if($data->start_date < date("Y-m-d H:i:s"))
                                                            @php
                                                                $minimal = $row->min_price;
                                                                $maximal = $row->max_price;
                                                                $harga = $row->price;

                                                                if ($row->min_discount_price !=null && $row->min_discount_price < $row->min_price)
                                                                    $minimal = $row->min_discount_price;

                                                                if ($row->min_discount_price !=null && $row->max_discount_price < $row->max_price)
                                                                    $maximal = $row->max_discount_price;

                                                                if ($row->after_discount_price > 0)
                                                                    $harga = $row->after_discount_price;

                                                                // if ($row->after_discount_price != null)
                                                                    // $maximal = $row->max_price;
                                                            @endphp
                                                            <span class="ec-price mb-0">
                                                                @if ($row->min_discount_price > 0 || $row->max_discount_price > 0)
                                                                    <span class="old-price">Rp.
                                                                        {{ $row->total_variant > 1 && $row->min_price != $row->max_price ? number_format($row->min_price, 0, '.', ',') . ' - ' . number_format($row->max_price, 0, '.', ',') : number_format($row->price, 0, '.', ',') }}
                                                                    </span>
                                                                @endif
                                                            </span>
                                                            <span class="ec-price mb-0">
                                                                <a href="{{ route('catalogues.detail', $row->id) }}">
                                                                    <span class="new-price" style="color:#7F3C1A">
                                                                        Rp. {{ $row->total_variant > 1 ? number_format($minimal, 0, '.', ',') . ' - ' . number_format($maximal, 0, '.', ',') : number_format($harga, 0, '.', ',') }}
                                                                    </span>
                                                                </a>
                                                            </span>
                                                        @else
                                                            <span class="ec-price mb-0">
                                                                <a href="{{ route('catalogues.detail', $row->id) }}">
                                                                    <span class="new-price" style="color:#7F3C1A">
                                                                        Rp. ???
                                                                    </span>
                                                                </a>
                                                            </span>
                                                        @endif
                                                        <input type="hidden" name="variant_id" class="variant_id" value="{{ $row->variant_id }}" />
                                                        <br>
                                                    </div>

                                                    <div class="row-stock">
                                                        <div class="stock">
                                                            <button class="stock-left-list">Stock Left</button>
                                                            <button class="stock-right-list">{{ number_format($row->total_stock, 0, '.', ',') }} Pcs</button>
                                                        </div>
                                                            <button type="button" class="getVariant button-round" data-product_id="{{ $row->id }}" {{ $row->total_stock <= 0 ? 'disabled' : '' }} >+</button>
                                                    </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endforeach

@endsection

@push('scripts')
    <style>
        .active-variant{
        background-color: #fbcd0a !important;
    }
    </style>
    <script type="text/javascript">
        $('.promotion_data').each(function() {
            var another = this;
            var date = $(this).find(".time").text();
            var countDownDate = new Date(date).getTime();

            var x = setInterval(function() {

                var now = new Date().getTime();

                var distance = countDownDate - now;

                var hours = Math.floor((distance / (1000 * 60 * 60)));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (hours < 10) {
                    hours = `0${hours}`;
                }
                if (minutes < 10) {
                    minutes = `0${minutes}`;
                }
                if (seconds < 10) {
                    seconds = `0${seconds}`;
                }

                $(another).find(".promo-time").text(hours + ":" + minutes + ":" + seconds);

                if (distance < 0) {
                    clearInterval(x);
                    $(another).find(".promo-time").text("EXPIRED");
                    location.reload();
                }

            }, 1000);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).on('click', '.detail-click', function (e) {
            e.preventDefault();
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
                icon: 'warning',
                title: 'Out of stock'
            });
        });
        $(document).ready(function() {
            $(document).on('click', '.filter_categories', function(event) {
                getData()
            });

            var index = 0;
            $(".prdct").each(function() {
                var another = this;

                $(this).find('.add-to-cart-btn').off().click(function(e) {
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
        });

        $(document).on("click", ".getVariant", function (e) {

            e.preventDefault();
            e.stopImmediatePropagation();

            let product_id = $(this).attr('data-product_id');
            getVariant(product_id);

        });

        function getVariant(params) {
            $(document).css("cursor", "progress");
            $.ajax({
                url: '{{ route('addVariant') }}',
                type: 'POST',
                data: {
                    product_id: params
                },
                dataType: "JSON",
                success: function(response) {
                    var html = '';
                    let count = 0;
                    $.each( response, function(key, item){
                        count++;
                        html += `<tr>` + `<td>` + `<span>` + `<a href="#" class="badge changeVariant variant_id" data-ix="${item.id}" data-price="${item.harga}"> ` + item.name + `</a>` + `</span>` + `</td>` +`</tr>`;
                    });
                    $(document).css("cursor", "auto");
                    if(count > 1) {
                        const { value: formValues } = Swal.fire({
                            toast: true,
                            title: 'Pilih Variant',
                            showCancelButton: true,
                            showConfirmButton: false,
                            width: 600,
                            html:
                                '<form id="form-variant" action="#">' +
                                    '<div class="d-flex justify-content-between align-items-center">'+
                                    '<div> <table> '+html+' </table> </div>' +
                                    `<div style="font-size: 16px;"> Rp. <span id="variantPrice"> </span> </div>`+
                                    '</div>' +
                                    `<input id="product_id" value="${params}" type="hidden">` +
                                    '<br>'+
                                    '<button type="submit" style="margin: 0; width: 100%; border-radius: 4px;" class="btn-primary swal2-styled" aria-label="" style="display: block;">Add To Cart</button>'+
                                '</form>',
                            focusConfirm: true
                        });
                        selectFirstVariant();
                    } else {
                        $.ajax({
                            url: "/add-to-cart",
                            method: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'variant_id': response[0].id,
                                'quantity': '1'
                            },
                            success: function() {
                                let params = {icon: 'success', title: 'Berhasil ditambahkan ke keranjang'}
                                showAlaret(params)
                                cartload()
                            }
                        });

                    }
                },error: function (request, status, error) {
                    $(document).css("cursor", "auto");
                    let params = {icon: 'error', title: 'Terjadi kesalahan atau koneksi terputus'}
                    showAlaret(params);
                    return false;
                }
            });

        }

        $(document).on('click', '.changeVariant', function(event) {
            event.preventDefault();
            var ix = $(this).data('ix');
            console.log(ix);
            $(".changeVariant").removeClass("active-variant");
            $(this).addClass("active-variant");
            SelectedVariant = ix;
            $("#variantPrice").text(formatNumber($(this).data('price').toString()));
        });

        function selectFirstVariant(){
            var firstVariant = $(".changeVariant:first");
            firstVariant.addClass("active-variant");
            SelectedVariant = firstVariant.data('ix');
            $("#variantPrice").text(formatNumber(firstVariant.data('price').toString()));
        }

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // console.log(xx)/
            return xx;
        }

        $(document).on("submit", "#form-variant", function (e) {
            // var another = this;
            // console.log(this);
            var another = this;
            e.preventDefault();
            e.stopImmediatePropagation();
            const user = {
                product_id : document.getElementById('product_id').value,
            }

            e.preventDefault();
            // var variant_id = $('.select-variant').find(":selected").val();
            var variant_id = SelectedVariant;
            console.log(variant_id);

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
        });

        function getData(page) {
            var categories = getCategory();
            $.ajax({
                url: "",
                type: 'GET',
                data: {
                    categories: categories
                },
                datatype: 'HTML',
            }).done(function(data) {
                $('#tag_container').empty().html(data);
                location.hash = page;
                callSlider();
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });

            function getCategory() {
                var filter = [];
                $('.filter_categories:checked').each(function() {
                    filter.push($(this).val());
                });
                return filter;
            }
        }

        function callSlider() {
            $('.ec-catalog-multi-vendor .ec-multi-vendor-slider').slick({
                rows: 1,
                dots: false,
                arrows: true,
                infinite: true,
                speed: 500,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToScroll: 2,
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToScroll: 2,
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 425,
                    settings: {
                        slidesToScroll: 1,
                        slidesToShow: 1,
                    }
                }
                ]
            });
        }
    </script>

    <script>
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
    </script>

@endpush
