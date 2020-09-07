<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Icon extends Component
{
    public static function getName()
    {
        return 'icon';
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'name' => '',
            'font' => 'material'
        ));
    }

    public function render()
    {
    }

    public function addChild($childComponent)
    {
        throw new \Exception(
            __e('Icon component do not support add child component', 'jankx')
        );
    }

    public function addChilds($childComponents)
    {
        throw new \Exception(
            __e('Icon component do not support add child components', 'jankx')
        );
    }
}
