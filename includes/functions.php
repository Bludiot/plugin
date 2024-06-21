<?php
/**
 * Functions
 *
 * @package    Boilerplate
 * @subpackage Core
 * @category   Functions
 * @since      1.0.0
 */

namespace Boilerplate;

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

/**
 * Plugin object
 *
 * Gets this plugin's core class.
 *
 * @since  1.0.0
 * @return object Returns the class object.
 */
function plugin() {
	return new \Boilerplate();
}

/**
 * Site class object
 *
 * Function to use inside other functions and
 * methods rather than calling the global.
 *
 * @since  1.0.0
 * @global object $site Site class
 * @return object
 */
function site() {
	global $site;
	return $site;
}

/**
 * Url class object
 *
 * Function to use inside other functions and
 * methods rather than calling the global.
 *
 * @since  1.0.0
 * @global object $url Url class
 * @return object
 */
function url() {
	global $url;
	return $url;
}

/**
 * Language class object
 *
 * Function to use inside other functions and
 * methods rather than calling the global.
 *
 * @since  1.0.0
 * @global object $L Language class
 * @return object
 */
function lang() {
	global $L;
	return $L;
}

/**
 * Page class object
 *
 * Function to use inside other functions and
 * methods rather than calling the global.
 *
 * @since  1.0.0
 * @global object $page Page class
 * @return object
 */
function page() {
	global $page;
	return $page;
}

/**
 * Website domain
 *
 * Returns the site URL setting or
 * the DOMAIN_BASE constant.
 *
 * @since  1.0.0
 * @return string
 */
function site_domain() {

	if ( site()->url() ) {
		return site()->url();
	}
	return DOMAIN_BASE;
}

/**
 * User logged in
 *
 * @since  1.0.0
 * @global object $login The Login class.
 * @return boolean Returns true if the current user is logged in.
 */
function user_logged_in() {

	// Access global variables.
	global $login;

	if ( $login->isLogged() ) {
		return true;
	}
	return false;
}

/**
 * User role
 *
 * @since  1.0.0
 * @return mixed Returns the logged-in user role or false.
 */
function user_role() {

	if ( ! user_logged_in() ) {
		return false;
	}
	$user = new \User( \Session :: get( 'username' ) );
	return $user->role();
}

/**
 * Current language
 *
 * The language from site settings.
 *
 * @since  1.0.0
 * @return string
 */
function current_lang() {
	return lang()->currentLanguageShortVersion();
}

/**
 * Is RTL language
 *
 * @since  1.0.0
 * @param  mixed $langs Arguments to be passed.
 * @param  array $rtl Default arguments.
 * @return boolean Returns true if site is in RTL language.
 */
function is_rtl( $langs = null, $rtl = [] ) {

	$rtl = [
		'ar',
		'fa',
		'he',
		'ks',
		'ku',
		'pa',
		'ps',
		'sd',
		'ug',
		'ur'
	];

	// Maybe override defaults.
	if ( is_array( $langs ) && $langs ) {
		$langs = array_merge( $rtl, $langs );
	} else {
		$langs = $rtl;
	}

	if ( in_array( current_lang(), $rtl ) ) {
		return true;
	}
	return false;
}

/**
 * Is home
 *
 * If the main loop is on the front page.
 *
 * @since  1.0.0
 * @return boolean
 */
function is_home() {

	if ( 'home' == url()->whereAmI() ) {
		return true;
	}
	return false;
}

/**
 * Is category
 *
 * Whether the current page is displaying
 * the category loop.
 *
 * @since  1.0.0
 * @return boolean Returns true if in the main loop.
 */
function is_cat() {

	if ( 'category' == url()->whereAmI() ) {
		return true;
	}
	return false;
}

/**
 * Is tag
 *
 * Whether the current page is displaying
 * the tag loop.
 *
 * @since  1.0.0
 * @return boolean Returns true if in the main loop.
 */
function is_tag() {

	if ( 'tag' == url()->whereAmI() ) {
		return true;
	}
	return false;
}

/**
 * Is main loop
 *
 * Whether the current page is displaying
 * the main posts loop.
 *
 * Excludes category and tag loops.
 *
 * @since  1.0.0
 * @return boolean Returns true if in the main loop.
 */
