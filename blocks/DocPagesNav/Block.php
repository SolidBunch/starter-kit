<?php

namespace StarterKitBlocks\DocPagesNav;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\NotFoundException;
use StarterKit\Repository\DocPageRepository;
use Throwable;

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
                'dependencies' => ['dropdown-script', 'offcanvas-script'],
            ],
            'editor_style' => [
                'file' => 'editor.css',
                'dependencies' => [],
            ]
        ];

    /**
     * Register block additional arguments including server side render callback
     *
     * @return void
     */
    public function registerBlockArgs(): void
    {
        $this->blockArgs['render_callback'] = [$this, 'blockServerSideCallback'];
    }

    /**
     * Block server side render callback
     * Used in register block type from metadata
     *
     * @param array  $attributes
     * @param string $content
     * @param object $block
     *
     * @return string
     *
     * @throws NotFoundException
     * @throws Throwable
     */
    public function blockServerSideCallback(array $attributes, string $content, object $block): string
    {
        $args = [
            'posts_per_page' => 300,
            'orderby' => [
                'menu_order' => 'ASC',
            ],
        ];

        $templateData['docPages'] = DocPageRepository::getAllHierarchicallyWithLinks($args);

        return $this->loadBlockView('layout', $templateData);
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
