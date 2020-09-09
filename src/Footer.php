<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Footer extends Component
{
    public static function getName()
    {
        return 'footer';
    }

    protected function parseProps($props) {
        $this->props = wp_parse_args( $props, array(
            'copyright' => sprintf(__('Copyright &copy; %d %s.', date('Y'), get_bloginfo('name'))),
        ));
    }

    public function render()
    {
        /**
         * Footer widgets area action hook
         * Hooked:
         * 10: FooterBuilder::render
         */
        do_action( 'jankx_template_footer_widgets' );

        if ($this->props['copyright']) {
            $jankxLovers  = apply_filters('jankx_template_enable_footer_credit', true);
            $loverMessage = __('Build with Jankx and WordPress.', 'jankx');

            return jankx_template('footer/copyright', array(
                'copyright' => array_get($this->props, 'copyright'),
                'jankx_credit' => $loverMessage,
            ), 'copyright', false);
        }
    }
}
