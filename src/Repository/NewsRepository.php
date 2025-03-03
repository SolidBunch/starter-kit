<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

use StarterKit\Helper\Config;
use StarterKit\Handlers\PostTypes;

/**
 * Repository for post type objects
 *
 * @package    Starter Kit
 */
class NewsRepository extends WpPostRepositoryAbstract
{
    public static function getPostTypeKey(): string
    {
        return PostTypes\News::getKey();
    }

    /**
     * @param  array  $args
     *
     * @return array
     */
    public static function getRecentNews(array $args): array
    {
        return [];
    }

    /**
     * @param  array  $args
     *
     * @return array
     */
    public static function getRelatedNews(array $args): array
    {
        return [];
    }

    /**
     * @param  array  $args
     *
     * @return array
     */
    public static function getRandomNews(array $args): array
    {
        return [];
    }

    /**
     * @param  float  $impact
     *
     * @return array
     */
    public static function getNewsPowerByImpact(float $impact): array
    {
        return match (true) {
            $impact >= 9.01 => ['title' => 'Definitely', 'color' => 'definitely'],
            $impact >= 7.01 => ['title' => 'Very Strong', 'color' => 'very-strong'],
            $impact >= 5.01 => ['title' => 'Strong', 'color' => 'strong'],
            $impact >= 3.01 => ['title' => 'Weak', 'color' => 'weak'],
            $impact >= 1.01 => ['title' => 'Very Weak', 'color' => 'very-weak'],
            $impact >= 0 => ['title' => 'Slightly', 'color' => 'slightly'],
            default => ['title' => 'No Power', 'color' => 'gray'],
        };
    }
}
