
<?php get_header();

// Home
if (is_front_page() || is_page(get_page_id('home'))):
    get_template_part('templates/pages/page', 'home');

// Pages
elseif (is_page(get_page_id('contact'))):
    get_template_part('templates/pages/page', 'contact');

elseif (is_page(get_page_id('about'))):
    get_template_part('templates/pages/page', 'about');

elseif (is_page(get_page_id('fuel'))):
    get_template_part('templates/pages/page', 'fuel');

elseif (is_page(get_page_id('generator'))):
    get_template_part('templates/pages/page', 'generator');

elseif (is_page(get_page_id('lubricants'))):
    get_template_part('templates/pages/page', 'lubricants');

elseif (is_page(get_page_id('urea'))):
    get_template_part('templates/pages/page', 'urea');

elseif (is_page(get_page_id('thanks'))):
    get_template_part('templates/pages/page', 'thanks');

// Resources
    elseif (is_tag() || is_page(get_page_id('blog')) || is_archive() || is_search()):
        get_template_part('templates/pages/page', 'blog');

    elseif (is_single()):
        get_template_part('templates/singles/single', 'blog');


// Defaults
elseif (is_page()):
    get_template_part('templates/pages/page');

elseif (is_404()):
    get_template_part('templates/pages/page', '404');

endif;

get_footer();
?>
