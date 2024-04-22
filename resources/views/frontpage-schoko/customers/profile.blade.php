
@extends('frontpage-schoko.layouts.main')

@section('content')
    <div class="sticky-header-next-sec  ec-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ __('profile.user_profile') }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">{{ __('profile.home') }}</a></li>
                                <li class="ec-breadcrumb-item active">{{ __('profile.address') }}</li>
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
                                        <div class="ec-vendor-block-img space-bottom-30">
                                            <div class="ec-vendor-block-bg">
                                                <a href="#" class="btn btn-lg btn-primary"
                                                data-link-action="editmodal" title="Edit Detail"
                                                data-bs-toggle="modal" data-bs-target="#edit_modal">Edit Detail</a>
                                            </div>
                                            <div class="ec-vendor-block-detail">
                                                <img class="v-img" src="{{ $detail->image != "" ? asset('administrator/assets/media/customers/'.$detail->image) : asset('frontpage/assets/images/user/default.png') }}" alt="vendor image">
                                                <h5 class="name">{{ $detail->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <h5>{{ __('profile.account_information') }}</h5>
                                                <div class="form-group mt-4">
                                                    <label for="full-name">{{ __('profile.full_name') }}</label>
                                                    <input type="text" name="name" value="{{ $detail->name }}" readonly class="form-control" id="full-name">
                                                </div>
                                                @if($detail->customer_group_id != 0)
                                                <div class="form-group mt-4">
                                                    <label for="full-name">{{ __('profile.customer_group') }}</label>
                                                    <input type="text" name="name" value="{{ $detail->customer_group_name }}" readonly class="form-control" id="full-name">
                                                </div>
                                                @endif
                                                <div class="form-group mt-4">
                                                    <label>{{ __('profile.email_address') }}</label>
                                                    <input type="email" value="{{ $detail->email }}" readonly class="form-control">
                                                </div>
                                                <div class="form-group mt-4">
                                                    <label for="telephone">{{ __('profile.phone_number') }}</label>
                                                    <input type="text" name="phone" value="{{ $detail->phone }}" readonly class="form-control" id="telephone">
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
        </div>
    </section>
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="ec-vendor-block-img space-bottom-30">
                            <form action="{{ route('save-profile') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="ec-vendor-block-bg cover-upload">
                                    <div class="thumb-upload">
                                        <div class="thumb-edit">
                                        </div>
                                        <div class="thumb-preview ec-preview">
                                            <div class="image-thumb-preview">
                                                <img class="image-thumb-preview ec-image-preview v-img" src="{{ asset('frontpage/assets/images/banner/8.jpg') }}" alt="edit" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ec-vendor-block-detail">
                                    <div class="thumb-upload">
                                        <div class="thumb-edit">
                                            <input type='file' name="image" id="thumbUpload02" class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                            <label><img src="{{ asset('frontpage/assets/images/icons/edit.svg') }}" class="svg_img header_svg" alt="edit" /></label>
                                        </div>
                                        <div class="thumb-preview ec-preview">
                                            <div class="image-thumb-preview">
                                                {{--  --}}
                                                <img class="image-thumb-preview ec-image-preview v-img" src="{{ $detail->image != "" ? asset('administrator/assets/media/customers/'.$detail->image) : asset('frontpage/assets/images/user/1.jpg') }}" alt="edit" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ec-vendor-upload-detail">
                                    <div class="row g-3">
                                        <div class="col-md-6 space-t-15">
                                            <label for="full-name">{{ __('profile.full_name') }}</label>
                                            <input type="text" name="name" value="{{ $detail->name }}" class="form-control" id="full-name">
                                        </div>
                                        <div class="col-md-6 space-t-15">
                                            <label>{{ __('profile.email_address') }}</label>
                                            <input type="email" value="{{ $detail->email }}" readonly class="form-control">
                                        </div>
                                        <div class="col-md-6 space-t-15">
                                            <label for="telephone">{{ __('profile.phone_number') }}</label>
                                            <input type="text" name="phone" value="{{ $detail->phone }}" class="form-control" id="telephone">
                                        </div>
                                        <div class="col-md-12 space-t-15">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <a href="#" class="btn btn-lg btn-secondary qty_close" data-bs-dismiss="modal" aria-label="Close">{{ __('profile.close') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
</script>
@endpush

