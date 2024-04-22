
@extends('frontpage.layouts.main')

@section('content')
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Wishlist</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">{{ __('address_list.home') }}</a></li>
                                <li class="ec-breadcrumb-item active">Wishlist</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-vendor-block">
                                <div class="ec-vendor-block-items">
                                    <ul>
                                        <li><a href="{{ route('profile') }}">{{ __('address_list.user_profile') }}</a></li>
                                        <li><a href="{{ route('address') }}">{{ __('address_list.address') }}</a></li>
                                        <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ec-wish-rightside col-lg-9 col-md-12">
                    <div class="ec-compare-content">
                        <div class="ec-compare-inner">
                            <div class="row margin-minus-b-30">
                                @foreach ($wishlists as $row)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-6 pro-gl-content prdct">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="{{ route('catalogues.detail', $row->id_produk) }}" class="image">
                                                    <img class="main-image" src="{{ img_src($row->data_file, 'product') }}" alt="Product" />
                                                    <img class="hover-image" src="{{ img_src($row->data_file, 'product') }}" alt="Product" />
                                                </a>
                                                <span class="ec-com-remove ec-remove-wish">
                                                    <a href="javascript:void(0)" class="delete-wish" data-url="{{ route('delete.wishlist', $row->id) }}" data-id="{{ $row->id }}">×</a>
                                                </span>
                                                <a title="Add To Cart" class="quickview add-to-cart-btn"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <span>{{ $row->category_name }}</span>
                                            <h5 class="ec-pro-title"><a href="{{ route('catalogues.detail', $row->id_produk) }}">{{ $row->nama_produk }}</a></h5>
                                            <span class="ec-price">
                                                <span class="new-price">Rp.
                                                    {{ $row->total_variant > 1 && $row->min_price != $row->max_price? number_format($row->min_price, 0, '.', ',') . ' - ' . number_format($row->max_price, 0, '.', ','): number_format($row->price, 0, '.', ',') }}
                                                </span>
                                            </span>
                                            <input type="hidden" name="variant_id" class="variant_id" value="{{ $row->variant_id }}" />
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
<script>

    $(document).ready(function () {
        $('.delete-wish').click(function (e) {
            // e.preventDefault();
            // e.stopImmediatePropagation();
            console.log();
            let id = $(this).data('id');
            let url = $(this).data('url');
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
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
                        icon: 'success',
                        title: 'Wishlist berhasil dihapus !'
                    });
                    countWishlist();
                }
            });
        });

        $(".prdct").each(function() {
            var another = this;

            $(this).find('.add-to-cart-btn').off().click(function(e) {
                $(".addtocart-toast").removeClass("d-none");
                setTimeout(function(){ $(".addtocart-toast").addClass("d-none") }, 3000);

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
                        cartload()
                    }
                });
            });

        });

        function countWishlist() {
            $.ajax({
                type: "GET",
                url: `{{ route('count-wishlist') }}`,
                success: function (response) {
                    $('#count-cart').html(response)
                }
            });
        }

    });

</script>
@endpush

