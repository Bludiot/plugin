<?php
/**
 * Boilerplate options
 *
 * @package    Boilerplate
 * @subpackage Views
 * @category   Forms
 * @since      1.0.0
 */

// Access namespaced functions.
use function Boilerplate\{
	plugin,
	lang
};

// Guide page URL.
$guide_page = DOMAIN_ADMIN . 'plugin/' . $this->className();

?>
<div class="alert alert-primary alert-cats-list" role="alert">
	<p class="m-0"><?php lang()->p( "Go to the <a href='{$guide_page}'>boilerplate guide</a> page." ); ?></p>
</div>

<fieldset class="mt-4">
	<legend class="screen-reader-text mb-3"><?php lang()->p( 'Boilerplate Options' ) ?></legend>

	<p><?php lang()->p( 'Plugin options fields here.' ); ?></p>

</fieldset>

<script>
jQuery(document).ready( function($) {
	// Field jQuery scripts here.
});
</script>
