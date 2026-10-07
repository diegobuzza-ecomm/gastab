<?php

function module_links($page_id = '') {
    global $lang, $post;

    if ($page_id == '') {
        $page_id = $post->ID;
    }

    $links = get_field('links', $page_id);

    // Verificar si el campo es clonado
    $links = (is_array($links) && isset($links['links'])) ? $links['links'] : $links;

?>
<section class="section module-links py-0"><div class="container">
    <div class="row items gy-3 justify-content-center">            
        <?php $i=0; foreach ($links['items'] as $v): $i++; ?>
            <div class="item col-md-3 <?= ($page_id == 2) ? 'col-lg-3' : 'col-lg-2'; ?>  wow fadeIn" data-wow-delay="0.<?= $i ?>s">
                <article><a href="<?= $v['url'] ?>"> </a>
                    <div class="icon mb-3" >
                        <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                    </div>
                    <div class="data">
                        <h2><?= $v['title'] ?></h2>
                    </div>

                    
              </article>  
            </div>
        <?php endforeach; ?>
    </div>
</div></section>
<?php 

}
