<?php global $lang;

$content = [
	'title' => $lang == 'es' ? 'No se encontraron resultados' : 'No results found',
];

?>
<div class="error error-noresults">
	<p><?= $content['title']; ?></p>
</div>