<?php namespace Kevinklonne\MenuBuilder;

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
            'Kevinklonne\MenuBuilder\Components\RenderMenu' => 'RenderMenu',
        ];
    }
    public function registerPageSnippets()
    {
        return [
            'Kevinklonne\MenuBuilder\Components\RenderMenu' => 'RenderMenu',
        ];
    }

    /**
     * registerSettings used by the backend.
     */
    public function registerSettings()
    {
    }
}
