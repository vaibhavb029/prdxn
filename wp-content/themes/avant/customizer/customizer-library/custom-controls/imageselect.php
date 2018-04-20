<?php
/**
 * Customize for Customizer help, extend the WP customizer
 *
 * @package 	Customizer_Library
 * @author		Devin Price, The Theme Foundry
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return NULL;
}

class Customizer_Library_Imageselect extends WP_Customize_Control {

	public $default;

	public function render_content() {
		global $_wp_additional_image_sizes;

		$dropdown = '<select data-customize-setting-link="' .$this->id. '">';

		$dropdown .= '<option value="full" ' . selected( 'full', $this->default, false ) . '>' . __( 'Full', 'avant' ) . '</option>';

		foreach ( get_intermediate_image_sizes() as $_size ) {
			$dropdown .= '<option value="' . $_size . '" ' . selected( $_size, $this->default, false ) . '>';

			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$dropdown .=  ucwords( str_replace( array('_', '-'), ' ', $_size ) ) . ' (' . get_option( "{$_size}_size_w" ) . ' X ' . get_option( "{$_size}_size_h" ) . ')';
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$dropdown .=  ucwords( str_replace( array('_', '-'), ' ', $_size ) ) . ' (' . $_wp_additional_image_sizes[ $_size ]['width'] . ' X ' . $_wp_additional_image_sizes[ $_size ]['height'] . ')';
			}

			$dropdown .= '</option>';
		}

		$dropdown .= '</select>';

		printf( '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>', $this->label, $dropdown );

		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . $this->description . '</span>';
		}

	}

}