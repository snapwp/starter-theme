<?php

return [
    /**
     * Blocks all requests to xmlrpc.php with a 403, and removes the X-Pingback header.
     * XMLRPC is only really used these days if JetPack is installed, and can otherwise be a potential security hole.
     *
     * @var bool
     */
    'disable_xmlrpc' => true,

    /**
     * Stops logged out visitors discovering usernames via ?author=N, the REST API users endpoints,
     * the users sitemap and oEmbed author data.
     *
     * @var bool
     */
    'disable_user_enumeration' => true,

    /**
     * Disables application passwords, which allow logging in via HTTP basic auth over the REST API.
     * Only needed if external services connect to the site.
     *
     * @var bool
     */
    'disable_application_passwords' => true,

    /**
     * Replaces login and lost password errors which reveal whether a username or email exists with generic ones.
     *
     * @var bool
     */
    'generic_login_errors' => true,

    /**
     * Requires a logged in user for REST API requests.
     * Set to an array of namespaces to keep public, such as ['contact-form-7/v1'], or false to leave the API open.
     *
     * @var bool|string[]
     */
    'restrict_rest_api' => false,

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
    'disable_widgets_block_editor' => true,

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