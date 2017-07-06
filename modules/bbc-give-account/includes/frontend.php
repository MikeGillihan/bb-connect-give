<?php
global $wp_embed;

$static_tabs = array(
	'profile' => array(
		'id'      => 'profile',
		'label'   => 'Donor Profile',
		'enabled' => 'true' == $settings->profile,
		'shortcode' => '[give_profile_editor]'
	),
	'history' => array(
		'id'      => 'history',
		'label'   => 'Donation History',
		'enabled' => 'true' == $settings->history,
		'shortcode' => '[donation_history]'
	),
	'subscriptions' => array(
		'id'      => 'subscriptions',
		'label'   => 'Subscriptions',
		'enabled' => 'true' == $settings->subscriptions,
		'shortcode' => '[give_subscriptions]'
	),
);
?>
<div class="bbc-tabs bbc-tabs-<?php echo $settings->layout; ?> fl-clearfix">
	<?php if ( $settings->title ) : ?>
        <h3 class="bbc-tabs-title"><?php echo $settings->title ?></h3>
	<?php endif; ?>

    <div class="bbc-tabs-labels fl-clearfix" role="tablist">

		<?php // Static Tabs ?>
		<?php $offset_counter = 0; ?>
		<?php foreach ( $static_tabs as $tab => $tab_settings ) : ?>
			<?php if ( $tab_settings['enabled'] ) : ?>
                <div class="bbc-tabs-label<?php echo $offset_counter == 0 ? ' bbc-tab-active' : ''; ?>"
                     id="<?php echo 'bbc-tabs-' . $module->node . '-label-' . $offset_counter; ?>"
                     data-index="<?php echo $offset_counter ?>"
                     aria-selected="<?php echo $offset_counter == 0 ? 'true' : 'false'; ?>"
                     aria-controls="<?php echo 'bbc-tabs-' . $module->node . '-panel-' . $offset_counter; ?>"
                     aria-expanded="<?php echo $offset_counter == 0 ? 'true' : 'false'; ?>"
                     role="tab"
                     tabindex="0">
					<?php echo $tab_settings['label']; ?>
                </div>
				<?php $offset_counter ++; ?>
			<?php endif; ?>
		<?php endforeach; ?>

		<?php // Dynamic Tabs ?>
		<?php for ( $i = 0; $i < count( $settings->tabs ); $i ++ ) : if ( ! is_object( $settings->tabs[ $i ] ) ) {
			continue;
		} ?>
			<?php $offset = $i + $offset_counter; ?>
            <div class="bbc-tabs-label<?php if ( $offset == 0 ) {
				echo ' bbc-tab-active';
			} ?>" id="<?php echo 'bbc-tabs-' . $module->node . '-label-' . $offset; ?>"
                 data-index="<?php echo $offset; ?>"
                 aria-selected="<?php echo ( $offset > 0 ) ? 'false' : 'true'; ?>"
                 aria-controls="<?php echo 'bbc-tabs-' . $module->node . '-panel-' . $offset; ?>"
                 aria-expanded="<?php echo ( $offset > 0 ) ? 'false' : 'true'; ?>"
                 role="tab"
                 tabindex="0">
				<?php echo $settings->tabs[ $i ]->label; ?>
            </div>
		<?php endfor; ?>
    </div>

    <div class="bbc-tabs-panels fl-clearfix">

		<?php // Static Tab Panels ?>
		<?php $offset_counter = 0; ?>
		<?php foreach ( $static_tabs as $tab => $tab_settings ) : ?>
			<?php if ( $tab_settings['enabled'] ) : ?>

                <div class="bbc-tabs-panel">
                    <div class="bbc-tabs-label bbc-tabs-panel-label<?php echo $offset_counter == 0 ? ' bbc-tab-active' : ''; ?>"
                         data-index="<?php echo $offset_counter ?>" tabindex="0">
                        <span><?php echo $tab_settings['label']; ?></span>
                        <i class="fa>"></i>
                    </div>
                    <div class="bbc-tabs-panel-content fl-clearfix<?php echo $offset_counter == 0 ? ' bbc-tab-active' : ''; ?>"
                         id="<?php echo 'bbc-tabs-' . $module->node . '-panel-' . $offset_counter; ?>"
                         data-index="<?php echo $offset_counter ?>"
						<?php echo $offset_counter > 0 ? 'aria-hidden="true"' : ''; ?>
                         aria-labelledby="<?php echo 'bbc-tabs-' . $module->node . '-label-' . $offset_counter; ?>"
                         role="tabpanel"
                         aria-live="polite">
						<?php echo do_shortcode( $tab_settings['shortcode'] ); ?>
                    </div>
                </div>

				<?php $offset_counter ++; ?>
			<?php endif; ?>
		<?php endforeach; ?>

		<?php // Dynamic Tab Panels ?>
		<?php for ( $i = 0; $i < count( $settings->tabs ); $i ++ ) : if ( ! is_object( $settings->tabs[ $i ] ) ) {
			continue;
		} ?>

			<?php $offset = $i + $offset_counter; ?>
            <div class="bbc-tabs-panel"<?php if ( ! empty( $settings->id ) ) {
				echo ' id="' . sanitize_html_class( $settings->id ) . '-' . $offset . '"';
			} ?>>
                <div class="bbc-tabs-label bbc-tabs-panel-label<?php if ( $offset == 0 ) {
					echo ' bbc-tab-active';
				} ?>" data-index="<?php echo $offset; ?>" tabindex="0">
                    <span><?php echo $settings->tabs[ $i ]->label; ?></span>
                    <i class="fa<?php if ( $offset > 0 ) {
						echo ' fa-plus';
					} ?>"></i>
                </div>
                <div class="bbc-tabs-panel-content fl-clearfix<?php if ( $offset == 0 ) {
					echo ' bbc-tab-active';
				} ?>" id="<?php echo 'bbc-tabs-' . $module->node . '-panel-' . $offset; ?>"
                     data-index="<?php echo $offset; ?>"<?php if ( $offset > 0 ) {
					echo ' aria-hidden="true"';
				} ?> aria-labelledby="<?php echo 'bbc-tabs-' . $module->node . '-label-' . $offset; ?>" role="tabpanel"
                     aria-live="polite">
					<?php echo wpautop( $wp_embed->autoembed( $settings->tabs[ $i ]->content ) ); ?>
                </div>
            </div>
		<?php endfor; ?>
    </div>

</div>