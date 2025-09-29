<?php
/**
 * Meta Data options
 *
 * @package    Meta Data
 * @subpackage Views
 * @category   Forms
 * @since      1.0.0
 */

// Access namespaced functions.
use function Meta_Data\{
	lang,
	can_search,
	is_rtl
};

// Guide page URL.
$guide_page = DOMAIN_ADMIN . 'plugin/' . $this->className();

?>
<style>
code.select {
	user-select: all;
	cursor: pointer;
}
</style>

<p><?php $L->p( "Include detailed information about the website for search engines and for embedding URLs. Go to the <a href='{$guide_page}'>Meta Data guide</a> page." ); ?></p>

<nav id="nav-tabs">
	<ul class="nav nav-tabs" id="nav-tab" role="tablist">
		<li class="nav-item">
			<a id="nav-title-tags-tab" href="#title-tags" class="nav-link active" data-toggle="tab" role="tab" aria-controls="title-tags" aria-selected="false">
				<?php lang()->p( 'Title Tags' ); ?>
			</a>
		</li>
		<li class="nav-item">
			<a id="nav-meta-tags-tab" href="#meta-tags" class="nav-link" data-toggle="tab" role="tab" aria-controls="nav-meta-tags" aria-selected="false">
				<?php lang()->p( 'Meta Tags' ); ?>
			</a>
		</li>
	</ul>
</nav>

