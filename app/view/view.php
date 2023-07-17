<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
$random_id = 'newsletter-wp-plugin-agreement-' . rand( 1, 1000000 );
?>

<div class="newsletter-wp-plugin">
	<?php if ( ! empty( $args['title'] ) ) : ?>
		<h3><?php echo esc_html( $args['title'] ); ?></h3>
	<?php endif; ?>

	<form method="post" class="newsletter-wp-plugin__form">
		<div class="newsletter-wp-plugin__form-left">
			<div class="newsletter-wp-plugin__form-left-top">
				<input
					type="email"
					name="email"
					placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
					required class="newsletter-wp-plugin__input"
				>
			</div>

			<?php if ( ! empty( $args['agreement_text'] ) ) : ?>
				<div class="newsletter-wp-plugin__form-left-bottom">
					<input
						type="checkbox"
						name="agreement"
						class="newsletter-wp-plugin__checkbox"
						required
						id="<?php echo $random_id; ?>"
					>
					<label for="<?php echo $random_id; ?>" class="newsletter-wp-plugin__agreement">
						<?php echo esc_html( $args['agreement_text'] ); ?>
					</label>
				</div>
			<?php endif; ?>
			<input type="hidden" name="action" value="newsletter_wp_plugin_subscribe">
			<?php wp_nonce_field( 'newsletter_wp_plugin_subscribe', 'nonce' ); ?>
		</div>

		<div class="newsletter-wp-plugin__form-right">
			<?php if ( ! empty( $args['button_title'] ) ) : ?>
				<button class="newsletter-wp-plugin__button"><?php echo esc_html( $args['button_title'] ); ?></button>
			<?php endif; ?>
		</div>
	</form>

	<div class="newsletter-wp-plugin__messages">
		<div class="newsletter-wp-plugin__errors">
			<div class="newsletter-wp-plugin__error newsletter-wp-plugin__error--email">
				<?php _e( 'Please enter a valid email address.', 'dp' ); ?>
			</div>
			<div class="newsletter-wp-plugin__error newsletter-wp-plugin__error--agreement">
				<?php _e( 'Please accept the agreement.', 'dp' ); ?>
			</div>
			<div class="newsletter-wp-plugin__error newsletter-wp-plugin__error--server">
				<?php _e( 'Internal server error, please try again later.', 'dp' ); ?>
			</div>
		</div>

		<div class="newsletter-wp-plugin__success">
			<?php _e( 'Thank you for subscribing!', 'dp' ); ?>
		</div>
	</div>
</div>
