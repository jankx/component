<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\BaseComponent;

class Header extends BaseComponent
{
    protected static $presets = array(
    );

    public static function getName()
    {
        return 'header';
    }

    protected function createChildCompontsFromPreset($presetName) {
    }

    public function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'preset' => 'none',
        ));

        if ($this->props['preset'] === 'none') {
            $this->children = static::createChildCompontsFromPreset($this->props['preset']);
        }
    }

    public function render()
    {
    }
}
