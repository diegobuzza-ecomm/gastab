<?php global $lang;

$post_id = get_the_ID();
$thumbnail_id = get_post_thumbnail_id();

$thumbnail_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : ''; 
$categories = get_the_category();
?>
<article>
    <a href="<?php the_permalink(); ?>"></a>

    <?php if ($thumbnail_id): ?>
        <picture class="thumbnail">
            <?= get_the_post_thumbnail($post_id, 'full', [
                'class' => 'img-fluid',
                'loading' => 'lazy',
                'alt' => esc_attr($thumbnail_alt),
            ]); ?>
        </picture>
    <?php endif; ?>

    <div class="data">
        <?php if (!empty($categories) && !is_wp_error($categories)): ?>
            <ul class="terms list-unstyled">
                <?php foreach ($categories as $category): ?>
                    <li><?= esc_html($category->name); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <h2><?php the_title(); ?></h2>
        <?php the_excerpt(); ?>
        
        <span class="see-more">Leer más</span>
    </div>
</article>
