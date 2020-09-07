<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Header extends Component
{
    public static function getName()
    {
        return 'header';
    }

    protected function createChildCompontsFromPreset($presetName)
    {
        return apply_filters("jankx_compont_preset_{$presetName}_create_children");
    }

    public function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'preset' => 'none',
        ));

        if ($this->props['preset'] !== 'none') {
            $this->children = static::createChildCompontsFromPreset($this->props['preset']);
        }
    }

    public function render()
    {
    }
}
