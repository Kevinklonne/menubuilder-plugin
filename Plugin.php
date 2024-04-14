<?php namespace KevinKlonne\MenuBuilder;

use System\Classes\PluginBase;

/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    public function boot()
    {
    }

    public function registerComponents()
    {
        return [
            'KevinKlonne\MenuBuilder\Components\RenderMenu' => 'RenderMenu',
        ];
    }
    public function registerPageSnippets()
    {
        return [
            'KevinKlonne\MenuBuilder\Components\RenderMenu' => 'RenderMenu',
        ];
    }
}
