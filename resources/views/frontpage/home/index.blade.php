@extends('frontpage.layouts.main')

@section('content')
    <div class="sticky-header-next-sec ec-main-slider section section-space-pb">
        <div class="ec-slider swiper-container main-slider-nav main-slider-dot">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="ec-slide-item swiper-slide d-flex"
                        style="background-repeat: no-repeat; background-image: url({{ asset_administrator('assets/media/banners/' . $banner->image) }}); background-size: cover; background-position: center center;">
                        <div class="container align-self-center">
                            <div class="row">
                                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                                    <div class="ec-slide-content slider-animation">
                                        <h1 class="ec-slide-title">
                                            {{ session()->get('locale') == 'id' ? $banner->title : $banner->title_an }}
                                        </h1>
                                        <h2 class="ec-slide-stitle">
                                            {{ session()->get('locale') == 'id' ? $banner->caption : $banner->caption_an }}
                                        </h2>
                                        <p>{{ session()->get('locale') == 'id' ? $banner->description : $banner->description_an }}</p>
                                        @if($banner->show_button == 1)
                                            @php
                                                $buttontext = json_decode($banner->button_text);
                                                $button_text = $buttontext->button_text;
                                                $button_text_an = $buttontext->button_text_an;
                                            @endphp
                                            <a href="{{ $banner->button_url }}" class="btn btn-lg btn-secondary">{{ session()->get('locale') == 'id' ? $button_text : $button_text_an }}</a>
                                        @endif
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

    <section class="ec-page-content section-space-p ec-fre-spe-section">
        <div class="container">
            <div class="row">
                <div class="ec-fre-section col-lg-9 col-md-12 col-sm-12" id="tag_container">
                    @include('frontpage.home.product_list')
                </div>
                <div class="ec-shop-leftside col-lg-3 order-lg-first col-md-12 order-md-last">
                    <!-- <div id="shop_sidebar"> -->
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
                                            @if($row->parent == null)
                                                <li>
                                                    <div class="ec-sidebar-block-item">
                                                        <input type="checkbox" name="category[]" value="{{ $row->id }}"
                                                            class="filter_categories parent" id="{{ $row->id }}" data-id="{{ $row->id }}">
                                                        <label class="ml-5 mb-0" for="{{ $row->id }}">{{ $row->name }}</label>
                                                        <span class="checked"></span>
                                                    </div>
                                                </li>
                                                @foreach ($categories as $row_child)
                                                    @if($row_child->parent == $row->id)
                                                        <li class="ml-3">
                                                            <div class="ec-sidebar-block-item">
                                                                <input type="checkbox" name="category[]" value="{{ $row_child->id }}"
                                                                    class="filter_categories parent child-{{ $row->id }}" id="{{ $row_child->id }}" data-id="{{ $row_child->id }}" data-parent_id="{{ $row_child->parent }}">
                                                                <label class="ml-5 mb-0" for="{{ $row_child->id }}">{{ $row_child->name }}</label>
                                                                <span class="checked"></span>
                                                            </div>
                                                        </li>
                                                        @foreach ($categories as $row_child2)
                                                            @if($row_child2->parent == $row_child->id)
                                                                <li class="ml-6">
                                                                    <div class="ec-sidebar-block-item">
                                                                        <input type="checkbox" name="category[]" value="{{ $row_child2->id }}"
                                                                            class="filter_categories child-{{ $row->id }} child-{{ $row_child->id }}" id="{{ $row_child2->id }}" data-id="{{ $row_child2->id }}" data-parent_id="{{$row_child2->parent}}">
                                                                        <label class="ml-5 mb-0" for="{{ $row_child2->id }}">{{ $row_child2->name }}</label>
                                                                        <span class="checked"></span>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>

    <section class="section ec-instagram-section module section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">{{ __('home.brand') }}</h2>
                        <h2 class="ec-title">{{ __('home.brand') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="ec-insta-wrapper">
            <div class="ec-insta-outer">
                <div class="container" data-animation="fadeIn">
                    <div class="insta-auto">
                        @foreach ($brands as $brand)
                            <div class="ec-insta-item">
                                <a href="{{ route('brand_detail', $brand->id) }}">
                                    <img src="{{ asset_administrator("assets/media/brands/$brand->image") }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
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
            $(document).on('change', '.filter_categories', function(event) {
               
                    var get_id = $(this).data("id");
                    var child = $('[data-parent_id='+get_id+']').val();

                    console.log("ID kategori : "+get_id);
                    console.log($('[data-parent_id='+get_id+']').is(":checked"));
                    
                    if($(this).is(":checked")){
                        $('[data-parent_id='+get_id+']').prop('checked', true);
                    }else{
                        $('[data-parent_id='+get_id+']').prop('checked', false);  
                    }

                    if($('[data-parent_id='+get_id+']').is(":checked")){
                        $('[data-parent_id='+child+']').prop('checked', true);
                    }else{
                        $('[data-parent_id='+child+']').prop('checked', false);
                    }                    
               
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
            // body...
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

                // $('.parent:checked').each(function() {
                //     var child = ".child-"+$(this).val();
                //     $(child).prop('checked', true);
                // });

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
