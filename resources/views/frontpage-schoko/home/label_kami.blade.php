<!-- Label Kami -->
<div class="container my-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" id="tag_container">
            <div class="col-md-12 section-text-title">
                <div class="section-title m-0">
                    <h2 class="ec-bg-title p-0">{{ __('home.brand') }}</h2>
                    <h2 class="ec-title p-0">{{ __('home.brand') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 p-0" id="tag_container">
            <div class="insta-auto" style="width:80%; height:80%">
                @foreach ($brands as $brand)
                    <div class="ec-insta-item">
                        <div class="ec-insta-inner">
                            <img src="{{ asset_administrator("assets/media/brands/$brand->image") }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
  <!-- Label Kami -->