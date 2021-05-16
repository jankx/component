<?php
namespace Jankx\Component\Components;

use Jankx\Component\Abstracts\Component;

class Navigation extends Component
{
    const COMPONENT_NAME = 'nav';

    public function getName()
    {
        return static::COMPONENT_NAME;
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'theme_location' => '',
            'open_container' => false,
        ));
    }

    public function render()
    {
        if (empty($this->props['theme_location'])) {
            return;
        }

        $templates = array(
            "components/navigation/{$this->props['theme_location']}",
            'components/navigation'
        );

        return jankx_template(
            $templates,
            array(
                'args' => apply_filters(
                    "jankx_component_navigation_{$this->props['theme_location']}_args",
                    $this->props
                ),
            ),
            "navigation_{$this->props['theme_location']}",
            false
        );
    }
}
