<?php

return [
    /**
     * If true sets the `xmlrpc_enabled` filter to return false.
     * XMLRPC is only really used these days if JetPack is installed, and can otherwise be a potential security hole.
     *
     * @var bool
     */
    'disable_xmlrpc' => true,

    /**
     * Disable comments site wide.
     *
     * @var bool
     */
    'disable_comments' => true,

    /**
     * Restores classic widget editing screen
     *
     * @var bool
     */
    'disable_widgets_block_editor' => false,

    /**
     * Disable the customizer in the admin.
     *
     * @var bool
     */
    'disable_customizer' => true,

    /**
     * Disable the loading=lazy attribute on images/video added via the editor.
     *
     * @var bool
     */
    'disable_lazy_loading' => false,
];