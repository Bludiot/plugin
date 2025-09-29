<?php
/**
 * Functions
 *
 * @package    Meta Data
 * @subpackage Core
 * @category   Functions
 * @since      1.0.0
 */

namespace Meta_Data;

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
	return new \Meta_Data();
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
 * System can search
 *
 * Checks if the system has search functionality.
 *
 * @since  1.0.0
 * @return boolean Returns true if a search plugin is activated.
 */
function can_search() {
	if (
		getPlugin( 'Search_Forms' ) ||
		getPlugin( 'pluginSearch' )
	) {
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
 * Loop data
 *
 * Gets data for the loop, especially when
 * using a static front page.
 *
 * @since  1.0.0
 * @global array  $content array of site content
 * @global object $pages Pages class
 * @return array  Returns an array of loop data.
 */
function loop_data() {

	// Access global variables.
	global $content, $pages;

	// Null if in search results (global errors).
	if ( is_search() ) {
		return null;
	}

	// Posts loop type.
	$loop_type = 'blog';
	if ( configureight() ) {
		$loop_type = configureight()->loop_type();
	}

	// Default loop description.
	$description = site()->title();
	if ( configureight() ) {
		if ( ! empty( configureight()->loop_description() ) ) {
			$description = configureight()->loop_description();
		}
	}

	// Default data array.
	$data = [
		'post_count'  => $pages->count(),
		'show_posts'  => site()->getField( 'itemsPerPage' ),
		'location'    => 'home',
		'key'         => false,
		'url'         => loop_url(),
		'slug'        => str_replace( '/', '', site()->getField( 'uriBlog' ) ),
		'template'    => false,
		'type'        => $loop_type,
		'title'       => $loop_type,
		'description' => $description,
		'cover'       => false,
	];

	if ( ! is_static_loop() ) {
		return $data;
	} else {

		// Get data from the static loop page.
		$loop_page = static_loop_page();

		// Description from the static loop page.
		if ( ! empty( $loop_page->description() ) ) {
			$description = $loop_page->description();
		}

		$static_data = [
			'location'    => 'page',
			'key'         => $loop_page->key(),
			'slug'        => $loop_page->slug(),
			'template'    => $loop_page->template(),
			'title'       => $loop_page->title(),
			'description' => $description,
			'cover'       => $loop_page->coverImage()
		];
		$data = array_merge( $data, $static_data );
	}
	return $data;
}

/**
 * Loop post count
 *
 * Gets loop post count from the loop data.
 *
 * @since  1.0.0
 * @return integer Returns the loop post count.
 */
function loop_post_count() {
	$loop_data = loop_data();
	return $loop_data['post_count'];
}

/**
 * Loop show posts
 *
 * Gets loop posts per page from the loop data.
 *
 * @since  1.0.0
 * @return integer Returns the loop posts per page.
 */
function loop_show_posts() {
	$loop_data = loop_data();
	return $loop_data['show_posts'];
}

/**
 * Loop location
 *
 * Gets loop location from the loop data.
 *
 * @since  1.0.0
 * @return string Returns the loop location.
 */
function loop_location() {
	$loop_data = loop_data();
	return $loop_data['location'];
}

/**
 * Loop key
 *
 * Gets loop key from the loop data.
 *
 * @since  1.0.0
 * @return mixed Returns the loop key or false.
 */
function loop_key() {
	$loop_data = loop_data();
	return $loop_data['key'];
}

/**
 * Loop URL
 *
 * Gets loop URL from the loop data.
 *
 * @since  1.0.0
 * @return string Returns the loop URL.
 */
function loop_url() {
	$loop_data = loop_data();
	return $loop_data['url'];
}

/**
 * Loop slug
 *
 * Gets loop slug from the loop data.
 *
 * @since  1.0.0
 * @return string Returns the loop slug.
 */
function loop_slug() {
	$loop_data = loop_data();
	return $loop_data['slug'];
}

/**
 * Loop template
 *
 * Gets loop template from the loop data.
 *
 * @since  1.0.0
 * @return mixed Returns the loop template or false.
 */
function loop_template() {
	$loop_data = loop_data();
	return $loop_data['template'];
}

/**
 * Loop type
 *
 * Gets loop type from the loop data.
 *
 * @since  1.0.0
 * @return string Returns the loop type.
 */
function loop_type() {
	$loop_data = loop_data();
	return $loop_data['type'];
}

/**
 * Loop title
 *
 * Gets loop title from the loop data.
 *
 * @since  1.0.0
 * @return string Returns the loop title.
 */
function loop_title() {
	$loop_data = loop_data();
	return $loop_data['title'];
}

/**
 * Loop description
 *
 * Gets loop description from the loop data.
 *
 * @since  1.0.0
 * @return string Returns the loop description.
 */
function loop_description() {
	$loop_data = loop_data();

	return $loop_data['description'];
}

/**
 * Loop cover image
 *
 * Gets loop cover image from the loop data.
 *
 * @since  1.0.0
 * @return mixed Returns the loop cover image or false.
 */
function loop_cover() {
	$loop_data = loop_data();
	return $loop_data['cover'];
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
 * Configure 8 compatibility
 *
 * @since  1.0.0
 * @return mixed
 */
function configureight() {

	if ( \getPlugin( 'configureight' ) ) {
		return \getPlugin( 'configureight' );
	}
	return false;
}

/**
 * User Profiles compatibility
 *
 * @since  1.0.0
 * @return mixed
 */
function profiles() {

	if ( getPlugin( 'User_Profiles' ) ) {
		return new \User_Profiles();
	}
	return false;
}

/**
 * Is user
 *
 * If on a user page.
 *
 * @since  1.0.0
 * @return boolean
 */
function is_user() {

	if ( profiles() ) {
		if ( profiles()->users_slug() == url()->whereAmI() ) {
			return true;
		}
	}
	return false;
}

/**
 * Get cover image source
 *
 * @since  1.0.0
 * @return string
 */
function get_cover_src() {

	$src     = '';
	$default = '';
	if ( configureight() ) {
		if ( configureight()->cover_src() ) {
			$default = configureight()->cover_src();
		}
	}

	// If in loop pages.
	if ( is_main_loop() ) {
		if ( is_static_loop() ) {
			$loop  = loop_data();
			$build = buildPage( $loop['slug'] );
			$uuid   = $build->uuid();
			$dir    = PATH_UPLOADS_PAGES . $uuid . DS;
			$files  = \Filesystem :: listFiles( $dir, '*', '*', true, 0 );
			$images = [];

			// Get the URL for each full-size image.
			foreach ( $files as $file ) {
				$images[] = DOMAIN_UPLOADS_PAGES . $uuid . '/' . str_replace( $dir, '', $file );
			}

			if ( $build->custom( 'random_cover' ) ) {
				$rand = array_rand( $images );
				$src  = $images[$rand];
			} elseif ( ! empty( $loop['cover'] ) ) {
				$src = $loop['cover'];
			} else {
				$src = $default;
			}
		} elseif ( $default ) {
			$src = $default;
		} elseif ( page()->coverImage() ) {
			$src = page()->coverImage();
		}

	// If on a singular page.
	} elseif ( is_page() ) {
		if ( page()->coverImage() ) {
			$src = page()->coverImage();
		} elseif ( $default ) {
			$src = $default;
		}

	// Default.
	} elseif ( $default ) {
		$src = $default;
	}
	return $src;
}

/**
 * Has cover image
 *
 * @since  1.0.0
 * @return boolean
 */
function has_cover( $default = '' ) {

	// Start false, conditionally true.
	$cover = false;

	// Default cover from theme plugin.
	if ( configureight() ) {
		if ( configureight()->cover_src() ) {
			$default = configureight()->cover_src();
		}
	} else {
		$default = get_cover_src();
	}

	// If on a singular post or page.
	if ( is_main_loop() && ! loop_cover() ) {
		$cover = false;
	} elseif ( is_user() ) {
		if ( configureight() ) {
			if (
				'header' == configureight()->cover_in_profile() ||
				'both'   == configureight()->cover_in_profile()
			) {
				$cover = true;
			} else {
				$cover = false;
			}
		} else {
			$cover = true;
		}
	} elseif ( is_page() ) {

		// If the page has a cover image set.
		if ( ! configureight() && page()->coverImage() ) {
			$cover = true;
		}

		// False if `no-cover` template.
		if ( str_contains( page()->template(), 'no-cover' ) ) {
			$cover = false;
		}

		if ( configureight() ) {
			if ( 'page' == page_type() ) {
				if ( 'none' == configureight()->cover_in_page() ) {
					if ( str_contains( page()->template(), 'full-cover' ) && configureight()->cover_src() ) {
						$cover = true;
					} elseif ( str_contains( page()->template(), 'default-cover' ) && configureight()->cover_src() ) {
						$cover = true;
					} elseif ( page()->custom( 'random_cover' ) && configureight()->cover_src() ) {
						$cover = true;
					} else {
						$cover = false;
					}
				} elseif ( configureight()->cover_src() ) {
					$cover = true;
				}
			} else {
				if ( 'none' == configureight()->cover_in_post() ) {
					if ( str_contains( page()->template(), 'full-cover' ) && configureight()->cover_src() ) {
						$cover = true;
					} elseif ( str_contains( page()->template(), 'default-cover' ) && configureight()->cover_src() ) {
						$cover = true;
					} elseif ( page()->custom( 'random_cover' ) && configureight()->cover_src() ) {
						$cover = true;
					} else {
						$cover = false;
					}
				} elseif ( configureight()->cover_src() ) {
					$cover = true;
				}
			}

		// If the theme plugin has a default cover image set.
		} elseif ( ! empty( $default ) ) {

			if ( filter_var( $default, FILTER_VALIDATE_URL ) ) {
				$cover = true;
			} elseif ( file_exists( THEME_DIR . $default ) ) {
				$cover = true;
			}

			// False if `no-cover` template.
			if ( str_contains( page()->template(), 'no-cover' ) ) {
				$cover = false;
			}
		}

	// If on a loop page.
	} elseif ( $default ) {

		if ( filter_var( $default, FILTER_VALIDATE_URL ) ) {
			$cover = true;
		} elseif ( file_exists( THEME_DIR . $default ) ) {
			$cover = true;
		}
	}
	return $cover;
}

/**
 * Page description
 *
 * Gets the page description or
 * an excerpt of the content.
 *
 * @since  1.0.0
 * @return string Returns the description.
 */
function page_description( $key = '' ) {

	if ( empty( $key ) ) {
		$key = page()->key();
	}

	$page = buildPage( $key );

	if ( $page->description() ) {
		$page_desc = $page->description();
	} else {
		$page_desc  = substr( strip_tags( $page->content() ), 0, 85 );
		if ( ! empty( $page->content() ) && ! ctype_space( $page->content() ) ) {
			$page_desc .= '&hellip;';
		}
	}
	return $page_desc;
}

/**
 * Frontend title tag
 *
 * @since  1.0.0
 * @global object $categories The Categories class.
 * @global object $L The Language class.
 * @global object $page The Page class.
 * @global object $site The Site class.
 * @global object $tags The Tags class.
 * @global object $url The Url class.
 * @return string Returns the meta tag.
 */
function title_tag() {

	global $categories, $L, $page, $site, $tags, $url;

	// Title separator.
	$sep = plugin()->dbFields['title_sep'];
	if ( 'custom' == plugin()->title_sep() && plugin()->custom_sep() ) {
		$sep = plugin()->custom_sep();
	} elseif ( 'custom' != plugin()->title_sep() ) {
		$sep = plugin()->title_sep();
	}

	// Loop name.
	$loop_name = '';
	if ( 'blog' == $url->whereAmI() ) {
		if ( ! is_static_loop() ) {
			if ( configureight()->loop_title() ) {
				$loop_name = ucwords( configureight()->loop_title() );
			} elseif ( $site->uriBlog() ) {
				$loop_name = ucwords( str_replace( [ '/', '-', '_' ], '', $site->uriBlog() ) );
			} else {
				$loop_name = ucwords( configureight()->loop_type() );
			}
		}
	}

	// Loop page.
	$loop_page = '';
	$loop_sep  = '>';
	if ( is_rtl() ) {
		$loop_sep  = '<';
	}
	if ( isset( $_GET['page'] ) && $_GET['page'] > 1 ) {
		$loop_page = sprintf(
			' %s %s %s',
			$loop_sep,
			$L->get( 'Page' ),
			$_GET['page']
		);
		if ( is_rtl() ) {
			$loop_page = sprintf(
				'%s %s %s ',
				$_GET['page'],
				$L->get( 'Page' ),
				$loop_sep
			);
		}
	}

	// Default title.
	if ( is_rtl() && plugin()->default_ttag_rtl() ) {
		$format = plugin()->default_ttag_rtl();
	} elseif ( plugin()->default_ttag() ) {
		$format = plugin()->default_ttag();
	} else {
		$format = sprintf(
			'%s %s %s',
			$site->title(),
			$site->slogan() ? $sep : '',
			$site->slogan()
		);
		if ( is_rtl() ) {
			$format = sprintf(
				'%s %s %s',
				$site->slogan(),
				$site->slogan() ? $sep : '',
				$site->title()
			);
		}
	}

	// Default 404 page.
	if ( $url->notFound() && ! $site->pageNotFound() ) {

		if ( is_rtl() && plugin()->error_ttag_rtl() ) {
			$format = plugin()->error_ttag_rtl();
		} elseif ( plugin()->error_ttag() ) {
			$format = plugin()->error_ttag();
		} else {
			$format = sprintf(
				'%s %s %s',
				$L->get( 'URL Error: Page Not Found' ),
				$sep,
				$site->title()
			);
			if ( is_rtl() ) {
				$format = sprintf(
					'%s %s %s',
					$site->title(),
					$sep,
					$L->get( 'URL Error: Page Not Found' )
				);
			}
		}

	// Posts loop.
	} elseif ( 'blog' == $url->whereAmI() ) {

		if ( is_rtl() && plugin()->loop_ttag_rtl() ) {
			$format = plugin()->loop_ttag_rtl();
		} elseif ( plugin()->loop_ttag() ) {
			$format = plugin()->loop_ttag();

		} elseif ( is_static_loop() ) {
			$static_loop = static_loop_page();
			$format = sprintf(
				'%s%s %s %s',
				ucwords( $static_loop->title() ),
				$loop_page,
				$sep,
				$site->title()
			);
			if ( is_rtl() ) {
				$format = sprintf(
					'%s %s %s%s',
					$site->title(),
					$sep,
					$loop_page,
					ucwords( $static_loop->title() )
				);
			}
		} else {
			$format = sprintf(
				'%s%s %s %s',
				$loop_name,
				$loop_page,
				$sep,
				$site->title()
			);
			if ( is_rtl() ) {
				$format = sprintf(
					'%s %s %s%s',
					$site->title(),
					$sep,
					$loop_page,
					$loop_name
				);
			}
		}

	// Static home page.
	} elseif ( is_front_page() ) {
		$format = sprintf(
			'%s %s %s',
			$site->title(),
			$sep,
			$site->slogan()
		);
		if ( is_rtl() ) {
			$format = sprintf(
				'%s %s %s',
				$site->slogan(),
				$sep,
				$site->title()
			);
		}

	// Post or page.
	} elseif ( 'page' == $url->whereAmI() ) {

		// Page (static).
		if ( $page->isStatic() ) {
			if ( is_rtl() && plugin()->page_ttag_rtl() ) {
				$format = plugin()->page_ttag_rtl();
			} elseif ( plugin()->page_ttag() ) {
					$format = plugin()->page_ttag();
			} else {
				$format = sprintf(
					'%s %s %s',
					$page->title(),
					$sep,
					$site->title()
				);
				if ( is_rtl() ) {
					$format = sprintf(
						'%s %s %s',
						$site->title(),
						$sep,
						$page->title()
					);
				}
			}
		} else {
			if ( is_rtl() && plugin()->post_ttag_rtl() ) {
				$format = plugin()->post_ttag_rtl();
			} elseif ( plugin()->post_ttag() ) {
					$format = plugin()->post_ttag();
			} else {
				$format = sprintf(
					'%s %s %s %s %s',
					$page->title(),
					$sep,
					$page->date(),
					$sep,
					$site->title()
				);
				if ( is_rtl() ) {
					$format = sprintf(
						'%s %s %s %s %s',
						$site->title(),
						$sep,
						$page->date(),
						$sep,
						$page->title()
					);
				}
			}
		}
		$format = str_replace( '{{page-title}}', $page->title(), $format );
		$format = str_replace( '{{page-description}}', $page->description(), $format );
		$format = str_replace( '{{published}}', $page->date(), $format );

	// Category loop.
	} elseif ( 'category' == $url->whereAmI() ) {
		try {
			$key    = $url->slug();
			$cat    = new \Category( $key );

			if ( is_rtl() && plugin()->cat_ttag_rtl() ) {
				$format = plugin()->cat_ttag_rtl();
			} elseif ( plugin()->cat_ttag() ) {
					$format = plugin()->cat_ttag();
			} else {
				$format = sprintf(
					'%s %s %s',
					$cat->name(),
					$sep,
					$site->title()
				);
				if ( is_rtl() ) {
					$format = sprintf(
						'%s %s %s',
						$site->title(),
						$sep,
						$cat->name()
					);
				}
			}
			$format = str_replace( '{{category-name}}', $cat->name(), $format );
		} catch ( \Exception $e ) {
			// Category doesn't exist.
		}

	// Tag loop.
	} elseif ( 'tag' == $url->whereAmI() ) {
		try {
			$key    = $url->slug();
			$tag    = new \Tag( $key );

			if ( is_rtl() && plugin()->tag_ttag_rtl() ) {
				$format = plugin()->tag_ttag_rtl();
			} elseif ( plugin()->tag_ttag() ) {
					$format = plugin()->tag_ttag();
			} else {
				$format = sprintf(
					'%s %s %s',
					$tag->name(),
					$sep,
					$site->title()
				);
				if ( is_rtl() ) {
					$format = sprintf(
						'%s %s %s',
						$site->title(),
						$sep,
						$tag->name()
					);
				}
			}
			$format = str_replace( '{{tag-name}}', $tag->name(), $format );
		} catch ( \Exception $e ) {
			// Tag doesn't exist.
		}

	} elseif ( 'search' == $url->whereAmI() ) {

		$slug  = $url->slug();
		$terms = '';
		if ( str_contains( $slug, 'search/' ) ) {
			$terms = str_replace( 'search/', '', $slug );
			$terms = str_replace( '+', ' ', $terms );
		}

		if ( is_rtl() && plugin()->search_ttag_rtl() ) {
			$format = plugin()->search_ttag_rtl();
		} elseif ( plugin()->search_ttag() ) {
				$format = plugin()->search_ttag();
		} else {
			$format = sprintf(
				'%s "%s" %s %s',
				$L->get( 'Searching' ),
				$terms,
				$sep,
				$site->title()
			);
			if ( is_rtl() ) {
				$format = sprintf(
					'%s %s "%s" %s',
					$site->title(),
					$sep,
					$terms,
					$L->get( 'Searching' )
				);
			}
		}
		$format = str_replace( '{{search-terms}}', $terms, $format );
	}

	$format = str_replace( '{{separator}}', $sep, $format );
	$format = str_replace( '{{site-title}}', $site->title(), $format );
	$format = str_replace( '{{site-slogan}}', $site->slogan(), $format );
	$format = str_replace( '{{site-description}}', $site->description(), $format );
	$format = str_replace( '{{loop-type}}', ucwords( configureight()->loop_type() ), $format );
	$format = str_replace( '{{page-number}}', $loop_page, $format );

	$title = sprintf(
		'<title dir="%s">%s</title>',
		is_rtl() ? 'rtl' : 'ltr',
		$format
	);
	return $title;
}

/**
 * Get keywords
 *
 * Converts each line of the textarea field
 * to an array value.
 *
 * @since  1.0.0
 * @return mixed Returns a simple array or
 *               an empty string.
 */
function get_keywords() {

	// Get the content of the keywords option.
	$option = plugin()->meta_keywords();

	// Return an empty string if the option is empty or only contains spaces.
	if ( 0 == strlen( $option ) || ctype_space( $option ) ) {
		return '';
	}

	/**
	 * Convert each new line of the option to an array value,
	 * removing any carriage return entities.
	 */
	$keywords = explode( "\n", str_replace( "\r", '', $option ) );

	// Return an array of keywords or phrases.
	return $keywords;
}

/**
 * Keywords
 *
 * Converts the array of keywords or phrases
 * to a comma-separated string.
 *
 * @since  1.0.0
 * @return string Returns a comma-separated string of
 *                keywords or phrases, or an empty string.
 */
function keywords() {

	// Get keywords.
	$keywords = get_keywords();

	// Convert keywords array to a comma-separated string.
	if ( is_array( $keywords ) ) {
		$keywords = implode( ', ', $keywords );
	}

	// Return the comma-separated string of keywords or empty.
	return $keywords;
}

/**
 * Meta URL
 *
 * @since  1.0.0
 * @return string
 */
function meta_url() {

	// Default to site domain.
	$url = site_domain();

	if ( is_front_page() ) {
		$url = site_domain();

	} elseif ( is_main_loop() && is_static_loop() ) {
		$url = DOMAIN_BASE . static_loop_page()->slug() . '/';

	} elseif ( is_main_loop() && is_loop_not_home() ) {
		$url = DOMAIN_BASE . str_replace( '/', '', site()->getField( 'uriBlog' ) ) . '/';

	} elseif ( is_page() ) {
		$url = site_domain() . url()->slug();

	} elseif ( is_cat() ) {
		$url = DOMAIN_CATEGORIES . url()->slug();

	} elseif ( is_tag() ) {
		$url = DOMAIN_TAGS . url()->slug();

	} elseif ( is_search() ) {
		$url = site_domain() . 'search/';
	}
	return $url;
}

/**
 * Meta title
 *
 * @since  1.0.0
 * @return string
 */
function meta_title() {

	// Title separator.
	$separator = '|';
	if ( plugin() ) {
		$separator = plugin()->title_sep();
	}

	// Default to site title.
	$title = site()->title();

	if ( is_page() ) {
		$title = sprintf(
			'%s %s %s',
			$title = page()->title(),
			$separator,
			site()->title()
		);

	} elseif ( is_main_loop() ) {
		$title = sprintf(
			'%s %s %s',
			configureight()->loop_title(),
			$separator,
			site()->title()
		);

	} elseif ( is_cat() ) {
		$title = sprintf(
			'%s %s %s',
			lang()->get( 'Category Index' ),
			$separator,
			site()->title()
		);

	} elseif ( is_tag() ) {
		$title = sprintf(
			'%s %s %s',
			lang()->get( 'Tag Index' ),
			$separator,
			site()->title()
		);

	} elseif ( is_search() ) {
		$title = sprintf(
			'%s %s %s',
			lang()->get( 'Search Results' ),
			$separator,
			site()->title()
		);
	}
	return $title;
}

/**
 * Meta description
 *
 * @since  1.0.0
 * @return string
 */
function meta_description() {

	// Default description.
	$desc = '';
	if ( site()->description() ) {
		$desc = site()->description();
	} elseif ( site()->slogan() ) {
		$desc = site()->slogan();
	}

	if ( is_page() ) {
		$desc = page_description( page()->key() );

	} elseif ( is_home() || is_main_loop() ) {
		$desc = loop_description();

	} elseif ( is_cat() ) {
		$cat  = new \Category( url()->slug() );
		$desc = lang()->get( "Posts in the {$cat->name()} category" );

	} elseif ( is_tag() ) {
		$tag  = new \Tag( url()->slug() );
		$desc = lang()->get( "Posts tagged '{$tag->name()}'" );

	} elseif ( is_search() ) {

		$slug  = url()->slug();
		$terms = '';
		if ( str_contains( $slug, 'search/' ) ) {
			$terms = str_replace( 'search/', '', $slug );
			$terms = str_replace( '+', ' ', $terms );
		}
		$desc = lang()->get( "Searching '{$terms}'" );
	}
	return $desc;
}

/**
 * Meta author
 *
 * @since  1.0.0
 * @return string
 */
function meta_author() {

	// Empty if not on a page.
	if ( ! is_page() ) {
		return '';
	}

	// Get user name.
	$user   = page()->user();
	$author = ucwords( page()->username() );
	if ( $user->nickname() ) {
		$author = $user->nickname();
	}
	return $author;
}

/**
 * Meta language tag
 *
 * @since  1.0.0
 * @return string
 */
function meta_tag_language( $print = true ) {

	if ( $print ) {
		printf(
			'<meta name="language" content="%s" />',
			current_lang()
		) . "\r";
	} else {
		return sprintf(
			'<meta name="language" content="%s" />',
			current_lang()
		) . "\r";
	}
}

/**
 * Meta keywords tag
 *
 * @since  1.0.0
 * @return string
 */
function meta_tag_keywords( $print = true ) {

	if ( $print ) {
		printf(
			'<meta name="keywords" content="%s" />',
			keywords()
		) . "\r";
	} else {
		return sprintf(
			'<meta name="keywords" content="%s" />',
			keywords()
		) . "\r";
	}
}

/**
 * Meta title tag
 *
 * @since  1.0.0
 * @return string
 */
function meta_tag_title( $print = true ) {

	if ( $print ) {
		printf(
			'<meta name="title" content="%s" />',
			meta_title()
		) . "\r";
	} else {
		return sprintf(
			'<meta name="title" content="%s" />',
			meta_title()
		) . "\r";
	}
}

/**
 * Meta description tag
 *
 * @since  1.0.0
 * @return string
 */
function meta_tag_description( $print = true ) {

	if ( $print ) {
		printf(
			'<meta name="description" content="%s" />',
			meta_description()
		) . "\r";
	} else {
		return sprintf(
			'<meta name="description" content="%s" />',
			meta_description()
		) . "\r";
	}
}

/**
 * Meta author tag
 *
 * @since  1.0.0
 * @return string
 */
function meta_tag_author( $print = true ) {

	if ( $print ) {
		printf(
			'<meta name="author" content="%s" />',
			meta_author()
		) . "\r";
	} else {
		return sprintf(
			'<meta name="author" content="%s" />',
			meta_author()
		) . "\r";
	}
}

/**
 * Meta copyright tag
 *
 * @since  1.0.0
 * @return string
 */
function meta_tag_copyright( $print = true ) {

	if ( $print ) {
		printf(
			'<meta name="copyright" content="%s" />',
			date( 'Y' )
		) . "\r";
	} else {
		return sprintf(
			'<meta name="copyright" content="%s" />',
			date( 'Y' )
		) . "\r";
	}
}

/**
 * Meta tags: standard
 *
 * @since  1.0.0
 * @return string
 */
function meta_tags_standard() {

	$html = '<!-- Standard meta tags -->' . "\r";

	// Language tag.
	$html .= meta_tag_language( false );

	// Keywords tag.
	if ( ! empty( keywords() ) ) {
		$html .= meta_tag_keywords( false );
	}

	// Title tag.
	$html .= meta_tag_title( false );

	// Description tag.
	$html .= meta_tag_description( false );

	// Author tag.
	if ( is_page() ) {
		$html .= meta_tag_author( false );
	}

	// Copyright tag.
	$html .= meta_tag_copyright( false );

	return $html;
}

/**
 * Meta tags: Schema
 *
 * @since  1.0.0
 * @return string
 */
function meta_tags_schema() {

	$html = "\r" . '<!-- Schema meta tags -->' . "\r";

	// URL tag.
	$html .= sprintf(
		'<meta itemprop="url" content="%s" />',
		meta_url()
	) . "\r";

	// Name (title) tag.
	$html .= sprintf(
		'<meta itemprop="name" content="%s" />',
		meta_title()
	) . "\r";

	// Description tag.
	$html .= sprintf(
		'<meta itemprop="description" content="%s" />',
		meta_description()
	) . "\r";

	// Post/page tags.
	if ( is_page() ) {
		$html .= sprintf(
			'<meta itemprop="author" content="%s" />',
			meta_author()
		) . "\r";
		$html .= sprintf(
			'<meta itemprop="datePublished" content="%s" />',
			page()->date()
		) . "\r";
		$html .= sprintf(
			'<meta itemprop="dateModified" content="%s" />',
			page()->dateModified()
		) . "\r";
	}

	// Image tag.
	if ( has_cover() ) {
		$html .= sprintf(
			'<meta itemprop="image" content="%s" />',
			get_cover_src()
		) . "\r";
	}
	return $html;
}

/**
 * Meta tags: Open Graph
 *
 * @since  1.0.0
 * @return string
 */
function meta_tags_open_graph() {

	$html = "\r" . '<!-- Open Graph meta tags -->' . "\r";

	// URL tag.
	$html .= sprintf(
		'<meta property="og:url" content="%s" />',
		meta_url()
	) . "\r";

	// Language tag.
	$html .= sprintf(
		'<meta property="og:locale" content="%s" />',
		current_lang()
	) . "\r";

	// Type tag.
	$html .= sprintf(
		'<meta property="og:type" content="%s" />',
		( is_page() ? 'article' : 'website' )
	) . "\r";

	// Site title.
	$html .= sprintf(
		'<meta property="og:site_name" content="%s" />',
		site()->title()
	) . "\r";

	// Content title.
	$html .= sprintf(
		'<meta property="og:title" content="%s" />',
		meta_title()
	) . "\r";

	// Description tag.
	$html .= sprintf(
		'<meta property="og:description" content="%s" />',
		meta_description()
	) . "\r";

	// Image tag.
	if ( has_cover() ) {
		$html .= sprintf(
			'<meta property="og:image" content="%s" />',
			get_cover_src()
		) . "\r";
	}
	return $html;
}

/**
 * Meta tags: X/Twitter
 *
 * @since  1.0.0
 * @return string
 */
function meta_tags_twitter() {

	$html = "\r" . '<!-- X/Twitter meta tags -->' . "\r";

	// Card tag.
	$html .= '<meta name="twitter:card" content="summary_large_image" />' . "\r";

	// Site URL tag.
	$html .= sprintf(
		'<meta name="twitter:domain" content="%s" />',
		site_domain()
	) . "\r";

	// Site title.
	$html .= sprintf(
		'<meta name="twitter:site" content="%s" />',
		site()->title()
	) . "\r";

	// URL tag.
	$html .= sprintf(
		'<meta name="twitter:url" content="%s" />',
		meta_url()
	) . "\r";

	// Content title.
	$html .= sprintf(
		'<meta name="twitter:title" content="%s" />',
		meta_title()
	) . "\r";

	// Description tag.
	$html .= sprintf(
		'<meta name="twitter:description" content="%s" />',
		meta_description()
	) . "\r";

	// Image tag.
	if ( has_cover() ) {
		$html .= sprintf(
			'<meta name="twitter:image:src" content="%s" />',
			get_cover_src()
		) . "\r";
	}

	return $html;
}

/**
 * Meta tags: Dublin Core
 *
 * @since  1.0.0
 * @return string
 */
function meta_tags_dublin_core() {

	$html  = "\r" . '<!-- Dublin Core meta tags -->' . "\r";
	$html .= '<meta name="DC.Format" content="text/html" />' . "\r";

	// Language tag.
	$html .= sprintf(
		'<meta name="DC.Language" content="%s" />',
		current_lang()
	) . "\r";

	// Source tag.
	$html .= sprintf(
		'<meta name="DC.Source" content="%s" />',
		site_domain()
	) . "\r";

	// Creator tag.
	$html .= sprintf(
		'<meta name="DC.Creator" content="%s" />',
		site()->title()
	) . "\r";

	// Publisher tag.
	$html .= sprintf(
		'<meta name="DC.Publisher" content="%s" />',
		site()->title()
	) . "\r";

	// Rights tag.
	$html .= sprintf(
		'<meta name="DC.Rights" content="%s" />',
		date( 'Y' )
	) . "\r";
	return $html;

	// Identifier tag.
	$html .= sprintf(
		'<meta name="DC.Identifier" content="%s" />',
		meta_url()
	) . "\r";

	// Content title tag.
	$html .= sprintf(
		'<meta name="DC.Title" content="%s" />',
		meta_title()
	) . "\r";

	if ( ! is_home() && ! is_front_page() ) {
		// Relation tag.
		$html .= sprintf(
			'<meta name="DC.Relation" content="%s" scheme="IsPartOf" />',
			meta_url()
		) . "\r";
	}

	// Post/page tags.
	if ( is_page() ) {

		// Subject tag.
		if ( page()->category() ) {
			$html .= sprintf(
				'<meta name="DC.Subject" content="%s" />',
				page()->category()
			) . "\r";
		}

		// Contributor tag.
		$html .= sprintf(
			'<meta name="DC.Contributor" content="%s" />',
			meta_author()
		) . "\r";

		// Date tag.
		$html .= sprintf(
			'<meta name="DC.Date" content="%s" />',
			page()->date()
		) . "\r";
	}

	// Description tag.
	$html .= sprintf(
		'<meta name="DC.Description" content="%s" />',
		meta_description()
	) . "\r";

	return $html;
}
