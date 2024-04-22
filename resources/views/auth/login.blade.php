
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
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="ec-breadcrumb-item active">Login</li>
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
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Log In</h2>
                    <h2 class="ec-title">Log In</h2>
                    <p id="error-msg-login" style="color: #f12424; font-size: 0.7rem;"></p>
                </div>
            </div>
            <div class="ec-login-wrapper">
                <div class="ec-login-container">
                    <div class="ec-login-form">
                        <form method="POST" id="form-login" action="{{ route('login') }}">
                            @csrf
                            <span class="ec-login-wrap">
                                <label>Email*</label>
                                <input type="email" name="email" placeholder="Enter your email add..." required />
                                @error('email') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                            </span>
                            <span class="ec-login-wrap">
                                <label>Password*</label>
                                <input type="password" name="password" placeholder="Enter your password" required />
                                @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                            </span>
                            <span class="ec-login-wrap ec-login-btn">
                                <button class="btn btn-primary" type="submit">{{ __('Login') }}</button>
                                <a href="{{ '/auth/redirect'}}" class="btn btn-secondary">Login By Google</a>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-primary" href="{{ route('password.request') }}">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
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
        $("#form-login").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {
                email: {
                    required: "Please enter email"
                },
                password: {
                    required: "Please enter password"
                }
            }
        });

        $('#form-login').submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            const data = $('#form-login').serialize();
            // console.log(data);
            showLoader();

            $.ajax({
                url: $('#form-login').attr('action'),
                type: 'POST',
                data: data,
                success: function(response) {
                    hideLoader();
                    var url = `{{ route('home') }}`;
                    location.href = url;
                },
                error: function (request, status, error) {
                    hideLoader();
                    // console.log(request);
                    $('#error-msg-login').html('Email atau password anda salah !')
                }
            });
        });
    });
</script>

@endpush
