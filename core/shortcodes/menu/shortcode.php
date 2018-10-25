<?php


if ( class_exists( 'WPBakeryShortCode' ) ) {

	class WPBakeryShortCode_Menu extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$shortcode_dir = dirname( __FILE__ );
			$shortcode     = basename( $shortcode_dir );
			$shortcode_uri = \ffblank\helper\utils::get_shortcodes_uri( $shortcode );

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			if ( ! empty( $atts['el_id'] ) ) {
				$id = 'shortcode-' . $atts['el_id'];
			} else {
				$id = '';
			}

			/** Shortcode data to output **/
			$data = array(
				'id'      => $id,
				'atts'    => $atts,
				'content' => $content,
				'wpb'     => $this
			);

			return FFBLANK()->view->load( '/view/view', $data, true, $shortcode_dir );

		}

	}
}
