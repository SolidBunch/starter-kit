<?php

namespace StarterKit\Handlers\Meta\PostMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Config;
use StarterKit\Handlers\PostTypes;

/**
 * Post type meta data handler
 *
 * @package    Starter Kit
 */
class Pricing
{
    public static function make(): void
    {
        $metaPrefix = Config::get('settingsPrefix') . PostTypes\Pricing::getKey() . '_';

        Container::make('post_meta', __('Pricing Package Data', 'starter-kit'))
            ->where('post_type', '=', PostTypes\Pricing::getKey())
            ->set_priority('default')
            ->add_fields([
                             Field::make('text', $metaPrefix . 'price', __('Price', 'starter-kit'))
                                 ->set_width(50),
                             Field::make('select', $metaPrefix . 'border_color', __('Border Color', 'starter-kit'))
                                 ->set_options([
                                                   'primary'   => __('Primary', 'starter-kit'),
                                                   'secondary' => __('Secondary', 'starter-kit'),
                                                   'success'   => __('Success', 'starter-kit'),
                                                   'danger'    => __('Danger', 'starter-kit'),
                                                   'warning'   => __('Warning', 'starter-kit'),
                                                   'info'      => __('Info', 'starter-kit'),
                                               ])
                                 ->set_width(50),
                             Field::make('complex', $metaPrefix . 'features', __('Features', 'starter-kit'))
                                 ->add_fields(
                                     'item',
                                     __('Feature Item', 'starter-kit'),
                                     [
                                         Field::make('text', 'text', __('Text', 'starter-kit')),
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
                             Field::make('text', $metaPrefix . 'button_text', __('Button Text', 'starter-kit'))
                                 ->set_width(10),
                             Field::make('text', $metaPrefix . 'button_link', __('Button Link', 'starter-kit'))
                                 ->set_width(10),
                             Field::make('select', $metaPrefix . 'button_color', __('Button Color', 'starter-kit'))
                                 ->set_options([
                                                   'primary'   => __('Primary', 'starter-kit'),
                                                   'secondary' => __('Secondary', 'starter-kit'),
                                                   'success'   => __('Success', 'starter-kit'),
                                                   'danger'    => __('Danger', 'starter-kit'),
                                                   'warning'   => __('Warning', 'starter-kit'),
                                                   'info'      => __('Info', 'starter-kit'),
                                               ])
                                 ->set_width(10),
                             Field::make('select', $metaPrefix . 'button_style', __('Button Style', 'starter-kit'))
                                 ->set_options([
                                                   ''    => __('Fill', 'starter-kit'),
                                                   'outline' => __('Outline', 'starter-kit'),
                                               ])
                                 ->set_width(10),
                         ]);
    }
}
