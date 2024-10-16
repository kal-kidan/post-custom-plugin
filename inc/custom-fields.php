<?php
class Custom_Fields
{
    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'addCustomMetaBox']);
        add_action('save_post', [$this, 'saveCustomMeta']);
    }
    
  
    public function addCustomMetaBox()
    {
        add_meta_box(
            'custom_fields',                     // Unique ID for the meta box
            'Custom Fields',                     // Title of the meta box
            [$this, 'renderCustomFieldsCallback'], // Callback function to render the meta box
            'custom_plugin',                     // Post type where the meta box appears
            'normal',                            // Context (normal, side, advanced)
            'high'                               // Priority (high, core, default, low)
        );
    }

    /**
     * Renders the content of the custom meta box.
     *
     * @param WP_Post $post The current post object.
     */
    public function renderCustomFieldsCallback($post)
    {
        // Nonce field for security
        wp_nonce_field(basename(__FILE__), 'custom_nonce');

        // Retrieve stored meta data
        $storedMetaText = get_post_meta($post->ID, 'meta-text', true);
        $storedMetaImage = get_post_meta($post->ID, 'meta-image', true);

        // Text field
        echo '<label for="meta-text">Enter Text: </label>';
        echo '<input type="text" name="meta-text" value="' . esc_attr($storedMetaText) . '" id="meta-text">';
        echo "<br /><br />";

        // Hidden input for image URL
        echo '<input type="text" name="meta-image" id="meta-image" hidden value="' . esc_attr($storedMetaImage) . '" />';
        echo "<br />";

        // Button to upload image
        echo '<input type="button" id="meta-image-button" class="button" value="Upload Image" />';
        echo '<div><img id="meta-image-preview" src="' . esc_url($storedMetaImage) . '" style="max-width: 100px; height: auto;" /></div>';
    }

    /**
     * Saves the custom meta data when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function saveCustomMeta($post_id)
    {
        // Check nonce for security
        if (!isset($_POST['custom_nonce']) || !wp_verify_nonce($_POST['custom_nonce'], basename(__FILE__))) {
            return;
        }

        // Check for autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Sanitize and save the meta data
        if (isset($_POST['meta-text'])) {
            update_post_meta($post_id, 'meta-text', sanitize_text_field($_POST['meta-text']));
        }
        if (isset($_POST['meta-image'])) {
            update_post_meta($post_id, 'meta-image', esc_url_raw($_POST['meta-image']));
        }
    }
}
