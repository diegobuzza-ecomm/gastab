<?php

function module_benefits($page_id = '') {
    global $lang, $post;

    if ($page_id == '') {
       $page_id = get_page_id('about');
    }

    $benefits = get_field('benefits', $page_id);    

?>

<section class="section module-benefits"><div class="container">

    <div class="title text-center">
        <h4><?= $benefits['title'] ?></h4>
    </div>

    <div class="row items g-3">
        
        <?php $i=0; foreach ($benefits['items'] as $v): $i++; ?>
                <div class="item col-12 col-md-4 wow fadeIn" data-wow-delay="0.<?= $i ?>s">
                    <article class="card">
                        <div class="icon mb-3" >
                            <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                        </div>
                        <div class="data">
                            <h2><?= $v['title'] ?></h2>
                            <p><?= $v['description'] ?></p>                                
                        </div>
                   </article>  
                </div>
            <?php endforeach; ?>
    </div>
</div></section>
<?php 

}
