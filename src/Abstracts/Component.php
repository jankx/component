<?php
namespace Jankx\Component\Abstracts;

use Jankx\Component\Constracts\Component as ComponentAbstract;

abstract class Component implements ComponentAbstract
{
    protected $props;
    protected $args;

    public function __construct($props, $args)
    {
        // Set component options
        $this->args = $args;

        // Parse props before render output
        $this->parseProps($props);
    }

    protected function parseProps($props)
    {
        $this->props = $props;
    }
}
