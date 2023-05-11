<?php
/*
 * Copyright © 2022. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

if( !function_exists('getSql') ) {
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return string
     */
    function getSql(Builder|Relation|\Illuminate\Contracts\Database\Query\Builder $builder, bool $parse = false): string
    {
        $sql = sprintf(str_ireplace('?', "'%s'", $builder->toSql()), ...$builder->getBindings());

        return !$parse ? $sql : replaceAll([
                                               " or " => "\n\t\tor ",
                                               " and " => "\n\t\tand ",
                                               " where " => "\n\twhere ",
                                           ], $sql);
    }
}

if( !function_exists('getMethodName') ) {
    /**
     * Returns method name by given Route->uses
     *
     * @param string $method
     *
     * @return string
     */
    function getMethodName(string $method): string
    {
        if( empty($method) ) return '';

        if( stripos($method, '::') !== false )
            $method = collect(explode('::', $method))->last();

        if( stripos($method, '@') !== false )
            $method = collect(explode('@', $method))->last();

        return $method;
    }
}

if( !function_exists('getClassPropertyValue') ) {
    /**
     * Get property value fom class
     *
     * @param string $class
     * @param string $property
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    function getClassPropertyValue(string $class, string $property)
    {
        $_property = new ReflectionProperty($class, $property);
        $_property->setAccessible(true);

        return $_property->getValue();
    }
}
