<div class="bbc-give-goal">
	<?php
	if ( $settings->select_form_field ) {

		$give_goal = sprintf( '[give_goal id="%s" show_text="%s" show_bar="%s"]',
			$settings->select_form_field,
			$settings->show_text,
			$settings->show_bar
		);

		echo do_shortcode( $give_goal );
	}
	?>
</div>
