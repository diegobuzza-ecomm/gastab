<?php global $lang;

$page_id = get_page_id('lubricants');

$about = get_field('about', $page_id);

?>
<div class="page lubricants">

   	<!-- Banner -->
	<?php module_banner(); ?>



	<!-- About -->
	<section class="section about bg-light"><div class="container">

		 <div class="title max-width-lg mx-auto text-center">
            <p class="subtitle"><?= $about['subtitle'] ?></p>
            <h3><?= $about['title'] ?></h3>
            <p class="description"><?= $about['description'] ?></p>           
        </div>

        <div class="row items g-4">

        	 <?php $i=0; foreach ($about['items'] as $v): $i++; ?>
                    <div class="item col-md-6 wow fadeIn" data-wow-delay="0.<?= $i ?>s">
                        <article class="card text-center">
                            <div class="icon" >
                                <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                            </div>
                            <div class="data">
                                <h4><?= $v['title'] ?></h4>
                            </div>
                       </article>  
                    </div>
                <?php endforeach; ?>
        	
        </div>
			
	</div></section>


	<!-- Benefits -->
	<?php module_benefits(); ?>


	<!-- Contact -->
	<?php module_contact($page_id); ?>

</div>
