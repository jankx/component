<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Dropdown extends Component
{
    public static function getName()
    {
        return 'dropdown';
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
        ));
    }

    public function render()
    {
    }
}
