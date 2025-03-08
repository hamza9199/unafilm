<?php
/**
 * Plugin Name: Movie Title List
 * Description: A simple plugin that displays a list of movie titles using a shortcode, filtered by _start_date.
 * Version: 1.5
 * Author: Your Name
 * License: GPL2
 */

// Register the shortcode


function replace_spaces_with_dashes($string) {
    // Replace all spaces with dashes
    return str_replace(' ', '-', $string);
}
function movie_title_list_shortcode($atts) {
    // Set default attributes for the shortcode
    $atts = shortcode_atts(
        array(
            'posts_per_page' => 10, // Default number of movies to show
        ),
        $atts,
        'movie_title_list' // Shortcode name
    );

    // Query parameters
    $args = array(
        'post_type'      => 'amy_movie', // Custom post type for movies
        'posts_per_page' => $atts['posts_per_page'],
        'orderby'        => 'meta_value', // Order by _start_date
        'meta_key'       => '_start_date', // Sort by this meta key
        'order'          => 'ASC', // Ascending order for the start date
        'meta_query'     => array(
            array(
                'key'     => '_start_date',  // Custom field key for the start date
                'value'   => date('Y-m-d'), // Today's date
                'compare' => '>=',         // Start dates on or after today
                'type'    => 'DATE',
            ),
        ),
    );

    // The Query
    $movie_query = new WP_Query($args);

    // Start output buffering
    ob_start();

    $site_url = get_site_url();

    if ($movie_query->have_posts()) {
        echo '<ul class="movie-title-list">';
        $counter = 1; // Initialize the counter
        $site_url = get_site_url(); // Get the site URL
        
        while ($movie_query->have_posts()) {
            $movie_query->the_post();
            $movie_title = get_the_title(); // Get the movie title
            $movie_title=  str_replace('&#8211;',' ',$movie_title);
            $movie_url = $site_url . '/movie/' . str_replace(' ', '-', strtolower($movie_title)); 
            $movie_url = str_replace('--', '-',$movie_url); // Generate URL with dashes
    
            echo '<li>';
            echo '<span class="number">' . $counter . '</span>';
            echo '<a href="' . esc_url($movie_url) . '"><span class="title">' . esc_html($movie_title) . '</span></a>';
            echo '</li>';
    
            $counter++; // Increment the counter
        }
        echo '</ul>';
    } else {
        echo '<p>' . esc_html__('No movies found with the specified criteria.', 'movie-title-list') . '</p>';
    }
    
    

    // Reset post data after the custom query
    wp_reset_postdata();

    // Return the output of the query
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('movie_title_list', 'movie_title_list_shortcode');

// Enqueue the style for the movie list


function movie_title_list_styles() {
    wp_enqueue_style('movie-title-list', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'movie_title_list_styles');
