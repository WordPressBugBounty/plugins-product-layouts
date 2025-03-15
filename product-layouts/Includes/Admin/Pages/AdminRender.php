<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages;

/**
 * AdminRender
 *
 * @since 1.0.0
 */
abstract class AdminRender {

	use \WPTE_PRODUCT_LAYOUT\Includes\Helper\Helper;
	use \WPTE_PRODUCT_LAYOUT\Includes\Helper\Advanced;

	/**
	 * Wpteid
	 *
	 * @var $wpteid
	 * @since 1.0.0
	 */
	public $wpteid;

	/**
	 * Wpdb
	 *
	 * @var $wpdb
	 * @since 1.0.0
	 */
	public $wpdb;

	/**
	 * WP DB Table Name
	 *
	 * @var $wpte_table
	 * @since 1.0.0
	 */
	public $wpte_table;

	/**
	 * Dbdata
	 *
	 * @var $dbdata
	 * @since 1.0.0
	 */
	public $dbdata;

	/**
	 * Rawdata
	 *
	 * @var $rawdata
	 */
	public $rawdata;

	/**
	 * Style
	 *
	 * @var $style
	 */
	public $style = [];

	/**
	 * Current Elements Style name
	 *
	 * @var $StyleName
	 * @since 1.0.0
	 */
	public $StyleName;

	/**
	 * All Wrapper
	 *
	 * @var $WRAPPER
	 * @since 1.0.0
	 */
	public $WRAPPER;

	/**
	 * All CSS Wrapper
	 *
	 * @var $CSSWRAPPER
	 * @since 1.0.0
	 */
	public $CSSWRAPPER;

	/**
	 * All CSS Data
	 *
	 * @var $CSSDATA
	 * @since 1.0.0
	 */
	public $CSSDATA;

	/**
	 * Type
	 *
	 * @var $type
	 * @since 1.0.0
	 */
	public $type;

	/**
	 * Font
	 *
	 *  @var $font
	 * @since 1.0.0
	 */
	public $font;

	/**
	 * Method __construct
	 *
	 * @param string $type .
	 * @return void
	 */
	public function __construct( $type = '' ) {

		global $wpdb;
		$this->wpdb       = $wpdb;
		$this->wpte_table = $this->wpdb->prefix . 'wpte_product_layout_style';
		$this->wpteid     = ( ! empty( $_GET['styleid'] ) ? intval( $_GET['styleid'] ) : 0 );
		$this->WRAPPER    = '.wpte-product-layout-wrapper-' . $this->wpteid;
		$this->CSSWRAPPER = '.wpte-product-layout-wrapper-' . $this->wpteid . ' .wpte-product-row';
		$this->wpte_script_loader();
		$this->type = $type;
		if ( $this->type != 'admin' ) {
			$this->wpte_db_data();
			$this->render();
		}
		new Layout_list\Export();
	}

	/**
	 * Method Hooks
	 *
	 * @return void
	 */
	public function wpte_db_data() {
		global $wpdb;
		$this->dbdata = $wpdb->get_row(
            $wpdb->prepare(
                'SELECT * FROM ' . $wpdb->prefix . 'wpte_product_layout_style WHERE id = %d ', $this->wpteid
            ), ARRAY_A
        );
		$this->StyleName = explode( '-', ucfirst( $this->dbdata['style_name'] ) );
		if ( ! empty( $this->dbdata['rawdata'] ) ) {
			$this->rawdata = json_decode( $this->dbdata['rawdata'], true );
			if ( is_array( $this->rawdata ) ) {
				$this->style = $this->rawdata;
			}
		}
	}

