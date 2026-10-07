<?php

function module_delivery($page_id = '') {
    global $lang, $post;

    if ($page_id == '') {
       $page_id = get_page_id('about');
    }

    $delivery = get_field('delivery', $page_id);    

?>

<section class="section module-delivery bg-light" id="entregas"><div class="container">

        <div class="title text-center">
            <h3><?= $delivery['title'] ?></h3>
        </div>

        <div class="row items g-3">
            
            <?php $i=0; foreach ($delivery['items'] as $v): $i++; ?>
                    <div class="item col-md-6 wow fadeIn" data-wow-delay="0.<?= $i ?>s">
                        <article class="card text-center">
                            <div class="icon mb-3" >
                                <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                            </div>
                            <div class="data">
                                <h2><?= $v['title'] ?></h2>
                                <p><?= $v['description'] ?></p>
                                <a href="<?= $v['url'] ?>"  class="btn btn-primary" <?= $i == 2 ? 'target="_blank"' : '' ?> ><?= $v['button'] ?></a>
                            </div>
                       </article>  
                    </div>
                <?php endforeach; ?>
        </div>
    </div></section>
<?php 

}
