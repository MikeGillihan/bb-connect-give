<?php
if ( $settings->select_form_field ) {
	$show_content = isset( $settings->show_content )
		? $settings->show_content
		: get_post_meta( $settings->select_form_field, '_give_content_option', true );

	$display_style = isset( $settings->display_style )
		? $settings->display_style
		: get_post_meta( $settings->select_form_field, '_give_payment_display', true );

	$float_labels = isset( $settings->float_labels )
		? $settings->float_labels
		: get_post_meta( $settings->select_form_field, '_give_form_floating_labels', true );

	$give_form = sprintf( '[give_form id="%s" show_title="%s" show_goal="%s" show_content="%s" display_style="%s" float_labels="%s"]',
		$settings->select_form_field,
		$settings->show_title,
		$settings->show_goal,
		$show_content,
		$display_style,
		$float_labels
	);

	echo do_shortcode( $give_form );
}