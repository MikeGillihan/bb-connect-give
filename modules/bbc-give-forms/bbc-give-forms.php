<?php

/**
 * This is the basic Give Donation Form module.
 *
 * @class BBC_Give_Forms
 * @since 1.0
 */
class BBC_Give_Forms extends FLBuilderModule {

	/**
	 * Constructor function for the module.
	 *
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct( array(
			'name'          => __( 'Donation Form', 'bbc-give' ),
			'description'   => __( 'Add your Give Donation Form Goal to your page.', 'bbc-give' ),
			'category'      => __( 'Give Modules', 'bbc-give' ),
			'dir'           => BBC_GIVE_DIR . 'modules/bbc-give-forms/',
			'url'           => BBC_GIVE_DIR . 'modules/bbc-give-forms/',
			'editor_export' => true, // Defaults to true and can be omitted.
			'enabled'       => true, // Defaults to true and can be omitted.
		) );
	}

	/**
	 * Get all GiveWP donation forms
	 *
	 * @return array List of GiveWP forms
	 */
	public static function list_forms() {
		$list = array( '' => __( 'Select a Form', 'bbc-give' ) );

		$forms = get_posts( array(
			'post_type'      => 'give_forms',
			'posts_per_page' => - 1,
		) );

		foreach ( $forms as $form ) {
			$list[ $form->ID ] = $form->post_title;
		}

		return $list;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module( 'BBC_Give_Forms', array(
	'form' => array( // Tab
		'title'    => __( 'General', 'bbc-give' ), // Tab title
		'sections' => array( // Tab Sections
			'select_form' => array( // Section
				'title'  => '', // Section Title
				'fields' => array( // Section Fields
					'select_form_field' => array(
						'type'    => 'select',
						'label'   => __( 'Select Form', 'bbc-give' ),
						'default' => '',
						'options' => BBC_Give_Forms::list_forms()
					),
				)
			),
			'form_settings' => array( // Section
				'title'  => '', // Section Title
				'fields' => array( // Section Fields
					'show_title'        => array(
						'type'        => 'bbc-toggle',
						'label'       => __( 'Show Title', 'bbc-give' ),
						'default'     => 'true',
						'options'     => array(
							'true'  => __( 'Show', 'bbc-give' ),
							'false' => __( 'Hide', 'bbc-give' ),
						),
						'help'    => __( 'Show/hide the form title. Default is “show”', 'bbc-give' )
					),
					'show_goal'         => array(
						'type'        => 'bbc-toggle',
						'label'       => __( 'Show Goal', 'bbc-give' ),
						'default'     => 'false',
						'options'     => array(
							'true'  => __( 'Show', 'bbc-give' ),
							'false' => __( 'Hide', 'bbc-give' ),
						),
						'help'    => __( 'Show/hide the form goal. Default is “hide”', 'bbc-give' )
					),
					'show_content'      => array(
						'type'    => 'select',
						'label'   => __( 'Show Content', 'bbc-give' ),
						'default' => 'default',
						'options' => array(
							'default' => 'Use default setting',
							'none'    => 'No Content',
							'above'   => 'Display content ABOVE the fields.',
							'below'   => 'Display content BELOW the fields.'
						),
						'help'    => __( 'Show/hide the form content. You can choose from None, Below, or Above. This will override the default settings of the form. The Default value is whatever you chose when you created the form.', 'bbc-give' )
					),
					'display_style'     => array(
						'type'    => 'select',
						'label'   => __( 'Display Style', 'bbc-give' ),
						'default' => 'default',
						'options' => array(
							'default' => 'Use default setting',
							'onpage'  => 'Show on page.',
							'reveal'  => 'Reveal on click.',
							'modal'   => 'Popup on click',
							'button'  => 'Button Only',
						),
						'help'    => __( 'Override the setting you set when you created the form. You can choose from “Show on Page”, “Reveal on Click”, or “Modal Window on Click”, or “Button only”.', 'bbc-give' )
					),
					'float_labels'      => array(
						'type'    => 'select',
						'label'   => __( 'Floating Labels', 'bbc-give' ),
						'default' => 'default',
						'options' => array(
							'default'  => 'Use default setting',
							'enabled'  => 'Enabled',
							'disabled' => 'Disabled',
						),
						'help'    => __( 'Enable/disable Floating labels. The default is whatever you chose when you created the form. This setting overrides that default.', 'bbc-give' )
					),
				)
			)
		)
	)
) );