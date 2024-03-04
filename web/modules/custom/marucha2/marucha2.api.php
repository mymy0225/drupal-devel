<?php

/**
 *This is hello world hook.
 *
 * This hook arrow you to do_something.
 *  when node loaded using hook_ENTITY_TYPE_view().
 */
function hook_marucha2_hello_world() {
    \Drupal::messenger()->addStatus("hello world!");

}