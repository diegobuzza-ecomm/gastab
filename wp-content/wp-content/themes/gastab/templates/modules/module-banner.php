<?php

function module_banner($page_id = '') {
    global $lang, $post;

    if ($page_id == '') {
        $page_id = $post->ID;
    }

    $banner = get_field('banner', $page_id);

    // Verificar si el campo es clonado
    $banner = (is_array($banner) && isset($banner['banner'])) ? $banner['banner'] : $banner;

?>
<header class="banner" style="background-image: url('<?= $banner['image']['url']; ?>')"><div class="container">
   
    <div class="title wow fadeIn">
        <?= !empty($banner['subtitle']) ? "<p class='subtitle'>{$banner['subtitle']}</p>" : ''; ?>
        <?= !empty($banner['title']) ? "<h1>{$banner['title']}</h1>" : ''; ?>
        <?= !empty($banner['description']) ? "<p>{$banner['description']}</p>" : ''; ?>
    </div>

</div></header>

<?php 

}
