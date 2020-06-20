<?php
/*
Template Name: Example Template
Template Post Type: post, page
*/
?>

This is just an example template which is never loaded into WordPress.

Use the comments block above to set:
* the human readable template name (what a user sees when choosing this template in the dropdown)
* what post types this template can be applied to. If left blank, it defaults to pages only

When a template is selected via the back end, the request is routed to index.php instead of the template file itself.
This means we can still use our main front controller to deal with requests and dispatching views