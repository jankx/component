<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\LayoutComponent;

class Row extends LayoutComponent
{
    public static function getName()
    {
        return 'row';
    }

    public function parseProps($props) {
        $this->props = wp_parse_args($props, array(
            'items' => 4,
            'extra_items' => 0,
            'tablet_items' => 0,
            'mobile_items' => 0,
        ));
    }

    public function render()
    {
    }
}
