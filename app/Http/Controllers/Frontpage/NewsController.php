<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use App\Models\Post;
use DataTables;
use Image;
use File;
use DB;

class NewsController extends Controller
{
    public function index(Request $request)
    {

        // return $request;

        $query = Post::select(DB::raw('posts.*, post_categories.name as post_category_name'))
            ->leftJoin(DB::raw('post_categories'), 'post_categories.id', '=', 'posts.post_category_id');

        if ($request->has("categories")) {
            $query->whereIn("posts.post_category_id", $request->categories);
        }
        if ($request->keywords != null || $request->keywords != ''){
            $query->whereRaw("title REGEXP ".DB::connection()->getPdo()->quote($request->keywords));
        }

        $data = $query->where("posts.status", 1)->orderBy("created_at", "DESC")->paginate(6);
        $categories = PostCategory::where('status', true)->get();

        if ($request->ajax()) {
            return view('frontpage-schoko.news.news_list', compact("data", "categories"))->render();
        }

        return view("frontpage-schoko.news.news", compact("data", "categories"));
    }

    public function detail(Request $request)
    {
        $detail = Post::where('slug', $request->slug)->first();
        if (!$detail) {
            return abort(404);
        }
        $recent_news = Post::where('status', true)->orderBy('created_at', 'DESC')->take(5)->get();
        $categories = PostCategory::where('status', true)->get();
        return view('frontpage-schoko.news.news_detail', compact("detail", "recent_news", "categories"));
    }
}
