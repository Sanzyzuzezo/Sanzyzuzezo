@extends('frontpage-schoko.layouts.main')

@section('content')

    <!-- Ec Blog page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row" style="margin:10px;">
                <div class="ec-blog-search">
                    <form class="ec-blog-search-form" action="#">
                        <input class="form-control filter_keywords" placeholder="{{ __('event.search_text') }}" type="text">
                        <button class="submit filter_keywords_button" type="button"><i class="ecicon eci-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="ec-blogs-rightside col-lg-12 col-md-12">

                    <!-- Blog content Start -->
                    <div class="ec-blogs-content" id="tag_container">
                        @include('frontpage-schoko.event.event_list')
                    </div>
                    <!--Blog content End -->
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

        });

    });
</script>
@endpush
