@extends('frontpage.layouts.main')

@section('content')
<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">{{ __('pages_detail.page_title') }}</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="ec-breadcrumb-item active">{{ session()->get('locale') == 'id' ? $detail->title : $detail->title }}</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- Ec Blog page -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="ec-blogs-rightside col-lg-8 col-md-12">

                <!-- Blog content Start -->
                <div class="ec-blogs-content">
                    <div class="ec-blogs-inner">
                        <div class="ec-blog-main-img">
                            <img src="{{ img_src($detail->image, "pages") }}" alt="{{ session()->get('locale') == 'id' ? $detail->title : $detail->title }}" />
                        </div>
                        <div class="ec-blog-date">
                            <p class="date">{{ date("M d, Y", strtotime($detail->created_at)) }} </p>
                        </div>
                        <div class="ec-blog-detail">
                            <h3 class="ec-blog-title">{{ session()->get('locale') == 'id' ? $detail->title : $detail->title }}</h3>
                            {!! session()->get('locale') == 'id' ? $detail->description : $detail->description !!}
                        </div>
                    </div>
                </div>
                <!--Blog content End -->
            </div>
            <!-- Sidebar Area Start -->
            <div class="ec-blogs-leftside col-lg-4 col-md-12">
                <div class="ec-blog-search">
                    <form class="ec-blog-search-form" action="#">
                        <input class="form-control" placeholder="{{ __('pages_detail.search_text') }}" type="text">
                        <button class="submit" type="submit"><i class="ecicon eci-search"></i></button>
                    </form>
                </div>
                <div class="ec-sidebar-wrap">
                    <!-- Sidebar Recent Blog Block -->
                    <div class="ec-sidebar-block ec-sidebar-recent-blog">
                        {{-- <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">{{ __('pages_detail.sidebar_text') }}</h3>
                        </div> --}}
                        <div class="ec-sb-block-content">
                            @foreach($recent_pages as $row)
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-blog-title"><a href="{{ route("pages_detail",$row->id) }}">{{ session()->get('locale') == 'id' ? $row->title : $row->title }}</a></h5>
                                <div class="ec-blog-date">{{ date("M d, Y", strtotime($row->created_at)) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Sidebar Recent Blog Block -->
                    <!-- Sidebar Category Block -->
                    <!-- Sidebar Category Block -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')

@endpush
