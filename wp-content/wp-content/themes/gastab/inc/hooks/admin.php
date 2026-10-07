<?php

// Hide Admin Bar
show_admin_bar(false);

// Add Admin Styles
function mati_admin_scripts(){
	wp_enqueue_style('mati-admin-css', get_template_directory_uri() . '/assets/css/admin.css?v='. uniqid());
	wp_enqueue_script('mati-admin-js', get_template_directory_uri() . '/assets/js/admin.js?v='. uniqid());
}

add_action('admin_enqueue_scripts', 'mati_admin_scripts');


// Remove dashboard
function mati_remove_dashboard_meta() {
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); //Removes the 'health' widget
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); //Removes the 'incoming links' widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); //Removes the 'plugins' widget
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); //Removes the secondary widget
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //Removes the 'Quick Draft' widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); //Removes the 'Recent Drafts' widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); //Removes the 'Activity' widget
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //Removes the 'Activity' widget (since 3.8)
}
add_action('admin_init', 'mati_remove_dashboard_meta');


// Custom Menus
function mati_custom_admin_menu(){
    global $menu;

    foreach ( $menu as $key => $value ) {
        if ( 'edit.php' == $value[2] ) {
            $menu[$key][6] = 'dashicons-media-document';
            break;
        }
    }

    // Remove
    remove_menu_page('upload.php');

    // Add new menus
    add_menu_page(__('Menu'), __('Menu'), 'edit_theme_options', 'nav-menus.php', '', 'dashicons-menu', 30);
    add_menu_page(__('Media'), __('Media'), 'upload_files', 'upload.php', '', 'dashicons-admin-media', 35);

}
add_action('admin_menu', 'mati_custom_admin_menu', 100);