<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use WP_Query;
use WP_Post;

/**
 * Repository abstract for WP_Post objects
 *
 * @package    Starter Kit
 */
abstract class WpPostRepositoryAbstract implements WpPostRepositoryInterface
{
    abstract public static function getPostTypeKey(): string;

    /**
     * Get posts WP_Query by params
     *
     * @param $args
     *
     * @return WP_Query
     */
    public static function getQuery($args): WP_Query
    {
        $defaults = [
            'post_type'      => static::getPostTypeKey(),
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => [
                'date' => 'DESC',
            ],
        ];

        $args = wp_parse_args($args, $defaults);

        if (isset($args['tax_query_type'])) {
            $_taxonomy_slug  = $args['taxonomy_slug'];
            $_taxonomy_terms = explode(',', $args['taxonomy_terms']);

            if ($args['tax_query_type'] === 'only') {
                $args['tax_query'] = [
                    [
                        'taxonomy' => $_taxonomy_slug,
                        'field'    => 'slug',
                        'terms'    => $_taxonomy_terms,
                    ],
                ];
            } elseif ($args['tax_query_type'] === 'except') {
                $args['tax_query'] = [
                    [
                        'taxonomy' => $_taxonomy_slug,
                        'field'    => 'slug',
                        'terms'    => $_taxonomy_terms,
                        'operator' => 'NOT IN',
                    ],
                ];
            }
        }

        if (isset($args['meta_query'])) {
            $args['meta_query'] = (array)$args['meta_query'];
        }

        return new WP_Query($args);
    }

    /**
     * Get \WP_Post objects array
     *
     * @param  array  $args
     *
     * @return WP_Post [] | array
     */
    public static function get(array $args): array
    {
        unset($args['fields']); // prevent unexpected return
        $query  = static::getQuery($args);
        $result = $query->get_posts();
        wp_reset_postdata();

        return $result;
    }


    /**
     * Get \WP_Post objects array
     *
     * @param  array  $args
     *
     * @return Int[]
     */
    public static function getIds(array $args): array
    {
        $args['fields'] = 'ids'; // prevent unexpected return
        $query          = static::getQuery($args);
        $result         = $query->get_posts();
        wp_reset_postdata();

        return $result;
    }


    public static function getAutocompleteValues(array $args): array
    {
        $posts  = static::get($args);
        $values = [];

        foreach ($posts as $post) {
            /** @var WP_Post $post */
            $values[] = [
                'value' => $post->ID ?? 0,
                'label' => $post->post_title ?? '',
            ];
        }

        return $values;
    }

    /**
     * @param  array  $args
     * @param  bool   $key_slug
     *
     * @return array
     */
    public static function getAllList(array $args, bool $key_slug = false): array
    {
        $posts  = static::get($args);
        $values = [];

        foreach ($posts as $post) {
            /** @var WP_Post $post */

            if ($key_slug) {
                $values[$post->post_name] = $post->post_title;
            } else {
                $values[$post->ID] = $post->post_title;
            }
        }

        return $values;
    }

    /**
     * @param  array  $args
     * @param  bool   $key_slug
     *
     * @return array
     */
    public static function getPagedList(array $args, bool $key_slug = false): array
    {
        $query      = static::getQuery($args);
        $posts      = $query->get_posts();
        $values     = [];
        $totalPages = $query->max_num_pages;
        wp_reset_postdata();

        foreach ($posts as $post) {
            /** @var WP_Post $post */

            if ($key_slug) {
                $values[$post->post_name] = $post->post_title;
            } else {
                $values[$post->ID] = $post->post_title;
            }
        }

        return [
            $values,
            $args['paged'] ?? 1,
            $totalPages,
        ];
    }
}
