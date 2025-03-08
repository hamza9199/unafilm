<?php
use AmyMovie\Core\Transition;

$transition = new Transition();

CSF::createSection(AMY_MOVIE_OPTION, [
    'title'     => esc_html__('Translation', 'amy-movie-extend'),
    'icon'      => 'fas fa-language',
    'id'        => 'transition',
    'fields'    => $transition->render_options()
]);