@extends('frontpage-schoko.layouts.main')

@section('content')
    <div class="sticky-header-next-sec ec-main-slider section section-space-pb">
        <div class="ec-slider swiper-container main-slider-nav main-slider-dot">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                    <div class="ec-slide-item swiper-slide d-flex" style="background-repeat: no-repeat; background-image: url({{ asset_administrator('assets/media/banners/'.$banner->image) }}); background-size: cover; background-position: center center;">
                        <div class="container align-self-center">
                            <div class="row">
                                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                                    <div class="ec-slide-content slider-animation">
                                        <h1 class="ec-slide-title">{{ session()->get('locale') == 'id' ? $banner->title : $banner->title_an }}</h1>
                                        <h2 class="ec-slide-stitle">{{ session()->get('locale') == 'id' ? $banner->caption : $banner->caption_an }}</h2>
                                        <p>{{ session()->get('locale') == 'id' ? $banner->description : $banner->description_an }}</p>
                                        <a href="#" class="btn btn-lg btn-secondary">{{ __('home.button_banner') }}</a>
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

    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-shop-rightside col-lg-9 order-lg-last col-md-12 order-md-first margin-b-30">
                    <div class="shop-pro-content" id="tag_container">
                        @include('frontpage-schoko.products.product_list')
                    </div>
                </div>
                <div class="ec-shop-leftside col-lg-3 order-lg-first col-md-12 order-md-last">
                    <div id="shop_sidebar">
                        <div class="ec-sidebar-heading">
                            <h1>Filter Products By</h1>
                        </div>
                        <div class="ec-sidebar-wrap">
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Category</h3>
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
        </div>
    </section>

    <!-- <section class="ec-page-content section-space-p ec-fre-spe-section">
        <div class="container">
            <div class="row">
                <div class="ec-fre-section col-lg-9 col-md-12 col-sm-12">                    
                    <div class="col-md-12">
                        <div class="section-title m-0">
                            <h2 class="ec-bg-title p-0">{{ __('home.new_product') }}</h2>
                            <h2 class="ec-title p-0">{{ __('home.new_product') }}</h2>
                        </div>
                    </div>
                    <div class="section ec-category-section ec-category-wrapper-1 section-space-p">
                        <div class="row margin-minus-tb-15">
                            <div class="ec_cat_slider p-0">
                                @foreach($new_products as $product)
                                    <div class="ec_cat_content">
                                        <div class="ec-product-inner">
                                            <div class="ec-pro-image-outer">
                                                <div class="ec-pro-image">
                                                    <a href="product-detail.html" class="image">
                                                        <img class="main-image" src="{{ img_src($product->image, "product") }}" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="#">{{ $product->name }}</a></h5>
                                                <span class="ec-price">
                                                    <span class="new-price">{{ $product->min_price == $product->max_price ? number_format($product->min_price) : number_format($product->min_price).' - '.number_format($product->max_price) }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="section-title m-0">
                            <h2 class="ec-bg-title p-0">{{ __('home.best_seller') }}</h2>
                            <h2 class="ec-title p-0">{{ __('home.best_seller') }}</h2>
                        </div>
                    </div>
                    <div class="section ec-category-section ec-category-wrapper-1 section-space-p">
                        <div class="row margin-minus-tb-15">
                            <div class="ec_cat_slider p-0">
                                @foreach($best_sellers as $product)
                                    <div class="ec_cat_content">
                                        <div class="ec-product-inner">
                                            <div class="ec-pro-image-outer">
                                                <div class="ec-pro-image">
                                                    <a href="product-detail.html" class="image">
                                                        <img class="main-image" src="{{ img_src($product->image, "product") }}" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="#">{{ $product->name }}</a></h5>
                                                <span class="ec-price">
                                                    <span class="new-price">{{ $product->min_price == $product->max_price ? number_format($product->min_price) : number_format($product->min_price).' - '.number_format($product->max_price) }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ec-shop-leftside col-lg-3 order-lg-first col-md-12 order-md-last">
                    <div class="ec-sidebar-heading">
                        <h1>{{ __('home.filter') }}</h1>
                    </div>
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">{{ __('home.category') }}</h3>
                            </div>
                            <div class="ec-sb-block-content border-bottom-0 m-0 p-0">
                                <ul>
                                    @foreach($categories as $category)
                                        <li>
                                            <div class="ec-sidebar-block-item boxes">
                                                <input type="checkbox" class="category" id="{{ $category->id }}" value="{{ $category->id }}"> <label class="ml-5" for="{{ $category->id }}">{{ $category->name }}</label><span class="checked"></span>
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
                        @foreach($brands as $brand)
                            <div class="ec-insta-item">
                                <div class="ec-insta-inner">
                                    <a href="#" target="_blank"><img src="{{ asset_administrator("assets/media/brands/$brand->image") }}"></a>
                                    <h5 class="text-center py-2">{{ $brand->name }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            
            $(document).on('click', '.filter_categories', function(event) {
                getData()
            });
            
            function getData() {
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
        });

    </script>
@endpush