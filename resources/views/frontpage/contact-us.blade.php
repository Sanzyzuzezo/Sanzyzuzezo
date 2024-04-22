@extends('frontpage.layouts.main')

@push('style')
<style>
    .error {
        color: #f30e0e !important;
        font-size: 0.7rem !important;
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
                            <h2 class="ec-breadcrumb-title">{{ __('contact_us.Contact_Us') }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="index.html">{{ __('contact_us.Home') }}</a></li>
                                <li class="ec-breadcrumb-item active">{{ __('contact_us.Contact_Us') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="ec-common-wrapper">
                        <div class="ec-contact-leftside" style="max-width: 100%;">
                            <div class="ec-contact-container">
                                <div class="ec-contact-form">
                                    <form id="contact-save" action="{{ route('contact-save') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <span class="ec-contact-wrap">
                                            <label>{{ __('contact_us.First_Name') }}*</label>
                                            <input type="text" name="name" />
                                            @if($errors->has('name')) <div class="text-danger"> {{ $errors->first('name')}} </div> @endif
                                        </span>
                                        <span class="ec-contact-wrap">
                                            <label>{{ __('contact_us.Email') }}*</label>
                                            <input type="email" name="email" />
                                            @if($errors->has('email')) <div class="text-danger"> {{ $errors->first('email')}} </div> @endif
                                        </span>
                                        <span class="ec-contact-wrap">
                                            <label>{{ __('contact_us.Phone_Number') }}</label>
                                            <input type="text" name="phone" />
                                            @if($errors->has('phone')) <div class="text-danger"> {{ $errors->first('phone')}} </div> @endif
                                        </span>
                                        <span class="ec-contact-wrap">
                                            <label>{{ __('contact_us.Subject') }}*</label>
                                            <input type="text" name="subject" />
                                            @if($errors->has('subject')) <div class="text-danger"> {{ $errors->first('subject')}} </div> @endif
                                        </span>
                                        <span class="ec-contact-wrap">
                                            <label>{{ __('contact_us.Questions') }}*</label>
                                            <textarea name="description"></textarea>
                                            @if($errors->has('description')) <div class="text-danger"> {{ $errors->first('description')}} </div> @endif
                                        </span>
                                        <span class="ec-contact-wrap ec-contact-btn">
                                            <button id="kt_ecommerce_add_category_submit" class="btn btn-primary" type="submit">Submit</button>
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script src="{{ asset_frontpage('assets/js/validation/contact/contact.js') }}"></script>
<script src="{{ asset_frontpage('assets/js/validation/validation.js') }}"></script>
<script>
    // $('#contact-save').submit(function (e) {
    //     e.preventDefault();
    //     e.stopImmediatePropagation();

    //     const data = $('#contact-save').serialize();
    //     console.log(data);
    //     showLoader();

    //     $.ajax({
    //         url: `{{ route('contact-save') }}`,
    //         type: 'POST',
    //         data: data,
    //         success: function(response) {
    //             hideLoader();
    //             var url = `{{ route('redirect') }}`;
    //             location.href = url;
    //         },
    //         error: function (request, status, error) {
    //             hideLoader();
    //             let err_msg = request.responseJSON.errors
    //             Object.keys(err_msg).forEach(value => {

    //                 if (value == 'description') {
    //                     let error = $('#contact-save').find(`textarea[name=description]`);
    //                     error.attr("placeholder", err_msg[value][0]);
    //                     error.css("border", "1px solid #f18e8e");
    //                 } else {
    //                     let error = $('#contact-save').find(`input[name=${value}]`);
    //                     error.attr("placeholder", err_msg[value][0]);
    //                     error.css("border", "1px solid #f18e8e");
    //                 }

    //             });
    //         }
    //     });
    // });
</script>

@endpush
