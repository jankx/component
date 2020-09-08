<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Footer extends Component
{
    public static function getName()
    {
        return 'footer';
    }

    public function render()
    {
        do_action( 'jankx_template_footer_widgets' );

        $jankxLovers = apply_filters('jankx_template_enable_footer_credit', true);
        if ($jankxLovers) {
            // Find the friendly message before add it to here
        }
    }
}
