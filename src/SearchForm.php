<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class SearchForm extends Component
{
    public static function getName()
    {
        return 'search_form';
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'id' => null,
            'method' => 'GET',
            'live_search' => false,
            'live_search_url' => '',
            'placeholder' => '',
            'submit_text' => __('Submit', 'jankx'),
        ));
    }

    public function render()
    {
        $formAttributes = array(
            'method' => strtoupper($this->props['method']),
            'class' => 'jankx-search-form'
        );

        if ($this->props['id']) {
            $formAttributes['id'] = "jankx-form-{$this->props['id']}";
        }

        return jankx_template(
            'components/search_form',
            array(
                'form_attributes' => jankx_generate_html_attributes($formAttributes),
                'placeholder' => $this->props['placeholder'],
                'submit_text' => $this->props['submit_text'],
            ),
            'seach_form',
            false // Do not echo the template
        );
    }
}
