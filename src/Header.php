<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\BaseComponent;

class Header extends BaseComponent
{
    public static function getName() {
        return 'header';
    }

    public function parseProps($props) {
        $this->props = wp_parse_args($props, array(
            'style' => 'default',
        ));
    }

    public function render() {
    }
}