<div id="tab-content" class="tab-content">

	<div id="title-tags" class="tab-pane fade show active" role="tabpanel" aria-labelledby="title-tags-tab">

		<h3 class="form-heading"><?php $L->p( 'Title Tag Options' ); ?></h3>

		<p><?php $L->p( 'Used by search engines as well as browser tabs.' ); ?></p>

		<fieldset>

			<legend class="screen-reader-text"><?php $L->p( 'Title Tags' ); ?></legend>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="title_sep"><?php $L->p( 'Title Separator' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<select class="form-select" id="title_sep" name="title_sep">

							<option value="|" <?php echo ( $this->getValue( 'title_sep' ) === '|' ? 'selected' : '' ); ?>><?php $L->p( 'Pipe' ); ?> ( | )</option>

							<option value="—" <?php echo ( $this->getValue( 'title_sep' ) === '—' ? 'selected' : '' ); ?>><?php $L->p( 'Dash' ); ?> ( — )</option>

							<option value="&gt;" <?php echo ( $this->getValue( 'title_sep' ) === '&gt;' ? 'selected' : '' ); ?>><?php $L->p( 'Angle' ); ?> ( &gt; )</option>

							<option value="≫" <?php echo ( $this->getValue( 'title_sep' ) === '≫' ? 'selected' : '' ); ?>><?php $L->p( 'Double' ); ?> ( &#8811; )</option>

							<option value="→" <?php echo ( $this->getValue( 'title_sep' ) === '→' ? 'selected' : '' ); ?>><?php $L->p( 'Arrow' ); ?> ( <?php echo ( is_rtl() ? '←' : '→' ); ?> )</option>

							<option value="custom" <?php echo ( $this->getValue( 'title_sep' ) === 'custom' ? 'selected' : '' ); ?>><?php $L->p( 'Custom' ); ?></option>
						</select>
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#title_sep').val('<?php echo $this->dbFields['title_sep']; ?>');$( '#custom_sep' ).val('');$( '#custom_sep_wrap' ).fadeOut( 250 );"><?php $L->p( 'Default' ); ?></span>
					</div>
					<small class="form-text"><?php $L->p( 'Directional characters are adjusted for language direction.' ); ?></small>
				</div>
			</div>

			<div id="custom_sep_wrap" style="display: <?php echo ( $this->getValue( 'title_sep' ) === 'custom' ? 'block' : 'none' ); ?>;">
				<div class="form-field form-group row">
					<label class="form-label col-sm-2 col-form-label" for="custom_sep"><?php $L->p( 'Custom Separator' ); ?></label>
					<div class="col-sm-10">
						<input type="text" id="custom_sep" name="custom_sep" value="<?php echo $this->getValue( 'custom_sep' ); ?>" placeholder="<?php echo $this->dbFields['custom_sep']; ?>" />
						<small class="form-text"><?php $L->p( 'Paste or type in the custom separator character.' ); ?></small>
					</div>
				</div>
			</div>

			<h3 class="form-heading"><?php $L->p( 'Left-to-Right Titles' ); ?></h3>

			<p><?php $L->p( 'Title formats for left-to-right languages.' ); ?></p>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="default_ttag"><?php $L->p( 'LTR Default Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="default_ttag" name="default_ttag" value="<?php echo $this->getValue( 'default_ttag' ); ?>" placeholder="{{site-title}} {{separator}} {{site-slogan}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#default_ttag').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="loop_ttag"><?php $L->p( 'LTR Loop Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="loop_ttag" name="loop_ttag" value="<?php echo $this->getValue( 'loop_ttag' ); ?>" placeholder="{{loop-type}} {{page-number}} {{separator}} {{site-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#loop_ttag').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{loop-type}}</code>
						<code class="select">{{page-number}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="post_ttag"><?php $L->p( 'LTR Post Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="post_ttag" name="post_ttag" value="<?php echo $this->getValue( 'post_ttag' ); ?>" placeholder="{{page-title}} {{separator}} {{published}} {{separator}} {{site-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#post_ttag').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{page-title}}</code>
						<code class="select">{{page-description}}</code>
						<code class="select">{{published}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="page_ttag"><?php $L->p( 'LTR Page Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="page_ttag" name="page_ttag" value="<?php echo $this->getValue( 'page_ttag' ); ?>" placeholder="{{page-title}} {{separator}} {{site-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#page_ttag').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{page-title}}</code>
						<code class="select">{{page-description}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="cat_ttag"><?php $L->p( 'LTR Category Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="cat_ttag" name="cat_ttag" value="<?php echo $this->getValue( 'cat_ttag' ); ?>" placeholder="{{category-name}} {{separator}} {{site-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#cat_ttag').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{category-name}}</code>
						<code class="select">{{page-number}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="tag_ttag"><?php $L->p( 'LTR Tag Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="tag_ttag" name="tag_ttag" value="<?php echo $this->getValue( 'tag_ttag' ); ?>" placeholder="{{tag-name}} {{separator}} {{site-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#tag_ttag').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{tag-name}}</code>
						<code class="select">{{page-number}}</code>
					</small>
				</div>
			</div>

			<?php if ( can_search() ) : ?>
			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="search_ttag"><?php $L->p( 'LTR Search Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="search_ttag" name="search_ttag" value="<?php echo $this->getValue( 'search_ttag' ); ?>" placeholder="<?php $L->p( 'Searching' ); ?> {{search-terms}} {{separator}} {{site-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#search_ttag').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{search-terms}}</code>
						<code class="select">{{page-number}}</code>
					</small>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( ! $site->pageNotFound() ) : ?>
			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="error_ttag"><?php $L->p( 'LTR 404 Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="error_ttag" name="error_ttag" value="<?php echo $this->getValue( 'error_ttag' ); ?>" placeholder="<?php $L->p( 'URL Not Found' ); ?> {{separator}} {{site-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#error_ttag').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
					</small>
				</div>
			</div>
			<?php endif; ?>

			<h3 class="form-heading"><?php $L->p( 'Right-to-Left Titles' ); ?></h3>

			<p><?php $L->p( 'Title formats for right-to-left languages.' ); ?></p>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="default_ttag_rtl"><?php $L->p( 'RTL Default Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="default_ttag_rtl" name="default_ttag_rtl" value="<?php echo $this->getValue( 'default_ttag_rtl' ); ?>" placeholder="{{site-slogan}} {{separator}} {{site-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#default_ttag_rtl').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="loop_ttag_rtl"><?php $L->p( 'RTL Loop Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="loop_ttag_rtl" name="loop_ttag_rtl" value="<?php echo $this->getValue( 'loop_ttag_rtl' ); ?>" placeholder="{{site-title}} {{separator}} {{page-number}} {{loop-type}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#loop_ttag_rtl').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{loop-type}}</code>
						<code class="select">{{page-number}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="post_ttag_rtl"><?php $L->p( 'RTL Post Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="post_ttag_rtl" name="post_ttag_rtl" value="<?php echo $this->getValue( 'post_ttag_rtl' ); ?>" placeholder="{{site-title}} {{separator}} {{published}} {{separator}} {{page-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#post_ttag_rtl').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{page-title}}</code>
						<code class="select">{{page-description}}</code>
						<code class="select">{{published}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="page_ttag_rtl"><?php $L->p( 'RTL Page Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="page_ttag_rtl" name="page_ttag_rtl" value="<?php echo $this->getValue( 'page_ttag_rtl' ); ?>" placeholder="{{site-title}} {{separator}} {{page-title}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#page_ttag_rtl').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{page-title}}</code>
						<code class="select">{{page-description}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="cat_ttag_rtl"><?php $L->p( 'RTL Category Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="cat_ttag_rtl" name="cat_ttag_rtl" value="<?php echo $this->getValue( 'cat_ttag_rtl' ); ?>" placeholder="{{site-title}} {{separator}} {{category-name}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#cat_ttag_rtl').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{category-name}}</code>
						<code class="select">{{page-number}}</code>
					</small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="tag_ttag_rtl"><?php $L->p( 'RTL Tag Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="tag_ttag_rtl" name="tag_ttag_rtl" value="<?php echo $this->getValue( 'tag_ttag_rtl' ); ?>" placeholder="{{site-title}} {{separator}} {{tag-name}}" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#tag_ttag_rtl').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{tag-name}}</code>
						<code class="select">{{page-number}}</code>
					</small>
				</div>
			</div>

			<?php if ( can_search() ) : ?>
			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="search_ttag_rtl"><?php $L->p( 'RTL Search Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="search_ttag_rtl" name="search_ttag_rtl" value="<?php echo $this->getValue( 'search_ttag_rtl' ); ?>" placeholder="{{site-title}} {{separator}} {{search-terms}} <?php $L->p( 'Searching' ); ?>" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#search_ttag_rtl').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
						<code class="select">{{search-terms}}</code>
						<code class="select">{{page-number}}</code>
					</small>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( ! $site->pageNotFound() ) : ?>
			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="error_ttag_rtl"><?php $L->p( 'RTL 404 Title' ); ?></label>
				<div class="col-sm-10">
					<div class="field-has-buttons">
						<input type="text" id="error_ttag_rtl" name="error_ttag_rtl" value="<?php echo $this->getValue( 'error_ttag_rtl' ); ?>" placeholder="{{site-title}} {{separator}} <?php $L->p( 'URL Not Found' ); ?>" />
						<span class="btn btn-secondary btn-md form-range-button hide-if-no-js" onClick="$('#error_ttag_rtl').val('');"><?php $L->p( 'Clear' ); ?></span>
					</div>
					<small class="form-text">
						<span class=""><?php $L->p( 'Placeholders:' ); ?> </span>
						<code class="select">{{separator}}</code>
						<code class="select">{{site-title}}</code>
						<code class="select">{{site-slogan}}</code>
						<code class="select">{{site-description}}</code>
					</small>
				</div>
			</div>
			<?php endif; ?>
		</fieldset>
	</div>

	<div id="meta-tags" class="tab-pane fade show" role="tabpanel" aria-labelledby="meta-tags-tab">

		<h3 class="form-heading"><?php $L->p( 'Meta Tag Options' ); ?></h3>

		<p><?php $L->p( 'Standard meta tags are always enabled.' ); ?></p>

		<fieldset>
			<legend class="screen-reader-text"><?php $L->p( 'Meta Tags' ); ?></legend>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="meta_noindex"><?php $L->p( 'No Index' ); ?></label>
				<div class="col-sm-10">
					<select class="form-select" id="meta_noindex" name="meta_noindex">
						<option value="true" <?php echo ( $this->getValue( 'meta_noindex' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
						<option value="false" <?php echo ( $this->getValue( 'meta_noindex' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>
					</select>
					<small class="form-text"><?php $L->p( 'Add tag to discourage search engines indexing this site.' ); ?></small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="meta_keywords"><?php $L->p( 'Keywords' ); ?></label>
				<div class="col-sm-10">
					<p><small class="form-text"><?php $L->p( 'Add one keyword or phrase per line.' ); ?></small></p>
					<textarea id="meta_keywords" name="meta_keywords" placeholder="" cols="60" rows="4"><?php echo $this->getValue( 'meta_keywords' ) ?></textarea>
				</div>
			</div>

			<h3 class="form-heading"><?php $L->p( 'Non-Standard Meta Tags' ); ?></h3>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="meta_use_schema"><?php $L->p( 'Schema Data' ); ?></label>
				<div class="col-sm-10">
					<select class="form-select" id="meta_use_schema" name="meta_use_schema">
						<option value="true" <?php echo ( $this->getValue( 'meta_use_schema' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
						<option value="false" <?php echo ( $this->getValue( 'meta_use_schema' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>
					</select>
					<small class="form-text"><?php $L->p( 'Used in conjunction with other Schema data throughout the theme.' ); ?></small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="meta_use_og"><?php $L->p( 'Open Graph' ); ?></label>
				<div class="col-sm-10">
					<select class="form-select" id="meta_use_og" name="meta_use_og">
						<option value="true" <?php echo ( $this->getValue( 'meta_use_og' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
						<option value="false" <?php echo ( $this->getValue( 'meta_use_og' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>
					</select>
					<small class="form-text"><?php $L->p( 'Used primarily for embedding URLs; includes Facebook.' ); ?></small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="meta_use_twitter"><?php $L->p( 'X/Twitter Cards' ); ?></label>
				<div class="col-sm-10">
					<select class="form-select" id="meta_use_twitter" name="meta_use_twitter">
						<option value="true" <?php echo ( $this->getValue( 'meta_use_twitter' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
						<option value="false" <?php echo ( $this->getValue( 'meta_use_twitter' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>
					</select>
					<small class="form-text"><?php $L->p( 'Used specifically for embedding URLs in X/Twitter.' ); ?></small>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="meta_use_dublin"><?php $L->p( 'Dublin Core' ); ?></label>
				<div class="col-sm-10">
					<select class="form-select" id="meta_use_dublin" name="meta_use_dublin">
						<option value="true" <?php echo ( $this->getValue( 'meta_use_dublin' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
						<option value="false" <?php echo ( $this->getValue( 'meta_use_dublin' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>
					</select>
				</div>
			</div>

			<h3 class="form-heading"><?php $L->p( 'Custom Code' ); ?></h3>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="meta_custom"><?php $L->p( 'Custom Tags' ); ?></label>
				<div class="col-sm-10">
					<p><small class="form-text"><?php $L->p( 'Prints to the <code>&lt;head&gt;</code> with other meta tags.' ); ?></small></p>
					<textarea class="code-field" id="meta_custom" name="meta_custom" placeholder="" cols="60" rows="4"><?php echo $this->getValue( 'meta_custom' ) ?></textarea>
				</div>
			</div>

			<div class="form-field form-group row">
				<label class="form-label col-sm-2 col-form-label" for="footer_scripts"><?php $L->p( 'Footer Scripts' ); ?></label>
				<div class="col-sm-10">
					<p><small class="form-text"><?php $L->p( 'Useful for analytics code.' ); ?></small></p>
					<textarea class="code-field" id="footer_scripts" name="footer_scripts" placeholder="" cols="60" rows="4"><?php echo $this->getValue( 'footer_scripts' ) ?></textarea>
				</div>
			</div>
		</fieldset>
	</div>
</div>

<script>
// Open current tab after refresh page
$(function() {
	$('a[data-toggle="tab"]').on('click', function(e) {
		window.localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = window.localStorage.getItem('activeTab');
	if (activeTab) {
		$('#nav-tabs a[href="' + activeTab + '"]').tab('show');
		//window.localStorage.removeItem("activeTab");
	}
});

jQuery(document).ready( function($) {
	$( '#title_sep' ).on( 'change', function() {
		var show = $(this).val();
		if ( show == 'custom' ) {
			$( "#custom_sep_wrap" ).fadeIn( 250 );
		} else if ( show != 'custom' ) {
			$( "#custom_sep_wrap" ).fadeOut( 250 );
		}
	});
});
</script>
