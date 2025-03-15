<?php
/**
 * The template for displaying product category pages
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

?>

<div class="woocommerce-category-page">
    <?php
    do_action( 'woocommerce_before_main_content' );
    ?>

    <header class="woocommerce-products-header">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>
    </header>

    <?php
    // do_action('woocommerce_before_shop_loop');
	$current_category = get_queried_object();

	if ( $current_category && ! is_wp_error( $current_category ) ) {
		$wpte_pl_settings = get_option( 'wpte_pl_settings' ) ? get_option( 'wpte_pl_settings' ) : [];

		$filter_id = isset( $wpte_pl_settings['wpte-settings-filter-select'] ) && $wpte_pl_settings['wpte-settings-filter-select'] ? $wpte_pl_settings['wpte-settings-filter-select'] : '';
		$layout_id = isset( $wpte_pl_settings['wpte-settings-category-select'] ) && $wpte_pl_settings['wpte-settings-category-select'] ? $wpte_pl_settings['wpte-settings-category-select'] : '';

		$cat_id = $current_category->term_id;

		echo "<div class='wpte-pl-cat-page-filter'>";
			echo do_shortcode( "[wpte_product_layout catid=$cat_id id=$filter_id]" );
		echo '</div>';
		echo "<div class='wpte-pl-cat-page-layout'>";
			echo do_shortcode( "[wpte_product_layout catid=$cat_id id=$layout_id]" );
		echo '</div>';
	} else {
		echo 'No category selected.';
	}

    do_action( 'woocommerce_after_main_content' );

    do_action( 'woocommerce_sidebar' );
    ?>

</div>

<?php
get_footer( 'shop' );
