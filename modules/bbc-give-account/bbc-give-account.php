<?php

/**
 * @class BBC_Give_Account
 * @since 2.0
 */
class BBC_Give_Account extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Account Details', 'bbc-give' ),
			'description'     => __( 'Display a tabbed view of Donor Account details.', 'bbc-give' ),
			'category'        => __( 'Give Modules', 'bbc-give' ),
			'partial_refresh' => true
		) );

		$this->add_css( 'font-awesome' );
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module( 'BBC_Give_Account', array(
	'tabs'  => array(
		'title'    => __( 'Tabs', 'bbc-give' ),
		'sections' => array(
			'general'      => array(
				'title'  => '',
				'fields' => array(
					'title' => array(
						'type'        => 'text',
						'label'       => __( 'Title', 'bbc-give' ),
						'default'     => __( 'Account Details', 'bbc-give' ),
						'placeholder' => __( 'Placeholder text', 'fl-builder' ),
						'class'       => 'bbc-give-account-title',
					),
				)
			),
			'static_tabs'  => array(
				'title'  => '',
				'fields' => array(
					'profile' => array(
						'type'        => 'bbc-toggle',
						'label'       => __( 'Donor Profile', 'bbc-give' ),
						'description' => '',
						'default'     => 'true',
						'options'     => array(
							'true'  => __( 'Show', 'bbc-give' ),
							'false' => __( 'Hide', 'bbc-give' ),
						),
					),
					'history' => array(
						'type'        => 'bbc-toggle',
						'label'       => __( 'Donation History', 'bbc-give' ),
						'description' => '',
						'default'     => 'true',
						'options'     => array(
							'true'  => __( 'Show', 'bbc-give' ),
							'false' => __( 'Hide', 'bbc-give' ),
						),
					),
				)
			),
			'dynamic_tabs' => array(
				'title'  => 'Additional Tabs',
				'fields' => array(
					'tabs' => array(
						'type'         => 'form',
						'label'        => __( 'Tab', 'bbc-give' ),
						'form'         => 'tabs_form', // ID from registered form below
						'preview_text' => 'label', // Name of a field to use for the preview text
						'multiple'     => true
					),
				)
			)
		)
	),
	'style' => array(
		'title'    => __( 'Style', 'bbc-give' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'layout'       => array(
						'type'    => 'select',
						'label'   => __( 'Layout', 'bbc-give' ),
						'default' => 'horizontal',
						'options' => array(
							'horizontal' => __( 'Horizontal', 'bbc-give' ),
							'vertical'   => __( 'Vertical', 'bbc-give' ),
						)
					),
					'border_color' => array(
						'type'    => 'color',
						'label'   => __( 'Border Color', 'bbc-give' ),
						'default' => 'e5e5e5'
					),
				)
			)
		)
	)
) );

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form( 'tabs_form', array(
	'title' => __( 'Add Item', 'bbc-give' ),
	'tabs'  => array(
		'general' => array(
			'title'    => __( 'General', 'bbc-give' ),
			'sections' => array(
				'general' => array(
					'title'  => '',
					'fields' => array(
						'label' => array(
							'type'        => 'text',
							'label'       => __( 'Label', 'bbc-give' ),
							'connections' => array( 'string' )
						)
					)
				),
				'content' => array(
					'title'  => __( 'Content', 'bbc-give' ),
					'fields' => array(
						'content' => array(
							'type'        => 'editor',
							'label'       => '',
							'wpautop'     => false,
							'connections' => array( 'string' )
						)
					)
				)
			)
		)
	)
) );