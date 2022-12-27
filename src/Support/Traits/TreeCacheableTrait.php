<?php

namespace Newnet\Core\Support\Traits;

use Kalnoy\Nestedset\NodeTrait;
use Newnet\Core\Support\TreeCacheableQueryBuilder;

trait TreeCacheableTrait
{
    use NodeTrait;
    use CacheableTrait;

//    public function newEloquentBuilder($query)
//    {
//        return new TreeCacheableQueryBuilder($query);
//    }
}
