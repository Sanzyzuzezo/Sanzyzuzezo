<div class="col-md-12">
    <div class="section-title m-0">
        <h2 class="ec-bg-title p-0">{{ __('home.new_product') }}</h2>
        <h2 class="ec-title p-0">{{ __('home.new_product') }}</h2>
    </div>
</div>
<div class="section ec-catalog-multi-vendor margin-bottom-30">
    <div class="container">
        <div class="row">
            <div class="ec-multi-vendor-slider border-0">
                @foreach ($new_products as $row)
                    <div class="ec_cat_content prdct">
                        <div class="ec-product-inner">
                            <div class="ec-pro-image-outer">
                                <div class="ec-pro-image">
                                    <a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ route('catalogues.detail', $row->id) }}">
                                        <img class="main-image" src="{{ $row->image != null ? img_src($row->image, 'product') : img_src('default.jpg', '') }}" alt="Product" />
                                    </a>
                                    {{-- <span class="percentage">20%</span> --}}
                                    @if ($row->total_stock > 0)
                                        <a title="Add To Cart" class="quickview add-to-cart-btn"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                        <div class="ec-pro-actions">
                                            <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                        </div>
                                    @else
                                        <span class="flags">
                                            <span style="background-color: red;" class="sale">{{ __('product.empty') }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="ec-pro-content">
                                <p class="m-0">{{ $row->category }}</p>
                                <h5 class="ec-pro-title m-0"><a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ $row->total_stock > 0 ? route('catalogues.detail', $row->id) : '#' }}">{{ $row->name }}</a></h5>
                                <span class="ec-price mb-0">
                                    @php
                                        $minimal = $row->min_price;
                                        $maximal = $row->max_price;
                                        $harga = $row->price;

                                        if ($row->min_discount_price > 0)
                                            $minimal = $row->min_discount_price;

                                        if ($row->max_discount_price > 0)
                                            $maximal = $row->max_discount_price;

                                        if ($row->discount_price > 0)
                                            $harga = $row->discount_price;
                                    @endphp
                                    @if ($row->min_discount_price > 0 || $row->max_discount_price > 0)
                                        <span class="old-price" style="font-size: 11px;">Rp.
                                            {{ $row->total_variant > 1 && $row->min_price != $row->max_price? number_format($row->min_price, 0, '.', ',') . ' - ' . number_format($row->max_price, 0, '.', ','): number_format($row->price, 0, '.', ',') }}
                                        </span>
                                    @endif
                                    <span class="new-price">Rp. {{ $row->total_variant > 1 && $minimal != $maximal? number_format($minimal, 0, '.', ',') . ' - ' . number_format($maximal, 0, '.', ','): number_format($harga, 0, '.', ',') }}</span>
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
<div class="col-md-12">
    <div class="section-title m-0">
        <h2 class="ec-bg-title p-0">{{ __('home.best_seller') }}</h2>
        <h2 class="ec-title p-0">{{ __('home.best_seller') }}</h2>
    </div>
</div>
<div class="section ec-catalog-multi-vendor margin-bottom-30">
    <div class="container">
        <div class="row">
            <div class="ec-multi-vendor-slider border-0">
                @foreach ($best_sellers as $row)
                    <div class="ec_cat_content prdct">
                        <div class="ec-product-inner">
                            <div class="ec-pro-image-outer">
                                <div class="ec-pro-image">
                                    <a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ route('catalogues.detail', $row->id) }}">
                                        <img class="main-image" src="{{ $row->image != null ? img_src($row->image, 'product') : img_src('default.jpg', '') }}" alt="Product" />
                                    </a>
                                    {{-- <span class="percentage">20%</span> --}}
                                    @if ($row->total_stock > 0)
                                        <a title="Add To Cart" class="quickview add-to-cart-btn"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                        <div class="ec-pro-actions">
                                            <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                        </div>
                                    @else
                                        <span class="flags">
                                            <span style="background-color: red;" class="sale">{{ __('product.empty') }}</span>
                                        </span>
                                    @endif
                                    <input type="hidden" name="variant_id" class="variant_id" value="{{ $row->variant_id }}" />
                                </div>
                            </div>
                            <div class="ec-pro-content">
                                <p class="m-0">{{ $row->category }}</p>
                                <h5 class="ec-pro-title m-0"><a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ $row->total_stock > 0 ? route('catalogues.detail', $row->id) : '#' }}">{{ $row->name }}</a></h5>
                                <span class="ec-price mb-0">
                                    @if ($row->min_discount_price > 0 || $row->max_discount_price > 0)
                                        <span class="old-price" style="font-size: 11px;">Rp.
                                            {{ $row->total_stock > 1 && $row->min_price != $row->max_price? number_format($row->min_price, 0, '.', ',') . ' - ' . number_format($row->max_price, 0, '.', ','): number_format($row->price, 0, '.', ',') }}
                                        </span>
                                    @endif
                                    <span class="new-price">{{ $row->min_price == $row->max_price ? number_format($row->min_price) : number_format($row->min_price).' - '.number_format($row->max_price) }}</span>
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

<div class="addtocart-toast d-none">
    <div class="cart-desc">{{ __('home.add_to_chart') }}</div>
</div>
