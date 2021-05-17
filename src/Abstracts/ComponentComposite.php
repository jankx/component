<?php
namespace Jankx\Component\Abstracts;

use Jankx;
use Jankx\Template\Template;
use Jankx\Component\Constracts\Component;
use Jankx\TemplateEngine\Data;

abstract class ComponentComposite implements Component
{
    protected static $isEngineRender = null;

    protected $props = array();
    protected $args  = array();
    protected $isGlobal = false;
    protected $isDataBuild = false;
    protected $supportEngines = array('wordpress', 'plates');

    public function __construct($props, $args = array())
    {
        // Set component options
        $this->args = apply_filters(
            sprintf('jankx_component_%s_options', static::getName()),
            wp_parse_args($args, array(
                'show_on_mobile' => true,
            ))
        );

        // Parse props before render output
        $this->parseProps(wp_parse_args(
            $props,
            array(
                'context' => null,
                'children' => array(),
            )
        ));
    }


    public function __toString()
    {
        return (string) $this->generateContent();
    }

    public function open()
    {
        do_action(
            sprintf('jankx_component_%s_open', static::getName()),
            $this->props,
            $this->args
        );
    }

    public function close()
    {
        do_action(
            sprintf('jankx_component_%s_close', static::getName()),
            $this->props,
            $this->args
        );
    }

    public function renderChildren()
    {
        if (count($this->props['children']) <= 0) {
            return;
        }
        $output = '';
        foreach ($this->props['children'] as $childComponent) {
            $output .= (string) $childComponent;
        }

        return $output;
    }

    protected function generateContent()
    {
        $content = $this->open();

        $content .= $this->render();

        $content .= $this->close();

        return $content;
    }

    public function addChild($childComponent)
    {
        if (!is_a($childComponent, Component::class)) {
            throw new \Exception(sprintf(
                'The child component must be an instance of %s',
                Component::class
            ));
        }

        $this->props['children'][] = $childComponent;
    }

    public function addChildren($childComponents)
    {
        foreach ($childComponents as $childComponent) {
            try {
                $this->addChild($childComponent);
            } catch (\Error $e) {
                error_log($e->getMessage());
            }
        }
    }

    protected function parseProps($props)
    {
        $this->props = $props;
    }

    public function isGlobal()
    {
        return $this->isGlobal;
    }

    public function isDataBuild()
    {
        return $this->isDataBuild;
    }

    public function buildComponentData()
    {
        return array();
    }

    public static function isEngineRender()
    {
        if (!is_null(static::$isEngineRender)) {
            return static::$isEngineRender;
        }
        $engine = Template::getEngine(Jankx::ENGINE_ID);

        static::$isEngineRender = $engine->isRenderDirectly();

        return static::$isEngineRender;
    }
}