function is_main_loop() {

	if ( 'blog' == url()->whereAmI() && ! is_cat() && ! is_tag() ) {
		return true;
	}
	return false;
}

/**
 * Is loop page
 *
 * Whether the current page is displaying
 * a posts loop.
 *
 * Excludes search pages.
 *
 * @since  1.0.0
 * @return boolean Returns true if in a loop.
 */
function is_loop_page() {

	$loop_page = false;
	if ( is_main_loop() ) {
		$loop_page = true;
	}
	if ( is_cat() ) {
		$loop_page = true;
	}
	if ( is_tag() ) {
		$loop_page = true;
	}
	return $loop_page;
}

/**
 * Loop not home
 *
 * If the main loop is not the website home.
 *
 * @since  1.0.0
 * @return boolean Returns true if loop slug is set.
 */
function is_loop_not_home() {

	if ( site()->getField( 'uriBlog' ) ) {
		return true;
	}
	return false;
}

/**
 * Is static loop
 *
 * If a static page has the same slug as the loop slug.
 *
 * @since  1.0.0
 * @return boolean Return whether that page exists.
 */
function is_static_loop() {

	if ( static_loop_page() ) {
		return true;
	}
	return false;
}

/**
 * Static loop page
 *
 * @since  1.0.0
 * @return mixed Returns the static loop page object or
 *               returns false if the page doesn't exist.
 */
function static_loop_page() {

	// Get the blog slug setting.
	$loop_field = site()->getField( 'uriBlog' );

	// Remove slashes from field value, if set.
	$loop_key   = str_replace( '/', '', $loop_field );

	// Build a page using blog slug setting.
	$loop_page  = buildPage( $loop_key );

	// Return whether that page exists (could be built).
	if ( $loop_page ) {
		return $loop_page;
	}
	return false;
}

/**
 * Is page
 *
 * If on a page, static or not.
 *
 * @since  1.0.0
 * @return boolean
 */
function is_page() {

	if ( 'page' == url()->whereAmI() ) {
		return true;
	}
	return false;
}

/**
 * Is search
 *
 * If on a search page.
 *
 * No need to check for a search plugin because
 * it is the plugin that defines the location,
 * so the `whereAmI()` function will return false.
 *
 * @since  1.0.0
 * @return boolean
 */
function is_search() {

	if ( 'search' == url()->whereAmI() ) {
		return true;
	}
	return false;
}

/**
 * Is 404
 *
 * @since  1.0.0
 * @return boolean
 */
function is_404() {

	if ( url()->notFound() ) {
		return true;
	}
	return false;
}

/**
 * Page type
 *
 * Whether the page object is static or not.
 *
 * @since  1.0.0
 * @return mixed Returns the page type or null.
 */
function page_type() {

	if ( ! is_page() ) {
		return null;
	}

	if ( page()->isStatic() ) {
		return 'page';
	}
	return 'post';
}

/**
 * Is front page
 *
 * If the front page is not the loop.
 *
 * @since  1.0.0
 * @return boolean
 */
function is_front_page() {

	if ( ! is_page() ) {
		return false;
	}

	if ( site()->homepage() && page()->key() == site()->homepage() ) {
		return true;
	}
	return false;
}

/**
 * Auto paragraph
 *
 * Replaces double line breaks with paragraph elements.
 *
 * Modified from WordPress' `wpautop` function.
 *
 * A group of regex replaces used to identify text formatted with newlines and
 * replace double line breaks with HTML paragraph tags. The remaining line breaks
 * after conversion become `<br />` tags, unless `$br` is set to '0' or 'false'.
 *
 * @since  1.0.0
 * @param  string $text The text which has to be formatted.
 * @param  bool   $br   Optional. If set, this will convert all remaining line breaks
 *                      after paragraphing.
 * @return string Text which has been converted into correct paragraph tags.
 */
