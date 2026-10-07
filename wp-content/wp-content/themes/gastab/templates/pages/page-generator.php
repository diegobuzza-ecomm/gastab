<?php global $lang;

$page_id = get_page_id('generator');

$rental_sale = get_field('rental_sale', $page_id);
$preventive = get_field('preventive', $page_id);
$reports = get_field('reports', $page_id);
$solutions = get_field('solutions', $page_id);
$maintenance = get_field('maintenance', $page_id);

?>
<div class="page generator">

	<!-- Banner -->
	<?php module_banner(); ?>

	<!-- Links -->
	<?php module_links(); ?>


	<!-- Rental Sale -->
	<section class="section rental-sale module" id="<?= $rental_sale['id'] ?>"><div class="container">
		<div class="row justify-content-between align-items-center">
            <div class="col-md-6">
                
                <div class="title wow fadeInLeft">
                    <p class="subtitle"><?= $rental_sale['subtitle'] ?></p>
                    <h3><?= $rental_sale['title'] ?></h3>
                    <p class="description max-width"><?= $rental_sale['description'] ?></p>
                </div>

            </div>
            <div class="col-md-5">

                <?php $i=0; foreach ($rental_sale['items'] as $v): $i++; ?>
                    
                    <article class="no-card d-flex mb-3 wow fadeInUp" data-wow-delay="0.<?= $i ?>s">
                        <div class="icon" >
                            <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                        </div>
                        <div class="data">
                            <p><?= $v['title'] ?></p>
                        </div>
                   </article>  
                  
                <?php endforeach; ?>
                
                
            </div>
        </div>
		
	</div></section>


	<!-- Preventive -->
	<section class="section preventive module bg-light" id="<?= $preventive['id'] ?>"><div class="container">
		
        <div class="title text-center mx-auto max-width-lg wow fadeInUp">
            <p class="subtitle"><?= $preventive['subtitle'] ?></p>
            <h3><?= $preventive['title'] ?></h3>
            <p class="description max-width"><?= $preventive['description'] ?></p>
        </div>

   
        <div class="row items">

            <?php $i=0; foreach ($preventive['items'] as $v): $i++; ?>
                <div class="item col-md-4 wow fadeInUp" data-wow-delay="0.<?= $i ?>s">
                    <article class="card">
                        <div class="icon" >
                            <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                        </div>
                        <div class="data">
                        	<h4><?= $v['title'] ?></h4>
                            <p><?= $v['description'] ?></p>
                        </div>
                   </article>  
                </div>
            <?php endforeach; ?>
		
	</div></section>


	<!-- Reports -->
	<section class="section reports module bg-light" id="<?= $reports['id'] ?>"><div class="container">
		<div class="row justify-content-between align-items-center">
			<div class="col-md-5 order-md-2">

                <div class="image">

                    <div class="circle">
                        <?php echo wp_get_attachment_image($reports['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>
                    <span class="arrow right wow fadeInLeft"></span>
                    
                </div>
                
                
            </div>
            <div class="col-md-6 order-md-1">
                
                <div class="title">
                    <p class="subtitle"><?= $reports['subtitle'] ?></p>
                    <h3><?= $reports['title'] ?></h3>
                    <p class="description max-width"><?= $reports['description'] ?></p>
                    <a href="<?= $reports['url'] ?>" class="btn btn-primary"><?= $reports['button'] ?></a>
                </div>

            </div>            
        </div>		
	</div></section>

	<!-- Solutions -->
	<section class="section solutions module" id="<?= $solutions['id'] ?>"><div class="container">
		<div class="row justify-content-between align-items-center">
			<div class="col-md-5">

                <div class="image">
                    <div class="circle wow fadeInLeft">
                        <?php echo wp_get_attachment_image($solutions['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>
                    <span class="arrow right wow fadeInLeft"></span>                    
                </div>                
                
            </div>
            <div class="col-md-6">
                
                <div class="title">
                    <p class="subtitle"><?= $solutions['subtitle'] ?></p>
                    <h3><?= $solutions['title'] ?></h3>
                    <p class="description max-width"><?= $solutions['description'] ?></p>
                </div>

                <div class="row items">
                	 <?php $i=0; foreach ($solutions['items'] as $v): $i++; ?>
		                <div class="item col-md-4 wow fadeIn" data-wow-delay="0.<?= $i ?>s">
		                    <article>
		                        <div class="icon mb-3" >
		                            <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
		                        </div>
		                        <div class="data">
		                        	<h6><?= $v['title'] ?></h6>
		                            <p><?= $v['description'] ?></p>
		                        </div>
		                   </article>  
		                </div>
		            <?php endforeach; ?>
                </div>

            </div>            
        </div>		
	</div></section>
	

    <!-- Maintenance -->
    <section class="section maintenance module bg-light" id="<?= $preventive['id'] ?>"><div class="container">
        
        <div class="title text-center mx-auto max-width-lg wow fadeInUp">
            <p class="subtitle"><?= $maintenance['subtitle'] ?></p>
            <h3><?= $maintenance['title'] ?></h3>
            <p class="description max-width"><?= $maintenance['description'] ?></p>
        </div>

   
        <div class="row items g-3">

            <?php $i=0; foreach ($maintenance['items'] as $v): $i++; ?>
                <div class="item col-md-4 wow fadeInUp" data-wow-delay="0.<?= $i ?>s">
                    <article class="card">
                        <div class="icon" >
                            <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                        </div>
                        <div class="data">
                            <h4><?= $v['title'] ?></h4>
                            <p><?= $v['description'] ?></p>
                        </div>
                   </article>  
                </div>
            <?php endforeach; ?>
        
    </div></section>


	<!-- Benefits -->
	<?php module_benefits(); ?>

   	<!-- Contact -->
	<?php module_contact($page_id); ?>

</div>
