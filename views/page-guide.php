<?php
/**
 * Boilerplate guide
 *
 * @package    Boilerplate
 * @subpackage Views
 * @category   Guides
 * @since      1.0.0
 */

// Form page URL.
$form_page = DOMAIN_ADMIN . 'configure-plugin/Boilerplate';

?>
<h1><span class="page-title-icon fa fa-book"></span> <span class="page-title-text"><?php $L->p( 'Boilerplate Guide' ) ?></span></h1>

<div class="alert alert-primary alert-cats-list" role="alert">
	<p class="m-0"><?php $L->p( "Go to the <a href='{$form_page}'>boilerplate options</a> page." ); ?></p>
</div>

<p><?php $L->p( 'Plugin guide content here.' ); ?></p>
