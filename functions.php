<?php
// Enqueue the parent and child theme stylesheets
function generatepress_child_enqueue_styles() {
    $parent_style = 'generatepress-style';

    wp_enqueue_style(
        $parent_style,
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'generatepress-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'generatepress_child_enqueue_styles');

// insert javascript code in between blog content
function insert_adsense_in_post_content($content) {
	if (is_single()) { // Check if it's a single blog post
		$paragraphs = explode('</p>', $content); // Split the content into paragraphs

		$ad_code = '<!-- Google AdSense code goes here --><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2149712258444821"
     crossorigin="anonymous"></script>'; // Replace with your AdSense code

		$paragraph_count = count($paragraphs);
		$middle_paragraph = ceil($paragraph_count / 2); // Calculate the middle paragraph

		// Insert the AdSense code after the middle paragraph
		if ($paragraph_count >= 2) {
			$paragraphs[$middle_paragraph - 1] .= $ad_code;
		}

		$content = implode('</p>', $paragraphs); // Reassemble the content with the AdSense code
	}

	return $content;
}

add_filter('the_content', 'insert_adsense_in_post_content');
