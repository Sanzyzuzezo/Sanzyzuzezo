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
            <div class="row" style="width:100%; margin: auto;">
                <a href="{{ route('category_detail', 'all') }}" style="width: 10%; padding:10px;">
                    <i><img src="{{ asset_frontpage("assets/images/icons/menu/new.png") }}" style="max-height: 30px;"></i>
                </a>
                <a href="{{ route('category_detail', 'all') }}" style="width: 40%; padding:10px;">
                    <span> All Product</span>
                </a>
                <a href="{{ route('category_detail', 'new') }}" style="width: 10%; padding:10px;">
                    <i><img src="{{ asset_frontpage("assets/images/icons/menu/new.png") }}" style="max-height: 30px;"></i>
                </a>
                <a href="{{ route('category_detail', 'new') }}" style="width: 40%; padding:10px;">
                    <span> New Product</span>
                </a>
                <a href="{{ route('category_detail', 'best') }}" style="width: 10%; padding:10px;">
                    <i><img src="{{ asset_frontpage("assets/images/icons/menu/new.png") }}" style="max-height: 30px;"></i>
                </a>
                <a href="{{ route('category_detail', 'best') }}" style="width: 40%; padding:10px;">
                    <span> Best</span>
                </a>
                <a href="{{ route('category_detail', 'sale') }}" style="width: 10%; padding:10px;">
                    <i><img src="{{ asset_frontpage("assets/images/icons/menu/new.png") }}" style="max-height: 30px;"></i>
                </a>
                <a href="{{ route('category_detail', 'sale') }}" style="width: 40%; padding:10px;">
                    <span> Sale</span>
                </a>
                @foreach ($categories as $category)
                <a href="#" style="width: 10%; padding:10px;">
                    <i><img src="{{ asset_frontpage("assets/images/icons/menu/new.png") }}" style="max-height: 30px;"></i>
                </a>
                <a href="{{ route('category_detail', $category->id) }}" style="width: 40%; padding:10px; margin-top: 2px;">
                    <span>{{ $category->name }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    @include('frontpage-schoko.menu.menu_product')
    @include('frontpage-schoko.menu.menu_event')

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

        $('.filter_keywords').keyup(function (e) {
            e.stopImmediatePropagation();
            getData()
        });

        $(document).off().on('click', '.filter_keywords_button', function(event) {
            e.stopImmediatePropagation();
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

        // alert(keywords);
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
