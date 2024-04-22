@extends('frontpage-schoko.layouts.main')

@section('content')
    <!-- Ec breadcrumb start -->
    <!-- <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ __('news.page_title') }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route("home") }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">{{ __('news.page_title') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Ec breadcrumb end -->

    <!-- Ec Blog page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row" style="margin:10px;">
                <div class="ec-blog-search">
                    <form class="ec-blog-search-form" action="#">
                        <input class="form-control filter_keywords" placeholder="{{ __('news.search_text') }}" type="text">
                        <button class="submit filter_keywords_button" type="button"><i class="ecicon eci-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="ec-blogs-rightside col-lg-12 col-md-12">

                    <!-- Blog content Start -->
                    <div class="ec-blogs-content" id="tag_container">
                        @include('frontpage-schoko.search.search_list')
                    </div>
                    <!--Blog content End -->
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
    $(document).ready(function() {
        var SelectedVariant = null;

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();

            $('a').removeClass('active');
            $(this).addClass('active');

            var url = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            getData(page);

        });;

        $('.filter_categories').click(function (e) {
            e.stopImmediatePropagation();
            getData()
            console.log('Clicked');
        });

        $('.filter_keywords').keyup(function (e) {
            e.stopImmediatePropagation();
            getData()
        });

        $(document).off().on('click', '.filter_keywords_button', function(event) {
            e.stopImmediatePropagation();
            getData()
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                            title: `Pilih Variant`,
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
            var another = this;
            e.preventDefault();
            e.stopImmediatePropagation();
            const user = {
                product_id : document.getElementById('product_id').value,
            }

            e.preventDefault();
            var variant_id = SelectedVariant;

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

         function formatNumber(n) {
            // format number 1000000 to 1,234,567
            var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // console.log(xx)/
            return xx;

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
    });

    function getData(page) {

        console.log(page);

        if (page == undefined) {
            var url = "";
        } else {
            var url = '?page=' + page;
        }

        var categories = getCategory();
        var keywords = $(".filter_keywords").val();

        // alert(keywords);
        // body...
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                categories: categories,
                keywords:keywords
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
    }
</script>
@endpush
