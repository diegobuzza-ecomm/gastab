<?php

// Add favicon
function mati_enqueue_favicon(){
	$options = get_option('mati_theme_options');
	$primary_color = isset($options['primary_color']) ? esc_attr($options['primary_color']) : '';

	$site_icon = get_option('site_icon');

	if (!empty($primary_color)){
		echo '<meta name="msapplication-TileImage" content="' . $theme_uri . '/assets/favicon/favicon-192x192.png' . '">' . PHP_EOL;
		echo '<meta name="msapplication-TileColor" content="' . $primary_color . '">' . PHP_EOL;
		echo '<meta name="theme-color" content="' . $primary_color . '">' . PHP_EOL;
	}

	if (!empty($site_icon)) return;

	$theme_uri = get_template_directory_uri();

	$favicons = [
		['rel' => 'icon', 'type' => 'image/png', 'sizes' => '16x16', 'href' => $theme_uri . '/assets/favicon/favicon-16x16.png'],
		['rel' => 'icon', 'type' => 'image/png', 'sizes' => '32x32', 'href' => $theme_uri . '/assets/favicon/favicon-32x32.png'],
		['rel' => 'apple-touch-icon', 'href' => $theme_uri . '/assets/favicon/apple-touch-icon.png'],
		['rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => $theme_uri . '/assets/favicon/favicon.ico'],
	];

	foreach ($favicons as $icon) {
		printf(
			'<link rel="%s" %s %s href="%s">',
			esc_attr($icon['rel']),
			isset($icon['type']) ? 'type="' . esc_attr($icon['type']) . '"' : '',
			isset($icon['sizes']) ? 'sizes="' . esc_attr($icon['sizes']) . '"' : '',
			esc_url($icon['href'])
		);
	}
}

add_action('wp_head', 'mati_enqueue_favicon', 10);


// Enqueue assets
function mati_enqueue_assets(){
	if (is_admin()) return;

	global $lang;

	$options = get_option('mati_theme_options');
	$theme_uri = get_template_directory_uri();


	// Enqueue jquery
	wp_deregister_script('jquery');
    wp_enqueue_script('jquery', $theme_uri.'/assets/js/libs/jquery.min.js', [], '3.7.1', false);

	// Thirds > Captcha
	$google_captcha_enabled = $options['google_captcha_api_enabled'] ?? false;
	$google_captcha_api_key = $options['google_captcha_api_key_public'] ?? '';
	$google_captcha_api_version = $options['google_captcha_api_version'] ?? 3;

	if ($google_captcha_enabled){
		$captcha_url = 'https://www.google.com/recaptcha/api.js?hl='. esc_attr($lang);

		if ($google_captcha_api_version !== 2){
			$captcha_url .= '&render='. $google_captcha_api_key;
		}

		wp_enqueue_script('google-recaptcha', $captcha_url, [], null, true);
		wp_script_add_data('google-recaptcha', 'async', true);
	}

	// Thirds > Maps
	$google_maps_enabled = $options['google_maps_api_enabled'] ?? false;
	$google_maps_api_key = $options['google_maps_api_key'] ?? '';

	if ($google_maps_enabled){
		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key='. $google_maps_api_key .'&libraries=marker&loading=async&language='. esc_attr($lang), [], null, true);
		wp_script_add_data('google-maps', 'async', true);
	}

	// Fonts
	$fonts = [
		//'Poppins:wght@100;200;300;400;500;600;700',
		//'Roboto:wght@100;300;400;500;700',
	];

	if (!empty($fonts)) {
		$fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts) . '&display=swap';
		wp_enqueue_style('google-fonts', esc_url($fonts_url), [], null);
	}

	// Enqueue libs scripts
	wp_enqueue_script('bootstrap', $theme_uri .'/assets/js/libs/bootstrap.min.js', array('jquery'), false, true);
	wp_enqueue_script('swiper', $theme_uri .'/assets/js/libs/swiper-bundle.min.js', array('jquery'), false, true);
	wp_enqueue_script('wow', $theme_uri .'/assets/js/libs/wow.min.js', array('jquery'), false, true);

	// For advanced animations (hide wow & animate.css)
	/*wp_enqueue_script('gsap', $theme_uri .'/assets/js/libs/gsap.min.js', array(), false, true);
	wp_enqueue_script('gsap-st', $theme_uri .'/assets/js/libs/scrollTrigger.min.js', array('gsap'), false, true);
	wp_enqueue_script('gsap-tp', $theme_uri .'/assets/js/libs/TextPlugin.min.js', array('gsap'), false, true);
	wp_enqueue_script('lenis', $theme_uri .'/assets/js/libs/lenis.min.js', array('jquery'), false, true);
	wp_enqueue_script('mati-animations', $theme_uri .'/assets/js/animations.js', array('jquery'), uniqid(), true);*/

	wp_enqueue_script('fancybox', $theme_uri .'/assets/js/libs/fancybox.umd.js', array(), null, true );
	wp_enqueue_script('mati-scripts', $theme_uri .'/assets/js/scripts.js', array('jquery'), uniqid(), true);
	wp_script_add_data('mati-scripts', 'defer', true);


	// Inline scripts
	wp_add_inline_script('mati-scripts', 'var mati_vars = ' . wp_json_encode([
	    'lang' => esc_js($lang),
	    'nonce' => wp_create_nonce('nonce'),
	    'ajax_url' => esc_js(admin_url('admin-ajax.php')),
	    'is_mobile' => wp_is_mobile() ? 'true' : 'false',
	    'is_logged_in' => is_user_logged_in() ? 'true' : 'false',
	    'site_url' => esc_js(get_bloginfo('url')),
	    'post_id' => is_singular() ? get_the_ID() : null,
	    'actual_url' => esc_js(get_permalink()),
	]), 'before');

	// Dequeue styles
	if (!is_single()){
		wp_dequeue_style('global-styles');
		wp_dequeue_style('classic-theme-styles');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wc-block-style');
	}

	// Enqueue libs styles
	wp_enqueue_style('fontawesome', $theme_uri .'/assets/css/libs/font-awesome.min.css', array(), false);
	wp_enqueue_style('bootstrap', $theme_uri .'/assets/css/libs/bootstrap.min.css', array(), false);
	wp_enqueue_style('swiper', $theme_uri .'/assets/css/libs/swiper-bundle.min.css', array(), false);
	wp_enqueue_style('fancybox', $theme_uri .'/assets/css/libs/fancybox.css', array(), null );
	wp_enqueue_style('animate', $theme_uri .'/assets/css/libs/animate.css', array(), false);

	// Enqueue custom styles
	wp_enqueue_style('mati-fonts', $theme_uri .'/assets/css/fonts.css', array(), null);
	wp_enqueue_style('mati-style', $theme_uri .'/style.css', array(), uniqid());
}

