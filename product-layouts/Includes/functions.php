<?php

/**
 * Method wpte_layout_insert.
 *
 * @param mixed $args .
 * Inser Layout to wpte_product_layout_style data table when create new.
 * @return int|WP_ERROR
 */
function wpte_layout_insert( $args = [] ) {

	global $wpdb;

	$default = [
		'name'        => '',
		'style_name'  => '',
		'rawdata'     => '',
		'stylesheet'  => '',
		'font_family' => '',

	];

	$data = wp_parse_args( $args, $default );

	$inserted = $wpdb->insert(
		"{$wpdb->prefix}wpte_product_layout_style",
		$data,
		[
			'%s',
			'%s',
			'%s',
			'',
			'%s',
		]
	);

	if ( ! $inserted ) {
		return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'wpte-product-layout' ) );
	}

	return $wpdb->insert_id;
}

/**
 * Method wpte_layout_update_style.
 * Update Style Sheet.
 *
 * @param mixed $id .
 * @param mixed $data .
 * @return void
 */
function wpte_layout_update_style( $id, $data ) {
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_layout_style SET stylesheet = %s WHERE id = %d", $data, $id ) );
}

/**
 * Method wpte_layout_update.
 * Update Raw Data.
 *
 * @param mixed $id .
 * @param mixed $data .
 * @return void
 */
function wpte_layout_update( $id, $data ) {
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_layout_style SET rawdata = %s WHERE id = %d", $data, $id ) );
}

/**
 * Method wpte_get_layout.
 * Fetch Layout Row by ID.
 *
 * @param mixed $id .
 * @return string
 */
function wpte_get_layout( $id ) {
	global $wpdb;
	return $wpdb->get_row(
		$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_product_layout_style WHERE id = %d", $id )
	);
}

/**
 * Method wpte_shortcode_name_update.
 * Update Name.
 *
 * @param mixed $id .
 * @param mixed $data .
 * @return void
 */
function wpte_shortcode_name_update( $id, $data ) {
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_layout_style SET name = %s WHERE id = %d", $data, $id ) );
}

/**
 * Method wpte_get_products_layout.
 * Fetch all product layouts from database.
 *
 * @param mixed $arg .
 * @return string
 */
function wpte_get_product_layouts( $arg = [] ) {

	global $wpdb;

	$default = [
		'number'  => 20,
		'offset'  => 0,
		'orderby' => 'id',
		'order'   => 'ASC',
	];

	$args = wp_parse_args( $arg, $default );

	$items = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}wpte_product_layout_style
			ORDER BY %s %s
			LIMIT %d, %d",
			$args['orderby'],
			$args['order'],
			$args['offset'],
			$args['number']
		)
	);

	return $items;
}

/**
 * Method wpte_product_layouts_counter.
 * get the count of total layouts shortcode.
 *
 * @return string
 */
function wpte_product_layouts_count() {
	global $wpdb;
	return $wpdb->get_var(
		"SELECT count(id) FROM {$wpdb->prefix}wpte_product_layout_style"
	);
}

/**
 * Method wpte_delete_layout
 * Delete Layout.
 *
 * @param mixed $id .
 * @return string
 */
function wpte_delete_layout( $id ) {
	global $wpdb;

	return $wpdb->delete(
		$wpdb->prefix . 'wpte_product_layout_style',
		[ 'id' => $id ]
	);
}

/**
 * Method wpte_layout_icons.
 * Icons.
 *
 * @param mixed $data .
 * @return string
 */
function wpte_layout_icons( $data ) {
	$files = '<i class="wpte-icons ' . esc_attr( $data ) . '"></i>';
	return $files;
}

/**
 * Method product_rating_render.
 *
 * @param object $product .
 * @return mixed
 */
function product_rating_render( $product ) {

	$value = $product->get_average_rating();

	$ratefull = 'icon-star';
	$ratehalf = 'icon-star-half';
	$rateO    = 'icon-star-0';

	if ( $value > 4.75 ) :
		return wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull );
	elseif ( $value <= 4.75 && $value > 4.25 ) :
		return wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratehalf );
	elseif ( $value <= 4.25 && $value > 3.75 ) :
		return wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $rateO );
	elseif ( $value <= 3.75 && $value > 3.25 ) :
		return wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratehalf ) . wpte_layout_icons( $rateO );
	elseif ( $value <= 3.25 && $value > 2.75 ) :
		return wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO );
	elseif ( $value <= 2.75 && $value > 2.25 ) :
		return wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratehalf ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO );
	elseif ( $value <= 2.25 && $value > 1.75 ) :
		return wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratefull ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO );
	elseif ( $value <= 1.75 && $value > 1.25 ) :
		return wpte_layout_icons( $ratefull ) . wpte_layout_icons( $ratehalf ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO );
	elseif ( $value <= 1.25 && $value > 0 ) :
		return wpte_layout_icons( $ratefull ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO );
	elseif ( $value < 1 ) :
		return wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO ) . wpte_layout_icons( $rateO );
	endif;
}

