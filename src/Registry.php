<?php
namespace Jankx\Component;

use Jankx\Component\Components\Icon;
use Jankx\Component\Components\Row;
use Jankx\Component\Components\Column;
use Jankx\Component\Components\Header;
use Jankx\Component\Components\Footer;
use Jankx\Component\Components\HTML;
use Jankx\Component\Components\Template;
use Jankx\Component\Components\Logo;
use Jankx\Component\Components\Modal;
use Jankx\Component\Components\SearchForm;
use Jankx\Component\Components\Link;
use Jankx\Component\Components\Dropdown;
use Jankx\Component\Components\DataList;
use Jankx\Component\Components\BreakingNews;
use Jankx\Component\Components\Navigation;

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
                Icon::COMPONENT_NAME         => Icon::class,
                Row::COMPONENT_NAME          => Row::class,
                Column::COMPONENT_NAME       => Column::class,
                Header::COMPONENT_NAME       => Header::class,
                Footer::COMPONENT_NAME       => Footer::class,
                HTML::COMPONENT_NAME         => HTML::class,
                Template::COMPONENT_NAME     => Template::class,
                Logo::COMPONENT_NAME         => Logo::class,
                Modal::COMPONENT_NAME        => Modal::class,
                SearchForm::COMPONENT_NAME   => SearchForm::class,
                Link::COMPONENT_NAME         => Link::class,
                Dropdown::COMPONENT_NAME     => Dropdown::class,
                DataList::COMPONENT_NAME     => DataList::class,
                'list'                       => DataList::class,
                BreakingNews::COMPONENT_NAME => BreakingNews::class,
                Navigation::COMPONENT_NAME   => Navigation::class,
            )
        );
    }

    public static function getComponents()
    {
        return static::$components;
    }
}
