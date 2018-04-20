<?php

/**
 * wp_trim_words preserves HTML tags
 */
function wonderplugin_slider_wp_trim_words( $text, $num_words = 55, $more = null ) {
	if ( null === $more ) {
		$more = __( '&hellip;' );
	}

	$original_text = $text;

	if ( strpos( _x( 'words', 'Word count type. Do not translate!' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
		$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
		preg_match_all( '/./u', $text, $words_array );
		$words_array = array_slice( $words_array[0], 0, $num_words + 1 );
		$sep = '';
	} else {
		$words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
		$sep = ' ';
	}

	if ( count( $words_array ) > $num_words ) {
		array_pop( $words_array );
		$text = implode( $sep, $words_array );
		$text = $text . $more;
	} else {
		$text = implode( $sep, $words_array );
	}

	return apply_filters( 'wp_trim_words', $text, $num_words, $more, $original_text );
}

function wonderplugin_slider_css_allow($allowed_attr) {

	if ( !is_array($allowed_attr) ) {
		$allowed_attr = array();
	}

	array_push($allowed_attr, 'position', 'top', 'left', 'bottom', 'right');

	return $allowed_attr;
}

function wonderplugin_slider_tags_allow( $allowedposttags ) {
		
	if ( isset($allowedposttags['a']) && is_array($allowedposttags['a']) )
		$allowedposttags['a']['download'] = true;
	
	if ( !isset($allowedposttags['source']) || !is_array($allowedposttags['source']) )
		$allowedposttags['source'] = array();
	
	$allowedposttags['source']['src'] = true;
	$allowedposttags['source']['type'] = true;
		
	return $allowedposttags;
}

function wonderplugin_slider_wp_check_filetype_and_ext($data, $file, $filename, $mimes) {

	$filetype = wp_check_filetype( $filename, $mimes );

	return array(
			'ext'             => $filetype['ext'],
			'type'            => $filetype['type'],
			'proper_filename' => $data['proper_filename']
	);
}