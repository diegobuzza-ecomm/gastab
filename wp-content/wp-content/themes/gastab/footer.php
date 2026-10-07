<?php global $lang;

$options = get_option('mati_theme_options');

// Contact
$contact_id = get_page_id('contact');
$contact = get_field('contact', $contact_id);


if (isset($contact['whatsapp']) && !empty($contact['whatsapp'])){
    $whatsapp = preg_replace('/[^0-9+]/', '', $contact['whatsapp']);

    $whatsapp = wp_is_mobile()
        ? 'whatsapp://send?phone=' . esc_attr($whatsapp)
        : 'https://wa.me/' . esc_attr(ltrim($whatsapp, '+'));
}


?>
</main>

<!-- Footer -->
<footer class="footer bg-dark text-light">

	<!-- Widgets -->
	<section class="widgets"><div class="container">

		<div class="row g-3">
			<div class="col-12 col-lg-3 wow fadeIn">

				<a href="<?= esc_url(home_url('/')); ?>" class="logo">
					<img src="<?= get_template_directory_uri() ?>/assets/img/logo-footer.png" alt="<?= get_bloginfo('name'); ?>" class="img-fluid">
				</a>

				<ul class="list-unstyled vias">
					<li class="phone">
						<div class="icon"></div>
						Pedidos las 24 hs:						
					    <?php
					    $phones = explode('/', $contact['phone']);
					    foreach ($phones as $phone):
					        $phone = trim($phone); 
					        $phone_href = preg_replace('/\D/', '', $phone);
					    ?>
					        <a href="tel:<?= $phone_href; ?>"><?= $phone; ?></a>
					    <?php endforeach; ?>
					</li>

					<li class="emergency">
						<div class="icon"></div>
						 Emergencias:
						<a href="tel:<?= preg_replace('/\s+/', '', $contact['0800']); ?>"><?= $contact['0800']; ?></a>					   
					</li>

					<li class="address">
						<div class="icon"></div>
					<?= $contact['address']; ?></li>	
				</ul>

			</div>
			<div class="col-12 col-lg-9 d-lg-flex justify-content-lg-end align-items-start wow fadeIn">

				<ul class="menu list-unstyled me-lg-3">
					<?php wp_nav_menu( array('theme_location' => 'footer', 'container' => '', 'items_wrap' => '%3$s')); ?>
				</ul>	

				<?= component_socialmedia(); ?>

			</div>
			
		</div>

		<div class="copyright row">
			<div class="col-md-6 d-md-flex align-items-start">
				<p class="mb-md-0">
					<?= date('Y'); ?> <?= get_bloginfo('name'); ?>. 
					<?= $lang == 'es' ? 'Todos los derechos reservados' : 'All rights reserved'; ?>.
				</p>

				<ul class="menu list-unstyled ms-md-5">
					<?php wp_nav_menu( array('theme_location' => 'legal', 'container' => '', 'items_wrap' => '%3$s')); ?>
				</ul>	

			</div>
			<div class="col-md-6 text-md-end">
				
				<p>Hecho con ❤️ por <a href="https://pragmativa.com/" target="_blank">Agencia Digital B2B</a></p>

			</div>
		</div>
	</div></section>

</footer>


<?php wp_footer(); ?>


<div id="pageloader"></div>

<?php if ($options['enable_whatsapp_icon'] && isset($contact['whatsapp']) && !empty($contact['whatsapp'])): ?>
<a class="btn-float btn-float-whatsapp" href="<?= $whatsapp ?>" target="_blank">
	<i class="fab fa-whatsapp"></i>
</a>
<?php endif ?>


</body>
</html>