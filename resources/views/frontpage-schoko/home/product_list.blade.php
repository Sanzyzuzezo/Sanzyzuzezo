@if(count($promotions) > 0)
<div class="container my-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" id="tag_container">
            @foreach($promotions as $data)
                <div class="d-flex justify-content-between section-text-title">
                    <div class="section-title m-0">
                        <h2 class="ec-bg-title p-0">{{ $data->title }}</h2>
                        <h2 class="ec-title p-0">{{ $data->title }}</h2>
                    </div>
                    @if($data->start_date < date("Y-m-d H:i:s"))
                        <div class="section-title m-0">
                            <label class="product-title text-uppercase mx-2">Ends In</label>
                            <p class="d-none" id="time">{{ $data->end_date }}</p>
                            <p class="ec-title p-0" id="promo-time"></p>
                        </div>
                    @else
                        <div class="section-title m-0">
                            <label class="product-title text-uppercase mx-2">Coming Soon</label>
                        </div>
                    @endif
                </div>
                <div class="section ec-catalog-multi-vendor mb-3">
                    <div class="container">
                        <div class="row">
                            @foreach ($data->sales as $row)
                                @if ($row->total_stock > 0)
                                    <div class="ec_cat_content prdct">
                                        <div class="ec-product-inner" style="margin-top:20px;">
                                            <div class="row-custom" style="vertical-align:middle;">
                                                <div class="row-column">
                                                    <!-- <div class="ec-pro-image"> -->
                                                    <div class="ec-pro-image custom-image" style="margin: auto;">
                                                        <a href="{{ route('catalogues.detail', $row->id) }}">
                                                            <img class="custom-size" src="{{ $row->image != null ? img_src($row->image, 'product') : img_src('default.jpg', '') }}" alt="Product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';">
                                                        </a>
                                                        <!-- TAG DISKON -->
                                                        <span class="custome-flags">
                                                            <span class="diskon">SALE</span>
                                                        </span>
                                                        {{-- <span class="percentage">20%</span> --}}
                                                        @if ($row->total_stock > 0)
                                                            <a title="Add To Cart" class="quickview getVariant" data-product_id="{{ $row->id }}"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            <div class="ec-pro-actions">
                                                                <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            </div>
                                                        {{-- <div class="ec-pro-actions">
                                                                <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            </div>  --}}
                                                        @else
                                                            <!-- TAG HABIS -->
                                                            <span class="custome-flags">
                                                                <span class="habis">EMPTY</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <!-- </div> -->
                                                </div>
                                                <div class="row-column">
                                                    <div class="product-info">
                                                    <div class="ec-pro-content pt-0">
                                                        <b class="category-product-title m-0">{{ $row->category }}</b>
                                                        <!-- <h5 class="ec-pro-title m-0">
                                                            <a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ $row->total_stock > 0 ? route('catalogues.detail', $row->id) : '#' }}">{{ $row->name }}</a>
                                                        </h5> -->
                                                        <div class="product-title mb-2">
                                                            {{-- <a href="{{ route('catalogues.detail', $row->id) }}">{{ $row->name }}</a> --}}
                                                            <a href="{{ route('catalogues.detail', $row->id) }}">{{Str::limit($row->name, 38, $end='...')}}</a>
                                                        </div>
                                                        @if($data->start_date < date("Y-m-d H:i:s"))
                                                            @php
                                                                $minimal = $row->min_price;
                                                                $maximal = $row->max_price;
                                                                $harga = $row->price;

                                                                if ($row->min_discount_price != null && $row->min_discount_price < $row->min_price){
                                                                    $minimal = $row->min_discount_price;
                                                                }

                                                                if ($row->max_discount_price != null && $row->max_discount_price < $row->max_price){
                                                                    $maximal = $row->max_discount_price;
                                                                }

                                                                if ($row->after_discount_price > 0){
                                                                    $harga = $row->after_discount_price;
                                                                }

                                                                // if ($row->max_price != $row->max_discount_price && $row->min_price < $row->max_discount_price && $row->min_discount_price == $row->max_discount_price){
                                                                    // $minimal = $row->min_price;
                                                                    // $maximal = $row->max_discount_price;
                                                                // }

                                                                // if ($row->min_price != $row->min_discount_price && $row->min_price > $row->max_discount_price){
                                                                    // $minimal = $row->min_discount_price;
                                                                    // $maximal = $row->max_price;
                                                                // }
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
                                                                        Rp. {{ $row->total_variant > 1 && $row->price != $row->after_discount_price ? number_format($minimal, 0, '.', ',') . ' - ' . number_format($maximal, 0, '.', ',') : number_format($harga, 0, '.', ',') }}
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
                                                            <button type="button" class="getVariant button-round" {{ $row->total_stock <= 0 && $data->start_date < date("Y-m-d H:i:s") ? 'disabled' : '' }} data-product_id="{{ $row->id }}">+</button>
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
            <div class="col-md-12 section-text-title text-right pt-4">
                <div class="section-title m-0">
                    <a href="{{ route('flash-sale') }}"><h2 class="ec-title p-0">More Flash Sale</h2><i class=""></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if(count($promotions_reguler) > 0)
