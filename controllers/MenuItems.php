<?php namespace KevinKlonne\MenuBuilder\Controllers;

use Backend;
use BackendMenu;
use Backend\Classes\Controller;

class MenuItems extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'manage_menus'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('KevinKlonne.MenuBuilder', 'menu-builder', 'menu-builder-menus');
    }

}
