@extends('frontpage-schoko.layouts.main')

@section('content')
    <!-- Ec breadcrumb start -->
    <!-- <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ __('news.page_title') }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route("home") }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">{{ __('news.page_title') }}</li>
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
            <div class="row" style="margin:10px;">
                <div class="ec-blog-search">
                    <form class="ec-blog-search-form" action="#">
                        <input class="form-control filter_keywords" placeholder="{{ __('news.search_text') }}" type="text">
                        <button class="submit filter_keywords_button" type="button"><i class="ecicon eci-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="ec-blogs-rightside col-lg-12 col-md-12">

                    <!-- Blog content Start -->
                    <div class="ec-blogs-content" id="tag_container">
                        @include('frontpage-schoko.news.news_list')
                    </div>
                    <!--Blog content End -->
                </div>
            </div>
            <div class="row">
                <!-- Sidebar Area Start -->
                <div class="ec-blogs-leftside col-lg-12 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Category Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">{{ __('news.sidebar_category') }}</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    @foreach ($categories as $row)
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" name="category[]" value="{{ $row->id }}" class="filter_categories">
                                                <label class="ml-5 mb-0">{{ session()->get('locale') == 'id' ? $row->name : $row->name_an }}</label>
                                                <span class="checked"></span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Category Block -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();

            $('a').removeClass('active');
            $(this).addClass('active');

            var url = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            getData(page);

        });;

        $('.filter_categories').click(function (e) {
            e.stopImmediatePropagation();
            getData()
            console.log('Clicked');
        });

        $(document).off().on('click', '.filter_keywords_button', function(event) {
            getData()
        });

    });

    function getData(page) {

        console.log(page);

        if (page == undefined) {
            var url = "";
        } else {
            var url = '?page=' + page;
        }

        var categories = getCategory();
        var keywords = $(".filter_keywords").val();
        // body...
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                categories: categories,
                keywords:keywords
            },
            datatype: 'HTML',
        }).done(function(data) {
            $('#tag_container').empty().html(data);
            location.hash = page;
        }).fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });

        function getCategory() {
            var filter = [];
            $('.filter_categories:checked').each(function() {
                filter.push($(this).val());
            });
            return filter;
        }
    }
</script>
@endpush
