<?php

namespace App\Jobs;

use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BlogIndexData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $tag;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tag)
    {
        //
        $this->tag = $tag;
    }

    /**
     * Execute the job.
     *
     * @return
     */
    public function handle()
    {
        //
        if ($this->tag) {
            return $this->tagIndexData($this->tag);
        }
        return $this->normalIndexData();
    }

    /**
     * @return array
     */
    protected function normalIndexData()
    {
        $posts = Post::with('tags')
            ->where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->simplePaginate(config('blog.post_per_page'));
        return [
            'title'             => config('blog.title'),
            'subtitle'          => config('blog.subtitle'),
            'posts'              => $posts,
            'page_image'        => config('blog.page_image'),
            'meta_description'  => config('blog.description'),
            'reverse_direction' => false,
            'tag'               => null
        ];
    }

    protected function tagIndexData($tag)
    {
        $tag = Tag::where('tag', $tag)->firstOrFail();
        $reverse_direction = (bool)$tag->reversee_direction;
        $posts = Post::where('publish_at', '<=', Carbon::now())
            ->whereHas('tag', function ($q) use ($tag)
            {
                $q->where('tag', '=', $tag->tag);
            }
            )
            ->where('id_draft', 0)
            ->orderBy('published_at', $reverse_direction ? 'asc' : 'desc')
            ->simplePaginate(config('blog.post_per_page'));
        $posts->addQuery('tag', $tag->tag);
        $page_image = $tag->page_image ?: config('blog.page_image');
        return [
            'title'             => $tag->title,
            'subtitle'          => $tag->subtitle,
            'posts'              => $posts,
            'page_image'        => $page_image,
            'meta_description'  => $tag->meta_descriptin ?: config('blog.description'),
            'reverse_direction' => $reverse_direction,
            'tag'               => $tag
        ];
    }
}
