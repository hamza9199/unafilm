<?php
/**
 * Plugin Name: Movie Type List
 * Description: A simple plugin to display all movie types.
 * Version: 1.0
 * Author: Your Name
 */

// Hook to register the shortcode
function movie_type_list_shortcode() {
    ob_start();
    
 // Query to get all movie posts
 $args = array(
    'post_type'      => 'amy_movie',     // Target the amy_movie custom post type
    'posts_per_page' => -1,               // Retrieve all posts
    'fields'         => 'ID',            // Only get the post IDs
);

$movie_posts = new WP_Query($args);

// Array to hold all unique movie_type values
$movie_types = array();

if ($movie_posts->have_posts()) {
    // Loop through all movie posts
    while ($movie_posts->have_posts()) {
        $movie_posts->the_post();

        // Get the movie_type meta value for each post
        $movie_type = get_post_meta(get_the_ID(), 'movie_type', true);

        // If there is a value, add it to the array (avoid duplicates)
        if ($movie_type && !in_array($movie_type, $movie_types)) {
            $movie_types[] = $movie_type;
        }
    }
    wp_reset_postdata();
}

// Display the movie types
if (!empty($movie_types)) {
    echo '<ul class="movie-type-list">';
    foreach ($movie_types as $movie_type) {
        echo '<li><strong>' . esc_html($movie_type) . '</strong></li>';
    }
    echo '</ul>';
} else {
    echo '<p>No movie types found.</p>';
}

return ob_get_clean();
}

// Register the shortcode
add_shortcode('movie_type_list', 'movie_type_list_shortcode');
?>
