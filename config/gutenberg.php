<?php

return [
    /**
     * Completely disable all custom colors including gradients, text, and background color selectors.
     *
     * @var bool
     */
    'disable_custom_colors' => true,

    /**
     * Completely disable user font size choice on paragraph blocks.
     *
     * @var bool
     */
    'disable_custom_font_sizes' => true,

    /**
     * Disable the paragraph "dropCap" feature.
     *
     * @var bool
     */
    'disable_drop_cap' => true,

    /**
     * Disable the gutenberg block directory search feature.
     *
     * Useful if you do not want third party blocks installed.
     *
     * @var bool
     */
    'disable_block_directory' => true,

    /**
     * Completely disable block patterns. (WordPress >= 5.5)
     *
     * @var bool
     */
    'disable_block_patterns' => true,

    /**
     * If block patterns are not disabled, use this setting to optionally unregister extraneous block patterns.
     *
     * @var array
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
     * Remove blocks from the inserter so they cannot be used.
     *
     * This differs from unregistering them, as this can cause fatal client errors if the block has already been used.
     *
     * @var array
     */
    'disabled_blocks' => [
        /*
         * Core text blocks
         */
        //'core/paragraph',
        //'core/heading',
        //'core/list',
        //'core/quote',
        //'core/code',
        //'core/preformatted',
        'core/freeform',
        //'core/pullquote',
        //'core/table',
        'core/verse',

        /*
         * Core media blocks
         */
        //'core/image',
        //'core/gallery',
        //'core/audio',
        //'core/cover',
        //'core/file',
        //'core/media-text',
        //'core/video',

        /*
         * Core layout blocks
         */
        //'core/button',
        //'core/buttons',
        //'core/columns',
        //'core/column',
        //'core/group',
        //'core/more',
        //'core/nextpage',
        //'core/separator',
        //'core/spacer',


        /*
         * Core widget blocks
         */
        'core/shortcode',
        'core/archives',
        'core/calendar',
        'core/categories',
        'core/html',
        'core/latest-comments',
        'core/latest-posts',
        'core/rss',
        'core/search',
        'core/social-links',
        'core/social-link',
        'core/tag-cloud',

        /**
         * Core embed blocks
         */
        //'core/embed',
        //'core-embed/twitter',
        //'core-embed/youtube',
        //'core-embed/facebook',
        //'core-embed/instagram',
        //'core-embed/wordpress',
        //'core-embed/soundcloud',
        //'core-embed/spotify',
        //'core-embed/flickr',
        //'core-embed/vimeo',
        'core-embed/animoto',
        'core-embed/cloudup',
        'core-embed/collegehumor',
        'core-embed/crowdsignal',
        'core-embed/dailymotion',
        //'core-embed/imgur',
        'core-embed/issuu',
        //'core-embed/kickstarter',
        //'core-embed/meetup-com',
        //'core-embed/mixcloud',
        'core-embed/polldaddy',
        //'core-embed/reddit',
        'core-embed/reverbnation',
        'core-embed/screencast',
        'core-embed/scribd',
        //'core-embed/slideshare',
        'core-embed/smugmug',
        'core-embed/speaker',
        'core-embed/speaker-deck',
        //'core-embed/tiktok',
        //'core-embed/ted',
        //'core-embed/tumblr',
        'core-embed/videopress',
        'core-embed/wordpress-tv',
        'core-embed/amazon-kindle',
    ]
];