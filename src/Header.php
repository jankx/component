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
            'preset' => 'default',
            'sticky' => false,
            'display' => 'flex',
        ));

        $this->props = apply_filters(
            'jankx_component_header_props',
            $this->props
        );

        if ($this->props['preset'] !== 'none') {
            $this->props['children'] = static::createChildCompontsFromPreset($this->props['preset']);
        }
    }

    public static function createDefaultPreset($components)
    {
        array_push($components, new Template(array(
            'template_file' => array(
                'layout/header/before'
            ),
        )));

        array_push($components, new Navigation(array(
            'theme_location' => apply_filters('jankx_header_component_default_preset_menu', 'primary'),
            'show_home'      => true,
        )));

        array_push($components, new Template(array(
            'template_file' => array(
                'layout/header/end'
            ),
        )));

        return $components;
    }

    public function render()
    {
        $headerAttributes = array(
            'id' => 'jankx-site-header',
            'class' => array(
                'jankx-site-header'
            )
        );
        if ($this->props['sticky']) {
            $headerAttributes['class'][] = 'sticky-header';
        }

        return jankx_template('components/header', array(
            'content' => $this->renderChildren(),
            'attributes' => jankx_generate_html_attributes($headerAttributes),
        ), 'component-header', false);
    }
}
