<?php

namespace StarterKit\Handlers\Blocks;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;
use StarterKit\Handlers\Errors\ErrorHandler;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;
use StarterKit\Helper\Utils;
use Throwable;

/**
 * Block abstract class
 *
 * @package    Starter Kit
 */
abstract class BlockAbstract implements BlockInterface
{
    /**
     * Block name defined in Register class, usually block directory name
     *
     * @var string
     */
    protected string $blockName;

    /**
     * Additional block metadata. Place server side render callback here
     *
     * @var array
     */
    protected array $blockArgs = [];

    /**
     * Block assets for editor and frontend
     *
     * @var array
     */
    protected array $blockAssets = [];

    /**
     * BlockAbstract constructor.
     * Runs on 'init' hook
     *
     * @param $blockName
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public function __construct($blockName)
    {
        $this->blockName = $blockName;

        // We should register block assets before block registration
        $this->registerBlockAssets();

        // We should add necessary block arguments before block registration
        $this->registerBlockArgs();

        $this->registerBlock();

        add_action('rest_api_init', [$this, 'blockRestApiEndpoints']);
    }

    /**
     * Register block with metadata from block.json
     * Add your server side render callback into $this->blockArgs
     *
     * @return void
     * @throws NotFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function registerBlock(): void
    {
        register_block_type_from_metadata(
            Config::get('blocksDir') . $this->blockName,
            $this->blockArgs
        );
    }

    /**
     * Load block view
     *
     * @param string      $file
     * @param array       $data
     * @param string|null $base
     *
     * @return string
     *
     * @throws NotFoundException
     * @throws Throwable
     */
    public function loadBlockView(string $file = '', array $data = [], string $base = null): string
    {
        if ($base === null) {
            $base = Config::get('blocksDir') . $this->blockName . '/' . Config::get('blocksViewDir');
        }

        $viewFilePath = $base . $file . '.php';

        ob_start();

        try {
            if (file_exists($viewFilePath)) {
                require $viewFilePath;
            } else {
                throw new RuntimeException('The view path ' . $viewFilePath . ' can not be found.');
            }
        } catch (Throwable $throwable) {
            ErrorHandler::handleThrowable($throwable);
        }

        return ob_get_clean();
    }

    /**
     * Generating block classes including spacers
     * Used in block server side render callback
     * Same as js function BootstrapSpacers.generateClasses
     *
     * @param array $attributes
     *
     * @return string
     */
    public function generateBlockClasses(array $attributes): string
    {
        $blockClasses = [];

        if (!empty($attributes['className'])) {
            $blockClasses[] = $attributes['className'];
        }

        $blockClasses = array_merge($blockClasses, $this->generateSpacersClasses($attributes['spacers'] ?? []));

        return esc_attr(implode(' ', $blockClasses));
    }

    /**
     * Generating spacers classes
     *
     * @param array $spacers
     *
     * @return array
     */
    public function generateSpacersClasses(array $spacers): array
    {
        $spacerClasses = [];
        // ToDo store grid variables in one place - maybe scss
        $numberOfGrid = 5;

        foreach ($spacers as $item) {
            if (isset($item['valueRange'])) {
                foreach ($item['valueRange'] as $key => $value) {
                    $modifiedValue   = ($value === ($numberOfGrid + 1)) ? 'auto' : $value;
                    $modifiedClass   = str_replace('-xs', '', "$key-$modifiedValue");
                    $spacerClasses[] = $modifiedClass;
                }
            }
        }

        return $spacerClasses;
    }

    /**
     * Register block editor and front assets
     * Functionality moved from default function because there is no ability to use dependencies
     * No need to add to block.json:
     *   "editorScript": "",
     *   "viewScript": "",
     *   "editorStyle": "",
     *   "style": ""
     * Use $blockAssets property instead
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public function registerBlockAssets(): void
    {
        $blockUri = Config::get('blocksUri') . $this->blockName . '/build/';
        $blockDir = Config::get('blocksDir') . $this->blockName . '/build/';

        foreach ($this->blockAssets as $type => $asset) {
            if (empty($asset['file'])) {
                continue;
            }

            $filePath = $blockDir . $asset['file'];
            $fileUri  = $blockUri . $asset['file'];
            $deps     = $asset['dependencies'];
            $ver      = filemtime($filePath);

            // Default for scripts
            $args = [
                'strategy' => !is_admin() ? 'defer' : '',
                'in_footer' => true,
            ];
            // Default for styles
            $media = 'all';

            // Prepare handle based on type
            $base_handle = 'block-' . Utils::camelToKebab($this->blockName) . '-'
                           . basename($asset['file'], strstr($asset['file'], '.')) . '-';

            $handle = $base_handle . (str_contains($type, 'script') ? 'script' : 'style');

            // Check environment and type for proper registration
            if (
                (is_admin() && in_array($type, ['editor_script', 'script', 'editor_style', 'style'])) ||
                (!is_admin() && in_array($type, ['script', 'view_script', 'style', 'view_style']))
            ) {
                if (str_contains($type, 'script')) {
                    wp_register_script($handle, $fileUri, $deps, $ver, $args);
                } else {
                    wp_register_style($handle, $fileUri, $deps, $ver, $media);
                }

                // Store registered handles for use in block registration
                $this->blockArgs[$type . '_handles'][] = $handle;
            }

            if (!in_array($type, ['editor_script', 'editor_style', 'script', 'view_script', 'style', 'view_style'])) {
                // ToDo vvv add correct error logging
                error_log("Unsupported asset type or context: $type");
            }
        }
    }
}
