<?php

// Display the options page
function mati_display_options_page() {

$title = 'Site options';
$logo = 'https://mati.agency/assets/img/mati-manager-plugin-logo.png';

$sections = mati_theme_options_get_sections();

?>
<script>
    document.body.classList.add("mati-manager");
</script>
<div class="mati-manager-page mati-manager-options">

    <!-- Header -->
    <header class="mati-header">

        <div class="mati-title">
            <h1><?= esc_html($title); ?></h1>
        </div>

        <div class="mati-logo">
            <a href="https://mati.agency" target="_blank">
                <img src="<?= esc_url($logo); ?>" alt="MATI Digital Agency">
            </a>
        </div>

    </header>


    <!-- Nav -->
    <nav class="mati-nav nav-tab-wrapper">
        <?php foreach ($sections as $key => $values): ?>
        <a href="#section_<?= esc_attr($key) ?>" class="nav-tab <?= $key === 'general' ? 'nav-tab-active' : '' ?>"><?= $values['title'] ?></a>
        <?php endforeach ?>
    </nav>

    <!-- Content -->
    <div class="mati-content">

        <form method="post" action="options.php" class="tab-content-wrapper">
            <?php settings_fields('mati_theme_options'); ?>

            <div class="tabs">
                <?php foreach ($sections as $key => $values): ?>
                <div id="section_<?= esc_attr($key); ?>" class="tab-content <?= $key === 'general' ? 'active' : ''; ?>">
                    <?php do_settings_sections("mati_theme_options_{$key}"); ?>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php submit_button(); ?>
        </form>

    </div>

</div>
<?php
}

// Get options sections
function mati_theme_options_get_sections(){
    return [
        'general' => [
            'title' => __('General', 'mati-theme'),
            'id' => 'mati_theme_options_general',
            'page' => 'mati_theme_options_general'
        ],
        'forms' => [
            'title' => __('Forms', 'mati-theme'),
            'id' => 'mati_theme_options_forms',
            'page' => 'mati_theme_options_forms'
        ],
        'menu' => [
            'title' => __('Menu', 'mati-theme'),
            'id' => 'mati_theme_options_menu',
            'page' => 'mati_theme_options_menu'
        ],
        'code' => [
            'title' => __('Code', 'mati-theme'),
            'id' => 'mati_theme_options_code',
            'page' => 'mati_theme_options_code'
        ],
        'others' => [
            'title' => __('Others', 'mati-theme'),
            'id' => 'mati_theme_options_others',
            'page' => 'mati_theme_options_others'
        ]
    ];
}


