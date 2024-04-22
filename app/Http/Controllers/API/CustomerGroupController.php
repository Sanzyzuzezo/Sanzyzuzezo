<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\CustomerGroup;
use App\Http\Controllers\Controller;
use Validator;

class CustomerGroupController extends Controller
{
    public function customer_group(Request $request){
        $validator = Validator::make($request->all(),[
            'limit' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);       
        }

        $query = CustomerGroup::select('customer_groups.id','customer_groups.name');
        $customer_group = $query->paginate($request->limit);

        return response()->json([
            'status' => 200, 
            'message' => 'Data successfully',
            'data' => $customer_group,
        ], 200);
    }
}
