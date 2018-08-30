<?php

namespace App\Http\Controllers;

use App\Jobs\BlogIndexData;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
//    public function index()
//    {
//        $posts = Post::where('published_at', '<=', Carbon::now())
//            ->orderby('published_at', 'desc')
//            ->paginate(config('blog.posts_per_page'));
//        //        var_dump($posts);
//        return view('blog.index', compact('posts'));
//    }

    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $data = $this->dispatchNow(new BlogIndexData($tag));
        $layout=$tag?Tag::layout($tag):'blog.layouts.index';
        var_dump($data);
//        return view($layout,$data);
    }

    /**
     * @param $slug
     * @return mixed
     */
//    public function showPost($slug)
//    {
//        $post = Post::whereSlug($slug)->firstOrFail();
//        return view('blog.post')->withPost($post);
//    }
    public function showPost($slug,Request $request)
    {
        $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
        $tag=$request->get('tag');
        if ($tag){
            $tag=Tag::whereTag($tag)->firstOrFail();
        }
        return view($post->layout,compact('post','tag'));
    }
}
