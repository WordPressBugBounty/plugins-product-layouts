<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Helper;

use WPTE_PRODUCT_LAYOUT\Includes\Controls;

trait Helper {
	/**
	 * WC Product Layout Tabs Header.
	 *
	 * @param int   $id .
	 * @param array $arg .
	 *
	 * @return void
	 */
	public function wpte_settings_tabs_header( $id, $arg = [] ) {

		$product_layouts_page = isset( $_GET['layouts'] ) && 'filter' !== $_GET['layouts'] ? true : false;
		if ( $product_layouts_page ) {
			$arg['options']['advanced'] = __( 'Advanced', 'wpte-product-layout' );
		}
		echo '<ul class="wpte-start-tabs-header">   ';
		foreach ( $arg['options'] as $key => $value ) {
			printf( '<li ref="#wpte-start-tabs-%s">%s</li>', esc_attr( $key ), esc_html( $value ) );
		}
		echo '</ul>';
	}

	/**
	 * Method forms_condition.
	 *
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function forms_condition( $arg = [] ) {

		if ( array_key_exists( 'condition', $arg ) ) :
			$i = $arg['condition'] !== '' ? count($arg['condition']) : 0;
			$data = '';
			$s    = 1;

			$form_condition = array_key_exists('form_condition', $arg) ? $arg['form_condition'] : '';
			$notcondition   = array_key_exists('notcondition', $arg) ? $arg['notcondition'] : false;

			foreach ( $arg['condition'] !== '' ? $arg['condition'] : [] as $key => $value ) {
				if ( is_array($value) ) :
					$c = count($value);
					$crow = 1;
					if ( $c > 1 && $i > 1 ) :
						$data .= '(';
					endif;
					foreach ( $value as $item ) {
						$data .= $form_condition . $key . ' === \'' . $item . '\'';
						if ( $crow < $c ) :
							$data .= ' || ';
							$crow++;
						endif;
					}
					if ( $c > 1 && $i > 1 ) :
						$data .= ')';
					endif;
				elseif ( $value === 'COMPILED' ) :
					$data .= $form_condition . $key;
				elseif ( $value === 'EMPTY' ) :
					$data .= $form_condition . $key . ' !== \'\'';
				elseif ( empty( $value ) ) :
					$data .= $form_condition . $key;
				elseif ( $notcondition ) :
					$data .= $form_condition . $key . ' !== \'' . $value . '\'';
				else :
					$data .= $form_condition . $key . ' === \'' . $value . '\'';
				endif;
				if ( $s < $i ) :
					$data .= ' && ';
					$s++;
				endif;
			}

			if ( ! empty( $data ) ) :
				return 'data-condition="' . esc_attr( $data ) . '"';
			endif;

		endif;
	}

	/**
	 * WC Product Layout Style Admin Panel Body
	 *
	 * @param int   $id .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function start_section_tabs( $id, array $arg = [] ) {
		$padding = array_key_exists( 'padding', $arg ) ? 'style="padding: ' . $arg['padding'] : '';
		echo '<div class="wpte-layout-content-tabs" id="wpte-start-tabs-';
		if ( array_key_exists( 'condition', $arg ) ) :
			foreach ( $arg['condition'] as $value ) {
				echo esc_html($value);
			}
		endif;
		printf( '"%s>', esc_html($padding) );
	}

	/**
	 * Method end_section_tabs.
	 *
	 * @since 1.0.0
	 */
	public function end_section_tabs() {
		echo '</div>';
	}

	/**
	 * Method start_controls_section.
	 *
	 * @param int   $id .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function start_controls_section( $id, array $arg = [] ) {
		$defualt   = [
			'showing' => false,
			'is_pro'  => '',
		];
		$arg       = array_merge( $defualt, $arg );
		$showing   = ( $arg['showing'] ) ? '' : 'wpte-ac-admin-section-d-none';
		$condition = $this->forms_condition($arg);

		$is_pro      = '';
		$is_po_class = '';
		if ( 'yes' === $arg['is_pro'] ) {
			if ( wpte_version_control() ) {
				$is_pro      = '';
				$is_po_class = '';
			} else {
				$is_pro      = __( 'Pro', 'wpte-product-layout' );
				$is_po_class = 'wpte-po-element';
			}
		}

		printf( '<div class="wpte-ac-admin-section-area %1$s" %3$s>
			<div class="wpte-ac-admin-section-head %5$s">
			<span class="dashicons dashicons-arrow-right"></span>
			%2$s 
			<b style="color:red">%4$s</b>
			</div>',
			esc_attr( $showing ),
			esc_html( $arg['label'] ),
			wp_kses( (string) $condition, wpte_plugins_allowed_condition() ),
			esc_html( $is_pro ),
			esc_attr( $is_po_class )
		);

		printf( '<div id="wpte-%s" class="wpte-ac-admin-section-body">', esc_attr( $id ) );
	}

	/**
	 * Method end_controls_section.
	 *
	 * @since 1.0.0
	 */
	public function end_controls_section() {
		echo '</div></div>';
	}

	/**
	 * Method start_controls_tabs.
	 *
	 * @param int   $id .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function start_controls_tabs( $id, array $arg = [] ) {
		$defualt   = [
			'options' => [
				'normal' => 'Normal',
				'hover'  => 'Hover',
			],
		];
		$arg       = array_merge($defualt, $arg);
		$condition = $this->forms_condition($arg);
		?>

		<div class="wpte-product-control-type-tabs" <?php echo wp_kses( (string) $condition, wpte_plugins_allowed_condition() ); ?> >
			<div class=" wpte-product-form-control wpte-product-form-control-content wpte-product-form-control-content-tabs">
				<div class="wpte-product-form-control-field">
					<?php
					foreach ( $arg['options'] as $value ) {

						?>
						<div class="wpte-product-type-control-tab-child">
							<div class="wpte-product-control-content">
								<?php echo esc_html($value); ?>
							</div>
						</div>
						<?php

					}
					?>
				</div>
			</div>
			<div class="wpte-product-form-control-content">
		<?php
	}

	/**
	 * Method end_controls_tabs.
	 *
	 * @since 1.0.0
	 */
	public function end_controls_tabs() {
		echo ' </div> </div>';
	}

	/**
	 * Method start_controls_tab.
	 *
	 * @since 1.0.0
	 */
	public function start_controls_tab() {
		echo '<div class="wpte-product-form-control-content wpte-product-form-control-content-tabs wpte-product-form-control-tabs-close">';
	}

	/**
	 * Method end_controls_tab.
	 *
	 * @since 1.0.0
	 */
	public function end_controls_tab() {
		echo '</div>';
	}

	/**
	 * Method start_controls_accordions.
	 *
	 * @param int   $id .
	 * @param array $arg .
	 * @since 1.1.2
	 */
	public function start_controls_accordions( $id, array $arg = [] ) {
		$condition = $this->forms_condition($arg);
		printf('<div class="wpte-product-control-type-accordions" %s>', wp_kses( (string) $condition, wpte_plugins_allowed_condition() ) );
	}

	/**
	 * Method end_controls_accordions.
	 *
	 * @since 1.1.2
	 */
	public function end_controls_accordions() {
		echo ' </div>';
	}

	/**
	 * Method start_controls_accordion.
	 *
	 * @param int   $id .
	 * @param array $arg .
	 * @since 1.1.2
	 */
	public function start_controls_accordion( $id, array $arg = [] ) {
		$defualt = [
			'title'  => __( 'Sort', 'wpte-product-layout' ),
			'is_pro' => '',
		];
		$arg     = array_merge($defualt, $arg);

		$is_pro      = '';
		$is_po_class = '';
		if ( 'yes' === $arg['is_pro'] ) {
			if ( wpte_version_control() ) {
				$is_pro      = '';
				$is_po_class = '';
			} else {
				$is_pro      = __( 'Pro', 'wpte-product-layout' );
				$is_po_class = 'wpte-po-element';
			}
		}

		?>
			<div class="wpte-product-control-content">
				<div class="wpte-product-control-accordion-title <?php echo esc_attr( $is_po_class ); ?>" >
					<span class="dashicons dashicons-arrow-right"></span>
					<?php echo esc_html( $arg['title'] ); ?>
					<b style="color:red"><?php echo esc_html( $is_pro ); ?></b>
				</div>
				<div class="wpte-product-control-accordion-body">
		<?php
	}

	/**
	 * Method end_controls_accordion.
	 *
	 * @since 1.1.2
	 */
	public function end_controls_accordion() {
		echo '</div></div>';
	}

	/**
	 * Method start_popover_control.
	 *
	 * @param int   $id .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function start_popover_control( $id, array $arg = [] ) {

		$condition = $this->forms_condition( $arg );
		$css       = array_key_exists( 'css', $arg ) && isset( $arg['css'] ) ? $arg['css'] : '';
		$separator = ( array_key_exists( 'separator', $arg ) ? ( $arg['separator'] === false ? 'wpte-product-form-control-separator-before' : '' ) : '' );

		echo '  <div class="wpte-product-form-control wpte-product-control-type-popover ' . esc_attr($separator) . '" style="' . esc_attr( $css ) . '" ' . wp_kses( (string) $condition, wpte_plugins_allowed_condition() ) . '>
					<div class="wpte-product-form-control-content wpte-product-form-control-content-popover">
						<div class="wpte-product-form-control-field-popover">
							<label class="wpte-product-form-control-title-popover">' . esc_html($arg['label']) . '</label>  
							<div class="wpte-product-popover-set">
								<span class="dashicons popover-set"></span>
							</div>
						</div>
						' . ( array_key_exists( 'description', $arg ) ? '<div class="wpte-product-form-control-description">' . esc_html( $arg['description'] ) . '</div>' : '' ) . '
						
					</div>
					<div class="wpte-product-form-control-content-popover-body">	
			   ';
	}

	/**
	 * Method end_popover_control.
	 *
	 * @since 1.0.0
	 */
	public function end_popover_control() {
		echo '</div></div>';
	}

