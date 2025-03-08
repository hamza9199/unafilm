<?php
use AmyMovie\Core\Template;
use AmyMovie\Core\Transition;

$transition = new Transition();
$template = new Template();
?>
<div class="amy-movie-layout-list amy-movie-showtimews-daily-1 <?php echo $data->class; ?>">
    <div class="amy-showtimes-header">
        <div class="amy-showtimes-header-inner">
            <input type="hidden" value="<?php echo base64_encode(json_encode($data->params)); ?>" class="amy-param"/>
            <input type="hidden" value="<?php echo base64_encode(json_encode($data->option)); ?>" class="amy-option"/>
            <ul>
                <?php for ($i = 0; $i < $data->number_date; $i++) : ?>
                    <?php $date 	= strtotime($data->start_date . '+' . $i . ' days'); ?>
                    <li class="<?php echo ($i == 0) ? 'active' : ''; ?>">
                        <a href="javascript:void(0)" data-date="<?php echo date('d-m-Y', $date) ?>"
                           data-movie="<?php echo implode(',', $data->list_movie_id); ?>">
                            <span>
                                <?php echo date_i18n(get_option('date_format'), $date); ?>
                            </span>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>

    <div class="amy-movie-list">
        <div class="amy-movie-items">
            <?php
            if (!empty($data->list_movie_to_show)) {
                foreach ($data->list_movie_to_show as $movie) {
                    $data->movie = $movie;

                    $template
                        ->set_template_data($data)
                        ->get_template_part('/shortcode/single/v2-showtime-3');
                }

            } else {
                echo $transition->get_string_translate('No Movie');
            }
            ?>
        </div>
    </div>
</div>
