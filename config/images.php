<?php

return [
	/**
     * The default upload quality of image media.
     *
     * Smaller numbers give smaller uploaded image sizes, but with reduced image quality.
     * Setting to 100 will actually increase uploaded image size!
     *
     * @var int
     */
    'default_image_quality' => 75,

    /**
     * The location of the placeholder directory relative to the current theme folder.
     *
     * Set to false to not use placeholders.
     *
     * @var string|false
     */
	'placeholder_dir' => 'public/images/placeholders/',

	/**
	 * An array of post types to enable featured images for.
     *
	 * Set to false to remove thumbnail support entirely, true to allow for all post types.
     *
     * @var array|bool
	 */
	'supports_featured_images' => true,

    /**
     * Removes any rewrite rules associated with attachments.
     *
     * You may need to save permalinks for this to take effect.
     *
     * @var bool
     */
    'disable_attachment_permalinks' => true,

    /**
     * Defines all image sizes for the site.
     *
     * If the value for a size is false, that image size is unregistered. This is useful for killing image sizes created by plugins.
     * If you define an existing image size, then your options here will override the default.
     *
     * @var array {
     *     The array key is the image size for use within your theme, and the value is an array as follows:
     *
     *     @var int        Image width.
     *     @var int        Image height.
     *     @var bool|array Whether to crop the image.
     *     @var string     Dropdown name. The name of this image size when being inserted into a post.
     *                     If not provided, then the size is not available from the image sizes dropdown.
     * }
     */
    'image_sizes' => [
        // Unset these default sizes as they aren't really needed
        'medium' => false,
        'medium_large' => false,
        'large' => false,

        // This is a full column width image for inserting into pages/posts.
        'post_full_width' => [760, 0, false, 'Full Width Image'],
    ],

    /**
     * These image sizes are NOT generated for all images upon upload.
     *
     * Instead they are generated only when the size is requested for a given image.
     * They will not appear in the editor dropdown for insertion by users, and do not need a dropdown name.
     *
     *  If this is not false, then sizes declared in image_sizes without a dropdown name will be treated as dynamic sizes
     *  and not generated automatically.
     *
     * @var array|bool
     */
    'dynamic_image_sizes' => [
        'post_featured_image' => [760, 468, true]
    ],

    /**
     * The default size selected when a user is inserting an image into a post via the editor.
     *
     * @var string
     */
    'insert_image_default_size' => 'post_full_width',

    /**
     * Whether the full uploaded image size is available to a user when inserting an image.
     *
     * @var bool
     */
    'insert_image_allow_full_size' => true,
];
