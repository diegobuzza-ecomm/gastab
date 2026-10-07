<?php

// Get pages by ID
function get_page_id($page = '', $lang = ''){

    if (empty($lang)) {
        $lang = get_global_lang();
    }

    if ($page == '') {
        $page = 'home';
    }

    $pageIds = [
        'home' => [
            'en' => 2,
            'es' => 2,
        ],
        'contact' => [
            'en' => 3,
            'es' => 3,
        ],
        'about' => [
            'en' => 8,
            'es' => 8,
        ],
        'fuel' => [
            'en' => 11,
            'es' => 11,
        ],
        'generator' => [
            'en' => 13,
            'es' => 13,
        ],
        'lubricants' => [
            'en' => 15,
            'es' => 15,
        ],
        'urea' => [
            'en' => 21,
            'es' => 21,
        ],
        'blog' => [
            'en' => 213,
            'es' => 213,
        ],
        'thanks' => [
            'en' => 24,
            'es' => 24,
        ],
    ];

    // Check if the page exists in the mapping and return the ID for the current language
    if (array_key_exists($page, $pageIds) && array_key_exists($lang, $pageIds[$page])){
        return $pageIds[$page][$lang];
    }

    return 1; // return always a number to avoid a bug in the index.php loop
}

function get_environment(){
    $site_url = get_site_url();
    
    if (strpos($site_url, 'stg.mati.agency') !== false || strpos($site_url, 'dev.mati.agency') !== false) {
        return 'dev';
    } else {
        return 'prod';
    }
}

// Count posts visits
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if($count == ''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }

    return $count.'';
}

// Get post date in format time ago
function get_time_ago($time = '', $post_id = false){
    global $lang;

    if ($post_id){
        $post = get_post($post_id);

        if ($post) {
            $time = $post->post_date;
        } else {
            return '-';
        }
    }

    if (empty($time)) {
        return '-';
    }

    $current_time = current_time( 'timestamp' );

    $time = strtotime( $time );
    $time_diff = $current_time - $time;

    $minutes_ago = floor( $time_diff / 60 );

    if ($minutes_ago <= 1) {
        return $lang == 'es' ? 'Ahora' : 'Just now';
    }

    return $lang == 'es' 
        ? 'hace ' . $minutes_ago . ' minutos'
        : $minutes_ago . ' minutes ago';
}

// Get estimate time to read
function get_estimate_time($post) {
    global $lang;

    $word_count = str_word_count(strip_tags($post->post_content));
    $minutes = max(1, floor($word_count / 200));

    $word_before = $lang == 'es' ? 'minuto' : 'minute';
    $word_after = $lang == 'es' ? 'de lectura' : 'to read';

    return $minutes . ' ' . $word_before . ($minutes == 1 ? '' : 's') . ' ' . $word_after;
}

// Countries
function get_countries($lang = ''){
    if ($lang == '') {
        $lang = get_global_lang();
    }

    $countries = array(
        'es' => array('Alemania', 'Argentina', 'Austria', 'Bahamas', 'Belice', 'Bolivia', 'Brasil', 'Bélgica', 'Canadá', 'Chile', 'China', 'Colombia', 'Corea del Sur', 'Costa Rica', 'Cuba', 'Dinamarca', 'Ecuador', 'Egipto', 'El Salvador', 'Eslovaquia', 'España', 'Estados Unidos', 'Finlandia', 'Francia', 'Ghana', 'Grecia', 'Guatemala', 'Guyana', 'Haití', 'Honduras', 'Hungría', 'India', 'Indonesia', 'Irlanda', 'Italia', 'Jamaica', 'Japón', 'Kenia', 'Marruecos', 'México', 'Nicaragua', 'Nigeria', 'Noruega', 'Panamá', 'Paraguay', 'Países Bajos', 'Perú', 'Polonia', 'Portugal', 'Reino Unido', 'República Checa', 'República Dominicana', 'Rumanía', 'Rusia', 'Sudáfrica', 'Suecia', 'Suiza', 'Surinam', 'Tailandia', 'Ucrania', 'Uruguay', 'Venezuela', 'Vietnam'),
        'en' => array('Argentina', 'Austria', 'Bahamas', 'Belgium', 'Belize', 'Bolivia', 'Brazil', 'Canada', 'Chile', 'China', 'Colombia', 'Costa Rica', 'Cuba', 'Czech Republic', 'Denmark', 'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Finland', 'France', 'Germany', 'Ghana', 'Greece', 'Guatemala', 'Guyana', 'Haiti', 'Honduras', 'Hungary', 'India', 'Indonesia', 'Ireland', 'Italy', 'Jamaica', 'Japan', 'Kenya', 'Mexico', 'Morocco', 'Netherlands', 'Nicaragua', 'Nigeria', 'Norway', 'Panama', 'Paraguay', 'Peru', 'Poland', 'Portugal', 'Romania', 'Russia', 'Slovakia', 'South Africa', 'South Korea', 'Spain', 'Suriname', 'Sweden', 'Switzerland', 'Thailand', 'Ukraine', 'United Kingdom', 'United States', 'Uruguay', 'Venezuela', 'Vietnam'),
    );

    return $countries[$lang];
}