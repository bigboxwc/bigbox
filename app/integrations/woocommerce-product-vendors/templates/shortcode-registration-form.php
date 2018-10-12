<?php
/**
 * Vendor Registration Form Template
 *
 * @version 2.0.0
 *
 * @since 1.14.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
// phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash
?>

<form class="wcpv-shortcode-registration-form">

	<?php do_action( 'wcpv_registration_form_start' ); ?>

	<?php if ( ! is_user_logged_in() ) { ?>
		<p class="form-row form-row-first">
			<label for="wcpv-firstname"><?php esc_html_e( 'First Name', 'bigbox' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="firstname" id="wcpv-firstname" value="<?php echo esc_attr( ! empty( $_POST['firstname'] ) ? trim( $_POST['firstname'] ) : null ); ?>" tabindex="1" />
		</p>

		<p class="form-row form-row-last">
			<label for="wcpv-lastname"><?php esc_html_e( 'Last Name', 'bigbox' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="lastname" id="wcpv-lastname" value="<?php echo esc_attr( ! empty( $_POST['lastname'] ) ? trim( $_POST['lastname'] ) : null ); ?>" tabindex="2" />
		</p>

		<div class="clear"></div>

		<p class="form-row form-row-wide">
			<label for="wcpv-username"><?php esc_html_e( 'Login Username', 'bigbox' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="username" id="wcpv-username" value="<?php echo esc_attr( ! empty( $_POST['username'] ) ? trim( $_POST['username'] ) : null ); ?>" tabindex="3" />
		</p>

		<p class="form-row form-row-first">
			<label for="wcpv-email"><?php esc_html_e( 'Email', 'bigbox' ); ?> <span class="required">*</span></label>
			<input type="email" class="input-text" name="email" id="wcpv-email" value="<?php echo esc_attr( ! empty( $_POST['email'] ) ? trim( $_POST['email'] ) : null ); ?>" tabindex="4" />
		</p>

		<p class="form-row form-row-last">
			<label for="wcpv-confirm-email"><?php esc_html_e( 'Confirm Email', 'bigbox' ); ?> <span class="required">*</span></label>
			<input type="email" class="input-text" name="confirm_email" id="wcpv-confirm-email" value="<?php echo esc_attr( ! empty( $_POST['confirm_email'] ) ? trim( $_POST['confirm_email'] ) : null ); ?>" tabindex="5" />
		</p>

		<div class="clear"></div>

	<?php } ?>

	<p class="form-row form-row-wide">
		<label for="wcpv-vendor-vendor-name"><?php esc_html_e( 'Vendor Name', 'bigbox' ); ?> <span class="required">*</span></label>
		<input class="input-text" type="text" name="vendor_name" id="wcpv-vendor-name" value="<?php echo esc_attr( ! empty( $_POST['vendor_name'] ) ? trim( $_POST['vendor_name'] ) : null ); ?>" tabindex="6" />
		<em class="wcpv-field-note"><?php esc_html_e( 'Important: This is the name that customers see when purchasing your products.  Please choose carefully.', 'bigbox' ); ?></em>
	</p>

	<p class="form-row form-row-wide">
		<label for="wcpv-vendor-description"><?php esc_html_e( 'Please describe something about your company and what you sell.', 'bigbox' ); ?> <span class="required">*</span></label>
		<textarea class="input-text" name="vendor_description" id="wcpv-vendor-description" rows="4" tabindex="7">
<?php
if ( ! empty( $_POST['vendor_description'] ) ) :
	echo esc_textarea( $_POST['vendor_description'] );
endif;
?>
		</textarea>
	</p>

	<?php do_action( 'wcpv_registration_form' ); ?>

	<p class="form-row">
		<input type="submit" class="button" name="register" value="<?php esc_attr_e( 'Register', 'bigbox' ); ?>" tabindex="8" />
	</p>

	<?php do_action( 'wcpv_registration_form_end' ); ?>

</form>
