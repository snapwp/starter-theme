<?php

namespace Theme\Http\Controllers;

use Snap\Http\Request;
use Snap\Http\Response;

class ExampleController
{
    public function index(Request $request, Response $response): void
    {
        $response->view('index');
    }
}
