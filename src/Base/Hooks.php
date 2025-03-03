<?php

namespace StarterKit\Base;

defined('ABSPATH') || exit;

use StarterKit\Handlers;
use StarterKit\Helper\Config;
use StarterKitBlocks;

/**
 * Hooks functionality for the theme.
 *
 * Run hook handlers
 *
 * @package    Starter Kit
 */
class Hooks
{
    public static function initHooks(): void
    {
        /************************************
         *           Setup Theme
         ************************************/
        add_action('after_setup_theme', [Handlers\SetupTheme::class, 'addThemeSupport']);
        add_action('after_setup_theme', [Handlers\SetupTheme::class, 'registerMenus']);
        // filter image sizes
        add_filter('intermediate_image_sizes', [Handlers\SetupTheme::class, 'filterImageSizes']);
        add_filter('big_image_size_threshold', [Handlers\SetupTheme::class, 'bigImageSizeThreshold']);

        /************************************
         *          Theme Settings
         ************************************/
        add_action('after_setup_theme', [Handlers\Settings\ThemeSettings::class, 'boot']);
        add_action('carbon_fields_register_fields', [Handlers\Settings\ThemeSettings::class, 'make']);
        add_action(
            'carbon_fields_theme_options_container_saved',
            [Handlers\Settings\ThemeSettings::class, 'updateFaviconFromThemeOptions']
        );
        add_action('carbon_fields_register_fields', [Handlers\Settings\NewsSettings::class, 'make']);

        /************************************
         *         Gutenberg blocks
         ************************************/
        add_action('block_categories_all', [Handlers\Blocks\Init::class, 'loadBlocksCategories']);
        add_action('init', [Handlers\Blocks\Init::class, 'loadBlocks']);
        add_filter('render_block', [Handlers\Blocks\BlockRenderHacks::class, 'templatePartWrapperHack'], 10, 2);
        add_filter('register_block_type_args', [Handlers\Blocks\Init::class, 'addSpacerAttributeToBlocks']);
        add_action('init', [Handlers\Blocks\DisableDefaultBlocks::class, 'init']);

        /************************************
         *     PostTypes with Taxonomies
         ************************************/
        add_action('init', [Handlers\PostTypes\News::class, 'registerPostType'], 5);
        add_action('init', [Handlers\PostTypes\News::class, 'registerCategoryTaxonomy'], 5);
        add_action('init', [Handlers\PostTypes\News::class, 'registerTagTaxonomy'], 5);
        add_action('init', [Handlers\PostTypes\Portfolio::class, 'registerPostType'], 5);
        add_action('init', [Handlers\PostTypes\Pricing::class, 'registerPostType'], 5);
        add_action('init', [Handlers\PostTypes\DocPage::class, 'registerPostType'], 5);
        add_action('init', [Handlers\PostTypes\TeamMember::class, 'registerPostType'], 5);
        add_action('init', [Handlers\PostTypes\Service::class, 'registerPostType'], 5);

        /************************************
         *            Meta Fields
         ************************************/
        add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\News::class, 'make']);
        add_action('carbon_fields_register_fields', [Handlers\Meta\TaxonomyMeta\NewsCategory::class, 'make']);
        add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\Pricing::class, 'make']);
        add_action('carbon_fields_register_fields', [Handlers\Meta\PostMeta\Page::class, 'make']);

        /************************************
         *     Admin aria customizations
         ************************************/
        add_action('restrict_manage_posts', [Handlers\AdminColumns::class, 'addNewsCategoryFilter'], 10, 2);
        add_filter('manage_posts_columns', [Handlers\AdminColumns::class, 'addImgColumn']);
        add_filter('manage_posts_custom_column', [Handlers\AdminColumns::class, 'manageImgColumn'], 10, 2);

        /************************************
         *               Back
         ************************************/
        add_action('enqueue_block_editor_assets', [Handlers\Back::class, 'enqueueBlockEditorAssets']);

        /************************************
         *               Front
         ************************************/
        add_action('enqueue_block_assets', [Handlers\Front::class, 'enqueueCriticalAssets'], 2);
        add_filter(
            Config::get('hooksPrefix') . '/block_asset_dependencies',
            [Handlers\Front::class, 'addThemeStyleDependencyToBlocks'],
            10,
            3
        );
        add_action('enqueue_block_assets', [Handlers\Front::class, 'enqueueBootstrap'], 10);
        add_action('wp_enqueue_scripts', [Handlers\Front::class, 'enqueueThemeAssets']);
        add_action('wp_enqueue_scripts', [Handlers\Front::class, 'loadFrontendJsData']);
        add_action('style_loader_src', [Handlers\Front::class, 'addFileTimeVerToStyles'], 20, 2);
        add_action('send_headers', [Handlers\Front::class, 'addNoCacheHeaders']);
        // Change excerpt dots
        add_filter('excerpt_more', [Handlers\Front::class, 'changeExcerptMore']);
        // GTM
        add_action('wp_head', [Handlers\Front::class, 'addGTMHead'], 1);
        add_action('wp_body_open', [Handlers\Front::class, 'addGTMBody'], 1);
        // add Google Analytics code to head
        add_action('wp_head', [Handlers\Front::class, 'addAnalyticsHead']);

        /************************************
         *       Security and CleanUp
         ************************************/
        add_action('init', [Handlers\Optimization\CleanUp::class, 'headCleanup'], 999);
        add_action('init', [Handlers\Optimization\Comments::class, 'disableComments']);
        add_action('init', [Handlers\Optimization\CleanAttributes::class, 'init']);
        add_action('init', [Handlers\Security\Xmlrpc::class, 'disableXmlrpcTrackbacks']);
        add_filter('rest_pre_dispatch', [Handlers\Security\RestApiFilter::class, 'restApiWhitelistOnly'], 10, 3);

        /************************************
         *            Send Mail
         ************************************/
        add_action('phpmailer_init', [Handlers\Mail\SMTP::class, 'phpmailerSmtpInit'], 999);
        add_action('wp_mail_failed', [Handlers\Mail\SMTP::class, 'mailFailedHandler']);

        /************************************
         *         Contact Form 7
         ************************************/
        add_filter('wpcf7_autop_or_not', '__return_false');
        add_filter('wpcf7_load_css', '__return_false');
    }
}
