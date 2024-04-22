<script>

const bite_ship_url = `{{ url('api/bitship') }}`;
let provinces = `{!! $provinces !!}`;
provinces = JSON.parse(provinces);
var global_post_code = '';

const internal_courier_price = `{{ $internal_courier_price }}`;

$.ajax({
    type: "POST",
    url: `${bite_ship_url}/origins`,
    success: function (response) {
        const list = (typeof response == "string") ? jQuery.parseJSON(response) : response;
        $(".select-origins").find('option').remove();
        let key = 0;
        list.locations.forEach(index => {
            let selected = '';
            let coordinate = typeof index.coordinate === 'object' ? JSON.stringify(index.coordinate) : index.coordinate
            if (key === 0) {
                selected = 'selected';
                $('#origin_coordinate').val(coordinate);
                $('#origin_postal_code').val(index.postal_code);
                $('#origin_name').val(index.name);
                $('#origin_address').val(index.address);
                $('#origin_contact_phone').val(index.contact_phone);
                $('#store_id').val(index.id);
            }

            let city_option =
                `<option
                    ${selected}
                    latitude="${index.coordinate.latitude}"
                    name="${index.name}"
                    longitude="${index.coordinate.longitude}"
                    coordinate="${coordinate}"
                    postal-code="${index.postal_code}"
                    value="${index.id}"
                    data-name="${index.contact_name}"
                    data-contact_phone="${index.contact_phone}"
                    data-address="${index.address}">${index.contact_name},  ${index.address}</option>`;
            $(".select-origins").append(city_option);
            key++;
        });
        if (list.locations.length === 1) {
            $('#origin_coordinate').val(list.locations[0].coordinate);
            $('#origin_postal_code').val(list.locations[0].postal_code);
            $('#origin_name').val(list.locations[0].name);
            $('#origin_address').val(list.locations[0].address);
            $('#origin_contact_phone').val(list.locations[0].contact_phone);
        }
        getOngkirWhenAddessActive();
    }
});


$(document).on('click', '.addresses', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    showLoader();
    let origin = dataOrigin();
    showHideInternal();
    const shipping = {
        province_id: $(this).data('shipping_province'),
        city_id: $(this).data('shipping_city'),
        subdistrict_id: $(this).data('shipping_distric'),
        origin_province_id: origin.provinsi,
        origin_city_id: origin.kota,
        origin_subdistrict_id: origin.kecamatan,
        courier: $('.courier').val(),
        address_id: $(this).data('addres_id'),
        weight_total: $('#weight_total').val()
    }
    saveAndGetAddressUser(shipping);
});

function dataOrigin() {
    const origin = {
        provinsi: $('.select-origins').find(':selected').data('province_id'),
        kota: $('.select-origins').find(':selected').data('city_id'),
        kecamatan: $('.select-origins').find(':selected').data('subdistrict_id'),
    }
    return origin;
}

function showHideInternal() {

    let active_address = $(document).find('.active_address');

    let destination_city = active_address.find('.shipping_city').val();

    let selected = $('.courier').find(":selected").val();
    if (selected == 'internal_courier') {
        $('.courier option:eq(2)').prop('selected', true)
    }
}

function saveAndGetAddressUser(shipping) {
    $.ajax({
        url: '{{ route('save-address') }}',
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "_method": 'POST',
            address_id: shipping.address_id,
            active: 1
        },
        success: function(response) {
            $('.exiting-address-list').empty();
            response.forEach(index => {
                let active_address = index.active == 1 ? "active_address" : "";
                let background = index.active == 1 ? "background-color: #F7F7F7" : "";
                let icon_check = index.active == 1 ?
                    '<i class="ecicon eci-check" aria-hidden="true"></i>' : '';

                let address_input = '';

                if (index.active == 1) {
                    address_input = `<input type="hidden" value="${index.subdistrict_id}" class="shipping_distric" name="shipping_distric">
                        <input type="hidden" value="${index.kecamatan_name}" class="shipping_distric_label" name="shipping_distric_label">
                        <input type="hidden" value="${index.city_id}" class="shipping_city" name="shipping_city">
                        <input type="hidden" value="${index.city_type} ${index.city_name}" class="shipping_city_label" name="shipping_city_label">
                        <input type="hidden" value="${index.province_id}" class="shipping_province" name="shipping_province">
                        <input type="hidden" value="${index.province_name}" class="shipping_province_label" name="shipping_province_label">
                        <input type="hidden" value="${index.id}" class="addres_id" name="addres_id">
                        <input type="hidden" value="${index.detail_address}" class="customer_address" name="customer_address">
                        <input type="hidden" value="${index.received_name}" class="customer_name" name="customer_name">
                        <input type="hidden" value="${index.postal_code}" class="existingaddress shipping_postal_code_label" name="shipping_postal_code_label">

                        `
                }

                let element_address = `<div
                    data-shipping_province="${index.province_id}"
                    data-shipping_city="${index.city_id}"
                    data-shipping_distric="${index.subdistrict_id}"
                    data-addres_id="${index.id}"
                    class="card mt-4 addresses ${active_address}" style="width: 100%; ${background}">
                    <div class="card-body">
                        <div class="card-title d-flex">
                            <h5 style="margin-right: 10px; color: green;"> ${icon_check} </h5>
                            <h5>Nama Penerima :  ${index.received_name} </h5>
                        </div>
                        <hr style="background-color: #2f4f4f;">
                        <p class="card-text"> ${index.detail_address }</p>
                        <p class="card-text">Kecamatan  ${index.kecamatan_name}   ${index.city_type}   ${index.city_name} ,  ${index.province_name} </p>
                        ` +
                    address_input +
                    `
                    </div>
                </div>`;
                $('.exiting-address-list').append(element_address);

                $('.shipping_cost_text').html('Rp. 0');
                $('.shipping_cost').val('');
            });
            let origins = $('option:selected', '.select-origins').attr('postal-code');

            // getOngkir(shipping);
            let active_address = $(document).find('.active_address');
            let destination_postal_code = active_address.find('.shipping_postal_code_label').val();

            ratesCourier(origins, destination_postal_code);
        },
        error: function(request, status, error) {
            hideLoader();
            let params = {
                icon: 'error',
                title: 'Terjadi kesalahan atau koneksi terputus !'
            }
            showAlaret(params);
        }
    });
}

