<?php

namespace Theme\Hookables;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Snap\Core\Hookable;
use Snap\Services\Config;
use Snap\Services\View;
use Snap\Utils\Theme;
use Snap\Utils\Vite;

/**
 * Gutenberg helper
 *
 * Registers block automatically.
 */
class Gutenberg extends Hookable
{
    private ?string $blocksPath = null;

    private array $categories = [];
    private bool $enabled;

    public function __construct()
    {
        $this->enabled = Config::get('gutenberg.enable_acf_blocks', false);
        $this->blocksPath = trailingslashit(\get_stylesheet_directory()) . Theme::getTemplatesPath() . 'blocks';

        if (!is_dir($this->blocksPath)) {
            $this->blocksPath = null;
        }
    }

    /**
     * Register hooks.
     */
    public function boot(): void
    {
        // Add our own editor styles and remove the default block styles.
        // These should always be registered, regardless of whether ACF blocks
        // are enabled, so the editor always reflects the theme's real styles.
        $this->addAction('init', 'addEditorStyles');
        $this->addAction('wp_default_styles', 'removeDefaultBlockStylesFromEditor', 9999);
        $this->addFilter('mce_css', 'removeEditorStyleFromTinyMce');

        // Enqueue any additional JS in the editor
        // $this->addAction('enqueue_block_editor_assets', 'enqueueRawAssets');

        if ($this->enabled) {
            if (function_exists('acf_register_block_type') && $this->blocksPath) {
                $this->addAction('acf/init', 'registerBlocks');
                $this->addAction('block_categories_all', 'registerCategories');
            }
        }
    }

    /**
     * WP will transform all css enqueued at this point by prefixing all selectors with the editor namespace.
     *
     * While useful (as there is no risk of affecting other admin elements),
     * it does scope all your classes to the editor itself - meaning you cannot affect things such as the page title.
     */
    public function addEditorStyles(): void
    {
        Vite::registerEditorStyle('resources/assets/css/editor.css');
        //add_editor_style('resources/assets/css/main.css');
    }

    /**
     * Keep editor.css out of classic TinyMCE editors (ACF WYSIWYG fields), which add_editor_style() also feeds.
     * It's written for the block editor; Gutenberg gets its editor styles separately, so this doesn't affect it.
     */
    public function removeEditorStyleFromTinyMce(string $css): string
    {
        $path = 'resources/assets/css/editor.css';
        $server = Vite::getViteServerUrl();
        $url = $server ? $server . $path : snap_get_asset_url($path);

        $styles = array_filter(explode(',', $css), fn ($style) => trim($style) !== $url);

        return implode(',', $styles);
    }

    /**
     * Remove the default block styles from the editor.
     */
    public function removeDefaultBlockStylesFromEditor($styles): void
    {
        $handles = [
            'wp-block-library',
            'wp-block-library-theme',
            // block-library/reset.css: unlayered `revert` rules for headings, p, lists etc. beat Tailwind's
            // layered utilities, so text sizes/weights/margins break in the editor. Core already skips it in
            // the iframed editor for theme.json themes; this classic theme doesn't need it either.
            'wp-reset-editor-styles',
        ];

        foreach ($handles as $handle) {
            // Search and compare with the list of registered style handles:
            $style = $styles->query($handle, 'registered');
            if (!$style) {
                continue;
            }

            $styles->remove($handle);
            $styles->add($handle, false, []);
        }
    }

    /**
     * Enqueue js for the editor.
     *
     * Needed when you need to use the blocks API.
     */
    public function enqueueRawAssets(): void
    {
        wp_enqueue_script(
            'theme-gutenberg-scripts',
            snap_get_asset_url('/js/gutenberg.js'),
            ['wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-edit-post', 'word-count']
        );
    }

