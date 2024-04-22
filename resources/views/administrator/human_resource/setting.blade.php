@extends('administrator.layouts.main')

@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <style>
        #map { height: 500px; }
    </style>
@endpush

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Settings</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">HR Setting</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <form id="form_add" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('admin.human_resource.update_setting') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>HR Setting</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Jam Masuk</label>
                                    <input type="time" name="jam_masuk" class="form-control mb-2" placeholder="Jam Masuk" value="{{ $setting->jam_masuk }}" />
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Jam Keluar</label>
                                    <input type="time" name="jam_keluar" class="form-control mb-2" placeholder="Jam Keluar" value="{{ $setting->jam_keluar }}" />
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Tanggal Tutup Buku</label>
                                    <input type="text" name="tanggal_tutup_buku" class="form-control mb-2" placeholder="Tanggal Tutup Buku" value="{{ $setting->tanggal_tutup_buku }}" />
                                </div>
                                {{-- <div class="mb-10 fv-row">
                                    <label class="required form-label">Radius Absen</label>
                                    <div id="map"></div>
                                </div>
                                <div class="mb-10 d-flex-justify-content-end">
                                    <button type="button" id="pilih_ulang" class="btn btn-secondary" disabled>
                                        <span class="indicator-label">Pilih Ulang</span>
                                    </button>
                                    <button type="button" id="set_data" class="btn btn-success" style="display: none">
                                        <span class="indicator-label">Set Data</span>
                                    </button>
                                </div>
                                <div class="mb-10 fv-row">
                                    <input type="hidden" name="master_lat" id="master_lat" value="<?php echo $setting->master_lat; ?>">
                                    <input type="hidden" name="master_long" id="master_long" value="<?php echo $setting->master_long; ?>">
                                    <input type="hidden" name="maks_lat" id="maks_lat" value="<?php echo $setting->maks_lat; ?>">
                                    <input type="hidden" name="maks_long" id="maks_long" value="<?php echo $setting->maks_long; ?>">
                                    <input type="hidden" name="radius" id="radius" value="<?php echo $setting->radius; ?>">
                                </div> --}}
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                                <span class="indicator-label">Save Changes</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
crossorigin=""></script>
<script>

    (function($) {
        $.fn.inputFilter = function(callback, errMsg) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
            if (callback(this.value)) {
                // Accepted value
                if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
                    $(this).removeClass("input-error");
                    this.setCustomValidity("");
                }
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                // Rejected value - restore the previous one
                $(this).addClass("input-error");
                this.setCustomValidity(errMsg);
                this.reportValidity();
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                // Rejected value - nothing to restore
                this.value = "";
            }
            });
        };
    }(jQuery));

</script>
<script>
    var map = L.map('map').setView([<?php echo $setting->master_lat; ?>, <?php echo $setting->master_long; ?>], 16);
    map.touchZoom.disable();
    map.doubleClickZoom.disable();
    map.scrollWheelZoom.disable();
    map.boxZoom.disable();
    map.keyboard.disable();
  
    if (map.tap) map.tap.disable();
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var radius_awal = <?php echo $setting->radius; ?>

    var marker = L.marker([<?php echo $setting->master_lat; ?>, <?php echo $setting->master_long; ?>], { title: 'ini title'}).addTo(map);
    marker.bindPopup("<b>Disini Kantornya</b>", { closeOnClick: false, autoClose: false }).openPopup();
    // var marker_radius = changeRadius(<?php echo $setting->radius; ?>);
    var marker_radius =  L.circle([<?php echo $setting->master_lat; ?>, <?php echo $setting->master_long; ?>], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius_awal
        }).addTo(map);

    var marker_maks = L.marker([<?php echo $setting->maks_lat; ?>, <?php echo $setting->maks_long; ?>]).addTo(map);
    marker_maks.bindPopup("<b>Maksimal Radius Absen "+radius_awal.toFixed(2)+" Meter</b>").openPopup();

    map.on('click', onMapClick);
 
    function onMapClick(e) {
        $('#pilih_ulang').prop('disabled', false)
        $('#set_data').css('display', 'inline-flex')
        $('#kt_ecommerce_add_category_submit').prop('disabled', true)
        map.removeLayer(marker_maks).removeLayer(marker_radius)
        marker_maks = new L.Marker([e.latlng.lat, e.latlng.lng, {dragable: true}]);
        map.addLayer(marker_maks)
        var radius = distance(<?php echo $setting->master_lat; ?>, <?php echo $setting->master_long; ?>, e.latlng.lat, e.latlng.lng);
        marker_radius = new L.circle([<?php echo $setting->master_lat; ?>, <?php echo $setting->master_long; ?>], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        })
        marker_maks.bindPopup("<b>Maksimal Radius Absen "+radius.toFixed(2)+" Meter</b>").openPopup();
        map.addLayer(marker_radius)
        $('#maks_lat').val(e.latlng.lat)
        $('#maks_long').val(e.latlng.lng)
        $('#radius').val(radius)
        $('#set_data').prop('disabled', false)
    }

    $('#pilih_ulang').click(function() {
        var radius_awal = <?php echo $setting->radius; ?>;
        map.removeLayer(marker_maks).removeLayer(marker_radius)
        marker_maks = L.marker([<?php echo $setting->maks_lat; ?>, <?php echo $setting->maks_long; ?>]).addTo(map);
        marker_maks.bindPopup("<b>Maksimal Radius Absen "+radius_awal.toFixed(2)+" Meter</b>").openPopup();

        marker_radius = new L.circle([<?php echo $setting->master_lat; ?>, <?php echo $setting->master_long; ?>], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius_awal
        })
        map.addLayer(marker_radius)
        $('#maks_lat').val(<?php echo $setting->maks_lat; ?>)
        $('#maks_long').val(<?php echo $setting->maks_long; ?>)
        $('#radius').val(radius_awal)
        $('#set_data').prop('disabled', true)
        $('#kt_ecommerce_add_category_submit').prop('disabled', false)
    })

    $('#set_data').click(function() {
        $(this).prop('disabled', true)
        $('#kt_ecommerce_add_category_submit').prop('disabled', false)
    })

    function deg2rad(deg) {
        return deg * (Math.PI/180)
    }

    function distance(lat_from, long_from, lat_to, long_to) {
        var radius = 6371000;
        var dLat = deg2rad(lat_to-lat_from);
        var dLon = deg2rad(long_to-long_from); 
        var a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat_from)) * Math.cos(deg2rad(lat_to)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2)
            ; 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        var d = radius * c;
        return d
    }

</script>
@endpush --}}
