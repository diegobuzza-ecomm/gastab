<?php global $lang;

function get_global_lang(){
	$lang = 'en';

    if (function_exists('pll_current_language')){
        $lang = pll_current_language('slug');
    } else {
        $locale = get_locale();

        if (!empty($locale)) {
            $locale = substr($locale, 0, 2);
            $lang = $locale;
        }
    }

    return $lang;
}

$lang = get_global_lang();


// Register strings
function register_polylang_strings(){

    if (function_exists('pll_register_string')){
        //pll_register_string( 'services', 'Servicios', 'site name', false);
    }
}

//add_action('after_setup_theme', 'register_polylang_strings');