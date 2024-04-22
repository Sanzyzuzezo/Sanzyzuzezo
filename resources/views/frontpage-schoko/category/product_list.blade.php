<div class="shop-pro-inner">
    <div class="row">
        @foreach ($products as $row)
            <div class="col-6">
                <div class="mb-6 pro-gl-content prdct">
                    <div class="ec-product-inner"  style="margin:auto;">
                        <div class="ec-pro-image custom-image-product" style="border-radius:16px; margin:auto; width: auto !important; height: auto !important;">
                            <a href="{{ route('catalogues.detail', $row->id) }}">
                                <img src="{{ $row->data_file != null ? img_src($row->data_file, 'product') : img_src('default.jpg', '') }}"
                                    alt="Product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';" class="custom-size">
                            </a>
                            {{-- <span class="percentage">{{ __('product.empty') }}</span> --}}
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
                            {{-- <span style="margin:auto;">{{ $row->category_name }}</span> --}}
                            {{-- <h5 class="ec-pro-title" style="margin:auto;"><a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ $row->total_stock > 0 ? route('catalogues.detail', $row->id) : '#' }}">{{Str::limit($row->name, 15, $end='...')}}</a></h5> --}}
                            <div class="ec-pro-list-desc" style="margin:auto;">{!! $row->description !!}</div>
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

<div class="ec-pro-pagination">
    {{ $products->links('vendor.pagination.custom')}}
</div>

<br>
<br>
