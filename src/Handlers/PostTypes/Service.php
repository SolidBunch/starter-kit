<?php

namespace StarterKit\Handlers\PostTypes;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;

/**
 * Services post type
 *
 * @package    Starter Kit
 */
class Service
{
    public static function getKey()
    {
        return 'service';
    }

    /**
     * Register post type
     * Reference type without frontend output
     *
     * @return void
     */
    public static function registerPostType(): void
    {
        register_post_type(
            static::getKey(),
            [
                'label'             => esc_html__('Services', 'starter-kit'),
                'description'       => '',
                'public'            => false,
                'show_ui'           => true,
                'show_in_rest'      => false, // Use Gutenberg editor
                'show_in_menu'      => true,
                'show_in_nav_menus' => true,
                'capability_type'   => 'post',
                'hierarchical'      => false,
                'supports'          => ['title', 'thumbnail'],
                'rewrite'           => false,
                'has_archive'       => true,
                'query_var'         => false,
                'menu_position'     => 5,
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
                    'name'               => esc_html__('Services', 'starter-kit'),
                    'singular_name'      => esc_html__('Service Item', 'starter-kit'),
                    'menu_name'          => esc_html__('Services', 'starter-kit'),
                    'add_new'            => esc_html__('Add Service', 'starter-kit'),
                    'add_new_item'       => esc_html__('Add Service', 'starter-kit'),
                    'all_items'          => esc_html__('All Services', 'starter-kit'),
                    'edit_item'          => esc_html__('Edit Service', 'starter-kit'),
                    'new_item'           => esc_html__('New Service', 'starter-kit'),
                    'view_item'          => esc_html__('View Service', 'starter-kit'),
                    'search_items'       => esc_html__('Search Service', 'starter-kit'),
                    'not_found'          => esc_html__('No Service Found', 'starter-kit'),
                    'not_found_in_trash' => esc_html__('No Service Found in Trash', 'starter-kit'),
                    'parent_item_colon'  => esc_html__('Parent Service:', 'starter-kit'),
                ],
            ]
        );
    }
}
