<?php

function newsletterForm($page_id = ''){
	global $post, $lang;

	if (empty($page_id)){
        $page_id = get_page_id('contact');
	};

	$contact = get_field('contact', $page_id);
	$options = get_option('mati_theme_options');

	$form = array(
		'id' => 'newsletterForm',
		'email' => $contact['email_form'],
		'subject' => 'Nueva suscripción',
		'submit' => $lang == 'es' ? 'Suscribirse' : 'Subscribe',
		'sending' => $lang == 'es' ? 'Suscribiendo...' : 'Subscribing...',
		'thanks' => $lang == 'es' ? '¡Gracias por suscribirte!' : '¡Thanks for subscribe!',
		'redirect' => '',
		'file' => '',
		'fields' => array(
			array(
				'id' => 'contactEmail',
				'type' => 'email',
				'label' => false,
				'placeholder' => 'E-mail',
				'columns' => 'col-12 col-md-auto',
				'required' => true,
				'required_message' => $lang == 'es' ? 'Debes ingresar un e-mail.' : 'You need to enter an e-mail.',
				'required_filter' => 'email',
				'required_filter_message' => $lang == 'es' ? 'Debes ingresar un e-mail válido.' : 'You need to enter a valid e-mail.',
			),
		),
		'captcha' => array(
			'enabled' => intval($options['google_captcha_api_enabled'] ?? false),
			'version' => intval($options['google_captcha_api_version'] ?? 3),
			'public' => $options['google_captcha_api_key_public'] ?? '',
			'secret' => $options['google_captcha_api_key_secret'] ?? '',
			'message' => $lang == 'es' ? 'Captcha incorrecto' : 'Wrong captcha',
		),
		'database' => array(
			'enabled' => $options['contactform_db_enabled'] ?? false,
			'id' => 'Newsletter',
		),
		'analytics' => array(
			'utm' => false,
		),
		'mailchimp' => array(
			'enabled' => false,
			'list_id' => '',
		),
	);

	// UTM
	if ($form['analytics']['utm']):
		 foreach ($_GET as $key => $value):
	        if (strpos($key, 'utm') === 0 || strtolower($key) == 'utm'):
	            $form['fields'][] = array(
	                'id' => $key,
	                'type' => 'hidden',
	                'label' => false,
	                'placeholder' => strtoupper($key),
	                'value' => $value,
	                'columns' => 'col-12 d-none',
	                'required' => false,
	            );
	        endif;
	    endforeach;
	endif;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['type'] == $form['id']){

	// Fields
	$results = [];
	foreach($form['fields'] as $field):

		$field_id = $field['id'];

		$value = !empty($field['empty_value']) ? $field['empty_value'] : '-';

		if(!empty($_POST[$field_id])):
			$value = is_array($_POST[$field_id]) ? implode(', ', $_POST[$field_id]) : strip_tags(trim($_POST[$field_id]));

		elseif(!empty($_FILES[$field_id]['name'])):
			$file = wp_handle_upload($_FILES[$field_id], ['test_form' => false]);
			$value = '<a href="'. $file['url'] .'" target="_blank">'. $file['url'] .'</a>';

		endif;

		$results[$field_id] = $value;

	endforeach;


	// Template e-mail
	$email_content = '<html><body><div style="padding:50px 0; text-align: center; background: #eeeeee;">

		<a href="'. get_bloginfo('url') .'" target="_Blank" style="display:inline-block; vertical-align: middle; max-width: 200px; height: auto; margin-bottom: 25px;">
			<img src="'. get_bloginfo('template_url') .'/assets/img/logo.png" width="200px" alt="'. get_bloginfo('name') .'" style="width: 100%; max-width: 200px">
		</a>

		<div></div>

		<table cellpadding="12" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 600px; padding-top:10px; padding-bottom: 10px; margin: 0 auto; text-align: left; background: #ffffff; font-family: helvetica, arial; font-size: 14px; border: 1px solid #ccc;">
		';

	foreach ($form['fields'] as $field){
		$label = $field['label'] ? $field['label'] : $field['placeholder'];
	    $result = $results[$field['id']];

		if ($field['type'] != 'utm'):
		$email_content .= '<tr>
							<td style="text-align: right" width="100px"><strong>'. $label .':</strong></td>
							<td>'. $result .'</td>
						</tr>';
		endif;
	}

	$email_content .= '</table></div></body></html>';


	// Send form
	$approved = true;

	if ($form['captcha']['enabled']):
		$captcha_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $form['captcha']['secret'] . '&response=' . $_POST["g-recaptcha-response"];
		$captcha_response = wp_remote_get($captcha_url);
	    $captcha_response_body = wp_remote_retrieve_body($captcha_response);
	    $captcha_response_data = json_decode($captcha_response_body, true);
	    $approved = isset($captcha_response_data["score"]) && $captcha_response_data["score"] >= 0.7;
	endif;

	if ($approved){
		$success = wp_mail($form['email'], $form['subject'], $email_content);

		if ($form['database']['enabled'] && function_exists('save_contactform_db')){
			$save_db = save_contactform_db($form, $results, $email_content);
		}

		if ($form['mailchimp']['enabled'] && function_exists('mailchimp_subscriber_status')){
			$mailchimp = mailchimp_subscriber_status($results['contactEmail'], $mailchimp_data, null, $form['mailchimp']['list_id']);
		}
	}

} ?>
<form id="<?= $form['id']; ?>" method="POST" class="row g-2">

	<?php foreach ($form['fields'] as $field):

		$field['label'] = isset($field['label']) ? $field['label'] : false;
		$field['placeholder'] = isset($field['placeholder']) ? $field['placeholder'] : false;
		$field['name'] = isset($field['name']) ? $field['name'] : $field['id'];
		$field['value'] = isset($field['value']) ? $field['value'] : '';
		$field['required'] = isset($field['required']) ? $field['required'] : false;

		if (!empty($field['placeholder']) && $field['required']){
			$field['placeholder'] .= ' *';
		}

	?>
	<div class="<?= $field['columns'] ?>">

		<?php if ($field['label']): ?>
		<label for="<?= $field['id'] ?>">
			<?= $field['label']; ?>
			<?= $field['required'] ? '<span class="required">*</span>' : '' ?>
		</label>
		<?php endif ?>


		<!-- Field -->
		<?php if ($field['type'] === 'textarea'): ?>

			<textarea name="<?= $field['id'] ?>" id="<?= $field['id'] ?>" class="form-control" rows="3" <?= $placeholder ? 'placeholder="'. $placeholder .'"' : '' ?>><?= $value ? $value : '' ?></textarea>

		<?php elseif($field['type'] === 'select'): ?>

			<select name="<?= !empty($field['name']) ? $field['name'] : $field['id']; ?>"  id="<?= $field['id'] ?>" class="form-control">
				<option value="" selected><?= $field['placeholder'] ? $field['placeholder'] : 'Select an option'; ?></option>
				<?php foreach ($field['options'] as $k => $v): ?>
				<option value="<?= $k ?>" <?= $value && $value == $k ? 'selected' : '' ?>><?= $v ?></option>
				<?php endforeach ?>
			</select>

		<?php elseif($field['type'] === 'file'): ?>

			<label class="input-file-wrapper" for="<?= $field['id'] ?>">
				<input type="file" id="<?= $field['id'] ?>" name="<?= !empty($field['name']) ? $field['name'] : $field['id']; ?>" accept="application/msword, application/vnd.ms-powerpoint, application/pdf, image/jpeg, image/png"><?= $placeholder ?>
				<div class="files"></div>
			</label>

		<?php else: ?>

			<input type="<?= $field['type']; ?>" name="<?= !empty($field['name']) ? $field['name'] : $field['id']; ?>"  id="<?= $field['id'] ?>"  class="form-control" <?= $placeholder ? 'placeholder="'. $placeholder .'"' : '' ?> <?= $value ? 'value="'. $value .'"' : '' ?>>

		<?php endif ?>

	</div>
	<?php endforeach ?>

	<!-- Submit -->
	<div class="col-12 col-md-auto text-end">
		<input type="hidden" name="type" value="<?= $form['id']; ?>">
		<button type="submit" class="btn btn-block-mobile btn-light"><?= $form['submit']; ?></button>
	</div>

	<?php if ($form['captcha']['enabled']): ?>
	<div class="col-12 text-end captcha">
		<input type="hidden" name="g-recaptcha-response" value="">

		<?php if($form['captcha']['version'] === 2): ?>
			<div class="g-recaptcha" data-sitekey="<?= $form['captcha']['public']; ?>"></div>
		<?php else: ?>
			<p class="small d-none"><small><?= $lang == 'es' ? 'Este sitio esta protegido por Google reCAPTCHA' : 'This site is protected by Google reCAPTCHA'; ?></small></p>
		<?php endif; ?>
	</div>
	<?php endif; ?>

</form>

<script>
document.addEventListener("DOMContentLoaded",function(){
	contactForm(<?= json_encode($form); ?>);
});
</script>
<?php

}