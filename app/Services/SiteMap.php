<?php

namespace App\Services;

use App\Post;
use Carbon\Carbon;
use DemeterChain\C;
use Illuminate\Support\Facades\Cache;

class SiteMap
{
    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @return mixed|string
     */
    public function getSiteMap()
    {
        if (Cache::has('site-map')) {
            return Cache::get('site-map');
        }
        $siteMap = $this->buildSiteMap();
        Cache::add('site-map', $siteMap, 120);
        return $siteMap;
    }

    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @return string
     */
    protected function buildSiteMap()
    {
        $postsInfo = $this->getPostInfo();
        $dates = array_values($postsInfo);
        sort($dates);
        $lastmod = last($dates);
        $url = $_SERVER['SERVER_NAME'] . '/';
        //        $url=trim(url(),'/').'/';
        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?' . '>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml[] = '  <url>';
        $xml[] = "    <loc>$url</loc>";
        $xml[] = "    <lastmod>$lastmod</lastmod>";
        $xml[] = '    <changefreq>daily</changefreq>';
        $xml[] = '    <priority>0.8</priority>';
        $xml[] = '  </url>';
        foreach ($postsInfo as $slug => $lastmod) {
            $xml[] = '  <url>';
            $xml[] = "    <loc>{$url}blog/$slug</loc>";
            $xml[] = "    <lastmod>$lastmod</lastmod>";
            $xml[] = "  </url>";
        }
        $xml[] = '</urlset>';
        return join("\n", $xml);
    }

    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @return mixed
     */
    protected function getPostInfo()
    {
        return Post::where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->pluck('updated_at', 'slug')
            ->all();
    }
}