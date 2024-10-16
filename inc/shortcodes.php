<?php
class Shortcodes
{
    public function __construct()
    {
        add_shortcode('custom_plugin_shortcode', [$this, 'customPluginShortcode']);
        add_action('wp_ajax_load_more_posts', [$this, 'customPluginLoadMore']);
        add_action('wp_ajax_nopriv_load_more_posts', [$this, 'customPluginLoadMore']);
        add_action('wp_ajax_get_post_content', [$this, 'getPostContent']);
        add_action('wp_ajax_nopriv_get_post_content', [$this, 'getPostContent']);
    }

    public function customPluginShortcode($atts)
    {
        $atts = shortcode_atts([
            'limit' => 5,
            'show_featured_image' => 'true',
            'pagination' => 'false',
        ], $atts);

        $perpage = $atts['limit'];
        $show_featured_image = $atts['show_featured_image'];

        $args = [
            'post_type' => 'custom_plugin',
            'posts_per_page' => $atts['limit'],
        ];
        $query = new WP_Query($args);

        ob_start();
        if ($query->have_posts()): ?>
            <div class="cp_container" id="cp_container">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="cp_item">
                        <?php if ($atts['show_featured_image'] == 'true') {
                            the_post_thumbnail('thumbnail', ['class' => 'post-thumbnail', 'data-postid' => get_the_ID(),'data-perpage' => $perpage]);
                        } ?>
                        <h2 class="post-title" data-postid="<?php echo get_the_ID(); ?>" data-perpage = <?php echo $perpage;?>><?php the_title(); ?></h2>
                    </div>
                <?php endwhile; ?>
            </div>

            <div id="postModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="modal-body"></div>
                </div>
            </div>

            <?php if ($atts['pagination'] === 'true'): ?>
                <button id="load-more" data-perpage="<?php echo esc_attr($perpage); ?>" data-show_featured_image="<?php echo esc_attr($show_featured_image); ?>">Load More</button>
            <?php endif;
            else: ?>
            <p>No Posts found</p>
            <?php 

        endif;
        wp_reset_postdata();
        return ob_get_clean();
    }

    public function customPluginLoadMore()
    {
        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 5;
        $show_featured_image = isset($_POST['showFeaturedImage']) ? sanitize_text_field($_POST['showFeaturedImage']) : 'true';

        $args = [
            'post_type' => 'custom_plugin',
            'posts_per_page' => $perpage,
            'paged' => $paged,
        ];
        $query = new WP_Query($args);

        if ($query->have_posts()): ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="cp_item">
                    <?php if ($show_featured_image == 'true') {
                        the_post_thumbnail('thumbnail', ['class' => 'post-thumbnail', 'data-postid' => get_the_ID() , 'data-perpage' => $perpage]);
                    } ?>
                    <h2 class="post-title" data-postid="<?php echo get_the_ID(); ?>" data-perpage="<?php $perpage;?>"><?php the_title(); ?></h2>
                </div>
            <?php endwhile; ?>
            <?php endif;
        wp_reset_postdata();
        wp_die();
    }

    public function getPostContent()
    {
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 5;

        if ($post_id) {
            $terms = wp_get_post_terms($post_id, 'custom_plugin_taxonomy', ['fields' => 'ids']);

            $args = [
                'post_type' => 'custom_plugin',
                'posts_per_page' => $perpage,
                'post__not_in' => [$post_id],
                'tax_query' => [
                    [
                        'taxonomy' => 'custom_plugin_taxonomy',
                        'field' => 'term_id',
                        'terms' => $terms,
                    ],
                ],
            ];

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $meta_text = get_post_meta(get_the_ID(), 'meta-text', true);
                    $meta_image = get_post_meta(get_the_ID(), 'meta-image', true);
                    $title = get_the_title();
                    $content = wp_trim_words(get_the_content(), 15, '...'); ?>

                    <div class="related-post-item">
                        <?php if ($meta_image): ?>
                            <img src="<?php echo esc_url($meta_image); ?>" alt="<?php echo esc_html($meta_text); ?>" class="thumbnail" />
                        <?php else: ?>
                            <?php echo get_the_post_thumbnail(null, 'thumbnail'); ?>
                        <?php endif; ?>
                        <h3><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h3>
                        <h4>Custom Field Text: <?php echo $meta_text; ?></h4>
                        <p><?php echo $content; ?></p>
                    </div>
<?php
                }
            } else {
                echo '<p>No related posts found.</p>';
            }

            wp_reset_postdata();
        }

        wp_die();
    }
}
