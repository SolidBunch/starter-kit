<?php

namespace StarterKit\Handlers\Meta\PostMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Config;
use StarterKit\Repository\CarBrandRepository;

/**
 * Post type meta data handler
 *
 * @package    Starter Kit
 */
class Page
{
    public static function make(): void
    {
        $metaPrefix = Config::get('settingsPrefix') . 'page_';

        $carBrands = CarBrandRepository::getCarBrands();

        Container::make('post_meta', __('Page Settings', 'starter-kit'))
                 ->where('post_type', '=', 'page')
                 ->set_priority('default')
                 ->add_fields([
                     Field::make('multiselect', $metaPrefix . 'car_brands', __('Car Brands', 'starter-kit'))
                          ->set_options($carBrands)
                          ->set_help_text(__('Select one or few Car Brands', 'starter-kit'))
                          ->set_width(30),
                 ]);
    }
}
