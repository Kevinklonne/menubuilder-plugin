<?php namespace KevinKlonne\MenuBuilder\Classes;

use Cms\Classes\PageManager;

class ResolvePage
{
    public function resolve($url)
    {
        $page = PageManager::resolve($url, ['nesting' => true]);
        return $page;
    }
}