/**
 * Method thumbnail_sizes
 * Get Thubmnail Sizes.
 *
 * @return array size
 */
function wpte_thumbnail_sizes() {
	$default_image_sizes = get_intermediate_image_sizes();
	$thumbnail_sizes     = [];
	foreach ( $default_image_sizes as $size ) {
		$image_sizes[ $size ]     = $size . ' - ' . intval( get_option( "{$size}_size_w" ) ) . ' x ' . intval( get_option( "{$size}_size_h" ) );
		$thumbnail_sizes[ $size ] = str_replace( '_', ' ', ucfirst( $image_sizes[ $size ] ) );
	}
	return $thumbnail_sizes;
}


/**
 * Method font_familly_validation.
 *
 * @param mixed $data .
 */
function font_familly_validation( $data = [] ) {
	$wepte_pl_settings = get_option( 'wpte_pl_settings' ) ? get_option( 'wpte_google_font' ) : [];
	$google_font = isset( $wepte_pl_settings['wpte_google_font'] ) && $wepte_pl_settings['wpte_google_font'] ? $wepte_pl_settings['wpte_google_font'] : ''; 
	if ( $google_font !== 'no' && $data ) {
		foreach ( $data as $value ) {
			wp_enqueue_style( '' . esc_attr( $value ) . '', 'https://fonts.googleapis.com/css?family=' . $value . '', null, WPTE_WPL_VERSION );
		}
	}
}

/**
 * Plugin Version Controler
 */
function wpte_version_control() {
	return wpl_fs()->can_use_premium_code();
}

/*
* Support Woocommerce Frontend Scripts to Admin
*
* @since 1.0.1
*/
if ( is_admin() && defined( 'ABSPATH' ) ) {

	if ( ! admin_url( 'admin.php?page=product-layouts' ) || ! isset( $_GET['layouts'] ) || ! file_exists( ABSPATH . 'wp-content/plugins/woocommerce/includes/class-wc-frontend-scripts.php' ) ) {
		return;
	} else {
		include_once ABSPATH . 'wp-content/plugins/woocommerce/includes/class-wc-frontend-scripts.php';
		add_action( 'admin_enqueue_scripts', [ new WC_Frontend_Scripts(), 'load_scripts' ] );
		add_action( 'admin_print_scripts', [ new WC_Frontend_Scripts(), 'localize_printed_scripts' ], 5 );
		add_action( 'admin_print_footer_scripts', [ new WC_Frontend_Scripts(), 'localize_printed_scripts' ], 5 );
	}
}

/**
 * Method admin_notice_missing_plugin.
 * Warning when the site doesn't have WooCommerce installed or activated.
 *
 * @param mixed $plugin_class .
 * @param mixed $path .
 * @param mixed $notice .
 * @since 1.0.1
 * @access public
 */
function admin_notice_missing_plugin( $plugin_class, $path, $notice ) {

	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin            = $plugin_class;
	$file_path         = $path;
	$installed_plugins = get_plugins();

	

	if ( isset( $installed_plugins[ $file_path ] ) ) { // check if plugin is installed.

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$activation_url = wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=' . $file_path ), 'activate-plugin_' . $file_path );

		$message  = wp_sprintf( '<p><strong>%s</strong>%s</p>', esc_html( $notice ), esc_html__( ' not working because you need to activate the ' ) . esc_html( $notice ) . esc_html__( ' plugin.', 'wpte-product-layout' ) );
		$message .= wp_sprintf( '<p><a href="%s" class="button-primary">%s</a></p>', $activation_url, esc_html__( 'Activate ' ) . esc_html( $notice ) . esc_html__( ' Now', 'wpte-product-layout' ) );

	} else {

		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
		$install_url = wp_nonce_url(
			add_query_arg(
				[
					'action' => 'install-plugin',
					'plugin' => $plugin,
				],
				admin_url( 'update.php' )
			),
			'install-plugin_' . $plugin
		);
		$message     = wp_sprintf( '<p><strong>%s</strong>%s</p>', esc_html( $notice ), __( ' not working because you need to install the ' ) . esc_html( $notice ) . esc_html__( ' plugin', 'wpte-product-layout' ) );
		$message    .= wp_sprintf( '<p><a href="%s" class="button-primary">%s</a></p>', $install_url, esc_html__( 'Install ' ) . esc_html( $notice ) . esc_html__( ' Now', 'wpte-product-layout' ) );

	}

	printf( '<div class="error"><p>%s</p></div>', wp_kses( $message, wpte_plugins_allowedtags() ) );
}

