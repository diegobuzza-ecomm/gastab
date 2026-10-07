<?php

function contactForm($page_id = ''){
	global $post, $lang;

    $options = get_option('mati_theme_options');
	if (!empty($options['contactform_external_code_enabled']) && !empty($options['contactform_external_code'])) {
		echo $options['contactform_external_code'];
		return;
	}

	if ( ! function_exists( 'wp_handle_upload' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	
	if (empty($page_id)){
        $page_id = get_page_id('contact');
	};

	$contact = get_field('contact', $page_id);

	$actual_page_id = $post->ID;
	$actual_page_url = get_permalink($actual_page_id);
	$actual_page_name = get_the_title($actual_page_id);
	$actual_page = '<a href="'. $actual_page_url .'" target="_blank">'. $actual_page_name .' (ID: '. $actual_page_id .')</a>';

	$form = array(
		'id' => 'contactForm',
		'email' => $contact['email_form'],
		'subject' => 'Nuevo contacto',
		'submit' => $lang == 'es' ? 'Enviar' : 'Send',
		'sending' => $lang == 'es' ? 'Enviando...' : 'Sending...',
		'thanks' => $lang == 'es' ? 'Mensaje enviado con éxito<br>¡Gracias por contactarnos!' : 'Message sent<br>¡Thanks for contact us!',
		'redirect' => '',
		'file' => '',
		'validation' => true,
		'fields' => array(
			array(
				'id' => 'contactName',
				'type' => 'text',
				'label' => false,
				'placeholder' => $lang == 'es' ? 'Nombre' : 'First name',
				'columns' => 'col-12 col-md-6 mb-3',
				'required' => true,
				'required_message' => $lang == 'es' ? 'Debes ingresar un nombre.' : 'You need to enter a first name.',
			),
			array(
				'id' => 'contactLastname',
				'type' => 'text',
				'label' => false,
				'placeholder' => $lang == 'es' ? 'Apellido' : 'Last name',
				'columns' => 'col-12 col-md-6 mb-3',
				'required' => true,
				'required_message' => $lang == 'es' ? 'Debes ingresar un apellido.' : 'You need to enter a last name.',
			),
			array(
				'id' => 'contactPosition',
				'type' => 'select',
				'label' => false,
				'placeholder' => $lang == 'es' ? 'Cargo' : 'Position',
				'columns' => 'col-12 mb-3',
				'options' => array(
			        'Administracion' => 'Administración',
			        'Administracion Obra' => 'Administracion Obra',
			        'Analista de compras' => 'Analista de compras',
			        'Facturación Electrónica' => 'Facturación Electrónica',
			        'Pago a Proveedores' => 'Pago a Proveedores',
			        'Analista de suministro' => 'Analista de suministro',
			        'Atencion Proveedores' => 'Atencion Proveedores',
			        'Compras' => 'Compras',
			        'Dueño' => 'Dueño',
			        'Ejecutivo de cuentas' => 'Ejecutivo de cuentas',
			        'Encargado' => 'Encargado',
			        'Gerencia de Compras' => 'Gerencia de Compras',
			        'Gerencia de Operaciones y sistemas' => 'Gerencia de Operaciones y sistemas',
			        'Gerente General' => 'Gerente General',
			        'Gerente Comercial' => 'Gerente Comercial',
			        'Gerente de Abastecimiento' => 'Gerente de Abastecimiento',
			        'Gerente Logistica' => 'Gerente Logistica',
			        'Gerente Mantenimiento' => 'Gerente Mantenimiento',
			        'Intendente' => 'Intendente',
			        'Jefe de Logistica' => 'Jefe de Logistica',
			        'Jefe de Obra' => 'Jefe de Obra'
			    ),
				'required' => false,
				'required_message' => $lang == 'es' ? 'Debes ingresar un Cargo.' : 'You need to enter a position.',
			),
			array(
				'id' => 'contactCompany',
				'type' => 'text',
				'label' => false,
				'placeholder' => $lang == 'es' ? 'Empresa' : 'Company',
				'columns' => 'col-12 col-md-6 mb-3',
				'required' => true,
				'required_message' => $lang == 'es' ? 'Debes ingresar una empresa.' : 'You need to enter a company.',
			),
			array(
				'id' => 'contactPhone',
				'type' => 'tel',
				'label' => false,
				'placeholder' => $lang == 'es' ? 'Teléfono' : 'Phone',
				'columns' => 'col-12 col-md-6 mb-3',
				'required' => true,
				'required_message' => $lang == 'es' ? 'Debes ingresar un teléfono.' : 'You need to enter a phone.',
				'required_filter' => 'phone',
				'required_filter_message' => $lang == 'es' ? 'Debes ingresar un teléfono válido.' : 'You need to enter a valid phone.',
			),
			array(
				'id' => 'contactEmail',
				'type' => 'email',
				'label' => false,
				'placeholder' => $lang == 'es' ? 'Correo electrónico' : 'E-mail',
				'columns' => 'col-12 mb-3',
				'required' => true,
				'required_message' => $lang == 'es' ? 'Debes ingresar un e-mail.' : 'You need to enter an e-mail.',
				'required_filter' => 'email',
				'required_filter_message' => $lang == 'es' ? 'Debes ingresar un e-mail válido.' : 'You need to enter a valid e-mail.',
			),			
			array(
				'id' => 'contactIndustry',
				'type' => 'select',
				'label' => false,
				'placeholder' => $lang == 'es' ? 'Sector' : 'Industry',
				'columns' => 'col-12 mb-3',
				'options' => array(
			        'ADMINISTRACIONES /CONSORCIOS' => 'ADMINISTRACIONES /CONSORCIOS',
			        'AGRO INDUSTRIA' => 'AGRO INDUSTRIA',
			        'BANCOS / FINANACIERAS' => 'BANCOS / FINANACIERAS',
			        'COUNTRIES Y BARRIOS PRIVADOS' => 'COUNTRIES Y BARRIOS PRIVADOS',
			        'DEPOSITOS / LOGISTICAS' => 'DEPOSITOS / LOGISTICAS',
			        'DEPOSITOS FISCALES' => 'DEPOSITOS FISCALES',
			        'EESS' => 'EESS',
			        'EMBAJADAS / CONSULADOS' => 'EMBAJADAS / CONSULADOS',
			        'EMPRESAS CONSTRUCTORAS' => 'EMPRESAS CONSTRUCTORAS',
			        'EMPRESAS DE MANTENIMIENTO / FACILITYS' => 'EMPRESAS DE MANTENIMIENTO / FACILITYS',
			        'EMPRESAS DE SERVICIOS' => 'EMPRESAS DE SERVICIOS',
			        'EMPRESAS DE TELECOMUNICACIONES' => 'EMPRESAS DE TELECOMUNICACIONES',
			        'EMPRESAS ENTRETENIMIENTO / EVENTOS' => 'EMPRESAS ENTRETENIMIENTO / EVENTOS',
			        'EMPRESAS RETAIL' => 'EMPRESAS RETAIL',
			        'HOSTITALES /SALUD' => 'HOSTITALES /SALUD',
			        'INDUSTRIA' => 'INDUSTRIA',
			        'INDUSTRIA ALIMENTICIA / BEBIDAS' => 'INDUSTRIA ALIMENTICIA / BEBIDAS',
			        'INDUSTRIA METALURGICA' => 'INDUSTRIA METALURGICA',
			        'INDUSTRIA QUIMICA' => 'INDUSTRIA QUIMICA',
			        'INDUSTRIA TEXTIL' => 'INDUSTRIA TEXTIL',
			        'INDUSTRIAS DEL PLASTICO Y POLICARBUROS' => 'INDUSTRIAS DEL PLASTICO Y POLICARBUROS',
			        'Instituciones educativas' => 'Instituciones educativas',
			        'INSTITUCIONES ESTATALES' => 'INSTITUCIONES ESTATALES',
			        'INSTITUCIONES GUBERNAMENTALES' => 'INSTITUCIONES GUBERNAMENTALES',
			        'LABORATORIOS' => 'LABORATORIOS',
			        'NAUTICAS / GUARDERIAS' => 'NAUTICAS / GUARDERIAS',
			        'REFINERIAS' => 'REFINERIAS',
			        'RENTADORES DE GE' => 'RENTADORES DE GE',
			        'TRANSPORTE DE CARGAS' => 'TRANSPORTE DE CARGAS',
			        'TRANSPORTE PUBLICOS' => 'TRANSPORTE PUBLICOS',
			        'TRANSPORTEDEPASAJEROS' => 'TRANSPORTEDEPASAJEROS'
			    ),
				'required' => true,
				'required_message' => $lang == 'es' ? 'Debes ingresar un sector.' : 'You need to enter an industry.',
			),
			array(
				'id' => 'contactInterest',
				'type' => 'checkbox',
				'options' => array(
			        'Abast. Combustible en sitio' => 'Abast. Combustible en sitio',
			        'Lubricantes / Urea' => 'Lubricantes / Urea',
			        'Servicio mantenimiento grupo electrógeno' => 'Servicio mantenimiento grupo electrógeno',
			        'Cuenta corriente en estación de servicio' => 'Cuenta corriente en estación de servicio',
			        'Alquiler / Venta de grupo electrógeno' => 'Alquiler / Venta de grupo electrógeno',
			        'Otros' => 'Otros'
			    ),
				'label' => false,
				'placeholder' => false,
				'is_empty' => 'No informado',
				'columns' => 'col-12 checkbox-list mb-3',
				'required' => false,
				'required_filter' => false,
			),
			array(
				'id' => 'contactMessage',
				'type' => 'textarea',
				'label' => false,
				'placeholder' => $lang == 'es' ? 'Descripción' : 'Descripción',
				'columns' => 'col-12 mb-3',
			),
			array(
				'id' => 'contactFrom',
				'type' => 'hidden',
				'label' => 'Desde',
				'placeholder' => false,
				'columns' => 'col-12 d-none',
				'value' => $actual_page,
			),
			
		),
		'captcha' => array(
			'enabled' => intval($options['google_captcha_api_enabled'] ?? 0),
			'version' => intval($options['google_captcha_api_version'] ?? 3),
			'public' => $options['google_captcha_api_key_public'] ?? '',
			'secret' => $options['google_captcha_api_key_secret'] ?? '',
			'message' => $lang == 'es' ? 'Captcha incorrecto' : 'Wrong captcha',
		),
		'database' => array(
			'enabled' => $options['contactform_db_enabled'] ?? false,
			'id' => 'Contacto',
		),
		'mailchimp' => array(
			'enabled' => false,
			'list_id' => '',
		),
	);

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


	// Mailchimp data
	$mailchimp_data = array(
		'FNAME' => $results['contactName'],
		'LNAME' => $results['contactLastname'],
		'EMAIL' => $results['contactEmail'],
	);


	// Send form
	$approved = true;

	if ($form['captcha']['enabled']):
		$response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
			'body' => array(
				'secret' => $form['captcha']['secret'],
				'response' => $_POST['g-recaptcha-response'] ?? '',
			),
		));
		$captcha_response_body = wp_remote_retrieve_body($response);
		$captcha_response_data = json_decode($captcha_response_body, true);

		if ($form['captcha']['version'] == 2) {
			$approved = isset($captcha_response_data['success']) && $captcha_response_data['success'];
		} else {
			$approved = isset($captcha_response_data['score']) && $captcha_response_data['score'] >= 0.7;
		}
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
<form id="<?= $form['id']; ?>" method="POST" class="row" enctype="multipart/form-data">

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

			<textarea name="<?= $field['name'] ?>" id="<?= $field['id'] ?>" class="form-control" rows="1"
				placeholder="<?= $field['placeholder']; ?>"><?= $field['value']; ?></textarea>

		<?php elseif($field['type'] === 'select'): ?>

			<select name="<?= $field['name']; ?>" id="<?= $field['id'] ?>" class="form-control">
				<option value="" selected><?= $field['placeholder'] ? $field['placeholder'] : 'Select an option'; ?></option>
				<?php foreach ($field['options'] as $key => $label): ?>
				<option value="<?= $key ?>" <?= $field['value'] && $field['value'] == $key ? 'selected' : '' ?>><?= $label ?></option>
				<?php endforeach ?>
			</select>

		<?php elseif ($field['type'] === 'checkbox' || $field['type'] === 'radio'): ?>

		    <?php foreach ($field['options'] as $key => $label): ?>
		        <div class="form-check">
		            <input type="<?= $field['type'] ?>" 
		                   name="<?= $field['name']; ?><?= $field['type'] === 'checkbox' ? '[]' : '' ?>" 
		                   id="<?= $field['id'] . '-' . $key ?>" 
		                   class="form-check-input" 
		                   value="<?= $key ?>"
		                   <?= isset($field['value']) && is_array($field['value']) && in_array($key, $field['value']) ? 'checked' : '' ?>
		            >
		            <label for="<?= $field['id'] . '-' . $key ?>" class="form-check-label"><?= $label ?></label>
		        </div>
		    <?php endforeach; ?>

		<?php elseif($field['type'] === 'file'): ?>

			<label class="input-file-group" for="<?= $field['id'] ?>">
				<input type="file" name="<?= $field['name']; ?>" id="<?= $field['id'] ?>" accept="application/msword, application/vnd.ms-powerpoint, application/pdf, image/jpeg, image/png"><?= $field['placeholder'] ?>
				<div class="files"></div>
			</label>

		<?php else: ?>

			<input type="<?= $field['type']; ?>" name="<?= $field['name']; ?>" id="<?= $field['id'] ?>" class="form-control"
			placeholder="<?= $field['placeholder']; ?>" value="<?= $field['value']; ?>">

		<?php endif ?>

	</div>
	<?php endforeach ?>

	<!-- Submit -->
	<div class="col-12 my-4 text-center">
		<input type="hidden" name="type" value="<?= $form['id']; ?>">
		<button type="submit" class="btn btn-block-mobile btn-primary"><?= $form['submit']; ?></button>
	</div>

	<?php if ($form['captcha']['enabled']): ?>
	<div class="col-12 text-center captcha">
		<input type="hidden" name="g-recaptcha-response" value="">
		
		<?php if($form['captcha']['version'] === 2): ?>
			<div class="g-recaptcha" data-sitekey="<?= $form['captcha']['public']; ?>"></div>
		<?php else: ?>
			<p class="small"><small><?= $lang == 'es' ? 'Este sitio esta protegido por Google reCAPTCHA' : 'This site is protected by Google reCAPTCHA'; ?></small></p>
		<?php endif; ?>
	</div>
	<?php endif; ?>

</form>

<script>
	document.addEventListener("DOMContentLoaded",function(){
		contactForm(<?= json_encode($form); ?>);
	});
</script>
<?php }