function autop( $text, $br = true ) {

	$pre_tags = [];

	if ( trim( $text ) === '' ) {
		return '';
	}

	// Just to make things a little easier, pad the end.
	$text = $text . "\n";

	/*
	 * Pre tags shouldn't be touched by autop.
	 * Replace pre tags with placeholders and bring them back after autop.
	 */
	if ( str_contains( $text, '<pre' ) ) {
		$text_parts = explode( '</pre>', $text );
		$last_part  = array_pop( $text_parts );
		$text       = '';
		$i          = 0;

		foreach ( $text_parts as $text_part ) {
			$start = strpos( $text_part, '<pre' );

			// Malformed HTML?
			if ( false === $start ) {
				$text .= $text_part;
				continue;
			}

			$name = "<pre pre-tag-$i></pre>";
			$pre_tags[ $name ] = substr( $text_part, $start ) . '</pre>';

			$text .= substr( $text_part, 0, $start ) . $name;
			++$i;
		}
		$text .= $last_part;
	}

	// Change multiple <br>'s into two line breaks, which will turn into paragraphs.
	$text = preg_replace( '|<br\s*/?>\s*<br\s*/?>|', "\n\n", $text );

	$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

	// Add a double line break above block-level opening tags.
	$text = preg_replace( '!(<' . $allblocks . '[\s/>])!', "\n\n$1", $text );

	// Add a double line break below block-level closing tags.
	$text = preg_replace( '!(</' . $allblocks . '>)!', "$1\n\n", $text );

	// Add a double line break after hr tags, which are self closing.
	$text = preg_replace( '!(<hr\s*?/?>)!', "$1\n\n", $text );

	// Standardize newline characters to "\n".
	$text = str_replace( [ "\r\n", "\r" ], "\n", $text );

	// Collapse line breaks before and after <option> elements so they don't get autop'd.
	if ( str_contains( $text, '<option' ) ) {
		$text = preg_replace( '|\s*<option|', '<option', $text );
		$text = preg_replace( '|</option>\s*|', '</option>', $text );
	}

	/*
	 * Collapse line breaks inside <object> elements, before <param> and <embed> elements
	 * so they don't get autop'd.
	 */
	if ( str_contains( $text, '</object>' ) ) {
		$text = preg_replace( '|(<object[^>]*>)\s*|', '$1', $text );
		$text = preg_replace( '|\s*</object>|', '</object>', $text );
		$text = preg_replace( '%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $text );
	}

	/*
	 * Collapse line breaks inside <audio> and <video> elements,
	 * before and after <source> and <track> elements.
	 */
	if ( str_contains( $text, '<source' ) || str_contains( $text, '<track' ) ) {
		$text = preg_replace( '%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $text );
		$text = preg_replace( '%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $text );
		$text = preg_replace( '%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $text );
	}

	// Collapse line breaks before and after <figcaption> elements.
	if ( str_contains( $text, '<figcaption' ) ) {
		$text = preg_replace( '|\s*(<figcaption[^>]*>)|', '$1', $text );
		$text = preg_replace( '|</figcaption>\s*|', '</figcaption>', $text );
	}

	// Remove more than two contiguous line breaks.
	$text = preg_replace( "/\n\n+/", "\n\n", $text );

	// Split up the contents into an array of strings, separated by double line breaks.
	$paragraphs = preg_split( '/\n\s*\n/', $text, -1, PREG_SPLIT_NO_EMPTY );

	// Reset $text prior to rebuilding.
	$text = '';

	// Rebuild the content as a string, wrapping every bit with a <p>.
	foreach ( $paragraphs as $paragraph ) {
		$text .= '<p>' . trim( $paragraph, "\n" ) . "</p>\n";
	}

	// Under certain strange conditions it could create a P of entirely whitespace.
	$text = preg_replace( '|<p>\s*</p>|', '', $text );

	// Add a closing <p> inside <div>, <address>, or <form> tag if missing.
	$text = preg_replace( '!<p>([^<]+)</(div|address|form)>!', '<p>$1</p></$2>', $text );

	// If an opening or closing block element tag is wrapped in a <p>, unwrap it.
	$text = preg_replace( '!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $text );

	// In some cases <li> may get wrapped in <p>, fix them.
	$text = preg_replace( '|<p>(<li.+?)</p>|', '$1', $text );

	// If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
	$text = preg_replace( '|<p><blockquote([^>]*)>|i', '<blockquote$1><p>', $text );
	$text = str_replace( '</blockquote></p>', '</p></blockquote>', $text );

	// If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
	$text = preg_replace( '!<p>\s*(</?' . $allblocks . '[^>]*>)!', '$1', $text );

	// If an opening or closing block element tag is followed by a closing <p> tag, remove it.
	$text = preg_replace( '!(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $text );

	// Optionally insert line breaks.
	if ( $br ) {

		// Normalize <br>
		$text = str_replace( [ '<br>', '<br/>' ], '<br />', $text );

		// Replace any new line characters that aren't preceded by a <br /> with a <br />.
		$text = preg_replace( '|(?<!<br />)\s*\n|', "<br />\n", $text );
	}

	// If a <br /> tag is after an opening or closing block tag, remove it.
	$text = preg_replace( '!(</?' . $allblocks . '[^>]*>)\s*<br />!', '$1', $text );

	// If a <br /> tag is before a subset of opening or closing block tags, remove it.
	$text = preg_replace( '!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $text );
	$text = preg_replace( "|\n</p>$|", '</p>', $text );

	// Replace placeholder <pre> tags with their original content.
	if ( ! empty( $pre_tags ) ) {
		$text = str_replace( array_keys( $pre_tags ), array_values( $pre_tags ), $text );
	}

	return $text;
}

/**
 * Read numbers
 *
 * Converts an integer to its textual representation.
 *
 * @since  1.0.0
 * @param  integer $number the number to convert to a textual representation
 * @param  integer $depth the number of times this has been recursed
 * @return string Returns a word corresponding to a numeral
 */
function numbers_to_text( $number, $depth = 0 ) {

	$number = (int)$number;
	$text   = '';

	// If it's any other negative, just flip it and call again.
	if ( $number < 0 ) {
		return 'negative ' + numbers_to_text( - $number, 0 );
	}

	// 100 and above.
	if ( $number > 99 ) {

		// 1000 and higher.
		if ( $number > 999 ) {
			$text .= numbers_to_text( $number / 1000, $depth + 3 );
		}

		// Last three digits.
		$number %= 1000;

		// As long as the first digit is not zero.
		if ( $number > 99 ) {
			$text .= numbers_to_text( $number / 100, 2 ) . lang()->get( ' hundred' ) . "\n";
		}

		// Last two digits.
		$text .= numbers_to_text( $number % 100, 1 );

	// From 0 to 99.
	} else {

		$mod = floor( $number / 10 );

		// Ones place.
		if ( 0 == $mod ) {
			if ( 1 == $number ) {
				$text .= lang()->get( 'one' );
			} elseif ( 2 == $number ) {
				$text .= lang()->get( 'two' );
			} elseif ( 3 == $number ) {
				$text .= lang()->get( 'three' );
			} elseif ( 4 == $number ) {
				$text .= lang()->get( 'four' );
			} elseif ( 5 == $number ) {
				$text .= lang()->get( 'five' );
			} elseif ( 6 == $number ) {
				$text .= lang()->get( 'six' );
			} elseif ( 7 == $number ) {
				$text .= lang()->get( 'seven' );
			} elseif ( 8 == $number ) {
				$text .= lang()->get( 'eight' );
			} elseif ( 9 == $number ) {
				$text .= lang()->get( 'nine' );
			}

		// if there's a one in the ten's place.
		} elseif ( 1 == $mod ) {
			if ( 10 == $number ) {
				$text .= lang()->get( 'ten' );
			} elseif ( 11 == $number ) {
				$text .= lang()->get( 'eleven' );
			} elseif ( 12 == $number ) {
				$text .= lang()->get( 'twelve' );
			} elseif ( 13 == $number ) {
				$text .= lang()->get( 'thirteen' );
			} elseif ( 14 == $number ) {
				$text .= lang()->get( 'fourteen' );
			} elseif ( 15 == $number ) {
				$text .= lang()->get( 'fifteen' );
			} elseif ( 16 == $number ) {
				$text .= lang()->get( 'sixteen' );
			} elseif ( 17 == $number ) {
				$text .= lang()->get( 'seventeen' );
			} elseif ( 18 == $number ) {
				$text .= lang()->get( 'eighteen' );
			} elseif ( 19 == $number ) {
				$text .= lang()->get( 'nineteen' );
			}

		// if there's a different number in the ten's place.
		} else {
			if ( 2 == $mod ) {
				$text .= lang()->get( 'twenty' );
			} elseif ( 3 == $mod ) {
				$text .= lang()->get( 'thirty' );
			} elseif ( 4 == $mod ) {
				$text .= lang()->get( 'forty' );
			} elseif ( 5 == $mod ) {
				$text .= lang()->get( 'fifty' );
			} elseif ( 6 == $mod ) {
				$text .= lang()->get( 'sixty' );
			} elseif ( 7 == $mod ) {
				$text .= lang()->get( 'seventy' );
			} elseif ( 8 == $mod ) {
				$text .= lang()->get( 'eighty' );
			} elseif ( 9 == $mod ) {
				$text .= lang()->get( 'ninety' );
			}

			if ( ( $number % 10 ) != 0 ) {

				// Get rid of space at end.
				$text  = rtrim( $text );
				$text .= '-';
			}
			$text .= numbers_to_text( $number % 10, 0 );
		}
	}

	if ( 0 != $number ) {
		if ( 3 == $depth ) {
			$text .= lang()->get( ' thousand' ) . "\n";
		} elseif ( 6 == $depth ) {
			$text .= lang()->get( ' million' ) . "\n";
		}

		if ( 9 == $depth ) {
			$text .= lang()->get( ' billion' ) . "\n";
		}
	}
	return $text;
}

/**
 * File size format
 *
 * Converts a number of bytes to the largest unit the bytes will fit into.
 * Taken from WordPress.
 *
 * It is easier to read 1 KB than 1024 bytes and 1 MB than 1048576 bytes. Converts
 * number of bytes to human readable number by taking the number of that unit
 * that the bytes will go into it. Supports YB value.
 *
 * Please note that integers in PHP are limited to 32 bits, unless they are on
 * 64 bit architecture, then they have 64 bit size. If you need to place the
 * larger size then what PHP integer type will hold, then use a string. It will
 * be converted to a double, which should always have 64 bit length.
 *
 * Technically the correct unit names for powers of 1024 are KiB, MiB etc.
 *
 * @since  1.0.0
 * @param  integer|string $bytes Number of bytes. Note max integer size for integers.
 * @param  integer $decimals Optional. Precision of number of decimal places. Default 0.
 * @return mixed Number string on success, false on failure.
 */
function size_format( $bytes, $decimals = 0 ) {

	// Read bytes in chunks.
	$KB = 1024;
	$MB = 1024 * $KB;
	$GB = 1024 * $MB;
	$TB = 1024 * $GB;

	// Assign relevant units.
	$units = [
		'TB' => $TB,
		'GB' => $GB,
		'MB' => $MB,
		'KB' => $KB,
		'B'  => 1,
	];

	// Return 0 bytes if so.
	if ( 0 === $bytes ) {
		return '0 B';
	}

	// Return the size in relevant units.
	foreach ( $units as $unit => $mag ) {
		if ( (float) $bytes >= $mag ) {
			return number_format( $bytes / $mag, abs( (int) $decimals ) ) . ' ' . $unit;
		}
	}
	return false;
}

/**
 * Hex to RGB
 *
 * Convert a 3- or 6-digit hexadecimal color to
 * an associative RGB array.
 *
 * @param  string $color The color in hex format.
 * @param  boolean $opacity Whether to return the RGB color as opaque.
 * @return string Returns the rgb(a) value.
 */
function hex_to_rgb( $color, $opacity = false ) {

	if ( empty( $color ) ) {
		return false;
	}

	if ( '#' === $color[0] ) {
		$color = substr( $color, 1 );
	}

	if ( 6 === strlen( $color ) ) {
		$hex = [ $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] ];
	} elseif ( 3 === strlen( $color ) ) {
		$hex = [ $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] ];
	} else {
		return null;
	}
	$rgb = array_map( 'hexdec', $hex );

	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}
		$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',', $rgb ) . ')';
	}
	return $output;
}
