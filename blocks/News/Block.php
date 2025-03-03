<?php

namespace StarterKitBlocks\News;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Handlers\PostTypes;
use StarterKit\Handlers\Blocks\BlockAbstract;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;
use StarterKit\Repository\NewsRepository;
use Throwable;
use WP_Error;
use WP_HTTP_Response;
use WP_REST_Request;
use WP_REST_Response;

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
            'editor_style' => [
                'file' => 'editor.css',
                'dependencies' => [],
            ],
            'style' => [
                'file' => 'style.css',
                'dependencies' => [],
            ],
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
        $templateData = [];

        $templateData['newsData']     = 'Some data';
        $templateData['newsCategory'] = $attributes['category'] ?? true;

        $templateData['blockClass'] = $this->generateBlockClasses($attributes);

        return $this->loadBlockView('layout', $templateData);
    }

    /**
     * Register rest api endpoints
     * Runs by Blocks Register Handler
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function blockRestApiEndpoints(): void
    {
        register_rest_route(Config::get('restApiNamespace'), '/news', [
            'methods' => 'GET,POST',
            'callback' => [$this, 'getNewsCallback'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * REST API endpoint callback
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response|WP_HTTP_Response
     *
     * @throws NotFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getNewsCallback(WP_REST_Request $request): WP_Error|WP_REST_Response|WP_HTTP_Response
    {
        $requestData = esc_sql(json_decode($request->get_body(), true));
        if (empty($requestData)) {
            status_header(404);
            nocache_headers();
            // ToDo return 404 template
            exit;
        }
        $params        = $requestData['params'];
        $requestedPage = $requestData['page'] ?? 1;
        //$nonce         = $requestData['nonce'];

        $metaPrefix = Config::get('settingsPrefix') . PostTypes\News::getKey() . '_';

        $args = [];

        list($news, $page, $totalPages) = NewsRepository::getPagedList($args);

        $response['page']        = $page;
        $response['total_pages'] = $totalPages;
        $response['news']        = $news;

        return rest_ensure_response($response);
    }
}
