<?php global $lang;

$page_id = get_page_id('about');

$about = get_field('about', $page_id);
$energy = get_field('energy', $page_id);
$solutions = get_field('solutions', $page_id);
$services = get_field('services', $page_id);
$delivery = get_field('delivery', $page_id);
$benefits = get_field('benefits', $page_id);
$about = get_field('about', $page_id);


?>
<div class="page about">

	<?php module_banner(); ?>

	<!-- About -->
	<section class="section about module"><div class="container">
		<div class="row justify-content-between align-items-center g-4">
             <div class="col-md-5 order-md-2">

                <div class="image">
                    <div class="circle wow fadeInRight">
                        <?php echo wp_get_attachment_image($about['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>
                    <span class="arrow right wow fadeInLeft"></span>                    
                </div>
                
                
            </div>
            <div class="col-md-6 order-md-1">
                
                <div class="title wow fadeInUp">
                    <p class="subtitle"><?= $about['subtitle'] ?></p>
                    <h3><?= $about['title'] ?></h3>
                    <p class="description max-width"><?= $about['description'] ?></p>
                     <a href="<?= $about['url'] ?>" class="btn btn-primary"><?= $about['button'] ?></a>
                </div>

            </div>
           
        </div>
		
	</div></section>

	<!-- Energy -->
	<section class="section energy module bg-light pb-0"><div class="container">
		<div class="row justify-content-between align-items-center g-4">
            <div class="col-md-5">

                <div class="image">
                    <div class="circle wow fadeInLeft">
                        <?php echo wp_get_attachment_image($energy['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>
                    <span class="arrow right wow fadeInLeft"></span>                    
                </div>
                
                
            </div>
            <div class="col-md-6">
                
                <div class="title wow fadeInUp">
                    <p class="subtitle"><?= $energy['subtitle'] ?></p>
                    <h3><?= $energy['title'] ?></h3>
                    <p class="description max-width"><?= $energy['description'] ?></p>
                </div>

            </div>            
        </div>		
	</div></section>

	<!-- Solutions -->
	<section class="section solutions bg-light"><div class="container">

		<div class="title text-center wow fadeIn">
			<p><?= $solutions['title'] ?></p>
		</div>

		<div class="row items">
			
			<?php $i=0; foreach ($solutions['items'] as $v): $i++; ?>
                <div class="item col-6 col-md-3 col-lg-2 wow fadeIn" data-wow-delay="0.<?= $i ?>s">

                    <article class="text-center">
                        <div class="icon mb-3" >
                            <img src="<?= $v['icon']['url'] ?>" width="<?= $v['icon']['width'] / 2; ?>" class="img-fluid">
                        </div>
                        <div class="data">
                            <h6><?= $v['title'] ?></h6>
                        </div>                            
                   </article>  
                </div>
            <?php endforeach; ?>
		</div>
	</div></section>


	<!-- Services -->
	<section class="section services module"><div class="container">
		<div class="row justify-content-between align-items-center">
              <div class="col-md-5 order-md-2">

                <div class="image">

                    <div class="circle wow fadeInRight">
                        <?php echo wp_get_attachment_image($services['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>
                    <span class="arrow right wow fadeInLeft"></span>
                    
                </div>
                
                
            </div>
            <div class="col-md-5 order-md-1">
                
                <div class="title">
                    <p class="subtitle"><?= $services['subtitle'] ?></p>
                    <h3><?= $services['title'] ?></h3>
                    <div class="description"><?= $services['description'] ?></div>
                </div>

            </div>
          
        </div>
		
	</div></section>


	<!-- Delivery -->
	<?php module_delivery(); ?>

	<!-- Benefits -->
	<?php module_benefits(); ?>

	<!-- Contact -->
	<?php module_contact(); ?>


</div>
