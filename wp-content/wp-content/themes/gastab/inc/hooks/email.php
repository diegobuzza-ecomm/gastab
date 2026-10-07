<?php

// Email via HTML
function mati_set_html_emails(){
    return "text/html";
}
add_filter('wp_mail_content_type','mati_set_html_emails');


// Email name
function mati_email_from_name($original){
	return get_bloginfo('name');
}
add_filter( 'wp_mail_from_name', 'mati_email_from_name');


// Email from
function mati_email_from_address($original_email_address) {
    $domain = wp_parse_url(get_bloginfo('url'), PHP_URL_HOST);
    $domain = str_replace('www.', '', $domain);

    return 'noreply@' . $domain;
}
add_filter('wp_mail_from', 'mati_email_from_address');