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
     * Disable the typography features.
     *
     * @var array<string, bool>
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
     *
     * @var bool
     */
    'disable_block_directory' => true,

    /**
     * Disable the block library CSS injected into the frontend to add default block styles.
     *
     * @var bool
     */
    'disable_block_library_css' => true,

    /**
     * Completely disable block patterns. (WordPress >= 5.5)
     *
     * @var bool
     */
    'disable_block_patterns' => true,

    /**
     * Completely disable all built in block styles.
     *
     * Styles manually registered via register_block_style will still be present.
     *
     * @var bool
     */
    'disable_default_block_styles' => true,

    /**
     *
     */
    'simplify_image_size_controls' => true,

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
        'core/code',
        'core/preformatted',
        'core/freeform', // classic block
        'core/pullquote',
        'core/table',
        'core/verse',

        /*
         * Media blocks
         */
        //'core/image',
        //'core/gallery',
        'core/audio',
        'core/cover',
        //'core/file',
        'core/media-text',
        //'core/video',

        /*
        * Design blocks
        */
        //'core/button',
        //'core/buttons',
        'core/columns',
        //'core/column',
        //'core/columns/one-column-full',
        //'core/columns/two-columns-equal',
        //'core/columns/two-columns-one-third-two-thirds',
        //'core/columns/two-columns-two-thirds-one-third',
        //'core/columns/three-columns-equal',
        //'core/columns/three-columns-wider-center',
        'core/group',
        //'core/group/group-row',
        //'core/group/group-stack',
        'core/more',
        'core/nextpage',
        //'core/separator',
        'core/spacer',
        'core/site-logo',
        'core/site-tagline',
        'core/site-title',
        'core/query-title',
        'core/post-terms',

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
        'core/page-list',
        'core/rss',
        'core/social-links',
        'core/social-link',
        'core/tag-cloud',
        'core/search',

        /**
         * Theme blocks
         */
        'core/query',
        'core/post-title',
        'core/post-content',
        'core/post-date',
        'core/post-excerpt',
        'core/post-featured-image',
        'core/loginout',
        'core/navigation',
        'core/post-author',
        'core/avatar',
        'core/post-navigation-link',

        'core/post-comments',
        'core/post-comments-form',
        'core/comments',
        'core/comment-author-name',
        'core/comment-content',
        'core/comment-date',
        'core/comment-edit-link',
        'core/comment-reply-link',
        'core/comments-title',
        'core/comments-query-loop',
        'core/comments-pagination-next',
        'core/comments-pagination-previous',

        'core/post-author-biography',
        'core/post-author-name',
        'core/term-description',
        'core/read-more',

        /**
         * Core embed blocks
         */
        //'core/embed',
        'core/embed/twitter',
        //'core/embed/youtube',
        'core/embed/facebook',
        //'core/embed/instagram',
        'core/embed/wordpress',
        'core/embed/soundcloud',
        'core/embed/spotify',
        'core/embed/flickr',
        //'core/embed/vimeo',
        'core/embed/pinterest',
        'core/embed/animoto',
        'core/embed/cloudup',
        'core/embed/collegehumor',
        'core/embed/crowdsignal',
        'core/embed/dailymotion',
        'core/embed/imgur',
        'core/embed/issuu',
        'core/embed/kickstarter',
        'core/embed/meetup-com',
        'core/embed/mixcloud',
        'core/embed/polldaddy',
        'core/embed/reddit',
        'core/embed/reverbnation',
        'core/embed/screencast',
        'core/embed/scribd',
        'core/embed/slideshare',
        'core/embed/smugmug',
        'core/embed/speaker',
        'core/embed/speaker-deck',
        'core/embed/tiktok',
        'core/embed/ted',
        'core/embed/tumblr',
        'core/embed/videopress',
        'core/embed/wordpress-tv',
        'core/embed/amazon-kindle',
        'core/embed/wolfram-cloud'
    ]
];