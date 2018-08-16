<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/16
 * Time: 11:18
 */

namespace App\utils;

use Parsedown;

class MarkDown
{
    protected $markdownConverter;

    /**
     * MarkDown constructor.
     * @param Parsedown $parsedown
     */
    public function __construct(Parsedown $parsedown)
    {
        $this->markdownConverter = $parsedown;
    }

    /**
     * @Describe: Convert Markdown To Html.
     * @Author: chinwe.jing
     * @Data: 2018/8/16 11:22
     * @param $markdown
     * @return string
     */
    public function convertMarkdownToHtml($markdown) :string
    {
        return $this->markdownConverter
            ->setBreaksEnabled(true)
            ->text($markdown);
    }
}