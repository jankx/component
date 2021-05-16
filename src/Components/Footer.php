<?php
namespace Jankx\Component\Components;

use Jankx\Component\Abstracts\Component;

class Footer extends Component
{
    const COMPONENT_NAME = 'footer';

    public function getName()
    {
        return static::COMPONENT_NAME;
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'copyright' => sprintf(__('Copyright &copy; %d %s.', 'jankx'), date('Y'), get_bloginfo('name')),
        ));
    }

    public function render()
    {
        /**
         * Footer widgets area action hook
         * Hooked:
         * 10: FooterBuilder::render
         */
        do_action('jankx_template_footer_widgets');

        if ($this->props['copyright']) {
            $jankxLovers  = apply_filters('jankx_template_enable_footer_credit', true);
            $loverMessage = sprintf(
                __('Build with <a href="%s" title="Jankx Framework">Jankx</a> and <a href="%s" title="WordPress">WordPress</a>.', 'jankx'),
                'https://jankx.puleeno.com',
                'https://wordpress.org'
            );

            return jankx_template('partials/footer/copyright', array(
                'copyright' => array_get($this->props, 'copyright'),
                'jankx_credit' => $loverMessage,
            ), 'copyright', false);
        }
    }
}
