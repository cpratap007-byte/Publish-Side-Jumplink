
function show_post_publish_date() {
    return '<b>Published:</b> ' . get_the_date('F j, Y');
}
add_shortcode('publish_date', 'show_post_publish_date');


// dynamic toc

function dynamic_toc_shortcode() {
    global $post;
    $content = $post->post_content;
    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/', $content, $matches);

    if (empty($matches[1])) return '';

    $toc = '<div class="quick_link"><div class="h4">Jump to topic</div><ul class="info_list">';
    foreach ($matches[1] as $heading) {
        $slug = sanitize_title($heading);
        $toc .= '<li><a href="#' . $slug . '">' . $heading . '</a></li>';
    }
    $toc .= '</ul></div>';

    return $toc;
}
add_shortcode('dynamic_toc', 'dynamic_toc_shortcode');



function add_ids_to_h2($content) {
    return preg_replace_callback('/<h2>(.*?)<\/h2>/', function($matches) {
        $id = sanitize_title($matches[1]);
        return '<h2 id="' . $id . '">' . $matches[1] . '</h2>';
    }, $content);
}
add_filter('the_content', 'add_ids_to_h2');