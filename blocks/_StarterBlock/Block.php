<?php

namespace StarterKitBlocks\StarterBlock;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\NotFoundException;

/**
 * Block controller
 *
 * @package    Starter Kit
 */
class Block extends BlockAbstract
{
    /**
     * Block assets for editor and frontend
     *
     * @var array
     */
    protected array $blockAssets
        = [
            'editor_script' => [
                'file' => 'index.js',
                'dependencies' => ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
            ],
            'view_script' => [
                'file' => 'view.js',
                'dependencies' => [],
            ],
            'editor_style' => [
                'file' => 'editor.css',
                'dependencies' => [],
            ],
            'style' => [
                'file' => 'style.css',
                'dependencies' => [],
            ],
            'view_style' => [],
        ];

    /**
     * Register block additional arguments including server side render callback
     *
     * @return void
     */
    public function registerBlockArgs(): void
    {
    }

    /**
     * Register rest api endpoints
     * Runs by abstract constructor
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function blockRestApiEndpoints(): void
    {
    }
}