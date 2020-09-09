<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Template extends Component
{
    public static function getName()
    {
        return 'template_file';
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'template' => null,
            'data' => array(),
        ));
    }

    public function render()
    {
        if (empty($this->props['template'])) {
            return;
        }
        return jankx_template(
            $this->props['template'],
            $this->props['data'],
            null, // Context
            false // Do not echo template
        );
    }
}
