<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Ingredients;
use App\Models\IngredientDetail;
use App\Models\Supplier;
use App\Models\UnitConversion;
use DataTables;
use Image;
use File;
use DB;
use Redirect;

class IngredientsController extends Controller
{
    private static $module = "ingredients";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view("administrator.ingredients.index");
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();
        
        $query = Ingredients::select(DB::raw('products.name as item_name, product_variants.name as item_variant_name, ingredients.id, ingredients.status, ingredients.information'))
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'ingredients.item_variant_id')
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->orderBy('ingredients.created_at', 'DESC');

        if ($company_id != 0) {
            $query->where('ingredients.company_id', $company_id);
        }
    
        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("ingredients.status", $status);
        }
    
        $data = $query->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataItem(Request $request){
        $company_id = getCompanyId();
        $que = Product::select(DB::raw('products.name, products.id'))
        ->leftJoin('product_variants', 'product_variants.product_id' , '=', 'products.id' )->where('products.status', 1)->where('product_variants.production', 1);

        if ($company_id != 0) {
            $que->where('products.company_id', $company_id);
        }
        $data = $que->get();
        
        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return $data;
    }

    public function getDataItemVariant(Request $request){
        $que = ProductVariant::where('product_id', $request->product_id)
                        ->where('status', 1)->where('production', 1);

        $data = $que->get();
        
        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return $data;
    }

    public function getDataItemVariantIngredient(Request $request){
        $company_id = getCompanyId();

        // $que = ProductVariant::where('status', 1)
        //     ->where('ingredient', 1)
        //     ->with([
        //         'products' => function ($query) use ($company_id) {
        //             if ($company_id != 0) {
        //                 $query->where('company_id', $company_id);
        //             }
        //         }
        //     ]);
        $que = ProductVariant::select(DB::raw('product_variants.*, products.name as products_name'))
            ->where('product_variants.status', 1)
            ->where('product_variants.ingredient', 1)
            ->leftJoin('products', 'products.id', '=', 'product_variants.product_id');

            if ($company_id != 0) {
                $que->where('products.company_id', $company_id);
            }

        $data = $que->get();
        
        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return $data;
    }

    public function getDataIngredient(Request $request)
    {
        $query = Ingredients::select(DB::raw('ingredients.id as ingredient_id, ingredients.information, products.name as item_name, product_variants.name as item_variant_name, product_variants.id, products.id as item_id'))
                            ->leftJoin('ingredient_details', 'ingredient_details.ingredient_id', '=', 'ingredients.id')
                            ->leftJoin('product_variants', 'product_variants.id', '=', 'ingredient_details.item_variant_id')
                            ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
                            ->leftJoin('units', 'units.id', '=', 'product_variants.unit_id')
                            ->where("ingredients.status", 1)
                            ->groupBy(
                                'products.name',
                                'ingredients.id',
                                'ingredients.information',
                                'product_variants.name',
                                'product_variants.id',
                                'products.id',
                            );

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('ingredients.company_id', $company_id);
        }
        $data = $query->get();


        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }
            

        return $data;
    }

    public function getVariantData(Request $request)
    {
        $data = ProductVariant::select(DB::raw('product_variants.name, product_variants.id'))
            ->where("product_variants.product_id", $request->id)
            ->get();

        return $data;
    }

    public function getItemData(Request $request)
    {
        $data = ProductVariant::select(DB::raw('products.name as item_name, product_variants.name as item_variant_name, product_variants.id, products.id as item_id'))
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->where("product_variants.id", $request->variant_id)
            ->first();

        return $data;
    }

    public function getItemDataSelect(Request $request)
    {
        $data = Product::select(DB::raw('products.name as item_name, products.id as item_id'))
            ->where("products.id", $request->id)
            ->first();

        return $data;
    }

    public function getUnitMainData(Request $request)
    {
        $data = ProductVariant::select(DB::raw('units.name'))
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
            ->where("product_variants.id", $request->id)
            ->first();

        return $data;
    }


    public function getUnitsData(Request $request)
    {
        $variant = ProductVariant::select(DB::raw('units.name, 0 as id'))
            ->where('product_variants.id', $request->id)
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id');

        $data = UnitConversion::select(DB::raw('unit_conversions.new_unit as name, unit_conversions.id'))
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'unit_conversions.unit_id')
            ->where("unit_conversions.item_variant_id", $request->id);

        $result = $variant->union($data)->get();

        return $result;
    }


    public function getItemIngredient(Request $request)
    {
        $product = ProductVariant::select(DB::raw('product_variants.id'))
            ->where("product_variants.product_id", $request->id)
            ->first();

        $data = ProductVariant::select(DB::raw('products.name as item_name, product_variants.name as item_variant_name, product_variants.id'))
            ->leftJoin(DB::raw('products'), 'product_variants.product_id', '=', 'products.id')
            ->where("product_variants.id", "!=", $product->id)
            ->where("product_variants.status", 1)
            ->where("products.status", 1)
            ->get();

        return $data;
    }

    public function getItemIngredients(Request $request)
    {
        $product_id = $request->product_id;
        $data = ProductVariant::with([
            'products' => function ($query) use ($company_id) {
                $query->where('status', 1);
                if ($company_id != 0) {
                    $query->where('products.company_id', $company_id);
                }
            }
        ])->where('ingredient', 1)
            ->where('status', 1)
            ->where('product_id', '!=', $product_id)
            ->get();

        return $data;
    }

    public function getSupplierDataSelect(Request $request)
    {
        $data = Supplier::where('id', $request->id)->first();

        return $data;
    }

    public function add(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        if ($request->information) {
            $data['ingredient'] = Ingredients::select(DB::raw('ingredients.id, ingredients.item_variant_id, product_variants.name as item_variant_name, products.id as item_id, products.name as item_name, ingredients.status, ingredients.information'))
                ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'ingredients.item_variant_id')
                ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                ->where('ingredients.information',$request->information)->first();

            if (!$data['ingredient']) {
                return redirect(route('admin.ingredients.add'));
            }
    
            $data['ingredient_detail'] = IngredientDetail::select(DB::raw('ingredient_details.id, products.name as item_name, product_variants.name as item_variant_name, ingredient_details.quantity, ingredient_details.unit_id, units.name as unit_name, ingredient_details.item_variant_id'))
                ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'ingredient_details.item_variant_id')
                ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                ->where("ingredient_details.ingredient_id", $data['ingredient']->id)
                ->get();
        }else{
            $data['ingredient'] = '';
            $data['ingredient_detail'] = '';
        }
        

        return view("administrator.ingredients.add", $data);
    }

    public function save(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $company_id = getCompanyId();
        // dd($request);

        $this->validate($request, [
            'item_id' => 'required',
            'item_variant_id' => 'required'
        ]);

        $data = [
            'item_id' => $request->item_id,
            'item_variant_id'       => $request->item_variant_id,
            'information'           => $request->information,
            'status'                => $request->has('status') ? 1 : 0,
            'company_id'            => $company_id,
        ];
        $ingredients = Ingredients::create($data);

        if ($request->has('ingredients')) {
            $ingredients_data = $request->ingredients;
            foreach ($ingredients_data as $ingredient) {
                if ($ingredient['unit_id'] !== 0) {
                    $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($ingredient['unit_id']);
                    $after = (str_replace(',', '', $ingredient['quantity'])) * (!empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1);
                }else{
                    $after = str_replace(',', '', $ingredient['quantity']);
                }

                $ingredients->ingredient_details()->create([
                    'ingredient_id'                 => $ingredients->id,
                    'item_variant_id'               => $ingredient['item_variant_id'],
                    'quantity'                      => str_replace(',', '', $ingredient['quantity']),
                    // 'quantity_after_conversion'     => (str_replace(',', '', $ingredient['quantity']))*(str_replace(',', '', $unit_conversion['quantity']) != null ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                    'quantity_after_conversion'     => $after,
                    'unit_id'                       => $ingredient['unit_id'],
                ]);
            }
        }
        //Write log
        createLog(static::$module, __FUNCTION__, $ingredients->id);
        return redirect(route('admin.ingredients'));
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $edit = Ingredients::select(DB::raw('ingredients.id, ingredients.item_variant_id, product_variants.name as item_variant_name, products.id as item_id, products.name as item_name, ingredients.status, ingredients.information'))
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'ingredients.item_variant_id')
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->find($id);

        $ingredient_details = IngredientDetail::select(DB::raw('ingredient_details.id, products.name as item_name, product_variants.name as item_variant_name, ingredient_details.quantity, ingredient_details.unit_id, units.name as unit_name, ingredient_details.item_variant_id'))
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'ingredient_details.item_variant_id')
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->Join(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
            ->where("ingredient_details.ingredient_id", $id)
            ->get();

        if (!$edit) {
            return abort(404);
        }

        $items = Product::with([
            'variants' => function ($query) {
                $query->where('ingredient', 1);
            }
        ])->where('status', 1)->get();

        $item_variants = ProductVariant::select(DB::raw('product_variants.name, product_variants.id'))
            ->where("product_variants.product_id", $edit->item_id)
            ->where("product_variants.ingredient", 1)
            ->get();

        $item_ingredients = ProductVariant::select(DB::raw('products.name as item_name, product_variants.name as item_variant_name, product_variants.id'))
            ->leftJoin(DB::raw('products'), 'product_variants.product_id', '=', 'products.id')
            ->where("product_variants.ingredient", 1)
            ->where("product_variants.id", "!=", $edit->item_variant_id)
            ->where("products.status", 1)
            ->where("product_variants.status", 1)
            ->get();
        // dd($item_ingredients);

        return view("administrator.ingredients.edit", compact("edit", "ingredient_details", "items", "item_variants", "item_ingredients"));
    }

    public function update(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $this->validate($request, [
            'item_id' => 'required',
            'item_variant_id' => 'required'
        ]);

        $data = [
            'item_id' => $request->item_id,
            'item_variant_id'    => $request->item_variant_id,
            'status'             => $request->has('status') ? 1 : 0,
            'information'           => $request->information,
        ];
        $id = $request->id;
        $ingredients = Ingredients::where('id', $id)->update($data);

        if ($request->has('ingredients')) {
            $ingredients_req = $request->ingredients;
            $ingredients_id = collect($request->ingredients)->pluck('id');
            foreach ($ingredients_req as $ingredient) {
                if ($ingredient['quantity'] == null) {
                    return Redirect::back();
                } else {
                    $ingredient_id = $ingredient['id'];
                    if ($ingredient['unit_id'] !== 0) {
                        $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($ingredient['unit_id']);
                        $after = (str_replace(',', '', $ingredient['quantity'])) * (!empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1);
                    }else{
                        $after = str_replace(',', '', $ingredient['quantity']);
                    }
                    $data_update = [
                        'ingredient_id'             => $id,
                        'item_variant_id'           => $ingredient['item_variant_id'],
                        'quantity'                      => str_replace(',', '', $ingredient['quantity']),
                        // 'quantity_after_conversion'     => (str_replace(',', '', $ingredient['quantity']))*(str_replace(',', '', $unit_conversion['quantity']) != null ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        'quantity_after_conversion'     => $after,
                        'unit_id'                   => $ingredient['unit_id'],
                    ];

                    if ($ingredient_id == null) {
                        IngredientDetail::create($data_update);
                    } else {
                        IngredientDetail::where(["id" => $ingredient_id])->update($data_update);
                    }
                }
            }
            IngredientDetail::whereNotIn('id', $ingredients_id)->where('ingredient_id', $id)->delete();
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.ingredients'));
    }

    public function detail($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $detail = Ingredients::select(DB::raw('ingredients.id, ingredients.item_variant_id, product_variants.name as item_variant_name, products.id as item_id, products.name as item_name, ingredients.status, ingredients.information'))
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'ingredients.item_variant_id')
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->find($id);

        $ingredient_details = IngredientDetail::select(DB::raw('ingredient_details.id, products.name as item_name, product_variants.name as item_variant_name, ingredient_details.quantity, ingredient_details.unit_id, units.name as unit_name, ingredient_details.item_variant_id'))
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'ingredient_details.item_variant_id')
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
            ->where("ingredient_details.ingredient_id", $id)
            ->get();

        if (!$detail) {
            return abort(404);
        }

        $items = Product::select(DB::raw('products.name, products.id'))
                        ->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
                        ->where("product_variants.ingredient", 1)
                        ->where("products.status", 1)
                        ->groupBy("products.name", "products.id")
                        ->get();


        $item_variants = ProductVariant::select(DB::raw('product_variants.name, product_variants.id'))
            ->where("product_variants.product_id", $detail->item_id)
            ->where("product_variants.ingredient", 1)
            ->get();

        $item_ingredients = ProductVariant::select(DB::raw('products.name as item_name, product_variants.name as item_variant_name, product_variants.id'))
            ->leftJoin(DB::raw('products'), 'product_variants.product_id', '=', 'products.id')
            ->where("product_variants.id", "!=", $detail->item_variant_id)
            ->where("products.status", 1)
            ->where("product_variants.status", 1)
            ->get();

        return view("administrator.ingredients.detail", compact("detail", "ingredient_details", "items", "item_variants", "item_ingredients"));
    }

    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $data = Ingredients::find($request->ix);
        $data->deleted_by = $deletedBy;
        $data->update();
        $data->delete();

        $data_details = IngredientDetail::where('ingredient_id', $request->ix)->get();
        foreach($data_details as $data_detail){
            $data_detail->deleted_by = $deletedBy;
            $data_detail->update();
            $data_detail->delete();
        }
        //Write log
        createLog(static::$module, __FUNCTION__, $request->ix);
        return response()->json([
            'success' => true
        ]);
    }
    
    public function deleteDetail(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data_detail = IngredientDetail::find($request->ix);

        if ($data_detail) {
            // Simpan ID pengguna yang menghapus sebelum menghapus
            $deletedBy = auth()->user() ? auth()->user()->id : '';
            $data_detail->deleted_by = $deletedBy;
            $data_detail->update();

            // Hapus detail setelah update
            $data_detail->delete();

            // Write log
            createLog(static::$module, __FUNCTION__, $request->ix);

            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }
    }


    public function isExistInformation(Request $request){
        if($request->ajax()){
            $ingredient = Ingredients::select('*');
            if(isset($request->information)){
                $ingredient->where('information', $request->information);
            }
            if(isset($request->id)){
                $ingredient->where('id', '<>', $request->id);
            }
            $data = [ 'valid' => ( $ingredient->count() == 0)  ];
            if(!empty($ingredient)){
                return $data;
            }else{
                return $data;
            }
        }
    }
}
