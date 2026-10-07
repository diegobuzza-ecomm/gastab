<?php

function module_clients($page_id = ''){
	global $lang;

	if ($page_id == ''){
        $page_id = 2;
    }

    $clients = get_field('clients', $page_id)['clients'];

?>
<section class="section module-clients"><div class="container">

	<div class="title wow fadeIn">
		<p class="subtitle"><?= $clients['subtitle'] ?></p>
		<h3><?= $clients['title'] ?></h3>
		<p><?= $clients['description'] ?></p>
	</div>
	
	<div class="slider swiper">
		<div class="slides swiper-wrapper items">
			<?php $i=0; foreach ($clients['items'] as $v): $i++; ?>
				<div class="slide swiper-slide item">
					<article>
					    <?= $v['url'] != '' ? '<a href="'. $v['url'] .'" target="_blank" rel="nofollow">' : ''; ?>
					    <img src="<?= $v['image']['url'] ?>"
					        alt="<?= $v['image']['alt']; ?>"
					        width="<?= $v['image']['width'] / 2 ?>"
					        height="<?= $v['image']['height'] / 2 ?>"
					        class="img img-fluid">
					    <?= $v['url'] != '' ? '</a>' : ''; ?>
					</article>

				</div>
			<?php endforeach; ?>			
		</div>

	</div>

	
</div></section>
<?php

}