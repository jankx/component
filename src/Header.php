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
        if ($presetName === 'default') {
            add_filter(
                'jankx_compont_header_preset_default_components',
                array(__CLASS__, 'createDefaultPreset')
            );
        }

        return apply_filters(
            "jankx_compont_header_preset_{$presetName}_components",
            array()
        );
    }

    public function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'preset' => 'none',
            'sticky' => false,
        ));

        if ($this->props['preset'] !== 'none') {
            $this->props['children'] = static::createChildCompontsFromPreset($this->props['preset']);
        }
    }

    public static function createDefaultPreset($components)
    {
        return $components;
    }

    public function render()
    {
        return $this->renderChildren();
    }
}
