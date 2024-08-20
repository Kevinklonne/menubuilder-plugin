<?php namespace Kevinklonne\MenuBuilder\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\PageManager;
use Kevinklonne\MenuBuilder\Models\Menu;
use Kevinklonne\MenuBuilder\Models\MenuItem;
use KevinKlonne\MenuBuilder\Classes\ResolvePage;
use KevinKlonne\MenuBuilder\Classes\MakeMenuItem;
use KevinKlonne\MenuBuilder\Classes\MakeNestedMenuItem;
use Throwable;

class RenderMenu extends ComponentBase
{
    private $menuReference;
    public $menu;
    public $menuItems;

    public function componentDetails()
    {
        return [
            'name' => 'kevinklonne.menubuilder::lang.render_menu.name',
            'description' => 'kevinklonne.menubuilder::lang.render_menu.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'menuCode' => [
                'title' => 'kevinklonne.menubuilder::lang.render_menu.menu',
                'description' => 'kevinklonne.menubuilder::lang.render_menu.menucode_description',
                'type' => 'dropdown',
                'validation' => ['required' => true],
            ],
        ];
    }

    public function onRun()
    {
        try {
            $this->menuReference = $this->getMenu();
            $this->menu = $this->getMenuInfo();
            $this->menuItems = $this->getMenuItems();
        } catch (Throwable $throwable) {
            $this->page['menuCode'] = $this->property('menuCode');
        }
    }

    public function getMenu()
    {
        $menuCode = $this->property('menuCode');
        $menu = Menu::where('code', $menuCode)->firstOrFail();
        if (!$menu) {
            return false;
        }
        return $menu;
    }
    public function getMenuInfo()
    {
        $menuReference = $this->menuReference;
        $menu = [];
        $menu['name'] = $menuReference->name;
        $menu['code'] = $menuReference->code;
        $menu['description'] = $menuReference->description;
        $menu['is_active'] = $menuReference->is_active;

        return $menu;
    }

    public function getMenuItems()
    {
        $pageResolver = new ResolvePage();
        $menuItem = new MakeMenuItem();
        $nesteMenuItem = new MakeNestedMenuItem();

        if ( !$this->menuReference ) {
            return;
        }

        $menuId = $this->menuReference->id;
        $menuItems = MenuItem::where('menu_id', $menuId)->where('is_hidden', false)->get();
        $items = [];

        foreach ($menuItems->toNested() as $item) {

            if ( $item->replace_with_nested ) {
                if ( !$item->url ) {
                    continue;
                }

                $page = $pageResolver->resolve($item->url);

                if ( !$page->items ) {
                    continue;
                }

                foreach ( $page->items as $nestedItem ) {
                    $items[] = $nesteMenuItem->make($item, $nestedItem);
                }
            } else {
                $items[] = $menuItem->make($item);
            }
        }

        $menuTree = collect($items);
        return $menuTree;
    }

    public function resetMenu($code)
    {
        $this->setProperty('menuCode', $code);
        $this->menuReference = null;
        $this->menu = null;
        $this->menuItems = null;

        $this->menuReference = $this->getMenu();
        $this->menu = $this->getMenuInfo();
        $this->menuItems = $this->getMenuItems();
    }

    public function getMenuCodeOptions()
    {
        return Menu::lists('name', 'code');
    }
}
