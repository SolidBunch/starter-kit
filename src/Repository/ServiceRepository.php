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
class ServiceRepository extends WpPostRepositoryAbstract
{
    public static function getPostTypeKey(): string
    {
        return PostTypes\Service::getKey();
    }
}