    /**
     * Register all blocks automatically.
     */
    public function registerBlocks(): void
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->blocksPath,
                FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS
            )
        );

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $group = trim(
                    str_replace($this->blocksPath, '', $file->getPath()),
                    '/'
                );

                if (empty($group)) {
                    $group = 'common';
                }

                $this->addCategory($group);

                $name = ucwords(str_replace(['.blade.php', '-'], ['', ' '], $file->getFilename()));
                $content = \file_get_contents($file->getPathname());

                // Inserter hover preview: only blocks with a screenshot get an example. The flag is only
                // ever set on the example, so inserted blocks never see it (see render()).
                $example = $this->getPreviewImage(sanitize_title($name))
                    ? ['attributes' => ['mode' => 'preview', 'data' => ['_inserter_preview' => true]]]
                    : null;

                acf_register_block_type([
                    'name' => sanitize_title($name),
                    'title' => $name,
                    'description' => $this->extractString('Description', $content),
                    'render_callback' => [$this, 'render'],
                    'category' => strtolower($group),
                    'post_types' => $this->extractPostTypes('Post types', $content),
                    'icon' => $this->extractString('Icon', $content),
                    'keywords' => $this->extractArray('Keywords', $content),
                    // Validate required/invalid fields in the editor and lock saving until fixed.
                    // ACF only defaults these on for block.json registration, not acf_register_block_type().
                    // validate_on_load also checks blocks as they first render (page load, newly inserted);
                    // without it, a block whose fields were never touched always passes.
                    'validate' => $validate = $this->extractBool('Validate', $content) ?? true,
                    'hide_fields_in_sidebar' => true,
                    'validate_on_load' => $validate,
                    'supports' => [
                        'multiple' => $this->extractBool('Multiple', $content) ?? true
                    ],
                    'example' => $example,
                ]);
            }
        }
    }

    /**
     * The block's inserter preview screenshot, as an absolute file path, or null if there isn't one.
     * Drop a file named after the block into resources/assets/images/block-previews/ (e.g. about-us.png).
     * No build step: render() embeds it directly.
     */
    private function getPreviewImage(string $slug): ?string
    {
        foreach (['png', 'jpg', 'webp'] as $extension) {
            $path = Theme::getActiveThemePath("resources/assets/images/block-previews/{$slug}.{$extension}");

            if (\file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Register any declared block categories.
     */
    public function registerCategories(array $categories): array
    {
        foreach ($categories as $key => $cat) {
            if ($cat['slug'] === 'common') {
                unset($categories[$key]);
                break;
            }
        }

        return array_merge(array_values($this->categories), $categories);
    }

    /**
     * Render the block.
     */
    public function render(array $block, $content = '', $is_preview = false, $post_id = 0, $wp_block = false, $context = false): void
    {
        // Inserter hover panel: show the block's screenshot instead of rendering it without content
        if (!empty($block['data']['_inserter_preview'])) {
            $image = $this->getPreviewImage(str_replace('acf/', '', $block['name']));

            if ($image) {
                // Embedded as a data URI straight from resources/: the theme's .htaccess blocks browser
                // requests to resources/, and this only ever renders in the inserter's hover panel.
                $mime = wp_check_filetype($image)['type'] ?: 'image/png';
                $src = "data:{$mime};base64," . base64_encode(\file_get_contents($image));

                echo '<img src="' . esc_attr($src) . '" alt="" style="display:block;width:100%;height:auto">';
                return;
            }
        }

        $data = [
            'block' => $block,
            'is_preview' => $is_preview,
            'context' => $context,
        ];

        $data = $this->getBlockData($block, $data);

        // Transform block name back into path
        $slug = str_replace('acf/', '', $block['name']);
        $path = "{$block['category']}.$slug";

        View::render("blocks.{$path}", array_map([$this, 'convertToObject'], $data));
    }

    /**
     * Convert array to object recursively.
     */
    private function convertToObject(mixed $data): mixed
    {
        if (!is_array($data)) {
            return $data;
        }

        if (is_numeric(key($data))) {
            return array_map([$this, 'convertToObject'], $data);
        }

        return (object)array_map([$this, 'convertToObject'], $data);
    }

    /**
     * Pass data to block (frontend)
     */
    private function getBlockData(array $block, array $data): array
    {
        if (!isset($block['data'])) {
            return $data;
        }

        $temp = array_merge($data, (array)get_fields());

        foreach ($temp as &$value) {
            if (empty($value)) {
                $value = null;
            }
        }

        return array_merge($data, (array)get_fields());
    }

    /**
     * Extracts a string from a docblock.
     *
     * @param string $string
     * @param string $content
     * @return string
     */
    private function extractString(string $string, string $content): string
    {
        \preg_match('|' . $string . '\s*:(.*)$|mi', $content, $match);

        if (isset($match[1])) {
            return trim($match[1]);
        }

        return '';
    }

    /**
     * Extracts an array from a docblock.
     *
     * @param string $string
     * @param string $content
     * @return array
     */
    private function extractArray(string $string, string $content): array
    {
        $raw = $this->extractString($string, $content);

        $values = explode(',', $raw);
        $values = array_map('trim', $values);
        return array_filter($values);
    }

    /**
     * Extracts an array from a docblock, falling back to an array of all registered post types.
     *
     * @param string $string
     * @param string $content
     * @return array
     */
    private function extractPostTypes(string $string, string $content): array
    {
        $raw = $this->extractArray($string, $content);

        if (empty($raw)) {
            return get_post_types();
        }

        return $raw;
    }

    /**
     * Extracts a bool from a docblock.
     */
    private function extractBool(string $string, string $content): ?bool
    {
        $raw = $this->extractString($string, $content);

        // not present
        if ($raw === '') {
            return null;
        }

        return (bool)filter_var($raw, FILTER_VALIDATE_BOOLEAN);
    }

    private function addCategory(string $group): void
    {
        $title = ucwords(str_replace(['.', '_', '-'], ' ', $group));

        $this->categories[$group] = [
            'slug' => sanitize_title($group),
            'title' => $title,
        ];
    }
}