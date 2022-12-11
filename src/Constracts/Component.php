<?php
namespace Jankx\Component\Constracts;

interface Component
{
    public function getName();

    public function defaultProps();

    public function parseProps($props);

    public function buildComponentData();

    public function render();

    public function __toString();

    public function echo();
}
