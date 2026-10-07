<?php

add_filter('embed_oembed_html', 'wrap_embed', 99, 4);

function wrap_embed($html, $url, $attr, $post_id) {
    return '<div class="ratio ratio-16x9">' . $html . '</div>';
}

function get_video_detail($field = '', $thumbnail = false){
    $video_type = '';
    $video_id = '';
    $video_thumbnail = '';

    // Handle local video files
    if (is_array($field) && isset($field['url'])) {
        $video_type = 'file';
        $video_id   = $field['url'];

    } else {
        if (preg_match('/src="([^"]+)"/', $field, $matches)) {
            $src = $matches[1];
        } else {
            $src = $field;
        }

        // Parse URL to determine type and extract ID
        $parsedUrl = parse_url($src);
        $host  = strtolower($parsedUrl['host'] ?? '');
        $path  = $parsedUrl['path'] ?? '';
        $query = $parsedUrl['query'] ?? '';
        $host  = preg_replace('/^www\./', '', $host);

        // Determine video type and ID
        if (strpos($host, 'youtube.com') !== false || strpos($host, 'youtu.be') !== false) {
            $video_type = 'youtube';
            preg_match('/(v=|\/embed\/|youtu\.be\/)([^\&\?\/]+)/', $src, $id_matches);
            $video_id = $id_matches[2] ?? '';

        } elseif (strpos($host, 'vimeo.com') !== false) {
            $video_type = 'vimeo';
            preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $src, $id_matches);
            $video_id = $id_matches[1] ?? '';
        }
    }

    // Fetch thumbnail if requested and ID is found
    if ($thumbnail && !empty($video_id)) {
        $video_thumbnail = fetch_video_thumbnail($video_type, $video_id);
    }

    return array_filter([
        'type'      => $video_type,
        'id'        => $video_id,
        'thumbnail' => $video_thumbnail,
    ]);
}

function fetch_video_thumbnail($video_type, $video_id) {
    $thumbnail_url = '';

    // YouTube thumbnail
    if ($video_type === 'youtube' && !empty($video_id)) {
        $transient_key = 'youtube_thumb_' . $video_id;
        $cached_thumbnail = get_transient($transient_key);

        if ($cached_thumbnail !== false) {
            return $cached_thumbnail;
        }

        // Attempt to get the high-resolution thumbnail
        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";
        $response = wp_remote_head($thumbnail_url);

        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
        }

        set_transient($transient_key, $thumbnail_url, DAY_IN_SECONDS);

    // Vimeo thumbnail
    } elseif ($video_type === 'vimeo' && !empty($video_id)) {
        $transient_key = 'vimeo_thumb_' . $video_id;
        $cached_thumbnail = get_transient($transient_key);

        if ($cached_thumbnail !== false) {
            return $cached_thumbnail;
        }

        $vimeo_api_url = "https://vimeo.com/api/v2/video/$video_id.json";
        $response = wp_remote_get($vimeo_api_url);
        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            if (isset($data[0]['thumbnail_large'])) {
                $thumbnail_url = $data[0]['thumbnail_large'];
                set_transient($transient_key, $thumbnail_url, DAY_IN_SECONDS);
            }
        }
    }

    return $thumbnail_url;
}