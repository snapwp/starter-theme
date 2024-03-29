<?php

if (defined('SNAP_DOING_COMMAND') && SNAP_DOING_COMMAND) {
    return;
}

include('vendor/autoload.php');
include('theme/helpers.php');

/**
 * Let's kick this off!
 *
 * The following loads Snap core files into the container, parses config and gets everything ready.
 */
try {
    Snap\Core\Snap::setup();
} catch (Exception $e) {
    wp_die('Could not start snap: ' . $e->getMessage());
}
