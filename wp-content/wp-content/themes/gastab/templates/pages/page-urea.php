<?php global $lang;

$page_id = get_page_id('urea');

$about = get_field('about', $page_id);

?>
<div class="page urea">
   
	<!-- Banner -->
	<?php module_banner(); ?>

	<!-- About -->
	<section class="section about module"><div class="container">
		<div class="row justify-content-between align-items-center">            
            <div class="col-md-5 order-md-2">

                <div class="image">
                    <div class="circle wow fadeInRight">
                        <?php echo wp_get_attachment_image($about['image']['ID'], 'full', false, array('class' => 'img-fluid', 'loading' => 'lazy')); ?>
                    </div>
                    <span class="arrow right wow fadeInLeft"></span>                    
                </div>                
                
            </div>
            <div class="col-md-6">
                
                <div class="title wow fadeInUp">
                    <p class="subtitle"><?= $about['subtitle'] ?></p>
                    <h3><?= $about['title'] ?></h3>
                    <div class="description max-width mt-3">
                        <?= $about['description'] ?>
                    </div>
                </div>

            </div>
        </div>
		
	</div></section>

	<!-- Delivery -->
	<?php module_delivery(); ?>


	<!-- Contact -->
	<?php module_contact($page_id); ?>

</div>
