@extends('frontpage-schoko.layouts.main')
@push('style')
<style>
    .error{
        color: red !important;
        font-weight: normal !important;
        font-style: italic !important;
        font-size: small !important;
        margin-bottom: 0px !important;
    }
    .invalid-feedback{
        color: red !important;
        font-weight: normal !important;
        font-style: italic !important;
        font-size: small !important;
        margin-bottom: 0px !important;
    }
</style>
@endpush
@section('content')
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
                            <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="ec-breadcrumb-item active">Register </li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Register</h2>
                    <h2 class="ec-title">Register</h2>
                    <p class="sub-title mb-3">Best place to buy and sell digital products</p>
                </div>
            </div>
            <div class="ec-register-wrapper">
                <div class="ec-register-container">
                    <div class="ec-register-form">
                        <form method="POST" id="form-register" action="{{ route('register') }}">
                            @csrf
                            <span class="ec-register-wrap ec-register-half">
                                <label>{{ __('Name') }}*</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your first name" required />
                                @error('name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>{{ __('E-Mail Address') }}*</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email add..." required />
                                @error('email') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Phone Number*</label>
                                <input type="text" name="phone" placeholder="Enter your phone number"/>
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Address</label>
                                <input type="text" name="address" placeholder="Address Line 1" />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label for="password">{{ __('Password') }}*</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password..." required />
                                @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label for="password-confirm">{{ __('Confirm Password') }}*</label>
                                <input type="password" id="password-confirm" name="password_confirmation" autocomplete="new-password" placeholder="Enter your password confirm..." required />
                            </span>
                            <span class="ec-register-wrap ec-register-btn">
                                <button class="btn btn-primary" type="submit">Register</button>
                                <a class="btn btn-secondary" href="{{ '/auth/redirect'}}">Register By Google</a>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function(){
        $("#form-register").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true,
                },
                password: {
                    required: true,
                },
                password_confirmation: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter name"
                },
                email: {
                    required: "Please enter email"
                },
                phone: {
                    required: "Please enter phone number"
                },
                password: {
                    required: "Please enter password"
                },
                password_confirmation: {
                    required: "Please enter confirm password"
                }
            }
        });
    });
</script>
@endpush
