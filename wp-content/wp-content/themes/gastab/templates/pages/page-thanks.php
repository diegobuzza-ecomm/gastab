<?php global $lang;
/*
Template Name: Thanks
*/

$content = get_field('content');

if ($content && empty($content['title'])){
	$content = [
		'title' => $lang == 'en' ? 'Thanks for reaching us' : 'Gracias por contactarnos',
		'description' => $lang == 'en' ? 'We will be in contact soon' : 'Pronto nos pondremos en contacto',
		'button' => $lang == 'en' ? 'Back to home' : 'Volver al inicio',
		'url' => get_bloginfo('url'),
	];
}

get_header(); ?>
<div class="page page-thanks">

	<!-- Content -->
	<section class="section content"><div class="container">

		<div class="title text-center wow fadeIn">
			<h1><?= $content['title']; ?></h1>
			<p><?= $content['description']; ?></p>

			<div class="buttons mt-5">
				<a href="<?= $content['url']; ?>" class="btn btn-primary"><?= $content['button']; ?></a>
			</div>
		</div>

	</div></section>

</div>
<?php get_footer(); ?>