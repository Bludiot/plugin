<?php
/**
 * Boilerplate
 *
 * Plugin core class, do not namespace.
 *
 * @package    Boilerplate
 * @subpackage Core
 * @since      1.0.0
 */

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

// Access namespaced functions.
use function Boilerplate\{
	site,
	url,
	lang,
	page
};

class Boilerplate extends Plugin {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Run parent constructor.
		parent :: __construct();

		// Include functionality.
		if ( $this->installed() ) {
			$this->get_files();
		}
	}

	/**
	 * Prepare plugin for installation
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function prepare() {
		$this->get_files();
	}

	/**
	 * Include functionality
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function get_files() {

		// Plugin path.
		$path = $this->phpPath();

		// Get plugin functions.
		foreach ( glob( $path . 'includes/*.php' ) as $filename ) {
			require_once $filename;
		}
	}

	/**
	 * Initiate plugin
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function init() {

		$this->dbFields = [
			'option_one' => true,
			'option_two' => '',
		];

		// Array of custom hooks.
		$this->customHooks = [
			'hook_one',
			'hook_two'
		];

		if ( ! $this->installed() ) {
			$Tmp = new dbJSON( $this->filenameDb );
			$this->db = $Tmp->db;
			$this->prepare();
		}
	}

	/**
	 * Admin settings form
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the markup of the form.
	 */
	public function form() {

		$html  = '';
		ob_start();
		include( $this->phpPath() . '/views/page-form.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Admin controller
	 *
	 * Change the text of the `<title>` tag.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global array $layout
	 * @return string Returns the head content.
	 */
	public function adminController() {

		// Access global variables.
		global $layout;

		// Title separator.
		$sep = '|';

		if ( isset( $_GET['page'] ) && 'dummy' == $_GET['page'] ) {
			$layout['title'] = lang()->get( 'Dummy Page' ) . " {$sep} " . site()->title();
		} else {
			$layout['title'] = lang()->get( 'Plugin Boilerplate Guide' ) . " {$sep} " . site()->title();
		}
	}

	/**
	 * Admin scripts & styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the head content.
	 */
	public function adminHead() {

		// Maybe get non-minified assets.
		$suffix = '.min';
		if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
			$suffix = '';
		}
		$assets = '';

		// Load only for this plugin's pages.
		if ( str_contains( url()->slug(), $this->className() ) ) :

			$assets .= '<script type="text/javascript" src="' . $this->domainPath() . "assets/js/backend{$suffix}.js?version=" . $this->getMetadata( 'version' ) . '"></script>' . PHP_EOL;

			$assets .= '<link rel="stylesheet" type="text/css" href="' . $this->domainPath() . "assets/css/backend{$suffix}.css?version=" . $this->getMetadata( 'version' ) . '" />' . PHP_EOL;
		endif;

		return $assets;
	}

	/**
	 * Admin info pages
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the markup of the page.
	 */
	public function adminView() {

		$html  = '';
		ob_start();
		include( $this->phpPath() . '/views/page-guide.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Sidebar link
	 *
	 * Link to the options screen in the admin sidebar menu.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed
	 */
	public function adminSidebar() {

		// Check user role.
		if ( ! checkRole( [ 'admin' ], false ) ) {
			return;
		}

		$url  = HTML_PATH_ADMIN_ROOT . 'configure-plugin/' . $this->className();
		$html = sprintf(
			'<a class="nav-link" href="%s"><span class="fa fa-code"></span>%s</a>',
			$url,
			lang()->get( 'Boilerplate' )
		);
		return $html;
	}

	/**
	 * Login scripts & styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function loginHead() {

		// Maybe get non-minified assets.
		$suffix = '';
		if ( ! $this->debug_mode() ) {
			$suffix = '.min';
		}

		$assets .= '<script type="text/javascript" src="' . $this->domainPath() . "assets/js/login{$suffix}.js?version=" . $this->getMetadata( 'version' ) . '"></script>' . PHP_EOL;
		$assets = '<link rel="stylesheet" type="text/css" href="' . $this->domainPath() . "assets/css/login{$suffix}.css?version=" . $this->getMetadata( 'version' ) . '" />' . PHP_EOL;

		return $assets;
	}

	/**
	 * Head section
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the head content.
	 */
	public function siteHead() {

		// Maybe get non-minified assets.
		$suffix = '.min';
		if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
			$suffix = '';
		}
		$assets = '';

		$assets .= '<script type="text/javascript" src="' . $this->domainPath() . "assets/js/frontend{$suffix}.js?version=" . $this->getMetadata( 'version' ) . '"></script>' . PHP_EOL;

		$assets .= '<link rel="stylesheet" type="text/css" href="' . $this->domainPath() . "assets/css/frontend{$suffix}.css?version=" . $this->getMetadata( 'version' ) . '" />' . PHP_EOL;

		return $assets;
	}

	/**
	 * Sidebar list
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the sidebar markup.
	 */
	public function siteSidebar() {

		$html  = '';
		ob_start();
		include( $this->phpPath() . '/views/site-sidebar.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Option return functions
	 *
	 * @since  1.0.0
	 * @access public
	 */

	// @return boolean
	public function option_one() {
		return $this->getValue( 'option_one' );
	}

	// @return string
	public function option_two() {
		return $this->getValue( 'option_two' );
	}
}
