<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use StarterKit\Helper\Config;
use StarterKit\Helper\NotFoundException;
use StarterKit\Helper\Utils;
use StarterKit\Handlers\PostTypes;

/**
 * Repository for post type objects
 *
 * @package    Starter Kit
 */
class PricingRepository extends WpPostRepositoryAbstract
{
    public static function getPostTypeKey(): string
    {
        return PostTypes\Pricing::getKey();
    }

    /**
     * Returns all pricing with metadata
     *
     * @param array $args
     *
     * @return array
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws NotFoundException
     */
    public static function getAllWithData(array $args): array
    {
        $posts  = static::get($args);
        $values = [];
        $metaPrefix = Config::get('settingsPrefix') . PostTypes\Pricing::getKey() . '_';

        foreach ($posts as $post) {
            /** @var WP_Post $post */

            $values[$post->ID]['title'] = $post->post_title;
            $values[$post->ID]['border_color'] = Utils::getPostMeta($post->ID, $metaPrefix . 'border_color', 'primary');
            $values[$post->ID]['features'] = Utils::getPostMeta($post->ID, $metaPrefix . 'features');
            $values[$post->ID]['content'] = apply_filters('the_content', $post->post_content);
            $values[$post->ID]['price'] = Utils::getPostMeta($post->ID, $metaPrefix . 'price');
            $values[$post->ID]['button_text'] = Utils::getPostMeta($post->ID, $metaPrefix . 'button_text');
            $values[$post->ID]['button_link'] = Utils::getPostMeta($post->ID, $metaPrefix . 'button_link');
            $values[$post->ID]['button_color'] = Utils::getPostMeta($post->ID, $metaPrefix . 'button_color');
            $values[$post->ID]['button_style'] = Utils::getPostMeta($post->ID, $metaPrefix . 'button_style');
        }

        return $values;
    }
}
