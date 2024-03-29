<?php

return [
    /**
     * Completely disable all custom colors including gradients, text, and background color selectors.
     */
    'disable_custom_colors' => true,

    /**
     * Completely disable user font size choice on paragraph blocks.
     */
    'disable_custom_font_sizes' => true,

    /**
     * Disable the typography features.
     */
    'disable_typography_features' => [
        'drop_cap' => true,
        'font_style' => true,
        'letter_spacing' => true,
        'text_transform' => true,
    ],

    /**
     * Disable the gutenberg block directory search feature.
     *
     * Useful if you do not want third party blocks installed.
     */
    'disable_block_directory' => true,

    /**
     * Disable the block library CSS injected into the frontend to add default block styles.
     */
    'disable_block_library_css' => true,

    /**
     * Completely disable all built in block styles.
     *
     * Styles manually registered via register_block_style will still be present.
     */
    'disable_default_block_styles' => true,

    /**
     *
     */
    'simplify_image_size_controls' => true,

    /**
     * Completely disable block patterns. (WordPress >= 5.5)
     */
    'disable_block_patterns' => true,

    /**
     * If block patterns are not disabled, use this setting to optionally unregister extraneous block patterns.
     */
    'disabled_block_patterns' => [
        //'core/text-two-columns',
        //'core/two-buttons',
        //'core/two-images',
        //'core/text-two-columns-with-images',
        //'core/text-three-columns-buttons',
        //'core/large-header',
        //'core/large-header-button',
        //'core/three-buttons',
        //'core/heading-paragraph',
        //'core/quote',
    ],

    /**
     * Restrict available blocks by post type.
     *
     * Set the value to true, '*' or an empty array to allow all.
     * You can also do a basic glob match to enable a whole namespace E.G. 'acf/*' to enable all acf blocks.
     */
    'enabled_blocks' => [
        'post' => [
            'core/heading',
            'core/paragraph',
            'core/list',
            'core/list-item',
            'core/embed',
            'core/image',
            'core/gallery',
            'acf/*'
        ],
        'page' => [
            'core/heading',
            'core/paragraph',
            'core/list',
            'core/list-item',
            'core/embed',
            'core/image',
            'core/gallery',
            'acf/*'
        ],
    ],

    /**
     * When enabled, blocks found in resources/views/blocks will be automatically registered, and the editor.scss will be enqueued.
     *
     * @see \Theme\Hookables\Gutenberg
     */
    'enable_acf_blocks' => true
];