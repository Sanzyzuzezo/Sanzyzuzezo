@extends('frontpage.layouts.main')

@section('content')
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ __('product.Catalogues') }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="index.html">{{ __('product.Home') }}</a></li>
                                <li class="ec-breadcrumb-item active">{{ __('product.Catalogues') }}</li>
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
                <div class="ec-shop-rightside col-lg-9 order-lg-last col-md-12 order-md-first margin-b-30">
                    <div class="ec-pro-list-top d-flex">
                        <div class="col-md-6 ec-grid-list">
                            <div class="ec-gl-btn">
                                <button class="btn btn-grid active"><img
                                        src="{{ asset_frontpage('assets/images/icons/grid.svg') }}" class="svg_img gl_svg"
                                        alt="" /></button>
                                <button class="btn btn-list"><img
                                        src="{{ asset_frontpage('assets/images/icons/list.svg') }}" class="svg_img gl_svg"
                                        alt="" /></button>
                            </div>
                        </div>
                        <div class="col-md-6 ec-sort-select">
                            <span class="sort-by">{{ __('product.Sort_by') }}</span>
                            <div class="ec-select-inner">
                                <select name="order_data" id="ec-select">
                                    <option value="0">{{ __('product.Position') }}</option>
                                    <option value="1">{{ __('product.Relevance') }}</option>
                                    <option value="2">{{ __('product.Name_A_to_Z') }}</option>
                                    <option value="3">{{ __('product.Name_Z_to_A') }}</option>
                                    <option value="4">{{ __('product.Price_low_to_high') }}</option>
                                    <option value="5">{{ __('product.Price_high_to_low') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="shop-pro-content" id="tag_container">
                        @include('frontpage.products.product_list')
                    </div>
                </div>
                <div class="ec-shop-leftside col-lg-3 order-lg-first col-md-12 order-md-last">
                    <div id="shop_sidebar">
                        <div class="ec-sidebar-heading">
                            <h1>{{ __('product.Filter_Products_By') }}</h1>
                        </div>
                        <div class="ec-sidebar-wrap">
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">{{ __('product.Category') }}</h3>
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
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">{{ __('product.Price') }}</h3>
                                </div>
                                <div class="ec-sb-block-content es-price-slider mb-4">
                                    <div class="ec-price-filter">
                                        <div id="ec-sliderPrice" class="filter__slider-price" data-min="0" data-max="250"
                                            data-step="10"></div>
                                        <div class="ec-price-input">
                                            <label><input type="text" class="filter__input min_price" name="min_price"
                                                    placeholder="Min"></label>
                                            <span class="ec-price-divider"></span>
                                            <label><input type="text" class="filter__input max_price" name="max_price"
                                                    placeholder="Max"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title pb-3 pb-lg-0">
                                    <h3 class="ec-sidebar-title">{{ __('product.Brands') }}</h3>
                                </div>
                                <div class="ec-sb-block-content border-bottom-0 pb-0 mb-0">
                                    <ul>
                                        @foreach ($brands as $row)
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    <input type="checkbox" name="brand[]" value="{{ $row->id }}"
                                                        class="filter_brands">
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
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">

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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();

                $('a').removeClass('active');
                $(this).addClass('active');

                var url = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];

                getData(page);

            });
            
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

            $(document).on('click', '.filter_brands', function(event) {
                getData()
            });

            $(document).on('keyup', '.min_price', function(event) {
                getData()
            });

            $(document).on('keyup', '.max_price', function(event) {
                getData()
            });

            $(document).on('change', '#ec-select', function(event) {
                getData()
            });

            // $(document).on('click', '.quickview-product', function(event) {
            //     var ix = $(this).data('ix');
            //     $.ajax({
            //         type: "POST",
            //         url: "{{ route('catalogues.getDetail') }}",
            //         data: ({
            //             "_token": "{{ csrf_token() }}",
            //             ix: ix,
            //         }),
            //         success: function(data) {
            //             var slide_image = "";
            //             slide_image += '<div class="qty-slide"><img class="img-responsive" src="{{ route('catalogues') }}" alt=""></div>';
            //             $('.ec-quick-title').html(data.name);
            //             console.log()
            //             $('#ec_quickview_modal').modal('show');
            //         }
            //     });
            // });

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

        });

        function getData(page) {
            if (page == undefined) {
                var url = '{{ route("catalogues") }}';
            } else {
                var url = '{{ route("catalogues") }}?page=' + page;
            }
            var categories = getCategory();
            var brands = getBrand();
            var min_price = $(".min_price").val();
            var max_price = $(".max_price").val();
            var order_data = $("#ec-select").val();
            // body...
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    categories: categories,
                    brands: brands,
                    min_price: min_price,
                    max_price: max_price,
                    order_data: order_data
                },
                datatype: 'HTML',
            }).done(function(data) {
                $('#tag_container').empty().html(data);
                location.hash = page;
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

            function getBrand() {
                var filter = [];
                $('.filter_brands:checked').each(function() {
                    filter.push($(this).val());
                });
                return filter;
            }
        }

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
                            title: 'Login untuk menambahkan wishlist!',
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
