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
                Icon::getName()       => Icon::class,
                Row::getName()        => Row::class,
                Column::getName()     => Column::class,
                Header::getName()     => Header::class,
                Footer::getName()     => Footer::class,
                HTML::getName()       => HTML::class,
                Template::getName()   => Template::class,
                Logo::getName()       => Logo::class,
                Modal::getname()      => Modal::class,
                SearchForm::getName() => SearchForm::class,
                Link::getName()       => Link::class,
                Dropdown::getName()   => Dropdown::class,
                DataList::getName()   => DataList::class,
                DataList::NAME        => DataList::class, // Make alias `list` for `datalist`
            )
        );
    }

    public static function getComponents()
    {
        return static::$components;
    }
}
