<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Customers;
use App\Models\Province;
use App\Models\CustomerAddress;
use App\Models\Whishlist;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        $id = auth()->user()->id;
        // $detail = Customers::where('id', $id)->first();
        $detail = Customers::select(DB::raw('customers.*, customer_groups.name as customer_group_name'))
                            ->leftJoin(DB::raw('customer_groups'), 'customer_groups.id', '=', 'customers.customer_group_id')
                            ->where('customers.id', $id)
                            ->first();
        $provinces = Province::get();
        return view('frontpage-schoko.customers.profile', compact('detail', 'provinces'));

    }

    public function saveProfile(Request $request) {

        try {
            $data = $request->except(['_token', '_method']);

            $file_name = null;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = $file->store('profile', 'public');
            }

            $data['image'] = $file_name;
            $updated = Customers::where('id', auth()->user()->id)->update($data);

            if ($updated) {
                Alert::toast('Profil berhasil disimpan', 'success');
                return redirect()->back();
            }

        } catch (\Throwable $th) {
            Alert::toast('Profil gagal disimpan', 'error');
            return redirect()->back();
        }
    }

    public function address(Request $request) {

        $id = auth()->user()->id;
        $list_address = CustomerAddress::where('customer_addresses.customer_id', $id)
        ->join('provinces', 'provinces.province_id', '=', 'customer_addresses.province_id')
        ->join('cities', 'cities.city_id', '=', 'customer_addresses.city_id')
        ->join('kecamatans', 'kecamatans.subdistrict_id', '=', 'customer_addresses.subdistrict_id')
        ->get([
            'customer_addresses.*',
            'provinces.title AS province_name',
            'cities.title AS city_name',
            'cities.type AS city_type',
            'kecamatans.title AS kecamatan_name'
        ]);

        if($request->ajax())
            return response()->json($list_address, 200);;

        return view('frontpage-schoko.customers.address-list', compact('list_address'));
    }

    public function createAddress() {

        $provinces = Province::get();
        return view('frontpage-schoko.customers.address-create', compact('provinces'));
    }

    public function editAddress(Request $request) {

        if(!$request->isMethod('post')){
            return redirect()->route('address');
        }

        $provinces = Province::get();
        $detail = CustomerAddress::where('id', $request->address_id)->first();
        return view('frontpage-schoko.customers.address-create', compact('provinces', 'detail'));
    }

    public function saveAddress(Request $request) {

        try {
            $data = $request->except(['_token', '_method', 'address_id']);
            $data['customer_id'] = auth()->user()->id;

            if (isset($request->active)) {
                $data['active'] = 1;
                CustomerAddress::where('customer_id', auth()->user()->id)->update(['active' => 0]);
            }
            if (isset($request->address_id)) {
                $create_update = CustomerAddress::where('id', $request->address_id)->update($data);
            } else {
                $create_update = CustomerAddress::create($data);
            }
            if ($create_update) {

                if($request->ajax()){
                    $list_address = $this->address($request);
                    return $list_address;
                }

                Alert::toast('Alamat berhasil disimpan', 'success');
                return redirect()->route('address');
            } else {
                Alert::toast('Alamat gagal disimpan', 'error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::toast('Alamat gagal disimpan', 'error');
            return redirect()->back();
        }
    }

    public function deleteAddress(Request $request) {

        try {
            $address = CustomerAddress::find($request->address_id);
            $address->delete();
            Alert::toast('Alamat berhasil dihapus', 'success');
            return redirect()->route('address');
        } catch (\Throwable $th) {
            Alert::toast('Alamat gagal dihapus', 'error');
            return redirect()->back();
        }
    }

    public function wishList() {

        $wishlists = DB::table('whishlists')
                ->select(
                    DB::raw('whishlists.*,
                        products.name AS nama_produk,
                        products.id AS id_produk,
                        categories.name as category_name,
                        brands.name as brand_name,
                        MAX(product_variants.id) as variant_id,
                        SUM(product_variants.stock) as total_stock,
                        MIN(product_variants.price) as min_price,
                        MAX(product_variants.price) as max_price,
                        MAX(product_medias.data_file) as data_file,
                        COUNT(product_variants.id) as total_variant')
                )
                ->where('whishlists.customer_id', auth()->user()->id)
                ->join('products', 'whishlists.product_id', '=', 'products.id')
                ->leftjoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftjoin('brands', 'products.brand_id', '=', 'brands.id')
                ->leftjoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->leftjoin('product_medias', 'products.id', '=', 'product_medias.product_id')
                ->groupBy('whishlists.id', 'products.name', 'products.id', 'categories.name', 'brands.name')
            ->get();

        // return $wishlists;

        return view('frontpage-schoko.customers.wishlist', compact('wishlists'));
    }

    public function countWishlist() {
        $Whishlist = Whishlist::where('customer_id', auth()->user()->id)->count();
        return $Whishlist;
    }

    public function deleteWishList($id) {

        $model = Whishlist::find($id);
        $model->delete();
        $wishlist_count = Whishlist::where('customer_id', auth()->user()->id)->count();
        $response = [ 'status' => true, 'data' => $model, 'deleted' => true, 'count' => $wishlist_count ];
        return response()->json($response, 200);

    }

}
