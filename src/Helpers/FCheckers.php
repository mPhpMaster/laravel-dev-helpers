<?php
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

if( !function_exists('isCommandExists') ) {
    /**
     * @param string $command
     *
     * @return bool
     */
    function isCommandExists(string $command): bool
    {
        return trim($command) && collect(\Artisan::all())
                ->filter(fn($c) => $c && $c->isHidden() !== true)
                ->keys()
                ->filter()
                ->contains($command);
    }
}

if( !function_exists('isLoggedIn') ) {
    /**
     * @param string|null $guard
     *
     * @return bool
     */
    function isLoggedIn($guard = null): bool
    {
        return auth($guard ?? 'web')->check() ?? auth()->check() ?? false;
    }
}

if( !function_exists('isGuest') ) {
    /**
     * @param string|null $guard
     *
     * @return bool
     */
    function isGuest($guard = null): bool
    {
        return auth($guard ?? 'web')->guest() ?? auth()->guest() ?? false;
    }
}

if( !function_exists('isClosure') ) {
    /**
     * Check if the given var is Closure.
     *
     * @param mixed|null $closure
     *
     * @return bool
     */
    function isClosure($closure): bool
    {
        return $closure instanceof Closure;
    }
}
