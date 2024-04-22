@extends('frontpage-schoko.layouts.main')

@section('content')
    <!-- <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
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
    </div> -->

    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-shop-rightside col-lg-12 order-lg-last col-md-12 order-md-first margin-b-30">
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
                            <div class="ec-select-inner w-100">
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
                        @include('frontpage-schoko.products.product_list')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="ec-shop-leftside col-lg-12 order-lg-first col-md-12 order-md-last">
                    <div id="shop_sidebar">
                        <div class="ec-sidebar-heading">
                            <h1>{{ __('product.Filter_Products_By') }}</h1>
                        </div>
                        <div class="row">
                            <div class="ec-sidebar-wrap col-md-6">
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
                            <div class="ec-sidebar-wrap col-md-6">
                                <div class="ec-sidebar-block">
                                    <div class="ec-sb-title">
                                        <h3 class="ec-sidebar-title">{{ __('product.Category') }}</h3>
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
                        <div class="row">
                            <div class="ec-sidebar-wrap col-md-12">
                                <div class="ec-sidebar-block">
                                    <div class="ec-sb-title">
                                        <h3 class="ec-sidebar-title">{{ __('product.Price') }}</h3>
                                    </div>
                                    <div class="ec-sb-block-content es-price-slider mb-4">
                                        <div class="ec-price-filter">
                                            <div id="ec-sliderPrice" class="filter__slider-price" data-min="0" data-max="250"
                                                data-step="10"></div>
                                            <div class="ec-price-input">
                                                <label><input type="text" class="filter__input min_price withseparator format-number" name="min_price"
                                                        placeholder="Min"></label>
                                                <span class="ec-price-divider"></span>
                                                <label><input type="text" class="filter__input max_price withseparator format-number" name="max_price"
                                                        placeholder="Max"></label>
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
@endsection

@push('scripts')
<style>
    .active-variant{
    background-color: #fbcd0a !important;
}
</style>

    <script type="text/javascript">
        var SelectedVariant = null;

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

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // console.log(xx)/
            return xx;

        }

        function formatDecimal(n) {
            // format number 1000000 to 1,234,567
            var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "");
            // console.log(xx)
            return xx;

        }

        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatDecimal(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = "" + left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = "" + input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }

        $(document).ready(function() {
            $(".format-number").keydown(function(e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && (e
                        .ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <=
                        40)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
                        105)) {
                    e.preventDefault();
                }
            });

            $('.withseparator').on({
                keyup: function() {
                    formatCurrency($(this));
                },
                blur: function() {
                    formatCurrency($(this), "blur");
                }
            });

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();

                $('a').removeClass('active');
                $(this).addClass('active');

                var url = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];

                getData(page);

            });

            $(document).on('click', '.filter_categories', function(event) {
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
            var min_price = $(".min_price").val().replace(/\,/g,'');
            var max_price = $(".max_price").val().replace(/\,/g,'');
            var order_data = $("#ec-select").val();
            console.log(max_price);
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
        
        $(document).on('click', '.changeVariant', function(event) {
            event.preventDefault();
            var ix = $(this).data('ix');
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

    </script>
@endpush
