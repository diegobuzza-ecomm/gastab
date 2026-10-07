<?php global $lang;

$top_args = array(
	'post_type' => 'post',
	'posts_per_page' => 3,
	// 'meta_key' => 'post_views_count',
	// 'orderby' => 'meta_value_num',
	// 'order' => 'DESC',
);

$top = new WP_Query($args);

?>
<aside class="sidebar">

	<!-- Sidebar section -->
	<div class="sidebar-section mb-5">
		<form action="<?= get_bloginfo('url'); ?>" class="searcher">
			<input type="text" name="s" class="form-control" placeholder="Buscador de notas">
			<i class="fas fa-search"></i>
		</form>
	</div>


	<!-- Sidebar section -->
	<div class="sidebar-section mb-4">

		<div class="title line">
			<h3><?= $lang == 'en' ? 'Most read<br> notes' : 'Notas<br> más leidas'; ?></h3>
		</div>

		<div class="feed-blog row">
			<?php while ($top->have_posts()): $top->the_post(); ?>
			<div class="col-12 my-2">
				<?php get_template_part('templates/loops/loop', 'related') ?>
			</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

	</div>

</aside>