<?php namespace KevinKlonne\MenuBuilder;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

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

    public function registerFormWidgets()
    {
        return [
            \KevinKlonne\MenuBuilder\FormWidgets\MenuFinder::class => 'menufinder',
        ];
    }
}
