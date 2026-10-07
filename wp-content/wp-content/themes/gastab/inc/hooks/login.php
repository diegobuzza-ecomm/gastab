<?php

// Login
function mati_add_login_logo_url_title(){ return get_bloginfo('name'); }
add_filter('login_headertext', 'mati_add_login_logo_url_title');

function mati_add_login_logo_url(){ return get_bloginfo('url'); }
add_filter('login_headerurl', 'mati_add_login_logo_url');  

function mati_add_login_css(){
	$options = get_option('mati_theme_options');
	if (!empty($options['primary_color'])){
		echo '<style type="text/css">:root{--color-primary:'.$options['primary_color'].';--bg-primary:'.$options['primary_color'].';}</style>';
	}

	echo '<link href="'. get_bloginfo('template_url') .'/assets/css/login.css?v='. uniqid() .'" rel="stylesheet">';
}
add_action('login_head', 'mati_add_login_css');


// Custom login label
function mati_login_label($translated_text, $text, $domain) {
    if ('Username or Email Address' === $text) {
        $translated_text = 'Email';
    }
    return $translated_text;
}
add_filter('gettext', 'mati_login_label', 20, 3);


// Redirection
function mati_login_redirect($redirect_to, $request, $user) {
	if (isset($user->roles) && is_array($user->roles)) {
		if(in_array('administrator', $user->roles)) {
			return admin_url();
		} else {
			return site_url();
		}
	} else {
		return site_url();
	}
}

add_filter('login_redirect', 'mati_login_redirect', 10, 3);