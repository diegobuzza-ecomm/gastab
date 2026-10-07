<?php global $lang;

$page_id = get_page_id('fuel');

$delivery = get_field('delivery', $page_id);
$fleet = get_field('fleet', $page_id);
$nautical = get_field('nautical', $page_id);
$onsite = get_field('onsite', $page_id);
$generator = get_field('generator', $page_id);
$filtration = get_field('filtration', $page_id);


?>
<div class="page fuel">

	<!-- Banner -->
	<?php module_banner(); ?>

	<!-- Links -->
	<?php module_links($page_id); ?>


	<!-- Delivery -->
	<section class="section delivery module" id="<?= $delivery['id'] ?>"><div class="container">
		<div class="row justify-content-between align-items-center g-5">
            <div class="col-md-6">
                
                <div class="title wow fadeInLeft">
                    <p class="subtitle"><?= $delivery['subtitle'] ?></p>
                    <h3><?= $delivery['title'] ?></h3>
                    <p class="description max-width"><?= $delivery['description'] ?></p>
                    <a href="<?= $delivery['url'] ?>" class="btn btn-primary"><?= $delivery['button'] ?></a>
                </div>

            </div>
            <div class="col-md-5">

                <?php $i=0; foreach ($delivery['items'] as $v): $i++; ?>
                    
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

	<!-- Fleet -->
	<section class="section fleet module bg-light" id="<?= $fleet['id'] ?>"><div class="container">
		<div class="row justify-content-between align-items-center g-5">
			<div class="col-md-5">

                 <div class="image">
                    <div class="circle wow fadeInLeft">
                        <?php echo wp_get_attachment_image($fleet['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>

                    <span class="arrow right wow fadeInLeft"></span>                    
                </div>   
                
            </div>
            <div class="col-md-6">
                
                <div class="title wow fadeInLeft">
                    <p class="subtitle"><?= $fleet['subtitle'] ?></p>
                    <h3><?= $fleet['title'] ?></h3>
                    <p class="description max-width"><?= $fleet['description'] ?></p>
                    <a href="<?= $fleet['url'] ?>" class="btn btn-primary"><?= $fleet['button'] ?></a>
                </div>

            </div>
            
        </div>

        <div class="row mt-5 g-3">
        	<?php $i=0; foreach ($fleet['items'] as $v): $i++; ?>
                <div class="col-12 col-md-4">
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
        </div>
		
	</div></section>

    <!-- On site -->
    <section class="section onsite module" id="<?= $onsite['id'] ?>"><div class="container">
        <div class="row justify-content-between align-items-center g-5">
            <div class="col-md-5">

                <div class="image">

                    <div class="circle bg-circles wow fadeInLeft">
                        <?php echo wp_get_attachment_image($onsite['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>

                    <span class="arrow left wow fadeInRight"></span>

                    <div class="icon top left wow fadeInUp">
                         <img src="<?= $onsite['icon_top']['url'] ?>" width="<?= $onsite['icon_top']['width'] / 2; ?>" class="img-fluid">
                    </div>

                    <div class="icon bottom right wow bounceIn">
                         <img src="<?= $onsite['icon_bottom']['url'] ?>" width="<?= $onsite['icon_bottom']['width'] / 2; ?>" class="img-fluid">
                    </div>
                    
                </div>
                
                
            </div>
            <div class="col-md-6">
                
                <div class="title wow fadeInUp">
                    <p class="subtitle"><?= $onsite['subtitle'] ?></p>
                    <h3><?= $onsite['title'] ?></h3>
                    <p class="description max-width"><?= $onsite['description'] ?></p>
                    <a href="<?= $onsite['url'] ?>" class="btn btn-primary"><?= $onsite['button'] ?></a>
                </div>

            </div>            
        </div>      
    </div></section>

    <!-- Generator -->
    <section class="section generator module bg-light" id="<?= $generator['id'] ?>"><div class="container">
        <div class="row justify-content-between align-items-center g-5">
            <div class="col-md-5 order-md-2">

                <div class="image">

                    <div class="circle bg-circles wow fadeInRight">
                        <?php echo wp_get_attachment_image($generator['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>
                    <span class="arrow left wow fadeInLeft"></span>

                    <div class="icon top left wow fadeInUp">
                         <img src="<?= $generator['icon_top']['url'] ?>" width="<?= $generator['icon_top']['width'] / 2; ?>" class="img-fluid">
                    </div>

                    <div class="icon bottom right wow bounceIn">
                         <img src="<?= $generator['icon_bottom']['url'] ?>" width="<?= $generator['icon_bottom']['width'] / 2; ?>" class="img-fluid">
                    </div>
                    
                </div>
                
                
            </div>
            <div class="col-md-6 order-md-1">
                
                <div class="title wow fadeInUp">
                    <p class="subtitle"><?= $generator['subtitle'] ?></p>
                    <h3><?= $generator['title'] ?></h3>
                    <p class="description max-width"><?= $generator['description'] ?></p>
                    <a href="<?= $generator['url'] ?>" class="btn btn-primary"><?= $generator['button'] ?></a>
                </div>

            </div>            
        </div>      
    </div></section>

    <!-- Filtration -->
    <section class="section filtration module" id="<?= $filtration['id'] ?>"><div class="container">
        <div class="row justify-content-between align-items-center g-5">
            <div class="col-md-5">

                <div class="image">

                    <div class="circle">
                        <?php echo wp_get_attachment_image($filtration['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>
                    <span class="arrow right wow fadeInLeft"></span>
                    
                </div>
                
                
            </div>
            <div class="col-md-6">
                
                <div class="title">
                    <p class="subtitle"><?= $filtration['subtitle'] ?></p>
                    <h3><?= $filtration['title'] ?></h3>
                    <div class="description max-width mt-3">
                        <?= $filtration['description'] ?>
                    </div>
                </div>  
            </div>          
        </div>      
    </div></section>

    <!-- CTA -->
    <?php module_cta($page_id); ?>	

	<!-- Nautical -->
	<section class="section nautical module bg-light" id="<?= $nautical['id'] ?>"><div class="container">
		<div class="row justify-content-between align-items-center g-5">
			<div class="col-md-5 order-md-2">

                <div class="image">

                    <div class="circle bg-circles wow fadeInRight">
                        <?php echo wp_get_attachment_image($nautical['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>

                    <span class="arrow left wow fadeInRight"></span>

                    <div class="icon top left wow fadeInUp">
                    	 <img src="<?= $nautical['icon_top']['url'] ?>" width="<?= $nautical['icon_top']['width'] / 2; ?>" class="img-fluid">
                    </div>

                    <div class="icon bottom right wow bounceIn">
                    	 <img src="<?= $nautical['icon_bottom']['url'] ?>" width="<?= $nautical['icon_bottom']['width'] / 2; ?>" class="img-fluid">
                    </div>
                    
                </div>
                
                
            </div>
            <div class="col-md-6 order-md-1">
                
                <div class="title wow fadeInUp">
                    <p class="subtitle"><?= $nautical['subtitle'] ?></p>
                    <h3><?= $nautical['title'] ?></h3>
                    <p class="description max-width"><?= $nautical['description'] ?></p>
                    <a href="<?= $nautical['url'] ?>" class="btn btn-primary"><?= $nautical['button'] ?></a>
                </div>

            </div>            
        </div>		
	</div></section>	

	<!-- Benefits -->
	<?php module_benefits(); ?>

	<!-- Delivery -->
	<?php module_delivery(); ?>	

	<!-- Contact -->
	<?php module_contact($page_id); ?>
</div>
