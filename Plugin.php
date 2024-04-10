<?php namespace KevinKlonne\MenuBuilder;

use System\Classes\PluginBase;

/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
    }

    /**
     * registerComponents used by the frontend.
     */
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

    /**
     * registerSettings used by the backend.
     */
    public function registerSettings()
    {
    }
}