/**
 * Method wpte_single_product_summary.
 * Get Product Description.
 *
 * @param mixed $content .
 * @param mixed $maxWords .
 * @since 1.0.2 - beta
 * @access public
 */
function wpte_single_product_summary( $content, $maxWords = 5 ) {
	$description  = wp_strip_all_tags( $content ); // Remove HTML to get the plain text.
	$words        = explode( ' ', $description );
	$trimmedWords = array_slice( $words, 0, $maxWords );
	$trimmedText  = join( ' ', $trimmedWords );

	if ( strlen( $trimmedText ) < strlen( $description ) ) {
		$trimmedText .= '...';
	}

	return $trimmedText;
}

/**
 * Method wpte_get_shortcode_list.
 * Fetch all shortcode from database to show id and name in admin select option.
 *
 * @param mixed $arg .
 * @return array shortcodes
 */
function wpte_get_shortcode_list( $arg = [] ) {

	global $wpdb;

	$a = 'general%';
	$b = 'call_to_action%';
	$c = 'product_list%';
	$d = 'caption%';
	$e = 'flipbox%';

	$items = $wpdb->get_results( $wpdb->prepare( "SELECT id, name FROM {$wpdb->prefix}wpte_product_layout_style WHERE style_name LIKE %s OR style_name LIKE %s OR style_name LIKE %s OR style_name LIKE %s OR style_name LIKE %s ORDER by id ASC", $a, $b, $c, $d, $e ), ARRAY_A );

	$shortcodes = [];
	foreach ( $items as $item ) {
		$shortcodes[ $item['id'] ] = $item['name'];
	}

	return $shortcodes;
}

/**
 * Method wpte_get_shortcode_list.
 * Fetch all shortcode from database to show id and name in admin select option.
 *
 * @param mixed $arg .
 * @return array shortcodes
 */
function wpte_get_filter_shortcode_list( $arg = [] ) {

	global $wpdb;

	$filter = 'filter%';

	$items = $wpdb->get_results( $wpdb->prepare( "SELECT id, name FROM {$wpdb->prefix}wpte_product_layout_style WHERE style_name LIKE %s ORDER by id ASC", $filter ), ARRAY_A );

	$shortcodes = [];
	foreach ( $items as $item ) {
		$shortcodes[ $item['id'] ] = $item['name'];
	}

	return $shortcodes;
}

/**
 * Method wpte_get_attribute_list.
 * Fetch all attribute from database to show id and name in admin select option.
 *
 * @return array attributes
 */
function wpte_get_attribute_list() {

	$attributes_array = [];

	// Get all product attributes
	$attributes = wc_get_attribute_taxonomies();

	// Loop through each attribute
	foreach ($attributes as $attribute) {
		$attributes_array[ $attribute->attribute_name ] = $attribute->attribute_label;
	}

	return $attributes_array;
}

/**
 * Method wpte_is_theme_exist.
 * Check is theme exist.
 *
 * @param mixed $theme_name .
 * @since 1.0.3
 * @access public
 */
function wpte_is_theme_exist( $theme_name ) {

	if ( get_option( 'template' ) === $theme_name ) {
		return true;
	}
	return false;
}

/**
 * Method wpte_allow_icons_html.
 * Allow html attr for icons.
 *
 * @since 1.0.6
 * @access public
 */
function wpte_allow_icons_html() {
	return [
		'div'  => [
			'class' => [],
		],
		'a'    => [
			'productid'          => [],
			'product_id'         => [],
			'tabindex'           => [],
			'compare_added_icon' => [],
		],
		'span' => [
			'class' => [],
			'id'    => [],
		],
		'i'    => [
			'class' => [],
		],
	];
}

/**
 * Method wpte_allow_wishlist_html.
 * Allow html attr for icons.
 *
 * @since 1.0.6
 * @access public
 */
function wpte_allow_wishlist_html() {
	return [
		'div'  => [
			'class' => [],
			'id'    => [],
		],
		'a'    => [
			'class'                          => [],
			'id'                             => [],
			'role'                           => [],
			'tabindex'                       => [],
			'aria-label'                     => [],
			'addedicon'                      => [],
			'data-tinv-wl-list'              => [],
			'data-tinv-wl-product'           => [],
			'data-tinv-wl-productvariation'  => [],
			'data-tinv-wl-productvariations' => [],
			'data-tinv-wl-action'            => [],
			'data-tinv-wl-producttype'       => [],
		],
		'span' => [
			'class' => [],
			'id'    => [],
		],
		'i'    => [
			'class' => [],
		],
	];
}

