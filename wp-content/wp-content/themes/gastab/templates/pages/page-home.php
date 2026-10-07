<?php global $lang;

$page_id = get_page_id('home');

// Fields
$presentation = get_field('presentation', $page_id);
$about = get_field('about', $page_id);
$benefits = get_field('benefits', $page_id);
$testimonial = get_field('testimonial', $page_id);
$resources = get_field('resources', $page_id);


$args = array(
    'post_type'=>'post',
    'posts_per_page' => 3,
    'paged' => $paged,
);

$loop = new WP_Query($args);

?>
<div class="page home">

    <!-- Presentation -->
    <section class="presentation">

       <div class="swiper slider">
            <div class="swiper-wrapper slides">
                <?php $i = 0; foreach ($presentation as $v): $i++; ?>
                <div class="swiper-slide slide-<?= $i ?>">


                   <video playsinline autoplay muted loop poster="<?= $v['image']['url']; ?>">
                        <source src="<?= $v['video']['url']; ?>" type="video/mp4">
                    </video>

                    <div class="container">
                        <div class="title mb-0">
                            <?php if ($i == 1): ?>
                                <h1><?= $v['title'] ?></h1>
                            <?php else: ?>
                                <h2><?= $v['title'] ?></h2>
                            <?php endif ?>
                            
                            <p><?= $v['description'] ?></p>                            
                            <a href="<?= $v['url'] ?>" class="btn btn-primary"><?= $v['button'] ?></a>
                        </div>                        
                    </div>
                   

                </div>
                <?php endforeach; ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination left square"></div>
        </div>

    </section>


    <?php module_links($page_id); ?>

    <!-- About -->
    <section class="section module about"><div class="container">
        <div class="row justify-content-between align-items-center g-5">
            <div class="col-11 col-md-5 order-md-2">

                <div class="image">                   

                    <div class="circle bg-circles wow fadeInRight">
                        <?php echo wp_get_attachment_image($about['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>
                    <span class="arrow left wow fadeInRight"></span>

                     <div class="icon right wow fadeInUp">
                         <img src="<?= $about['icon_right']['url'] ?>" width="<?= $about['icon_right']['width'] / 2; ?>" class="img-fluid">
                    </div>

                    <div class="icon bottom right wow bounceIn">
                         <img src="<?= $about['icon_bottom']['url'] ?>" width="<?= $about['icon_bottom']['width'] / 2; ?>" class="img-fluid">
                    </div>
                    
                </div>
                
                
            </div>
            <div class="col-md-6 order-md-1">
                
                <div class="title wow fadeInUp">
                    <p class="subtitle"><?= $about['subtitle'] ?></p>
                    <h3><?= $about['title'] ?></h3>
                    <p class="description max-width"><?= $about['description'] ?></p>
                </div>

            </div>
            
        </div>
    </div></section>

    <!-- Benefits -->
    <section class="section benefits"> <div class="container-fluid px-0">
        <div class="row items g-0">
            <?php $i = 0; foreach ($benefits['items'] as $v): $i++; ?>
                <div class="item col-md-6 <?= ($i <= 4) ? 'col-lg-3' : 'col-lg-4'; ?> wow fadeIn">
                    <article>
                        <div class="thumbnail">
                            <?php echo wp_get_attachment_image($v['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                        </div>
                        <div class="data">
                            <div class="icon mb-3">
                                <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                            </div>
                            <h2><?= $v['title'] ?></h2>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div></section>


    <!-- Testimonial -->
    <section class="section testimonial"><div class="container">


        <div class="title max-width mx-auto text-center wow fadeIn">
            <h3><?= $testimonial['title'] ?></h3>
         </div>


        <div class="swiper">
            <div class="swiper-wrapper pb-5">
                 <?php $i = 0; foreach ($testimonial['items'] as $v): $i++; ?>
                <div class="item swiper-slide">
                    <article class="card"><a href="<?= $v['url'] ?>"></a>
                        <div class="icon mb-3">
                            <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                        </div>
                        <div class="data">                            
                            <h2><?= $v['title'] ?></h2>
                            <p><?= $v['description'] ?></p>
                            <span class="see-more">Leer más</span>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>

            </div>

            <div class="swiper-button-next chevron bottom right"></div>
            <div class="swiper-button-prev chevron bottom right"></div>
        </div>
    </div></section>

    <?php module_cta($page_id); ?>

    <!-- Resources -->
     <section class="section resources"><div class="container">

        <div class="title max-width mx-auto text-center wow fadeIn">
            <p class="subtitle"><?= $resources['subtitle'] ?></p>
            <h3><?= $resources['title'] ?></h3>
            <p class="description"><strong><?= $resources['description'] ?></strong></p>
         </div>

         <div class="feed-blog row g-5">
            <?php $i=0; while ($loop->have_posts()): $loop->the_post(); $i++;  ?>

            <div class="col-12 col-md-4 wow fadeIn" data-wow-delay="0.<?= $i; ?>s">
               <?php get_template_part('templates/loops/loop', 'blog'); ?>
            </div>              
            <?php endwhile; ?>
        </div>

        <div class="buttons text-center mt-5">
             <a href="<?= $resources['url'] ?>" class="btn btn-primary"><?= $resources['button'] ?></a>
        </div>
     </div></section>

    <?php module_contact(); ?>

</div>