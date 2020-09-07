<?php
namespace Jankx\Component\Abstracts;

abstract class Component extends ComponentComposite
{
    protected $props;
    protected $args;

    public function __construct($props, $args)
    {
        // Set component options
        $this->args = wp_parse_args($args, array(
            'show_on_mobile' => true,
        ));

        // Parse props before render output
        $this->parseProps($props);
    }

    protected function parseProps($props)
    {
        $this->props = $props;
    }
}
