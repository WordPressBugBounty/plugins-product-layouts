<?php

namespace WPTE_PRODUCT_LAYOUT\Includes\Admin\Pages\Layout_list;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require ABSPATH . 'wp-admin/includes/class-wp-links-list-table.php';
}
/**
 * Layouts_list Handler Class
 *
 * @since 1.0.0
 */
class Layouts_List extends \WP_List_Table {

	/**
	 * Plugin Constructor
	 *
	 * @return void
	 */
	public function __construct() {

		parent::__construct(
            [
				'singular' => 'layout',
				'plural'   => 'layouts',
				'ajax'     => false,
			]
        );
	}

	/**
	 * Message to show if no designation found
	 *
	 * @return void
	 */
	public function no_items() {
		esc_html_e( 'No Layout found', 'wpte-product-layout' );
	}

	/**
	 * Get the column names
	 *
	 * @return array
	 */
	public function get_columns() {
		return [
			'cb'         => '<input type="checkbox" />',
			'name'       => __( 'Name', 'wpte-product-layout' ),
			'style_name' => __( 'Templates', 'wpte-product-layout' ),
			'id'         => __( 'Shortcode', 'wpte-product-layout' ),
		];
	}

	/**
	 * Default column values
	 *
	 * @param object $item .
	 * @param string $column_name .
	 * @return string
	 */
	protected function column_default( $item, $column_name ) {

		if ( $column_name ) {
			return isset( $item->$column_name ) ? $item->$column_name : '';
		}
	}

	/**
	 * Dispaly Checkbox
	 *
	 * @param object $item .
	 * @return input
	 */
	protected function column_cb( $item ) {
		return sprintf( '<input type="checkbox" class="wpte-shortcode-check" name="layout_id[]" value="%d"', $item->id );
	}

	/**
	 * Dispaly Name
	 *
	 * @param object $item .
	 * @return url
	 */
	protected function column_name( $item ) {

		$style_name = explode( '-', $item->style_name );

		$actions           = [];
		$actions['id']     = sprintf( '<span style="color:#a0a0a4">ID: %s</span>', $item->id );
		$actions['edit']   = sprintf( '<a href="%s">%s</a>', admin_url( "admin.php?page=product-layouts&layouts=$style_name[0]&styleid=$item->id" ), __( 'Edit', 'wpte-product-layout' ), __( 'Edit', 'wpte-product-layout' ) );
		$actions['clone']  = sprintf( '<a class="wpte-shortcode-clone" href="" datavalue="%1$s" layouts-data="wptestyle%1$sdata">%2$s</a>', $item->id, __( 'Clone', 'wpte-product-layout' ), __( 'Clone', 'wpte-product-layout' ) );
		$actions['export'] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=product-layouts-shortcode&action=export&id=' . $item->id ), __( 'Export', 'wpte-product-layout' ), __( 'Export', 'wpte-product-layout' ) );
		$actions['delete'] = sprintf( '<a href="%s" class="wptesubmitdelete" layoutid="%s">%s</a>', __( 'Delete', 'wpte-product-layout' ), $item->id, __( 'Delete', 'wpte-product-layout' ) );

		$adminUrl = admin_url( "admin.php?page=product-layouts&layouts=$style_name[0]&styleid=$item->id" );
		return sprintf( '<a href="%1$s">%2$s</a>%3$s', $adminUrl, $item->name, $this->row_actions( $actions ) );
	}

	/**
	 * Column Style Name
	 *
	 * @param object $item .
	 * @return data
	 */
	public function column_style_name( $item ) {
		$styleName = $item->style_name;
		$data      = str_replace( '-', ' ', $styleName );
		return sprintf( '%s', ucfirst( $data ) );
	}

	/**
	 * Column Id
	 *
	 * @param object $item .
	 * @return mixed
	 */
	public function column_id( $item ) {
		return sprintf(
            '
			%2$s <input type="text" onclick="this.setSelectionRange(0, this.value.length)" value=\'[wpte_product_layout id="%1$s"]\'>
			<br>%3$s  &nbsp;<input type="text" onclick="this.setSelectionRange(0, this.value.length)" value=\'<?php echo do_shortcode("[wpte_product_layout id=%1$s]"); ?>\'
		>', $item->id, esc_html__( 'Shortcode', 'wpte-product-layout' ), esc_html__( 'Php Code', 'wpte-product-layout' )
        );
	}

	/**
	 * Get sortable columns
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = [
			'name'       => [ 'name', true ],
			'style_name' => [ 'style_name', true ],
		];

		return $sortable_columns;
	}

	/**
	 * Set the bulk actions
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = [
			'delete' => __( 'Delete Permanently', 'wpte-product-layout' ),
		];

		return $actions;
	}

	/**
	 * Method extra_tablenav
	 *
	 * @param mixed $which .
	 * @return void
	 */
	public function extra_tablenav( $which ) {
		$per_page_number = isset( $_GET['show_per_page'] ) ? sanitize_text_field( wp_unslash( $_GET['show_per_page'] ) ) : 7;
		$page            = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
		printf( '<span>%s</span>', esc_html__( 'Show', 'wpte-product-layout' ) );
		echo ' <form id="show_per_page_form" action="" method="post">
					<input id="show_per_page" type="number" name="show_per_page" value="' . esc_attr( $per_page_number ) . '">
					<input type="hidden" name="page" value="' . esc_attr( $page ) . '">
					<input type="submit" id="per_page_submit" class="button action" value="Submit">
				</form>
		';
	}

	/**
	 * Get Search Value from DB
	 *
	 * @param object $item .
	 * @return bol
	 */
	public function get_search_value( $item ) {
		$name = strtolower( $item['name'] );
		$id   = $item['id'];
		$data = isset( $_REQUEST['s'] ) ? strtolower( sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) ) : '';
		if ( strpos( $name, $data ) !== false || strpos( $id, $data ) !== false ) {
			return true;
		}
		return false;
	}

	/**
	 * Prepare the Product Layouts
	 *
	 * @return void
	 */
	public function prepare_items() {
		$column   = $this->get_columns();
		$hidden   = [];
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = [ $column, $hidden, $sortable ];

		$per_page_number = isset( $_GET['show_per_page'] ) && ! empty( $_GET['show_per_page'] ) ? intval( wp_unslash( $_GET['show_per_page'] ) ) : 7;

		$per_page = $per_page_number;
		$current_page = $this->get_pagenum();
		$offset = ( $current_page - 1 ) * $per_page;

		$args = [
			'number' => $per_page,
			'offset' => $offset,
		];

		if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
			$args['orderby'] = sanitize_text_field( wp_unslash( $_REQUEST['orderby'] ) );
			$args['order'] = sanitize_text_field( wp_unslash( $_REQUEST['order'] ) );
		}

		if ( isset( $_REQUEST['s'] ) && ! empty( $_REQUEST['s'] ) ) {
			$data = wpte_get_product_layouts( $args );
			$data = json_decode( wp_json_encode( $data ), true );
			$data = array_filter( $data, [ $this, 'get_search_value' ] );
			$data = json_decode( wp_json_encode( $data ) );
		} else {
			$data = wpte_get_product_layouts( $args );
		}

		$this->items = $data;

		$this->set_pagination_args(
            [
				'total_items' => wpte_product_layouts_count(),
				'per_page'    => $per_page,
			]
        );
	}
}
