<?php

namespace StarterKit\Handlers\Settings;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StarterKit\Helper\Config;
use StarterKit\Handlers\PostTypes;

/**
 * Post type settings handler
 *
 * @package    Starter Kit
 */
class NewsSettings
{
    /**
     * Make Carbon Fields
     *
     * @return void
     */
    public static function make(): void
    {
        $prefix = Config::get('settingsPrefix');

        $container = Container::make(
            'theme_options',  // type
            'news_settings', // id
            __('News Settings', 'starter-kit') // desc
        );

        $container->set_page_parent('edit.php?post_type=' . PostTypes\News::getKey());
        $container->set_page_menu_title('News Settings');
        $container->set_icon('dashicons-carrot');

        /** Example */
        $container->add_tab(
            __('Settings', 'starter-kit'),
            [
                Field::make('separator', $prefix . 'sep_general_header', __('Example', 'starter-kit')),
                Field::make('checkbox', $prefix . 'example_option', __('Example option', 'starter-kit'))
                     ->set_option_value('1')
                     ->set_default_value(''),
            ]
        );
    }
}
