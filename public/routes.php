<?php

use Snap\Services\Router;

Router::whenPostTemplate()->dispatchPostTemplate();

Router::when(is_404())->view('404');

// If you prefer, you can also dispatch a controller action.
Router::dispatch('Example@index');