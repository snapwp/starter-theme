<?php

use Snap\Core\Snap;
use Snap\Services\Router;
use Snap\Services\View;

// We always want these partials, so put them here.
View::partial('header');
View::partial('navigation');

// Post-templates are a little bit more tricky as the view name needs to be dynamic.
Router::when(is_page_template())->view(get_page_template_slug());

Router::when(is_404())->view('404');

// If you prefer, you can also dispatch a controller action.
Router::dispatch('Example@index');

View::partial('footer');
