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

	<p><?php lang()->p( 'Plugin options fields here. How about a demo field?...' ); ?></p>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="option_one"><?php lang()->p( 'Option One' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="option_one" name="option_one">
				<option value="true" <?php echo ( $this->getValue( 'option_one' ) === true ? 'selected' : '' ); ?>><?php lang()->p( 'Enabled' ); ?></option>
				<option value="false" <?php echo ( $this->getValue( 'option_one' ) === false ? 'selected' : '' ); ?>><?php lang()->p( 'Disabled' ); ?></option>
			</select>
			<small class="form-text"><?php lang()->p( 'A simple select field sample.' ); ?></small>
		</div>
	</div>

	<input type="hidden" name="option_two" id="option_two" value="3" />

</fieldset>

<script>
jQuery(document).ready( function($) {
	// Field jQuery scripts here.
});
</script>
