<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index(){
        $posts=Post::where('published_at','<=',Carbon::now())
            ->orderby('published_at','desc')
            ->paginate(config('blog.posts_per_page'));
//        var_dump($posts);
        return view('blog.index',compact('posts'));
    }
    public function showPost($slug){
        $post=Post::whereSlug($slug)->firstOrFail();
        return view('blog.post')->withPost($post);
    }
}
