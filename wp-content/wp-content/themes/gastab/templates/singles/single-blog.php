<?php global $lang;

// Core
$post_id = get_the_ID();
$blog_id = get_page_id('blog');

$thumbnail_id = get_post_thumbnail_id();
$thumbnail_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : ''; 

// Terms
$categories = get_the_terms($post_id, 'category');
$tags = get_the_terms($post_id, 'post_tag');


// Fields


// Relateds
$relateds_args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'ignore_sticky_posts' => 1,
    'post__not_in' => array($post_id),
);

if ($categories){
    $relateds_args['category__in'] = array($categories[0]->term_id);
}

$relateds = new WP_Query($relateds_args);

?>
<script>
    $('.header .navigation .menu-blog').addClass('current-menu-item');
</script>
<div class="single blog">

    <!-- Content -->
    <section class="section content"><div class="container">

        <div class="row justify-content-center g-5">
            <div class="col-12 col-lg-10">

                <div class="title">

                    <a href="<?= get_permalink($blog_id); ?>" class="go-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="14" fill="none"><path stroke="#000" d="M17.823 7.3H1.333m0 0L6.475 1M1.333 7.3 6.475 13"/></svg> Volver
                    </a>

                    
                    <h1 class="mt-5"><?php the_title(); ?></h1>
                    <div class="excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </div>

                <aside class="meta">                  

                    <div class="share">
                        <p class="mb-0"><?= $lang == 'es' ? 'Compartir' : 'Share'; ?></p>
                        <?= component_share(); ?>
                    </div>


                </aside>

               <?php if ($thumbnail_id): ?>
                    <picture class="thumbnail">
                        <?= get_the_post_thumbnail($post_id, 'full', [
                            'class' => 'img-fluid mt-5',
                            'loading' => 'lazy',
                            'alt' => esc_attr($thumbnail_alt),
                        ]); ?>
                    </picture>
                <?php endif; ?>            

            </div>

             <div class="col-12 col-lg-8">

                 <article>
                    <?php while(have_posts()): the_post(); the_content(); endwhile; ?>
                </article>

             </div>
        </div>

    </div></section>


    <!-- Relateds -->
    <section class="section relateds pt-0"><div class="container">
        <hr class="pt-5">
        <div class="title wow fadeIn">
            <h4>Novedades relacionadas</h4>
        </div>

        <div class="feed-blog row">
            <?php while($relateds->have_posts()): $relateds->the_post(); ?>
            <div class="item col-12 col-md-6 col-lg-4 mb-3 wow fadeIn">
                <?php get_template_part('templates/loops/loop', 'blog'); ?>
             </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    </div></section>

</div>