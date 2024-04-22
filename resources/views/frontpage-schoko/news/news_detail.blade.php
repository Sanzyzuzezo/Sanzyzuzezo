@extends('frontpage-schoko.layouts.main')
@push('styles')
<link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />
@endpush
@section('content')
<!-- Ec breadcrumb start -->
<!-- <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">{{ __('news_detail.page_title') }}</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ route("home") }}">Home</a></li>
                            <li class="ec-breadcrumb-item"><a href="{{ route("news") }}">{{ __('news_detail.Article') }}</a></li>
                            <li class="ec-breadcrumb-item active">{{ session()->get('locale') == 'id' ? $detail->title : $detail->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Ec breadcrumb end -->

<!-- Ec Blog page -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="ec-blogs-rightside col-lg-12 col-md-12" style="padding:20px;">

                <!-- Blog content Start -->
                <div class="ec-blogs-content">
                    <div class="ec-blogs-inner">
                        <div class="ec-blog-main-img">
                            @php $ext = explode('.', $detail->data_file) @endphp
                            @if (end($ext) == 'jpg' || end($ext) == 'jpeg' || end($ext) == 'gif' || end($ext) == 'png')
                                <img src="{{ img_src($detail->data_file, "news") }}" alt="{{ session()->get('locale') == 'id' ? $detail->title : $detail->title }}" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';">
                            @elseif (end($ext) == 'mp4' || end($ext) == '3gp' || end($ext) == 'wmv' || end($ext) == 'mkv')
                                <video id="my-video" class="video-js" controls preload="auto" width="100%" poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
                                    <source src="{{ img_src($detail->data_file, "news") }}" type="video/mp4" />
                                    <source src="{{ img_src($detail->data_file, "news") }}" type="video/webm" />
                                </video>
                            @else
                                <iframe
                                    width="100%"
                                    height="400px"
                                    src="https://www.youtube.com/embed/{{$detail->data_file}}"
                                    title="YouTube"
                                    frameborder="0"
                                    allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            @endif
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
            <div class="ec-blogs-leftside col-lg-12 col-md-12">
                <!-- <div class="ec-blog-search">
                    <form class="ec-blog-search-form" action="#">
                        <input class="form-control" placeholder="{{ __('news_detail.search_text') }}" type="text">
                        <button class="submit" type="submit"><i class="ecicon eci-search"></i></button>
                    </form>
                </div> -->
                <div class="ec-sidebar-wrap">
                    <!-- Sidebar Recent Blog Block -->
                    <div class="ec-sidebar-block ec-sidebar-recent-blog">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">{{ __('news_detail.sidebar_text') }}</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            @foreach($recent_news as $row)
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-blog-title"><a href="{{ route("news_detail",$row->slug) }}">{{ session()->get('locale') == 'id' ? $row->title : $row->title }}</a></h5>
                                <div class="ec-blog-date">{{ date("M d, Y", strtotime($row->created_at)) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Sidebar Recent Blog Block -->
                    <!-- Sidebar Category Block -->
                    {{-- <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">{{ __('news_detail.sidebar_category') }}</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <ul>
                                @foreach($categories as $row)
                                <li>
                                    <div class="ec-sidebar-block-item">
                                        <input type="checkbox" checked /> <a href="#">{{ session()->get('locale') == 'id' ? $row->name : $row->name }}</a><span
                                            class="checked"></span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div> --}}
                    <!-- Sidebar Category Block -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
{{-- <script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script> --}}
@endpush
