<div class="container my-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" id="tag_container">
            <div class="col-md-12 section-text-title">
                <div class="section-title m-0">
                    <h2 class="ec-bg-title p-0">{{ __('product.Related_products') }}</h2>
                    <h2 class="ec-title p-0">{{ __('product.Related_products') }}</h2>
                </div>
            </div>
            <div class="section ec-catalog-multi-vendor">
                <div class="container">
                    <div class="row">
                        <!-- <div class="ec-multi-vendor-slider border-0"> -->
                            @foreach ($related_products as $row)
                                <div class="ec_cat_content related-product">
                                    <div class="ec-product-inner" style="margin-top:20px;">
                                        <div class="row-custom" style="vertical-align:middle;">
                                            <div class="row-column">
                                                <!-- <div class="ec-pro-image"> -->
                                                <div class="ec-pro-image custom-image" style="margin: auto;">
                                                    <a href="{{ route('catalogues.detail', $row->id) }}">
                                                        <img src="{{ $row->data_file != null ? img_src($row->data_file, 'product') : img_src('default.jpg', '') }}" alt="Product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';" class="custom-size">
                                                    </a>
                                                    <!-- TAG DISKON -->
                                                    <span class="custome-flags">
                                                        <span class="diskon">SALE</span>
                                                    </span>
                                                    @if ($row->total_stock > 0)
                                                        <a title="Add To Cart" class="quickview add-to-cart-btn-pr"><img src="{{ asset_frontpage('assets/images/icons/cart.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                        <div class="ec-pro-actions">
                                                            <a href="#" class="ec-btn-group compare" data-product_id="{{ $row->id }}" title="Add To Wishlist"><img src="{{ asset_frontpage('assets/images/icons/wishlist.svg') }}" class="svg_img pro_svg" alt="" /></a>
                                                        </div>
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
                                                    <div class="product-title mb-2">
                                                        <a href="{{ route('catalogues.detail', $row->id) }}">{{ $row->name }}</a>
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
                                                    @endphp
                                                    <span class="ec-price mb-0">
                                                        @if (($row->min_discount_price != $row->min_price && $row->min_discount_price > 0 ) || ($row->max_price != $row->max_discount_price && $row->max_discount_price > 0))
                                                            <span class="old-price">Rp.
                                                                {{ $row->total_variant > 1 && $row->min_price != $row->max_price ? number_format($row->min_price, 0, '.', ',') . ' - ' . number_format($row->max_price, 0, '.', ',') : number_format($row->price, 0, '.', ',') }}
                                                            </span>
                                                        @endif
                                                    </span>
                                                    <span class="ec-price mb-0">
                                                        <a href="{{ route('catalogues.detail', $row->id) }}"><span class="new-price" style="color:#7F3C1A">Rp. {{ $row->total_variant > 1 && $minimal != $maximal? number_format($minimal, 0, '.', ',') . ' - ' . number_format($maximal, 0, '.', ','): number_format($harga, 0, '.', ',') }}</span></a>
                                                    </span>
                                                    <input type="hidden" name="variant_id" class="variant_id_pr" value="{{ $row->variant_id }}" />
                                                    <br>

                                                </div>

                                                <div class="row-stock">
                                                    <div class="stock">
                                                        <button class="stock-left-list">Stock Left</button>
                                                        <button class="stock-right-list">{{ number_format($row->total_stock, 0, '.', ',') }} Pcs</button>
                                                    </div>
                                                        <button type="button" class="add-to-cart-btn-pr button-round" {{ $row->total_stock <= 0 ? 'disabled' : '' }} >+</button>
                                                </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        <!-- </div> -->
                    </div>
                </div>
            </div>
            <div class="col-md-12 section-text-title text-right pt-4">
                <div class="section-title m-0">
                    <a href="{{ route('catalogues') }}"><h2 class="ec-title p-0">{{ __('home.more_product') }}</h2><i class=""></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var index = 0;
            $(".related-product").each(function() {
                var another = this;

                $(this).find('.add-to-cart-btn-pr').off().click(function(e) {
                    e.preventDefault();
                    var variant_id = $(another).find('.variant_id_pr').val();

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
    </script>
@endpush
