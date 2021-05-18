<?php
namespace Jankx\Component\Abstracts;

use Jankx;
use Jankx\Template\Template;
use Jankx\Component\Constracts\Component;
use Jankx\TemplateEngine\Data;

abstract class ComponentComposite implements Component
{
    const RETURN_TYPE_STRING = 1;
    const RETURN_TYPE_ARRAY = 2;

    protected static $isEngineRender = null;

    protected $parent = null;
    protected $props = array();
    protected $args  = array();
    protected $supportEngines = array('wordpress', 'plates', 'twig');

    protected $returnType = 1;

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
            $output .= $childComponent->render();
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
        $childComponent->setParent($this);
        $this->props['children'][] = &$childComponent;
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

    public function setParent(&$parent)
    {
        $this->parent = $parent;
    }

    protected function parseProps($props)
    {
        $this->props = $props;
    }

    public function setReturnType($returnType)
    {
        $supportTypes = array(
            static::RETURN_TYPE_STRING,
            static::RETURN_TYPE_ARRAY,
        );
        if (!in_array($returnType, $supportTypes)) {
            $error_message = sprintf(__('The return type "%s" is not support', 'jankx'), $returnType);

            return error_log($error_message);
        }
        $this->returnType = $returnType;
    }

    public function generate()
    {
        if ($this->returnType === static::RETURN_TYPE_ARRAY) {
            return $this->buildComponentData();
        }
        return $this->render();
    }

    public function buildComponentData()
    {
        return array();
    }

    public function isEngineRender()
    {
        if (!is_null(static::$isEngineRender)) {
            return static::$isEngineRender;
        }

        $engineName = Jankx::ENGINE_ID;
        if (!in_array($engineName, $this->supportEngines)) {
            foreach ($this->supportEngines as $engineName) {
                $engine = Template::getEngine($engineName);
                if (!is_null($engine)) {
                    break;
                }
            }
        } else {
            $engine = Template::getEngine($engineName);
        }

        if (is_null($engine)) {
            return false;
        }

        static::$isEngineRender = $engine->isRenderDirectly();
        return static::$isEngineRender;
    }

    public function hasParent()
    {
        return $this->parent !== null;
    }
}
