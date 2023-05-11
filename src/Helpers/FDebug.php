<?php
/*
 * Copyright © 2022. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

/**
 * dump to memory & return the result
 */
if( !function_exists('getDumpOutput') ) {
    /**
     * @return string
     */
    function getDumpOutput()
    {
        $_data = '';
        ob_start();
        $d = collect(func_get_args());
        $d->dump();

        $_data = ob_get_contents();
        ob_end_clean();

        return $_data;
    }
}

/**
 * Shortcut: get_class_methods
 */
if( !function_exists('_gcm') ) {
    /**
     * @return array
     */
    function _gcm()
    {
        return get_class_methods(...func_get_args());
    }
}

/**
 * Shortcut: get_class
 */
if( !function_exists('_gc') ) {
    /**
     * @return string
     */
    function _gc()
    {
        return get_class(...func_get_args());
    }
}

/**
 * Shortcut: class_exists
 */
if( !function_exists('_ce') ) {
    /**
     * @return bool
     */
    function _ce()
    {
        return class_exists(...func_get_args());
    }
}

if( !function_exists('bindTo') ) {
    /**
     * Bind the given Closure
     *
     * @param \Closure    $closure
     * @param object|null $newthis  The object to which the given anonymous function should be bound, or NULL for the closure to be unbound.
     * @param mixed       $newscope The class scope to which associate the closure is to be associated, or 'static' to keep the current one.
     *                              If an object is given, the type of the object will be used instead.
     *                              This determines the visibility of protected and private methods of the bound object.
     *
     * @return Closure Returns the newly created Closure object
     */
    function bindTo($closure, $newthis = null, $newscope = 'static')
    {
        if( isClosure($closure) && $newthis ) {
            return $closure->bindTo($newthis, $newscope);
        }

        return $closure;
    }
}
