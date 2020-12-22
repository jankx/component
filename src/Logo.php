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
        // Parse component props
        $this->props = wp_parse_args($props, array(
            'type'      => 'text',
            'show_text' => get_theme_mod('header_text', true),
            'image_url' => '',
            'url'       => site_url(),
            'wrap_tag'  => is_home() || is_front_page() ? 'h1' : 'h2',
        ));
    }

    public function get_logo_size() {

    }

    public function render()
    {
        if ($this->props['type'] === 'image') {
            $logo_height = get_theme_mod('logo_height') ? get_theme_mod('logo_height') : 60;
            $logo_stat = get_option('jankx_logo_image_stat', array());

            if ($logo_height != array_get($logo_stat, 'height')) {
                $logo_image_id = array_get($this->props, 'logo_image_id');
                if ($logo_image_id > 0) {
                    $metadata = wp_get_attachment_metadata($logo_image_id);
                    if ($metadata) {
                        $real_sizes = $metadata['sizes'];
                    } else {
                        $image_file = get_attached_file($logo_image_id);
                        $image_sizes =  getimagesize($image_file);
                    }
                }
            }

            return jankx_template('components/logo/image', $this->props, 'logo_image', false);
        }
        return jankx_template('components/logo/text', $this->props, 'logo_text', false);
    }
}
