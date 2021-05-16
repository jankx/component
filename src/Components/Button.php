<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Button extends Component
{
    const COMPONENT_NAME = 'button';

    public function getName()
    {
        return static::COMPONENT_NAME;
    }
}
