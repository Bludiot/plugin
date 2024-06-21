<?php
/**
 * Boilerplate guide
 *
 * @package    Boilerplate
 * @subpackage Views
 * @category   Guides
 * @since      1.0.0
 */

// Access namespaced functions.
use function Boilerplate\{
	lang
};

// Form page URL.
$form_page = DOMAIN_ADMIN . 'configure-plugin/' . $this->className();

?>
<h1><span class="page-title-icon fa fa-book"></span> <span class="page-title-text"><?php lang()->p( 'Plugin Boilerplate Guide' ) ?></span></h1>

<div class="alert alert-primary alert-cats-list" role="alert">
	<p class="m-0"><?php lang()->p( "Go to the <a href='{$form_page}'>boilerplate options</a> page." ); ?></p>
</div>

<p><?php lang()->p( 'Plugin guide content here.' ); ?></p>
