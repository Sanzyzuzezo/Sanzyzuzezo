@extends('frontpage-schoko.layouts.main')

@section('content')
    <div class="ec-style ec-right-top">
        <div class="ec-right-top" style="display:none;">
            @foreach ($banners_kanan as $kanan)
            <div class="ec-box">
                <img class="gambar-banner-kanan" src="{{ asset_administrator('assets/media/banners/' . $kanan->image) }}" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';" style="border-radius: 16px;">
            </div>
            @endforeach
        </div>
    </div>

    <div class="sticky-header-next-sec ec-main-slider section">
        <div class="ec-slider swiper-container main-slider-nav main-slider-dot">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="ec-slide-item swiper-slide d-flex bg-white" style="overflow-x:hidden;" >
                        <div class="align-self-center">
                            <div class="row" style="width: 100%;">
                                <div style="height: 360px; width: 600px; position: relative; top: 73px; margin-left: -10px; background-size: auto; background-position: center center; background-repeat: no-repeat; background-image: url({{ asset_administrator('assets/media/banners/' . $banner->image) }});">
                                </div>
                            </div>
                            <div class="row text-banner">
                                <div class="col-2 banner-title text-uppercase">
                                    <label>{{ $banner->title }}</label>
                                </div>
                                <div class="col-auto banner-caption">
                                    {{ $banner->caption }}
                                    <div class="banner-description">{{ $banner->description }}</div>
                                    @if($banner->date != null && $banner->date != '0000-00-00')
                                        <div class="banner-date">{{ date('d M Y', strtotime($banner->date)) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <div class="section-title">
                                            <h2 class="ec-bg-title p-0">Recipe & Tips</h2>
                                            <h2 class="ec-title p-0">Recipe & Tips</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination swiper-pagination-white"></div>
            <div class="swiper-buttons">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>

    <div class="separator"></div>

    @include('frontpage-schoko.home.product_list')

   <!--  <section class="ec-page-content section-space-p ec-fre-spe-section">
        <div class="container">
            <div class="row">
                <div class="ec-shop-leftside col-lg-12 order-lg-first col-md-12 order-md-last">
                    <div class="ec-sidebar-heading">
                        <h1>{{ __('home.filter') }}</h1>
                    </div>
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title pb-3 pb-lg-0">
                                <h3 class="ec-sidebar-title">{{ __('home.category') }}</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    @foreach ($categories as $row)
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" name="category[]" value="{{ $row->id }}"
                                                    class="filter_categories">
                                                <label class="ml-5 mb-0">{{ $row->name }}</label>
                                                <span class="checked"></span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <div class="separator"></div>

    <!-- resep -->
    @include('frontpage-schoko.home.recipe')
    <!-- end resep -->

    <div class="separator"></div>

    <div class="sticky-header-next-sec ec-main-slider section" style="padding:30px;">
        <div class="ec-slider swiper-container main-slider-nav main-slider-dot" style="border-radius: 16px; max-height: 120px;">
            <div class="swiper-wrapper">
                @foreach ($banners_bawah as $bawah)
                    <div class="ec-slide-item d-flex"
                        style="background-repeat: no-repeat; background-image: url({{ asset_administrator('assets/media/banners/' . $bawah->image) }}); background-size: cover; background-position: center center; max-height: 120px; border-radius: 16px;">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="separator"></div>

@endsection

@push('scripts')
<style>
    .active-variant{
    background-color: #fbcd0a !important;
}
</style>

    <script type="text/javascript">
        var SelectedVariant = null;
        var date = $("#time").text();
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

        document.getElementById("promo-time").innerHTML = hours + ":"
        + minutes + ":" + seconds;

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("promo-time").innerHTML = "EXPIRED";
            location.reload();
        }
        }, 1000);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var SelectedVariant2 = null;
        var date2 = $("#time2").text();
        var countDownDate2 = new Date(date2).getTime();

        var x2 = setInterval(function() {

        var now = new Date().getTime();

        var distance2 = countDownDate2 - now;

        var hours2 = Math.floor((distance2 / (1000 * 60 * 60)));
        var minutes2 = Math.floor((distance2 % (1000 * 60 * 60)) / (1000 * 60));
        var seconds2 = Math.floor((distance2 % (1000 * 60)) / 1000);

        if (hours2 < 10) {
            hours2 = `0${hours2}`;
        }
        if (minutes2 < 10) {
            minutes2 = `0${minutes2}`;
        }
        if (seconds2 < 10) {
            seconds2 = `0${seconds2}`;
        }

        document.getElementById("promo-time2").innerHTML = hours2 + ":"
        + minutes2 + ":" + seconds2;

        if (distance2 < 0) {
            clearInterval(x);
            document.getElementById("promo-time2").innerHTML = "EXPIRED";
            location.reload();
        }
        }, 1000);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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
