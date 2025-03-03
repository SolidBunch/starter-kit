<?php

namespace StarterKit\Handlers\PostTypes;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;

/**
 * Post type class
 *
 * @package    Starter Kit
 */
class Pricing
{
    public static function getKey()
    {
        return 'pricing';
    }

    public static function getRewriteSlug()
    {
        return 'pricing';
    }

    /**
     * Register post type
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws NotFoundException
     */
    public static function registerPostType(): void
    {
        register_post_type(
            static::getKey(),
            [
                'label'             => esc_html__('Pricing', 'starter-kit'),
                'description'       => '',
                'public'            => true,
                'show_ui'           => true,
                'show_in_rest'      => false, // Use Gutenberg editor
                'show_in_menu'      => true,
                'show_in_nav_menus' => true,
                'capability_type'   => 'post',
                'hierarchical'      => false,
                'supports'          => ['title', 'editor', 'page-attributes'],
                'rewrite'           => ['slug' => static::getRewriteSlug()],
                'has_archive'       => false,
                'query_var'         => false,
                'menu_position'     => 5,
                'menu_icon'         => 'dashicons-money-alt',
                'capabilities'      => [
                    'publish_posts'       => 'edit_pages',
                    'edit_posts'          => 'edit_pages',
                    'edit_others_posts'   => 'edit_pages',
                    'delete_posts'        => 'edit_pages',
                    'delete_others_posts' => 'edit_pages',
                    'read_private_posts'  => 'edit_pages',
                    'edit_post'           => 'edit_pages',
                    'delete_post'         => 'edit_pages',
                    'read_post'           => 'edit_pages',
                ],
                'labels'            => [
                    'name'               => esc_html__('Pricing', 'starter-kit'),
                    'singular_name'      => esc_html__('Pricing', 'starter-kit'),
                    'menu_name'          => esc_html__('Pricing', 'starter-kit'),
                    'add_new'            => esc_html__('Add Pricing', 'starter-kit'),
                    'add_new_item'       => esc_html__('Add New Pricing', 'starter-kit'),
                    'all_items'          => esc_html__('All Pricing', 'starter-kit'),
                    'edit_item'          => esc_html__('Edit Pricing', 'starter-kit'),
                    'new_item'           => esc_html__('New Pricing', 'starter-kit'),
                    'view_item'          => esc_html__('View Pricing', 'starter-kit'),
                    'search_items'       => esc_html__('Search Pricing', 'starter-kit'),
                    'not_found'          => esc_html__('No Pricing Found', 'starter-kit'),
                    'not_found_in_trash' => esc_html__('No Pricing Found in Trash', 'starter-kit'),
                    'parent_item_colon'  => esc_html__('Parent Pricing:', 'starter-kit'),
                ],
            ]
        );
    }
}
