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
        ob_start();
        ?>
        <header <?php echo jankx_generate_html_attributes($headerAttributes); ?>>
            <?php do_action('jankx_template_before_header_content'); ?>
            <?php jankx_open_container(); ?>

                <?php do_action('jankx_component_before_header'); ?>
                <?php echo $this->renderChildren(); ?>
                <?php do_action('jankx_component_after_header'); ?>

            <?php jankx_close_container(); ?>
          <?php do_action('jankx_template_after_header_content'); ?>
        </header>
        <?php
        return ob_get_clean();
    }
}
