<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ServiceRajaOngkir;

class APIRajaOngkirController extends Controller {

    protected $service;

    public function __construct() {
        $this->service = new ServiceRajaOngkir;
    }

    public function getOngkir(Request $request) {
        $data = $this->service->getOngkir($request);
        return $data;
    }

    public function getProvince(Request $request) {
        $provinces = $this->service->getProvince();
        return $provinces;
    }

    public function getCities(Request $request) {
        $provinces = $this->service->getCityByProvince($request->province_id);
        return $provinces;
    }

    public function getKecamatan(Request $request) {
        $cities = $this->service->getKecamatan($request->city_id);
        return $cities;
    }

    public function getWaybill(Request $request) {
        return $this->service->getWaybill($request);
    }
}
