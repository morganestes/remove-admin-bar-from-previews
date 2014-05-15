<?php
/**
 * Plugin Name: Remove Admin Bar from Previews
 * Plugin URI: http://www.morganestes.me
 * Description: Removes the Admin Bar from Post Previews.
 * Version: 0.2.0
 * Author: Morgan Estes
 * Author URI: http://www.morganestes.me
 * License: GPLv2 or later
 */

/**
 * Hides admin bar from previewed posts.
 *
 * @return bool|void
 */
function abp_hide_admin_bar() {
	$options = get_option( 'abp_preview_settings' );
	if ( is_preview() ) {
		if ( true == $options['hide_on_preview'] ) {
			add_filter( 'show_admin_bar', '__return_false' );
		}
		if ( true == $options['show_notice_bar'] ) {
			add_action( 'wp_enqueue_scripts', 'abp_notice_bar_style' );
			add_filter( 'wp_footer', 'abp_notice_bar' );
		}
	}
}

add_action( 'wp', 'abp_hide_admin_bar' );

/**
 * Create the settings fields and register them with the Admin UI.
 */
function abp_settings_api_init() {
	if ( false === get_option( 'abp_preview_settings' ) ) {
		$defaults = array(
			'hide_on_preview' => 1,
			'show_notice_bar' => 1,
		);
		update_option( 'abp_preview_settings', $defaults );
	}

	add_settings_field( 'abp-post-preview', 'Hide Admin Bar on Preview', 'abp_settings_field', 'writing', 'default' );

	register_setting( 'writing', 'abp_preview_settings', 'abp_check_options' );
}

add_action( 'admin_init', 'abp_settings_api_init' );

/**
 * Filter and validate the options.
 *
 * @param array $options Array of options created by the serialized string set by *_option().
 *
 * @return array The filtered options.
 */
function abp_check_options( $options ) {
	// Use intval() instead of boolval() for checkboxes
	// @link http://wptheming.com/2011/05/checkboxes-and-booleans/
	$options['hide_on_preview'] = intval( $options['hide_on_preview'] );
	$options['show_notice_bar'] = intval( $options['show_notice_bar'] );

	return $options;
}

/**
 * Create the settings fields HTML in the Writing admin page.
 */
function abp_settings_field() {
	$options = get_option( 'abp_preview_settings' );
	?>
	<input type="checkbox" name="abp_preview_settings[hide_on_preview]" id="abp-post-preview" value="1" <?php checked( $options['hide_on_preview'], 1 ); ?> />
	<label for="abp-post-preview"><?php _e( 'Hide the Admin Bar when previewing posts and pages', 'abp-hidden' ); ?></label>
	<br>
	<input type="checkbox" name="abp_preview_settings[show_notice_bar]" id="abp-show-notice" value="1" <?php checked( $options['show_notice_bar'], 1 ); ?> />
	<label for="abp-show-notice"><?php _e( 'Show a reminder notice when previewing a post', 'abp-hidden' ); ?></label>
	<?php
}

/**
 * Create the HTML for the notice bar. Can be overridden in a theme by including a template file.
 */
function abp_notice_bar() {
	$template_name = 'abp-notice-bar-template.php';
	$path          = locate_template( $template_name );

	if ( empty( $path ) ) {
		$path = plugin_dir_path( __FILE__ ) . '/inc/' . $template_name;
	}

	include_once $path;
}

/**
 * Add the stylesheet for the notice bar. Can be overridden in a theme by including a stylesheet.
 */
function abp_notice_bar_style() {
	if ( file_exists( get_stylesheet_directory() . '/abp-preview-notice.css' ) ) {
		wp_enqueue_style( 'abp-preview-notice', get_stylesheet_directory_uri() . '/abp-preview-notice.css' );
	} else {
		wp_enqueue_style( 'abp-preview-notice', plugins_url( '/preview-notice.css', __FILE__ ) );
	}
}
