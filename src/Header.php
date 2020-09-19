<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;
use Jankx\Option\Option;

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
            'display' => 'flex',
        ));

        if ($this->props['preset'] !== 'none') {
            $this->props['children'] = static::createChildCompontsFromPreset($this->props['preset']);
        }
    }

    public static function createDefaultPreset($components)
    {
        array_push($components, new Navigation(array(
            'theme_location' => 'primary'
        )));

        array_push($components, new Template(array(
            'template_file' => array(
                'layout/header/end'
            ),
        )));

        return $components;
    }

    public function open()
    {
        ob_start();
        jankx_template('layout/header/open');

        parent::open();

        return ob_get_clean();
    }

    public function close()
    {
        ob_start();

        parent::close();
        jankx_template('layout/header/close');

        return ob_get_clean();
    }

    public function render()
    {
        return $this->renderChildren();
    }
}
