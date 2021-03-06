<?php

namespace App\Http\Controllers;

use App\Jobs\BlogIndexData;
use App\Post;
use App\Services\RssFeed;
use App\Services\SiteMap;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BlogController extends Controller
{
    //
//    /**
//     *
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    public function index()
//    {
//        $posts = Post::where('published_at', '<=', Carbon::now())
//            ->orderby('published_at', 'desc')
//            ->paginate(config('blog.posts_per_page'));
//        //        var_dump($posts);
//        return view('blog.index', compact('posts'));
//    }

    /**
     * Notes:
     * User:
     * Date:2018/9/1
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $data = $this->dispatchNow(new BlogIndexData($tag));
        //        $data=$this->dispatch(new BlogIndexData($tag));
        $layout=$tag?Tag::layout($tag):'blog.layouts.index';
//        var_dump($data);
//        var_dump($layout);
        return view($layout,$data);
    }

    //    /**
    //     * @param $slug
    //     * @return mixed
    //     */
//    public function showPost($slug)
//    {
//        $post = Post::whereSlug($slug)->firstOrFail();
//        return view('blog.post')->withPost($post);
//    }

    /**
     * Notes:
     * User:
     * Date:2018/9/1
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPost($slug, Request $request)
    {

        $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
        $tag=$request->get('tag');
        if ($tag){
            $tag=Tag::whereTag($tag)->firstOrFail();
        }

//        echo '<hr/>';
//        var_dump($post);
        return view($post->layout,compact('post','tag'));
    }

    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @param SiteMap $siteMap
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function siteMap(SiteMap $siteMap)
    {
        $map = $siteMap->getSiteMap();
        return response($map)
            ->header('Content-type', 'text/xml');
    }

    public function rss(RssFeed $feed)
    {
        $rss = $feed->getRSS();
        return response($rss)->header('Content-type', 'application/rss+xml');
    }
}
