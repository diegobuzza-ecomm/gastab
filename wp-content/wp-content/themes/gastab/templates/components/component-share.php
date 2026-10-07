<?php

function component_share($post_id = ''){
    global $lang;

	if (empty($post_id)){
		$post_id = $post->ID;
	}

    $post_url = esc_url(get_permalink($post_id));
    $post_thumbnail = esc_url(wp_get_attachment_url(get_post_thumbnail_id($post_id)) ?? '');
    $post_title = esc_attr(get_the_title($post_id));

	ob_start();

?>
<ul class="list-unstyled">
    <li class="links">
        <a target="_blank" href="<?= $post_url; ?>" aria-label="Link">
            <i class="fa fa-chain"></i>
        </a>
    </li>
    <li class="twitter">
        <a target="_blank" href="https://twitter.com/share?url=<?= urlencode($post_url); ?>&text=<?= urlencode($post_title); ?>" aria-label="Twitter">
            <i class="fab fa-x-twitter"></i>
        </a>
    </li>
    <li class="facebook">
        <a target="_blank" href="https://www.facebook.com/sharer.php?u=<?= urlencode($post_url); ?>" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
    </li>
    <li class="pinterest">
        <a target="_blank" href="https://pinterest.com/pin/create/button/?url=<?= urlencode($post_url); ?>&media=<?= urlencode($post_thumbnail); ?>&description=<?= urlencode($post_title); ?>" aria-label="Pinterest">
            <i class="fab fa-pinterest"></i>
        </a>
    </li>
    <li class="linkedin">
        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($post_url); ?>&title=<?= urlencode($post_title); ?>" aria-label="LinkedIn">
            <i class="fab fa-linkedin"></i>
        </a>
    </li>
    <li class="whatsapp">
        <a target="_blank" href="https://wa.me/?text=<?= urlencode($post_url); ?>" aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </li>
</ul>
<?php
	return ob_get_clean();
}