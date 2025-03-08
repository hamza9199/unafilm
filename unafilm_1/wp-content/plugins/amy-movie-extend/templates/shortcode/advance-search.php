<?php
use AmyMovie\Core\Transition;

$transition = new Transition();
?>

<div class="amy-shortcode amy-advance-search <?php echo esc_attr($data->class); ?>">
    <form role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
        <div class="search-inner">
            <div class="filters">
                <?php
                if ($data->filters) {
                    $filters = explode(',', $data->filters);

                    if (!empty($filters)) {
                        foreach ($filters as $filter) {
                            $filter = sanitize_title($filter);
                            $terms 	= get_terms(array('taxonomy' => $filter));
                            $tax	= get_taxonomy($filter);

                            echo '<select name="' . $filter . '_s">';
                            echo '<option value="">' . $transition->get_string_translate('Select') . ' ' . $tax->label . '</option>';
                            if (!empty($terms)) {
                                foreach ($terms as $term) {
                                    echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                                }
                            }

                            echo '</select>';
                        }
                    }
                }
                ?>
            </div>

            <input type="text" name="s" placeholder="<?php echo $transition->get_string_translate('Movie search'); ?>"/>
            <input type="hidden" name="post_type" value="advance_search" />
            <input type="submit" alt="Search" value="<?php echo $transition->get_string_translate('Go'); ?>" />
        </div>
    </form>
</div>