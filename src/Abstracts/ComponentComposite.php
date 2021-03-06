<?php
namespace Jankx\Component\Abstracts;

use Jankx;
use Jankx\Template\Template;
use Jankx\TemplateEngine\Data;
use Jankx\Component\Constracts\Component;

abstract class ComponentComposite implements Component
{
    protected static $engine;

    protected $props = array();

    public function __construct($props)
    {
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
            $this->props
        );
    }

    public function close()
    {
        do_action(
            sprintf('jankx_component_%s_close', static::getName()),
            $this->props
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

    protected function parseProps($props)
    {
        $this->props = $props;
    }

    public function buildComponentData()
    {
        return array();
    }

    public function _render()
    {
        $engine = Template::getEngine('jankx');
        if (is_null($engine)) {
            throw \Exception('The Jankx template engine is not initialized');
        }

        $args = func_get_args();
        $templates = array_get($args, 0);
        if (is_array($templates)) {
            $args[0] = array_map(function ($template) {
                return sprintf('components/%s', $template);
            }, $templates);
        } else {
            $args[0] = sprintf('components/%s', $templates);
        }

        return call_user_func_array(
            array($engine, 'render'),
            $args
        );
    }
}
