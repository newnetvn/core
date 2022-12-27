<?php

namespace Newnet\Core\Services\Menu;

use Illuminate\Support\Arr;
use Lavary\Menu\Builder;

class AdminMenuBuilder extends Builder
{
    const ADMIN_MENU_NAME = 'admin-menu';

    protected $extendOptions = ['icon', 'permission', 'order'];

    public function __construct()
    {
        $name = self::ADMIN_MENU_NAME;
        $conf = config('core.admin_menu');

        parent::__construct($name, $conf);
    }

    public function add($title, $options = '')
    {
        $id = isset($options['id']) ? $options['id'] : $this->id();

        $item = new AdminMenuItem($this, $id, $title, $options);

        $this->items->push($item);

        return $item;
    }

    public function addItem($title, $options = [])
    {
        if (isset($options['parent']) && !$this->{$options['parent']}) {
            unset($options['parent']);
        }

        $item = $this->add($title, Arr::except($options, $this->extendOptions));

        if (isset($options['href'])) {
            $item->link->href($options['href']);
        }

        foreach ($this->extendOptions as $extend) {
            if (isset($options[$extend])) {
                $item->data($extend, $options[$extend]);
            }
        }

        if (!empty($options['id']) && empty($options['nickname'])) {
            $item->nickname($options['id']);
        }

        return $item;
    }

    public function activeMenu($menuId)
    {
        if ($findMenu = $this->get($menuId)) {
            $findMenu->activate();
        }
    }

    public function filterPermisison()
    {
        return $this->filter(function ($item) {
            if ($item->hasChildren()) {
                return true;
            }

            $permission = $item->data('permission');
            if ($permission) {
                return admin_can($permission);
            }

            return true;
        });
    }

    public function filterChildren()
    {
        return $this->filter(function ($item) {
            if ($item->url() != '#') {
                return true;
            }

            $checkArr = [];

            foreach ($item->children() as $child) {
                if ($child->hasChildren() || $child->url() != '#') {
                    $checkArr[] = true;
                }
            }

            return (bool) count(array_filter($checkArr));
        });
    }
}
