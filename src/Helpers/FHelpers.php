<?php
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

use Illuminate\Contracts\Auth\Authenticatable;

if( !function_exists('hasDeveloper') ) {
    /**
     * Check if exists DEVELOPER value in .env.
     *
     * @param string|null $developer
     *
     * @return bool
     */
    function hasDeveloper(?string $developer = null): bool
    {
        return filled($dev = getDeveloper()) && ( !$developer || $developer === $dev);
    }
}

if( !function_exists('getDeveloper') ) {
    /**
     * @return string
     */
    function getDeveloper(): string
    {
        return trim(config('app.developer') ?: "");
    }
}

if( !function_exists('isDeveloper') ) {
    /**
     * Check DEVELOPER value in .env.
     *
     * @param string|null $developer
     *
     * @return bool
     */
    function isDeveloper(?string $developer = null): bool
    {
        return isDeveloperMode() && hasDeveloper($developer);
    }
}

if( !function_exists('isDeveloperMode') ) {
    /**
     * Check if dev mode is active.
     *
     * @return bool
     */
    function isDeveloperMode(): bool
    {
        return config('app.dev_mode', false);
    }
}

if( !function_exists('logout') ) {
    /**
     * @param $guard
     *
     * @return callable|mixed|null
     */
    function logout($guard = null)
    {
        return when((is_null($guard) ? auth() : auth($guard ?: 'web')), fn($a) => $a->logout());
    }
}

if( !function_exists('login') ) {
    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param                                            $remember
     * @param                                            $guard
     *
     * @return callable|mixed|null
     */
    function login(Authenticatable $user, $remember = false, $guard = null)
    {
        return when((is_null($guard) ? auth() : auth($guard ?: 'web')), fn($a) => $a->login($user, $remember));
    }
}

if( !function_exists('notifyWhenTerminating') ) {
    /**
     * Notify after response.
     *
     * @param \Illuminate\Notifications\Notifiable          $notifiable
     * @param \Illuminate\Notifications\Notification|string $notification
     *
     * @return void
     */
    function notifyWhenTerminating(\Illuminate\Notifications\Notifiable $notifiable, $notification)
    {
        \Illuminate\Container\Container::getInstance()->terminating(
            function() use ($notifiable, $notification) {
                $notification = $notification instanceof \Closure ? $notification() : (new $notification());
                $notifiable && $notifiable->notifyNow($notification);
            }
        );
    }
}
