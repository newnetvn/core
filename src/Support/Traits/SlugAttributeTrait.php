<?php

namespace Newnet\Core\Support\Traits;

use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

trait SlugAttributeTrait
{
    use HasSlug;

    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = Str::slug($value, $this->getSlugOptions()->slugSeparator, $this->getSlugOptions()->slugLanguage);
    }

    public function getSlugOptions()
    {
        return SlugOptions::create()
            ->doNotGenerateSlugsOnUpdate()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
