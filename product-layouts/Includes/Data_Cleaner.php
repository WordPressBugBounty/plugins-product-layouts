<?php

namespace WPTE_PRODUCT_LAYOUT\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Removes Product Layouts data from the database.
 *
 * Two entry points:
 * - delete_now(): the Danger zone button on the Settings page. The plugin
 *   stays active, so the layouts table is emptied but kept, and the install
 *   options and license are kept.
 * - uninstall(): runs from Freemius' after_uninstall action when the plugin
 *   is deleted, only on sites where "Delete data when the plugin is deleted"
 *   is switched on. Drops the table and removes every option.
 *
 * Product Layouts stores its layouts in {prefix}wpte_product_layout_style,
 * a table only this plugin uses. Freemius keeps its own data and handles it
 * on uninstall. Uses no plugin constants, because the uninstall request
 * loads the plugin file without running its plugins_loaded setup.
 *
 * @since 1.4.5
 */
class Data_Cleaner {

	/**
	 * Option that turns on cleanup when the plugin is deleted.
	 */
	const UNINSTALL_OPTION = 'wpte_pl_delete_data_on_uninstall';

	/**
	 * Settings page options.
	 */
	const SETTINGS = [ 'wpte_pl_settings' ];

	/**
	 * Internal options (install state).
	 */
	const OPTIONS = [ 'WPTE_wpl_installed', 'WPTE_wpl_version', 'WPTE_wpl_activation_redirect' ];

	/**
	 * Cached header menu.
	 */
	const TRANSIENTS = [ 'get_wpte_wpl_admin_menu' ];

	/**
	 * Layouts table name.
	 *
	 * @return string
	 */
	public static function table() {
		global $wpdb;
		return $wpdb->prefix . 'wpte_product_layout_style';
	}

	/**
	 * Number of saved layouts, for the Danger zone text and dialog.
	 *
	 * @return int
	 */
	public static function count_layouts() {
		global $wpdb;
		if ( ! self::table_exists() ) {
			return 0;
		}
		return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . esc_sql( self::table() ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	}

	/**
	 * Delete every layout and setting, keep the plugin usable.
	 *
	 * Rows are deleted rather than the table truncated, so new layouts never
	 * reuse an old ID and suddenly appear wherever an old shortcode was left.
	 */
	public static function delete_now() {
		global $wpdb;
		if ( self::table_exists() ) {
			$wpdb->query( 'DELETE FROM ' . esc_sql( self::table() ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		}
		foreach ( self::SETTINGS as $option ) {
			delete_option( $option );
		}
		foreach ( self::TRANSIENTS as $transient ) {
			delete_transient( $transient );
		}
	}

	/**
	 * Freemius after_uninstall callback.
	 */
	public static function uninstall() {
		if ( is_multisite() ) {
			foreach ( get_sites( [ 'fields' => 'ids', 'number' => 0 ] ) as $site_id ) {
				switch_to_blog( $site_id );
				self::uninstall_site();
				restore_current_blog();
			}
			return;
		}
		self::uninstall_site();
	}

	/**
	 * Remove everything on the current site, if the site opted in.
	 */
	public static function uninstall_site() {
		global $wpdb;
		if ( 'yes' !== get_option( self::UNINSTALL_OPTION ) ) {
			return;
		}
		$wpdb->query( 'DROP TABLE IF EXISTS ' . esc_sql( self::table() ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.DirectDatabaseQuery.SchemaChange, WordPress.DB.PreparedSQL.InterpolatedNotPrepared

		foreach ( array_merge( self::SETTINGS, self::OPTIONS ) as $option ) {
			delete_option( $option );
		}
		foreach ( self::TRANSIENTS as $transient ) {
			delete_transient( $transient );
		}
		delete_option( self::UNINSTALL_OPTION );
	}

	/**
	 * Whether the layouts table exists.
	 *
	 * @return bool
	 */
	public static function table_exists() {
		global $wpdb;
		$table = self::table();
		return $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table ) ) ) === $table; // phpcs:ignore WordPress.DB.DirectDatabaseQuery
	}
}
