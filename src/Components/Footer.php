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
            'copyright' => sprintf(
                __('Copyright © %1$s <a href="%2$s">%3$s</a>.', 'jankx'),
                date('Y'),
                site_url(),
                get_bloginfo('name')
            ),
        ));
    }

    public function buildComponentData()
    {
        $enableCredit  = apply_filters('jankx_template_enable_footer_credit', true);
        $creditMessage = sprintf(
            __('Build with <a href="%s" title="Jankx Framework">Jankx</a> and <a href="%s" title="WordPress">WordPress</a>.', 'jankx'),
            'https://jankx.puleeno.com',
            'https://wordpress.org'
        );

        return array(
            'copyright' => array_get($this->props, 'copyright'),
            'enable_credit' => $enableCredit,
            'credit_message' => $creditMessage,
        );
    }

    public function render()
    {
        if ($this->props['copyright']) {
            $jankxLovers  = apply_filters('jankx_template_enable_footer_credit', true);
            $loverMessage = sprintf(
                __('Build with <a href="%s" title="Jankx Framework">Jankx</a> and <a href="%s" title="WordPress">WordPress</a>.', 'jankx'),
                'https://jankx.puleeno.com',
                'https://wordpress.org'
            );

            return jankx_template(
                'partials/footer/copyright',
                $this->buildComponentData(),
                false
            );
        }
    }
}
