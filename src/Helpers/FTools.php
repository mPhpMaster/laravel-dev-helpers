<?php
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

// region: return
if( !function_exists('returnCallable') ) {
    /**
     * Determine if the given value is callable, but not a string.
     * **Source**: ---  {@link \Illuminate\Support\Collection Laravel Collection}
     *
     * @param mixed $value
     *
     * @return \Closure
     */
    function returnCallable($value): \Closure
    {
        if( !is_callable($value) ) {
            return returnClosure($value);
        }

        if( is_string($value) ) {
            return Closure::fromCallable($value);
        }

        return $value;
    }
}

if( !function_exists('returnClosure') ) {
    /**
     * Returns function that returns any arguments u sent;
     *
     * @param mixed ...$data
     *
     * @return \Closure
     */
    function returnClosure(...$data)
    {
        $_data = head($data);
        if( func_num_args() > 1 ) {
            $_data = $data;
        } elseif( func_num_args() === 0 ) {
            $_data = returnNull();
        }

        return function() use ($_data) {
            return value($_data);
        };
    }
}

if( !function_exists('returnArray') ) {
    /**
     * Returns function that returns [];
     *
     * @param mixed ...$data
     *
     * @return \Closure
     */
    function returnArray(...$data)
    {
        return returnClosure($data);
    }
}

if( !function_exists('returnCollect') ) {
    /**
     * Returns function that returns Collection;
     *
     * @param mixed ...$data
     *
     * @return \Closure
     */
    function returnCollect(...$data)
    {
        return function(...$args) use ($data) {
            return collect($data)->merge($args);
        };
    }
}

if( !function_exists('returnArgs') ) {
    /**
     * Returns function that returns func_get_args();
     *
     * @return \Closure
     */
    function returnArgs()
    {
        return function() {
            return func_get_args();
        };
    }
}

if( !function_exists('returnString') ) {
    /**
     * Returns function that returns ""
     *
     * @param string|null $text
     *
     * @return \Closure
     */
    function returnString(?string $text = "")
    {
        return returnClosure((string) $text);
    }
}

if( !function_exists('returnNull') ) {
    /**
     * Returns function that returns null;
     *
     * @param mixed ...$data
     *
     * @return \Closure
     */
    function returnNull()
    {
        return function() {
            return null;
        };
    }
}

if( !function_exists('returnTrue') ) {
    /**
     * Returns function that returns true;
     *
     * @param mixed ...$data
     *
     * @return \Closure
     */
    function returnTrue()
    {
        return returnClosure(true);
    }
}

if( !function_exists('returnFalse') ) {
    /**
     * Returns function that returns false;
     *
     * @param mixed ...$data
     *
     * @return \Closure
     */
    function returnFalse()
    {
        return returnClosure(false);
    }
}
// endregion: return

if( !function_exists('unauthenticated') ) {
    /**
     * @param string      $message
     * @param array       $guards
     * @param string|null $redirectTo
     *
     * @return \Illuminate\Auth\AuthenticationException
     */
    function unauthenticated($message = null, array $guards = [], $redirectTo = null)
    {
        $message = $message ?? (($message = __($label = "auth.unauthenticated")) === $label ? null : $message);

        return new \Illuminate\Auth\AuthenticationException($message, $guards, $redirectTo);
//        return new \Exception($message, $status);
    }
}

if( !function_exists('throwUnauthenticated') ) {
    /**
     * @param string      $message
     * @param array       $guards
     * @param string|null $redirectTo
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    function throwUnauthenticated($message = null, array $guards = [], $redirectTo = null)
    {
        $message = $message ?? (($message = __($label = "auth.unauthenticated")) === $label ? null : $message);
        throw unauthenticated($message, $guards, $redirectTo);
    }
}

if( !function_exists('fixPath') ) {
    /**
     * Fix slashes/back-slashes replace it with DIRECTORY_SEPARATOR.
     *
     * @param string $path
     *
     * @return string
     */
    function fixPath(string $path, $replace_separator_with = DIRECTORY_SEPARATOR)
    {
        $replace_separator_with = $replace_separator_with ?: DIRECTORY_SEPARATOR;

        return replaceAll([
                              "\\" => $replace_separator_with,
                              "/" => $replace_separator_with,
                              $replace_separator_with . $replace_separator_with => $replace_separator_with,
                          ], $path);
    }
}

if( !function_exists('real_path') ) {
    /**
     * return given path without ../
     *
     * @param string|null $path
     * @param string      $DIRECTORY_SEPARATOR
     *
     * @return string
     */
    function real_path($path = null, $DIRECTORY_SEPARATOR = "/")
    {
        $_DIRECTORY_SEPARATOR = $DIRECTORY_SEPARATOR === "/" ? "\\" : "/";
        if( $path ) $path = str_ireplace($_DIRECTORY_SEPARATOR, $DIRECTORY_SEPARATOR, $path);

        $a = 0;
        if( stringStarts($path, [ './' ]) ) {
            $path = substr($path, 2);
            $path = base_path($path);
            $a = 1;
        }

        $backslash = "..{$DIRECTORY_SEPARATOR}";
        if( stripos($path, $backslash) !== false ) {
            $path = collect(explode($backslash, $path))->reverse();
            $path = $path->map(function($v, $i) use ($path) {
                $_v = ($_v = dirname($v)) === '.' ? '' : $_v;

                return $i == $path->count() - 1 ? $v : $_v;
            });
            $path = str_ireplace(
                $DIRECTORY_SEPARATOR . $DIRECTORY_SEPARATOR,
                $DIRECTORY_SEPARATOR,
                $path->reverse()->implode($DIRECTORY_SEPARATOR)
            );
        }

        $path = str_ireplace(
            './',
            '/',
            fixPath($path)
        );

        return collect($path)->first();
    }
}

if( !function_exists('fromCallable') ) {
    /**
     * @param string|\Closure|callable $callable
     *
     * @return \Closure|mixed
     * @throws \Exception
     */
    function fromCallable($callable)
    {
        if( $callable instanceof Closure ) {
            return $callable;
        }

        if( is_string($callable) || is_array($callable) ) {
            if( !is_callable($callable) ) {
                throw new Exception("The given name [{$callable}] is not callable!");
            }

            return \Closure::fromCallable($callable);
        }

        return $callable;
    }
}
