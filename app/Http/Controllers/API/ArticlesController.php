<?php

namespace App\Http\Controllers\API;

use File;
use DB;
use App\Models\PostCategory;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    public function articleCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // $article_category = PostCategory::paginate($request->limit);
        $article_category = PostCategory::where('company_id', $request->company_id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat.',
            'data' => $article_category,
        ]);
    }

    public function articles(Request $request){
    $validator = Validator::make($request->all(), [
        'company_id' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    $query = Post::select('*')->with('category');

    if (!empty($request->post_category_id)) {
        $category = PostCategory::find($request->post_category_id);
    
        if ($category) {
            $query->where('post_category_id', $category->id);
        } else {
            return response()->json(['status'=> 406, 'message' => 'Not Acceptable'], 406); 
        }
    }
    if (!empty($request->search)) {
        $query->where('posts.title', 'LIKE', '%'.$request->search.'%');
    }

    $article_total = $query->count();
    $articles = $query->where('company_id', $request->company_id)->get();
    // $articles = $query->paginate($request->limit);

    $articles->map(function($pr){
        $pr->data_file = $pr->data_file != null ? img_src($pr->data_file, 'news') : img_src('default.jpg', '');
    });

    if($request->post_category_id == 'undefined'){
        return response()->json(['status'=> 406, 'message' => 'Not Acceptable'], 406); 
    }

    return response()->json([
        'status'=> 200,
        'message' => 'You successfully completed loaded.',
        'data' => $articles,
    ]);
}
}