add_action('wp_enqueue_scripts', 'mati_enqueue_assets');


// Customize assets
function mati_customize_assets(){

	$options = get_option('mati_theme_options');

		// Remove emojis
	if (!$options['enable_emojis']){
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('admin_print_styles', 'print_emoji_styles');

		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	}

	if (!is_admin()){
		remove_action('wp_head', 'rsd_link'); // Remove Really Simple Discovery link
		remove_action('wp_head', 'wp_shortlink_wp_head'); // Remove Shortlink
		remove_action('wp_head', 'rest_output_link_wp_head'); // Remove oEmbed discovery links
		remove_action('wp_head', 'wp_oembed_add_discovery_links'); // Remove oEmbed discovery links
		remove_action('wp_head', 'wp_oembed_add_host_js'); // Remove oEmbed-specific JavaScript
		remove_action('wp_head', 'wp_generator'); // Remove WordPress generator version
		remove_action('wp_head', 'wlwmanifest_link'); // Remove wlwmanifest link
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	}
}
add_action('init', 'mati_customize_assets');


// Add preconnect for Google Fonts
function mati_resource_hints($urls, $relation_type) {
	if ('preconnect' === $relation_type) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin' => '',
		);
	}
	return $urls;
}
add_filter('wp_resource_hints', 'mati_resource_hints', 10, 2);