const getDestinations = (district, city, area) => {

    showLoader();

    $.ajax({
        type: "POST",
        url: `${bite_ship_url}/destinations`,
        data: {
            destination: area
        },
        success: function (response) {

            const list = (typeof response == "string") ? jQuery.parseJSON(response) : response;
            let destination;
            if (list.areas.length === 1) {
                destination = list.areas[0]
            } else {
                destination = list.areas.find(
                    row => district.includes(row.administrative_division_level_3_name),
                    row => city.includes(row.administrative_division_level_2_name)
                );
            }
            firstDestination(destination)
            hideLoader();
        }
    });
}

const firstDestination = (destination) => {

    showLoader();
    // Jika Destinasi Tujuan Ditemukan
    if (destination) {
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
                hideLoader();
            }
        });
    } else {
        // Jika tidak ada coba kirimkan lagi dengan hanya mengirimkan kata kunci nama kota
        let district = $('option:selected', '.select-district').attr("title");
        let city = $('option:selected', '.select-city').attr("title");
        let destination_plan = getDataDestinationCLient();

        let area = `${destination_plan.city}`;

        getDestinations(district, city, area);
        hideLoader();
    }


}

const getDataDestinationCLient = () => {

    return {
        'district': $('option:selected', '.select-district').attr("title"),
        'city': $('option:selected', '.select-city').attr("title"),
        'province': $('option:selected', '.select-province').attr("title"),
    }

}

const getDataOrderListInformations = () => {
    let orders = [];

    $('.cart-list').each(function () {

        let dimensions = $(this).find('.dimensions').val();

        dimensions = typeof dimensions == 'string' ? jQuery.parseJSON(dimensions) : dimensions;

        let order = {
            'name': $(this).find('.product-variant').html(),
            'weight': $(this).find('.weight').val() || 0,
            'quantity': $(this).find('.quantity').val() || 0,
            'description': $(this).find('.note').val() || 0,
            'length': dimensions.length || 0,
            'width': dimensions.width || 0,
            'height': dimensions.height || 0,
        }
        orders.push(order)
    });
    return orders;
}

const ratesCourier = (origin, destination) => {

    showLoader();
    $.ajax({
        type: "POST",
        url: `${bite_ship_url}/shipping-cost`,
        data: {
            origin_post_code: origin,
            destination_post_code: destination,
            items: getDataOrderListInformations()
        },
        success: function (response) {
            const couriers = (typeof response == "string") ? jQuery.parseJSON(response) : response;
            $(".courier").find('option').not(':first').remove();
            couriers.pricing.forEach(index => {
                let option = `<option value="${index.courier_name}" price="${index.price}" service="${index.courier_service_code}" estimated="${index.shipment_duration_range}" waybill="${index.available_for_instant_waybill_id}" unit="${index.shipment_duration_unit}">
                    ${index.courier_name} -
                    ${index.courier_service_name}
                    ${index.shipment_duration_range} ${index.shipment_duration_unit == 'days' ? 'Hari' : 'Jam'}
                    Rp. ${new Intl.NumberFormat('de-DE', { currency: 'EUR' }).format(index.price)}
                </option>`;
                $(".courier").append(option);
            });
            global_post_code = destination;
            hideLoader();
        }
    });
}

function getOngkirWhenAddessActive() {

    let active_address = $(document).find('.active_address');

    if (active_address.length > 0) {

        let origin = $('option:selected', '.select-origins').attr('postal-code');
        let destination = active_address.find('.shipping_postal_code_label').val();
        // console.log('origin : ' + origin);
        // console.log('destination : ' + destination);

        if (origin && destination) {
            ratesCourier(origin, destination);
        } else {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'warning',
                title: 'Silahkan isi dan pilih alamat tujuan !'
            });
        }
    }
}

