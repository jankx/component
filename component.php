<?php
use Jankx\Component\Registry;

if (function_exists('jankx_component')) {
    // Load Jankx component helpers once time
    return;
}

/**
 * Jankx component
 *
 * @param string $name The component name
 * @param array $props Component property or data
 * @param array $args The options of component
 * @return void|string
 */
function jankx_component($name, $props, $args) {
    $components = Registry::getComponents();
    if (!isset($components[$name])) {
        return;
    }

    // Parse args with default values
    $args = wp_parse_args($args, array(
        'echo' => true,
    ));

    // Create component object
    $componentClass = array_get($components, $name);
    $component      = new $componentClass($props, $args);

    // The component output
    if (!$args['echo']) {
        return $component->render();
    }
    echo $component->render();
}
