<?php

function module_newsletter($page_id = ''){
	global $lang;

    if ($page_id == ''){
        $page_id = 3;
    }   

    $newsletter = get_field('newsletter', $page_id);

?>
<section class="section module-newsletter bg-primary text-light"><div class="container">

	<div class="row align-items-center">
		<div class="col-12 col-md-6 my-2 wow fadeIn">

			<div class="title m-0">
				<h3><?= $newsletter['title']; ?></h3>
				<p class="description"><?= $newsletter['description']; ?></p>
			</div>

		</div>
		<div class="col-12 col-md-6 my-2 wow fadeIn">

			<?php newsletterForm(); ?>
			
		</div>
	</div>

</div></section>
<?php

}