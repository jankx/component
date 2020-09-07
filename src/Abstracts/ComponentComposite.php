<?php
namespace Jankx\Component\Abstracts;

use Jankx\Component\Constracts\Component;

abstract class ComponentComposite implements Component
{
    protected $children = array();

    public function __toString()
    {
        return (string) $this->render();
    }

    public function addChild($childComponent)
    {
        if (!is_a($childComponent, Component::class)) {
            throw new \Exception(sprintf(
                'The child component must be an instance of %s',
                Component::class
            ));
        }

        $this->children[] = $childComponent;
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
}
