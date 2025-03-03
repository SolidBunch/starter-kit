<?php

namespace StarterKit\Handlers\Meta\PostMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Config;
use StarterKit\Repository\CarBrandRepository;
use StarterKit\Repository\ServiceRepository;
use StarterKit\Handlers\PostTypes;

/**
 * Post type meta data handler
 *
 * @package    Starter Kit
 */
class News
{
    public static function make(): void
    {
        $metaPrefix = Config::get('settingsPrefix') . PostTypes\News::getKey() . '_';

        $services = ServiceRepository::getAllList(['posts_per_page' => 1000]);
        asort($services);

        $carBrands = CarBrandRepository::getCarBrands();

        Container::make('post_meta', __('News Data fields', 'starter-kit'))
                 ->where('post_type', '=', PostTypes\News::getKey())
                 ->set_priority('default')
                 ->add_fields([
                     Field::make('text', $metaPrefix . 'data', __('Data', 'starter-kit')),
                     Field::make('text', $metaPrefix . 'impact', __('Impact', 'starter-kit'))
                          ->set_attribute('type', 'number')
                          ->set_attribute('min', '0')
                          ->set_attribute('max', '10')
                          ->set_attribute('step', '0.01')
                          ->set_help_text('from 0 to 10')
                          ->set_width(10),
                     Field::make('color', $metaPrefix . 'color', __('Color', 'starter-kit'))
                          ->set_width(50),
                     Field::make('select', $metaPrefix . 'data_options', __('Data Options', 'starter-kit'))
                          ->set_options([
                              '' => __('Unknown', 'starter-kit'),
                              'allowed' => __('Allowed', 'starter-kit'),
                              'denied' => __('Denied', 'starter-kit'),
                          ])
                          ->set_width(10),
                     Field::make('complex', $metaPrefix . 'related_data', __('Related Data', 'starter-kit'))
                          ->add_fields(
                              'item',
                              __('Item', 'starter-kit'),
                              [
                                  Field::make('text', 'text', __('Text', 'starter-kit')),
                                  Field::make('select', 'type', __('Type', 'starter-kit'))
                                       ->set_options([
                                           'data_one' => __('Data One', 'starter-kit'),
                                           'data_two' => __('Data Two', 'starter-kit'),
                                       ]),
                              ]
                          )
                          ->set_header_template(
                              '
                            <% if (text) { %>
                                <%- text %>
                            <% } else { %>
                                empty
                            <% } %>
                        '
                          )
                          ->set_collapsed(true),
                     Field::make('multiselect', $metaPrefix . 'services', __('Services', 'starter-kit'))
                          ->set_options($services)
                          ->set_help_text(__('Select one or few Services', 'starter-kit'))
                          ->set_width(30),
                     Field::make('multiselect', $metaPrefix . 'car_brands', __('Car Brands', 'starter-kit'))
                          ->set_options($carBrands)
                          ->set_help_text(__('Select one or few Car Brands', 'starter-kit'))
                          ->set_width(30),

                 ]);
    }
}
