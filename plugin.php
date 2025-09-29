<?php
/**
 * Meta Data
 *
 * Plugin core class, do not namespace.
 *
 * @package    Meta Data
 * @subpackage Core
 * @since      1.0.0
 */

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

// Access namespaced functions.
use function Meta_Data\{
	site,
	lang,
	is_rtl,
	meta_tags_standard,
	meta_tags_schema,
	meta_tags_open_graph,
	meta_tags_twitter,
	meta_tags_dublin_core,
	title_tag,
	meta_tag_language,
	meta_tag_keywords,
	meta_tag_title,
	meta_tag_description,
	meta_tag_author,
	meta_tag_copyright
};

class Meta_Data extends Plugin {

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
		require_once 'includes/functions.php';
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
			'title_sep'        => '|',
			'custom_sep'       => '',
			'default_ttag'     => '',
			'loop_ttag'        => '',
			'post_ttag'        => '',
			'page_ttag'        => '',
			'cat_ttag'         => '',
			'tag_ttag'         => '',
			'search_ttag'      => '',
			'error_ttag'       => '',
			'default_ttag_rtl' => '',
			'loop_ttag_rtl'    => '',
			'post_ttag_rtl'    => '',
			'page_ttag_rtl'    => '',
			'cat_ttag_rtl'     => '',
			'tag_ttag_rtl'     => '',
			'search_ttag_rtl'  => '',
			'error_ttag_rtl'   => '',
			'use_title_tag'    => true,
			'meta_noindex'     => false,
			'meta_keywords'    => '',
			'meta_use_schema'  => true,
			'meta_use_og'      => true,
			'meta_use_twitter' => true,
			'meta_use_dublin'  => false,
			'meta_custom'      => '',
			'footer_scripts'   => ''
		];

		// Array of custom hooks.
		$this->customHooks = [
			'all_meta_tags',
			'standard_tags',
			'schema_tags',
			'open_graph_tags',
			'twitter_tags',
			'dublin_core_tags',
			'meta_tag_title',
			'meta_tag_language',
			'meta_tag_keywords',
			'meta_tag_title',
			'meta_tag_description',
			'meta_tag_author',
			'meta_tag_copyright'
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
	 * @global object $L Language class.
	 * @global object $plugin Plugin class.
	 * @global object $site Site class.
	 * @return string Returns the markup of the form.
	 */
	public function form() {

		// Access global variables.
		global $L, $plugin, $site;

		$html  = '';
		ob_start();
		include( $this->phpPath() . '/views/page-form.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Minified asset
	 *
	 * Gets minified CSS and JavaScript files or
	 * non-minified if in debug mode.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the `.min` suffix or empty.
	 */
	public function minify() {

		$suffix = '.min';
		if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
			$suffix = '';
		}
		return $suffix;
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
		$sep = ' | ';

		if ( isset( $_GET['page'] ) && 'dummy' == $_GET['page'] ) {
			$layout['title'] = lang()->get( 'Meta Data' ) . "{$sep}" . site()->title();
		} else {
			$layout['title'] = lang()->get( 'Meta Data Guide' ) . "{$sep}" . site()->title();
		}
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
			lang()->get( 'Meta Data' )
		);
		return $html;
	}

	/**
	 * Head section
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the head content.
	 */
	public function siteHead() {

		$meta  = "\r";
		// $meta .= title_tag();
		$meta .= meta_tags_standard();

		if ( $this->meta_use_schema() ) {
			$meta .= meta_tags_schema();
		}

		if ( $this->meta_use_og() ) {
			$meta .= meta_tags_open_graph();
		}

		if ( $this->meta_use_twitter() ) {
			$meta .= meta_tags_twitter();
		}

		if ( $this->meta_use_dublin() ) {
			$meta .= meta_tags_dublin_core();
		}
		$meta .= "\r";

		echo $meta;
	}

	/**
	 * All meta tags hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function all_meta_tags() {}

	/**
	 * Standard tags hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function standard_tags() {}

	/**
	 * Schema tags hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function schema_tags() {}

	/**
	 * Open Graph tags hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function open_graph_tags() {}

	/**
	 * Twitter tags hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function twitter_tags() {}

	/**
	 * Dublin Core tags hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function dublin_core_tags() {}

	/**
	 * Language meta tag hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function meta_tag_language() {}

	/**
	 * Keywords meta tag hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function meta_tag_keywords() {}

	/**
	 * Title meta tag hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function meta_tag_title() {}

	/**
	 * Description meta tag hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function meta_tag_description() {}

	/**
	 * Author meta tag hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function meta_tag_author() {}

	/**
	 * Copyright meta tag hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function meta_tag_copyright() {}

	/**
	 * Option return functions
	 *
	 * @since  1.0.0
	 * @access public
	 */

	// @return string
	public function title_sep() {

		// Get field value;
		$sep = $this->getValue( 'title_sep' );

		// Reverse some for RTL languages.
		if ( is_rtl() ) {
			if ( '&gt;' === $sep ) {
				$sep = '&lt;';
			}
			if ( '→' === $sep ) {
				$sep = '←';
			}
			if ( '≫' === $sep ) {
				$sep = '≪';
			}
		}
		return $sep;
	}

	// @return string
	public function custom_sep() {
		return $this->getValue( 'custom_sep' );
	}

	// @return string
	public function default_ttag() {
		return $this->getValue( 'default_ttag' );
	}

	// @return string
	public function loop_ttag() {
		return $this->getValue( 'loop_ttag' );
	}

	// @return string
	public function post_ttag() {
		return $this->getValue( 'post_ttag' );
	}

	// @return string
	public function page_ttag() {
		return $this->getValue( 'page_ttag' );
	}

	// @return string
	public function cat_ttag() {
		return $this->getValue( 'cat_ttag' );
	}

	// @return string
	public function tag_ttag() {
		return $this->getValue( 'tag_ttag' );
	}

	// @return string
	public function search_ttag() {
		return $this->getValue( 'search_ttag' );
	}

	// @return string
	public function error_ttag() {
		return $this->getValue( 'error_ttag' );
	}

	// @return string
	public function default_ttag_rtl() {
		return $this->getValue( 'default_ttag_rtl' );
	}

	// @return string
	public function loop_ttag_rtl() {
		return $this->getValue( 'loop_ttag_rtl' );
	}

	// @return string
	public function post_ttag_rtl() {
		return $this->getValue( 'post_ttag_rtl' );
	}

	// @return string
	public function page_ttag_rtl() {
		return $this->getValue( 'page_ttag_rtl' );
	}

	// @return string
	public function cat_ttag_rtl() {
		return $this->getValue( 'cat_ttag_rtl' );
	}

	// @return string
	public function tag_ttag_rtl() {
		return $this->getValue( 'tag_ttag_rtl' );
	}

	// @return string
	public function search_ttag_rtl() {
		return $this->getValue( 'search_ttag_rtl' );
	}

	// @return string
	public function error_ttag_rtl() {
		return $this->getValue( 'error_ttag_rtl' );
	}

	// @return boolean
	public function meta_noindex() {
		return $this->getValue( 'meta_noindex' );
	}

	// @return string
	public function meta_keywords() {
		return $this->getValue( 'meta_keywords' );
	}

	// @return boolean
	public function meta_use_schema() {
		return $this->getValue( 'meta_use_schema' );
	}

	// @return boolean
	public function meta_use_og() {
		return $this->getValue( 'meta_use_og' );
	}

	// @return boolean
	public function meta_use_twitter() {
		return $this->getValue( 'meta_use_twitter' );
	}

	// @return boolean
	public function meta_use_dublin() {
		return $this->getValue( 'meta_use_dublin' );
	}

	// @return string
	public function meta_custom() {
		return "\n" . htmlspecialchars_decode( $this->getValue( 'meta_custom' ) ) . "\n";
	}

	// @return string
	public function footer_scripts() {
		return "\n" . htmlspecialchars_decode( $this->getValue( 'footer_scripts' ) ) . "\n";
	}
}
