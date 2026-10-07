<?php

// Remove gutenberg on Pages and CPT
function mati_disable_gutenberg_on_pages( $current_status, $post_type ) {
    if ( 'post' !== $post_type ) return false;
    return $current_status;
}

add_filter( 'use_block_editor_for_post_type', 'mati_disable_gutenberg_on_pages', 10, 2 );


// Excerpt
function mati_custom_excerpt_more($more){
    return '...';
}
add_filter('excerpt_more', 'mati_custom_excerpt_more');


function mati_custom_excerpt_length($length){
    return 20;
}
add_filter('excerpt_length', 'mati_custom_excerpt_length', 999);


function gutenberg_supports() {
    remove_theme_support('core-block-patterns');
    remove_theme_support('editor-color-palette');
    remove_theme_support('editor-gradient-presets');
    //remove_theme_support('editor-font-sizes');
}
add_action('after_setup_theme', 'gutenberg_supports');


function gutenberg_block_types_allowed($allowed_blocks, $post){
    $allowed_blocks = array(
       // Text
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/quote',
        'core/code',
        'core/details',
        'core/preformatted',
        'core/pullquote',
        'core/table',
        'core/audio',
        'core/freeform', // Classic block
        //'core/footnotes',
        //'core/separator',
        //'core/button',

        // Media
        'core/image',
        'core/gallery',
        'core/audio',
        'core/cover',
        'core/cover-image',
        'core/media-text',
        'core/video',
//      'core/file',
        
        // Design
        'core/buttons',
        'core/columns',
//      'core/group',
//      'core/row',
//      'core/stack',
//      'core/more', // Read more
//      'core/nextpage', // Page break
//      'core/separator', // <hr>
//      'core/spacer', // line with height

        // Widgets
        'core/html', // Custom HTML
        //'core/social-links', // Social icons
        'core/shortcode',

        // Embed
        'core/embed',
        'core/embed/youtube',
        'core/embed/twitter',
        'core/embed/spotify',
        'core/embed/vimeo',
        'core/embed/dailymotion',
        'core/embed/tiktok',
        'core/embed/pinterest',

        // Custom blocks
        'acf/block-text-image',
        'acf/block-text-video',
        'acf/block-text-gallery',
    );

    return $allowed_blocks;

}
add_filter( 'allowed_block_types_all', 'gutenberg_block_types_allowed', 10, 2 );

/**/
function gutenberg_remove_openverse($settings){
    $settings['enableOpenverseMediaCategory'] = false;
    return $settings;    
}
add_filter('block_editor_settings_all', 'gutenberg_remove_openverse', 10);


/* Supported block colors */
function blocks_supported_colors() {
    $options = get_option('mati_theme_options');

    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => esc_attr__( 'Primary' ),
            'slug'  => 'primary',
            'color' => '#fc3f50',
        ),
        array(
            'name'  => esc_attr__( 'Secondary' ),
            'slug'  => 'secondary',
            'color' => '#f58426',
        ),
        array(
            'name'  => esc_attr__( 'Dark' ),
            'slug'  => 'dark',
            'color' => '#151515',
        ),
        array(
            'name'  => esc_attr__( 'Black' ),
            'slug'  => 'dark',
            'color' => '#000000',
        ),
        array(
            'name'  => esc_attr__( 'White' ),
            'slug'  => 'white',
            'color' => '#ffffff',
        ),
    ) );
}
add_action( 'after_setup_theme', 'blocks_supported_colors', 11);