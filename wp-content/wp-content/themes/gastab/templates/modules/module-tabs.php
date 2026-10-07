<?php

function module_tabs($page_id = ''){
	global $lang;

    if ($page_id == ''){
        $page_id = $post->ID;
    }

    $tabs = get_field('tabs', $page_id);

    $tabs = (is_array($tabs) && isset($tabs['tabs'])) ? $tabs['tabs'] : $tabs;

    if ($tabs) {

?>
<section class="section module-tabs"><div class="container">

	<div class="title text-center wow fadeIn">
		<h3><?= $tabs['title']; ?></h3>
	</div>

	<div class="tabs tab_menu">

		<ul class="items nav wow fadeIn">
			<?php $i=0; foreach ($tabs['items'] as $v): $i++; ?>
			<li><a class="<?= $i == 1 ? 'active' : '' ?> item" data-bs-toggle="tab" href="#service-<?=$i ?>">
				<?= $v['title']; ?>					
			</a></li>
			<?php endforeach ?>
		</ul>

		<div class="tab-content wow fadeIn mt-3">
			<?php $i=0; foreach ($tabs['items'] as $v): $i++; ?>
			<div class="tab-pane fade <?= $i == 1 ? 'show active' : '' ?>" id="service-<?=$i ?>">
				<article class="row g-3 justify-content-around align-items-center">
					<div class="thumbnail col-md-6 ratio-4x3">
						<?php echo wp_get_attachment_image($v['image']['ID'], 'full', false, array('class' => ' img-fluid', 'loading' => 'lazy')); ?>
					</div>

					<div class="content col-md-5">
						<h2><?= $v['title']; ?></h2>
						<p><?= $v['description']; ?></p>
					</div>
				</article>
			</div>
			<?php endforeach ?>
		</div>

	</div>
		
</div></section>
<?php 
    }
}

?>