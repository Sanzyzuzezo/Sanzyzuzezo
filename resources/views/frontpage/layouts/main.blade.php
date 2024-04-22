<!DOCTYPE html>
<html lang="en">

<head>
    @php $navbar = Layout::getLayout() @endphp
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $navbar['settings']['site_name'] }} @yield('title')</title>
    <meta name="keywords" content="apparel, catalog, clean, ecommerce, ecommerce HTML, electronics, fashion, html eCommerce, html store, minimal, multipurpose, multipurpose ecommerce, online store, responsive ecommerce template, shops" />
    <meta name="description" content="Best ecommerce html template for single and multi vendor store.">
    <meta name="author" content="ashishmaraviya">
    <!-- site Favicon -->
    <link rel="icon" href="{{ img_src($navbar['settings']['favicon'], "favicon") }}" sizes="32x32" />

    <link rel="apple-touch-icon" href="{{ img_src($navbar['settings']['favicon'], "favicon") }}" />
    <meta name="msapplication-TileImage" content="{{ img_src($navbar['settings']['favicon'], "favicon") }}" />

    <!-- css Icon Font -->
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/vendor/ecicons.min.css') }}" />

    <!-- css All Plugins Files -->
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/plugins/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/plugins/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/plugins/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/plugins/countdownTimer.css') }}" />
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/plugins/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/plugins/nouislider.css') }}" />
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/plugins/bootstrap.css') }}" />
    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset_frontpage('assets/css/backgrounds/bg-4.css') }}">

    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/demo1.css') }}" />
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset_frontpage('assets/css/responsive.css') }}" />

    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset_frontpage('assets/css/backgrounds/bg-4.css') }}">

    <style>
        .ec-fre-spe-section .slick-arrow {
            top: 45% !important;
        }

        .cart-qty-plus-minus {
            border: 1px solid #ededed;
            height: 35px;
            overflow: hidden;
            padding: 0;
            position: relative;
            width: 84px;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            justify-content: space-between;
            margin: 0 auto;
        }

        tr td .cart-qty-plus-minus input {
            background: transparent none repeat scroll 0 0;
            border: medium none;
            color: #444444;
            float: left;
            font-size: 14px;
            height: auto;
            margin: 0;
            padding: 0;
            text-align: center;
            width: 40px;
            outline: none;
            font-weight: 600;
            line-height: 38px;
        }

        .cart-qty-plus-minus .ec_cart_qtybtn {
            color: #444444;
            float: left;
            font-size: 20px;
            height: auto;
            margin: 0;
            padding: 0;
            width: 40px;
            height: 38px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .cart-qty-plus-minus .ec_qtybtn {
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0;
            color: #444444;
            height: 19px;
            position: relative;
        }
        .cart-qty-plus-minus .inc.ec_qtybtn:before {
            padding-top: 4px;
            content: "";
        }
        tr td .cart-qty-plus-minus .dec.ec_qtybtn:before {
            padding-bottom: 4px;
            content: "";
        }
        tr td .cart-qty-plus-minus .ec_qtybtn:before {
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            cursor: pointer;
            font-size: 20px;
            color: #444444;
            height: 19px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            content: "";
            font-family: "EcIcons";
            overflow: hidden;
        }
        tr td.ec-cart-pro-remove a {
            font-size: 22px;
        }
        .ec-cart-update-bottom {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 30px 0 0;
        }
        .ec-cart-update-bottom > a {
            color: #444444;
            display: inline-block;
            text-decoration: underline;
            font-size: 15px;
            line-height: 20px;
            font-weight: 500;
            letter-spacing: 0.8px;
        }
        .ec-cart-update-bottom .btn {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: 40px;
            line-height: 40px;
            text-align: center;
            font-size: 16px;
            font-weight: 500;
            text-transform: uppercase;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            min-width: 150px;
        }
        .blog-image{
            object-fit: cover;
            height: 230px;
            width: 100%
        }

    </style>

    @stack('style')
    @stack('styles')
</head>

<body>
    <div id="ec-overlay" style="background-color: #9a9a9b26">
        <span class="loader_img" style="background-color: #9a9a9b26"></span>
    </div>

    @include('frontpage.layouts.header', ['navbar' => $navbar])

    @yield('content')

    @include('frontpage.layouts.footer', ['navbar' => $navbar])

    <div class="modal fade" id="ec_quickview_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close qty_close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="qty-product-cover">


                            </div>
                            <div class="qty-nav-thumb">

                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="quickview-pro-content">
                                <h5 class="ec-quick-title"><a href="product-detail.html">Handbag leather purse for
                                        women</a>
                                </h5>
                                <div class="ec-quickview-desc">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                                    since the 1500s,</div>
                                <div class="ec-quickview-price">
                                    <span class="old-price">$100.00</span>
                                    <span class="new-price">$80.00</span>
                                </div>

                                <div class="ec-pro-variation">
                                    <div class="ec-pro-variation-inner ec-pro-variation-color">
                                        <span>Color</span>
                                        <div class="ec-pro-color">
                                            <ul class="ec-opt-swatch">
                                                <li><span style="background-color:#ebbf60;"></span></li>
                                                <li><span style="background-color:#75e3ff;"></span></li>
                                                <li><span style="background-color:#11f7d8;"></span></li>
                                                <li><span style="background-color:#acff7c;"></span></li>
                                                <li><span style="background-color:#e996fa;"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="ec-pro-variation-inner ec-pro-variation-size ec-pro-size">
                                        <span>Size</span>
                                        <div class="ec-pro-variation-content">
                                            <ul class="ec-opt-size">
                                                <li class="active"><a href="#" class="ec-opt-sz"
                                                        data-tooltip="Small">S</a></li>
                                                <li><a href="#" class="ec-opt-sz" data-tooltip="Medium">M</a></li>
                                                <li><a href="#" class="ec-opt-sz" data-tooltip="Large">X</a></li>
                                                <li><a href="#" class="ec-opt-sz" data-tooltip="Extra Large">XL</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="ec-quickview-qty">
                                    <div class="qty-plus-minus">
                                        <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                                    </div>
                                    {{-- <div class="ec-quickview-cart ">
                                        <button class="btn btn-primary"><img src="assets/images/icons/cart.svg"
                                                class="svg_img pro_svg" alt="" /> Add To Cart</button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ec-nav-toolbar">
        <div class="container">
            <div class="ec-nav-panel">
                <div class="ec-nav-panel-icons">
                    <a href="#ec-mobile-menu" class="navbar-toggler-btn ec-header-btn ec-side-toggle"><img
                            src="{{ asset_frontpage("assets/images/icons/menu.svg") }}" class="svg_img header_svg" alt="icon" /></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="{{ route("home") }}" class="ec-header-btn"><img src="{{ asset_frontpage("assets/images/icons/home.svg") }}"
                            class="svg_img header_svg" alt="icon" /></a>
                </div>
                <div class="ec-nav-panel-icons">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('profile') }}" class="ec-header-btn"><img src="{{ asset_frontpage("assets/images/icons/user.svg") }}" class="svg_img header_svg" alt="icon" /></a>
                        @else
                            <a href="{{ route('login') }}" class="ec-header-btn"><img src="{{ asset_frontpage("assets/images/icons/user.svg") }}" class="svg_img header_svg" alt="icon" /></a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="ec-cart-float">
        <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
            <div class="header-icon"><img src="assets/images/icons/cart.svg" class="svg_img header_svg" alt="cart" />
            </div>
            <span class="ec-cart-count cart-count-lable">3</span>
        </a>
    </div> --}}

    <div class="ec-style ec-right-bottom">
        <div class="ec-panel">
            <div class="ec-header">
                <strong>Need Help?</strong>
                <p>Chat with us on WhatsApp</p>
            </div>
            <div class="ec-body">
                <ul>
                    <li>
                        <a class="ec-list" target="_blank" href="https://wa.me/{{ $navbar['settings']['whatsapp'] }}">
                            <div class="d-flex bd-highlight">
                                <div class="ec-user-info">
                                    <span>{{ $navbar['settings']['site_name'] }}</span>
                                </div>
                                <div class="ec-chat-icon">
                                    <i class="fa fa-whatsapp"></i>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ec-right-bottom">
            <div class="ec-box">
                <div class="ec-button rotateBackward">
                    <img class="whatsapp" src="{{ asset_frontpage('assets/images/common/whatsapp.png') }}" alt="whatsapp icon">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showLoader(){
            $('#ec-overlay').css("background-color", "#9a9a9b26");
            $('.loader_img').css("background-color", "#9a9a9b26");
            $('#ec-overlay').show();
        }

        function hideLoader(){
            $('#ec-overlay').hide();
        }

    </script>

    <script src="{{ asset_frontpage('assets/js/vendor/jquery-3.5.1.min.js') }}"></script>
    @auth
    <script>
        $.ajax({
            type: "GET",
            url: `{{ route('count-wishlist') }}`,
            success: function (response) {
                $('#count-cart').html(response)
            }
        });
    </script>
    @endauth
    <script src="{{ asset_frontpage('assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/vendor/modernizr-3.11.2.min.js') }}"></script>

    <script src="{{ asset_frontpage('assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/plugins/countdownTimer.min.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/plugins/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/plugins/slick.min.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/plugins/infiniteslidev2.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.7/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset_frontpage('assets/js/vendor/google-translate.js') }}"></script>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>
    @include('sweetalert::alert')

    <script src="{{ asset_frontpage('assets/js/vendor/index.js') }}"></script>
    <script src="{{ asset_frontpage('assets/js/main.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            cartload();

            $.ajaxSetup({
                xhrFields: {
                    withCredentials: true
                }
            });
        });

        $(document).on('click', '.changeLanguage', function(event) {
            var lang = $(this).data('lang');
            $.ajax({
                type: "POST",
                url: "{{ route('change_language') }}",
                data: ({
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    lang: lang,

                }),
                success: function() {
                    location.reload();
                }
            });
        });

        function cartload()
        {
            $.ajax({
                url: '/load-cart-data',
                method: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    // $('.cart-count-lable').html('');
                    var parsed = jQuery.parseJSON(response)
                    var value = parsed;
                    $('.cart-count-lable').html(value['totalcart']);
                    // console.log(value);
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
