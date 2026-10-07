<?php global $lang;

$content = array(
	'title' => $lang == 'es' ? 'Página no encontrada' : 'Page not found' ,
	'description' => $lang == 'es' ? 'Por favor revisa la URL' : 'Please check the url',
	'button' => $lang == 'es' ? 'Volver al inicio' : 'Back to home',
	'url' => get_bloginfo('url'),
);

?>
<div class="page page-404">

	<!-- Content -->
	<section class="section content"><div class="container">

		<div class="title text-center wow fadeIn">
			<h1>Error 404 | <?= $content['title']; ?></h1>
			<p><?= $content['description']; ?>.</p>

			<div class="buttons mt-5">
				<a href="<?= $content['url']; ?>" class="btn btn-primary" aria-label="<?= $content['button']; ?>">
					<?= $content['button']; ?>
				</a>
			</div>
		</div>

	</div></section>

</div>