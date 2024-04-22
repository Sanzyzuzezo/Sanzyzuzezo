<div class="shop-pro-inner">
    <div class="row">
        @foreach ($products as $row)
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content prdct">
                <div class="ec-product-inner">
                    <div class="ec-pro-image-outer">
                        <div class="ec-pro-image">
                            <a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ route('catalogues.detail', $row->id) }}">
                                <img class="main-image" src="{{ $row->data_file != null ? img_src($row->data_file, 'product') : img_src('default.jpg', '') }}"
                                    alt="Product" />
                            </a>
                            {{-- <span class="percentage">{{ __('product.empty') }}</span> --}}
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
                        <span>{{ $row->category_name }}</span>
                        <h5 class="ec-pro-title"><a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ $row->total_stock > 0 ? route('catalogues.detail', $row->id) : '#' }}">{{ $row->name }}</a></h5>
                        <div class="ec-pro-list-desc">{!! $row->description !!}</div>
                        <span class="ec-price">
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
                            <span class="new-price">Rp.
                                {{ $row->total_variant > 1 && $minimal != $maximal? number_format($minimal, 0, '.', ',') . ' - ' . number_format($maximal, 0, '.', ','): number_format($harga, 0, '.', ',') }}</span>
                        </span>
                        <input type="hidden" name="variant_id" class="variant_id" value="{{ $row->variant_id }}" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="ec-pro-pagination">
    {{ $products->links('vendor.pagination.custom')}}
</div>

<div class="addtocart-toast d-none">
    <div class="cart-desc">{{ __('product.add_alert') }}</div>
</div>
