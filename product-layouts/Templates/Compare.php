<?php

namespace WPTE_PRODUCT_LAYOUT\Templates;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Compare Table Class
 *
 * @since 1.0.1
 */
class Compare {

	/**
	 * Placeholder for an attribute a product does not define.
	 *
	 * @var string
	 */
	const EMPTY_VALUE = '&mdash;';

	/**
	 * Construct
	 *
	 * @param mixed $product_list .
	 * @since 1.0.1
	 */
	public function __construct( $product_list ) {

		$this->wpte_product_compare_template( $product_list );
	}

	/**
	 * Method wpte_product_compare_template
	 *
	 * @param mixed $product_list .
	 * @since 1.0.1
	 */
	public function wpte_product_compare_template( $product_list ) {

		$items = $this->wpte_get_compare_items( $product_list );

		if ( ! $items ) {
			return;
		}

		$rows = $this->wpte_get_compare_rows();
		?>
		<div class="wpte-compare-table-title">
			<h1><?php echo esc_html__( 'Compare Products', 'product-layouts' ); ?></h1>
			<?php
			/* translators: %s: number of products in the comparison table. */
			$count_singular = __( '%s product', 'product-layouts' );
			/* translators: %s: number of products in the comparison table. */
			$count_plural = __( '%s products', 'product-layouts' );
			?>
			<span class="wpte-compare-table-count"
				data-singular="<?php echo esc_attr( $count_singular ); ?>"
				data-plural="<?php echo esc_attr( $count_plural ); ?>"
				data-empty="<?php echo esc_attr__( 'No products to compare', 'product-layouts' ); ?>">
				<?php
				printf(
					esc_html( count( $items ) === 1 ? $count_singular : $count_plural ),
					esc_html( number_format_i18n( count( $items ) ) )
				);
				?>
			</span>
		</div>
		<div class="wpte-compare-table-scroll">
			<table class="wpte-compare-table">
				<tbody>
					<tr class="wpte-compare-head-row">
						<th class="wpte-compare-label hide"></th>
						<?php foreach ( $items as $item ) : ?>
							<td class="wpte-compare-product-col wpte-remove-<?php echo intval( $item['id'] ); ?>">
								<div class="wpte-th-wraper">
									<div class="wpte-compare-product-remove" product_id="<?php echo intval( $item['id'] ); ?>">
										<a title="<?php echo esc_attr__( 'Remove', 'product-layouts' ); ?>">&times;</a>
									</div>
									<div class="wpte-compare-product-img">
										<a href="<?php echo esc_url( $item['permalink'] ); ?>">
											<?php echo wp_kses_post( $item['image'] ); ?>
										</a>
									</div>
									<?php if ( $item['categories'] ) : ?>
										<div class="wpte-compare-product-cat">
											<?php echo wp_kses( $item['categories'], true ); ?>
										</div>
									<?php endif; ?>
									<div class="wpte-compare-product-title">
										<a href="<?php echo esc_url( $item['permalink'] ); ?>">
											<?php echo esc_html( $item['title'] ); ?>
										</a>
									</div>
									<div class="wpte-compare-product-rating">
										<?php echo wp_kses_post( (string) product_rating_render( $item['product'] ) ); ?>
									</div>
									<div class="wpte-compare-product-price">
										<?php echo wp_kses_post( $item['product']->get_price_html() ); ?>
									</div>
									<div class="wpte-compare-product-button">
										<?php $this->wpte_render_add_to_cart( $item ); ?>
									</div>
								</div>
							</td>
						<?php endforeach; ?>
					</tr>
					<?php
					foreach ( $rows as $row ) {
						$values = [];

						foreach ( $items as $item ) {
							$values[ $item['id'] ] = call_user_func( $row['value'], $item['product'] );
						}

						// Skip an optional row when not a single product defines it — a table
						// full of dashes reads worse than a shorter, denser table.
						if ( empty( $row['always'] ) && ! $this->wpte_has_value( $values ) ) {
							continue;
						}
						?>
						<tr>
							<th class="wpte-compare-label"><?php echo esc_html( $row['label'] ); ?></th>
							<?php foreach ( $values as $product_id => $value ) : ?>
								<td class="wpte-compare-product-col wpte-remove-<?php echo intval( $product_id ); ?>">
									<span><?php echo wp_kses_post( $value ); ?></span>
								</td>
							<?php endforeach; ?>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<div class="wpte-compare-empty" style="display:none;">
				<span class="wpte-compare-empty-icon">&#9723;</span>
				<p><?php echo esc_html__( 'No products left to compare.', 'product-layouts' ); ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Collect every comparable product once, in the order it was added.
	 *
	 * @param mixed $product_list .
	 * @return array
	 * @since 1.4.4
	 */
	protected function wpte_get_compare_items( $product_list ) {

		$ids = array_filter( array_unique( array_map( 'intval', (array) $product_list ) ) );

		if ( ! $ids ) {
			return [];
		}

		$query = new \WP_Query(
			[
				'post_type'           => 'product',
				'post__in'            => $ids,
				'orderby'             => 'post__in',
				'posts_per_page'      => count( $ids ),
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			]
		);

		$items = [];

		foreach ( $query->posts as $post_object ) {
			$product = wc_get_product( $post_object->ID );

			if ( ! $product ) {
				continue;
			}

			$items[] = [
				'id'         => $post_object->ID,
				'post'       => $post_object,
				'product'    => $product,
				'title'      => $product->get_name(),
				'permalink'  => get_permalink( $post_object->ID ),
				'image'      => $product->get_image( 'woocommerce_thumbnail', [ 'loading' => 'eager' ] ),
				'categories' => wc_get_product_category_list( $post_object->ID ),
			];
		}

		return $items;
	}

	/**
	 * The comparison rows, in display order.
	 *
	 * Rows flagged `always` are rendered even when no product defines a value.
	 *
	 * @return array
	 * @since 1.4.4
	 */
	protected function wpte_get_compare_rows() {

		return [
			[
				'label'  => __( 'Price', 'product-layouts' ),
				'always' => true,
				'value'  => function ( $product ) {
					return $product->get_price_html() ? $product->get_price_html() : self::EMPTY_VALUE;
				},
			],
			[
				'label'  => __( 'Availability', 'product-layouts' ),
				'always' => true,
				'value'  => [ $this, 'wpte_get_stock_badge' ],
			],
			[
				'label'  => __( 'Description', 'product-layouts' ),
				'always' => true,
				'value'  => function ( $product ) {
					$description = $product->get_short_description();

					return $description ? $description : self::EMPTY_VALUE;
				},
			],
			[
				'label' => __( 'SKU', 'product-layouts' ),
				'value' => function ( $product ) {
					return $product->get_sku() ? esc_html( $product->get_sku() ) : self::EMPTY_VALUE;
				},
			],
			[
				'label' => __( 'Weight', 'product-layouts' ),
				'value' => function ( $product ) {
					return $product->get_weight()
						? esc_html( wc_format_weight( $product->get_weight() ) )
						: self::EMPTY_VALUE;
				},
			],
			[
				'label' => __( 'Dimensions', 'product-layouts' ),
				'value' => function ( $product ) {
					$dimensions = wc_format_dimensions( $product->get_dimensions( false ) );

					// wc_format_dimensions() returns a localised "N/A" rather than an
					// empty string when a product has no dimensions set. Its separator is
					// the `&times;` entity, so it must not be escaped again here — the
					// value is passed through wp_kses_post() when the row is rendered.
					return $dimensions && __( 'N/A', 'woocommerce' ) !== $dimensions
						? $dimensions
						: self::EMPTY_VALUE;
				},
			],
			[
				'label' => __( 'Color', 'product-layouts' ),
				'value' => function ( $product ) {
					return $this->wpte_get_attribute_chips( $product, 'pa_color' );
				},
			],
			[
				'label' => __( 'Size', 'product-layouts' ),
				'value' => function ( $product ) {
					return $this->wpte_get_attribute_chips( $product, 'pa_size' );
				},
			],
		];
	}

	/**
	 * Stock status as a coloured badge.
	 *
	 * @param \WC_Product $product .
	 * @return string
	 * @since 1.4.4
	 */
	public function wpte_get_stock_badge( $product ) {

		$statuses = [
			'instock'     => [ 'in', __( 'In Stock', 'product-layouts' ) ],
			'outofstock'  => [ 'out', __( 'Out of Stock', 'product-layouts' ) ],
			'onbackorder' => [ 'backorder', __( 'On Back Order', 'product-layouts' ) ],
		];

		$status = $product->get_stock_status();

		if ( ! isset( $statuses[ $status ] ) ) {
			return self::EMPTY_VALUE;
		}

		return sprintf(
			'<span class="wpte-compare-badge wpte-compare-badge-%1$s">%2$s</span>',
			esc_attr( $statuses[ $status ][0] ),
			esc_html( $statuses[ $status ][1] )
		);
	}

	/**
	 * Render a product attribute as individual chips instead of a comma-joined string.
	 *
	 * @param \WC_Product $product .
	 * @param string      $taxonomy Attribute taxonomy name, e.g. `pa_color`.
	 * @return string
	 * @since 1.4.4
	 */
	protected function wpte_get_attribute_chips( $product, $taxonomy ) {

		$value = $product->get_attribute( $taxonomy );

		if ( ! $value ) {
			return self::EMPTY_VALUE;
		}

		$chips = '';

		foreach ( array_filter( array_map( 'trim', explode( ',', $value ) ) ) as $item ) {
			$chips .= sprintf( '<span class="wpte-compare-chip">%s</span>', esc_html( $item ) );
		}

		return $chips ? $chips : self::EMPTY_VALUE;
	}

	/**
	 * Does at least one product define a real value for this row?
	 *
	 * @param array $values .
	 * @return bool
	 * @since 1.4.4
	 */
	protected function wpte_has_value( $values ) {

		foreach ( $values as $value ) {
			if ( self::EMPTY_VALUE !== $value && '' !== trim( (string) $value ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Output the loop add-to-cart button for one product.
	 *
	 * WooCommerce's loop template reads the $product and $post globals, so both are
	 * set up for the current column before it runs.
	 *
	 * @param array $item .
	 * @return void
	 * @since 1.4.4
	 */
	protected function wpte_render_add_to_cart( $item ) {

		global $post, $product;

		$post    = $item['post'];
		$product = $item['product'];

		setup_postdata( $post );
		woocommerce_template_loop_add_to_cart();
		wp_reset_postdata();
	}
}
