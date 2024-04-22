
@extends('frontpage.layouts.main')

@section('content')
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">{{ __('address_create.user_profile') }}</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">{{ __('address_create.home') }}</a></li>
                                <li class="ec-breadcrumb-item active">{{ __('address_create.address') }}</li>
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
                <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <div class="ec-sidebar-block">
                            <div class="ec-vendor-block">
                                <div class="ec-vendor-block-items">
                                    <ul>
                                        <li><a href="{{ route('profile') }}">{{ __('address_create.user_profile') }}</a></li>
                                        <li><a href="{{ route('address') }}">{{ __('address_create.address') }}</a></li>
                                        <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ec-shop-rightside col-lg-9 col-md-12">
                    <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                        <div class="ec-vendor-card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ec-vendor-block-profile">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <form action="{{ route('save-address') }}" method="post">
                                                    @csrf
                                                    @method('POST')
                                                    <h5 class="mt-4">{{ __('address_create.address_information') }}</h5>
                                                    <div class="form-group mt-4">
                                                        @isset($detail)
                                                            <input type="hidden" value="{{ $detail->id }}" name="address_id">
                                                        @endisset
                                                        <label for="received_name">{{ __('address_create.receive_name') }}</label>
                                                        <input type="text" name="received_name" value="{{ !isset($detail) ? '' : $detail->received_name }}" class="form-control" id="received_name">
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <label for="provinsi-id">{{ __('address_create.province') }}</label>
                                                        <select name="province_id" style="border: 1px solid #d7d7d7 !important;" class="form-control" id="provinsi-id">
                                                            <option value="">{{ __('address_create.select_province') }}</option>
                                                            @foreach ($provinces as $province)
                                                                @if(isset($detail) && $detail->province_id == $province->province_id)
                                                                    <option selected value="{{ $province->province_id }}">{{ $province->title }}</option>
                                                                @else
                                                                    <option value="{{ $province->province_id }}">{{ $province->title }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <label for="city-id">{{ __('address_create.city') }}</label>
                                                        <select disabled="true" name="city_id" style="cursor: not-allowed; border: 1px solid #d7d7d7 !important;" class="form-control" id="city-id">
                                                            <option>{{ __('address_create.select_city') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <label for="subdistrict-id">{{ __('address_create.subdistrict') }}</label>
                                                        <select disabled="true" name="subdistrict_id" style="cursor: not-allowed; border: 1px solid #d7d7d7 !important;" class="form-control" id="subdistrict-id">
                                                            <option>{{ __('address_create.select_subdistrict') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <label for="detail_address">{{ __('address_create.detail_address') }}</label>
                                                        <textarea class="form-control" name="detail_address" id="detail_address" rows="3">{{ !isset($detail) ? '' : $detail->detail_address }}</textarea>
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <div class="form-check form-switch p-0">
                                                            <label class="form-check-label" for="active">{{ __('address_create.make_it_active') }}</label>
                                                            <input class="form-check-input m-1 float-none" type="checkbox" role="switch" id="active" {{ !isset($detail) || (isset($detail) && $detail->active == 1) ? 'checked' : '' }} name="active">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <button class="btn btn-primary" id="save" type="submit">{{ __('address_create.save') }}</button>
                                                    </div>
                                                </form>
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
@endsection
@push('scripts')
<script>
function getCity(params, current_id = null) {
    let province_id = params;
    let actionUrl = `{{ route('getCities') }}`;
    $("#city-id").find('option').not(':first').remove();
    if (province_id != "") {
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": 'POST',
                province_id: province_id
            },
            success: function(data) {
                const list = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                const cities = list.rajaongkir.results;
                cities.forEach(index => {
                    if (current_id != null && index.city_id == current_id) {
                        let city_option = `<option selected value="${index.city_id}">${index.type} ${index.city_name}</option>`;
                        $("#city-id").append(city_option);

                    } else {
                        let city_option = `<option value="${index.city_id}">${index.type} ${index.city_name}</option>`;
                        $("#city-id").append(city_option);

                    }
                });

                $("#city-id").attr("disabled", false);
                $("#city-id").css("background-color", "#FFFF").css("cursor", "pointer");

                $("#subdistrict-id").attr("disabled", true);
                $("#subdistrict-id").css("background-color", "#e9e7e7").css("cursor", "not-allowed");

            }
        });
    } else {

        $("#city-id").attr("disabled", true);
        $("#city-id").css("background-color", "#e9e7e7").css("cursor", "not-allowed");

        $("#subdistrict-id").attr("disabled", true);
        $("#subdistrict-id").css("background-color", "#e9e7e7").css("cursor", "not-allowed");

    }
}

function getKecamatan(params, current_id = null) {
    let city_id = params;
    let actionUrl = `{{ route('getKecamatan') }}`;
    $("#subdistrict-id").find('option').not(':first').remove();
    if (city_id != "") {
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": 'POST',
                city_id: city_id
            },
            success: function(data) {
                const subdistrict = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                const subdistricts = subdistrict.rajaongkir.results;
                subdistricts.forEach(index => {
                    if (current_id != null && index.subdistrict_id == current_id) {
                        let subdistrict_option = `<option selected value="${index.subdistrict_id}">${index.subdistrict_name}</option>`;
                        $("#subdistrict-id").append(subdistrict_option);

                    } else {
                        let subdistrict_option = `<option value="${index.subdistrict_id}">${index.subdistrict_name}</option>`;
                        $("#subdistrict-id").append(subdistrict_option);

                    }
                });

                $("#subdistrict-id").attr("disabled", false);
                $("#subdistrict-id").css("background-color", "#FFFF").css("cursor", "pointer");

            }
        });
    } else {

        $("#subdistrict-id").attr("disabled", true);
        $("#subdistrict-id").css("background-color", "#e9e7e7").css("cursor", "not-allowed");

    }
}

$('#provinsi-id').on('change', function (e) {
    e.stopImmediatePropagation();
    let province_id = $(this).val();
    getCity(province_id);
});

$('#city-id').on('change', function (e) {
    e.stopImmediatePropagation();
    let city_id = $(this).val();
    getKecamatan(city_id);
});


</script>

@isset($detail)
<script>
    let current_province_id = `{!! $detail->province_id !!}`;
    let current_city_id = `{!! $detail->city_id !!}`;
    let current_subdistrict_id = `{!! $detail->subdistrict_id !!}`;
    getCity(current_province_id, current_city_id);
    getKecamatan(current_city_id, current_subdistrict_id);
</script>
@endisset

@endpush
