<?php

/**
 * This is the basic Give Donation Form module.
 *
 * @class BBB_Give_Goal
 */
class BBB_Give_Goal extends FLBuilderModule {

	/**
	 * Constructor function for the module.
	 *
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct( array(
			'name'          => __( 'Donation Form Goal', 'bbb-give' ),
			'description'   => __( 'Add your Give Donation Form Goal to your page.', 'bbb-give' ),
			'category'      => __( 'Give Modules', 'bbb-give' ),
			'dir'           => BBB_GIVE_DIR . 'modules/bbb-give-goal/',
			'url'           => BBB_GIVE_DIR . 'modules/bbb-give-goal/',
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
		$list = array( '' => __( 'None', 'bbb-give' ) );

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
FLBuilder::register_module( 'BBB_Give_Goal', array(
	'form' => array( // Tab
		'title'    => __( 'General', 'bbb-give' ), // Tab title
		'sections' => array( // Tab Sections
			'select_form' => array( // Section
				'title'  => '', // Section Title
				'fields' => array( // Section Fields
					'select_form_field' => array(
						'type'    => 'select',
						'label'   => __( 'Select Form', 'bbb-give' ),
						'default' => '',
						'options' => BBB_Give_Goal::list_forms()
					),
					'show_text'        => array(
						'type'    => 'select',
						'label'   => __( 'Show Text', 'bbb-give' ),
						'default' => 'true',
						'options' => array(
							'true'  => 'Show',
							'false' => 'Hide'
						)
					),
					'show_bar'         => array(
						'type'    => 'select',
						'label'   => __( 'Show Progress Bar', 'bbb-give' ),
						'default' => 'true',
						'options' => array(
							'true'  => 'Show',
							'false' => 'Hide'
						)
					),
				)
			)
		)
	)
) );