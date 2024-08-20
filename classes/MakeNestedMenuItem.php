<?php namespace Kevinklonne\MenuBuilder\Classes;

class MakeNestedMenuItem
{
    public function make($item, $nestedItem)
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
                $menuitem['items'][] = $this->make($item, $subitem);
            }
        }

        return $menuitem;
    }
}