/**
 * Method wpte_allow_qunatity_input_html.
 * Allow html for quantity input field.
 *
 * @since 1.0.6
 * @access public
 */
function wpte_allow_quantity_input_html() {
	return [
		'div'   => [
			'class' => [],
		],
		'label' => [
			'class' => [],
			'for'   => [],
		],
		'input' => [
			'type'         => [],
			'id'           => [],
			'class'        => [],
			'name'         => [],
			'value'        => [],
			'title'        => [],
			'size'         => [],
			'min'          => [],
			'max'          => [],
			'step'         => [],
			'placeholder'  => [],
			'inputmode'    => [],
			'autocomplete' => [],
		],
	];
}

/**
 * Method wpte_plugins_allowedtags.
 * Allow html tag.
 *
 * @since 1.0.6
 * @access public
 */
function wpte_plugins_allowedtags() {
	return [
		'a'      => [
			'href'   => [],
			'title'  => [],
			'target' => [],
			'class'  => [],
			'id'     => [],
		],
		'nav'    => [
			'class' => [],
			'id'    => [],
		],
		'unit'   => [],
		'style'  => [],
		'code'   => [],
		'em'     => [],
		'strong' => [],
		'div'    => [
			'class' => [],
			'id'    => [],
		],
		'span'   => [
			'class' => [],
			'id'    => [],
		],
		'p'      => [
			'class' => [],
			'id'    => [],
		],
		'ul'     => [
			'class' => [],
			'id'    => [],
		],
		'li'     => [
			'class' => [],
			'id'    => [],
		],
		'i'      => [ 'class' => [] ],
		'h1'     => [],
		'h2'     => [],
		'h3'     => [],
		'h4'     => [],
		'h5'     => [],
		'img'    => [
			'src'   => [],
			'class' => [],
			'alt'   => [],
		],
	];
}

/**
 * Method wpte_plugins_allowed_input_tags.
 * Allow html tag.
 *
 * @since 1.0.6
 * @access public
 */
function wpte_plugins_allowed_input_tags() {
	return [
		'input' => [
			'name'          => [],
			'class'         => [],
			'id'            => [],
			'value'         => [],
			'responsive'    => [],
			'retundata'     => [],
			'custom'        => [],
			'type'          => [],
			'background'    => [],
			'ckdflt'        => [],
			'checked'       => [],
			'data-opacity'  => [],
			'data-format'   => [],
			'unit'          => [],
			'min'           => [],
			'max'           => [],
			'step'          => [],
			'default-value' => [],
		],
	];
}

/**
 * Method wpte_plugins_allowed_condition.
 * Allow condition.
 *
 * @since 1.0.6
 * @access public
 */
function wpte_plugins_allowed_condition() {
	return [
		'input' => [
			'name'         => [],
			'class'        => [],
			'id'           => [],
			'value'        => [],
			'responsive'   => [],
			'retundata'    => [],
			'custom'       => [],
			'type'         => [],
			'background'   => [],
			'ckdflt'       => [],
			'checked'      => [],
			'data-opacity' => [],
			'data-format'  => [],
		],
	];
}

/**
 * Name Converter
 *
 * @param string $data .
 * @since 1.0.6
 */
