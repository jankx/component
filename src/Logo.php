<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Logo extends Component
{
    public static function getName()
    {
        return 'logo';
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'type'      => 'text',
            'text'      => 'Jankx Framework',
            'image_url' => '',
            'url'       => site_url(),
            'wrap_tag'  => is_home() || is_front_page() ? 'h1' : 'h2',
        ));
    }

    public function render()
    {
        if ($this->props['type'] === 'image') {
            return jankx_template('components/logo/image', $this->props, 'logo_image', false);
        }
        return jankx_template('components/logo/text', $this->props, 'logo_text', false);
    }
}
