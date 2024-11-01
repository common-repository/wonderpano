<?php
namespace WonderPano;

class Frontend {
    public function __construct() {
        add_shortcode(WONDERPANO_SHORTCODE_NAME, [$this, 'shortcode']);
    }
    private function get_globals() {
        $globals = [
            'version' => WONDERPANO_PLUGIN_VERSION
        ];
        return $globals;
    }
    private function init_loader() {
        wp_enqueue_style('wonderpano-pannellum', WONDERPANO_PLUGIN_URL . 'assets/pannellum/css/pannellum.css', [], WONDERPANO_PLUGIN_VERSION);
        wp_enqueue_script('wonderpano-libpannellum', WONDERPANO_PLUGIN_URL . 'assets/pannellum/js/libpannellum.js', [], WONDERPANO_PLUGIN_VERSION, false);
        wp_enqueue_script('wonderpano-pannellum', WONDERPANO_PLUGIN_URL . 'assets/pannellum/js/pannellum.js', [], WONDERPANO_PLUGIN_VERSION, false);

        wp_enqueue_style('wonderpano-main', WONDERPANO_PLUGIN_URL . 'assets/css/main.css', [], WONDERPANO_PLUGIN_VERSION);
        wp_enqueue_script('wonderpano-loader', WONDERPANO_PLUGIN_URL . 'assets/js/loader.js', ['jquery'], WONDERPANO_PLUGIN_VERSION, true);
        wp_localize_script('wonderpano-loader', 'wonderpano_globals', $this->get_globals());
    }
    public function shortcode($atts = []) {
        $atts = array_change_key_case($atts, CASE_LOWER);
        $defaults = [
            'image'  => null,
            'title'  => null,
            'class'  => null,
            'width'  => null,
            'height' => null
        ];
        $atts = shortcode_atts($defaults, $atts);

        if(empty($atts['image'])) {
            return;
        }

        $this->init_loader();

        $inlineStyles = '';
        $inlineStyles .= (!empty($atts['width']) ? 'width:' . $atts['width'] . ';' : '');
        $inlineStyles .= (!empty($atts['height']) ? 'height:' . $atts['height'] . ';' : '');

        $data = '';
        $data .= '<div class="wonderpano-panorama';
        $data .= (!empty($atts['class']) ? ' ' . esc_attr($atts['class']) : '') . '" ';
        $data .= 'data-image="' . esc_attr($atts['image']) . '" ';
        $data .= (!empty($atts['title']) ? 'data-title="' . esc_attr($atts['title']) . '" ' : '');
        $data .= (!empty($inlineStyles) ? 'style="' . esc_attr($inlineStyles) . '"' : '');
        $data .= '>';
        $data .= '</div>';

        return $data;
    }
}