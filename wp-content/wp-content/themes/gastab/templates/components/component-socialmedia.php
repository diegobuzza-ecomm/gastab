<?php

function component_socialmedia($page_id = ''){

	if (empty($page_id)){
		$page_id = get_page_id('contact');
	}

	$socialmedia = get_field('socialmedia', $page_id);

	if (empty($socialmedia)){
		return false;
	}

	ob_start();
?>
<ul class="socialmedia list-unstyled">
	<?php foreach ($socialmedia as $v):	?>
		<?php if (!empty($v['url'])): ?>
        <li class="<?= esc_attr($v['type']); ?>">
            <a href="<?= esc_url($v['url']); ?>" target="_blank" aria-label="<?= esc_attr($v['type']); ?>">
            	<?php 
					$v['type'] = $v['type'] == 'twitter' ? 'x-twitter' : $v['type'];
			        $v['type'] = $v['type'] == 'facebook' ? 'facebook-f' : $v['type'];
			        $v['type'] = $v['type'] == 'linkedin' ? 'linkedin' : $v['type'];
				?>
                <i class="fab fa-<?= esc_attr($v['type']); ?>"></i>
            </a>
        </li>
		<?php endif ?>
	<?php endforeach ?>
</ul>
<?php
	return ob_get_clean();
}