	/**
	 * Method add_extra_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function add_extra_control( $id, $data = [], $arg = [] ) {
		$func = $arg['type'] . '_extra_control';
		$this->$func( $id, $data, $arg );
	}

	/**
	 * Method add_responsive_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function add_responsive_control( $id, $data = [], $arg = [] ) {
		$lap    = $id . '-lap';
		$tab    = $id . '-tab';
		$mob    = $id . '-mob';
		$laparg = [ 'responsive' => 'laptop' ];
		$tabarg = [ 'responsive' => 'tab' ];
		$mobarg = [ 'responsive' => 'mobile' ];
		$this->add_control( $lap, $data, array_merge( $arg, $laparg ) );
		$this->add_control( $tab, $data, array_merge( $arg, $tabarg ) );
		$this->add_control( $mob, $data, array_merge( $arg, $mobarg ) );
	}

	/**
	 * Method add_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function add_control( $id, $data = [], $arg = [] ) {

		$responsive      = '';
		$responsiveclass = '';

		$is_pro      = '';
		$is_po_class = '';
		if ( array_key_exists( 'is_pro', $arg ) && 'yes' === $arg['is_pro'] ) {
			if ( wpte_version_control() ) {
				$is_pro      = '';
				$is_po_class = '';
			} else {
				$is_pro      = __( 'Pro', 'wpte-product-layout' );
				$is_po_class = 'wpte-po-element';
			}
		}

		if ( array_key_exists( 'responsive', $arg ) ) :
			if ( $arg['responsive'] === 'laptop' ) :
				$responsiveclass = 'wpte-product-form-responsive-laptop';
			elseif ( $arg['responsive'] === 'tab' ) :
				$responsiveclass = 'wpte-product-form-responsive-tab';
			elseif ( $arg['responsive'] === 'mobile' ) :
				$responsiveclass = 'wpte-product-form-responsive-mobile';
			endif;
			$responsive = '<div class="wpte-form-control-responsive-switchers">
											<a class="wpte-form-responsive-switcher wpte-form-responsive-switcher-desktop" data-device="desktop">
												<span class="dashicons dashicons-desktop"></span>
											</a>
											<a class="wpte-form-responsive-switcher wpte-form-responsive-switcher-tablet" data-device="tablet">
												<span class="dashicons dashicons-tablet"></span>
											</a>
											<a class="wpte-form-responsive-switcher wpte-form-responsive-switcher-mobile" data-device="mobile">
												<span class="dashicons dashicons-smartphone"></span>
											</a>
										</div>';

		endif;

		/*
		 * Data Currection while Its comes from group Control
		 */
		if ( array_key_exists( 'selector-value', $arg ) ) :
			foreach ( $arg['selector'] as $key => $value ) {
				$arg['selector'][ $key ] = $arg['selector-value'];
			}
		endif;

		$defualt = [
			'type'          => 'text',
			'label'         => 'Input Text',
			'default'       => '',
			'label_on'      => __( 'Yes', 'wpte-product-layout' ),
			'label_off'     => __( 'No', 'wpte-product-layout' ),
			'placeholder'   => '',
			'selector-data' => true,
			'render'        => true,
			'responsive'    => 'laptop',
		];

		$arg       = array_merge( $defualt, $arg );
		$condition = $this->forms_condition($arg);

		$beforeSeparator = array_key_exists('separator', $arg) && $arg['separator'] === 'before' ? 'wpte_product_layout_before_separator' : '';
		$css             = array_key_exists('css', $arg) && isset($arg['css']) ? $arg['css'] : '';

		printf(
			'
			<div class="wpte-product-form-control wpte-product-control-type-%1$s %5$s %7$s" %6$s>
			<div class="wpte-product-form-control-content %10$s" id="wpte-%2$s" style="%8$s">
			<div class="wpte-product-from-lable"><label class="wpte-product-form-control-title">%3$s</label>%4$s <b style="color:red;margin-left:3px"> %9$s</b></div>
			',
			esc_attr( $arg['type'] ),
			esc_attr( $id ),
			esc_html( $arg['label'] ),
			wp_kses( (string) $responsive, wpte_plugins_allowedtags() ),
			esc_attr( $responsiveclass ),
			wp_kses( (string) $condition, wpte_plugins_allowed_condition() ),
			esc_attr( $beforeSeparator ),
			esc_attr( $css ),
			esc_html( $is_pro ),
			esc_attr( $is_po_class )
		);

		$func = $arg['type'] . '_admin_control';
		$this->$func( $id, $data, $arg );

		printf( array_key_exists( 'description', $arg ) ? '<div class="wpte-product-form-control-description">' . esc_html($arg['description']) . '</div>' : '' );
		printf( '</div></div> ' );

