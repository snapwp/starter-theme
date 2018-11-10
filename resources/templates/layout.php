<?php

// Include some partials we want on every request.
$this->partial('header');
$this->partial('navigation');

// Outputs the content of the current view template.
$this->output_view();

$this->partial('footer');