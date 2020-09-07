<?php
namespace Jankx\Component;

class Registry
{
    protected static $components = array();

    public static function register($name, $componentClass)
    {
        if (isset(static::$components[$name])) {
            return;
        }
        if (!class_exists($componentClass)) {
            return;
        }
        // Register the component to global list
        static::$components[$name] = $componentClass;
    }

    public static function registerComponents()
    {
        static::$components = apply_filters(
            'jankx_components',
            array(
                Row::getName() => Row::class,
                Column::getName() => Column::class,
                Header::getName() => Header::class,
            )
        );
    }

    public static function getComponents()
    {
        return static::$components;
    }
}
