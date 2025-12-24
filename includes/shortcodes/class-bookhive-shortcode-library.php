<?php
if (!defined('ABSPATH')) exit;

class Bookhive_Shortcode_Library {

    public static function register() {
        add_shortcode('bookhive_library', [__CLASS__, 'render']);
    }

    public static function render($atts = []) {
        if (!is_user_logged_in()) {
            return '<div class="bookhive-notice">Please log in to view your library.</div>';
        }

        $user_id = get_current_user_id();

        // Filters from query string
        $tab  = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'all';
        $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'recent';

        ob_start();
        include BOOKHIVE_PATH . 'templates/library.php';
        return ob_get_clean();
    }
}