		if ( array_key_exists( 'separator', $arg ) && $arg['separator'] === 'after' ) {
			printf("<div class='wpte_product_layout_after_separator' " . wp_kses( (string) $condition, wpte_plugins_allowed_condition() ) . '></div>' );
		}
	}

	/**
	 * Method add_group_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function add_group_control( $id, array $data = [], array $arg = [] ) {
		$defualt = [
			'type'              => 'text',
			'label'             => 'Input Text',
			'css'               => '',
			'description'       => '',
			'simpledescription' => '',
		];
		if ( $arg['type'] !== 'cart' ) {
			$arg  = array_merge( $defualt, $arg );
			$func = $arg['type'] . '_admin_group_control';
			print_r( $this->$func( $id, $data, $arg ) );
		} else {
			$func = $arg['type'] . '_cart_control';
			$this->$func($data, $arg);
		}
	}

	/**
	 * Method heading_extra_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function heading_extra_control( $id, $data = [], $arg = [] ) {
		$label           = isset($arg['label']) ? $arg['label'] : '';
		$description     = isset($arg['description']) ? $arg['description'] : '';
		$css             = isset($arg['css']) ? $arg['css'] : 'padding-top:10px; padding-bottom:10px';
		$beforeSeparator = array_key_exists('separator', $arg) && $arg['separator'] === 'before' ? 'wpte_product_layout_before_separator' : '';
		$condition       = $this->forms_condition($arg);
		?>
			<div class="wpte-product-layout-heading <?php echo esc_attr($beforeSeparator); ?>" style="<?php echo esc_attr( $css ); ?>" <?php echo wp_kses( (string) $condition, wpte_plugins_allowed_condition() ); ?> >
				<strong><?php echo esc_html($label); ?></strong>
				<p><?php echo esc_html($description); ?></p>
			</div>
		<?php
	}

	/**
	 * Method multiple_selector_handler.
	 *
	 * @param array $data .
	 * @param array $val .
	 * @since 1.0.0
	 */
	public function multiple_selector_handler( $data = [], $val = [] ) {

		$val = preg_replace_callback( '/\{\{\K(.*?)(?=}})/', function ( $match ) use ( $data ) {
			$ER = explode( '.', $match[0] );
			if ( strpos( $match[0], 'SIZE' ) !== false ) :
				$size     = array_key_exists( $ER[0] . '-size', $data ) ? $data[ $ER[0] . '-size' ] : '';
				$match[0] = str_replace( '.SIZE', $size, $match[0] );
			endif;
			if ( strpos( $match[0], 'UNIT' ) !== false ) :
				$size     = array_key_exists( $ER[0] . '-choices', $data ) ? $data[ $ER[0] . '-choices' ] : '';
				$match[0] = str_replace( '.UNIT', $size, $match[0] );
			endif;
			if ( strpos( $match[0], 'VALUE' ) !== false ) :
				$size     = array_key_exists( $ER[0], $data ) ? $data[ $ER[0] ] : '';
				$match[0] = str_replace( '.VALUE', $size, $match[0] );
			endif;
			return str_replace( $ER[0], '', $match[0] );
		}, $val );
		return str_replace( '{{', '', str_replace( '}}', '', $val ) );
	}

	/**
	 * Method heading_extra_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.1.2
	 */
	public function hidden_extra_control( $id, $data = [], $arg = [] ) {
		$value = isset($arg['value']) ? $arg['value'] : '';
		?>
			<div class="wpte-product-layout-hidden">
				<input type="hidden" name="<?php echo esc_attr( $id ) . '_po'; ?>" value="<?php echo esc_attr( $value ); ?>" >
			</div>
		<?php
	}

	/**
	 * Method separator_extra_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function separator_extra_control( $id, $data = [], $arg = [] ) {

		$css = isset($arg['css']) ? $arg['css'] : 'margin-top:10px; margin-bottom:10px';
		?>
			<div class="wpte-product-layout-separator" style="<?php echo esc_attr( $css ); ?>"></div>
		<?php
	}

	/**
	 * Method parent_categories_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function parent_categories_admin_control( $id, $data = [], $arg = [] ) {

		$saved_cat = isset( $data[ $id ] ) ? $data[ $id ] : [];
		$Categories = get_terms( 
			[ 
				'taxonomy' => 'product_cat',
				'parent' => 0
			] 
		);
		?>
		<select class="wpte-product-category-list" name="<?php echo esc_attr($id); ?>[]" id="wpte-product-<?php echo esc_attr($id); ?>" multiple="multiple">
			<?php
			foreach ( $Categories as $category ) {
				$selected = in_array( $category->term_id, $saved_cat ) ? 'selected' : '';
				printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $category->term_id ), esc_attr($selected), esc_html( ucfirst( $category->name ) ) );
			}
			?>
		</select>
		<?php
	}

	/**
	 * Method categories_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function categories_admin_control( $id, $data = [], $arg = [] ) {

		$saved_cat = isset( $data[ $id ] ) ? $data[ $id ] : [];
		$Categories = get_terms( [ 'taxonomy' => 'product_cat' ] );
		?>
		<select class="wpte-product-category-list" name="<?php echo esc_attr($id); ?>[]" id="wpte-product-<?php echo esc_attr($id); ?>" multiple="multiple">
			<?php
			foreach ( $Categories as $category ) {
				$selected = in_array( $category->term_id, $saved_cat ) ? 'selected' : '';
				printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $category->term_id ), esc_attr($selected), esc_html( ucfirst( $category->name ) ) );
			}
			?>
		</select>
		<?php
	}

	/**
	 * Method parent_categories_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function sub_categories_admin_control( $id, $data = [], $arg = [] ) {

		$saved_cat = isset( $data[ $id ] ) ? $data[ $id ] : [];

		$Categories = get_terms(
			[
				'taxonomy'   => 'product_cat',
				'parent'     => 0,  // Only top-level categories
				'hide_empty' => false,  // Set to true if you want to exclude empty categories
			]
		);

		?>
		<select class="wpte-product-category-list" name="<?php echo esc_attr($id); ?>[]" id="wpte-product-<?php echo esc_attr($id); ?>" multiple="multiple">
			<?php
			foreach ( $Categories as $category ) {
				$subcategories = get_terms([
					'taxonomy' => 'product_cat',
					'parent'   => $category->term_id,
				]);
				foreach ( $subcategories as $subcategory ) {
					$selected = in_array( $subcategory->term_id, $saved_cat ) ? 'selected' : '';
					printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $subcategory->term_id ), esc_attr($selected), esc_html( ucfirst( $subcategory->name ) ) );
				}
			}
			?>
		</select>
		<?php
	}

	/**
	 * Method producttype_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function producttype_admin_control( $id, $data = [], $arg = [] ) {

		$saved_cat = isset( $data[ $id ] ) ? $data[ $id ] : [];
		$Categories = get_terms( [ 'taxonomy' => 'product_type' ] );
		?>
		<select class="wpte-product-category-list" name="<?php echo esc_attr($id); ?>[]" id="wpte-product-<?php echo esc_attr($id); ?>" multiple="multiple">
			<?php
			foreach ( $Categories as $category ) {
				$selected = in_array( $category->term_id, $saved_cat ) ? 'selected' : '';
				printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $category->term_id ), esc_attr($selected), esc_html( ucfirst( $category->name ) ) );
			}
			?>
		</select>
		<?php
	}

	/**
	 * Method slider_admin_control.
	 *
	 * @param int   $id .
	 * @param array $styleData .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function slider_admin_control( $id, $styleData = [], $arg = [] ) {

		$unit       = array_key_exists( $id . '-choices', $styleData ) ? $styleData[ $id . '-choices' ] : $arg['default']['unit'];
		$size       = array_key_exists( $id . '-size', $styleData ) ? $styleData[ $id . '-size' ] : $arg['default']['size'];
		$retunvalue = array_key_exists( 'selector', $arg ) ? wp_json_encode( $arg['selector'] ) : '';

		if ( array_key_exists( 'selector-data', $arg ) && $arg['selector-data'] === true && $arg['render'] === true ) :
			if ( array_key_exists( 'selector', $arg ) ) :
				foreach ( $arg['selector'] as $key => $val ) {
					if ( $size !== '' && $val !== '' ) :
						$key   = ( strpos( $key, '{{KEY}}' ) ? str_replace( '{{KEY}}', explode( 'saarsa', "$id" )[1], $key ) : $key );
						$class = str_replace( '{{WRAPPER}}', $this->CSSWRAPPER, $key );
						$file  = str_replace( '{{SIZE}}', $size, $val );
						$file  = str_replace( '{{UNIT}}', $unit, $file );

						if ( strpos( $file, '{{' ) !== false ) :
							$file = $this->multiple_selector_handler( $styleData, $file );

						endif;
						if ( ! empty( $size ) ) :
							$this->CSSDATA[ $arg['responsive'] ][ $class ][ $file ] = $file;
						endif;
					endif;
				}
			endif;
		endif;

		if ( array_key_exists( 'range', $arg ) ) :
			if ( count( $arg['range'] ) > 1 ) :
				echo ' <div class="wpte-product-form-units-choices">';
				foreach ( $arg['range'] as $key => $val ) {
					$rand    = wp_rand( 10000, 233333333 );
					$checked = $key === $unit ? 'checked' : '';
					printf(
						'<input id="%1$s-choices-%2$s" type="radio" name="%1$s-choices"  value="%3$s" %4$s  min="%5$s" max="%6$s" step="%7$s">
											<label class="wpte-product-form-units-choices-label" for="%1$s-choices-%2$s">%3$s</label>',
						esc_attr( $id ),
						esc_attr( $rand ),
						esc_html($key),
						esc_attr($checked),
						esc_attr( $val['min'] ),
						esc_attr( $val['max'] ),
						esc_attr( $val['step'] )
					);
				}
				echo '</div>';
			endif;
		endif;

		$unitvalue = array_key_exists( $id . '-choices', $styleData ) ? 'unit="' . $styleData[ $id . '-choices' ] . '"' : '';
		$custom    = array_key_exists( 'custom', $arg ) ? $arg['custom'] : '';

		printf(
			' <div class="wpte-product-form-control-input-wrapper">
					<div class="wpte-product-form-slider" id="%1$s-slider' . '"></div>
					<div class="wpte-product-form-slider-input">
						<input name="%1$s-size" custom="%2$s" id="%1$s-size' . '" type="number" min="%3$s" max="%4$s" step="%5$s" value="%6$s" default-value="%6$s" %7$s responsive="%8$s" retundata="%9$s">
					</div>
				</div>',
			esc_attr( $id ),
			esc_attr( $custom ),
			esc_attr( $arg['range'][ $unit ]['min'] ),
			esc_attr( $arg['range'][ $unit ]['max'] ),
			esc_attr( $arg['range'][ $unit ]['step'] ),
			esc_attr( $size ),
			wp_kses( (string) $unitvalue, wpte_plugins_allowed_input_tags() ),
			esc_attr( $arg['responsive'] ),
			esc_attr( $retunvalue )
		);
	}

	/**
	 * Method product_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function product_admin_control( $id, $data = [], $arg = [] ) {

		$args = [
			'post_type'      => 'product',
			'post_status'    => [ 'publish', 'pending', 'future' ],
			'posts_per_page' => -1,
		];

		$products = new \WP_Query( $args );
		$saved_cat = isset( $data[ $id ] ) ? $data[ $id ] : [];
		?>
		<select class="wpte-product-category-list" name="<?php echo esc_attr($id); ?>[]" id="wpte-product-<?php echo esc_attr($id); ?>" multiple="multiple">
			<?php
			if ( $products->have_posts() ) {
				while ( $products->have_posts() ) {
					$products->the_post();
					$selected = in_array( get_the_ID(), $saved_cat ) ? 'selected' : '';
					printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( get_the_ID() ), esc_attr($selected), esc_html( ucfirst( get_the_title() ) ) );
				}
				wp_reset_postdata();
			}
			?>
		</select>
		<?php
	}

	/**
	 * Method cart_cart_control.
	 *
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function cart_cart_control( $data = [], $arg = [] ) {
		$operator = array_key_exists('operator', $arg) ? $arg['operator'] : '';

		$this->add_extra_control(
			'wpte_product_layout_cart_icon_heading',
			$this->style,
			[
				'label' => 'Cart',
				'type'  => Controls::HEADING,
				'css'   => 'padding-top:10px; padding-bottom:10px',
			]
		);

		$this->add_control(
			'wpte_product_layout_cart_icon_switcher',
			$this->style,
			[
				'label'        => __( 'Show Cart', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'return_value' => 'yes',
				'description'  => '',
			]
		);

		if ( $operator === 'icon' || $operator === 'icontext' ) {

			$this->add_control(
				'wpte-product-cart-icon',
				$data,
				[
					'label'       => __('Cart Icon', 'wpte-product-layout'),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-cart-2',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-added-cart-icon',
				$data,
				[
					'label'       => __('Added Cart Icon', 'wpte-product-layout'),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-cart-3',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-grouped-icon',
				$data,
				[
					'label'       => __('Grouped Icon', 'wpte-product-layout'),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-setting-5',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-external-icon',
				$data,
				[
					'label'       => __('External Icon', 'wpte-product-layout'),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-external',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-variable-icon',
				$data,
				[
					'label'       => __('Variable Icon', 'wpte-product-layout'),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-ok-5',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		}
		if ( $operator === 'icon' ) {
			$this->add_extra_control(
				'wpte_product_layout_cart_tooltip_heading',
				$this->style,
				[
					'label'     => 'Tooltip',
					'type'      => Controls::HEADING,
					'css'       => 'margin-top:5px; padding-top:10px; padding-bottom:10px',
					'condition' => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'separator' => 'before',
				]
			);

			$this->add_control(
				'wpte_product_layout_cart_icon_tooltip_switcher',
				$this->style,
				[
					'label'        => __( 'Show Tooltip', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'yes',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'return_value' => 'yes',
					'condition'    => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description'  => '',
				]
			);

			$this->add_control(
				'wpte-product-cart-tooltip',
				$data,
				[
					'label'       => __('Cart Tooltip', 'wpte-product-layout'),
					'type'        => Controls::TOOLTIP,
					'default'     => __('Add to Cart', 'wpte-product-layout'),
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
						'wpte_product_layout_cart_icon_tooltip_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-grouped-tooltip',
				$data,
				[
					'label'       => __('Grouped Tooltip', 'wpte-product-layout'),
					'type'        => Controls::TOOLTIP,
					'default'     => 'Grouped',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
						'wpte_product_layout_cart_icon_tooltip_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-external-tooltip',
				$data,
				[
					'label'       => __('External Tooltip', 'wpte-product-layout'),
					'type'        => Controls::TOOLTIP,
					'default'     => 'External',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
						'wpte_product_layout_cart_icon_tooltip_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-variable-tooltip',
				$data,
				[
					'label'       => __('Variable Tooltip', 'wpte-product-layout'),
					'type'        => Controls::TOOLTIP,
					'default'     => 'Variable',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
						'wpte_product_layout_cart_icon_tooltip_switcher' => 'yes',
					],
					'css'         => 'margin-bottom:10px',
					'description' => '',
				]
			);
		}

		if ( $operator === 'text' || $operator === 'icontext' ) {

			$this->add_control(
				'wpte-product-cart-text',
				$data,
				[
					'label'       => __('Cart Text', 'wpte-product-layout'),
					'type'        => Controls::TEXT,
					'default'     => __('Add to Cart', 'wpte-product-layout'),
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-cart-view',
				$data,
				[
					'label'       => __('View Cart', 'wpte-product-layout'),
					'type'        => Controls::TEXT,
					'default'     => 'View Cart',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-grouped-text',
				$data,
				[
					'label'       => __('Grouped Text', 'wpte-product-layout'),
					'type'        => Controls::TEXT,
					'default'     => 'Grouped',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-external-text',
				$data,
				[
					'label'       => __('External Text', 'wpte-product-layout'),
					'type'        => Controls::TEXT,
					'default'     => 'External',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-variable-text',
				$data,
				[
					'label'       => __('Variable Text', 'wpte-product-layout'),
					'type'        => Controls::TEXT,
					'default'     => 'Variable',
					'condition'   => [
						'wpte_product_layout_cart_icon_switcher' => 'yes',
					],
					'css'         => 'margin-bottom:10px',
					'description' => '',
				]
			);
		}
	}

	/**
	 * Method switcher_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function switcher_admin_control( $id, $data = [], $arg = [] ) {

		$argKey     = isset( $data[ $id ] ) ? $data[ $id ] : '';
		$ref_class  = isset( $arg['ref_class'] ) && $arg['ref_class'] ? "ref_calss='" . $arg['ref_class'] . "'" : '';
		$not_loader = isset( $arg['not_loader'] ) && $arg['not_loader'] ? 'not_loader=yes' : '';

		if ( 'yes' === $arg['default'] ) {
			$value = array_key_exists( $id, $data ) ? $argKey : 'no';
		} else {
			$value = array_key_exists( $id, $data ) ? $argKey : $arg['default'];
		}

		$condition_val = ( $value === $arg['return_value'] ? 'checked = "checked" ckdflt="true"' : '' );

		$html_data = '<div class="wpte-product-form-control-wrapper">
						<label class="wpte-product-switcher">
							<input class="wpte-product-layout-switcher" type="checkbox" ' . $condition_val . ' ' . $ref_class . ' ' . $not_loader . ' value="' . $arg['return_value'] . '"  name="' . $id . '" id="' . $id . '"/>
							<span data-on="' . $arg['label_on'] . '" data-off="' . $arg['label_off'] . '"></span>
						</label>
					</div>';

		echo wp_kses(
			(string) $html_data,
			[
				'div'   => [
					'class' => [],
				],
				'label' => [
					'class' => [],
				],
				'input' => [
					'class'      => [],
					'type'       => [],
					'checked'    => [],
					'ref_calss'  => [],
					'not_loader' => [],
					'ckdflt'     => [],
					'value'      => [],
					'name'       => [],
					'id'         => [],
				],
				'span'  => [
					'data-on'  => [],
					'data-off' => [],
				],
			]
		);
	}

	/**
	 * Method dimensions_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function dimensions_admin_control( $id, $data = [], $arg = [] ) {
		$unit   = array_key_exists( $id . '-choices', $data ) ? $data[ $id . '-choices' ] : $arg['default']['unit'];
		$top    = array_key_exists( $id . '-top', $data ) ? $data[ $id . '-top' ] : $arg['default']['size'];
		$bottom = array_key_exists( $id . '-bottom', $data ) ? $data[ $id . '-bottom' ] : $top;
		$left   = array_key_exists( $id . '-left', $data ) ? $data[ $id . '-left' ] : $top;
		$right  = array_key_exists( $id . '-right', $data ) ? $data[ $id . '-right' ] : $top;

		$retunvalue = array_key_exists( 'selector', $arg ) ? htmlspecialchars( wp_json_encode( $arg['selector'] ) ) : '';
		$ar         = [ $top, $bottom, $left, $right ];
		$unlink     = ( count( array_unique( $ar ) ) === 1 ? '' : 'link-dimensions-unlink' );

		if ( array_key_exists( 'selector-data', $arg ) && $arg['selector-data'] === true && $arg['render'] === true ) {
			if ( array_key_exists( 'selector', $arg ) ) :
				if ( isset( $top ) && isset( $right ) && isset( $bottom ) && isset( $left ) ) :
					foreach ( $arg['selector'] as $key => $val ) {
						$key   = ( strpos( $key, '{{KEY}}' ) ? str_replace( '{{KEY}}', explode( 'saarsa', $id )[1], $key ) : $key );
						$class = str_replace( '{{WRAPPER}}', $this->CSSWRAPPER, $key );
						$file  = str_replace( '{{UNIT}}', $unit, $val );
						$file  = str_replace( '{{TOP}}', $top, $file );
						$file  = str_replace( '{{RIGHT}}', $right, $file );
						$file  = str_replace( '{{BOTTOM}}', $bottom, $file );
						$file  = str_replace( '{{LEFT}}', $left, $file );

						$this->CSSDATA[ $arg['responsive'] ][ $class ][ $file ] = $file;
					}
				endif;
			endif;
		}

		if ( array_key_exists( 'range', $arg ) ) :
			if ( count( $arg['range'] ) > 1 ) :
				echo ' <div class="wpte-product-form-units-choices">';
				foreach ( $arg['range'] as $key => $val ) {
					$rand    = wp_rand( 10000, 233333333 );
					$checked = $key === $unit ? 'checked' : '';
					printf(
						'<input id="%1$s-choices-%2$s" type="radio" name="%1$s-choices"  value="%3$s" %4$s  min="%5$s" max="%6$s" step="%7$s">
							<label class="wpte-product-form-units-choices-label" for="%1$s-choices-%2$s">%3$s</label>',
						esc_attr($id),
						esc_attr($rand),
						esc_html($key),
						esc_attr($checked),
						esc_attr($val['min']),
						esc_attr($val['max']),
						esc_attr($val['step'])
					);
				}
				echo '</div>';
			endif;
		endif;
		$unitvalue = array_key_exists( $id . '-choices', $data ) ? 'unit="' . $data[ $id . '-choices' ] . '"' : '';

		printf(
			'<div class="wpte-product-form-control-input-wrapper">
			<ul class="wpte-product-control-dimentions">
				<li class="wpte-product-control-dimention">
					<input id="%1$s-top" input-id="%1$s" name="%1$s-top" type="number"  min="%2$s" max="%3$s" step="%4$s" value="%9$s" default-value="%9$s" %5$s responsive="%6$s" retundata="%7$s">
					<label for="%1$s-top" class="wpte-product-control-dimension-label">Top</label>
				</li>
				<li class="wpte-product-control-dimention">
				   <input id="%1$s-right" input-id="%1$s" name="%1$s-right" type="number"  min="%2$s" max="%3$s" step="%4$s" value="%10$s" default-value="%10$s" %5$s responsive="%6$s" retundata="%7$s">
					 <label for="%1$s-right" class="wpte-product-control-dimension-label">Right</label>
				</li>
				<li class="wpte-product-control-dimention">
				   <input id="%1$s-bottom" input-id="%1$s" name="%1$s-bottom" type="number"  min="%2$s" max="%3$s" step="%4$s" value="%11$s" default-value="%11$s" %5$s responsive="%6$s" retundata="%7$s">
				   <label for="%1$s-bottom" class="wpte-product-control-dimension-label">Bottom</label>
				</li>
				<li class="wpte-product-control-dimention">
					<input id="%1$s-left" input-id="%1$s" name="%1$s-left" type="number"  min="%2$s" max="%3$s" step="%4$s" value="%12$s" default-value="%12$s" %5$s responsive="%6$s" retundata="%7$s">
					 <label for="%1$s-left" class="wpte-product-control-dimension-label">Left</label>
				</li>
				<li class="wpte-product-control-dimention">
					<button type="button" class="wpte-product-form-link-dimensions %8$s"  data-tooltip="Link values together">
					   <span class="dashicons dashicons-admin-links"></span>
					</button>
				</li>
			</ul>
		</div>',
			esc_attr( $id ),
			esc_attr( $arg['range'][ $unit ]['min'] ),
			esc_attr( $arg['range'][ $unit ]['max'] ),
			esc_attr( $arg['range'][ $unit ]['step'] ),
			wp_kses( (string) $unitvalue, wpte_plugins_allowed_input_tags() ),
			esc_attr( $arg['responsive'] ),
			esc_attr( $retunvalue ),
			esc_attr( $unlink ),
			esc_attr( $top ),
			esc_attr( $right ),
			esc_attr( $bottom ),
			esc_attr( $left )
		);
	}

	/**
	 * Method select_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function select_admin_control( $id, $data = [], $arg = [] ) {

		$value  = array_key_exists( $id, $data ) ? $data[ $id ] : $arg['default'];
		$loader = array_key_exists( 'loader', $arg ) ? $arg['loader'] : '';
		$retun  = [];

		if ( array_key_exists( 'selector-data', $arg ) && $arg['selector-data'] == true ) {
			if ( array_key_exists( 'selector', $arg ) ) :
				foreach ( $arg['selector'] as $key => $val ) {
					$key = ( strpos( $key, '{{KEY}}' ) ? str_replace( '{{KEY}}', explode( 'saarsa', $id )[1], $key ) : $key );
					if ( ! empty( $value ) && ! empty( $val ) && $arg['render'] == true ) {
						$class = str_replace( '{{WRAPPER}}', $this->CSSWRAPPER, $key );
						$file = str_replace( '{{VALUE}}', $value, $val );
						if ( strpos( $file, '{{' ) !== false ) :
							$file = $this->multiple_selector_handler( $data, $file );
						endif;
						if ( ! empty( $value ) ) :
							$this->CSSDATA[ $arg['responsive'] ][ $class ][ $file ] = $file;
						endif;
					}
					$retun[ $key ][ $key ]['type']  = ( $val != '' ? 'CSS' : 'HTML' );
					$retun[ $key ][ $key ]['value'] = $val;
				}
			endif;
		}
		$retunvalue = array_key_exists( 'selector', $arg ) ? htmlspecialchars( wp_json_encode( $retun ) ) : '';
		$multiple   = ( array_key_exists( 'multiple', $arg ) && $arg['multiple'] ) == true ? true : false;

		printf('<div class="wpte-product-form-control-input-select-wrapper" id="wpte-%1$s">
		<select id="%1$s" class="wpte-product-select-input %2$s" %3$s name="%1$s%4$s" loader="%5$s"  responsive="%6$s" retundata="%7$s">',
		esc_attr($id),
		esc_attr(( $multiple ? 'js-example-basic-multiple' : '' )),
		esc_attr(( $multiple ? 'multiple' : '' )),
		( $multiple ? '[]' : '' ),
		esc_attr( $loader ),
		esc_attr( $arg['responsive'] ),
		esc_attr( $retunvalue )
		);
		foreach ( $arg['options'] as $key => $val ) {
			if ( is_array( $val ) ) :
				if ( isset( $val[0] ) && $val[0] == true ) :
					echo '<optgroup label="' . esc_attr( $val[1] ) . '">';
				else :
					echo '</optgroup>';
				endif;
			elseif ( is_array( $value ) ) :
					$new = array_flip( $value );
					printf('<option value="%1$s" %2$s>%3$s</option>',
					esc_attr($key),
					( array_key_exists( $key, $new ) ? 'selected' : '' ),
					esc_html($val)
					);
				else :
					echo ' <option value="' . esc_attr($key) . '" ' . ( $value == $key ? 'selected' : '' ) . '>' . esc_html( $val ) . '</option>';
			endif;
		}
		echo '</select>
			</div>';
	}

	/**
	 * Method number_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function number_admin_control( $id, $data = [], $arg = [] ) {

		$value  = array_key_exists( $id, $data ) ? $data[ $id ] : $arg['default'];
		$loader = array_key_exists( 'loader', $arg ) ? $arg['loader'] : '';

		$retunvalue = array_key_exists( 'selector', $arg ) ? htmlspecialchars( wp_json_encode( $arg['selector'] ) ) : '';
		if ( array_key_exists( 'selector-data', $arg ) && $arg['selector-data'] === true ) :
			if ( array_key_exists( 'selector', $arg ) ) :
				foreach ( $arg['selector'] as $key => $val ) {
					$key = ( strpos( $key, '{{KEY}}' ) ? str_replace( '{{KEY}}', explode( 'saarsa', $id )[1], $key ) : $key );
					$class = str_replace( '{{WRAPPER}}', $this->CSSWRAPPER, $key );
					$file = str_replace( '{{VALUE}}', $value, $val );
					if ( strpos( $file, '{{' ) !== false ) :
						$file = $this->multiple_selector_handler( $data, $file );
					endif;
					if ( ! empty( $value ) ) :
						$this->CSSDATA[ $arg['responsive'] ][ $class ][ $file ] = $file;
					endif;
				}
			endif;
		endif;

		$defualt = [
			'min' => 0,
			'max' => 1000,
			'step' => 1,
		];
		$arg     = array_merge( $defualt, $arg );
		printf( '<div class="wpte-product-form-control-wrapper">
				<div class="wpte-product-form-control-input-wrapper">
				<input class="wpte-product-input-type-number" id="%1$s" name="%1$s" type="number" loader="%8$s" min="%2$s" max="%3$s" step="%4$s" value="%5$s"  responsive="%6$s" retundata="%7$s">
				</div></div>',
			esc_attr($id),
			esc_attr($arg['min']),
			esc_attr($arg['max']),
			esc_attr($arg['step']),
			esc_attr($value),
			esc_attr($arg['responsive']),
			esc_attr($retunvalue),
			esc_attr($loader)
		);
	}

	/**
	 * Method color_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function color_admin_control( $id, $data = [], $arg = [] ) {
		$id         = ( array_key_exists( 'repeater', $arg ) ? $id . ']' : $id );
		$value      = array_key_exists( $id, $data ) ? $data[ $id ] : $arg['default'];
		$retunvalue = array_key_exists( 'selector', $arg ) ? htmlspecialchars( wp_json_encode( $arg['selector'] ) ) : '';

		if ( array_key_exists( 'selector-data', $arg ) && $arg['selector-data'] == true && $arg['render'] == true ) {
			if ( array_key_exists( 'selector', $arg ) ) :
				foreach ( $arg['selector'] as $key => $val ) {
					$key   = ( strpos( $key, '{{KEY}}' ) ? str_replace( '{{KEY}}', explode( 'saarsa', $id )[1], $key ) : $key );
					$class = str_replace( '{{WRAPPER}}', $this->CSSWRAPPER, $key );
					$file  = str_replace( '{{VALUE}}', $value, $val );
					if ( ! empty( $value ) ) :
						$this->CSSDATA[ $arg['responsive'] ][ $class ][ $file ] = $file;
					endif;
				}
			endif;
		}
		$type   = array_key_exists( 'oparetor', $arg ) ? 'data-format="rgb" data-opacity="true"' : '';
		$custom = array_key_exists( 'custom', $arg ) ? $arg['custom'] : '';

		printf( '<div class="wpte-product-form-control-wrapper">
				<label class="wpte-product-color-control">
					<input %1$s type="text"  class="wpte-product-minicolor" id="%2$s" name="%2$s" value="%3$s" responsive="%4$s" retundata="%5$s" custom="%6$s">
				</label>
			 </div>',
			wp_kses( (string) $type, wpte_plugins_allowedtags() ),
			esc_attr($id),
			esc_attr($value),
			esc_attr($arg['responsive']),
			esc_attr($retunvalue),
			esc_attr($custom)
		);
	}

	/**
	 * Method color_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function gradient_admin_control( $id, array $data = [], array $arg = [] ) {

		$id         = array_key_exists( 'repeater', $arg ) ? $id . ']' : $id;
		$value      = array_key_exists( $id, $data ) ? $data[ $id ] : $arg['default'];
		$retunvalue = array_key_exists( 'selector', $arg ) ? htmlspecialchars( wp_json_encode( $arg['selector'] ) ) : '';

		if ( array_key_exists( 'selector-data', $arg ) && $arg['selector-data'] === true ) {

			if ( array_key_exists( 'selector', $arg ) ) :

				foreach ( $arg['selector'] as $key => $val ) {
					if ( $arg['render'] === true ) :

						$key = ( strpos( $key, '{{KEY}}' ) ? str_replace( '{{KEY}}', explode( 'saarsa', $id )[1], $key ) : $key );
						$class = str_replace( '{{WRAPPER}}', $this->CSSWRAPPER, $key );
						$file = str_replace( '{{VALUE}}', $value, $val );
						if ( ! empty( $value ) ) :
							$this->CSSDATA[ $arg['responsive'] ][ $class ][ $file ] = $file;
						endif;
					endif;
				}
			endif;
		}
		$background = ( array_key_exists( 'gradient', $arg ) ? $arg['gradient'] : '' );
		echo '<div class="wpte-product-form-control-wrapper">
					<label class="wpte-product-color-control">
						<input type="text" background="' . esc_attr($background) . '"  class="wpte-product-gradient-color" id="' . esc_attr($id) . '" name="' . esc_attr($id) . '" value="' . esc_attr($value) . '" responsive="' . esc_attr($arg['responsive']) . '" retundata=\'' . esc_attr($retunvalue) . '\'>
					</label>
				</div>';
	}

	/**
	 * Method choose_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function choose_admin_control( $id, array $data = [], array $arg = [] ) {

		$value = array_key_exists( $id, $data ) ? $data[ $id ] : $arg['default'];
		$retun = [];

		$operator = array_key_exists( 'operator', $arg ) ? $arg['operator'] : 'text';
		if ( array_key_exists( 'selector-data', $arg ) && $arg['selector-data'] === true ) {
			if ( array_key_exists( 'selector', $arg ) ) :
				foreach ( $arg['selector'] as $key => $val ) {
					$key = ( strpos( $key, '{{KEY}}' ) ? str_replace( '{{KEY}}', explode( 'saarsa', $id )[1], $key ) : $key );
					if ( ! empty( $val ) ) {
						$class = str_replace( '{{WRAPPER}}', $this->CSSWRAPPER, $key );
						$file = str_replace( '{{VALUE}}', $value, $val );
						if ( strpos( $file, '{{' ) !== false ) :
							$file = $this->multiple_selector_handler( $data, $file );
						endif;
						if ( ! empty( $value ) ) :
							$this->CSSDATA[ $arg['responsive'] ][ $class ][ $file ] = $file;
						endif;
					}
					$retun[ $key ][ $key ]['type']  = ( $val !== '' ? 'CSS' : 'HTML' );
					$retun[ $key ][ $key ]['value'] = $val;
				}
			endif;
		}

		$retunvalue = array_key_exists( 'selector', $arg ) ? htmlspecialchars( wp_json_encode( $retun ) ) : '';

		echo '<div class="wpte-product-form-control-wrapper">
				<div class="wpte-product-form-choices" responsive="' . esc_attr( $arg['responsive'] ) . '" retundata=\'' . esc_attr( $retunvalue ) . '\'>';
		foreach ( $arg['options'] as $key => $val ) {
			echo '<input id="' . esc_attr($id) . '-' . esc_attr($key) . '" type="radio" name="' . esc_attr($id) . '" value="' . esc_attr($key) . '" ' . ( $value === $key ? 'checked  ckdflt="true"' : '' ) . '>
					<label class="wpte-product-form-choices-label" for="' . esc_attr($id) . '-' . esc_attr($key) . '" tooltip="' . esc_attr($val['title']) . '">
						' . ( ( $operator === 'text' ) ? esc_html($val['title']) : '<i class="' . esc_attr($val['icon']) . '" aria-hidden="true"></i>' ) . '
					</label>';
		}
		echo '</div>
		</div>';
	}

	/**
	 * Method icon_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function icon_admin_control( $id, $data = [], $arg = [] ) {
		$value = array_key_exists( $id, $data ) ? $data[ $id ] : $arg['default'];
		printf('<div class="wpte-product-form-control-input-wrapper">
					<div class="wpte-product-admin-icon-selector">
						<input type="text" class="%1$s" id="%1$s" name="%1$s" value="%2$s">
						<span class="input-group-addon"></span>
					</div>
				</div>',
				esc_attr($id),
				esc_attr($value)
		);
	}

	/**
	 * Method text_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function text_admin_control( $id, $data = [], $arg = [] ) {
		$value = array_key_exists( $id, $data ) ? $data[ $id ] : $arg['default'];

		printf('<div class="wpte-product-form-control-input-wrapper">
					<div class="wpte-product-admin-text">
						<input type="text" class="%1$s" id="%1$s" name="%1$s" value="%2$s">
					</div>
				</div>',
				esc_attr($id),
				esc_attr($value)
		);
	}

	/**
	 * Method tooltip_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function tooltip_admin_control( $id, $data = [], $arg = [] ) {

		$value = array_key_exists( $id, $data ) ? $data[ $id ] : $arg['default'];

		printf('<div class="wpte-product-form-control-input-wrapper">
					<div class="wpte-product-admin-text">
						<input type="text" class="%1$s" id="%1$s" name="%1$s" value="%2$s">
					</div>
				</div>',
				esc_attr($id),
				esc_attr($value)
		);
	}

	/**
	 * Method notice_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function notice_admin_control( $id, $data = [], $arg = [] ) {

		$value = array_key_exists( 'notice', $arg ) ? $arg['notice'] : '';

		printf('<div class="wpte-product-form-control-input-wrapper">
					<div class="wpte-product-notice" id="%1$s">
						<p>%2$s</p>
					</div>
				</div>',
				esc_attr($id),
				wp_kses( (string) $value, wpte_plugins_allowedtags() )
		);
	}

	/**
	 * Method column_admin_group_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function column_admin_group_control( $id, array $data = [], array $arg = [] ) {

		$selector  = array_key_exists( 'selector', $arg ) ? $arg['selector'] : '';
		$select    = array_key_exists( 'selector', $arg ) ? 'selector' : '';
		$cond      = '';
		$condition = '';

		if ( array_key_exists( 'condition', $arg ) ) :
			$cond      = 'condition';
			$condition = $arg['condition'];
		endif;

		$this->add_control(
			$id . '-lap',
			$data,
			[
				'label'          => __( 'Column Size', 'wpte-product-layout' ),
				'type'           => Controls::SELECT,
				'responsive'     => 'laptop',
				'description'    => $arg['description'],
				'default'        => 'wpte-pd-col-lg-12',
				'options'        => [
					'wpte-col-lap-1'  => __( 'Col 1', 'wpte-product-layout' ),
					'wpte-col-lap-2'  => __( 'Col 2', 'wpte-product-layout' ),
					'wpte-col-lap-3'  => __( 'Col 3', 'wpte-product-layout' ),
					'wpte-col-lap-4'  => __( 'Col 4', 'wpte-product-layout' ),
					'wpte-col-lap-5'  => __( 'Col 5', 'wpte-product-layout' ),
					'wpte-col-lap-6'  => __( 'Col 6', 'wpte-product-layout' ),
					'wpte-col-lap-7'  => __( 'Col 7', 'wpte-product-layout' ),
					'wpte-col-lap-8'  => __( 'Col 8', 'wpte-product-layout' ),
					'wpte-col-lap-12' => __( 'Col 12', 'wpte-product-layout' ),
				],
				$select          => $selector,
				'form_condition' => ( array_key_exists( 'form_condition', $arg ) ? $arg['form_condition'] : '' ),
				$cond            => $condition,
			]
		);
		$this->add_control(
			$id . '-tab',
			$data,
			[
				'label'          => __( 'Column Size', 'wpte-product-layout' ),
				'type'           => Controls::SELECT,
				'responsive'     => 'tab',
				'default'        => 'wpte-pd-col-md-12',
				'description'    => $arg['description'],
				'options'        => [
					''                => __( 'Default', 'wpte-product-layout' ),
					'wpte-col-tab-1'  => __( 'Col 1', 'wpte-product-layout' ),
					'wpte-col-tab-2'  => __( 'Col 2', 'wpte-product-layout' ),
					'wpte-col-tab-3'  => __( 'Col 3', 'wpte-product-layout' ),
					'wpte-col-tab-4'  => __( 'Col 4', 'wpte-product-layout' ),
					'wpte-col-tab-5'  => __( 'Col 5', 'wpte-product-layout' ),
					'wpte-col-tab-6'  => __( 'Col 6', 'wpte-product-layout' ),
					'wpte-col-tab-7'  => __( 'Col 7', 'wpte-product-layout' ),
					'wpte-col-tab-8'  => __( 'Col 8', 'wpte-product-layout' ),
					'wpte-col-tab-12' => __( 'Col 12', 'wpte-product-layout' ),
				],
				$select          => $selector,
				'form_condition' => ( array_key_exists( 'form_condition', $arg ) ? $arg['form_condition'] : '' ),
				$cond            => $condition,
			]
		);
		$this->add_control(
			$id . '-mob',
			$data,
			[
				'label'          => __( 'Column Size', 'wpte-product-layout' ),
				'type'           => Controls::SELECT,
				'default'        => 'wpte-pd-col-lg-12',
				'responsive'     => 'mobile',
				'description'    => $arg['description'],
				'options'        => [
					''                => __( 'Default', 'wpte-product-layout' ),
					'wpte-col-mob-1'  => __( 'Col 1', 'wpte-product-layout' ),
					'wpte-col-mob-2'  => __( 'Col 2', 'wpte-product-layout' ),
					'wpte-col-mob-3'  => __( 'Col 3', 'wpte-product-layout' ),
					'wpte-col-mob-4'  => __( 'Col 4', 'wpte-product-layout' ),
					'wpte-col-mob-5'  => __( 'Col 5', 'wpte-product-layout' ),
					'wpte-col-mob-6'  => __( 'Col 6', 'wpte-product-layout' ),
					'wpte-col-mob-7'  => __( 'Col 7', 'wpte-product-layout' ),
					'wpte-col-mob-8'  => __( 'Col 8', 'wpte-product-layout' ),
					'wpte-col-mob-12' => __( 'Col 12', 'wpte-product-layout' ),
				],
				$select          => $selector,
				'form_condition' => ( array_key_exists( 'form_condition', $arg ) ? $arg['form_condition'] : '' ),
				$cond            => $condition,
			]
		);
	}

	/**
	 * Wishlist Admin Group Control.
	 * Operator Allowed.
	 * Operator = Icon, text, icontext.
	 *
	 * @param int   $id .
	 * @param array $styleData .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function wishlist_admin_group_control( $id, $styleData = [], $arg = [] ) {

		$operator = array_key_exists('operator', $arg) ? $arg['operator'] : '';

		$this->add_control(
			'wpte_product_layout_wishlist_icon_switcher',
			$this->style,
			[
				'label'        => __( 'Show Wishlist', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'css'          => 'padding-top:10px',
				'return_value' => 'yes',
				'description'  => '',
			]
		);

		if ( $operator === 'icon' || $operator === 'icontext' ) {

			$this->add_control(
				'wpte-product-wishlist-icon',
				$this->style,
				[
					'label'       => __('Wishlist Icon', 'wpte-product-layout'),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-wishlist-3',
					'css'         => 'padding-bottom:10px',
					'condition'   => [
						'wpte_general_products_show_icons' => 'yes',
						'wpte_product_layout_wishlist_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-wishlist-added-icon',
				$this->style,
				[
					'label'       => __('Added Icon', 'wpte-product-layout'),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-wishlist-11',
					'condition'   => [
						'wpte_general_products_show_icons' => 'yes',
						'wpte_product_layout_wishlist_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		}

		if ( $operator === 'icon' ) {
			$this->add_control(
				'wpte_product_layout_wishlist_icon_tooltip_switcher',
				$this->style,
				[
					'label'        => __( 'Show Tooltip', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'yes',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'css'          => 'padding-top:10px',
					'return_value' => 'yes',
					'condition'    => [
						'wpte_product_layout_wishlist_icon_switcher' => 'yes',
						'wpte_general_products_show_icons' => 'yes',
					],
					'description'  => '',
				]
			);

			$this->add_control(
				'wpte-product-wishlist-tooltip',
				$this->style,
				[
					'label'       => __( 'Tooltip Text', 'wpte-product-layout' ),
					'type'        => Controls::TOOLTIP,
					'default'     => __( 'Wishlist', 'wpte-product-layout' ),
					'css'         => 'padding-bottom:10px',
					'condition'   => [
						'wpte_product_layout_wishlist_icon_switcher' => 'yes',
						'wpte_general_products_show_icons' => 'yes',
						'wpte_product_layout_wishlist_icon_tooltip_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		}

		if ( $operator === 'text' || $operator === 'icontext' ) {
			$this->add_control(
				'wpte-product-wishlist-text',
				$this->style,
				[
					'label'       => __('Wishlist Text', 'wpte-product-layout'),
					'type'        => Controls::TEXT,
					'default'     => __('Wishlist', 'wpte-product-layout'),
					'condition'   => [
						'wpte_product_layout_wishlist_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);
			$this->add_control(
				'wpte-product-wishlist-added-text',
				$this->style,
				[
					'label'       => __('Added Text', 'wpte-product-layout'),
					'type'        => Controls::TEXT,
					'default'     => __('Added', 'wpte-product-layout'),
					'css'         => 'padding-bottom:10px',
					'condition'   => [
						'wpte_product_layout_wishlist_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		}
	}

	/**
	 * Method compare_admin_group_control.
	 * Operator Allowed.
	 * Operator = Icon, text, icontext.
	 *
	 * @param int   $id .
	 * @param array $styleData .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function compare_admin_group_control( $id, $styleData = [], $arg = [] ) {

		$operator = array_key_exists('operator', $arg) ? $arg['operator'] : '';

		$this->add_control(
			'wpte_product_layout_compare_icon_switcher',
			$this->style,
			[
				'label'        => __( 'Show Compare', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'css'          => 'padding-top:10px',
				'return_value' => 'yes',
				'description'  => '',
			]
		);

		if ( $operator === 'icon' || $operator === 'icontext' ) {

			$this->add_control(
				'wpte-product-compare-icon',
				$this->style,
				[
					'label'       => __( 'Compare Icon', 'wpte-product-layout' ),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-compare-1',
					'css'         => 'padding-bottom:10px',
					'condition'   => [
						'wpte_general_products_show_icons' => 'yes',
						'wpte_product_layout_compare_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);

			$this->add_control(
				'wpte-product-compare-added-icon',
				$this->style,
				[
					'label'       => __( 'Added Icon', 'wpte-product-layout' ),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-compare-6',
					'condition'   => [
						'wpte_general_products_show_icons' => 'yes',
						'wpte_product_layout_compare_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		}
		if ( $operator === 'icon' ) {
			$this->add_control(
				'wpte_product_layout_compare_icon_tooltip_switcher',
				$this->style,
				[
					'label'        => __( 'Show Tooltip', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'yes',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'css'          => 'padding-top:10px',
					'return_value' => 'yes',
					'condition' => [
						'wpte_product_layout_compare_icon_switcher' => 'yes',
						'wpte_general_products_show_icons' => 'yes',
					],
					'description'  => '',
				]
			);

			$this->add_control(
				'wpte-product-compare-tooltip',
				$this->style,
				[
					'label'       => __( 'Tooltip Text', 'wpte-product-layout' ),
					'type'        => Controls::TOOLTIP,
					'default'     => __( 'Compare', 'wpte-product-layout' ),
					'css'         => 'padding-bottom:10px',
					'condition'   => [
						'wpte_product_layout_compare_icon_switcher' => 'yes',
						'wpte_general_products_show_icons' => 'yes',
						'wpte_product_layout_compare_icon_tooltip_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		} elseif ( $operator === 'text' || $operator === 'icontext' ) {
			$this->add_control(
				'wpte-product-compare-text',
				$this->style,
				[
					'label'       => __( 'Compare Text', 'wpte-product-layout' ),
					'type'        => Controls::TEXT,
					'default'     => __( 'Compare', 'wpte-product-layout' ),
					'condition'   => [
						'wpte_product_layout_compare_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);
			$this->add_control(
				'wpte-product-compare-added-text',
				$this->style,
				[
					'label'       => __( 'Added Text', 'wpte-product-layout' ),
					'type'        => Controls::TEXT,
					'default'     => __( 'Added', 'wpte-product-layout' ),
					'css'         => 'padding-bottom:10px',
					'condition'   => [
						'wpte_product_layout_compare_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		}
	}

	/**
	 * Method quickview_admin_group_control.
	 * Operator Allowed.
	 * Operator = Icon, text, icontext.
	 *
	 * @param int   $id .
	 * @param array $styleData .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function quickview_admin_group_control( $id, $styleData = [], $arg = [] ) {

		$operator = array_key_exists('operator', $arg) ? $arg['operator'] : '';

		$this->add_control(
			'wpte_product_layout_quickview_icon_switcher',
			$this->style,
			[
				'label'        => __( 'Show Quickview', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'No', 'wpte-product-layout' ),
				'css'          => 'padding-top:10px',
				'return_value' => 'yes',
				'description'  => '',
			]
		);

		if ( $operator === 'icon' || $operator === 'icontext' ) {

			$this->add_control(
				'wpte-product-quickview-icon',
				$this->style,
				[
					'label'       => __( 'Quickview Icon', 'wpte-product-layout' ),
					'type'        => Controls::ICON,
					'default'     => 'wpte-icon icon-quickview',
					'css'         => 'padding-bottom:10px',
					'condition'   => [
						'wpte_general_products_show_icons' => 'yes',
						'wpte_product_layout_quickview_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		}
		if ( $operator === 'icon' ) {
			$this->add_control(
				'wpte_product_layout_quickview_icon_tooltip_switcher',
				$this->style,
				[
					'label'        => __( 'Show Tooltip', 'wpte-product-layout' ),
					'type'         => Controls::SWITCHER,
					'default'      => 'yes',
					'label_on'     => __( 'Yes', 'wpte-product-layout' ),
					'label_off'    => __( 'No', 'wpte-product-layout' ),
					'css'          => 'padding-top:10px',
					'return_value' => 'yes',
					'condition' => [
						'wpte_product_layout_quickview_icon_switcher' => 'yes',
						'wpte_general_products_show_icons' => 'yes',
					],
					'description'  => '',
				]
			);

			$this->add_control(
				'wpte-product-quickview-tooltip',
				$this->style,
				[
					'label'       => __( 'Tooltip Text', 'wpte-product-layout' ),
					'type'        => Controls::TOOLTIP,
					'default'     => __( 'Quick view', 'wpte-product-layout' ),
					'css'         => 'padding-bottom:10px',
					'condition'   => [
						'wpte_product_layout_quickview_icon_switcher' => 'yes',
						'wpte_general_products_show_icons' => 'yes',
						'wpte_product_layout_quickview_icon_tooltip_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		}

		if ( $operator === 'text' || $operator === 'icontext' ) {
			$this->add_control(
				'wpte-product-quickview-text',
				$this->style,
				[
					'label'       => __( 'Quickview Text', 'wpte-product-layout' ),
					'type'        => Controls::TEXT,
					'default'     => __( 'Quick view', 'wpte-product-layout' ),
					'condition'   => [
						'wpte_product_layout_quickview_icon_switcher' => 'yes',
					],
					'description' => '',
				]
			);
		}
	}

	/**
	 * Method font_admin_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function font_admin_control( $id, array $data = [], array $arg = [] ) {

		$id         = ( array_key_exists( 'repeater', $arg ) ? $id . ']' : $id );
		$retunvalue = '';
		$value      = array_key_exists( $id, $data ) ? $data[ $id ] : $arg['default'];

		if ( $value != '' ) :
			$this->font[ $value ] = $value;
		endif;

		if ( array_key_exists( 'selector-data', $arg ) && $arg['selector-data'] == true ) {
			if ( array_key_exists( 'selector', $arg ) && $value != '' ) :
				foreach ( $arg['selector'] as $key => $val ) {
					if ( $arg['render'] == true ) :
						$key = ( strpos( $key, '{{KEY}}' ) ? str_replace('{{KEY}}', explode( 'saarsa', $id )[1], $key ) : $key );
						$class = str_replace( '{{WRAPPER}}', $this->WRAPPER, $key );
						$file = str_replace( '{{VALUE}}', str_replace( '+', ' ', $value ), $val );
						if ( ! empty( $value ) ) :
							$this->CSSDATA[ $arg['responsive'] ][ $class ][ $file ] = $file;
						endif;
					endif;
				}
			endif;
		}
		$retunvalue = array_key_exists('selector', $arg) ? htmlspecialchars( wp_json_encode( $arg['selector'] ) ) : '';

		printf('<div class="wpte-product-form-control-input-wrapper">
		<input type="text"  class="wpte-product-font-family" id="%1$s" name="%1$s" value="%2$s" responsive="%3$s" retundata="%4$s">
		</div>',
		esc_attr($id),
		esc_attr($value),
		esc_attr($arg['responsive']),
		esc_attr($retunvalue)
		);
	}

	/**
	 * Method typography_admin_group_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function typography_admin_group_control( $id, $data = [], $arg = [] ) {

		$cond         = '';
		$notcond      = '';
		$condition    = '';
		$notcondition = '';

		if ( array_key_exists( 'condition', $arg ) ) :
			$cond = 'condition';
			$condition = $arg['condition'];
			if ( array_key_exists( 'notcondition', $arg ) ) :
				$notcond = 'notcondition';
				$notcondition = $arg['notcondition'];
			endif;
		endif;

		$separator = array_key_exists( 'separator', $arg ) ? $arg['separator'] : false;

		$selector_key  = '';
		$selector      = '';
		$selectorvalue = '';
		$loader        = '';
		$loadervalue   = '';

		if ( array_key_exists( 'selector', $arg ) ) :
			$selectorvalue = 'selector-value';
			$selector_key  = 'selector';
			$selector      = $arg['selector'];
		endif;

		$css = array_key_exists( 'css', $arg ) && isset($arg['css']) ? $arg['css'] : '';
		$this->start_popover_control(
				$id,
				[
					'label'          => __( 'Typography', 'wpte-product-layout'),
					$notcond         => $notcondition,
					$cond            => $condition,
					'form_condition' => ( array_key_exists( 'form_condition', $arg ) ? $arg['form_condition'] : '' ),
					'description'    => $arg['description'],
					'css'            => $css,
					'separator'      => $separator,
				]
		);

		$this->add_control(
				$id . '-font',
				$data,
				[
					'label'        => __( 'Font Family', 'wpte-product-layout' ),
					'type'         => Controls::FONT,
					$selectorvalue => 'font-family:{{VALUE}};',
					$selector_key  => $selector,
				]
		);
		$this->add_responsive_control(
				$id . '-size',
				$data,
				[
					'label'   => __( 'Size', 'wpte-product-layout' ),
					'type'    => Controls::SLIDER,
					'default' => [
						'unit' => 'px',
						'size' => '',
					],
					'range'   => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'em' => [
							'min' => 0,
							'max' => 10,
							'step' => 0.1,
						],
						'rem' => [
							'min' => 0,
							'max' => 10,
							'step' => 0.1,
						],
						'vm' => [
							'min' => 0,
							'max' => 10,
							'step' => 0.1,
						],
					],
					$selectorvalue => 'font-size: {{SIZE}}{{UNIT}};',
					$selector_key => $selector,
				]
		);
		$this->add_control(
				$id . '-weight',
				$data,
				[
					'label'        => __( 'Weight', 'wpte-product-layout' ),
					'type'         => Controls::SELECT,
					$selectorvalue => 'font-weight: {{VALUE}};',
					$selector_key  => $selector,
					'options'      => [
						'100'    => __( '100', 'wpte-product-layout' ),
						'200'    => __( '200', 'wpte-product-layout' ),
						'300'    => __( '300', 'wpte-product-layout' ),
						'400'    => __( '400', 'wpte-product-layout' ),
						'500'    => __( '500', 'wpte-product-layout' ),
						'600'    => __( '600', 'wpte-product-layout' ),
						'700'    => __( '700', 'wpte-product-layout' ),
						'800'    => __( '800', 'wpte-product-layout' ),
						'900'    => __( '900', 'wpte-product-layout' ),
						''       => __( 'Default', 'wpte-product-layout' ),
						'normal' => __( 'Normal', 'wpte-product-layout' ),
						'bold'   => __( 'Bold', 'wpte-product-layout' ),
					],
				]
		);
		$this->add_control(
				$id . '-transform',
				$data,
				[
					'label'        => __( 'Transform', 'wpte-product-layout' ),
					'type'         => Controls::SELECT,
					'default'      => '',
					'options'      => [
						''           => __( 'Default', 'wpte-product-layout' ),
						'uppercase'  => __( 'Uppercase', 'wpte-product-layout' ),
						'lowercase'  => __( 'Lowercase', 'wpte-product-layout' ),
						'capitalize' => __( 'Capitalize', 'wpte-product-layout' ),
						'none'       => __( 'Normal', 'wpte-product-layout' ),
					],
					$selectorvalue => 'text-transform: {{VALUE}};',
					$selector_key  => $selector,
				]
		);
		$this->add_control(
				$id . '-style',
				$data,
				[
					'label'        => __( 'Style', 'wpte-product-layout' ),
					'type'         => Controls::SELECT,
					'default'      => '',
					'options'      => [
						''        => __('Default', 'wpte-product-layout'),
						'normal'  => __('normal', 'wpte-product-layout'),
						'italic'  => __('Italic', 'wpte-product-layout'),
						'oblique' => __('Oblique', 'wpte-product-layout'),
					],
					$selectorvalue => 'font-style: {{VALUE}};',
					$selector_key  => $selector,
				]
		);
		$this->add_control(
				$id . '-decoration',
				$data,
				[
					'label'        => __( 'Decoration', 'wpte-product-layout' ),
					'type'         => Controls::SELECT,
					'default'      => '',
					'options'      => [
						'' => __( 'Default', 'wpte-product-layout' ),
						'underline'    => __( 'Underline', 'wpte-product-layout' ),
						'overline'     => __( 'Overline', 'wpte-product-layout' ),
						'line-through' => __( 'Line Through', 'wpte-product-layout' ),
						'none'         => __( 'None', 'wpte-product-layout' ),
					],
					$selectorvalue => 'text-decoration: {{VALUE}};',
					$selector_key  => $selector,
				]
		);

		$this->add_responsive_control(
				$id . '-l-height',
				$data,
				[
					'label'   => __( 'Line Height', 'wpte-product-layout' ),
					'type'    => Controls::SLIDER,
					'default' => [
						'unit' => 'px',
						'size' => '',
					],
					'range'   => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'em' => [
							'min' => 0,
							'max' => 10,
							'step' => 0.1,
						],
					],
					$selectorvalue => 'line-height: {{SIZE}}{{UNIT}};',
					$selector_key  => $selector,
				]
		);

		$this->add_responsive_control(
				$id . '-l-spacing',
				$data,
				[
					'label'   => __( 'Letter Spacing', 'wpte-product-layout' ),
					'type'    => Controls::SLIDER,
					'default' => [
						'unit' => 'px',
						'size' => '',
					],
					'range'   => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 0.1,
						],
						'em'  => [
							'min' => 0,
							'max' => 10,
							'step' => 0.01,
						],
					],
					$selectorvalue => 'letter-spacing: {{SIZE}}{{UNIT}};',
					$selector_key  => $selector,
				]
		);
		$this->end_popover_control();
	}

	/**
	 * Method boxshadow_admin_group_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function boxshadow_admin_group_control( $id, $data = [], $arg = [] ) {

		$cond      = '';
		$condition = '';
		$boxshadow = '';

		if ( array_key_exists( 'condition', $arg ) ) :
			$cond      = 'condition';
			$condition = $arg['condition'];
		endif;

		$true = true;

		$selector_key  = '';
		$selector      = '';
		$selectorvalue = '';

		if ( ! array_key_exists( $id . '-shadow', $data ) ) :
			$data[ $id . '-shadow' ] = 'no';
		endif;
		if ( ! array_key_exists( $id . '-blur-size', $data ) ) :
			$data[ $id . '-blur-size' ] = 0;
		endif;
		if ( ! array_key_exists( $id . '-horizontal-size', $data ) ) :
			$data[ $id . '-horizontal-size' ] = 0;
		endif;
		if ( ! array_key_exists( $id . '-vertical-size', $data ) ) :
			$data[ $id . '-vertical-size' ] = 0;
		endif;

		if ( array_key_exists( $id . '-shadow', $data ) && $data[ $id . '-shadow' ] === 'yes' && array_key_exists( $id . '-color', $data ) && array_key_exists( $id . '-blur-size', $data ) && array_key_exists( $id . '-spread-size', $data ) && array_key_exists( $id . '-horizontal-size', $data ) && array_key_exists( $id . '-vertical-size', $data ) ) :
			$true       = ( $data[ $id . '-blur-size' ] === 0 || empty( $data[ $id . '-blur-size' ] ) ) && ( $data[ $id . '-spread-size' ] === 0 || empty( $data[ $id . '-spread-size' ] ) ) && ( $data[ $id . '-horizontal-size' ] === 0 || empty( $data[ $id . '-horizontal-size' ] ) ) && ( $data[ $id . '-vertical-size' ] === 0 || empty( $data[ $id . '-vertical-size' ] ) ) ? true : false;
			$boxshadow  = ( $true === false ? '-webkit-box-shadow:' . ( array_key_exists( $id . '-type', $data ) ? $data[ $id . '-type' ] : '' ) . ' ' . $data[ $id . '-horizontal-size' ] . 'px ' . $data[ $id . '-vertical-size' ] . 'px ' . $data[ $id . '-blur-size' ] . 'px ' . $data[ $id . '-spread-size' ] . 'px ' . $data[ $id . '-color' ] . ';' : '' );
			$boxshadow .= ( $true === false ? '-moz-box-shadow:' . ( array_key_exists( $id . '-type', $data ) ? $data[ $id . '-type' ] : '' ) . ' ' . $data[ $id . '-horizontal-size' ] . 'px ' . $data[ $id . '-vertical-size' ] . 'px ' . $data[ $id . '-blur-size' ] . 'px ' . $data[ $id . '-spread-size' ] . 'px ' . $data[ $id . '-color' ] . ';' : '' );
			$boxshadow .= ( $true === false ? 'box-shadow:' . ( array_key_exists( $id . '-type', $data ) ? $data[ $id . '-type' ] : '' ) . ' ' . $data[ $id . '-horizontal-size' ] . 'px ' . $data[ $id . '-vertical-size' ] . 'px ' . $data[ $id . '-blur-size' ] . 'px ' . $data[ $id . '-spread-size' ] . 'px ' . $data[ $id . '-color' ] . ';' : '' );
		endif;

		if ( array_key_exists( 'selector', $arg ) ) :
			$selectorvalue = 'selector-value';
			$selector_key  = 'selector';
			$selector      = $arg['selector'];
			$boxshadow     = array_key_exists( $id . '-shadow', $data ) && $data[ $id . '-shadow' ] === 'yes' ? $boxshadow : '';

			foreach ( $arg['selector'] as $key => $val ) {
				$key   = ( strpos( $key, '{{KEY}}' ) ? str_replace( '{{KEY}}', explode( 'saarsa', $id )[1], $key ) : $key );
				$class = str_replace( '{{WRAPPER}}', $this->CSSWRAPPER, $key );
				$this->CSSDATA['laptop'][ $class ][ $boxshadow ] = $boxshadow;
			}

		endif;
		$css = array_key_exists('css', $arg) && isset($arg['css']) ? $arg['css'] : '';
		$this->start_popover_control(
				$id,
				[
					'label'          => __( 'Box Shadow', 'wpte-product-layout' ),
					$cond            => $condition,
					'form_condition' => ( array_key_exists( 'form_condition', $arg ) ? $arg['form_condition'] : '' ),
					'css'            => $css,
					'description'    => $arg['description'],
				]
		);
		$this->add_control(
			$id . '-shadow',
			$data,
			[
				'label'        => __( 'Shadow', 'wpte-product-layout' ),
				'type'         => Controls::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'wpte-product-layout' ),
				'label_off'    => __( 'None', 'wpte-product-layout' ),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			$id . '-type',
			$data,
			[
				'label'     => __( 'Type', 'wpte-product-layout' ),
				'type'      => Controls::CHOOSE,
				'default'   => '',
				'options'   => [
					''      => [
						'title' => __( 'Outline', 'wpte-product-layout' ),
						'icon'  => 'fa fa-align-left',
					],
					'inset' => [
						'title' => __( 'Inset', 'wpte-product-layout' ),
						'icon'  => 'fa fa-align-center',
					],
				],
				'condition' => [ $id . '-shadow' => 'yes' ],
			]
		);

		$this->add_control(
			$id . '-horizontal',
			$data,
			[
				'label'        => __( 'Horizontal', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'default'      => [
					'unit' => 'px',
					'size' => 0,
				],
				'range'        => [
					'px' => [
						'min'  => -50,
						'max'  => 100,
						'step' => 1,
					],
				],
				'custom'       => $id . '|||||box-shadow',
				$selectorvalue => '{{VALUE}}',
				$selector_key  => $selector,
				'render'       => false,
				'condition'    => [ $id . '-shadow' => 'yes' ],
			]
		);
		$this->add_control(
			$id . '-vertical',
			$data,
			[
				'label'        => __( 'Vertical', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'default'      => [
					'unit' => 'px',
					'size' => 0,
				],
				'range'        => [
					'px' => [
						'min'  => -50,
						'max'  => 100,
						'step' => 1,
					],
				],
				'custom'       => $id . '|||||box-shadow',
				$selectorvalue => '{{VALUE}}',
				$selector_key  => $selector,
				'render'       => false,
				'condition'    => [ $id . '-shadow' => 'yes' ],
			]
		);
		$this->add_control(
			$id . '-blur',
			$data,
			[
				'label'        => __( 'Blur', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'default'      => [
					'unit' => 'px',
					'size' => 0,
				],
				'range'        => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'custom'       => $id . '|||||box-shadow',
				$selectorvalue => '{{VALUE}}',
				$selector_key  => $selector,
				'render'       => false,
				'condition'    => [ $id . '-shadow' => 'yes' ],
			]
		);
		$this->add_control(
			$id . '-spread',
			$data,
			[
				'label'        => __( 'Spread', 'wpte-product-layout' ),
				'type'         => Controls::SLIDER,
				'default'      => [
					'unit' => 'px',
					'size' => 0,
				],
				'range'        => [
					'px' => [
						'min'  => -50,
						'max'  => 100,
						'step' => 1,
					],
				],
				'custom'       => $id . '|||||box-shadow',
				$selectorvalue => '{{VALUE}}',
				$selector_key  => $selector,
				'render'       => false,
				'condition'    => [ $id . '-shadow' => 'yes' ],
			]
		);
		$this->add_control(
			$id . '-color',
			$data,
			[
				'label'        => __( 'Color', 'wpte-product-layout' ),
				'separator'    => 'before',
				'type'         => Controls::COLOR,
				'oparetor'     => 'RGB',
				'default'      => '#CCC',
				'custom'       => $id . '|||||box-shadow',
				$selectorvalue => '{{VALUE}}',
				$selector_key  => $selector,
				'render'       => false,
				'condition'    => [ $id . '-shadow' => 'yes' ],
			]
		);
		$this->end_popover_control();
	}

	/**
	 * Method border_admin_group_control.
	 *
	 * @param int   $id .
	 * @param array $data .
	 * @param array $arg .
	 * @since 1.0.0
	 */
	public function border_admin_group_control( $id, $data = [], $arg = [] ) {

		$cond      = '';
		$condition = '';

		if ( array_key_exists( 'condition', $arg ) ) :
			$cond      = 'condition';
			$condition = $arg['condition'];
		endif;

		$separator = array_key_exists( 'separator', $arg ) ? $arg['separator'] : false;

		$selector_key  = '';
		$selector      = '';
		$selectorvalue = '';
		$render        = '';

		if ( array_key_exists( 'selector', $arg ) ) :
			$selectorvalue = 'selector-value';
			$selector_key  = 'selector';
			$selector      = $arg['selector'];
		endif;

		if ( array_key_exists( $id . '-type', $data ) && $data[ $id . '-type' ] === '' ) :
			$render = 'render';
		endif;
		$css = array_key_exists( 'css', $arg ) && isset( $arg['css'] ) ? $arg['css'] : '';
		$this->start_popover_control(
				$id,
				[
					'label'          => __( 'Border', 'wpte-product-layout' ),
					$cond            => $condition,
					'form_condition' => ( array_key_exists( 'form_condition', $arg ) ? $arg['form_condition'] : '' ),
					'separator'      => $separator,
					'css'            => $css,
					'description'    => $arg['description'],
				]
		);
		$this->add_control(
				$id . '-type',
				$data,
				[
					'label'        => __( 'Type', 'wpte-product-layout' ),
					'type'         => Controls::SELECT,
					'default'      => '',
					'options'      => [
						''       => __('None', 'wpte-product-layout' ),
						'solid'  => __( 'Solid', 'wpte-product-layout' ),
						'dotted' => __( 'Dotted', 'wpte-product-layout' ),
						'dashed' => __( 'Dashed', 'wpte-product-layout' ),
						'double' => __( 'Double', 'wpte-product-layout' ),
						'groove' => __( 'Groove', 'wpte-product-layout' ),
						'ridge'  => __( 'Ridge', 'wpte-product-layout' ),
						'inset'  => __( 'Inset', 'wpte-product-layout' ),
						'outset' => __( 'Outset', 'wpte-product-layout' ),
						'hidden' => __( 'Hidden', 'wpte-product-layout' ),
					],
					$selectorvalue => 'border-style: {{VALUE}};',
					$selector_key  => $selector,
				]
		);
		$this->add_responsive_control(
				$id . '-width',
				$data,
				[
					'label'        => __( 'Width', 'wpte-product-layout' ),
					'type'         => Controls::DIMENSIONS,
					$render        => false,
					'default'      => [
						'unit' => 'px',
						'size' => '',
					],
					'range'        => [
						'px' => [
							'min'  => -100,
							'max'  => 100,
							'step' => 1,
						],
						'em' => [
							'min'  => 0,
							'max'  => 10,
							'step' => 0.01,
						],
					],
					'condition'    => [
						$id . '-type' => 'EMPTY',
					],
					$selectorvalue => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					$selector_key  => $selector,
				]
		);
		$this->add_control(
				$id . '-color',
				$data,
				[
					'label'        => __( 'Color', 'wpte-product-layout' ),
					'type'         => Controls::COLOR,
					$render        => false,
					'default'      => '',
					$selectorvalue => 'border-color: {{VALUE}};',
					$selector_key  => $selector,
					'condition'    => [
						$id . '-type' => 'EMPTY',
					],
				]
		);
		$this->end_popover_control();
	}
}

