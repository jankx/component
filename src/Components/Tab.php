<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Tab extends Component
{
    const COMPONENT_NAME = 'tab';

    public function getName()
    {
        return static::COMPONENT_NAME;
    }
}
