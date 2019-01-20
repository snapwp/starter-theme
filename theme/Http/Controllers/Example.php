<?php

namespace Theme\Http\Controllers;

use Snap\Http\Request;
use Snap\Services\View;

class Example
{
    public function index(Request $request)
    {
        View::render('index');
    }
}
