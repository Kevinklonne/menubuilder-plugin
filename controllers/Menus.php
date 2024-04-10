<?php namespace KevinKlonne\MenuBuilder\Controllers;

use Backend;
use BackendMenu;
use Backend\Classes\Controller;
use October\Rain\Support\Facades\Str;
use Flash;

class Menus extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'manage_menus' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('KevinKlonne.MenuBuilder', 'menu-builder', 'menu-builder-menus');
    }

    public function onDuplicate()
    {
        $menu = $this->formFindModelObject(post('id'));
        $clone = $menu->replicateWithRelations();
        $clone->code = $menu->code . '-' . Str::random(5);
        $clone->name = $menu->name . ' (' . trans('kevinklonne.menubuilder::lang.menu.copy_noun') . ')';
        $clone->save();

        Flash::success(e(trans('kevinklonne.menubuilder::lang.menu.duplicate_success')));

        return $this->listRefresh();
    }

}
