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

    private function getMenu()
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

    private function getMenuItems()
    {
        $menu = $this->menu;
        
        if ( !$menu ) {
            return;
        }

        $menu_id = $menu->id;
        $menuItems = MenuItem::where('menu_id', $menu_id)->where('is_hidden', false)->get();
        $items = [];

        foreach ($menuItems->toNested() as $item) {
            if ( $item->url ) {
                $page = $this->resolvePage($item->url);
                $isActive = $page->isActive;
                $url = $page->url;
            } else {
                $url = null;
                $isActive = false;
            }
            $menuitem = [];
            
            if ( $item->replace_with_nested ) {
                if ( $page->items ) {
                    foreach ( $page->items as $nested ) {
                        $menuitem['label'] = $nested->title;
                        $menuitem['url'] = $nested->url;
                        $menuitem['is_external'] = false;
                        $menuitem['css_class'] = null;
                        $menuitem['code'] = null;
                        $menuitem['custom_attributes'] = null;
                        $menuitem['isActive'] = $nested->isActive;
                        $menuitem['childActive'] = false;
                        $menuitem['items'] = [];
                        $subitem = [];
                        
                        if ( $item->include_nested ) {
                            if ( $nested->items ) {
                                foreach ( $nested->items as $subitem ) {
                                    $subitem['label'] = $subitem->title;
                                    $subitem['url'] = $subitem->url;
                                    $subitem['is_external'] = false;
                                    $subitem['css_class'] = null;
                                    $subitem['code'] = null;
                                    $subitem['custom_attributes'] = null;
                                    $subitem['isActive'] = $subitem->isActive;
                                    if ( $subitem->isActive ) {
                                        $menuitem['childActive'] = true;
                                    }
                                    
                                    $menuitem['items'][] = $subitem;
                                }
                            }
                        }
                        
                        $items[] = $menuitem;
                    }
                }
            }
            
            else {
                $menuitem['label'] = $item->label;
                $menuitem['url'] = $url;
                $menuitem['is_external'] = $item->is_external;
                $menuitem['css_class'] = $item->css_class;
                $menuitem['code'] = $item->code;
                $menuitem['custom_attributes'] = $item->custom_attributes;
                $menuitem['isActive'] = $isActive;
                $menuitem['childActive'] = false;
                $menuitem['items'] = [];

                if ( $item->include_nested ) {
                    if ( $page->items ) {
                        foreach ( $page->items as $nested ) {
                            $subitem['label'] = $nested->title;
                            $subitem['url'] = $nested->url;
                            $subitem['is_external'] = false;
                            $subitem['css_class'] = null;
                            $subitem['code'] = null;
                            $subitem['custom_attributes'] = null;
                            $subitem['isActive'] = $nested->isActive;
                            if ( $nested->isActive ) {
                                $menuitem['childActive'] = true;
                            }
                            
                            $menuitem['items'][] = $subitem;
                        }
                    }
                }

                if ( $item->children ) {
                    foreach ( $item->children as $child ) {
                        $resolvedChild = $this->resolvePage($child->url);
    
                        if ( $child->replace_with_nested ) {
                            $subitem['label'] = '';
                            $subitem['url'] = '';
                        } else {
                            $subitem['label'] = $child->label;
                            $subitem['url'] = $resolvedChild->url;
                        }
            
                        $subitem['is_external'] = $child->is_external;
                        $subitem['css_class'] = $child->css_class;
                        $subitem['code'] = $child->code;
                        $subitem['custom_attributes'] = $child->custom_attributes;
                        $subitem['isActive'] = $this->isActive($child->url);
    
                        if ( $this->isActive($child->url) ) {
                            $menuitem['childActive'] = true;
                        }
    
                        $menuitem['items'][] = $subitem;
                    }
                }
    
                $items[] = $menuitem;
            }
        }
        $menutree = collect($items);
        return $menutree;
    }

    public function getMenuCodeOptions()
    {
        return Menu::lists('name', 'code');
    }

    private function isActive($url)
    {
        $page = PageManager::resolve($url);
        return $page->isActive;
    }

    private function resolvePage($url)
    {
        $page = PageManager::resolve($url, ['nesting' => true]);
        return $page;
    }
}