function name_converter( $data ) {
	$data = str_replace( '_', ' ', $data );
	$data = str_replace( '-', ' ', $data );
	$data = str_replace( '+', ' ', $data );
	$data = ucwords( $data );
	switch ( $data ) {
		case 'General Layouts':
			$_data = __( 'General Layouts', 'wpte-product-layout' );
			break;
		case 'Call To Action Layouts':
			$_data = __( 'Call To Action Layouts', 'wpte-product-layout' );
			break;
		case 'Product Table Layouts':
			$_data = __( 'Product Table Layouts', 'wpte-product-layout' );
			break;
		case 'Product List Layouts':
			$_data = __( 'Product List Layouts', 'wpte-product-layout' );
			break;
		case 'Caption Layouts':
			$_data = __( 'Caption Layouts', 'wpte-product-layout' );
			break;
		case 'Flipbox Layouts':
			$_data = __( 'Flipbox Layouts', 'wpte-product-layout' );
			break;
		case 'Filter & Sorting':
			$_data = __( 'Filter & Sorting', 'wpte-product-layout' );
			break;
		case 'Product Tabs':
			$_data = __( 'Product Tabs', 'wpte-product-layout' );
			break;
		case 'Carousel':
			$_data = __( 'Carousel', 'wpte-product-layout' );
			break;
		case 'Accordion':
			$_data = __( 'Accordion', 'wpte-product-layout' );
			break;
		case 'Product Layout':
			$_data = __( 'Product Layouts', 'wpte-product-layout' );
			break;
		case 'Shortcode List':
			$_data = __( 'Shortcode List', 'wpte-product-layout' );
			break;
		case 'General':
			$_data = __( 'General', 'wpte-product-layout' );
			break;
		case 'Call To Action':
			$_data = __( 'Call To Action', 'wpte-product-layout' );
			break;
		case 'Table':
			$_data = __( 'Product Table', 'wpte-product-layout' );
			break;
		case 'Product List':
			$_data = __( 'Product List', 'wpte-product-layout' );
			break;
		case 'Caption':
			$_data = __( 'Caption', 'wpte-product-layout' );
			break;
		case 'Flipbox':
			$_data = __( 'Flipbox', 'wpte-product-layout' );
			break;
		case 'Tabs':
			$_data = __( 'Product Tabs', 'wpte-product-layout' );
			break;
		case 'Filter':
			$_data = __( 'Filter & Sorting', 'wpte-product-layout' );
			break;
	}
	return $_data;
}

/**
 * Wpte_offer_popup.
 *
 * @since 1.1.4
 */
function wpte_offer_popup() {
	global $pagenow;

	if ( is_admin() && $pagenow === 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] === 'product-layouts' ) {
		echo '<div id="wpte-offer-modal"></div>';
	}
}
add_action( 'admin_print_footer_scripts', 'wpte_offer_popup' );

/**
 * Wpte_product_title_tags.
 *
 * @since 1.1.6
 */
function wpte_product_title_tags() {
	return [
		'h1' => 'h1',
		'h2' => 'h2',
		'h3' => 'h3',
		'h4' => 'h4',
		'h5' => 'h5',
		'h6' => 'h6',
	];
}

/**
 * wpte_get_upgrade_popup_data.
 *
 * @since 1.1.7
 */
function wpte_get_upgrade_popup_data() {
    // Get the current date
    $current_date = date('Y-m-d');

    // Define the Halloween period
    $halloween_start = '2024-10-25';
    $halloween_end   = '2024-11-05';

	$blackfirday_start = '2024-11-21';
	$blackfirday_end   = '2024-12-05';

    if ( $current_date >= $halloween_start && $current_date <= $halloween_end ) {
        return [
            '🎃 Halloween Special Orders 🎃',
            '<span class="wpte-upto">UPTO</span>30% OFF',
            'Upgrade now to enjoy eerie savings on exclusive Halloween items!',
            'Upgrade Now',
            'https://product-layouts.com/pricing/',
            'halloween.png'
        ];
    } elseif ( $current_date >= $blackfirday_start && $current_date <= $blackfirday_end ) {
		return [
            '🔥 Black Friday Mega Sale 🔥',
            '<span class="wpte-upto">UPTO</span>80% OFF',
            'Hurry! Grab this once-a-year deal on our Pro features!',
            'Upgrade Now',
            'https://product-layouts.com/pricing/',
            'blackfriday.png'
        ];
	} {
        return [
            'Unlock PRO Features',
            '<span class="wpte-upto">UPTO</span>25% OFF',
            'Upgrade to the Pro version to enable Pro features.',
            'Upgrade Now',
            'https://product-layouts.com/pricing/',
            'wpte-offer.png'
        ];
    }
}

/**
 * wpte_get_category_ids.
 *
 * @since 1.2.0
 */
function wpte_get_category_ids() {
	$Categories = get_terms( [ 'taxonomy' => 'product_cat' ] );

	$ids = [];
	foreach ( $Categories as $category ) {
		$ids[] = $category->term_id;
	}

	return $ids;
}

/**
 * wpte_get_product_price.
 *
 * @param mixed $product
 * @since 1.2.3
 */
function wpte_get_product_price( $product ) {
	$regular_price = $product->get_regular_price();
	$sale_price    = $product->get_sale_price();

	if ( $product->is_type('variable') || $product->is_type('grouped') ) {
		return $product->get_price_html();
	} elseif ( $sale_price ) {
		return "<del>" . wc_price( $regular_price ) . "</del> " . wc_price( $sale_price ) . "";
	} else {
		return wc_price( $regular_price );
	}
}
