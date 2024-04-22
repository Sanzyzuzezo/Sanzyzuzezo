
@extends('frontpage.layouts.main')

@section('content')
<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">{{ __('order_history.user_profile') }}</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">{{ __('order_history.home') }}</a></li>
                            <li class="ec-breadcrumb-item active">{{ __('order_history.user_profile') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- User history section -->
<section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
    <div class="container">
        <div class="row">

            @include("frontpage.customers.sidebar")

            <div class="ec-shop-rightside col-lg-9 col-md-12">
                <div class="ec-vendor-dashboard-card">
                    <div class="ec-vendor-card-header">
                        <h5>{{ __('order_history.user_profile') }}</h5>
                        <div class="ec-header-btn">
                            <a class="btn btn-lg btn-primary" href="{{ route("catalogues") }}">{{ __('order_history.show_now') }}</a>
                        </div>
                    </div>
                    <div class="ec-vendor-card-body">
                        <div class="ec-vendor-card-table" id="tag_container">
                            @include('frontpage.customers.order_list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End User history section -->

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

            $(document).on('click', '.filter_categories', function(event) {
                getData()
            });

            $(document).on('click', '.filter_brands', function(event) {
                getData()
            });

            $(document).on('keyup', '.min_price', function(event) {
                getData()
            });

            $(document).on('keyup', '.max_price', function(event) {
                getData()
            });

            $(document).on('change', '#ec-select', function(event) {
                getData()
            });


        });

        function getData(page) {
            if (page == undefined) {
                var url = "";
            } else {
                var url = '?page=' + page;
            }
            var categories = getCategory();
            var brands = getBrand();
            var min_price = $(".min_price").val();
            var max_price = $(".max_price").val();
            var order_data = $("#ec-select").val();
            // body...
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    categories: categories,
                    brands: brands,
                    min_price: min_price,
                    max_price: max_price,
                    order_data: order_data
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

            function getBrand() {
                var filter = [];
                $('.filter_brands:checked').each(function() {
                    filter.push($(this).val());
                });
                return filter;
            }
        }
    </script>
@endpush
