<?php
use Jankx\Component\Registry;
use Jankx\TemplateEngine\Data;
use Jankx\Component\Abstracts\ComponentComposite;

if (defined('JANKX_COMPONENT_ROOT_DIR')) {
    return;
}
define('JANKX_COMPONENT_ROOT_DIR', dirname(__FILE__));

/**
 * Jankx component
 *
 * @param string $name The component name
 * @param array $props Component property or data
 * @param array $args The options of component
 *
 * @return Jankx\Component\Constracts\Component | null;
 */
function jankx_component($name, $props = array(), $echo = false)
{
    // Get all components are supported
    $components = Registry::getComponents();

    if (!isset($components[$name])) {
        error_log(
            sprintf(
                __('The component `%s` is not registered in Jankx system', 'jankx'),
                $name
            )
        );
        return null;
    }

    // Create component object
    $componentClass = array_get($components, $name);
    $component      = new $componentClass($props);

    if (is_a($component, ComponentComposite::class)) {
        // The component output
        if (!$echo) {
            return $component;
        }
        echo $component;
    }
    return $component;
}
