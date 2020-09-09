<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Icon extends Component
{
    protected static $mappingFonts;

    public static function getName()
    {
        return 'icon';
    }

    protected static function loadFonts() {
        static::$mappingFonts = apply_filters('jankx_component_icon_fonts', array(
            'material' => array(
                'name' => 'Material Design Icons',
                'prefix' => 'mdi mdi',
            ),
        ));
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'name' => '',
            'font' => 'material',
            'wrap_tags' => 'span',
        ));

        if (is_null(static::$mappingFonts)) {
            return static::loadFonts();
        }
    }

    public function render()
    {
        if (empty($this->props['name'])) {
            return;
        }
        if (!isset(static::$mappingFonts[$this->props['font']])) {
            error_log(sprintf(
                __('The font `%s` family is not registered', 'jankx'),
                $this->props['font']
            ));
            return;
        }
        $loadedFont     = static::$mappingFonts[$this->props['font']];
        $iconAttributes = array(
            'class' => sprintf('%s-%s', $loadedFont['prefix'], $this->props['name']),
        );

        return sprintf(
            '<%1$s %2$s></%1$s>',
            $this->props['wrap_tags'],
            jankx_generate_html_attributes($iconAttributes)
        );
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
