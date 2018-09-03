<?php

namespace App\Services;

use App\Post;
use Carbon\Carbon;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Support\Facades\Cache;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed
{
    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @return mixed|string|Feed
     */
    public function getRSS()
    {
        //        if (Cache::has('rss-feed')) {
        //            return Cache::get('rss-feed');
        //        }
        $rss = $this->buildRssData();
        //        $rss = '123222';
        Cache::add('rss-feed', $rss, 60);
        return $rss;

    }

    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @return mixed|string|Feed
     */
    protected function buildRssData()
    {
        $now = Carbon::now();
        $feed = new Feed();
        $channel = new Channel();
        $channel->title(config('blog.title'))
            ->description(config('blog.description'))
            ->url(url())
            ->language('en')
            ->copyright('Copyright(c)' . config('blog.author'))
            ->lastBuildDate($now->timestamp)
            ->appendTo($feed);
        //        var_dump($channel);
        $posts = Post::where('published_at', '<=', $now)
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->take(config('blog.rss.size'))
            ->get();
        foreach ($posts as $post) {
            $item = new Item();
            $item->title($post->title)
                ->description($post->subtitle)
                ->url($post->url())
                ->pubDate($post->published_at)
                ->guid($post->url(), true)
                ->appendTo($channel);
        }
        $feed = json_encode($feed);
        var_dump($feed->channel());
        $feed = str_replace(
            '<rss version="2.0">',
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
            $feed
        );
        $feed = str_replace(
            '<channel>',
            '<channel>' . "\n" . '    <atom:link href="' . url('/rss') .
            '" rel="self" type="application/rss+xml" />',
            $feed
        );
        //        return 'feed';
        return $feed;
    }
}