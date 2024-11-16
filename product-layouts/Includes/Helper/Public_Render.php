<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Helper;

/**
 * Class Public_Render.
 */
class Public_Render {

	/**
	 * Dbdata
	 *
	 * @var array
	 */
	public $dbdata = [];

	/**
	 * ID
	 *
	 * @var string
	 */
	public $wpteid;

	/**
	 * User
	 *
	 * @var string
	 */
	public $user;

	/**
	 * Js handle
	 *
	 * @var string
	 */
	public $jshandle = 'wpte-product-layout';

	/**
	 * Style
	 *
	 * @var string
	 */
	public $style = '';

	/**
	 * Page Id
	 *
	 * @var number
	 */
	public $page_id = 1;

	/**
	 * CSSDATA
	 *
	 * @var string
	 */
	public $CSSDATA = '';

	/**
	 * WRAPPER
	 *
	 * @var string
	 */
	public $WRAPPER = '';

	/**
	 * WRAPPER
	 *
	 * @var string
	 */
	public $layout_id = '';

	/**
	 * Method __construct.
	 *
	 * @param mixed $dbdata .
	 * @param mixed $user .
	 *
	 * @return void
	 */
	public function __construct( $dbdata = [], $user = 'user' ) {

		$this->dbdata = $dbdata;
		$this->user   = $user;

		if ( array_key_exists( 'id', $this->dbdata ) ) :
			$this->wpteid = $dbdata['id'];
		else :
			$this->wpteid = wp_rand( 100000, 200000 );
		endif;

		if ( ! empty( $dbdata['rawdata'] ) ) :
			$this->loader();
		endif;
	}

	/**
	 * Current element loader
	 *
	 * @since 1.0.0
	 */
	public function loader() {

		$this->style     = json_decode( $this->dbdata['rawdata'], true );
		$this->CSSDATA   = $this->dbdata['stylesheet'];
		$this->WRAPPER   = 'wpte-product-layout-wrapper-' . $this->dbdata['id'];
		$this->layout_id = $this->dbdata['id'];
		$this->hooks();
	}

	/**
	 * Load css and js hooks
	 *
	 * @since 1.0.0
	 */
	public function hooks() {

		$this->public_js();
		$this->render();
		$inlinecss = '';
		if ( $this->CSSDATA === '' && $this->user === 'admin' ) {

			$name    = explode( '-', $this->dbdata['style_name'] );
			$cls     = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . $name[0] . '\Backend\\Layout' . $name[1];
			$CLASS      = new $cls( 'admin' );
			$inlinecss .= $CLASS->inline_template_css_render( $this->style );
		} else {
			$inlinecss .= $this->CSSDATA;
		}

		$font_family = $this->dbdata['font_family'] !== '' && isset( $this->dbdata['font_family'] ) ? json_decode( $this->dbdata['font_family'], true ) : [];
		echo wp_kses( (string) font_familly_validation( $font_family ), true );

		if ( $inlinecss !== '' ) :
			$inlinecss = html_entity_decode( str_replace( '<br>', '', str_replace( '&nbsp;', ' ', $inlinecss ) ) );
			if ( $this->user === 'admin' ) {
				printf( '<style>%s</style>', esc_html( $inlinecss ) );
			} else {
				wp_register_style( 'wpte-product-layouts', false, null, WPTE_WPL_VERSION );
				wp_enqueue_style( 'wpte-product-layouts' );
				wp_add_inline_style( 'wpte-product-layouts', $inlinecss );
			}
		endif;
	}

	/**
	 * Load current element render since 1.0.0
	 *
	 * @since 1.0.0
	 */
	public function render() {

		$pagination_load_more = ( isset( $this->style['wpte_product_layout_pagination_global_display'] ) && $this->style['wpte_product_layout_pagination_global_display'] ) ? $this->style['wpte_product_layout_pagination_global_display'] : '';

		printf( '<div class="wpte-product-container %1$s" id="%1$s"><div class="wpte-product-row">', esc_attr( $this->WRAPPER ) );

		printf( '<div class="wpte-product-load">' );
			$this->layout_render( $this->style, $this->user );

		if ( wpte_version_control() ) {
			if ( 'pagination' === $pagination_load_more ) {
				printf( '<div class="wpte-product-paginations">' );
				$this->wpte_products_pagination_render( $this->style, $this->page_id, $this->layout_id );
				printf( '</div>' );
			} elseif ( 'load_more' === $pagination_load_more ) {
				printf( '<div class="wpte-product-load-more">');
				$this->wpte_products_load_more_render( $this->style, $this->layout_id );
				printf( '</div>' );
			}
		}

		printf( '</div></div></div>' );
	}

	/**
	 * Method layout_render.
	 *
	 * @param mixed $style .
	 * @param mixed $user .
	 * @return void
	 */
	public function layout_render( $style, $user ) {
		echo '';
	}

	/**
	 * Load public css
	 *
	 * @since 1.0.0
	 */
	public function public_js() {
		echo '';
	}
	
