
@extends('frontpage-schoko.layouts.main')

@push('style')
<style>
    /* Float cancel and delete buttons and add an equal width */
    .cancelbtn, .deletebtn {
    float: left;
    width: 50%;
    }

    /* Add a color to the cancel button */
    .cancelbtn {
    background-color: #ccc;
    color: black;
    }

    /* Add a color to the delete button */
    .deletebtn {
    background-color: #f44336;
    }

    /* Add padding and center-align text to the container */
    .containerx {
    padding: 16px;
    text-align: center;
    }

    /* The Modal (background) */
    .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: #a0a0a06b;
    padding-top: 50px;
    }

    /* Modal Content/Box */
    .modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 47%; /* Could be more or less, depending on screen size */
    }

    /* Style the horizontal ruler */
    hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
    }

    /* The Modal Close Button (x) */
    .close {
    position: absolute;
    right: 35px;
    top: 15px;
    font-size: 40px;
    font-weight: bold;
    color: #f1f1f1;
    }

    .close:hover,
    .close:focus {
    color: #f44336;
    cursor: pointer;
    }

    /* Clear floats */
    .clearfix::after {
    content: "";
    clear: both;
    display: table;
    }

    /* Change styles for cancel button and delete button on extra small screens */
    @media screen and (max-width: 300px) {
        .cancelbtn, .deletebtn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
    <div class="sticky-header-next-sec  ec-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ __('address_list.user_profile') }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">{{ __('address_list.home') }}</a></li>
                                <li class="ec-breadcrumb-item active">{{ __('address_list.address') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-shop-leftside ec-vendor-sidebar col-lg-12 col-md-12 section-space-mb">
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-vendor-block">
                                <div class="ec-vendor-block-items">
                                    <ul>
                                        <li><a href="{{ route('profile') }}">{{ __('profile.user_profile') }}</a></li>
                                        <li><a href="{{ route('address') }}">{{ __('profile.address') }}</a></li>
                                        <li><a href="{{ route('order_history') }}">{{ __('profile.transaction') }}</a></li>
                                        <li><a href="{{ route('cart') }}">Cart</a></li>
                                        <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                        <div class="ec-vendor-card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ec-vendor-block-profile">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                @foreach ($list_address as $address)
                                                <div class="card mb-4">
                                                    <div class="card-header">
                                                        {{ __('address_list.receive_name') }}: {{ $address->received_name }}
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $address->kecamatan_name }} {{ $address->city_name .', '. $address->province_name }}</h5>
                                                        <p class="card-text">{{ $address->detail_address }}</p>
                                                        <div class="d-flex">
                                                            <a style="margin-right: 20px;" href="#" onclick="event.preventDefault(); document.getElementById('edit-form-{{ $address->id }}').submit();" class="btn btn-secondary">{{ __('address_list.edit') }}</a>
                                                            <form id="edit-form-{{ $address->id }}" style="display: none;" method="POST" action="{{ route('address') }}">
                                                                @csrf
                                                                @method('POST')
                                                                <input type="hidden" name="address_id" value="{{ $address->id }}">
                                                            </form>
                                                            <a style="margin-right: 20px;" href="#" onclick="event.preventDefault();" data-id="{{ $address->id }}" class="btn btn-danger delete-address">{{ __('address_list.delete') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <a href="{{ route('create-address') }}" class="btn btn-primary">{{ __('address_list.add_address') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
        <form method="POST" class="modal-content" action="{{ route('address') }}">
            @csrf
            @method('DELETE')
            <input type="hidden" id="address_id" name="address_id" value="">
            <div class="containerx">
            <h1>{{ __('address_list.delete') }} {{ __('address_list.address') }}</h1>
            <p>{{ __('address_list.delete_alert') }}</p>
            <div class="clearfix">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">{{ __('address_list.cancel') }}</button>
                <button type="submit" onclick="document.getElementById('id01').style.display='none'" class="deletebtn">{{ __('address_list.delete') }}</button>
            </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
<script>

$('.delete-address').click(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    let data_id = $(this).data("id");
    $('#address_id').val(data_id);
    document.getElementById('id01').style.display='block'

});

</script>
@endpush

