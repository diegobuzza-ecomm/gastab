<?php global $lang;

$contact_id = get_page_id('contact');
$contact = get_field('contact', $contact_id);


?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?= get_bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">

	<?php wp_head(); ?>

</head>
<body <?= is_front_page() || is_page(get_page_id('home')) ? 'class="home"' : ''; ?>>

<?php 
	$options = get_option('mati_theme_options');
    if (!empty($options['custom_body_code'])) {
        echo $options['custom_body_code'];
    }
?>

<!-- Header -->
<header class="header">

	<nav class="top-menu"><div class="container">
		<ul class="list-unstyled my-0">
			<li class="phone">
				<div class="icon"></div>				
			   <a href="tel:<?= preg_replace('/\s+/', '', $contact['0800']); ?>">Urgencias: <?= $contact['0800']; ?></a>
			   
			</li>

			<li class="contact">
			  	<div class="icon"></div>
			  	<a href="<?= get_permalink($contact_id); ?>">Solicitá un presupuesto</a>
			</li>
		</ul>
	</div></nav>

	<div class="container">

	<a href="<?= esc_url(home_url('/')); ?>" class="logo">
		<img src="<?= get_template_directory_uri() ?>/assets/img/logo.png" alt="<?= get_bloginfo('name'); ?>" class="img-fluid">
	</a>

	<div class="nav-menu" data-open="menu">
		<span class="menu-line"></span>
		<span class="menu-line"></span>
		<span class="menu-line"></span>
	</div>

	<!-- Navigation -->
	<nav class="navigation">

		<ul class="menu list-unstyled">
			<?php wp_nav_menu( array('theme_location' => 'header', 'container' => '', 'items_wrap' => '%3$s')); ?>
		</ul>

	</nav>

</div></header>


<!-- Main -->
<main class="main">