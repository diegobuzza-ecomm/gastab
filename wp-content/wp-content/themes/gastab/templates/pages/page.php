<div class="page internal">

	<!-- Content -->
	<section class="section content"><div class="container">

		<div class="title wow fadeIn">
			<h1><?php the_title(); ?></h1>
		</div>

		<article class="wow fadeIn">
			<?php while(have_posts()): the_post(); the_content(); endwhile; ?>
		</article>

	</div></section>

</div>