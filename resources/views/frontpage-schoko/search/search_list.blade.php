<div class="shop-pro-inner">
    <h5>Hasil Pencarian Product</h5>
    <br>
    <div class="row">
        @foreach ($products as $row)
            <div class="col-6">
                <div class="mb-6 pro-gl-content prdct">
                    <div class="ec-product-inner">
                        <div class="ec-pro-image-outer">
                            <div class="ec-pro-image" style="border-radius:6px; width: auto !important; height: auto !important;">
                                <a href="{{ route('catalogues.detail', $row->id) }}">
                                    <img src="{{ $row->data_file != null ? img_src($row->data_file, 'product') : img_src('default.jpg', '') }}"
                                        alt="Product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';">
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
                        </div>
                        <div class="ec-pro-content">
                            <span>{{ $row->category_name }}</span>
                            <h5 class="ec-pro-title"><a class="{{ $row->total_stock > 0 ? '' : 'detail-click' }}" href="{{ $row->total_stock > 0 ? route('catalogues.detail', $row->id) : '#' }}">{{ $row->name }}</a></h5>
                            <div class="ec-pro-list-desc">{!! $row->description !!}</div>
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
                                //     $minimal = $row->min_price;
                                //     $maximal = $row->max_discount_price;
                                // }

                                // if ($row->min_price != $row->min_discount_price && $row->min_price > $row->max_discount_price){
                                //     $minimal = $row->min_discount_price;
                                //     $maximal = $row->max_price;
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

<div class="addtocart-toast d-none">
    <div class="cart-desc">{{ __('product.add_alert') }}</div>
</div>
<br><br>
<h5>Hasil Pencarian Artikel</h5>
<br>
<div class="ec-blogs-inner">
    <div class="row">
        @foreach ($data as $row)
            <div class="col-md-12 col-sm-12 mb-6 ec-blog-block">
                <div class="ec-blog-inner">
                    <div class="ec-blog-image">
                        @php $ext = explode('.', $row->data_file) @endphp
                        @if (end($ext) == 'jpg' || end($ext) == 'jpeg' || end($ext) == 'gif' || end($ext) == 'png')
                        <a href="{{ route('news_detail', $row->slug) }}">
                            <img class="custom-size" src="{{ img_src($row->data_file, 'news') }}" alt="{{ session()->get('locale') == 'id' ? $row->title : $row->title }}" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';" style="border-radius: 16px;">
                        </a>
                        @elseif (end($ext) == 'mp4' || end($ext) == '3gp' || end($ext) == 'wmv' || end($ext) == 'mkv')
                            <video id="my-video" class="gambar-resep video-js" controls preload="auto" width="100%" poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
                                <source src="{{ img_src($row->data_file, "news") }}" type="video/mp4" />
                                <source src="{{ img_src($row->data_file, "news") }}" type="video/webm" />
                            </video>
                        @else
                            <iframe
                                width="100%"
                                height="180px"
                                src="https://www.youtube.com/embed/{{$row->data_file}}"
                                title="YouTube"
                                frameborder="8"
                                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        @endif
                    </div>
                    <div class="ec-blog-content">
                        <span class="badge btn-primary mb-2">{{ $row->post_category_name }}</span>
                        <h5 class="ec-blog-title m-0"><a href="{{ route('news_detail', $row->slug) }}">{{ session()->get('locale') == 'id' ? $row->title : $row->title }}</a></h5>
                        <div class="ec-blog-date">
                            {{ date('M d, Y', strtotime($row->created_at)) }}</div>
                        <div class="ec-blog-desc">
                            {!! strip_tags(substr(session()->get('locale') == 'id' ? $row->description : $row->description, 0, 190)) !!} {!!  strlen(session()->get('locale') == 'id' ? $row->description : $row->description) > 190 ? '...' : '' !!}
                        </div>
                        <div class="ec-blog-btn">
                            <a href="{{ route('news_detail', $row->slug) }}" class="btn btn-primary">{{ __('news.detail_button') }}</a>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
        @endforeach

    </div>
</div>

<div class="ec-pro-pagination">
    {{ $products->links('vendor.pagination.custom')}}
</div>


