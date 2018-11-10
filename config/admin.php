<?php

return [
	/**
     * Set to true to use the snap admin theme.
     *
     * As well as graphical changes, the admin theme also reorders the page menu link to be above posts, and cleans
     * the admin bar.
     *
     * @var bool
     */
    'snap_admin_theme' => true,


    /**
     * Output custom 'Built using' text in the admin footer.
     *
     * Set to false to output the Snap default text.
     *
     * @var false|string
     */
	'footer_text' => false,


	/**
	 * Whether to display the current WordPress version in the admin footer.
     *
     * @var bool
	 */
	'show_version' => true,


	/**
	 * Provide a css url to enqueue on the login screen.
     *
     * @var false|string
	 */
	'login_extra_css' => false,

	/**
	 * Set the logo link url on the login page.
     *
     * @var string
	 */
	'login_logo_url' => home_url(),
];