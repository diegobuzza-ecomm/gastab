<?php

// On theme init
function mati_post_type_init(){

    // Products
    $products_args = array(
        'labels' => array(
            'menu_name'          => __('Productos'),
            'name'               => __('Productos'),
            'singular_name'      => __('Producto'),
            'add_new'            => __('Añadir nuevo'),
            'add_new_item'       => __('Añadir nuevo producto'),
            'edit_item'          => __('Editar producto'),
            'new_item'           => __('Nuevo producto'),
            'view_item'          => __('Ver producto'),
            'view_items'         => __('Ver productos'),
            'search_items'       => __('Buscar productos'),
            'not_found'          => __('No se encontraron productos'),
            'not_found_in_trash' => __('No hay productos en la papelera'),
            'all_items'          => __('Todos los productos'),
        ),
        'public' => true,
        'has_archive' => true,
        'query_var' => true,
        'show_ui' => true,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-layout',
        'capability_type' => 'post', 
        'rewrite' => array('with_front' => false, 'slug' => 'productos'),
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
    );

    register_post_type('products', $products_args);

    // Products Categories
    $products_cat = array(
        'label' => __('Categorias'),
        'hierarchical' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_ui' => true,
        'rewrite' => array(
            'slug' => 'producto',
            'with_front' => false,
            'hierarchical' => true,
        ),
    );

    register_taxonomy('products_cat', array('products'), $products_cat);


}

//add_action('init', 'mati_post_type_init');

function mati_flush_rewrite_rules() {
    mati_post_type_init();
    flush_rewrite_rules();
}

//add_action('after_switch_theme', 'mati_flush_rewrite_rules');
