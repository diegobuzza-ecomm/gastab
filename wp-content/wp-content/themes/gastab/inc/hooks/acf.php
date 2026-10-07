<?php

// Google Maps API Key
function mati_acf_init(){
    $options = get_option('mati_theme_options');

    $google_maps_enabled = $options['google_maps_api_enabled'] ?? false;
    $google_maps_api_key = $options['google_maps_api_key'] ?? '';

	if (!empty($google_maps_api_key)){
    	acf_update_setting('google_api_key', $google_maps_api_key);
	}
}
add_action('acf/init', 'mati_acf_init');


// Content editor custom
function mati_acf_content_to_message(){ ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function(){
            const messageFieldInput = document.querySelector('.acf-field-message .acf-input');
            const contentEditor = document.getElementById('postdivrich');

            // Check if both elements exist before attempting to move the editor
            if (!messageFieldInput || !contentEditor) {
                console.warn('ACF message field or content editor not found.');
                return;
            }

            // Append the content editor to the ACF message field
            messageFieldInput.appendChild(contentEditor);
        });
    </script>
    <style type="text/css">
        .acf-field #wp-content-editor-tools{
            background: transparent;
            padding-top: 0;
        }
    </style>
<?php }

add_action('acf/input/admin_head', 'mati_acf_content_to_message');