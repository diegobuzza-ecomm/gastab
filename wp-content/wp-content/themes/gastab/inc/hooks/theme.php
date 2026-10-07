<?php

// On theme init
function mati_theme_init(){
    global $lang;

    // Register menu
    register_nav_menus(array(
        'header' => 'Header',
        'footer' => 'Footer',
        'legal' => 'Legal',
    ));

}

add_action('init', 'mati_theme_init', 0);


// Add theme setup
function mati_theme_setup(){
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('menus');
}
add_action('after_setup_theme', 'mati_theme_setup');


// Disable scaled
add_filter( 'big_image_size_threshold', '__return_false');


function mati_seo_setup(){
    $home_id = get_page_id('home');

    if (is_front_page()){
        if (defined('WPSEO_VERSION') && function_exists('yoast_get_head')){
            $yoast_description = get_post_meta($home_id, '_yoast_wpseo_metadesc', true);

            if (!empty($yoast_description)){
                echo '<meta name="description" content="' . esc_attr($yoast_description) . '">';
                return;
            }
        }

        if (has_excerpt($home_id)){
            $description = get_the_excerpt($home_id);
            echo '<meta name="description" content="' . esc_attr($description) . '">';
        }
    }
}
add_action('wp_head', 'mati_seo_setup');

// Enable maintenance mode
function mati_enable_maintenance_mode() {
    $options = get_option('mati_theme_options');
    $is_maintenance_mode = isset($options['maintenance_mode_enabled']) ? $options['maintenance_mode_enabled'] : 0;

    if ($is_maintenance_mode && !current_user_can('administrator')) {
        $maintenance_page = locate_template('templates/pages/page-maintenance.php');
        get_header();
            load_template($maintenance_page);
        get_footer();
        exit;
    }
}
add_action('template_redirect', 'mati_enable_maintenance_mode');

// Add templates on /templates/pages/
function register_custom_page_templates($templates) {
    $templates_dir = get_template_directory() . '/templates/pages/';
    
    $files = glob($templates_dir . '*.php');

    if ($files) {
        foreach ($files as $file) {
            $file_name = basename($file);
            $file_data = file_get_contents($file, false, null, 0, 8192);

            if (preg_match('/Template Name:\s*(.*)$/mi', $file_data, $matches)) {
                $templates['templates/pages/' . $file_name] = $matches[1];
            }
        }
    }

    return $templates;
}

add_filter('theme_page_templates', 'register_custom_page_templates');

function load_custom_page_template($template) {
    global $post;

    if ($post && !empty(get_page_template_slug($post))) {
        $slug = get_page_template_slug($post);
        
        $template_dir = get_template_directory() . '/' . $slug;
        
        if (file_exists($template_dir)) {
            return $template_dir;
        }
    }

    return $template;
}
add_filter('template_include', 'load_custom_page_template');