<div class="container my-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" id="tag_container">
            @foreach($promotions_reguler as $data)
                <div class="d-flex justify-content-between section-text-title">
                    <div class="section-title m-0">
                        <h2 class="ec-bg-title p-0">{{ $data->title }}</h2>
                        <h2 class="ec-title p-0">{{ $data->title }}</h2>
                    </div>
                    @if($data->start_date < date("Y-m-d H:i:s"))
                        <div class="section-title m-0">
                            <label class="product-title text-uppercase mx-2">Ends In</label>
                            <p class="d-none" id="time2">{{ $data->end_date }}</p>
                            <p class="ec-title p-0" id="promo-time2"></p>
                        </div>
                    @else
                        <div class="section-title m-0">
                            <label class="product-title text-uppercase mx-2">Coming Soon</label>
                        </div>
                    @endif
                </div>
                <div class="section ec-catalog-multi-vendor mb-3">
                    <div class="container">
                        <div class="row">
                            @foreach ($data->sales as $row)
                                @if ($row->total_stock > 0)
                                    <div class="ec_cat_content prdct">
                                        <div class="ec-product-inner" style="margin-top:20px;">
                                            <div class="row-custom" style="vertical-align:middle;">
                                                <div class="row-column">
                                                    <!-- <div class="ec-pro-image"> -->
                                                    <div class="ec-pro-image custom-image" style="margin: auto;">
                                                        <a href="{{ route('catalogues.detail', $row->id) }}">
                                                            <img class="custom-size" src="{{ $row->image != null ? img_src($row->image, 'product') : img_src('default.jpg', '') }}" alt="Product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';">
                                                        </a>
                                                        <!-- TAG DISKON -->
                                                        <span class="custome-flags">
                                                            <span class="diskon">SALE</span>
                                                        </span>
                                                        {{-- <span class="percentage">20%</span> --}}
                                                        @if ($row->total_stock > 0)
                                                            <a title="Add To Cart" class="quickview getVariant" data-product_id="{{ $row->id }}"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            <div class="ec-pro-actions">
                                                                <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            </div>
                                                        {{-- <div class="ec-pro-actions">
                                                                <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            </div>  --}}
                                                        @else
                                                            <!-- TAG HABIS -->
                                                            <span class="custome-flags">
                                                                <span class="habis">EMPTY</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <!-- </div> -->
                                                </div>
                                                <div class="row-column">
                                                    <div class="product-info">
                                                    <div class="ec-pro-content pt-0">
                                                        <b class="category-product-title m-0">{{ $row->category }}</b>
                                                        <!-- <h5 class="ec-pro-title m-0">
                                                            <a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ $row->total_stock > 0 ? route('catalogues.detail', $row->id) : '#' }}">{{ $row->name }}</a>
                                                        </h5> -->
                                                        <div class="product-title mb-2">
                                                            {{-- <a href="{{ route('catalogues.detail', $row->id) }}">{{ $row->name }}</a> --}}
                                                            <a href="{{ route('catalogues.detail', $row->id) }}">{{Str::limit($row->name, 38, $end='...')}}</a>
                                                        </div>
                                                        @if($data->start_date < date("Y-m-d H:i:s"))
                                                            @php
                                                                $minimal = $row->min_price;
                                                                $maximal = $row->max_price;
                                                                $harga = $row->price;

                                                                if ($row->min_discount_price != null && $row->min_discount_price < $row->min_price){
                                                                    $minimal = $row->min_discount_price;
                                                                }

                                                                if ($row->max_discount_price != null && $row->max_discount_price < $row->max_price){
                                                                    $maximal = $row->max_discount_price;
                                                                }

                                                                if ($row->after_discount_price > 0){
                                                                    $harga = $row->after_discount_price;
                                                                }

                                                                // if ($row->max_price != $row->max_discount_price && $row->min_price < $row->max_discount_price && $row->min_discount_price == $row->max_discount_price){
                                                                    // $minimal = $row->min_price;
                                                                    // $maximal = $row->max_discount_price;
                                                                // }

                                                                // if ($row->min_price != $row->min_discount_price && $row->min_price > $row->max_discount_price){
                                                                    // $minimal = $row->min_discount_price;
                                                                    // $maximal = $row->max_price;
                                                                // }
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
                                                                        Rp. {{ $row->total_variant > 1 && $row->price != $row->after_discount_price ? number_format($minimal, 0, '.', ',') . ' - ' . number_format($maximal, 0, '.', ',') : number_format($harga, 0, '.', ',') }}
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
                                                            <button type="button" class="getVariant button-round" {{ $row->total_stock <= 0 && $data->start_date < date("Y-m-d H:i:s") ? 'disabled' : '' }} data-product_id="{{ $row->id }}">+</button>
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
            {{-- <div class="col-md-12 section-text-title text-right pt-4">
                <div class="section-title m-0">
                    <a href="{{ route('flash-sale') }}"><h2 class="ec-title p-0">More Flash Sale</h2><i class=""></i></a>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endif

@if(count($promotions) > 0)
    @foreach($promotions as $data)
        {{-- <div class="separator"></div> --}}

        <div class="sticky-header-next-sec ec-main-slider section" style="padding:30px;">
            <div class="ec-slider swiper-container main-slider-nav main-slider-dot" style="border-radius: 16px; max-height: 120px;">
                <div class="swiper-wrapper">
                    <div class="ec-slide-item d-flex"
                        style="background-repeat: no-repeat; background-image: url({{ asset_administrator('assets/media/banners/' . $data->image) }}); background-size: cover; background-position: center center; max-height: 120px; border-radius: 16px;">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
@if(count($promotions_reguler) > 0)
    @foreach($promotions_reguler as $data)
        {{-- <div class="separator"></div> --}}

        <div class="sticky-header-next-sec ec-main-slider section" style="padding:30px;">
            <div class="ec-slider swiper-container main-slider-nav main-slider-dot" style="border-radius: 16px; max-height: 120px;">
                <div class="swiper-wrapper">
                    <div class="ec-slide-item d-flex"
                        style="background-repeat: no-repeat; background-image: url({{ asset_administrator('assets/media/banners/' . $data->image) }}); background-size: cover; background-position: center center; max-height: 120px; border-radius: 16px;">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<div class="separator"></div>

@if($new_products->count() > 0)
<div class="container my-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" id="tag_container">
            <div class="col-md-12 section-text-title">
                <div class="section-title m-0">
                    <h2 class="ec-bg-title p-0">{{ __('home.new_product') }}</h2>
                    <h2 class="ec-title p-0">{{ __('home.new_product') }}</h2>
                </div>
            </div>
            <div class="section ec-catalog-multi-vendor mt-4">
                <div class="container">
                    <div class="row">
                        @foreach ($new_products as $row)
                            <div class="col-6">
                                <div class="mb-6 pro-gl-content prdct">
                                    <div class="ec-product-inner" style="margin:auto;">
                                        <div class="ec-pro-image custom-image-product" style="border-radius:16px; margin:auto; width: auto !important; height: auto !important">
                                            <a href="{{ route('catalogues.detail', $row->id) }}">
                                                <img class="custom-size" src="{{ $row->image != null ? img_src($row->image, 'product') : img_src('default.jpg', '') }}" alt="Product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';">
                                            </a>
                                            @if (($row->min_discount_price != $row->min_price && $row->min_discount_price > 0 ) || ($row->max_price != $row->max_discount_price && $row->max_discount_price > 0))
                                                <!-- TAG DISKON -->
                                                <span class="custome-flags">
                                                    <span class="diskon">SALE</span>
                                                </span>
                                            @endif
                                            <!-- TAG BARU -->
                                            <span class="custome-flags">
                                                <span class="baru">NEW</span>
                                            </span>
                                            @if ($row->total_stock > 0)
                                                <a title="Add To Cart" class="quickview getVariant" data-product_id="{{ $row->id }}"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                <div class="ec-pro-actions">
                                                    <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                </div>
                                            @else
                                                <span class="custome-flags" id="empty">
                                                    <span class="habis">EMPTY</span>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="ec-pro-content text-center mx-1">
                                            <b class="category-product-title">{{ $row->category_name }}</b>
                                            <div class="product-title">
                                                {{-- <a href="{{ route('catalogues.detail', $row->id) }}">{{ $row->name }}</a> --}}
                                                <a href="{{ route('catalogues.detail', $row->id) }}">{{Str::limit($row->name, 35, $end='...')}}</a>
                                            </div>
                                            @php
                                                $minimal = $row->min_price;
                                                $maximal = $row->max_price;
                                                $harga = $row->price;

                                                if($row->promotion_stock > 0){
                                                    if ($row->min_discount_price != null && $row->min_discount_price < $row->min_price){
                                                        $minimal = $row->min_discount_price;
                                                    }

                                                    if ($row->max_discount_price != null && $row->max_discount_price < $row->max_price){
                                                        $maximal = $row->max_discount_price;
                                                    }

                                                    if ($row->after_discount_price > 0){
                                                        $harga = $row->after_discount_price;
                                                    }

                                                    // if ($row->max_price != $row->max_discount_price && $row->min_price < $row->max_discount_price && $row->min_discount_price == $row->max_discount_price){
                                                        // $minimal = $row->min_price;
                                                        // $maximal = $row->max_discount_price;
                                                    // }

                                                    // if ($row->min_price != $row->min_discount_price && $row->min_price > $row->max_discount_price){
                                                        // $minimal = $row->min_discount_price;
                                                        // $maximal = $row->max_price;
                                                    // }
                                                }
                                            @endphp
                                            <span class="ec-price mb-0 align-self-center">
                                                @if (($row->min_discount_price != $row->min_price && $row->min_discount_price > 0 ) || ($row->max_price != $row->max_discount_price && $row->max_discount_price > 0))
                                                    <span class="old-price">Rp.
                                                        {{ $row->total_variant > 1 && $row->min_price != $row->max_price ? number_format($row->min_price, 0, '.', ',') . ' - ' . number_format($row->max_price, 0, '.', ',') : number_format($row->price, 0, '.', ',') }}
                                                    </span>
                                                @endif
                                            </span>
                                            <span class="ec-price mb-0 align-self-center">
                                                <a href="{{ route('catalogues.detail', $row->id) }}">
                                                    <span class="new-price" style="color:#7F3C1A">
                                                        Rp. {{ $row->total_variant > 1 && $row->price != $row->after_discount_price ? number_format($minimal, 0, '.', ',') . ' - ' . number_format($maximal, 0, '.', ',') : number_format($harga, 0, '.', ',') }}
                                                    </span>
                                                </a>
                                            </span>
                                            <input type="hidden" name="variant_id" class="variant_id" value="{{ $row->variant_id }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12 section-text-title text-right">
                <div class="section-title m-0">
                    <a href="{{ route('catalogues') }}"><h2 class="ec-title p-0">{{ __('home.more_product') }}</h2><i class=""></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="separator"></div>
@endif

<div class="container my-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" id="tag_container">
            <div class="col-md-12 section-text-title">
                <div class="section-title m-0">
                    <h2 class="ec-bg-title p-0">{{ __('home.best_seller') }}</h2>
                    <h2 class="ec-title p-0">{{ __('home.best_seller') }}</h2>
                </div>
            </div>
            <div class="section ec-catalog-multi-vendor">
                <div class="container">
                    <div class="row">
                        <div class="ec-multi-vendor-slider border-0 pb-0">
                            @foreach ($best_sellers as $row)
                                <div class="ec_cat_content prdct">
                                    <div class="ec-product-inner">
                                        <div class="row-custom" style="vertical-align:middle;">
                                            <div class="row-column p-0">
                                                <!-- <div class="ec-pro-image"> -->
                                                    <div class="ec-pro-image custom-image-best-sales" style="margin: auto;">
                                                        <a href="{{ route('catalogues.detail', $row->id) }}">
                                                            <img class="custom-size" src="{{ $row->image != null ? img_src($row->image, 'product') : img_src('default.jpg', '') }}" alt="Product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';">
                                                        </a>
                                                        {{-- <span class="percentage">20%</span> --}}
                                                        @if ($row->total_stock > 0)
                                                            <a title="Add To Cart" class="quickview getVariant" data-product_id="{{ $row->id }}"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            <div class="ec-pro-actions">
                                                                <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                            </div>
                                                        @else
                                                            <span class="custome-flags">
                                                                <span class="habis">EMPTY</span>
                                                            </span>
                                                        @endif
                                                        <input type="hidden" name="variant_id" class="variant_id" value="{{ $row->variant_id }}" />
                                                    </div>
                                                <!-- </div> -->
                                            </div>
                                            <div class="row-column">
                                                <div class="product-info">
                                                    <div class="ec-pro-content pt-0">
                                                        <b class="category-product-title m-0">{{ $row->category }}</b>
                                                        <!-- <h5 class="ec-pro-title m-0">
                                                            <a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ $row->total_stock > 0 ? route('catalogues.detail', $row->id) : '#' }}">{{ $row->name }}</a>
                                                        </h5> -->
                                                        <div class="product-title mb-2">
                                                            <a href="{{ route('catalogues.detail', $row->id) }}">{{Str::limit($row->name, 27, $end='...')}}</a>
                                                        </div>
                                                        @php
                                                            $minimal = $row->min_price;
                                                            $maximal = $row->max_price;
                                                            $harga = $row->price;

                                                            if ($row->min_discount_price != null && $row->min_discount_price < $row->min_price){
                                                                $minimal = $row->min_discount_price;
                                                            }

                                                            if ($row->max_discount_price != null && $row->max_discount_price < $row->max_price){
                                                                $maximal = $row->max_discount_price;
                                                            }

                                                            if ($row->after_discount_price > 0){
                                                                $harga = $row->after_discount_price;
                                                            }

                                                            // if ($row->max_price != $row->max_discount_price && $row->min_price < $row->max_discount_price && $row->min_discount_price == $row->max_discount_price){
                                                                // $minimal = $row->min_price;
                                                                // $maximal = $row->max_discount_price;
                                                            // }

                                                            // if ($row->min_price != $row->min_discount_price && $row->min_price > $row->max_discount_price){
                                                                // $minimal = $row->min_discount_price;
                                                                // $maximal = $row->max_price;
                                                            // }
                                                        @endphp
                                                        <span class="ec-price mb-0">
                                                            @if (($row->min_discount_price != $row->min_price && $row->min_discount_price > 0 ) || ($row->max_price != $row->max_discount_price && $row->max_discount_price > 0))
                                                                <span class="old-price">Rp.
                                                                    {{ $row->total_variant > 1 && $row->min_price != $row->max_price ? number_format($row->min_price, 0, '.', ',') . ' - ' . number_format($row->max_price, 0, '.', ',') : number_format($row->price, 0, '.', ',') }}
                                                                </span>
                                                            @endif
                                                        </span>
                                                        <span class="ec-price mb-0">
                                                            <a href="{{ route('catalogues.detail', $row->id) }}">
                                                                <span class="new-price" style="color:#7F3C1A">
                                                                    Rp. {{ $row->total_variant > 1 && $row->price != $row->after_discount_price ? number_format($minimal, 0, '.', ',') . ' - ' . number_format($maximal, 0, '.', ',') : number_format($harga, 0, '.', ',') }}
                                                                </span>
                                                            </a>
                                                        </span>
                                                        <input type="hidden" name="variant_id" class="variant_id" value="{{ $row->variant_id }}" />
                                                        <br>

                                                    </div>
                                                </div>
                                            </div>
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
</div>

<div class="addtocart-toast d-none">
    <div class="cart-desc">{{ __('home.add_to_chart') }}</div>
</div>