	/**
	 * Method wpte_script_loader
	 *
	 * @return void
	 */
	public function wpte_script_loader() {

		// Js.
		wp_enqueue_script( 'wpte-serializejson' );
		wp_enqueue_script( 'wpte-wpl-select2-js' );
		wp_enqueue_script( 'wpte-nouislider' );
		wp_enqueue_script( 'wpte-gradient-color' );
		wp_enqueue_script( 'wpte-minicolors' );
		wp_enqueue_script( 'jquery-ui-resizable' );
		wp_enqueue_script( 'wpte-icon-picker' );
		wp_enqueue_script( 'wpte-font-picker-js' );
		wp_enqueue_script( 'wpte-global-js' );
		wp_enqueue_script( 'wpte-condition-js' );
		wp_enqueue_script( 'wpte-wpl-admin-js' );
		wp_enqueue_script( 'wpte-wpl-editor' );
		wp_localize_script(
            'wpte-wpl-editor', 'wpteEditor', [
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-editor-update-nonce' ),
				'error'      => __( 'Something Went Wrong!', 'wpte-product-layout' ),
			]
        );

		wp_localize_script(
            'wpte-global-js', 'wpteGlobal', [
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'wpte_nonce' => wp_create_nonce( 'wpte-global-nonce' ),
				'error'      => __( 'Something Went Wrong!', 'wpte-product-layout' ),
			]
        );

		$this->wpte_compare_script_loader();
		$this->wpte_quickview_script_loader();
	}

	/**
	 * Admin Compare script loader
	 *
	 * @since 1.0.1
	 */
	public function wpte_compare_script_loader() {
		wp_enqueue_script( 'wpte-product-compare' );
	}

