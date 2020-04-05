<?php

namespace Theme\Http\Controllers;

use Snap\Http\Request;
use Snap\Http\Response;

class Example
{
    public function index(Request $request, Response $response)
    {
        $response->view('index');
    }
}
