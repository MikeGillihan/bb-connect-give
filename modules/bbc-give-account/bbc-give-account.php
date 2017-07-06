<?php

/**
 * @class  BBC_Give_Account
 * @since  2.0
 * @credit The Beaver Builder (https://beaverbuilder.com) team for the Tabs module which is what we based  this upon and the team at UABB (https://www.ultimatebeaver.com) for their clever implementation of toggle fields.
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

	/**
	 * Return the Subscription Tab settings if Give Recurring is active
	 *
	 * @return array
	 */
	public static function bbc_do_subscriptions() {
		if ( !class_exists( 'Give_Recurring' ) ) {
			return;
		}

		$settings = array(
			'type'        => 'bbc-toggle',
			'label'       => __( 'Subscriptions', 'bbc-give' ),
			'description' => '',
			'default'     => 'false',
			'options'     => array(
				'true'  => __( 'Show', 'bbc-give' ),
				'false' => __( 'Hide', 'bbc-give' ),
			),
			'help'    => __( 'Displays the Subscriptions tab. Default is “Hide”', 'bbc-give' )
		);

		return $settings;
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
					'profile'       => array(
						'type'        => 'bbc-toggle',
						'label'       => __( 'Profile Editor', 'bbc-give' ),
						'description' => '',
						'default'     => 'true',
						'options'     => array(
							'true'  => __( 'Show', 'bbc-give' ),
							'false' => __( 'Hide', 'bbc-give' ),
						),
						'help'    => __( 'Displays the Profile Editor tab. Default is “Show”', 'bbc-give' )
					),
					'history'       => array(
						'type'        => 'bbc-toggle',
						'label'       => __( 'Donation History', 'bbc-give' ),
						'description' => '',
						'default'     => 'true',
						'options'     => array(
							'true'  => __( 'Show', 'bbc-give' ),
							'false' => __( 'Hide', 'bbc-give' ),
						),
						'help'    => __( 'Displays the Donation History tab. Default is “Show”', 'bbc-give' )
					),
					'subscriptions' => BBC_Give_Account::bbc_do_subscriptions(),
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