	/**
	 * Admin Quick view script loader
	 *
	 * @since 1.0.1
	 */
	public function wpte_quickview_script_loader() {
		if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {
			if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
				wp_enqueue_script( 'zoom' );
			}
			if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
				wp_enqueue_script( 'flexslider' );
			}
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			wp_enqueue_script( 'wc-single-product' );
		}

		wp_enqueue_script( 'wpte-quick-view-js' );
	}

	/**
	 * Template Register Control
	 * return always true and abstract with current Style Template
	 *
	 * @since 1.0.0
	 */
	public function register_controls() {
		return true;
	}

	/**
	 * Template CSS Render.
	 *
	 * @param int   $id .
	 * @param mixed $rawData .
	 * @since 1.0.0
	 */
	public function template_css_render( $id, $rawData ) {
		$styleid      = $id;
		$this->wpteid = $styleid;

		$this->WRAPPER    = '.wpte-product-layout-wrapper-' . $this->wpteid;
		$this->CSSWRAPPER = '.wpte-product-layout-wrapper-' . $this->wpteid . ' .wpte-product-row';
		$this->style      = $rawData;

		ob_start();
			$this->register_controls();
			$this->wpte_advanced_controlers();
		ob_end_clean();

		$fullcssfile = '';
		foreach ( $this->CSSDATA as $key => $responsive ) {
			$tempcss = '';
			foreach ( $responsive as $class => $classes ) {
				$tempcss .= $class . '{';
				foreach ( $classes as $properties ) {
					$tempcss .= $properties;
				}
				$tempcss .= '}';
			}
			if ( $key === 'laptop' ) :
				$fullcssfile .= $tempcss;
			elseif ( $key === 'tab' ) :
				$fullcssfile .= '@media only screen and (min-width : 669px) and (max-width : 993px){';
				$fullcssfile .= $tempcss;
				$fullcssfile .= '}';
			elseif ( $key === 'mobile' ) :
				$fullcssfile .= '@media only screen and (max-width : 668px){';
				$fullcssfile .= $tempcss;
				$fullcssfile .= '}';
			endif;
		}
		$font = wp_json_encode( $this->font );
		global $wpdb;
		$this->wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->prefix . 'wpte_product_layout_style SET stylesheet = %s WHERE id = %d', $fullcssfile, $styleid ) );
		$this->wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->prefix . 'wpte_product_layout_style SET font_family = %s WHERE id = %d', $font, $styleid ) );
		exit;
	}

	/**
	 * Method secondary_menut
	 *
	 * @return void
	 */
	public function secondary_menut() {
		?>
		<div class="wpte-wpl-wrapper">
			<div class="wpte-wpl-row">
				<div class="wpte-product-container">
					<div class="wpte-col-top-lap-3 wpte-col-mob-1">
						<div class="wpte-card">
							<div class="wpte-card-info">
								<div class="wpte-card-heading">
									<span><?php echo esc_html__( 'Shortcode', 'wpte-product-layout' ); ?></span>
									<span class="dashicons dashicons-arrow-down card-icon-hide"></span>
									<span class="dashicons dashicons-arrow-right"></span>
								</div>
								<div class="wpte-card-body wpte-card-body-slider">
									<div class="wpte-single-page-shortcode">
										<?php
										$id = isset( $_GET['styleid'] ) ? sanitize_text_field( wp_unslash( $_GET['styleid'] ) ) : '';
										printf( '<b>%s</b>', esc_html__( 'Shortcode for posts/pages/plugins', 'wpte-product-layout' ) );
										printf( '<p>%s</p>', esc_html__( 'Copy & paste the shortcode directly into any WordPress post, page or Page Builder.', 'wpte-product-layout' ) );
										printf( '<input type="text" onclick="this.setSelectionRange(0, this.value.length)" value=\'[wpte_product_layout id="%1$s"]\'>', esc_attr( $id ) );
										?>
										<div class="wpte-single-page-php-shortcode">
											<?php
												printf( '<b>%s</b>', esc_html__( 'Shortcode for templates/themes', 'wpte-product-layout' ) );
												printf( '<p>%s</p>', esc_html__( 'Copy & paste this code into a template file to include the slideshow within your theme.', 'wpte-product-layout' ) );
												printf( '<input type="text" onclick="this.setSelectionRange(0, this.value.length)" value=\'<?php echo do_shortcode("[wpte_product_layout id=%1$s]"); ?>\'>', esc_attr( $id ) );
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="wpte-card">
							<div class="wpte-card-info">
								<div class="wpte-card-heading">
									<span><?php echo esc_html__( 'Shortcode Name', 'wpte-product-layout' ); ?></span>
									<span class="dashicons dashicons-arrow-down card-icon-hide"></span>
									<span class="dashicons dashicons-arrow-right"></span>
								</div>
								<div class="wpte-card-body wpte-card-body-slider">
									<div class="wpte-single-page-shortcode">
										<form class="wpte-change-shortcode-name" action="" method="post">
											<?php
												$shortcode_name = wpte_get_layout( $id ) ? wpte_get_layout( $id ) : (object) [];
											?>
											<input id="wpte-shortcode-name" type="text" value="<?php echo esc_html( $shortcode_name->name ); ?>">
											<input id="wpte-shortcode-name-id" type="hidden" value="<?php echo esc_html( $id ); ?>" >
											<button><?php echo esc_html__( 'Update', 'wpte-product-layout' ); ?></button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="wpte-card">
							<div class="wpte-card-info">
								<div class="wpte-card-heading">
									<span><?php echo esc_html__( 'Action', 'wpte-product-layout' ); ?></span>
									<span class="dashicons dashicons-arrow-down card-icon-hide"></span>
									<span class="dashicons dashicons-arrow-right"></span>
								</div>
								<div class="wpte-card-body wpte-card-body-slider">
									<div class="wpte-single-page-shortcode">
										<?php $layouts = isset( $_GET['layouts'] ) ? sanitize_text_field( wp_unslash( $_GET['layouts'] ) ) : ''; ?>
										<button class="wpte-single-page-export"><a href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts&layouts=' . $layouts . '&styleid=' . $id . '&action=export&id=' . $id . '' ) ); ?>"><?php echo esc_html__( 'EXPORT', 'wpte-product-layout' ); ?></a></button>
										<button class="wpte-single-page-import"> <a href="<?php echo esc_url( admin_url( 'admin.php?page=product-layouts-shortcode&action=import' ) ); ?>"><?php echo esc_html__( 'IMPORT', 'wpte-product-layout' ); ?></a></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Method wpte_editor_left_sidebar
	 *
	 * @return void
	 */
	public function wpte_editor_left_sidebar() {
		?>
		<aside id="wpte_setting_bar" data-visibale="true" class="ui-widget-content wpte-single-settings-card">
			<form id="wpte-editor-update-form" action="" method="POST">
				<div class="wpte-single-settings-card-header">
					<div>
						<?php echo esc_html__( 'Settings', 'wpte-product-layout' ); ?>
					</div>
					<div class="wpte-editor-avatar">
						<svg xmlns="http://www.w3.org/2000/svg" width="30" height="28" viewBox="0 0 24 24" >
							<path fill="currentColor" d="M21 11H3a1 1 0 0 1 0-2h18a1 1 0 0 1 0 2zm0-6H3a1 1 0 0 1 0-2h18a1 1 0 0 1 0 2zm0 12H3a1 1 0 0 1 0-2h18a1 1 0 0 1 0 2z"></path>
						</svg>
						<ul class="wpte-editor-dropdown-menu">
							<li class="wpte-editor-back">
								<a href="#" class="wpte-editor-go-back"><i class="wpte-icon icon-arrow-10"></i>Back</a>
							</li>
							<li>
								<a href="<?php echo esc_url( get_site_url() ); ?>"><span class="dashicons dashicons-admin-site-alt3"></span>Visit Site</a>
							</li>
							<li>
								<a href="<?php echo esc_url( admin_url() . 'admin.php?page=product-layouts' ); ?>"><span class="dashicons dashicons-wordpress"></span>Dashboard</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="wpte-single-settings-card-body">
					<div class="wpte-single-settings-card-body-wrapper">
						<div class="wpte-single-settings-card-body-inner">
							<?php
							$this->register_controls();
							$product_layouts_page = isset( $_GET['layouts'] ) && 'filter' !== $_GET['layouts'] ? true : false;
							if ( $product_layouts_page ) {
								?>
							<div class="wpte-layout-content-tabs" id="wpte-start-tabs-advanced">
								<?php echo esc_html( $this->wpte_advanced_controlers() ); ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="wpte-single-settings-card-footer">
					<input type="hidden" id="wpte-layouts-id" value="<?php echo esc_attr( $this->wpteid ); ?>">
					<button id="wpte-submit-editor-form" type="submit"><?php echo esc_html__( 'Save', 'wpte-product-layout' ); ?></button>
				</div>
			</form>
		</aside>
		<?php
	}

	/**
	 * Method wpte_single_layout_wraper
	 *
	 * @return mixed
	 */
	public function render() {
		$is_p = isset( $this->rawdata['status_po'] ) && $this->rawdata['status_po'] ? $this->rawdata['status_po'] : '';
		if ( 'p' === $is_p ) {
			if ( wpte_version_control() !== true ) {
				?>
				<div class="wpte-wpl-wrapper">
					<div class="wpte-wpl-row">
					<?php printf( '<h1>%s</h1>', esc_html__( 'Opps! Please upgrade!', 'wpte-product-layout' ) ); ?>
					</div>
				</div>
				<?php
				return false;
			}
		}
		?>
		<div class="wpte-editor-page">
			<div class="wpte-editor-left-sidebar">
				<?php $this->wpte_editor_left_sidebar(); ?>
				<span class="wpte-sidebar-toggler"><i class="wpte-icon icon-arrow-6"></i></span>
			</div>
			<div class="wpte-editor-content">
				<?php
				$this->secondary_menut();
				$this->wpte_singe_layout_preview();
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Method wpte_singe_layout_preview
	 *
	 * @return void
	 */
	public function wpte_singe_layout_preview() {
		?>
		<div class="wpte-wpl-wrapper">
			<div class="wpte-wpl-row">
				<div class="wpte-wpl-layout-preview">
					<div class="wpte-popup-display"></div>
					<div class="wpte-card">
						<div class="wpte-card-heading">
							<div class="wpte-single-layout-preview">
								<?php echo esc_html__( 'Preview', 'wpte-product-layout' ); ?>
							</div>
						</div>
						<div class="wpte-card-body" id="wpte-product-preview-data" template-wrapper="<?php echo esc_attr( $this->CSSWRAPPER ); ?>">
							<?php
							$clss = '\WPTE_PRODUCT_LAYOUT\Layouts\\' . ucfirst( $this->StyleName[0] ) . '\Frontend\Layout' . $this->StyleName[1];
							new $clss( $this->dbdata, 'admin' );
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
