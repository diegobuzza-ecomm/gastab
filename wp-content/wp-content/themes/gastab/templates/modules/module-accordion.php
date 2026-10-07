<?php

function module_accordion($page_id = ''){
	global $lang;

    if ($page_id == ''){
        $page_id = $post->ID;
    }

    $accordion = get_field('accordion', $page_id);

    $accordion = (is_array($accordion) && isset($accordion['accordion'])) ? $accordion['accordion'] : $accordion;

    if ($accordion) {

?>
<section class="section module-accordion"><div class="container">

	<div class="title max-width wow fadeIn">
		<?= !empty($accordion['subtitle']) ? "<p class='subtitle'>{$accordion['subtitle']}</p>" : ''; ?>
        <?= !empty($accordion['title']) ? "<h3>{$accordion['title']}</h3>" : ''; ?>
        <?= !empty($accordion['description']) ? "<p class='description'>{$accordion['description']}</p>" : ''; ?>
	</div>

	<div class="items" id="accordion">
		<?php $i=0; foreach ($accordion['items'] as $v): $i++; ?>
		<div class="item wow fadeIn" data-wow-delay="0.<?= $i ?>s">
			<a href="#answer<?=$i ?>" data-bs-toggle="collapse" class="question" aria-controls="#answer<?= $i ?>">
				<?= $v['title']; ?>
			</a>

			<div class="answer collapse" id="answer<?=$i ?>" data-bs-parent="#accordion">
				<?= $v['description']; ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

</div></section>
<?php 
    }
}

?>