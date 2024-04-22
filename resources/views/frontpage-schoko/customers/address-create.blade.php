
@extends('frontpage-schoko.layouts.main')

@push('style')
<style>
    .error {
        color: red;
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
                <div class="ec-vendor-sidebar col-lg-12 col-md-12 section-space-mb">
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
                                                <form action="{{ route('save-address') }}" id="form-address" method="post">
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
                                                                    <option title="{{ $province->title }}" selected value="{{ $province->province_id }}">{{ $province->title }}</option>
                                                                @else
                                                                    <option title="{{ $province->title }}" value="{{ $province->province_id }}">{{ $province->title }}</option>
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
                                                        <label for="postal_code">Pilih Kode Pos</label>
                                                        <div id="list-postal-code"></div>
                                                        <br><br>
                                                        <input type="text" readonly name="postal_code" value="{{ !isset($detail) ? '' : $detail->postal_code }}" class="form-control" id="postal_code">
                                                    </div>
                                                    <div class="form-group mt-4">
                                                        <label for="detail_address">Alamat Lengkap</label>
                                                        <textarea class="form-control" name="detail_address" id="detail_address" rows="3">{{ !isset($detail) ? '' : $detail->detail_address }}</textarea>
                                                    </div>
                                                    <div class="form-group mt4">
                                                        <label for="no_telepon">No Telepon</label>
                                                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ !isset($detail) ? '' : $detail->no_telepon }}">
                                                    </div>
                                                    <div class="form-group mt4">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="{{ !isset($detail) ? '' : $detail->email }}">
                                                    </div>
                                                    {{-- <div class="form-group mt-4">
                                                        <label for="detail_address">Patokan</label>
                                                        <textarea class="form-control" name="detail_address" id="detail_address" rows="3">{{ !isset($detail) ? '' : $detail->detail_address }}</textarea>
                                                    </div> --}}
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function () {
        $("#form-address").validate({
            rules: {
                received_name: {
                    required: true,
                },
                province_id: {
                    required: true,
                },
                city_id: {
                    required: true,
                },
                subdistrict_id: {
                    required: true,
                },
                postal_code: {
                    required: true,
                },
                detail_address: {
                    required: true,
                },
                no_telepon: {
                    required: true,
                },
                email: {
                    required: true,
                }
            },
            messages: {
                received_name: {
                    required: "silahkan masukan nama"
                },
                province_id: {
                    required: "silahkan masukan provinsi"
                },
                city_id: {
                    required: "silahkan masukan kabupaten/kota"
                },
                subdistrict_id: {
                    required: "silahkan masukan kecamatan"
                },
                postal_code: {
                    required: "silahkan pilih kode pos"
                },
                detail_address: {
                    required: "silahkan masukan alamat lengkap"
                },
                no_telepon: {
                    required: "silahkan masukan nomor telepon"
                },
                email: {
                    required: "silahkan masukan email"
                }
            }
        });
    });
</script>
<script>

const bite_ship_url = `{{ url('api/bitship') }}`;

const getDestinations = (district, city, destination_plan) => {

    $.ajax({
        type: "POST",
        url: `${bite_ship_url}/destinations`,
        data: {
            destination: destination_plan
        },
        success: function (response) {

            console.log('Response', response);

            const list = (typeof response == "string") ? jQuery.parseJSON(response) : response;
            let destination;
            if (list.areas.length === 1) {
                let destination = list.areas[0]
                firstDestination(destination);
            } else {

                let destination = list.areas.find(
                    row => district.includes(row.administrative_division_level_3_name),
                    row => city.includes(row.administrative_division_level_2_name)
                );
                firstDestination(destination);
            }
            // firstDestination(destination)
        }
    });
}

const firstDestination = (destination) => {
    // console.log(destination);
    $.ajax({
        type: "POST",
        url: `${bite_ship_url}/first-destination`,
        data: {
            id: destination.id
        },
        success: function (response) {
            $("#list-postal-code").empty();
            const list = (typeof response == "string") ? jQuery.parseJSON(response) : response;
            list.areas.forEach(index => {
                let postal_code =
                    `<a class="btn btn-sm btn-primary postalcode-change" style="border-radius: 26px;" postalcode-change="${index.postal_code}">${index.postal_code}</a>&nbsp;&nbsp;`;
                $("#list-postal-code").append(postal_code);
            });
        }
    });
}

function getCity(params, current_id = null) {
    let province_id = params;
    $("#city-id").find('option').not(':first').remove();
    if (province_id != "") {
        $.ajax({
            type: "POST",
            url: `${bite_ship_url}/cities`,
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": 'POST',
                province_id: province_id
            },
            success: function(data) {

                const cities = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                cities.forEach(index => {
                    if (current_id != null && index.id == current_id) {
                        let city_option = `<option title="${index.title}" selected value="${index.id}">${index.type} ${index.title}</option>`;
                        $("#city-id").append(city_option);

                    } else {
                        let city_option = `<option title="${index.title}" value="${index.id}">${index.type} ${index.title}</option>`;
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
    $("#subdistrict-id").find('option').not(':first').remove();
    if (city_id != "") {
        $.ajax({
            type: "POST",
            url: `${bite_ship_url}/districts`,
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": 'POST',
                city_id: city_id
            },
            success: function(data) {

                const subdistricts = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                subdistricts.forEach(index => {
                    if (current_id != null && index.id == current_id) {
                        let subdistrict_option = `<option title="${index.title}" selected value="${index.id}">${index.title}</option>`;
                        $("#subdistrict-id").append(subdistrict_option);

                    } else {
                        let subdistrict_option = `<option title="${index.title}" value="${index.id}">${index.title}</option>`;
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

$('#subdistrict-id').off().change(function(e) {

    let district = $('option:selected', '#subdistrict-id').attr("title");
    let city = $('option:selected', '#city-id').attr("title");
    let province = $('option:selected', '#provinsi-id').attr("title");
    // let destination_plan = district + ' ' + city;
    let destination_plan = district;

    getDestinations(district, city, destination_plan);

});

$(document).on('click', '.postalcode-change', function (event) {

    event.preventDefault();
    $('.postalcode-change').removeClass("btn-success").addClass("btn-primary");
    $(this).removeClass("btn-primary").addClass("btn-success");
    let destination = $(this).attr('postalcode-change');
    $('#postal_code').val(destination);

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
