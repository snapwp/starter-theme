<?php

use Snap\Services\Router;

Router::whenPostTemplate()->dispatchPostTemplate();

Router::when(is_404())->view('404');
Router::when(is_home())->view('home');
Router::when(is_search())->view('search');

// If you prefer, you can also dispatch a controller action.
Router::dispatch([\Theme\Http\Controllers\ExampleController::class, 'index']);