<?php

namespace StarterKit\Base;

use StarterKit\Helper\Utils;

/**
 * Shortcodes Manager
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 */
class ShortcodesManager {
	
	public $shortcodes = [];
	
	public $custom_css = [];
	
	public function init() {
		
		if ( Utils::is_vc() ) {
			add_action( 'vc_after_init', [ $this, 'load' ] );
		} else {
			add_action( 'init', [ $this, 'load' ] );
			add_action( 'wp_footer', [ $this, 'footer' ] );
		}
		
	}
	
	/**
	 * Load shortcodes
	 *
	 * @return void
	 **/
	public function load() {
		
		$dirs = glob( get_template_directory() . '/app/Shortcodes/*', GLOB_ONLYDIR );
		
		foreach ( $dirs as $shortcode_dir ) {
			
			$parent = basename( $shortcode_dir );
			
			// Load child's shortcodes if exist
			$childs = [];
			if ( is_dir( $shortcode_dir . '/childs' ) ) {
				$dirs_childs = glob( $shortcode_dir . '/childs/*', GLOB_ONLYDIR );
				foreach ( $dirs_childs as $shortcode_child_dir ) {
					$shortcode = $this->load_shortcode( $shortcode_child_dir, $parent );
					$childs[]  = $shortcode->shortcode;
				}
			}
			
			// Load shortcode
			$this->load_shortcode( $shortcode_dir, '', $childs );
			
		}
		
		// add filter of all shortcodes list
		$this->shortcodes = apply_filters( 'StarterKit/shortcodes', $this->shortcodes );
		
	}
	
	public function load_shortcode( $shortcode_dir, $parent = '', $childs = [] ) {
		$config = require_once( $shortcode_dir . '/config.php' );
		
		// Add childs shortcodes to container config
		if ( ! empty( $childs ) && isset( $config['as_parent'] ) ) {
			$only = explode( ',', $config['as_parent']['only'] );
			foreach ( $childs as $child ) {
				if ( ! in_array( $child, $only ) ) {
					$only[] = $child;
				}
			}
			$config['as_parent']['only'] = implode( ',', $only );
		}
		
		require_once( $shortcode_dir . '/shortcode.php' );
		
		$class_name = 'StarterKitShortcode_' . str_replace( '-', '_', $config['base'] );
		if ( class_exists( $class_name ) ) {
			$this->shortcodes[ $config['base'] ] = new $class_name ( [
				'config'        => $config,
				'shortcode_dir' => $shortcode_dir,
				'shortcode_uri' => Utils::get_shortcodes_uri(
					! $parent ? $config['base'] : $parent . '/childs/' . $config['base']
				),
			
			] );
			
			return $this->shortcodes[ $config['base'] ];
		}
	}
	
	
	public function content( $shortcode, $atts, $content = '' ) {
		return $this->shortcodes[ $shortcode ]->content( $atts, $content );
	}
	
	public function footer() {
		
		echo '<style>';
		echo implode( '', $this->custom_css );
		echo '</style>';
		/*
		if (!empty($this->custom_css)) {
			wp_add_inline_style( 'custom-style', implode('', $this->custom_css) );
		}
		*/
	}
	
}
