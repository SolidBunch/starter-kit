<?php

namespace StarterKit\Handlers\PostTypes;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;

/**
 * Post type class
 *
 * @package    Starter Kit
 */
class Portfolio
{
    public static function getKey()
    {
        return 'portfolio';
    }

    public static function getRewriteSlug()
    {
        return 'portfolio';
    }

    /**
     * Register post type
     *
     * @return void
     */
    public static function registerPostType(): void
    {
        register_post_type(
            static::getKey(),
            [
                'label'             => esc_html__('Portfolio', 'starter-kit'),
                'description'       => '',
                'public'            => true,
                'show_ui'           => true,
                'show_in_rest'      => false, // Use Gutenberg editor
                'show_in_menu'      => true,
                'show_in_nav_menus' => true,
                'capability_type'   => 'post',
                'hierarchical'      => false,
                'supports'          => ['title', 'editor', 'thumbnail', 'page-attributes'],
                'rewrite'           => ['slug' => static::getRewriteSlug()],
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
                    'name'               => esc_html__('Portfolio', 'starter-kit'),
                    'singular_name'      => esc_html__('Post', 'starter-kit'),
                    'menu_name'          => esc_html__('Portfolio', 'starter-kit'),
                    'add_new'            => esc_html__('Add Post', 'starter-kit'),
                    'add_new_item'       => esc_html__('Add New Post', 'starter-kit'),
                    'all_items'          => esc_html__('All Posts', 'starter-kit'),
                    'edit_item'          => esc_html__('Edit Post', 'starter-kit'),
                    'new_item'           => esc_html__('New Post', 'starter-kit'),
                    'view_item'          => esc_html__('View Post', 'starter-kit'),
                    'search_items'       => esc_html__('Search Posts', 'starter-kit'),
                    'not_found'          => esc_html__('No Posts Found', 'starter-kit'),
                    'not_found_in_trash' => esc_html__('No Posts Found in Trash', 'starter-kit'),
                    'parent_item_colon'  => esc_html__('Parent Post:', 'starter-kit'),
                ],
            ]
        );
    }
}
