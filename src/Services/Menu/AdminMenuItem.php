<?php

namespace Newnet\Core\Services\Menu;

use Lavary\Menu\Item;

class AdminMenuItem extends Item
{
    public function getFirstChildUrl()
    {
        foreach ($this->children() as $child) {
            return $child->url();
        }

        return '#';
    }
}