// Get options fields
function mati_theme_options_get_fields(){
    $fields = [
        'primary_color' => [
            'label' => __('Primary Color', 'mati-theme'),
            'section' => 'general',
            'type' => 'color'
        ],
        'enable_emojis' => [
            'label' => __('Enable Emojis', 'mati-theme'),
            'section' => 'general',
            'type' => 'checkbox'
        ],
        'google_maps_api_enabled' => [
            'label' => __('Enable Google Maps', 'mati-theme'),
            'section' => 'general',
            'type' => 'checkbox'
        ],
        'google_maps_api_key' => [
            'label' => __('Google Maps API Key', 'mati-theme'),
            'section' => 'general',
            'type' => 'text'
        ],
        'enable_whatsapp_icon' => [
            'label' => __('Enable floating WhatsApp', 'mati-theme'),
            'section' => 'general',
            'type' => 'checkbox'
        ],
        'disable_gutenberg_editor' => [
            'label' => __('Disable gutenberg editor', 'mati-theme'),
            'section' => 'general',
            'type' => 'checkbox'
        ],

        // Forms
        'contactform_db_enabled' => [
            'label' => __('Enable Forms DB', 'mati-theme'),
            'section' => 'forms',
            'type' => 'checkbox'
        ],
        'google_captcha_api_enabled' => [
            'label' => __('Enable Recaptcha', 'mati-theme'),
            'section' => 'forms',
            'type' => 'checkbox'
        ],
        'google_captcha_api_version' => [
            'label' => __('Recaptcha Version', 'mati-theme'),
            'section' => 'forms',
            'type' => 'select',
            'options' => [
                2 => '2',
                3 => '3',
            ],
        ],
        'google_captcha_api_key_public' => [
            'label' => __('Captcha API Key Public', 'mati-theme'),
            'section' => 'forms',
            'type' => 'text'
        ],
        'google_captcha_api_key_secret' => [
            'label' => __('Captcha API Key Secret', 'mati-theme'),
            'section' => 'forms',
            'type' => 'text'
        ],
        'contactform_external_code_enabled' => [
            'label' => __('Enable external code', 'mati-theme'),
            'section' => 'forms',
            'type' => 'checkbox'
        ],
        'contactform_external_code' => [
            'label' => __('External code to<br> replace local form', 'mati-theme'),
            'section' => 'forms',
            'type' => 'textarea'
        ],


        // Menu
        'hide_posts_menu' => [
            'label' => __('Hide Posts Menu', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ],
        'hide_comments_menu' => [
            'label' => __('Hide Comments Menu', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ],
        'hide_themes_menu' => [
            'label' => __('Hide Themes Menu', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ],
        'hide_tools_menu' => [
            'label' => __('Hide Tools Menu', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ],
        'hide_plugins_menu' => [
            'label' => __('Hide Plugins Menu', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ],

        // Code
        'custom_head_code' => [
            'label' => __('Custom code<br> inside &lt;head&gt;', 'mati-theme'),
            'section' => 'code',
            'type' => 'textarea'
        ],
        'custom_body_code' => [
            'label' => __('Custom code<br> after &lt;body&gt;', 'mati-theme'),
            'section' => 'code',
            'type' => 'textarea'
        ],
        'custom_footer_code' => [
            'label' => __('Custom code<br> after &lt;footer&gt;', 'mati-theme'),
            'section' => 'code',
            'type' => 'textarea'
        ],
        'custom_footer_css' => [
            'label' => __('Custom CSS', 'mati-theme'),
            'section' => 'code',
            'type' => 'textarea'
        ],

        // Others
        'maintenance_mode_enabled' => [
            'label' => __('Enable Maintenance Mode', 'mati-theme'),
            'section' => 'others',
            'type' => 'checkbox'
        ],
        'enable_debug_mode' => [
            'label' => __('Enable Debug Mode', 'mati-theme'),
            'section' => 'others',
            'type' => 'checkbox'
        ],
    ];

    if (!function_exists('is_plugin_active')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

   // Plugins condicionales
    if (class_exists('ACF')
        || is_plugin_active('advanced-custom-fields/acf.php')
        || is_plugin_active('advanced-custom-fields-pro/acf.php')){
        $fields['hide_acf_plugin_menu'] = [
            'label' => __('Hide ACF Plugin', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ];
    }

    if (class_exists('WPMailSMTP')
        || is_plugin_active('wp-mail-smtp/wp_mail_smtp.php')
        || is_plugin_active('wp-mail-smtp-pro/wp_mail_smtp.php')){
        $fields['hide_wpmailsmtp_plugin_menu'] = [
            'label' => __('Hide WP Mail SMTP Plugin', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ];
    }

    if (class_exists('Polylang')
        || is_plugin_active('polylang/polylang.php')
        || is_plugin_active('polylang-pro/polylang.php')){
        $fields['hide_polylang_plugin_menu'] = [
            'label' => __('Hide Polylang Plugin', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ];
    }


    if (class_exists('mk_file_folder_manager')
        || is_plugin_active('wp-file-manager/file_folder_manager.php')){
        $fields['hide_filemanager_plugin_menu'] = [
            'label' => __('Hide File Manager Plugin', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ];
    }

    if (class_exists('W3_Plugin_TotalCache')
        || is_plugin_active('w3-total-cache/w3-total-cache.php')){
        $fields['hide_w3tc_plugin_menu'] = [
            'label' => __('Hide W3 Total Cache Plugin', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ];
    }

    if (class_exists('ITSEC_Core')
        || is_plugin_active('ithemes-security-pro/ithemes-security-pro.php') 
        || is_plugin_active('better-wp-security/better-wp-security.php')){
        $fields['hide_solidsecurity_plugin_menu'] = [
            'label' => __('Hide Solid Security Plugin', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ];
    }

    if (class_exists('WPSEO_Options')
        || is_plugin_active('wordpress-seo/wp-seo.php')) {
        $fields['hide_yoastseo_plugin_menu'] = [
            'label' => __('Hide Yoast SEO Plugin', 'mati-theme'),
            'section' => 'menu',
            'type' => 'checkbox'
        ];
    }

    return $fields;
}

function mati_theme_render_options(){
    register_setting(
        'mati_theme_options',
        'mati_theme_options',
        'mati_theme_options_sanitize'
    );

    $sections = mati_theme_options_get_sections();
    foreach ($sections as $section) {
        add_settings_section(
            $section['id'],
            $section['title'],
            null,
            $section['page']
        );
    }


    $fields = mati_theme_options_get_fields();
    foreach ($fields as $id => $field) {
        $section = $sections[$field['section']];

        add_settings_field(
            $id,
            $field['label'],
            'mati_theme_options_render_field',
            $section['page'],
            $section['id'],
            [
                'label_for' => $id,
                'type' => $field['type'],
                'attributes' => $field['attributes'] ?? [],
                'options' => $field['options'] ?? [],
                'placeholder' => $field['placeholder'] ?? ''
            ]
        );
    }
};

add_action('admin_init', 'mati_theme_render_options');


// Generalized field rendering callback
function mati_theme_options_render_field($args) {
    $options = get_option('mati_theme_options');
    $field_id = $args['label_for'];
    $value = $options[$field_id] ?? '';

    switch ($args['type']) {
        case 'color':
            $input_id = 'mati_color_' . esc_attr($field_id);
            $hex_value = esc_attr($value);
            echo '
            <input type="text" id="' . $input_id . '_text" value="' . $hex_value . '" style="width: 80px; vertical-align: middle; margin-right: 5px;" maxlength="7" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$" title="Código hexadecimal (#fff o #ffffff)">
            <input type="color" id="' . $input_id . '_picker" value="' . $hex_value . '" style="height: 36px; border-radius: 6px; vertical-align: middle;">
            <input type="hidden" name="mati_theme_options[' . esc_attr($field_id) . ']" id="' . $input_id . '" value="' . $hex_value . '">
            
            <script>
            (function() {
                const picker = document.getElementById("' . $input_id . '_picker");
                const text = document.getElementById("' . $input_id . '_text");
                const hidden = document.getElementById("' . $input_id . '");

                const isValidHex = (val) => /^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/.test(val);

                function syncColorInputs(source, target1, target2) {
                    source.addEventListener("input", function() {
                        const val = source.value;
                        if (isValidHex(val)){
                            target1.value = val;
                            target2.value = val;
                        }
                    });
                }

                text.addEventListener("input", function() {
                    const val = text.value;
                    if (isValidHex(val)){
                        picker.value = val;
                        hidden.value = val;
                        text.style.borderColor = "";
                    } else {
                        text.style.borderColor = "black";
                    }
                });

                syncColorInputs(picker, text, hidden);
            })();
            </script>';
            break;

        case 'number':
            printf(
                '<input type="number" name="mati_theme_options[%s]" value="%s" %s />',
                esc_attr($field_id), esc_attr($value),
                isset($args['attributes']) ? join(' ', array_map(function ($k, $v) {
                    return esc_attr($k) . '="' . esc_attr($v) . '"';
                }, array_keys($args['attributes']), $args['attributes'])) : ''
            );
            break;

        case 'checkbox':
            printf('<input type="hidden" name="mati_theme_options[%s]" value="0" />', esc_attr($field_id));
            printf('<input type="checkbox" name="mati_theme_options[%s]" value="1" %s />',
                esc_attr($field_id), checked(1, $value, false)
            );
            break;

        case 'radio':
            foreach ($args['options'] as $option_value => $option_label) {
                printf(
                    '<label><input type="radio" name="mati_theme_options[%s]" value="%s" %s> %s</label><br>',
                    esc_attr($field_id), esc_attr($option_value), checked($value, $option_value, false), esc_html($option_label)
                );
            }
            break;

        case 'select':
            printf('<select name="mati_theme_options[%s]">', esc_attr($field_id));
            foreach ($args['options'] as $option_value => $option_label) {
                printf(
                    '<option value="%s" %s>%s</option>',
                    esc_attr($option_value), selected($value, $option_value, false), esc_html($option_label)
                );
            }
            echo '</select>';
            break;

        case 'textarea':
            printf(
                '<textarea name="mati_theme_options[%s]" placeholder="%s" rows="12" cols="80">%s</textarea>',
                esc_attr($field_id), esc_attr($args['placeholder']), esc_textarea($value)
            );
            break;

        case 'text':
        default:
            printf(
                '<input type="text" name="mati_theme_options[%s]" value="%s" placeholder="%s" />',
                esc_attr($field_id), esc_attr($value), esc_attr($args['placeholder'])
            );
            break;
    }
}

// Sanitize input values
function mati_theme_options_sanitize($input){
    $sanitized_input = [];
    $fields = mati_theme_options_get_fields();

    foreach ($fields as $field_id => $field) {
        if (!isset($input[$field_id])) continue;

        switch ($field['type']) {
            case 'color':
                $sanitized_input[$field_id] = sanitize_hex_color($input[$field_id]);
                break;

            case 'number':
            case 'checkbox':
                $sanitized_input[$field_id] = absint($input[$field_id]);
                break;

            case 'textarea':
                $sanitized_input[$field_id] = $input[$field_id];
                break;

            case 'radio':
            case 'select':
            case 'text':
            default:
                $sanitized_input[$field_id] = sanitize_text_field($input[$field_id]);
                break;
        }
    }

    return $sanitized_input;
}


// Output custom code in wp_head
function mati_options_custom_header_code() {
    $options = get_option('mati_theme_options');
 
    if (!empty($options['custom_head_code'])) {
        echo $options['custom_head_code'];
    }
}

add_action('wp_head', 'mati_options_custom_header_code');


// Output custom code in wp_footer
function mati_options_custom_footer_code(){
    $options = get_option('mati_theme_options');

    if (!empty($options['custom_footer_code'])){
        echo $options['custom_footer_code'];
    }

    if (!empty($options['custom_footer_css'])) {
        echo '<style type="text/css">' . wp_strip_all_tags($options['custom_footer_css']) . '</style>';
    }
}

add_action('wp_footer', 'mati_options_custom_footer_code');


// Options > Defaults
function mati_theme_options_default(){
    $current_options = get_option('mati_theme_options');
    $fields = mati_theme_options_get_fields();

    if ($current_options === false){
        $default_options = [
            'primary_color'                     => '#000000',
            'enable_emojis'                     => 0,
            'enable_whatsapp_icon'              => 0,

            'google_maps_api_enabled'           => 0,
            'google_maps_api_key'               => 'AIzaSyB-KZtYJLbK-9fiCL1xTaOyOc2kTgo7VbY',

            'contactform_db_enabled'            => 1,
            'google_captcha_api_enabled'        => 1,
            'google_captcha_api_version'        => 3,
            'google_captcha_api_key_public'     => '6LcX6OcjAAAAACa3LCRZgfO9HF0nc2Rpt-fymSbV',
            'google_captcha_api_key_secret'     => '6LcX6OcjAAAAANSJrqnDLx7l_h5L1CONZg_3jxw3',
            'contactform_external_code_enabled' => 0,
            'contactform_external_code'         => '',

            'hide_posts_menu'                   => 1,
            'hide_comments_menu'                => 1,
            'hide_themes_menu'                  => 1,
            'hide_tools_menu'                   => 1,
            'hide_plugins_menu'                 => 1,
            'hide_acf_plugin_menu'              => 0,
            'hide_wpmailsmtp_plugin_menu'       => 0,
            'hide_polylang_plugin_menu'         => 0,
            'hide_filemanager_plugin_menu'      => 0,
            'hide_w3tc_plugin_menu'             => 0,
            'hide_solidsecurity_plugin_menu'    => 0,
            'hide_yoast_plugin_menu'            => 0,

            'custom_head_code'                  => '',
            'custom_body_code'                  => '',
            'custom_footer_code'                => '',
            'custom_footer_css'                 => '',

            'maintenance_mode_enabled'          => 0,
            'enable_debug_mode'                 => 0,
        ];

        add_option('mati_theme_options', $default_options);
    }
}
add_action('after_setup_theme', 'mati_theme_options_default', 0);


// Options > Custom Menus
function mati_theme_options_menu(){
    add_menu_page('Site options', 'Site options', 'manage_options', 'mati-theme-options', 'mati_display_options_page', 'dashicons-heart');
}

add_action('admin_menu', 'mati_theme_options_menu');

// Options > Custom Menus
function mati_theme_options_custom_menu(){
    $options = get_option('mati_theme_options');

    if (!function_exists('is_plugin_active')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    // Menu > posts, comments, themes and tools
    $simple_menus = [
        'hide_posts_menu'    => 'edit.php',
        'hide_comments_menu' => 'edit-comments.php',
        'hide_themes_menu'   => 'themes.php',
        'hide_tools_menu'    => 'tools.php',
    ];

    foreach ($simple_menus as $option_key => $menu_slug) {
        if (!empty($options[$option_key])) {
            remove_menu_page($menu_slug);
        }
    }

    // Menu > Plugins
    if (isset($options['hide_plugins_menu']) && $options['hide_plugins_menu']) {
        remove_menu_page('plugins.php');

        add_submenu_page(
            'options-general.php', 
            'Plugins', 
            'Plugins', 
            'manage_options', 
            'plugins.php',
            ''
        );
    }

    // Menús personalizados: ACF y otros plugins
    $custom_plugins = [
        'hide_acf_plugin_menu' => [
            'slug'   => 'edit.php?post_type=acf-field-group',
            'title'  => 'Advanced Custom Fields',
            'label'  => 'ACF',
            'check'  => fn() => (
                class_exists('ACF')
                || is_plugin_active('advanced-custom-fields/acf.php')
                || is_plugin_active('advanced-custom-fields-pro/acf.php')
            ),
        ],
        'hide_wpmailsmtp_plugin_menu' => [
            'slug'   => 'wp-mail-smtp',
            'title'  => 'WP Mail SMTP',
            'label'  => 'WP Mail SMTP',
            'check'  => fn() => (
                class_exists('WPMailSMTP')
                || is_plugin_active('wp-mail-smtp/wp_mail_smtp.php')
                || is_plugin_active('wp-mail-smtp-pro/wp_mail_smtp.php')
            ),
        ],
        'hide_polylang_plugin_menu' => [
            'slug'   => 'mlang',
            'title'  => 'Polylang',
            'label'  => 'Polylang',
            'check'  => fn() => (
                class_exists('Polylang')
                || is_plugin_active('polylang/polylang.php')
                || is_plugin_active('polylang-pro/polylang.php')
            ),
        ],
        'hide_filemanager_plugin_menu' => [
            'slug'   => 'wp_file_manager',
            'title'  => 'File Manager',
            'label'  => 'File Manager',
            'check'  => fn() => (
                class_exists('mk_file_folder_manager')
                || is_plugin_active('wp-file-manager/file_folder_manager.php')
            ),
        ],
        'hide_w3tc_plugin_menu' => [
            'slug'   => 'w3tc_dashboard',
            'title'  => 'W3 Total Cache',
            'label'  => 'W3 Total Cache',
            'check'  => fn() => (
                class_exists('W3_Plugin_TotalCache')
                || is_plugin_active('w3-total-cache/w3-total-cache.php')
            ),
        ],
        'hide_solidsecurity_plugin_menu' => [
            'slug'   => 'itsec-dashboard',
            'title'  => 'Solid Security',
            'label'  => 'Solid Security',
            'check'  => fn() => (
                class_exists('ITSEC_Core')
                || is_plugin_active('ithemes-security-pro/ithemes-security-pro.php') 
                || is_plugin_active('better-wp-security/better-wp-security.php')
            ),
        ],
        'hide_yoastseo_plugin_menu' => [
            'slug'   => 'wpseo_dashboard',
            'title'  => 'Yoast SEO',
            'label'  => 'Yoast SEO',
            'check'  => fn() => (
                class_exists('WPSEO_Options')
                || is_plugin_active('wordpress-seo/wp-seo.php')
            ),
        ],
    ];


    foreach ($custom_plugins as $option_key => $data) {
        if (!empty($options[$option_key])
            && is_callable($data['check'])
            && call_user_func($data['check'])
        ){
            remove_menu_page($data['slug']);
            add_submenu_page('options-general.php', $data['title'], $data['label'], 'manage_options', $data['slug']);
        }
    }
}

add_action('admin_menu', 'mati_theme_options_custom_menu', 99);