<?php
namespace AmyMovie\Core;

class Media {
    /**
     * Download an image from the specified URL and attach it to a post.
     *
     * @since 2.6.0
     *
     * @param string $file The URL of the image to download
     * @param int    $post_id The post ID the media is to be associated with
     * @param string $desc Optional. Description of the image
     * @return string|WP_Error Populated HTML img tag on success
     */
    static function add_image_to_media_gallery($attachment_id, $file, $post_id = '', $desc = null) {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Set variables for storage, fix file filename for query strings.
        preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches);
        $file_array = array();
        $file_array['name'] = basename($matches[0]);

        // Download file to temp location.
        $file_array['tmp_name'] = download_url($file);

        // If error storing temporarily, return the error.
        if (is_wp_error($file_array['tmp_name'])) {
            @unlink($file_array['tmp_name']);
            echo 'is_wp_error $file_array: ' . $file;
            print_r($file_array['tmp_name']);
            return $file_array['tmp_name'];
        }

        // Do the validation and storage stuff.
        $id = media_handle_sideload($file_array, $post_id, $desc); // $id of attachement or wp_error

        // If error storing permanently, unlink.
        if (is_wp_error($id)) {
            @unlink($file_array['tmp_name']);
            echo 'is_wp_error $id: ' . $id->get_error_messages() . ' ' . $file;
            return $id;
        }

        update_post_meta($id, 'amy_hand_attachment', $attachment_id);

        return $id;
    }

    static function remove() {
        $args = [
            'post_type' => array('attachment'),
            'post_status' => 'inherit',
            'meta_key'  => 'amy_hand_attachment',
            'posts_per_page' => '-1',
        ];

        $query = new WP_Query($args);

        if (! empty($query->posts)) {
            foreach ($query->posts as $post) {
                $return_value = wp_delete_attachment($post->ID, true);
                if ($return_value === false) {
                    echo 'AmyMedia::remove - failed to delete image id:' . $post->ID ;
                }
            }
        }
    }

    static function get_by_amy_id($id) {
        $args = array(
            'post_type'         => array('attachment'),
            'post_status'       => 'inherit',
            'meta_key'          => 'amy_hand_attachment',
            'posts_per_page'    => '-1',
        );

        // @todo big problem here - we rely on the wp_cache from get_post_meta too much
        $query = new \WP_Query($args);
        if (! empty($query->posts)) {
            foreach ($query->posts as $post) {
                $current_id = get_post_meta($post->ID, 'amy_hand_attachment', true);
                if ($current_id == $id) {
                    return $post->ID;
                    break;
                }
            }
        }
        return false;
    }

    static function get_image_url_by_amy_id($id, $size = 'full') {
        $image_id = self::get_by_amy_id($id);
        if ($image_id !== false) {
            $attachement_array = wp_get_attachment_image_src($image_id, $size, false);
            if (! empty($attachement_array[0])) {
                return $attachement_array[0];
            }
        }
        return false;
    }
}
