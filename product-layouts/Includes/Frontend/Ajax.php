<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Frontend;

/**
 * Frontend Ajax Handler Class
 */
class Ajax {

	/**
	 * Product List.
	 *
	 * @var products_list
	 */
	public $products_list = [];

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'wp_ajax_wpte_quick_view_popup', [ $this, 'wpte_quick_view_popup' ] );
		add_action( 'wp_ajax_nopriv_wpte_quick_view_popup', [ $this, 'wpte_quick_view_popup' ] );
		add_action( 'wp_ajax_wpte_quick_view_add_to_cart', [ $this, 'wpte_quick_view_add_to_cart' ] );
		add_action( 'wp_ajax_nopriv_wpte_quick_view_add_to_cart', [ $this, 'wpte_quick_view_add_to_cart' ] );
		// Compare.
		add_action( 'wp_ajax_wpte_product_compare_popup', [ $this, 'wpte_product_compare_popup' ] );
		add_action( 'wp_ajax_nopriv_wpte_product_compare_popup', [ $this, 'wpte_product_compare_popup' ] );
		add_action( 'wp_ajax_wpte_compare_product_remove', [ $this, 'wpte_compare_product_remove' ] );
		add_action( 'wp_ajax_nopriv_wpte_compare_product_remove', [ $this, 'wpte_compare_product_remove' ] );

		// Product Filter.
		add_action( 'wp_ajax_wpte_load_filter_product', [ $this, 'wpte_load_filter_product' ] );
		add_action( 'wp_ajax_nopriv_wpte_load_filter_product', [ $this, 'wpte_load_filter_product' ] );

		// Load products based on category.
		add_action( 'wp_ajax_wpte_load_product_based_on_category', [ $this, 'wpte_load_product_based_on_category' ] );
		add_action( 'wp_ajax_nopriv_wpte_load_product_based_on_category', [ $this, 'wpte_load_product_based_on_category' ] );

		// Pagination.
		add_action( 'wp_ajax_wpte_product_pagination', [ $this, 'wpte_product_pagination' ] );
		add_action( 'wp_ajax_nopriv_wpte_product_pagination', [ $this, 'wpte_product_pagination' ] );

		// Load More.
		add_action( 'wp_ajax_wpte_product_load_more', [ $this, 'wpte_product_load_more' ] );
		add_action( 'wp_ajax_nopriv_wpte_product_load_more', [ $this, 'wpte_product_load_more' ] );
	}

	/**
	 * Method wpte_quick_view_popup.
	 */
	public function wpte_quick_view_popup() {

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wpte-global-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		$product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : '';

		global $post, $product;

		$product   = wc_get_product( $product_id );
		$post_data = get_post( $product_id );
		setup_postdata( $post_data );
		ob_start();
		?>
		<div class="wpte-quick-view-wrapper">
			<div id="wpte<?php echo esc_attr( $product->get_id() ); ?>" class="woocommerce">
				<div class="wpte-product-popup-bg">
					<div id="wpte-quick-view-box" <?php post_class( 'product wpte-product-popup-box' ); ?>>
						<span class="wpte-product-popup-close">×</span>
						<?php new \WPTE_PRODUCT_LAYOUT\Templates\QuickView( $product_id ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		$data = ob_get_clean();
		wp_reset_postdata();
		wp_send_json_success(
            [
				'data' => $data,
			]
        );
	}

	/**
	 * Method wpte_quick_view_add_to_cart.
	 */
	public function wpte_quick_view_add_to_cart() {

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wpte-global-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		$cart_items = isset( $_POST['cart_item_data'] ) ? filter_input( INPUT_POST, 'cart_item_data', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];
		$variation  = [];
		if ( ! empty( $cart_items ) ) {
			foreach ( $cart_items as $key => $value ) {
				if ( preg_match( '/^attribute*/', $value['name'] ) ) {
					$variation[ $value['name'] ] = sanitize_text_field( $value['value'] );
				}
			}
		}

		if ( isset( $_POST['product_data'] ) ) {
			$product_data = filter_input( INPUT_POST, 'product_data', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY );

			foreach ( $product_data as $item ) {
				$product_id   = isset( $item['product_id'] ) ? sanitize_text_field( $item['product_id'] ) : 0;
				$variation_id = isset( $item['variation_id'] ) ? sanitize_text_field( $item['variation_id'] ) : 0;
				$quantity     = isset( $item['quantity'] ) ? sanitize_text_field( $item['quantity'] ) : 0;

				if ( $variation_id ) {
					WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );
				} else {
					WC()->cart->add_to_cart( $product_id, $quantity );
				}
			}
		}

		ob_start();
		wc_print_notices();
		// wc_clear_notices();.
		$notices = wc_kses_notice( ob_get_clean() );

		wp_send_json_success(
            [
				'notices' => $notices,
			]
        );
	}

	/**
	 * Method add_product_to_compare
	 *
	 * @param int $product_id Product ID to add in the comparison table.
	 * @since 1.0.1
	 */
	public function add_product_to_compare( $product_id ) {

		$_ids = filter_input( INPUT_COOKIE, 'wpte_product_compare_id', FILTER_SANITIZE_STRING );
		$ids  = isset( $_COOKIE['wpte_product_compare_id'] ) ? json_decode( $_ids ) : [];

		if ( ! in_array( $product_id, $ids ) ) {
			$this->products_list[] = absint( $product_id );
			if ( $ids ) {
				$arg = array_merge( $ids, $this->products_list );
			} else {
				$arg = $this->products_list;
			}
			setcookie( 'wpte_product_compare_id', wp_json_encode( $arg ), 0, COOKIEPATH, COOKIE_DOMAIN, false, false );
		}
	}

	/**
	 * Method add_product_to_compare.
	 *
	 * @since 1.0.1
	 */
	public function wpte_product_compare_popup() {

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wpte-global-nonce' ) ) {
			wp_send_json_success(
                [
					'nonceerror' => __( 'Nonce Varification Failed!', 'wpte-product-layout' ),
				]
            );
			return false;
		}

		$product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;

		if ( ! $product_id ) {
			wp_send_json_success(
                [
					'iderror' => __( 'Product id not found!', 'wpte-product-layout' ),
				]
            );
		}

		$this->add_product_to_compare( $product_id );

		if ( isset( $_COOKIE['wpte_product_compare_id'] ) ) {
			$_ids        = filter_input( INPUT_COOKIE, 'wpte_product_compare_id', FILTER_SANITIZE_STRING );
			$product_ids = isset( $_COOKIE['wpte_product_compare_id'] ) ? json_decode( $_ids ) : [];

			if ( ! in_array( $product_id, $product_ids ) ) {
				if ( $product_ids ) {
					$new_list = array_merge( $product_ids, $this->products_list );
				} else {
					$new_list = [ $product_id ];
				}
			} else {
				$new_list = $product_ids;
			}
		} else {
			$new_list = $this->products_list;
		}
		ob_start();

		?>

		<div class="wpte-product-compare-wrapper">
			<div id="wpte" class="woocommerce">
				<div class="wpte-product-popup-bg">
					<div id="wpte-product-compare-box" class="wpte-product-popup-box">
						<span class="wpte-product-popup-close">×</span>
						<?php
						if ( $new_list ) {
							new \WPTE_PRODUCT_LAYOUT\Templates\Compare( $new_list );
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<?php

		$data = ob_get_clean();
		if ( $data ) {
			wp_send_json_success(
                [
					'data' => $data,
				]
            );
		} else {
			wp_send_json_success(
                [
					'error' => __( 'Something went wrong!', 'wpte-product-layout' ),
				]
            );
		}
	}

	/**
	 * Add a product in the products comparison table
	 *
	 * @since 1.0.1
	 * @param int $product_id Product ID to add in the comparison table.
	 */
	public function remove_product_to_compare( $product_id ) {

		$_ids = filter_input( INPUT_COOKIE, 'wpte_product_compare_id', FILTER_SANITIZE_STRING );
		$ids  = isset( $_COOKIE['wpte_product_compare_id'] ) ? json_decode( $_ids ) : [];

		if ( in_array( $product_id, $ids ) ) {
			$key = array_search( $product_id, $ids );
			if ( false !== $key ) {
				unset( $ids[ $key ] );
			}

			$arr = array_values( $ids );
			setcookie( 'wpte_product_compare_id', wp_json_encode( $arr ), 0, COOKIEPATH, COOKIE_DOMAIN, false, false );
		}
	}

	/**
	 * Method wpte_compare_product_remove.
	 * Compare table remove product
	 *
	 * @since 1.0.1
	 */
	public function wpte_compare_product_remove() {

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wpte-global-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		$product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;

		$this->remove_product_to_compare( $product_id );
		exit;
	}

	/**
	 * Method wpte_load_filter_product.
	 * Frontend product filter
	 *
	 * @since 1.0.3
	 */
	public function wpte_load_filter_product() {

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wpte-global-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		global $wpdb;
		$ids            = isset( $_POST['id'] ) ? filter_input( INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];
		$layoutid       = isset( $_POST['layoutid'] ) ? intval( $_POST['layoutid'] ) : '';
		$data           = ! empty( $_POST['data'] ) ? filter_input( INPUT_POST, 'data', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];
		$wpte_attribute = ! empty( $_POST['wpte_attribute'] ) ? filter_input( INPUT_POST, 'wpte_attribute', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];

		$user      = 'admin';
		$dbData    = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $layoutid ), ARRAY_A );
		$StyleName = explode( '-', ucfirst( $dbData['style_name'] ) );

		$cls     = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $StyleName[0] . '\Frontend\Layout' . $StyleName[1];
		$clas = new $cls( [ 'id' => $dbData['id'] ], 'admin' );

		$settings = json_decode( $dbData['rawdata'], true );

		$sort_by       = '';
		$per_page      = '';
		$category      = [];
		$rating        = [];
		$min_max_price = '';
		$attributes    = [];
		foreach ( $ids as $id ) {
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_sort_by_$id" ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_sort_by_$id" ] ) {
				$sort_by = $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_sort_by_$id" ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_show_per_page_$id" ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_show_per_page_$id" ] ) {
				$per_page = $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_show_per_page_$id" ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_cat_$id" ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_cat_$id" ] ) {
				$category = $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_cat_$id" ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_rating_' . $id ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_rating_' . $id ] ) {
				$rating = $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_rating_' . $id ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_price_' . $id ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_price_' . $id ] ) {
				$min_max_price = $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_price_' . $id ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_attribute_' . $id ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_attribute_' . $id ] ) {
				$attributes[ $wpte_attribute[ $id ] ] = $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_attribute_' . $id ];
			}
		}

		if ( $sort_by ) {
			$settings['wpte_product_layout_product_sort_by'] = $sort_by;
		}
		if ( $per_page ) {
			$settings['wpte_product_layout_product_number'] = $per_page;
		}
		if ( $category ) {
			$settings['wpte_product_layout_product_category'] = $category;
		}
		if ( $rating ) {
			$settings['wpte_product_layout_product_rating'] = $rating;
		}
		if ( $min_max_price ) {
			$settings['wpte_product_layout_product_min_max_price'] = $min_max_price;
		}
		if ( $attributes ) {
			$settings['wpte_product_layout_product_attributes'] = $attributes;
		}

		ob_start();
			$clas->layout_render( $settings, $user );
		$data = ob_get_clean();

		$pagination = '';
		if ( wpte_version_control() ) {
			if ( isset( $settings['wpte_product_layout_pagination_global_display'] ) && 'pagination' === $settings['wpte_product_layout_pagination_global_display'] ) {
				ob_start();
				echo '<div class="wpte-product-paginations">';
				$clas->wpte_products_pagination_render( $settings, 1, $layoutid );
				echo '</div>';
				$pagination = ob_get_clean();
			} elseif ( isset( $settings['wpte_product_layout_pagination_global_display'] ) && 'load_more' === $settings['wpte_product_layout_pagination_global_display'] ) {
				ob_start();
				echo '<div class="wpte-product-load-more">';
				$clas->wpte_products_load_more_render( $settings, $layoutid );
				echo '</div>';
				$pagination = ob_get_clean();
			}
		}

		wp_send_json_success(
            [
				'data'       => $data,
				'pagination' => $pagination,
			]
        );
	}

	/**
	 * Method wpte_load_product_based_on_category
	 * Load product based on category
	 *
	 * @since 1.0.3
	 */
	public function wpte_load_product_based_on_category() {

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wpte-global-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		global $wpdb;
		$catid    = isset( $_POST['catid'] ) ? intval( $_POST['catid'] ) : '';
		$layoutid = isset( $_POST['layoutid'] ) ? intval( $_POST['layoutid'] ) : '';

		$user      = 'admin';
		$dbData    = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $layoutid ), ARRAY_A );
		$StyleName = explode( '-', ucfirst( $dbData['style_name'] ) );

		$cls     = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $StyleName[0] . '\Frontend\Layout' . $StyleName[1];
		$clas = new $cls( [ 'id' => $dbData['id'] ], 'admin' );

		$settings = json_decode( $dbData['rawdata'], true );

		$settings['wpte_product_layout_product_category'] = $catid;

		ob_start();
		$clas->layout_render( $settings, $user );
		$data = ob_get_clean();

		wp_send_json_success(
            [
				'data' => $data,
			]
        );
	}

	/**
	 * Method wpte_product_pagination
	 * Load product using pagination
	 *
	 * @since 1.1.2
	 */
	public function wpte_product_pagination() {

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wpte-global-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		global $wpdb;
		$ids      = isset( $_POST['id'] ) ? filter_input( INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];
		$page_id  = isset( $_POST['page_id'] ) ? intval( $_POST['page_id'] ) : '';
		$layoutid = isset( $_POST['layoutid'] ) ? intval( $_POST['layoutid'] ) : '';
		$data     = ! empty( $_POST['data'] ) ? filter_input( INPUT_POST, 'data', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];

		$user      = 'admin';
		$dbData    = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $layoutid ), ARRAY_A );
		$StyleName = explode( '-', ucfirst( $dbData['style_name'] ) );

		$cls     = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $StyleName[0] . '\Frontend\Layout' . $StyleName[1];
		$clas = new $cls( [ 'id' => $dbData['id'] ], 'admin' );

		$settings = json_decode( $dbData['rawdata'], true );

		$sort_by       = '';
		$per_page      = '';
		$category      = [];
		$rating        = [];
		$min_max_price = '';
		foreach ( $ids as $id ) {
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_sort_by_$id" ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_sort_by_$id" ] ) {
				$sort_by = $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_sort_by_$id" ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_show_per_page_$id" ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_show_per_page_$id" ] ) {
				$per_page = $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_show_per_page_$id" ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_cat_$id" ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_cat_$id" ] ) {
				$category = $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_cat_$id" ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_rating_' . $id ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_rating_' . $id ] ) {
				$rating = $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_rating_' . $id ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_price_' . $id ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_price_' . $id ] ) {
				$min_max_price = $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_price_' . $id ];
			}
		}

		if ( $category ) {
			$settings['wpte_product_layout_product_category'] = $category;
		}
		if ( $per_page ) {
			$settings['wpte_product_layout_product_number'] = $per_page;
		}

		if ( $min_max_price ) {
			$settings['wpte_product_layout_product_min_max_price'] = $min_max_price;
		}
		if ( $rating ) {
			$settings['wpte_product_layout_product_rating'] = $rating;
		}
		if ( $sort_by ) {
			$settings['wpte_product_layout_product_sort_by'] = $sort_by;
		}

		$settings['wpte_product_layout_page_id'] = $page_id;

		ob_start();
		$clas->layout_render( $settings, $user );
		$data = ob_get_clean();

		$pagination = '';
		if ( wpte_version_control() ) {
			ob_start();
			$clas->wpte_products_pagination_render( $settings, $page_id, $layoutid );
			$pagination = ob_get_clean();
		}
		wp_send_json_success(
            [
				'data'       => $data,
				'pagination' => $pagination,
			]
        );
	}

	/**
	 * Method wpte_product_pagination
	 * Load product using pagination
	 *
	 * @since 1.1.2
	 */
	public function wpte_product_load_more() {

		$nonce = isset( $_REQUEST['_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wpte-global-nonce' ) ) {
			return esc_html__( 'Nonce Varification Failed!', 'wpte-product-layout' );
		}

		global $wpdb;
		$ids          = isset( $_POST['id'] ) ? filter_input( INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];
		$add_page     = isset( $_POST['add_page'] ) ? intval( $_POST['add_page'] ) : '';
		$layoutid     = isset( $_POST['layoutid'] ) ? intval( $_POST['layoutid'] ) : '';
		$current_page = isset( $_POST['current_page'] ) ? intval( $_POST['current_page'] ) : '';
		$data         = ! empty( $_POST['data'] ) ? filter_input( INPUT_POST, 'data', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY ) : [];

		$user      = 'admin';
		$dbData    = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $layoutid ), ARRAY_A );
		$StyleName = explode( '-', ucfirst( $dbData['style_name'] ) );

		$cls     = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $StyleName[0] . '\Frontend\Layout' . $StyleName[1];
		$clas = new $cls( [ 'id' => $dbData['id'] ], 'admin' );

		$settings = json_decode( $dbData['rawdata'], true );

		$sort_by       = '';
		$per_page      = '';
		$category      = [];
		$rating        = [];
		$min_max_price = '';
		foreach ( $ids as $id ) {
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_sort_by_$id" ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_sort_by_$id" ] ) {
				$sort_by = $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_sort_by_$id" ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_show_per_page_$id" ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_show_per_page_$id" ] ) {
				$per_page = $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_show_per_page_$id" ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_cat_$id" ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_cat_$id" ] ) {
				$category = $data[ "wpte-product-filter-form-$id" ][ "wpte_product_filter_cat_$id" ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_rating_' . $id ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_rating_' . $id ] ) {
				$rating = $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_rating_' . $id ];
			}
			if ( isset( $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_price_' . $id ] ) && '' !== $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_price_' . $id ] ) {
				$min_max_price = $data[ "wpte-product-filter-form-$id" ][ 'wpte_product_filter_price_' . $id ];
			}
		}

		if ( $category ) {
			$settings['wpte_product_layout_product_category'] = $category;
		}
		if ( $per_page ) {
			$settings['wpte_product_layout_product_number'] = $per_page;
		}

		if ( $min_max_price ) {
			$settings['wpte_product_layout_product_min_max_price'] = $min_max_price;
		}
		if ( $rating ) {
			$settings['wpte_product_layout_product_rating'] = $rating;
		}
		if ( $sort_by ) {
			$settings['wpte_product_layout_product_sort_by'] = $sort_by;
		}

		$settings['wpte_product_layout_product_number_load'] = $add_page;

		ob_start();
		$clas->layout_render( $settings, $user );
		$data = ob_get_clean();

		ob_start();
		$clas->wpte_products_load_more_render( $settings, $layoutid );
		$load_more = ob_get_clean();

		wp_send_json_success(
            [
				'data'      => $data,
				'load_more' => $load_more,
			]
        );
	}
}