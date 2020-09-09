<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class HTML extends Component
{
    public static function getName()
    {
        return 'html';
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_props($props, array(
            'content' => '',
        ));
    }

    public function render()
    {
        /**
         * Sanitizes content for allowed HTML tags for post content.
         * @link https://developer.wordpress.org/reference/functions/wp_kses_post/
         */
        return wp_kses_post(
            $this->props['content']
        );
    }
}
