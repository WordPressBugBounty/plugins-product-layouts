( function ( blocks, element, components, serverSideRender, blockEditor ) {
	'use strict';

	var el                = element.createElement;
	var Fragment          = element.Fragment;
	var SelectControl     = components.SelectControl;
	var Placeholder       = components.Placeholder;
	var Spinner           = components.Spinner;
	var ServerSideRender  = serverSideRender;
	var useBlockProps     = blockEditor.useBlockProps;
	var InspectorControls = blockEditor.InspectorControls;
	var PanelBody         = components.PanelBody;

	// ── Build the plugin icon from the base64 data URI passed from PHP ──────────
	var blockIcon = 'layout'; // fallback dashicons name
	if ( window.wpteBlockData && window.wpteBlockData.iconUri ) {
		blockIcon = el(
			'img',
			{
				src:    window.wpteBlockData.iconUri,
				width:  24,
				height: 24,
				alt:    'Product Layouts',
				style:  { display: 'block', objectFit: 'contain' },
			}
		);
	}

	blocks.registerBlockType( 'product-layouts/product-layouts', {

		icon: blockIcon,

		edit: function ( props ) {
			var blockProps = useBlockProps( { className: 'wpte-gutenberg-block-wrap' } );
			var layouts    = ( window.wpteBlockData && window.wpteBlockData.layouts ) ? window.wpteBlockData.layouts : [];
			var editUrl    = ( window.wpteBlockData && window.wpteBlockData.editUrls && props.attributes.layoutId )
				? window.wpteBlockData.editUrls[ props.attributes.layoutId ]
				: '';
			var i18n       = ( window.wpteBlockData && window.wpteBlockData.i18n ) ? window.wpteBlockData.i18n : {};
			var options    = [ { value: '', label: '— ' + ( i18n.selectLayout || 'Select a Layout' ) + ' —' } ].concat( layouts );

			var inspectorPanel = el(
				InspectorControls,
				{},
				el(
					PanelBody,
					{ title: 'Product Layouts', initialOpen: true },
					el( SelectControl, {
						label:    i18n.selectLayout || 'Select Layout',
						value:    props.attributes.layoutId,
						options:  options,
						onChange: function ( val ) {
							props.setAttributes( { layoutId: val } );
						},
					} ),
					( props.attributes.layoutId && editUrl )
						? el(
							'a',
							{
								href:   editUrl,
								target: '_blank',
								rel:    'noreferrer',
								style:  {
									display:        'inline-flex',
									alignItems:     'center',
									gap:            '6px',
									marginTop:      '10px',
									padding:        '7px 14px',
									background:     '#6d59ef',
									color:          '#fff',
									borderRadius:   '4px',
									textDecoration: 'none',
									fontSize:       '13px',
									fontWeight:     '600',
								},
							},
							'✏ ' + ( i18n.editLayout || 'Edit Layout' )
						  )
						: null
				)
			);

			// ── No layout selected yet → show Placeholder ───────────────────────
			if ( ! props.attributes.layoutId ) {
				return el(
					Fragment,
					{},
					inspectorPanel,
					el(
						'div',
						blockProps,
						el(
							Placeholder,
							{
								icon:         blockIcon,
								label:        'Product Layouts for WooCommerce',
								instructions: i18n.placeholder || 'Select a saved layout to display products.',
							},
							el( SelectControl, {
								value:    props.attributes.layoutId,
								options:  options,
								onChange: function ( val ) {
									props.setAttributes( { layoutId: val } );
								},
								style: { maxWidth: '320px', marginTop: '8px' },
							} )
						)
					)
				);
			}

			// ── Layout selected → show ServerSideRender preview ─────────────────
			return el(
				Fragment,
				{},
				inspectorPanel,
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block:      'product-layouts/product-layouts',
						attributes: props.attributes,
						LoadingResponsePlaceholder: function () {
							return el(
								'div',
								{ style: { padding: '40px', textAlign: 'center' } },
								el( Spinner )
							);
						},
					} )
				)
			);
		},

		save: function () {
			return null; // server-side rendered
		},
	} );

} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.components,
	window.wp.serverSideRender,
	window.wp.blockEditor
);
