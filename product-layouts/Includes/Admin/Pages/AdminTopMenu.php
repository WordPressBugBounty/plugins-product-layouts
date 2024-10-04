<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

/**
 * Admin Menu Class
 *
 * @since 1.0.0
 */
trait AdminTopMenu {

	/**
	 * Admin Menu Converter.
	 *
	 * @param string $arg .
	 * @since 1.0.0
	 */
	public function admin_url_convert( $arg ) {
		return admin_url( strpos( $arg, 'edit') !== false ? $arg : 'admin.php?page=' . $arg );
	}

	/**
	 * Product Layout Admin Top Menu
	 *
	 * @since 1.0.0
	 */
	public function wpte_admin_menu() {

		$adminmenu = 'get_wpte_wpl_admin_menu';

		$response = ! empty( get_transient( $adminmenu ) ) ? get_transient( $adminmenu ) : [];

		if ( ! array_key_exists('Product Layout', $response) ) :

			$response['Product Layout']['Product Layout'] = [
				'name'     => 'Product Layout',
				'menupage' => 'product-layouts',
			];
			$response['Product Layout']['Shortcode List'] = [
				'name'     => 'Shortcode List',
				'menupage' => 'product-layouts-shortcode',
			];

			set_transient($adminmenu, $response, 10 * DAY_IN_SECONDS);

		endif;

		$adminLogo = WPTE_WPL_URL . '/Image/wpl-logo.svg';
		$sub       = '';

		$menu = '<div class="wpte-wpl-wrapper">
					<div class="wpte-wpl-admin-top-menu">
						<div class="wpte-wpl-admin-top-logo">
							<a href="' . esc_url($this->admin_url_convert('product-layouts')) . '" class="header-logo">
								<img src="' . $adminLogo . '"/>
							</a>
						</div>
						<nav class="wpte-wpl-admin-top-nav">
							<ul class="wpte-wpl-admin-menu">';

								$GETPage = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
								$layouts = ( ! empty( $_GET['layouts'] ) ? sanitize_text_field( wp_unslash( $_GET['layouts'] ) ) : '' );

		if ( count( $response ) == 1 ) :
			if ( $layouts != '' ) :
				$menu .= '<li class="active" >
							<a href="' . esc_url($this->admin_url_convert('product-layouts')) . '&layouts=' . esc_attr($layouts) . '">';
				if ( $layouts == 'display' ) :
					$menu .= 'Display Post';
				else :
					$menu .= name_converter($layouts) . ' Layouts';
				endif;
				$menu . '   </a>
						</li>';

			endif;
			foreach ( $response['Product Layout'] as $key => $value ) {

				$active = ( ( $GETPage == $value['menupage'] && $layouts == '' ) ? ' class="active" ' : '' );
				$menu  .= '<li ' . $active . '><a href="' . esc_url($this->admin_url_convert($value['menupage'])) . '">' . esc_html( name_converter( $value['name'] ) ) . '</a></li>';
			}
		else :
			foreach ( $response as $key => $value ) {
				$active = ( $key == 'Product Layout' ? 'active' : '' );
				$menu  .= '<li class="' . $active . '"><a class="wpte-wpl-drop-menu" href="#">' . esc_html( name_converter( $key ) ) . '</a>';
				$menu  .= '   <div class="wpte-wpl-d-menu">
									<div class="wpte-wpl-drop-menu-li">';
				foreach ( $value as $key2 => $submenu ) {
					$menu .= '<a href="' . $this->admin_url_convert($submenu['menupage']) . '">' . esc_html( name_converter( $submenu['name'] ) ) . '</a>';
				}
				$menu .= '</div>';
				$menu .= '</li>';
			}
			if ( $GETPage == 'product-layouts' || $GETPage == 'product-layouts-shortcode' ) :
				$sub .= '<div class="wpte-wpl-main-tab-header">';
				if ( $layouts != '' ) :
					$sub .= '<a href="' . esc_url($this->admin_url_convert('product-layouts')) . '&layouts=' . esc_attr( $layouts ) . '">
								<div class="wpte-wpl-header wpte-active">';
					if ( $layouts == 'display' ) :
						$sub .= 'Display Post';
					else :
						$sub .= name_converter($layouts) . ' Layouts';
					endif;
					$sub .= '       </div>
							</a>';
				endif;
				foreach ( $response['Product Layout'] as $key => $value ) {
					$active = ( ( $GETPage == $value['menupage'] && $layouts == '' ) ? 'wpte-active' : '' );
					$sub   .= '<a href="' . esc_url($this->admin_url_convert($value['menupage'])) . '">
								<div class="wpte-wpl-header ' . $active . '">' . esc_attr( name_converter( $value['name'] ) ) . '</div>
							</a>';
				}
				$sub .= '</div>';
			endif;
		endif;
		$menu .= ' </ul>
					<ul class="wpte-wpl-admin-menu2"> ';
		if ( ! wpte_version_control() ) {
			$menu .= ' <li class="wpte-wpl-upgrade"><a target="_black" href="https://product-layouts.com/pricing/">Upgrade</a></li>';
		}
		$menu .= ' <li class="wpte-wpl-doc"><a target="_black" href="https://wpkin.com/docs-category/product-layouts/">Docs</a></li>
						<li class="wpte-wpl-support"><a target="_black" href="https://wordpress.org/support/plugin/product-layouts#new-post">Support</a></li>
						<li class="wpte-wpl-set"><a href="' . esc_url(admin_url('admin.php?page=product-layouts-settings')) . '"><span class="dashicons dashicons-admin-generic"></span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		' . $sub;
		echo wp_kses( $menu, wpte_plugins_allowedtags() );
	}
}
