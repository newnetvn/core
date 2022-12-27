<?php

namespace Newnet\Core\Http\Middleware;

use Closure;

class TranslationAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->is(config('core.admin_prefix').'*')) {
            config([
                'translatable.fallback_locale' => null,
            ]);
        }

        return $next($request);
    }
}
