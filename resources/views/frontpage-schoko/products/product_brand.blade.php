@extends('frontpage-schoko.layouts.main')

@section('content')
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">{{ __('home.brand') }}</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="ec-breadcrumb-item active">{{ __('home.brand') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="ec-blogs-rightside col-lg-8 col-md-12">

                <div class="ec-blogs-content">
                    <div class="ec-blogs-inner">
                        <div class="row">
                            @foreach ($data['brand'] as $brand)
                            <div class="col-md-6 col-sm-12 mb-6 ec-blog-block">
                                <div class="ec-blog-inner">
                                    <div class="ec-blog-image">
                                        <a href="{{ route('brand_detail', $brand->id) }}">
                                            <img class="blog-image" src="{{ asset_administrator("assets/media/brands/$brand->image") }}" alt="{{ $brand->name }}" />
                                        </a>
                                    </div>
                                    <div class="ec-blog-content">
                                        <h5 class="ec-blog-title"><a href="{{ route('brand_detail', $brand->id) }}">{{ $brand->name }}</a></h5>
                                        <div class="ec-blog-btn"><a href="{{ route('brand_detail', $brand->id) }}" class="btn btn-primary">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--Blog content End -->
            </div>
            {{-- <div class="ec-blogs-leftside col-lg-4 col-md-12">
                <div class="ec-blog-search">
                    <form class="ec-blog-search-form" action="#">
                        <input class="form-control" placeholder="Search Our Blog" type="text">
                        <button class="submit" type="submit"><i class="ecicon eci-search"></i></button>
                    </form>
                </div>
                <div class="ec-sidebar-wrap">
                    <div class="ec-sidebar-block ec-sidebar-recent-blog">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Recent Articles</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-blog-title"><a href="blog-detail-left-sidebar.html">The best fashion influencers.</a></h5>
                                <div class="ec-blog-date">February 10, 2021-2022</div>
                            </div>
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-blog-title"><a href="blog-detail-left-sidebar.html">Vogue Shopping Weekend.</a></h5>
                                <div class="ec-blog-date">March 14, 2021-2022</div>
                            </div>
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-blog-title"><a href="blog-detail-left-sidebar.html">Fashion Market Reveals Her Jacket.</a></h5>
                                <div class="ec-blog-date">June 09, 2021-2022</div>
                            </div>
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-blog-title"><a href="blog-detail-left-sidebar.html">Summer Trending Fashion Market.</a></h5>
                                <div class="ec-blog-date">July 17, 2021-2022</div>
                            </div>
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-blog-title"><a href="blog-detail-left-sidebar.html">Winter 2021 Trending Fashion Market</a></h5>
                                <div class="ec-blog-date">August 02, 2021-2022</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
@endsection

@push('scripts')

@endpush
