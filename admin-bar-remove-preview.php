<?php
/**
 * Plugin Name: Remove Admin Bar from Previews
 * Plugin URI: http://www.morganestes.me
 * Description: Removes the Admin Bar from Post Previews.
 * Version: 0.1.0
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
	$options = get_option( 'abp_hidden' );
	if ( is_preview() ) {
		if ( true == $options['hide-on-preview'] ) {
			add_filter( 'show_admin_bar', '__return_false' );
		}
		if ( true == $options['show-notice-bar'] ) {
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
	if ( false === get_option( 'abp_hidden' ) ) {
		$defaults = array(
			'hide-on-preview' => true,
			'show-notice-bar' => true,
		);
		update_option( 'abp_hidden', $defaults );
	}

	add_settings_field( 'abp-post-preview', 'Hide Admin Bar on Preview', 'abp_settings_field', 'writing', 'default' );

	register_setting( 'writing', 'abp_hidden', 'abp_check_options' );
}

add_action( 'admin_init', 'abp_settings_api_init' );

/**
 * Filter and validate the options.
 *
 * @param $options
 *
 * @return array
 */
function abp_check_options( $options ) {
	$options['hide-on-preview'] = intval( $options['hide-on-preview'] );
	$options['show-notice-bar'] = intval( $options['show-notice-bar'] );

	return $options;
}

/**
 * Create the settings fields HTML in the Writing admin page.
 */
function abp_settings_field() {
	$options = get_option( 'abp_hidden' );
	?>
	<input type="checkbox" name="abp_hidden[hide-on-preview]" id="abp-post-preview" value="1" <?php checked( $options['hide-on-preview'], 1 ); ?> />
	<label for="abp-post-preview"><?php _e( 'Hide the Admin Bar when previewing posts and pages', 'abp-hidden' ); ?></label>
	<br>
	<input type="checkbox" name="abp_hidden[show-notice-bar]" id="abp-show-notice" value="1" <?php checked( $options['show-notice-bar'], 1 ); ?> />
	<label for="abp-show-notice"><?php _e( 'Show a reminder notice when previewing a post', 'abp-hidden' ); ?></label>
<?php
}

function abp_notice_bar( ) {
$notice_bar = <<<HTML
<div class="abp-notice">
<p>This is a preview, and changes may not have been saved.</p>
</div>
HTML;

	echo $notice_bar;
}

function abp_notice_bar_style() {
	wp_enqueue_style( 'abp-preview-notice', plugins_url( '/preview-notice.css', __FILE__ ) );
}

