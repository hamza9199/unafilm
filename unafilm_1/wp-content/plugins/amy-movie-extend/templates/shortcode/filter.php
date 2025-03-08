<?php
use AmyMovie\Movie\MovieHelpers;
use AmyMovie\Core\Transition;

$transition     = new Transition();
$movie_helper   = new MovieHelpers();

$show_filter    = $filter_var['show_filter'];
$filter_style   = $filter_var['filter_style'];
$show_sortby    = $filter_var['show_sortby'];
$filters        = $filter_var['filters'];
$filters        = explode(',', $filters);

$custom_fields  = $movie_helper->get_options_custom_fields();
?>

<?php if ($show_filter) : ?>
    <div class="filter-mv <?php echo esc_attr($filter_style); ?>">
        <form class="mv-filter-form" method="get">
            <?php if (!empty($filters)) : ?>
                <?php foreach ($filters as $filter) : ?>
                    <?php
                        $label      = '';
                        $taxonomy   = get_terms(array('taxonomy' => $filter));

                        if ($filter == 'amy_actor') {
                            $label = $transition->get_string_translate('Actor');
                        } else if ($filter == 'amy_director') {
                            $label = $transition->get_string_translate('Director');
                        } else if ($filter == 'amy_genre') {
                            $label = $transition->get_string_translate('Genre');
                        }

                        if (!empty($custom_fields)) {
                            foreach ($custom_fields as $field) {
                                if ($field['type'] == 'person' || $field['type'] == 'category') {
                                    $name 			= (isset($field['name']) && $field['name'] != '') ? $field['name'] : '';
                                    $singular_name 	= (isset($field['singular_name']) && $field['singular_name'] != '') ? sanitize_title($field['singular_name']) : sanitize_title($name);

                                    if ($filter == $singular_name) {
                                        $label = $field['name'];
                                    }
                                }
                            }
                        }
                    ?>
                    <label>
                        <select name="<?php echo esc_attr($filter); ?>">
                            <option value="all">
                                <?php echo $transition->get_string_translate('Select') . $label; ?>
                            </option>
                            <?php if (!empty($taxonomy)) : ?>
                                <?php foreach ($taxonomy as $tax) : ?>
                                    <?php $selected = (isset($_GET[$filter]) && $_GET[$filter] == $tax->term_id) ? 'selected' : ''; ?>
                                    <option value="<?php echo $tax->term_id; ?>" <?php echo $selected; ?>>
                                        <?php echo esc_attr($tax->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </label>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($show_sortby) : ?>
                <label>
                    <select class="amy-mv-sort" name="orderby">
                        <option value="default" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'default' ? 'selected' : ''); ?>>
                            <?php echo $transition->get_string_translate('Sort by'); ?>
                        </option>
                        <option value="_rating_average" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == '_rating_average' ? 'selected' : ''); ?>>
                            <?php echo $transition->get_string_translate('Rate'); ?>
                        </option>
                        <option value="_release" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == '_release' ? 'selected' : ''); ?>>
                            <?php echo $transition->get_string_translate('Release Date'); ?>
                        </option>
                        <option value="_amy_post_views_count" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == '_amy_post_views_count' ? 'selected' : ''); ?>>
                            <?php echo $transition->get_string_translate('Post Views'); ?>
                        </option>
                        <option value="title" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'title' ? 'selected' : ''); ?>>
                            <?php echo $transition->get_string_translate('Title'); ?>
                        </option>
                    </select>
                </label>
            <?php endif; ?>
        </form>
    </div>
<?php endif; ?>
