<?php

include('vendor/autoload.php');

/**
 * Let's kick this off!
 *
 * The following loads Snap core files into the container, parses config and gets everything ready.
 */
try {
    Snap\Core\Snap::setup();
} catch (Exception $e) {
   \wp_die('Could not start snap: ' . $e->getMessage());
}
