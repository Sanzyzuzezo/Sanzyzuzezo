<?php

namespace App\Http\Controllers\API;

use File;
use App\Models\City;
use App\Models\Province;
use App\Models\Customers;
use App\Models\Kecamatan;
use App\Models\Whishlist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $id = auth()->user()->id;
        // $detail = Customers::where('id', $id)->first();
        $detail = Customers::select(DB::raw('customers.*, customer_groups.name as customer_group_name'))
                            ->leftJoin(DB::raw('customer_groups'), 'customer_groups.id', '=', 'customers.customer_group_id')
                            ->where('customers.id', $id)
                            ->first();

        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => [
                'detail' => $detail,
            ],
        ], 200);
    }

    public function saveProfile(Request $request) {
        try {
            $validator = Validator::make($request->all(),[
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            if($validator->fails()){
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);
            }

            $data = $request->except(['_token', '_method']);

            $file_name = null;

            if ($request->hasFile('image')) {
                $detail = Customers::where('id', auth()->user()->id)->first();
                if (!empty($detail->image)) {
                    $image_path = "./administrator/assets/media/profiles/" . $detail->image;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
                $image = $request->file('image');
                $file_name = 'profile_' . Str::random(10) . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
                $path = upload_path('profile') . $file_name;
                Image::make($image->getRealPath())->save($path, 100);
            }

            $data['image'] = $file_name;
            $updated = Customers::where('id', auth()->user()->id)->update($data);

            if ($updated) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data successfully updated',
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data failed to update',
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => 'Error system: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function listAddress(Request $request) {

        $id = auth()->user()->id;
        $list_address = CustomerAddress::where('customer_addresses.customer_id', $id)
        ->leftjoin('provinces', 'provinces.province_id', '=', 'customer_addresses.province_id')
        ->leftjoin('cities', 'cities.city_id', '=', 'customer_addresses.city_id')
        ->leftjoin('kecamatans', 'kecamatans.subdistrict_id', '=', 'customer_addresses.subdistrict_id')
        ->get([
            'customer_addresses.*',
            'provinces.title AS province_name',
            'cities.title AS city_name',
            'cities.type AS city_type',
            'kecamatans.title AS kecamatan_name'
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $list_address,
        ], 200);
    }

    public function provinces() {
        $provinces = Province::get();
        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $provinces,
        ], 200);
    }

    public function cities(Request $request) {

        $data = City::select(DB::raw('cities.*'));

           if ($request->province_id) {
            $data->where('cities.province_id', $request->province_id);
        }

        $cities = $data->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $cities,
        ], 200);
    }

    public function districts(Request $request) {
         $data = Kecamatan::select(DB::raw('kecamatans.*'));

           if ($request->city_id) {
            $data->where('kecamatans.city_id', $request->city_id);
        }

        $districts = $data->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $districts,
        ], 200);
    }

    public function address(Request $request, $id) {
        $detail = CustomerAddress::where('id', $id)->first();
        if (!$detail) {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found',
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $detail,
        ], 200);
    }

    public function setAddressDefault(Request $request) {
        if (!$request->address_id) {
            return response()->json([
                'status' => 400,
                'message' => 'Address id is required',
            ], 400);
        }

        $address = CustomerAddress::where('customer_id', auth()->user()->id)
                                ->where('id', $request->address_id)
                                ->first();

        if (!$address) {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found',
            ], 404);
        }

        $data = Customers::where('id', auth()->user()->id)->first();
        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not found',
            ], 404);
        }

        $data->update([
            'default_address_id' => $address->id
        ]);


        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $address,
        ], 200);
    }

    public function saveAddress(Request $request) {
        try {
            DB::beginTransaction();

            $data = [
                'active' => $request->active ? $request->active : 1,
                'customer_id' => auth()->user()->id,
                'received_name' => $request->received_name,
                'received_phone' => $request->received_phone,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'subdistrict_id' => $request->subdistrict_id,
                'detail_address' => $request->detail_address,
            ];

            if (isset($request->address_id)) {
                $update = CustomerAddress::where('id', $request->address_id)->update($data);
            } else {
                $create_update = CustomerAddress::create($data);
            }

            if (isset($update) && $update) {
                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data successfully updated.',
                ], 200);
            } elseif (isset($create_update) && $create_update) {
                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data successfully created.',
                ], 200);
            } else {
                DB::rollback();

                return response()->json([
                    'status' => 400,
                    'message' => 'Data failed to update or create.',
                ], 400);
            }
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json([
                'status' => 400,
                'message' => 'Error system: ' . $th->getMessage(),
            ], 400);
        }
    }

    public function deleteAddress(Request $request, $id) {
        try {
            $address = CustomerAddress::where('id', $id)->first();

            if (!$address) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Address not found',
                ], 404);
            }

            $address->update(['deleted_by' => auth()->user()->id]);
            $address->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully deleted',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => 'Data failed: ' . $th->getMessage(),
            ], 400);
        }
    }


    public function wishlist(Request $request){
        $validator = Validator::make($request->all(),[
            'limit' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);
        }

        $query = DB::table('whishlists')
            ->select(
                DB::raw('whishlists.*,
                    products.name AS nama_produk,
                    products.id AS id_produk,
                    categories.name as category_name,
                    brands.name as brand_name,
                    MAX(product_variants.id) as variant_id,
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
            ->groupBy('whishlists.id', 'products.name', 'products.id', 'categories.name', 'brands.name');

        $wishlist = $query->paginate($request->limit);

        $wishlist->map(function($pr){
            $pr->data_file = $pr->data_file != null ? '/administrator/assets/media/products/' . $pr->data_file : img_src('default.jpg', '');
        });

        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $wishlist,
        ], 200);
    }

    public function countWishlist() {
        $Whishlist = Whishlist::where('customer_id', auth()->user()->id)->count();
        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $Whishlist,
        ], 200);
    }

    public function deleteWishList($id) {

        $model = Whishlist::find($id);
        $model->delete();
        $wishlist_count = Whishlist::where('customer_id', auth()->user()->id)->count();
        $response = [ 'status' => true, 'data' => $model, 'deleted' => true, 'count' => $wishlist_count ];
        return response()->json($response, 200);

    }
}
