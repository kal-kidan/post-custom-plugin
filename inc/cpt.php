<?php
class CPT
{
    public function __construct()
    {
        add_action('init', [$this, 'registerCustomPostType']);
    }

    /**
     * Registers the custom post type and taxonomy.
     */
    public function registerCustomPostType()
    {
        // Register Custom Post Type
        register_post_type('custom_plugin', [
            'labels' => $this->getCustomPostTypeLabels(),
            'public' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
            'has_archive' => true,
            'rewrite' => ['slug' => 'custom-plugins'],
        ]);

        // Register Custom Taxonomy
        register_taxonomy(
            'custom_plugin_taxonomy',
            'custom_plugin',
            $this->getCustomTaxonomyArgs()
        );
    }
    /**
     * Retrieves the labels for the custom post type.
     *
     * @return array Array of labels for the custom post type.
     */
    private function getCustomPostTypeLabels()
    {
        return [
            'name' => __('Custom Plugins', 'text-domain'),
            'singular_name' => __('Custom Plugin', 'text-domain'),
            'menu_name' => __('Custom Plugins', 'text-domain'),
            'name_admin_bar' => __('Custom Plugin', 'text-domain'),
            'add_new' => __('Add New', 'text-domain'),
            'add_new_item' => __('Add New Custom Plugin', 'text-domain'),
            'new_item' => __('New Custom Plugin', 'text-domain'),
            'edit_item' => __('Edit Custom Plugin', 'text-domain'),
            'view_item' => __('View Custom Plugin', 'text-domain'),
            'all_items' => __('All Custom Plugins', 'text-domain'),
            'search_items' => __('Search Custom Plugins', 'text-domain'),
            'not_found' => __('No Custom Plugins found.', 'text-domain'),
            'not_found_in_trash' => __('No Custom Plugins found in Trash.', 'text-domain'),
        ];
    }

    /**
     * Retrieves the arguments for the custom taxonomy.
     *
     * @return array Array of arguments for the custom taxonomy.
     */
    private function getCustomTaxonomyArgs()
    {
        return [
            'label' => __('Categories', 'text-domain'),
            'rewrite' => ['slug' => 'custom-plugin-category'],
            'hierarchical' => true,
        ];
    }
}
