<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class DataList extends Component
{
    const NAME = 'list';

    public static function getName() {
        return 'data_list';
    }

    protected function parseProps($props) {
        /**
         * @var $type       Type of dropdown support `drop` and `select`.
         * @var $options    Data list for type select
         * @var $template   Template file for type `drop`
         */
        $this->props = wp_parse_args($props, array(
            'type' => 'drop',
            'option' => array(),
            'template' => 'components/dropdown'
        ));
    }

    public function render() {
    }
}
