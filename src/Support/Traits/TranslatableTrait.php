<?php

namespace Newnet\Core\Support\Traits;

use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait TranslatableTrait
{
    use BaseHasTranslations;

    /**
     * Encode the given value as JSON.
     *
     * @param  mixed  $value
     * @return string
     */
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    protected function getLocale(): string
    {
        return $this->translationLocale ?: request('edit_locale') ?? config('app.locale');
    }

    public function getTranslatableAttributes(): array
    {
        return is_array($this->translatable) && config('core.enable_translate')
            ? $this->translatable
            : [];
    }
}
