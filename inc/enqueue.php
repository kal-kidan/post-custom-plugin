<?php
class Enqueue
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueFrontendScripts']);
    }

    /**
     * Enqueue admin scripts and styles.
     */
    public function enqueueAdminScripts()
    {
        // Enqueue media uploader
        wp_enqueue_media();

        // Enqueue the admin JavaScript file
        wp_enqueue_script('admin-script', CP_DIR_URL . 'assets/js/admin.js', ['jquery'], null, true);
    }

    /**
     * Enqueue frontend scripts and styles.
     */
    public function enqueueFrontendScripts()
    {
        // Enqueue the frontend stylesheet
        wp_enqueue_style('frontend-style', CP_DIR_URL . 'assets/css/style.css');

        // Enqueue the load-more script
        wp_enqueue_script('load-more-js', CP_DIR_URL . 'assets/js/load-more.js', ['jquery'], null, true);

        // Enqueue the modal script
        wp_enqueue_script('modal-js', CP_DIR_URL . 'assets/js/modal.js', ['jquery'], null, true);

        // Localize the load-more script with AJAX URL and current page
        wp_localize_script('load-more-js', 'loadmore_params', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'current_page' => 1,
        ]);
    }
}
