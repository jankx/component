<?php
namespace Jankx\Component\Abstracts;

abstract class Component extends ComponentComposite
{
    protected function parseProps($props)
    {
        $this->props = $props;
    }
}