$(document).ready(function() {

    $(".select-origins").change(function () {
        // console.log($(this).find(':selected').data("name"));
        $('#origin_coordinate').val($(this).find(':selected').attr("coordinate"));
        $('#origin_postal_code').val($(this).find(':selected').attr("postal-code"));
        $('#origin_name').val($(this).find(':selected').attr("name"));
        $('#origin_address').val($(this).find(':selected').data("address"));
        $('#origin_contact_phone').val($(this).find(':selected').data("contact_phone"));
        $('#store_id').val($(this).find(':selected').val());
    })

    $(this).find('#order').off().click(function(e) {
        store_id = $('.select-origins').find(':selected').val();
        $('#store_id').val(store_id);

        store_name = $('.select-origins').find(':selected').data('name');
        $('#store_name').val(store_name);
    });

    $('.payment_method').off().change(function(e) {
        var payment_method = $(this).val();
        if (payment_method == "other") {
            $(".bank_account-select").hide();
        } else {
            $(".bank_account-select").show();
        }
    });

    $('.select-province').off().change(function(e) {

        let title = $('option:selected', this).attr('title');
        let id = $(this).val();
        var selected_label = $('option:selected', this).text();

        showLoader();
        $.ajax({
            url: `${bite_ship_url}/cities`,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": 'POST',
                province_id: id
            },
            dataType: "JSON",
            success: function(data) {

                $(".select-city").find('option').not(':first').remove();
                $(".select-district").find('option').not(':first').remove();
                $('.shipping_cost_text').html('Rp. 0');
                $('.shipping_cost').val('');
                $('#shipping_province_label').val(selected_label);

                $('.postalcode-change').remove();
                $('#postalcode').val('');
                $(".courier").find('option').not(':first').remove();

                const list = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                list.forEach(index => {
                    let city_option =
                        `<option title="${index.title}" value="${index.id}">${index.type} ${index.title}</option>`;
                    $(".select-city").append(city_option);
                });
                hideLoader();
            }
        });

    });

    $('.select-city').off().change(function(e) {

        var selected_data = $(this).val();
        var selected_label = $('option:selected', this).text();
        showLoader();

        $.ajax({
            url: `${bite_ship_url}/districts`,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": 'POST',
                city_id: selected_data
            },
            dataType: "JSON",
            success: function(data) {

                $(".select-district").find('option').not(':first').remove();
                $('.shipping_cost_text').html('Rp. 0');
                $('.shipping_cost').val('');
                $('#shipping_city_label').val(selected_label);

                $('.postalcode-change').remove();
                $('#postalcode').val('');
                $(".courier").find('option').not(':first').remove();

                const list = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                list.forEach(index => {
                    let district_option =
                        `<option title="${index.title}" value="${index.id}">${index.title}</option>`;
                    $(".select-district").append(district_option);
                });
                hideLoader();
            }
        });
    });

    $('.select-district').off().change(function(e) {

        var selected_data = $(this).val();
        var selected_label = $('option:selected', this).text();
        let district = $('option:selected', '.select-district').attr("title");
        let city = $('option:selected', '.select-city').attr("title");
        let destination_plan = getDataDestinationCLient();

        $('#shipping_distric_label').val(selected_label);
        let area = `${destination_plan.district}+${destination_plan.city}`;
        getDestinations(district, city, area);

    });

    $(document).on('click', '.postalcode-change', function (event) {

        event.preventDefault();

        let this_post_code = $(this);
        let destination = $(this).attr('postalcode-change');
        let origin = $('option:selected', '.select-origins').attr('postal-code');

        if (global_post_code != destination) {
            ratesCourier(origin, destination);
            $('.postalcode-change').removeClass("btn-success").addClass("btn-primary");
            this_post_code.removeClass("btn-primary").addClass("btn-success");
            $('#postalcode').val(destination);
        }

    });

    $('.courier').change(function (e) {

        e.preventDefault();

        let value = $(this).val();
        let price = $(this).find(':selected').attr('price');
        let estimated = $(this).find(':selected').attr('estimated');
        let unit = $(this).find(':selected').attr('unit');
        let waybill = $(this).find(':selected').attr('waybill');
        let courier_service = $(this).find(':selected').attr('service');

        let format = Intl.NumberFormat('en-US');
        let price_format = format.format(price);
        let total_order = $('.total').val();

        $('.shipping_cost_text').html('Rp. ' + price_format);
        $('.shipping_cost').val(price);
        $('.shipping_waybill').val(waybill);
        $(".courier-service").val(courier_service);

        let total_amount = parseInt(total_order) + parseInt(price)
        $('.total_amount').html('Rp. ' + format.format(total_amount))

    });

});
</script>