	/**
	 * Method tab_column_render.
	 *
	 * @param mixed $id .
	 * @param mixed $style .
	 * @return string
	 */
	public function tab_column_render( $id, $style ) {
		if ( $style[ $id . '-lap' ] === 'wpte-col-lap-1' ) :
			return 'wpte-col-tab-1';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-2' ) :
			return 'wpte-col-tab-2';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-3' ) :
			return 'wpte-col-tab-3';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-4' ) :
			return 'wpte-col-tab-4';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-5' ) :
			return 'wpte-col-tab-5';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-6' ) :
			return 'wpte-col-tab-6';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-7' ) :
			return 'wpte-col-tab-7';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-8' ) :
			return 'wpte-col-tab-8';
		else :
			return 'wpte-col-tab-12';
		endif;
	}

	/**
	 * Method wpte_get_woo_products.
	 *
	 * @param mixed $settings .
	 * @return array
	 */
	public function wpte_get_woo_products($settings) {
		// Extracting settings with default values
		$get_product_cats = !empty($settings['wpte_product_layout_product_category']) ? $settings['wpte_product_layout_product_category'] : [];
		$product_cats = str_replace(' ', '', $get_product_cats);
	
		$product_type = !empty($settings['wpte_product_layout_product_type']) ? $settings['wpte_product_layout_product_type'] : [];
		$include_product_ids = !empty($settings['wpte_product_layout_include_product']) ? $settings['wpte_product_layout_include_product'] : [];
		$exclude_product_ids = !empty($settings['wpte_product_layout_exclude_product']) ? $settings['wpte_product_layout_exclude_product'] : [];
		$page_id = !empty($settings['wpte_product_layout_page_id']) ? $settings['wpte_product_layout_page_id'] : 1;
		$product_number_load = !empty($settings['wpte_product_layout_product_number_load']) ? $settings['wpte_product_layout_product_number_load'] : 0;
		$_post_per_page = !empty($settings['wpte_product_layout_product_number']) ? $settings['wpte_product_layout_product_number'] : 4;
		$wpte_attributes = !empty($settings['wpte_product_layout_product_attributes']) ? $settings['wpte_product_layout_product_attributes'] : [];
	
		// Determine posts per page
		$post_per_page = $product_number_load ? $product_number_load : $_post_per_page;
	
		// Category retrieve
		$cat_args = array(
			'order'      => 'ASC',
			'hide_empty' => false,
			'include'    => $product_cats,
			'orderby'    => 'include',
		);
	
		$product_categories = get_terms('product_cat', $cat_args);
	
		// Query arguments
		$args = array(
			'post_type'      => 'product',
			'post_status'    => array('publish'),
			'posts_per_page' => $post_per_page,
			'order'          => !empty($settings['wpte_product_layout_product_order']) ? $settings['wpte_product_layout_product_order'] : 'desc',
			'paged'          => $page_id,
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => array('exclude-from-search', 'exclude-from-catalog'),
					'operator' => 'NOT IN',
				),
			),
			'post__in'       => $include_product_ids,
			'post__not_in'   => $exclude_product_ids,
		);

		// Orderby logic
		if ( ! empty( $settings[ 'wpte_product_layout_product_order_by' ] ) ) {
			switch ($settings['wpte_product_layout_product_order_by']) {
				case 'ID':
					$args['orderby'] = 'ID';
					break;
				case 'title':
					$args['orderby'] = 'title';
					break;
				case '_price':
				case '_sku':
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = $settings['wpte_product_layout_product_order_by'];
					break;
				case 'date':
					$args['orderby'] = 'date';
					break;
				case 'modified':
					$args['orderby'] = 'modified';
					break;
				case 'parent':
					$args['orderby'] = 'parent';
					break;
				case 'rand':
					$args['orderby'] = 'rand';
					break;
				case 'menu_order':
					$args['orderby'] = 'menu_order';
					break;
				case 'alphabetically':
					$args['orderby'] = 'title';
					$args['order'] = 'ASC';
					break;
				default:
					$args['orderby'] = 'date';
					break;
			}
		} else {
			$args['orderby'] = 'date';
		}
	
		// Category tax query
		if (!empty($get_product_cats) && !empty($product_categories)) {
			$args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $get_product_cats,
				'operator' => 'IN',
			);
		}
	
		// Product type tax query
		if (!empty($product_type)) {
			$args['tax_query'][] = array(
				'taxonomy' => 'product_type',
				'field'    => 'term_id',
				'terms'    => $product_type,
			);
		}
	
		// Meta queries
		$args['meta_query'] = array('relation' => 'AND');
	
		if (!empty($settings['wpte_product_layout_product_stock_status']) && $settings['wpte_product_layout_product_stock_status'] === 'yes') {
			$args['meta_query'][] = array(
				'key'   => '_stock_status',
				'value' => 'instock',
			);
		}
	
		// Featured, Best Selling, Sale, Top products filter
		if (!empty($settings['wpte_product_layout_product_filter'])) {
			switch ($settings['wpte_product_layout_product_filter']) {
				case 'featured-products':
					$args['tax_query'][] = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'featured',
						),
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => array('exclude-from-search', 'exclude-from-catalog'),
							'operator' => 'NOT IN',
						),
					);
					break;
				case 'best-selling-products':
					$args['meta_key'] = 'total_sales';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
					break;
				case 'sale-products':
					$args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
					break;
				case 'top-products':
					$args['meta_key'] = '_wc_average_rating';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
					break;
				default:
					break;
			}
		}
	
		// Min Max price query
		if (!empty($settings['wpte_product_layout_product_min_max_price'])) {
			$min_max_price = $settings['wpte_product_layout_product_min_max_price'];
			if ($min_max_price === '20') {
				$min_price = 0;
				$max_price = 20;
			} elseif ($min_max_price === '21-40') {
				$min_price = 21;
				$max_price = 40;
			} elseif ($min_max_price === '41-70') {
				$min_price = 41;
				$max_price = 70;
			} elseif ($min_max_price === '70') {
				$min_price = 71;
				$max_price = -1;
			}
	
			$args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => array($min_price, $max_price),
				'type'    => 'numeric',
				'compare' => 'BETWEEN',
			);
		}
	
		// Rating Query
		if ( ! empty( $settings[ 'wpte_product_layout_product_rating' ] ) ) {
			$ratings = $settings['wpte_product_layout_product_rating'];
			$rating_query = array('relation' => 'OR');
	
			foreach ($ratings as $rating) {
				$rating_query[] = array(
					'key'     => '_wc_average_rating',
					'value'   => $rating,
					'type'    => 'numeric',
					'compare' => '=',
				);
			}
	
			$args['meta_query'][] = $rating_query;
		}
	
		// Sort by Query
		if (!empty($settings['wpte_product_layout_product_sort_by'])) {
			$sort_by = $settings['wpte_product_layout_product_sort_by'];
	
			switch ($sort_by) {
				case 'popularity':
					$args['meta_key'] = 'total_sales';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
					break;
				case 'latest':
					$args['orderby'] = 'date';
					$args['order']   = 'DESC';
					break;
				case 'low_to_high':
					$args['meta_key'] = '_price';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'ASC';
					break;
				case 'high_to_low':
					$args['meta_key'] = '_price';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
					break;
				default:
					break;
			}
		}
	
		// Attribute Query
		if ($wpte_attributes) {
			$wpte_attributes_arr = array();
			foreach ($wpte_attributes as $a_key => $wpte_attribute) {
				$wpte_attributes_arr[] = array(
					'taxonomy' => $a_key,
					'field'    => 'slug',
					'terms'    => $wpte_attribute,
					'operator' => 'IN',
				);
			}
	
			$args['tax_query'][] = array('relation' => 'AND') + $wpte_attributes_arr;
		}

		return $args;
	}

	/**
	 * Method mob_column_render
	 *
	 * @param mixed $id .
	 * @param mixed $style .
	 * @return string
	 */
	public function mob_column_render( $id, $style ) {

		if ( $style[ $id . '-lap' ] === 'wpte-col-lap-1' ) :
			return 'wpte-col-mob-1';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-2' ) :
			return 'wpte-col-mob-2';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-3' ) :
			return 'wpte-col-mob-3';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-4' ) :
			return 'wpte-col-mob-4';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-5' ) :
			return 'wpte-col-mob-5';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-6' ) :
			return 'wpte-col-mob-6';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-7' ) :
			return 'wpte-col-mob-7';
		elseif ( $style[ $id . '-lap' ] === 'wpte-col-lap-8' ) :
			return 'wpte-col-mob-8';
		else :
			return 'wpte-col-mob-12';
		endif;
	}

	/**
	 * Wish List Render.
	 *
	 * @param int    $product_id .
	 * @param string $operator .
	 * @param mixed  $settings .
	 * @param string $iconPosition .
	 * @return mixed
	 */
	public function wpte_product_wishlist_render( $product_id, $operator = 'icon', $settings = [], $iconPosition = 'bottom' ) {

		$product     = wc_get_product( $product_id );
		$icon        = isset( $settings['wpte-product-wishlist-icon'] ) ? $settings['wpte-product-wishlist-icon'] : '';
		$added_icon  = isset( $settings['wpte-product-wishlist-added-icon'] ) ? $settings['wpte-product-wishlist-added-icon'] : '';
		$text        = isset( $settings['wpte-product-wishlist-text'] ) ? $settings['wpte-product-wishlist-text'] : '';
		$added_text  = isset( $settings['wpte-product-wishlist-added-text'] ) ? $settings['wpte-product-wishlist-added-text'] : '';
		$tooltip     = isset( $settings['wpte-product-wishlist-tooltip'] ) ? $settings['wpte-product-wishlist-tooltip'] : '';
		$showTooltip = isset( $settings['wpte_product_layout_wishlist_icon_tooltip_switcher'] ) ? $settings['wpte_product_layout_wishlist_icon_tooltip_switcher'] : 'right';

		// Coming from settings Style tab.
		// Icon Position = Left, Right, Top, Bottom.

		$html = '';

		if ( $operator === 'icon' ) {
			$html .= '<div class="wpte-product-layouts-wish-list">';
			if ( $showTooltip === 'yes' ) :
				$html .= "<span class='wpte-product-tooltip wpte-tooltip-" . esc_attr( $iconPosition ) . "'>" . $this->text_render( 'wpte-product-wishlist-tooltip', $tooltip ) . '</span>';
			endif;
			$html .= '<div class="tinv-wraper woocommerce tinv-wishlist tinvwl-shortcode-add-to-cart" data-product_id="' . $product_id . '">
						<a role="button" tabindex="0" aria-label="" class="tinvwl_add_to_wishlist_button tinvwl-product-already-on-wishlist" addedicon="' . $added_icon . '" data-tinv-wl-list="{1:{ID:1,title:,status:share,share_key:9ca542,in:[0]}}" id="wpte-wishlist-' . $product_id . '" data-tinv-wl-product="' . $product_id . '" data-tinv-wl-productvariation="0" data-tinv-wl-productvariations="[0]" data-tinv-wl-producttype="' . esc_html( $product->get_type() ) . '" data-tinv-wl-action="addto">';
			$html .= $this->icon_render( 'wpte-product-wishlist-icon', $icon );
			$html .= '</a></div></div>';
		} elseif ( $operator === 'text' ) {
			$html .= '<div class="wpte-product-layouts-wish-list">';
			$html .= '<div class="tinv-wraper woocommerce tinv-wishlist tinvwl-shortcode-add-to-cart" data-product_id="' . $product_id . '">
						<a role="button" tabindex="0" aria-label="" class="tinvwl_add_to_wishlist_button tinvwl-product-already-on-wishlist" addedtext="' . $added_text . '" data-tinv-wl-list="{1:{ID:1,title:,status:share,share_key:9ca542,in:[0]}}" id="wpte-wishlist-' . $product_id . '" data-tinv-wl-product="' . $product_id . '" data-tinv-wl-productvariation="0" data-tinv-wl-productvariations="[0]" data-tinv-wl-producttype="' . esc_html( $product->get_type() ) . '" data-tinv-wl-action="addto">';
			$html .= $this->text_render( 'wpte-product-wishlist-text', $text );
			$html .= '</a></div></div>';
		} else {
			$html .= '<div class="wpte-product-layouts-wish-list">';
			$html .= '<div class="tinv-wraper woocommerce tinv-wishlist tinvwl-shortcode-add-to-cart" data-product_id="' . $product_id . '">
					<a role="button" tabindex="0" aria-label="" class="tinvwl_add_to_wishlist_button tinvwl-product-already-on-wishlist" addedicon="' . $added_icon . '" addedtext="' . $added_text . '" data-tinv-wl-list="{1:{ID:1,title:,status:share,share_key:9ca542,in:[0]}}" id="wpte-wishlist-' . $product_id . '" data-tinv-wl-product="' . $product_id . '" data-tinv-wl-productvariation="0" data-tinv-wl-productvariations="[0]" data-tinv-wl-producttype="' . esc_html( $product->get_type() ) . '" data-tinv-wl-action="addto">';
			$html .= $this->icon_render( 'wpte-product-wishlist-icon', $icon );
			$html .= $this->text_render( 'wpte-product-wishlist-text', $text );
			$html .= '</a></div></div>';
		}

		return $html;
	}

	/**
	 * Method column_render
	 *
	 * @param mixed $id .
	 * @param mixed $style .
	 * @return mixed
	 */
	public function column_render( $id, $style ) {
		$file = $style[ $id . '-lap' ] . ' ';
		if ( ! array_key_exists( $id . '-tab', $style ) || $style[ $id . '-tab' ] === '' ) :
			$file .= $this->tab_column_render( $id, $style ) . ' ';
		else :
			$file .= $style[ $id . '-tab' ] . ' ';
		endif;
		if ( ! array_key_exists( $id . '-mob', $style ) || $style[ $id . '-mob' ] === '' ) :
			$file .= $this->mob_column_render( $id, $style ) . ' ';
		else :
			$file .= $style[ $id . '-mob' ] . ' ';
		endif;
		return $file;
	}

	/**
	 * Product Compare Render.
	 *
	 * @param int    $product_id .
	 * @param string $operator .
	 * @param mixed  $settings .
	 * @param string $iconPosition .
	 * @return mixed
	 */
	public function wpte_product_compare_render( $product_id, $operator = 'icon', $settings = [], $iconPosition = 'bottom' ) {

		$icon        = isset( $settings['wpte-product-compare-icon'] ) ? $settings['wpte-product-compare-icon'] : '';
		$added_icon  = isset( $settings['wpte-product-compare-added-icon'] ) ? $settings['wpte-product-compare-added-icon'] : '';
		$text        = isset( $settings['wpte-product-compare-text'] ) ? $settings['wpte-product-compare-text'] : '';
		$added_text  = isset( $settings['wpte-product-compare-added-text'] ) ? $settings['wpte-product-compare-added-text'] : '';
		$tooltip     = isset( $settings['wpte-product-compare-tooltip'] ) ? $settings['wpte-product-compare-tooltip'] : '';
		$showTooltip = isset( $settings['wpte_product_layout_compare_icon_tooltip_switcher'] ) ? $settings['wpte_product_layout_compare_icon_tooltip_switcher'] : 'right';
		// This array comming from cookie.
		$added_product_list = isset( $_COOKIE['wpte_product_compare_id'] ) ? json_decode( wp_kses( wp_unslash( $_COOKIE['wpte_product_compare_id'] ), true ) ) : [];
		// Coming from settings Style tab // Icon Position = Left, Right, Top, Bottom.

		$html = '';

		if ( $operator === 'icon' ) {
			$html .= '<div class="wpte-product-layouts-compare">';
			if ( $showTooltip === 'yes' ) :
				$html .= "<span class='wpte-product-tooltip wpte-tooltip-" . esc_attr( $iconPosition ) . "'>" . $this->text_render( 'wpte-product-compare-tooltip', $tooltip ) . '</span>';
			endif;
			$html .= '<a product_id="' . $product_id . '" compare_added_icon="' . $added_icon . '">';
			if ( in_array( $product_id, $added_product_list ) ) {
				$html .= $this->icon_render( 'wpte-product-compare-added-icon', $added_icon );
			} else {
				$html .= $this->icon_render( 'wpte-product-compare-icon', $icon );
			}
			$html .= '</a></div>';
		} elseif ( $operator === 'text' ) {
			$html .= '<div class="wpte-product-layouts-compare"><a product_id="' . $product_id . '" compare_added_text="' . $added_text . '">';
			if ( in_array( $product_id, $added_product_list ) ) {
				$html .= $this->text_render( 'wpte-product-compare-added-text', $added_text );
			} else {
				$html .= $this->text_render( 'wpte-product-compare-text', $text );
			}
			$html .= '</a></div>';
		} else {
			$html .= '<div class="wpte-product-layouts-compare"><a product_id="' . $product_id . '" compare_added_text="' . $added_text . '" compare_added_icon="' . $added_icon . '">';
			if ( in_array( $product_id, $added_product_list ) ) {
				$html .= $this->icon_render( 'wpte-product-compare-added-icon', $added_icon );
				$html .= $this->text_render( 'wpte-product-compare-added-text', $added_text );
			} else {
				$html .= $this->icon_render( 'wpte-product-compare-icon', $icon );
				$html .= $this->text_render( 'wpte-product-compare-text', $text );
			}

			$html .= '</a></div>';
		}

		return $html;
	}

	/**
	 * Product Quickview Render.
	 *
	 * @param int    $product_id .
	 * @param string $operator .
	 * @param mixed  $settings .
	 * @param string $iconPosition .
	 *
	 * @return mixed
	 */
	public function wpte_product_quickview_render( $product_id, $operator = 'icon', $settings = [], $iconPosition = 'bottom' ) {

		$icon        = isset($settings['wpte-product-quickview-icon']) ? $settings['wpte-product-quickview-icon'] : '';
		$text        = isset($settings['wpte-product-quickview-text']) ? $settings['wpte-product-quickview-text'] : '';
		$tooltip     = isset($settings['wpte-product-quickview-tooltip']) ? $settings['wpte-product-quickview-tooltip'] : '';
		$showTooltip = isset($settings['wpte_product_layout_quickview_icon_tooltip_switcher']) ? $settings['wpte_product_layout_quickview_icon_tooltip_switcher'] : 'right';
		// Coming from settings Style tab // Icon Position = Left, Right, Top, Bottom.

		$html = '';

		if ( $operator === 'icon' ) {
			$html .= '<div class="wpte-product-layouts-quick-view">';
			if ( $showTooltip === 'yes' ) :
				$html .= "<span class='wpte-product-tooltip wpte-tooltip-" . esc_attr( $iconPosition ) . "'>" . $this->text_render( 'wpte-product-quickview-tooltip', $tooltip ) . '</span>';
			endif;
			$html .= '<a productId="' . $product_id . '">';
			$html .= $this->icon_render( 'wpte-product-quickview-icon', $icon );
			$html .= '</a></div>';
		} elseif ( $operator === 'text' ) {
			$html .= '<div class="wpte-product-layouts-quick-view"><a productId="' . $product_id . '">';
			$html .= $this->text_render( 'wpte-product-quickview-text', $text );
			$html .= '</a></div>';
		} else {
			$html .= '<div class="wpte-product-layouts-quick-view"><a productId="' . $product_id . '">';
			$html .= $this->icon_render( 'wpte-product-quickview-icon', $icon );
			$html .= $this->text_render( 'wpte-product-quickview-text', $text );
			$html .= '</a></div>';
		}

		return $html;
	}

	/**
	 * Method wpte_product_cart_render.
	 *
	 * @param int    $product_id .
	 * @param string $operator .
	 * @param mixed  $settings .
	 * @param string $iconPosition .
	 */
	public function wpte_product_cart_render( $product_id, $operator = 'icon', $settings = [], $iconPosition = 'bottom' ) {
		// Icons.
		$addCart   = isset($settings['wpte-product-cart-icon']) ? $settings['wpte-product-cart-icon'] : '';
		$addedCart = isset($settings['wpte-product-added-cart-icon']) ? $settings['wpte-product-added-cart-icon'] : '';
		$grouped   = isset($settings['wpte-product-grouped-icon']) ? $settings['wpte-product-grouped-icon'] : '';
		$external  = isset($settings['wpte-product-external-icon']) ? $settings['wpte-product-external-icon'] : '';
		$variable  = isset($settings['wpte-product-variable-icon']) ? $settings['wpte-product-variable-icon'] : '';

		// Text.
		$addCartText   = isset($settings['wpte-product-cart-text']) ? $settings['wpte-product-cart-text'] : '';
		$addedCartText = isset($settings['wpte-product-cart-view']) ? $settings['wpte-product-cart-view'] : '';
		$groupedText   = isset($settings['wpte-product-grouped-text']) ? $settings['wpte-product-grouped-text'] : '';
		$externalText  = isset($settings['wpte-product-external-text']) ? $settings['wpte-product-external-text'] : '';
		$variableText  = isset($settings['wpte-product-variable-text']) ? $settings['wpte-product-variable-text'] : '';

		$is_cart_tooltip = isset($settings['wpte_product_layout_cart_icon_tooltip_switcher']) ? $settings['wpte_product_layout_cart_icon_tooltip_switcher'] : '';

		$product = wc_get_product( $product_id );

		if ( $product ) :
			if ( $operator === 'icon' ) :

				if ( $is_cart_tooltip ) {
					$productType = $product->get_type() ? $product->get_type() : 'Other';
				} else {
					$productType = false;
				}

				// Tooltip.
				switch ( $productType ) {
					case 'simple':
						$cartTooltip = $settings['wpte-product-cart-tooltip'] ? $settings['wpte-product-cart-tooltip'] : '';
						break;
					case 'grouped':
						$cartTooltip = $settings['wpte-product-grouped-tooltip'] ? $settings['wpte-product-grouped-tooltip'] : '';
						break;
					case 'external':
						$cartTooltip = $settings['wpte-product-external-tooltip'] ? $settings['wpte-product-external-tooltip'] : '';
						break;
					case 'variable':
						$cartTooltip = $settings['wpte-product-variable-tooltip'] ? $settings['wpte-product-variable-tooltip'] : '';
						break;
					default:
						$cartTooltip = 'Other';
						break;
				}

				printf('<span class="wpte-product-cart-icon-render">
					%7$s
					<span class="wpte-product-add-cart-icon wpte-cart-icon" id="wpte-cart-icons-%1$s" dataid="wpte-cart-icons-%1$s" view_cart="%2$s" add_cart="%3$s" groupde_icon="%4$s" external_icon="%5$s" variable_icon="%6$s">',
					esc_attr($this->wpteid),
					esc_attr($addedCart),
					esc_attr($addCart),
					esc_attr($grouped),
					esc_attr($external),
					esc_attr($variable),
					$productType ? "<span class='wpte-product-tooltip wpte-tooltip-" . esc_attr( $iconPosition ) . "'>" . esc_html( $cartTooltip ) . '</span>' : ''
					);
					woocommerce_template_loop_add_to_cart();
					printf('</span></span>');
			elseif ( $operator === 'text' ) :
				printf('<span class="wpte-product-cart-icon-render">
				<span class="wpte-product-add-cart-text wpte-cart-text" id="wpte-cart-text-%1$s" add_cart_text="%2$s" view_cart_text="%3$s" groupde_text="%4$s" external_text="%5$s" variable_text="%5$s">',
				esc_attr($this->wpteid),
				esc_attr($addCartText),
				esc_attr($addedCartText),
				esc_attr($groupedText),
				esc_attr($externalText),
				esc_attr($variableText)
				);
				woocommerce_template_loop_add_to_cart();
				printf('</span></span>');
			else :
				printf('<span class="wpte-product-cart-icon-render">
				<span class="wpte-product-add-cart-icon-text wpte-cart-icon-text" id="wpte-cart-icons-text-%1$s" dataid="wpte-cart-icons-text-%1$s" view_cart="%2$s" add_cart_text="%3$s" add_cart="%4$s" view_cart_text="%5$s" groupde_icon="%6$s" groupde_text="%7$s" external_icon="%8$s" external_text="%9$s" variable_icon="%10$s" variable_text="%11$s">',
				esc_attr($this->wpteid),
				esc_attr($addedCart),
				esc_attr($addCartText),
				esc_attr($addCart),
				esc_attr($addedCartText),
				esc_attr($grouped),
				esc_attr($groupedText),
				esc_attr($external),
				esc_attr($externalText),
				esc_attr($variable),
				esc_attr($variableText)
				);
				woocommerce_template_loop_add_to_cart();
				printf('</span></span>');
			endif;
		endif;
	}

	/**
	 * Method icon_render
	 *
	 * @param int    $id .
	 * @param string $icon .
	 * @return mixed
	 */
	public function icon_render( $id, $icon ) {
		return "<span class='wpte-product-icon-render'>
					<span class='$id' id='$id'>
						<i class='$icon'></i>
					</span>
				</span>";
	}

	/**
	 * Method text_render
	 *
	 * @param int    $id .
	 * @param string $text .
	 * @return mixed
	 */
	public function text_render( $id, $text ) {
		return "<span class='wpte-product-text-render'>
					<span class='$id' id='$id'>
						$text
					</span>
				</span>";
	}

	/**
	 * Method wpte_product_badge_label
	 *
	 * @return void
	 */
	public function wpte_product_badge_label() {
		global $product;

		$output = [];

		if ( $product->is_on_sale() ) {

			$percentage = '';

			if ( $product->get_type() === 'variable' ) {

				$available_variations = $product->get_variation_prices();
				$max_percentage       = 0;

				foreach ( $available_variations['regular_price'] as $key => $regular_price ) {
					$sale_price = $available_variations['sale_price'][ $key ];

					if ( $sale_price < $regular_price ) {
						$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

						if ( $percentage > $max_percentage ) {
							$max_percentage = $percentage;
						}
					}
				}

				$percentage = $max_percentage;
			} elseif ( ( $product->get_type() === 'simple' || $product->get_type() === 'external' || $product->get_type() === 'variation' ) ) {
				$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
			}

			if ( $percentage ) {
				$output[] = '<li class="onsale product-label">-' . $percentage . '% </li>';
			} else {
				$output[] = '<li class="onsale product-label">' . esc_html__( 'Sale', 'wpte-product-layout' ) . '</li>';
			}
		}

		if ( ! $product->is_in_stock() ) {
			$output[] = '<li class="out-of-stock product-label">' . esc_html__( 'Sold out', 'wpte-product-layout' ) . '</li>';
		}

		if ( $product->is_featured() ) {
			$output[] = '<li class="featured product-label">' . esc_html__( 'Hot', 'wpte-product-layout' ) . '</li>';
		}

		if ( $output ) {
			$out_data = implode( '', $output );
			echo '<ul>' . wp_kses( $out_data, wpte_plugins_allowedtags() ) . '</ul>';
		}
	}

	/**
	 * Method wpte_products_filter_render
	 *
	 * @param mixed  $settings .
	 * @param string $show_filter .
	 * @return void
	 */
	public function wpte_products_filter_render( $settings, $show_filter ) {

		$show_sort_by  = isset( $settings['wpte_product_layout_filter_sort'] ) && 'yes' === $settings['wpte_product_layout_filter_sort'] ? 'wpte-sort-by-show' : '';
		$show_per_page = isset( $settings['wpte_product_layout_filter_show_per_page'] ) && 'yes' === $settings['wpte_product_layout_filter_show_per_page'] ? 'wpte-per-page-show' : '';
		$show_category = isset( $settings['wpte_product_layout_filter_category'] ) && 'yes' === $settings['wpte_product_layout_filter_category'] ? 'wpte-category-show' : '';
		$show_rating   = isset( $settings['wpte_product_layout_filter_rating'] ) && 'yes' === $settings['wpte_product_layout_filter_rating'] ? 'wpte-rating-show' : '';
		$show_price_r  = isset( $settings['wpte_product_layout_filter_price_ranges'] ) && 'yes' === $settings['wpte_product_layout_filter_price_ranges'] ? 'wpte-price-range-show' : '';

		$is_per_page = false;
		$is_category = false;
		$is_rating   = false;
		$is_price_r  = false;

		if ( wpte_version_control() ) {
			$is_per_page = true;
			$is_category = true;
			$is_rating   = true;
			$is_price_r  = true;
		}

		$product_categories = get_terms(
			[
				'taxonomy' => 'product_cat',
				'parent'   => 0,
			]
		);
	}

	/**
	 * Method wpte_products_pagination_render
	 *
	 * @param mixed  $settings .
	 * @param number $current_page .
	 * @param number $layoutid .
	 * @return void
	 */
	public function wpte_products_pagination_render( $settings, $current_page, $layoutid ) {

		$args  = $this->wpte_get_woo_products( $settings ) ?? [];
		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			$found_posts = $query->found_posts;
			$total_pages = ceil( $found_posts / absint( $args['posts_per_page'] ) );
			$range       = 3;
			$this->new_pagination( $settings, $current_page, $total_pages, $range, $layoutid );

		}
	}

	/**
	 * Method new_pagination
	 *
	 * @param mixed  $settings .
	 * @param number $current_page .
	 * @param number $total_page .
	 * @param number $range .
	 * @param number $layoutid .
	 * @return void
	 */
	public function new_pagination( $settings, $current_page, $total_page, $range, $layoutid ) {

		$preset    = isset( $settings['wpte_product_layout_pagination_preset'] ) ? $settings['wpte_product_layout_pagination_preset'] : '';
		$prev_icon = isset( $settings['wpte_product_pagination_prev_icon'] ) && ! empty( $settings['wpte_product_pagination_prev_icon'] ) ? $this->icon_render( 'wpte_product_pagination_prev_icon', $settings['wpte_product_pagination_prev_icon'] ) : '';
		$prev_text = isset( $settings['wpte_product_pagination_prev_text'] ) && ! empty( $settings['wpte_product_pagination_prev_text'] ) ? $this->text_render( 'wpte_product_pagination_prev_text', $settings['wpte_product_pagination_prev_text'] ) : '';
		$next_icon = isset( $settings['wpte_product_pagination_next_icon'] ) && ! empty( $settings['wpte_product_pagination_next_icon'] ) ? $this->icon_render( 'wpte_product_pagination_next_icon', $settings['wpte_product_pagination_next_icon'] ) : '';
		$next_text = isset( $settings['wpte_product_pagination_next_text'] ) && ! empty( $settings['wpte_product_pagination_next_text'] ) ? $this->text_render( 'wpte_product_pagination_next_text', $settings['wpte_product_pagination_next_text'] ) : '';

		$prev_btn = $prev_icon . $prev_text;
		$next_btn = $next_text . $next_icon;

		?>
		<ul class="wpte-product-layout-pagination" id="wpte-pagination-<?php echo esc_attr( $layoutid ); ?>">
			<?php
			if ( intval( $current_page ) > 1 ) {
				$prev = intval($current_page) - 1;
				printf('<li data-id="%s" layoutid="%s">%s</li>', esc_attr( $prev ), intval( $layoutid ), wp_kses( $prev_btn, wpte_allow_icons_html() ) );
			}
			if ( 'preset_3' !== $preset ) {
				for ( $i = 1; $i <= $total_page; $i++ ) {
					$active = intval( $current_page ) === $i ? 'pagination-active' : '';

					if ( 'preset_1' === $preset ) {
						if ( $current_page > 4 ) {
							if ( $current_page > 1 ) {
								if ( $i <= ( $current_page + 2 ) ) {
									if ( $i === 1 ) {
										printf('<li class="%s" data-id="%s" layoutid="%s">%s</li>', esc_attr( $active ), esc_attr( $i ), esc_html( $layoutid ), intval( $i ) );
									} elseif ( $i > ( $current_page - ( $range ) ) && $i !== intval( $total_page ) ) {
										printf('<li class="%s" data-id="%s" layoutid="%s">%s</li>', esc_attr( $active ), esc_attr( $i ), esc_html( $layoutid ), intval( $i ) );
									}
								}
							}
							if ( $i === 1 ) {
								printf('<span class="wpte_pg_seperator">...</span>');
							}
						} elseif ( $current_page > 1 ) {
							if ( $i <= ( $current_page + 2 ) ) {
								printf('<li class="%s" data-id="%s" layoutid="%s">%s</li>', esc_attr( $active ), esc_attr( $i ), esc_html( $layoutid ), intval( $i ) );
							}
						} elseif ( $i <= $range ) {
								printf('<li class="%s" data-id="%s" layoutid="%s">%s</li>', esc_attr( $active ), esc_attr( $i ), esc_html( $layoutid ), intval( $i ) );
						}

						if ( $i === ( intval( $total_page ) - 1 ) && $i !== intval( $current_page - 1 ) ) {
							printf('<span class="wpte_pg_seperator">...</span>');
						}
						if ( $i === intval( $total_page ) ) {
							printf('<li class="%s" data-id="%s" layoutid="%s">%s</li>', esc_attr( $active), esc_attr( $i ), esc_html( $layoutid ), intval( $i ) );
						}
					} elseif ( 'preset_2' === $preset ) {
						printf('<li class="%s" data-id="%s" layoutid="%s">%s</li>', esc_attr( $active), esc_attr( $i ), esc_html( $layoutid ), intval( $i ) );
					}
				}
			}
			if ( intval( $total_page ) !== intval( $current_page ) ) {
				$next = intval($current_page) + 1;
				printf('<li data-id="%s" layoutid="%s">%s</li>', esc_attr( $next ), intval( $layoutid ), wp_kses( $next_btn, wpte_allow_icons_html() ) );
			}

			?>
		</ul>
		<?php
	}

	/**
	 * Method wpte_products_load_more_render
	 *
	 * @param mixed  $settings .
	 * @param number $layoutid .
	 * @return void
	 */
	public function wpte_products_load_more_render( $settings, $layoutid ) {

		$args  = $this->wpte_get_woo_products( $settings ) ?? [];
		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			$found_posts = $query->found_posts;
			$total_pages = ceil( $found_posts / absint( $args['posts_per_page'] ) );
		}

		$product_number_load = isset( $settings['wpte_product_layout_product_number_load'] ) && '' !== $settings['wpte_product_layout_product_number_load'] ? $settings['wpte_product_layout_product_number_load'] : 0;
		$_post_per_page      = isset( $settings['wpte_product_layout_product_number'] ) && '' !== $settings['wpte_product_layout_product_number'] ? $settings['wpte_product_layout_product_number'] : 4;
		$button_text         = isset( $settings['wpte_product_pagination_load_more_text'] ) && ! empty( $settings['wpte_product_pagination_load_more_text'] ) ? $this->text_render( 'wpte_product_pagination_load_more_text', $settings['wpte_product_pagination_load_more_text'] ) : '';

		if ( $product_number_load ) {
			$post_per_page = $product_number_load;
		} else {
			$post_per_page = $_post_per_page;
		}

		if ( $total_pages > 1 ) {
			printf( '<button class="wpte-product-layout-load-more-button" add-page="%1$s" post-per-page="%4$s" layoutid="%2$s">%3$s</button>', esc_attr( $post_per_page ), esc_attr( $layoutid ), wp_kses( $button_text, wpte_allow_icons_html() ), esc_attr( $_post_per_page ) );
		}
	}

}
