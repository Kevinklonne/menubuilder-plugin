<?php namespace Kevinklonne\MenuBuilder;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

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

    public function registerFormWidgets()
    {
        return [
            \Kevinklonne\MenuBuilder\FormWidgets\MenuFinder::class => 'menufinder',
        ];
    }
}
