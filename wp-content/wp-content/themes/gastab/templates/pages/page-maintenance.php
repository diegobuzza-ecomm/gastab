<?php global $lang;

// Contact
$contact_id = get_page_id('contact');
$socialmedia = component_socialmedia();

// Fields
$content = [
	'title' => $lang == 'es' ? 'Ya volvemos' : 'We back soon!',

	'description' => $lang == 'es' ? 
		'El sitio se encuentra en mantenimiento, porfavor intenta mas tarde.' :
		'The website in under maintenance, please try later.',

	'button' => $lang == 'es' ? 'Volver al inicio' : 'Back to home',
	'url' => get_bloginfo('url'),
];

?>
<div class="page page-maintenance">

	<!-- Content -->
	<section class="section content"><div class="container">

		<div class="title text-center wow fadeIn">
			<div class="logo mb-5">
				<img src="<?= get_bloginfo('template_url') ?>/assets/img/logo.png" width="200px" alt="<?= get_bloginfo('name'); ?>" class="img-fluid">
			</div>

			<h3><?= $content['title']; ?></h3>
			<p><?= $content['description']; ?></p>

			<?= $socialmedia; ?>
		</div>

	</div></section>

</div>
<style>
	.header,
	.footer{
		display: none;
	}
</style>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    var elements = document.querySelectorAll('.header, .footer');

    elements.forEach(function(element) {
        element.remove();
    });
});
</script>