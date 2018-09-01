<?php

namespace App\Services;

use Michelf\MarkdownExtra;
use Michelf\SmartyPants;

class Markdowner
{

    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @param $text
     * @return mixed|string
     */
    public function toHTML($text)
    {
        $text = $this->preTransformText($text);
        $text = MarkdownExtra::defaultTransform($text);
        $text = SmartyPants::defaultTransform($text);
        $text = $this->postTransformText($text);
        return $text;
    }

    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @param $text
     * @return mixed
     */
    protected function preTransformText($text)
    {
        return $text;
    }

    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @param $text
     * @return mixed
     */
    protected function postTransformText($text)
    {
        return $text;
    }
}