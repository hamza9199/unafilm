<?php
use AmyMovie\Movie\Movie;
use AmyMovie\Core\Transition;

$transition     = new Transition();
$single_movie   = new Movie();
?>
<div class="amy-shortcode amy-mv-ratelist <?php echo esc_attr($class); ?>">
    <div class="list-rate">
        <table>
            <tbody>
                <?php if (!empty($data)) : ?>
                    <?php foreach ($data as $i => $item) : ?>
                        <?php
                        $single_movie = new Movie();
                        $single_movie->set_movie($item->ID);

                        if ($pagination == true && $max >= 2 && $paged != 0) {
                            $number = $i + 1 + (($paged - 1) * $movie_number);
                        } else {
                            $number 	= $i + 1;
                        }

                        $average = $single_movie->get_rate_average();

                        if ($number < 9) {
                            $number = '0' . $number;
                        }

                        if ($i < 5) {
                            $cs = 'highlight';
                        } else {
                            $cs = '';
                        }
                        ?>
                        <tr class="<?php echo esc_attr($cs); ?>">
                            <td class="title">
                                <a href="<?php echo $single_movie->get_url(); ?>">
                                    <?php echo $number . '. ' . $single_movie->get_title(); ?>
                                </a>
                            </td>
                            <td class="turn">
                                <?php echo $single_movie->get_rate_total_count() . ' ' . $transition->get_string_translate('votes'); ?>
                            </td>
                            <td class="point">
                                <?php echo $average; ?>
                            </td>
                            <td class="star">
                                <ul class="mv-rating-stars">
                                    <li class="mv-current-rating" data-point="<?php echo round($average / 5, 2) * 100; ?>%"></li>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php
            if ($pagination == true && $max >= 2) {
                echo amy_movie_pagination(array('max_pages' => $max));
            }
        ?>
    </div>
</div>