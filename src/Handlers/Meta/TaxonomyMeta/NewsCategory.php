<?php

namespace StarterKit\Handlers\Meta\TaxonomyMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Config;
use StarterKit\Handlers\PostTypes;

/**
 * Taxonomy meta data handler
 *
 * @package    Starter Kit
 */
class NewsCategory
{
    public static function make(): void
    {
        $metaPrefix = Config::get('settingsPrefix') . PostTypes\News::getCategoryKey() . '_';

        Container::make('term_meta', __('News Category Settings', 'starter-kit'))
                 ->where('term_taxonomy', '=', PostTypes\News::getCategoryKey())
                 ->add_fields([
                     Field::make('image', $metaPrefix . 'image_id', __('Image', 'starter-kit')),
                 ]);
    }
}
