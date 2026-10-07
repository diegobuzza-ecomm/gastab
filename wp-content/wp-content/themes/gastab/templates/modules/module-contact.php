<?php

function module_contact($page_id = ''){
	global $lang;

    if ($page_id == ''){
        $page_id = get_page_id('contact');
    }

    $contact = get_field('contact', $page_id);

?>
<section class="section module-contact border-top" id="contacto"><div class="container">

	<div class="title text-center wow fadeIn">
		<h3 class="text-primary"><?= $contact['title']; ?></h3>
		<p><?= $contact['description']; ?></p>
	</div>

	<div class="row justify-content-center">
		<div class="col-12 col-md-7">

			<div class="form wow fadeIn">
				<?php contactFormExternal(); ?>   
			</div>			

		</div>
	</div>

</div></section>
<?php

}