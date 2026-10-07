<?php

// Save to list
function mati_register_contactformdb_post_type(){

	// Create CPT
    $contactformdb_cpt_args = array(
		'labels' => array(
			'name' => __('Forms'),
		),
		'public'          => false,
		'show_ui'         => true,
		'menu_position'   => 2,
		'menu_icon'		  => 'dashicons-database', 
		'capability_type' => 'post',
		'rewrite'         => false,
		'supports'        => array('title', 'editor' ),
		'capabilities'    => array('create_posts' => 'do_not_allow'),
		'map_meta_cap'    => true,
	);

	register_post_type('contactformdb', $contactformdb_cpt_args);


	// Create taxonomy
	$contactformdb_cat_args = array(
		'label' => __('Category'),
		'public' => false,
		'hierarchical' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'show_tagcloud' => false,
		'capability_type' => 'post',
	);

	register_taxonomy('contactformdb_cat', 'contactformdb', $contactformdb_cat_args);

}
add_action('init', 'mati_register_contactformdb_post_type');

// Add meta box
function mati_register_contactformdb_metaboxes(){

	add_meta_box('contactformdb_meta_box', 'Detalles de contacto', function(){
			$meta = get_post_meta(get_the_ID());

			foreach ($meta as $key => $value):
				if (!isset($value[0]) || '_' == substr( $key, 0, 1)){
					continue;
				}

				$label = explode('|', $key);
				echo '<p><strong>'. esc_html($label[0]) .'</strong>: <span>'. esc_html($value[0]) .'</span></p>';
			endforeach;
		},
		array('contactformdb'),
		'normal',
		'default'
	);
}

add_action('add_meta_boxes', 'mati_register_contactformdb_metaboxes');


// Save data
function save_contactform_db($form, $results, $email_content, $post_type = 'contactformdb'){

	// Title
	$post_title = !empty($results['contactEmail']) ? $results['contactEmail'] : '';
	$post_title .= !empty($results['contactName']) ? ' - '. $results['contactName'] : '';

	// Content
	$email_content = str_replace(['<html>', '</html>', '<body>', '</body>'], '', $email_content);

	// Fields
	$fields = [];
	foreach ($form['fields'] as $v):
		if (!empty($results[$v['id']])):
			$key = $v['label'] ? $v['label'] : $v['placeholder'];
			$fields[$key] = $results[$v['id']];
		endif;
	endforeach;

	// Create
    $post_id = wp_insert_post(array(
        'post_status'	=> 'publish',
        'post_type'		=> $post_type,
        'post_title'	=> $post_title,
        'post_content'	=> $email_content,
        'meta_input'	=> $fields,
    ));

    if ($post_type == 'contactformdb') {
    	$term_id = $form['database']['id'];
    	wp_set_object_terms($post_id, $term_id, 'contactformdb_cat');
    }

	if (is_wp_error($post_id)){
		return $post_id->get_error_message();
	} else{
		return true;
	}
}

function handle_csv_sanitize($str) {
	if (strpos($str, ',') !== false || strpos($str, '"') !== false || strpos($str, "\n") !== false) {
		$str = '"' . str_replace('"', '""', $str) . '"';
	}
	return $str;
}

function get_export_data($post_type) {
    $args = [
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
    ];
    $posts = get_posts($args);

    $titles = ['ID', 'Title'];
    $list = [];

    foreach ($posts as $post) {
        $meta = get_post_meta($post->ID);
        $values = [$post->ID, $post->post_title];

        // Only add meta titles for the first post
        if (empty($list)) {
            foreach ($meta as $key => $value) {
                if ('_' == substr($key, 0, 1)) {
                    continue;
                }
                $label = explode('|', $key);
                $titles[] = $label[0];
            }
            $list[] = $titles;
        }

        foreach ($titles as $index => $title) {
            if ($title == 'ID' || $title == 'Title') continue;

            $meta_value = isset($meta[$title]) ? $meta[$title][0] : '';
            $values[] = $meta_value;
        }
        $list[] = $values;
    }

    return $list;
}

function contacformdb_export_to_xls($data, $post_type) {
    $filename = $post_type . '_' . date('d-m-Y_G-i') . '.xlsx';
    $xlsx = SimpleXLSXGen::fromArray($data);
    $xlsx->downloadAs($filename);
    exit();
}

function contacformdb_export_to_csv($data, $post_type) {
    $filename = $post_type . '_' . date('d-m-Y_G-i') . '.csv';

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    $output = fopen('php://output', 'w');
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}

function mati_contactformdb_handle_export_form_db(){
    if (isset($_GET['export_form_db'])){

        $post_type = $_GET['export_form_db'];
        $data = get_export_data($post_type);

        if (class_exists('SimpleXLSXGen')) {
            contacformdb_export_to_xls($data, $post_type);
        } else {
            contacformdb_export_to_csv($data, $post_type);
        }
    }
}

add_action('admin_init', 'mati_contactformdb_handle_export_form_db');


// Add button to export
function mati_contactformdb_export_button($views){
	global $pagenow;

	$post_types = array('contactformdb', 'rrhhformdb');

	if($pagenow == 'edit.php' && isset($_GET['post_type']) && in_array($_GET['post_type'], $post_types)):
		$export_url = add_query_arg(array('export_form_db' => $_GET['post_type']));
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$exportButton = '<a href="<?= $export_url ?>" class="page-title-action" style="margin-left:5px">Export data</a>';

			if (jQuery(".wrap .page-title-action").length > 0){
				jQuery(".wrap .page-title-action:last").after($exportButton);
			} else {
				jQuery(".wrap .wp-heading-inline").after($exportButton);
			}
		});
	</script>
	<?php endif;
}
add_filter('admin_head', 'mati_contactformdb_export_button');