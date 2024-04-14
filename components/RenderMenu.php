<?php namespace KevinKlonne\MenuBuilder\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\PageManager;
use KevinKlonne\MenuBuilder\Models\Menu;
use KevinKlonne\MenuBuilder\Models\MenuItem;
use Log;
use Throwable;

/**
 * RenderMenu Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class RenderMenu extends ComponentBase
{
    public $menu;
    public $menuItems;

    public function componentDetails()
    {
        return [
            'name' => 'kevinklonne.menubuilder::lang.render_menu.name',
            'description' => 'kevinklonne.menubuilder::lang.render_menu.description'
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
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

    public function onRender()
    {
        try {
            $this->menu = $this->getMenu();
            $this->menuItems = $this->getMenuItems();
        } catch (Throwable $throwable) {
            $this->page['menuCode'] = $this->property('menuCode');
        }
    }

    public function getMenu()
    {
        $menuCode = $this->property('menuCode');
        $menu = new Menu;
        $query = $menu->query();
        $query->where('code', $menuCode);
        $menu = $query->firstOrFail();
        if (!$menu) {
            return false;
        }
        return $menu;
    }

    public function getMenuItems()
    {        
        if ( !$this->menu ) {
            return;
        }

        $menu_id = $this->menu->id;
        $menuItems = MenuItem::where('menu_id', $menu_id)->where('is_hidden', false)->get();
        $items = [];

        foreach ($menuItems->toNested() as $item) {
            if ( $item->url ) {
                $page = $this->resolvePage($item->url);
            }
            
            if ( $item->replace_with_nested ) {
                if ( !$page->items ) {
                    continue;
                }

                foreach ( $page->items as $nestedItem ) {
                    $items[] = $this->makeNestedMenuItem($item, $nestedItem);
                }
            } else {
                $items[] = $this->makeMenuItem($item);
            }
        }

        $menutree = collect($items);
        return $menutree;
    }
    
    private function makeMenuItem($item)
    {
        $page = $item->url ? $this->resolvePage($item->url) : '';
        $menuitem = [];

        $menuitem['label'] = $item->label;
        $menuitem['url'] = $page->url ?: '';
        $menuitem['is_external'] = $item->is_external;
        $menuitem['css_class'] = $item->css_class;
        $menuitem['code'] = $item->code;
        $menuitem['custom_attributes'] = $item->custom_attributes;
        $menuitem['isActive'] = $page->isActive ?: false;
        $menuitem['items'] = [];

        if ( $item->include_nested ) {
            if ( $page->items ) {
                foreach ( $page->items as $nested ) {
                    $menuitem['items'][] = $this->makeNestedMenuItem($item, $nested);
                }
            }
        }

        if ( !$item->children ) {
            return $menuitem;
        }

        foreach ( $item->children as $child ) {
            if ( $child->replace_with_nested ) {
                $resolveChild = $this->resolvePage($child->url);
                foreach ( $resolveChild->items as $nested ){
                    $menuitem['items'][] = $this->makeNestedMenuItem($item, $nested);
                }
            } else {
                $menuitem['items'][] = $this->makeMenuItem($child, $item);
            }
        }

        return $menuitem;

    }

    private function makeNestedMenuItem($item, $nestedItem)
    {
        $menuitem = [];
        $menuitem['label'] = $nestedItem->title;
        $menuitem['url'] = $nestedItem->url;
        $menuitem['isActive'] = $nestedItem->isActive;

        if ( !$item->include_nested ) {
            return $menuitem;
        }
        
        $menuitem['items'] = [];

        if ( $nestedItem->items ) {
            foreach ( $nestedItem->items as $subitem ) {
                $menuitem['items'][] = $this->makeNestedMenuItem($item, $subitem);
            }
        }

        return $menuitem;
    }

    public function getMenuCodeOptions()
    {
        return Menu::lists('name', 'code');
    }

    private function resolvePage($url)
    {
        $page = PageManager::resolve($url, ['nesting' => true]);
        return $page;
    }
}
