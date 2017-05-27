<?php

/**
 * The Give Donation Form Goal module.
 *
 * @class BBC_Give_Goal
 */
class BBC_Give_Goal extends FLBuilderModule {

	/**
	 * Constructor function for the module.
	 *
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct( array(
			'name'        => __( 'Donation Form Goal', 'bbc-give' ),
			'description' => __( 'Add your Give Donation Form Goal to your page.', 'bbc-give' ),
			'category'    => __( 'Give Modules', 'bbc-give' ),
			'dir'         => BBC_GIVE_DIR . 'modules/bbc-give-goal/',
			'url'         => BBC_GIVE_DIR . 'modules/bbc-give-goal/',
		) );
	}

	/**
	 * Get all GiveWP donation forms
	 *
	 * @return array List of GiveWP forms
	 */
	public static function list_forms() {
		$list = array( '' => __( 'None', 'bbc-give' ) );

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
FLBuilder::register_module( 'BBC_Give_Goal', array(
	'form' => array(
		'title'    => __( 'General', 'bbc-give' ),
		'sections' => array(
			'select_form' => array(
				'title'  => '',
				'fields' => array(
					'select_form_field' => array(
						'type'    => 'select',
						'label'   => __( 'Select Form', 'bbc-give' ),
						'default' => '',
						'options' => BBC_Give_Goal::list_forms()
					),
					'show_text'         => array(
						'type'    => 'select',
						'label'   => __( 'Show Text', 'bbc-give' ),
						'default' => 'true',
						'options' => array(
							'true'  => 'Show',
							'false' => 'Hide'
						)
					),
					'show_bar'          => array(
						'type'    => 'select',
						'label'   => __( 'Show Progress Bar', 'bbc-give' ),
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