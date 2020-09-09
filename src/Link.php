<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Link extends Component
{
    public static function getName()
    {
        return 'link';
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'text' => '',
            'url' => '',
            'target' => '_self',
        ));
    }

    public function render()
    {
        // Check the link text or url must have a value
        if (!isset($this->props['text'], $this->props['url'])) {
            return;
        }
        return jankx_template('components/link', $this->props, 'link', false);
    }
}
