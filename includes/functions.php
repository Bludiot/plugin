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
