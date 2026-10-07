<?php

// Remove detailed errors in login
function no_wordpress_errors(){
    return 'Something is wrong!';
}
add_filter( 'login_errors', 'no_wordpress_errors' );


// Hide WP version
function no_wordpress_version() {
    return '';
}
add_filter('the_generator', 'no_wordpress_version');
remove_action('wp_head', 'wp_generator');


// Remove WP version from scripts and styles
function remove_wp_version_strings($src){
    global $wp_version;
    $query_string = parse_url($src, PHP_URL_QUERY);

    if ($query_string) {
        parse_str($query_string, $query);

        if (isset($query['ver']) && $query['ver'] === $wp_version) {
            $src = remove_query_arg('ver', $src);
        }
    }

    return $src;
}
add_filter('script_loader_src', 'remove_wp_version_strings', 15, 1);
add_filter('style_loader_src', 'remove_wp_version_strings', 15, 1);

// Remove old connection
add_filter('xmlrpc_enabled', '__return_false');

// Add security headers
function add_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    header('Referrer-Policy: no-referrer-when-downgrade');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}
add_action('send_headers', 'add_security_headers');