<?php

add_shortcode('user_pdfs', function () {
    if (!is_user_logged_in()) {
        return '<p>You must be logged in to view your PDFs.</p>';
    }

    $current_user = wp_get_current_user();
    $args = [
        'post_type' => 'user_pdfs',
        'meta_query' => [
            [
                'key' => 'username',
                'value' => $current_user->user_login,
                'compare' => '='
            ]
        ]
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        $output = '<div style="margin: 0; padding: 0; height: 100vh; overflow: hidden;">';
        while ($query->have_posts()) {
            $query->the_post();
            $pdf_link = get_post_meta(get_the_ID(), 'pdf_link', true);

            $output .= '<iframe src="' . esc_url($pdf_link) . '" style="width: 100%; height: 70vh; border: none;"></iframe>';
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return '';
    }
});




























