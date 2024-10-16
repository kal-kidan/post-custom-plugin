<?php

/**
 * @package Custom Plugin test
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Access the global $wpdb object
global $wpdb;

// Define the custom post type and taxonomy
$post_type = 'custom_plugin';
$taxonomy = 'custom_plugin_taxonomy';

// Delete all custom posts
$posts = get_posts([
    'post_type' => $post_type,
    'numberposts' => -1, // Get all posts
]);

if (!empty($posts)) {
    foreach ($posts as $post) {
        // Delete each post
        wp_delete_post($post->ID, true);
    }
}

// Optionally, you can delete any custom taxonomy terms if required
$terms = get_terms([
    'taxonomy' => $taxonomy,
    'hide_empty' => false, // Get all terms, even if they are not assigned to any posts
]);

if (!empty($terms) && !is_wp_error($terms)) {
    foreach ($terms as $term) {
        // Delete each term
        wp_delete_term($term->term_id, $taxonomy);
    }
}

// Clear any cached data related to your plugin
wp_cache_flush();
