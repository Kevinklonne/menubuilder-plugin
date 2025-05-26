<?php namespace KevinKlonne\MenuBuilder\Classes;

use KevinKlonne\MenuBuilder\Classes\ResolvePage;
use KevinKlonne\MenuBuilder\Classes\MakeNestedMenuItem;


class MakeMenuItem
{
    public function make($item)
    {
        $pageResolver = new ResolvePage();
        $nesteMenuItem = new MakeNestedMenuItem();

        $menuitem = [];

        $page = $pageResolver->resolve($item->url);

        $menuitem['label'] = $item->label;
        $menuitem['is_external'] = $item->is_external;
        $menuitem['css_class'] = $item->css_class;
        $menuitem['code'] = $item->code;
        $menuitem['custom_attributes'] = $item->custom_attributes;

        if ( $item->url ) {
            $menuitem['url'] = $page->url ?: '';
            $menuitem['isActive'] = $page->isActive ?: false;
            $menuitem['items'] = [];

            if ( $page->url )  {
                $menuitem['hidden'] = false;
            } else {
                $menuitem['hidden'] = true;
            }

            if ( $item->include_nested ) {
                if ( $page->items ) {
                    foreach ( $page->items as $nested ) {
                        $menuitem['items'][] = $nesteMenuItem->make($item, $nested);
                    }
                }
            }
        }

        if ( !$item->children ) {
            return $menuitem;
        }

        foreach ( $item->children as $child ) {
            if ( $child->replace_with_nested ) {
                if ( !$child->url ) {
                    continue;
                }

                $resolveChild = $pageResolver->resolve($child->url);

                foreach ( $resolveChild->items as $nested ){
                    $menuitem['items'][] = $nesteMenuItem->make($item, $nested);
                }

            } else {
                $menuitem['items'][] = $this->make($child, $item);

            }
        }

        return $menuitem;

    }
}
