<?php

namespace Newnet\Core\Support\Traits;

use Spatie\EloquentSortable\SortableTrait;

trait SortOrderTrait
{
    use SortableTrait;

    public static function bootSortOrderTrait()
    {
        static::creating(function ($model) {
            if ($model->shouldSortWhenCreating()) {
                $model->setHighestOrderNumber();
            }
        });
    }

    protected function determineOrderColumnName(): string
    {
        return $this->sortable['order_column_name'] ?? 'sort_order';
    }
}
