<?php
namespace Jankx\Component;

use Jankx\Component\Abstracts\Component;

class Modal extends Component
{
    public static function getName()
    {
        return 'modal';
    }

    protected function parseProps($props)
    {
        $this->props = wp_parse_args($props, array(
            'id' => '',
            'click_on' => '',
            'title' => '',
            'content' => '',
        ));

        if ($this->props['id']) {
            add_action('wp_footer', array($this, 'renderModal'));
        }
    }

    public function render()
    {
        // Modal must have ID to create trigger on click event
        if (empty($this->props['id'])) {
            return;
        }
        $output  = sprintf(
            '<div id="jankx-modal-trigger-%s" class="jankx-trigger trigger-modal">',
            $this->props['id']
        );
        $output .= (string) $this->props['click_on'];
        $output .= '</div>';

        return $output;
    }

    public function renderModal()
    {
        $dialogAttributes = array(
            'role' => "dialog",
            'aria-modal' => "true",
        );
        if ($this->props['title']) {
            $dialogAttributes['aria-labelledby'] = sprintf('modal-%s-title', $this->props['id']);
        }
        ?>
        <div
            id="jankx-modal-<?php echo $this->props['id']; ?>"
            class="jankx-modal modal-<?php echo $this->props['id']; ?>"
            aria-hidden="true"
        >
            <div tabindex="-1" data-micromodal-close>
                <div <?php echo jankx_generate_html_attributes($dialogAttributes); ?> >
                    <header>
                        <?php if ($this->props['title']) : ?>
                        <h2 id="modal-<?php echo $this->props['id']; ?>-title">
                            <?php echo $this->props['title']; ?>
                        </h2>
                        <?php endif; ?>
                        <button aria-label="<?php _e('Close'); ?>" data-micromodal-close></button>
                    </header>
                    <div id="modal-<?php echo $this->props['id']; ?>-content">
                        <?php echo $this->props['content']; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
