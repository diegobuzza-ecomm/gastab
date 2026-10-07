<?php

function module_cta($page_id = '') {
    global $lang, $post;

    if ($page_id == '') {
        $page_id = $post->ID;
    }

    $cta = get_field('cta', $page_id);

    // Verificar si el campo es clonado
    $cta = (is_array($cta) && isset($cta['cta'])) ? $cta['cta'] : $cta;

?>
<section class="module-cta" style="background-image: url('<?= $cta['image']['url']; ?>')"><div class="container">

    <?php if ($cta['video']['url'] != ''): ?>
        <video playsinline autoplay muted loop poster="<?= $cta['image']['url']; ?>">
            <source src="<?= $cta['video']['url']; ?>" type="video/mp4">
        </video>
    <?php endif ?>
    
    <div class="title mx-auto text-center mb-0 wow fadeIn">
        <?= !empty($cta['title']) ? "<h2>{$cta['title']}</h2>" : ''; ?>
        <?= !empty($cta['description']) ? "<p>{$cta['description']}</p>" : ''; ?>

        <a href="<?= $cta['url']; ?>" class="btn btn-primary"><?= $cta['button']; ?></a>
    </div>

</div></section>

<?php 

}
