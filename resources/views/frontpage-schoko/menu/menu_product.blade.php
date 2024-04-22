<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">
                <div class="section-title">
                    <h2 class="ec-bg-title">Produk Terbaru</h2>
                    <h2 class="ec-title">Produk Terbaru</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="swiper mySwiper swiper-hide-slide">
      <div class="swiper-wrapper">
             @foreach ($new_products as $row)
            <div class="swiper-slide" style="width:150px;"> 
                <div style="height:70%;">
                    <a href="{{ route('catalogues.detail', $row->id) }}">
                        <img src="{{ $row->image != null ? img_src($row->image, 'product') : img_src('default.jpg', '') }}" alt="Product" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';">
                    </a>
                </div>
                <br>
                <div style="height:30%;">
                    <label class="ec-blog-title"><b>{{Str::limit($row->name, 15, $end='...')}}</b></label>
                </div>
            </div>
            @endforeach
                    
      </div>
      <!-- <div class="swiper-pagination"></div> -->
    </div>
</section>