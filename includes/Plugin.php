<?php
namespace WonderPano;

final class Plugin {
    private $instances = [];
    public static function run() {
        static $instance = false;
        $instance = $instance ? $instance : new Plugin();
    }
    private function __construct() {
        add_action('plugins_loaded', [$this, 'localization']);
        add_action('after_setup_theme', [$this, 'init']);
    }
    public function localization() {
        load_plugin_textdomain('wonderpano', false, dirname(WONDERPANO_PLUGIN_BASE_NAME) . '/languages/');
    }
    public function init() {
        if(!is_admin()) {
            $this->instances['frontend'] = new Frontend();
        }
    }
}