<?php global $lang;

$page_id = get_page_id('blog');

// Terms
$queried_term = get_queried_object();

$categories = get_terms(array('taxonomy' => 'category'));

// Loop query
$paged = $_POST['paged'] ?? (get_query_var('paged') ?: 1);

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 24,
    'paged' => $paged,
);

if (is_category()){
    $args['cat'] = $queried_term->term_id;
}

if (is_tag()){
    $args['tag'] = $queried_term->slug;
}

if (is_search()){
    $args['s'] = get_search_query();
}

$loop = new WP_Query($args);
$total_pages = $loop->max_num_pages;
$current_page = max(1, get_query_var('paged'));

?>
<div class="page blog">
    
    <!-- Feed -->
    <section class="section feed"><div class="container">

        <?php if ($loop->have_posts()): ?>

        <div class="feed-blog row g-5">
            <?php $i=0; while ($loop->have_posts()): $loop->the_post(); $i++; ?>
                <div class="item col-12 col-md-6 col-lg-4 wow fadeIn">
                	<?php get_template_part('templates/loops/loop', 'blog'); ?>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($total_pages > 1): ?>
        <div class="pagination wow fadeIn">
            <?= paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => '/page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text' => '<i class="fas fa-angle-left"></i>',
                'next_text' => '<i class="fas fa-angle-right"></i>',
            )); ?>
        </div>
        <?php endif; ?>

        <?php else: get_template_part('templates/errors/error', 'noresults'); endif ?>

    </div></section>


	<!-- Contact -->
	<?php module_contact(); ?>

</div>