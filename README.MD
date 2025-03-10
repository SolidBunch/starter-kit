# Starter Kit theme
<!--suppress HtmlDeprecatedAttribute -->

<p align="center">

  <a href="LICENSE.md">
    <img alt="GitHub" src="https://img.shields.io/github/license/solidbunch/starter-kit-theme">
  </a>

  <a href="https://github.com/solidbunch/starter-kit-theme/releases">
    <img alt="GitHub release (latest by date)" src="https://img.shields.io/github/v/release/solidbunch/starter-kit-theme?color=blueviolet">
  </a>

</p>

<p align="center">
<strong>WordPress starter theme with a modern development stack for launching projects faster and easily.</strong>

</p>

## Requirements

- [PHP](https://secure.php.net/manual/en/install.php) 8.1
- [WordPress](https://wordpress.org/) 6.1
- [Composer](https://getcomposer.org/) 2.6
- [Node.js](http://nodejs.org/) 18

## How to use

### Installation

1. Create a new theme directory in wp-content/themes:

```bash
mkdir you-theme-dir && cd you-theme-dir
```

2. Clone Starter Kit Theme:

```bash
git clone --depth=1 git@github.com:solidbunch/starter-kit-theme.git . && rm -rf .git
```

3. Setup php dependencies:

```bash
composer install
```

4. Setup node dependencies and dev mode build:

```bash
npm run install-dev
```

<!-- 5. Edit theme config object in `gulpfile.js`. Change theme name, theme prefix, main class, etc.


5. Run replace names command:

```bash
npm run replaceNames
```
-->
### Build commands

- Build minified assets for production:

```bash
npm run prod
```

- Build assets with source maps for development:

```bash
npm run dev
```

- Start watcher with browser sync for development:

```bash
npm run watch
```

<details>
  <summary>Yarn commands</summary>

- `yarn` - setup node dependencies;
- `yarn prod` - build minified assets;
- `yarn dev`- build assets with source maps (for development);
- `yarn watch`- start watcher;
- `yarn browser-sync` - start watcher with browser sync;

</details>

## Structure

```
── app/                                # Main theme functionality files
   ├── Base/                           # Base theme functions
   │   ├──Hooks.php                    # Registering hooks
   │   ├──Settings.php                 # Theme settings framework initialization
   │   ├──Shortcode.php                # Shortcode object configuration
   │   └──ShortcodesManager.php        # Register and load shortcodes
   │
   ├── config/                         # Base theme configuration
   │   ├──_animations.php              # CSS animations declaration
   │   ├──_social_icons.php            # Social CSS classes settings. Font Awesome default
   │   ├──_social_profiles.php         # Register social profiles meta for website options
   │   └──config.php                   # Bootstrap config file
   │
   ├── Handlers/                       # Theme hook handlers, main functionality
   │   ├──PostMeta/                    # Registering meta fields for post types. Each file separately. Runs by Base/Hooks
   │   ├──PostTypes/                   # Registering custom post types with Taxonomies. Runs by Base/Hooks
   │   ├──Settings/                    #
   │   │  └──ThemeSettings.php/        # Theme settings creation. Look in wp-admin Appearance/Theme Settings
   │   ├──Backend.php                  # wp-admin functions
   │   ├──Front.php                    # Basic Front handlers
   │   ├──HTTP2.php                    # HTTP2 support
   │   ├──LayoutGlobal.php             # Builds global theme layout using actions
   │   ├──LayoutSingle.php             # Builds single post / page etc. layout using actions
   │   ├──LazyLoad.php                 # Lazy load for images
   │   ├──Menu.php                     # Menu registration hooks and methods
   │   ├──OAuth.php                    # Oauth support
   │   ├──Optimization.php             # Removes unnecessary tags, performance optimization
   │   ├──Security.php                 # Provides some security options. Disable xmlrpc, etc
   │   ├──SetupTheme.php               # Setup theme handlers
   │   ├──VisualComposer.php           # Rewrite default WPBakery Page Builder functions
   │   └──VisualComposerExtends.php    # Extend default functional of WPBakery Page Builder
   │
   ├── Helper/                         # Helpers classes
   │   ├──ResponsiveImages/            # Modern responsive images with <picture> or <img>
   │   ├──Assets.php                   # Helper to work with assets processed by webpack
   │   ├──Front.php                    # Helper functions for templates and Front handler
   │   ├──Media.php                    # Functions to help to output and resize media
   │   ├──Utils.php                    # Other useful functions
   │   └──View.php                     # Connect and output templates
   │
   ├── Repository/                     # Repositories, help to receive data from DB
   │   └──*.php                        # Classes by each post type
   │
   ├── Shortcodes/                     # Shortcodes library (works with/without WPBakery Page Builder)
   │   ├── alert/                      # Alert block (icon, styling)
   │   ├── button/                     # Button element (icon, link, layout, styling)
   │   ├── contact_form/               # Form and form elements (checkbox, email, file uploader, text, datepicker and other)
   │   ├── google_map/                 # Improved Google Map
   │   ├── heading/                    # Heading h1,h2,h3,h4,h5,h6 (font styling, layout)
   │   ├── menu/                       # Custom menu with desktop and mobile devices support
   │   ├── news/                       # News block
   │   ├── posts/                      # Posts block (pagination, styling)
   │   ├── pricing_table/              # Pricing table (price settings, styling)
   │   ├── social_login/               # Login using social networks Facebook, Twitter, Google
   │   ├── tabs/                       # Tabs shortcode
   │   └── toggles/                    # Accordion shortcode
   │
   ├── templates/                      # HTML or other templates
   ├── Widgets/                        # Theme widgets
   ├── AbstractSingleton.php           # Abstract Class for creating Singleton Classes
   ├── App.php                         # Application Singleton. Entrypoint
   └── dev.php                         # Some developers functions for debug, logging, etc

── assets/                             # Theme assets
   ├── css/
   ├── fonts/
   ├── images/
   ├── js/
   └── libs/

── build/                              # Webpack configs
── dist/                               # The compiled assets
── template-parts/                     # Front templates

── vendor-custom/                      # Third-party development
   ├── aq_resizer/                     # Resizes WordPress images on the fly
   ├── carbon-fields/                  # Developer-oriented library for WordPress custom fields for all types of WordPress content
   ├── oauth/                          # Facebook, Google, Twitter libs for OAuth
   ├── tgm/                            # Required plugin installation
   └── wp-bootstrap-navwalker/         # Make awesome bootstrap menu

── 404.php
── comments.php
── footer.php
── functions.php
── gulpfile.js
── header.php
── index.php
── package.json
── page.php
── page-tpl-no-sidebar.php
── postcss.config.js
── screenshot.png
── sidebar.php
── single.php
── style.css
── webpack.config.js

```

## Blocks

### Overview

 Gutenberg Blocks in the `blocks/` folder are loaded with the autoloader. That is, you can simply create a folder of a new block with the necessary files and this blocks will be automatically available.

Use `StarterBlock` as an example to create new blocks.

 <!-- Each shortcode has its view files, its assets directory, which contains its own, individual css, js, images, fonts, etc. (these attachments need to be connected via wp_enqueue_style and wp_enqueue_script in the shortcode.php file, they are not automatically connected). This is necessary to ensure that shortcode shortcuts are loaded only when the shortcode is active and that you can transfer the shortcodes by simply copying the shortcode folder. -->

### Structure

The file structure can be any, you can add your files, but here are three files `config.php`, `ajax.php` and `shortcode.php` - loads by the autoloader.

```
── assets/              # All assets (styles, scripts, fonts, etc)
   ├── style.scss
   ├── scripts.js
   └── images/
── childs/              # Nested shortcodes, have the same structure
── view/                # Shortcode templates
── ajax.php             # Backend functions for ajax queries
── config.php           # Shortcode config (required file)
── shortcode.php        # Shortcode controller (required file)
── vc.php               # WPBakery Page Builder support

```
