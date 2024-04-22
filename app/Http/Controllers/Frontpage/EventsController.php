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

class EventsController extends Controller
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

        $data = $query->where('post_categories.name', 'like', '%event%')->where("posts.status", 1)->orderBy("created_at", "DESC")->paginate(6);

        if ($request->ajax()) {
            return view('frontpage-schoko.event.event_list', compact("data"))->render();
        }

        return view("frontpage-schoko.event.event", compact("data"));
    }

    public function detail(Request $request)
    {
        $detail = Post::where('slug', $request->slug)->first();
        if (!$detail) {
            return abort(404);
        }
        $recent_event = Post::select(DB::raw('posts.*, post_categories.name as post_category_name'))
                            ->leftJoin(DB::raw('post_categories'), 'post_categories.id', '=', 'posts.post_category_id')
                            ->where('post_categories.name', 'like', '%event%')
                            ->where('posts.status', 1)
                            ->orderBy('created_at', 'DESC')
                            ->take(5)
                            ->get();
        $categories = PostCategory::where('name', 'like', '%event%')->where('status', true)->get();
        return view('frontpage-schoko.event.event_detail', compact("detail", "recent_event", "categories"));
    }
}
