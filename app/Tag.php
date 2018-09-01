<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $primaryKey='id';
    protected $fillable = [
        'tag', 'title', 'subtitle', 'page_image', 'meta_description','reverse_direction',
    ];


    /**
     * Notes:
     * User:
     * Date:2018/9/1
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post', 'post_tag_pivot');
    }

    /**
     * Add any tags needed from the list
     *
     * @param array $tags List of tags to check/add
     */
    public static function addNeededTags(array $tags)
    {
        if (count($tags) === 0) {
            return;
        }

        $found = static::whereIn('tag', $tags)->pluck('tag')->all();

        foreach (array_diff($tags, $found) as $tag) {
            static::create([
                               'tag' => $tag,
                               'title' => $tag,
                               'subtitle' => 'Subtitle for '.$tag,
                               'page_image' => '',
                               'meta_description' => '',
                               'reverse_direction' => false,
                           ]);
        }
    }

    /**
     * Notes:
     * User:
     * Date:2018/9/1
     * @param $tag
     * @param string $default
     * @return string
     */
    public static function layout($tag,$default='blog.layouts.index'){
        $layout=static::whereTag($tag)->pluck('layout')->toArray();
        return $layout?$layout[0]:$default;
    }
}
