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

<nav class="mb-3">
	<div class="nav nav-tabs" id="nav-tab" role="tablist">

		<a class="nav-item nav-link active" id="tab-one" data-toggle="tab" href="#content-one" role="tab" aria-controls="tab-one" aria-selected="false"><?php lang()->p( 'One' ); ?></a>

		<a class="nav-item nav-link" id="tab-two" data-toggle="tab" href="#content-two" role="tab" aria-controls="tab-two" aria-selected="false"><?php lang()->p( 'Two' ); ?></a>

		<a class="nav-item nav-link" id="tab-three" data-toggle="tab" href="#content-three" role="tab" aria-controls="tab-three" aria-selected="false"><?php lang()->p( 'Three' ); ?></a>
	</div>
</nav>

<div class="tab-content" id="nav-tabContent">

	<div id="content-one" class="tab-pane fade show mt-4 active" role="tabpanel" aria-labelledby="tab-one">
		<h2><?php lang()->p( 'Tab One' ); ?></h2>
		<p><?php lang()->p( 'Tab one content.' ); ?></p>
	</div>

	<div id="content-two" class="tab-pane fade show mt-4" role="tabpanel" aria-labelledby="tab-two">
		<h2><?php lang()->p( 'Tab Two' ); ?></h2>
		<p><?php lang()->p( 'Tab two content.' ); ?></p>
	</div>

	<div id="content-three" class="tab-pane fade show mt-4" role="tabpanel" aria-labelledby="tab-three">
		<h2><?php lang()->p( 'Tab Three' ); ?></h2>
		<p><?php lang()->p( 'Tab three content.' ); ?></p>
	</div>

</div>

<script>
// Open current tab after refresh page.
$( function() {
	$( 'a[data-toggle="tab"]' ).on( 'click', function(e) {
		window.localStorage.setItem( 'sample_active_tab', $( e.target ).attr( 'href' ) );
	});
	var sample_active_tab = window.localStorage.getItem( 'sample_active_tab' );
	if ( sample_active_tab ) {
		$( '#nav-tab a[href="' + sample_active_tab + '"]' ).tab( 'show' );
		window.localStorage.removeItem( 'sample_active_tab' );
	}
});
</script>
