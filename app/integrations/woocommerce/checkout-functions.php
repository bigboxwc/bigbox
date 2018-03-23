<?php
/**
 * WooCommerce checkout functions.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Allow these modifications to easily be removed.
if ( apply_filters( 'bigbox_optimize_checkout', true ) ) {
	add_filter( 'woocommerce_billing_fields', 'bigbox_woocommerce_billing_fields' );
	add_filter( 'woocommerce_default_address_fields', 'bigbox_woocommerce_default_address_fields' );
}

/**
 * Adjust order for billing form fields.
 *
 * @since 1.0.0
 *
 * @param array $fields Billing fields.
 * @return array
 */
function bigbox_woocommerce_billing_fields( $fields ) {
	// Move email under name.
	$fields['billing_email']['priority'] = 23;

	// Remove phone.
	unset( $fields['billing_phone'] );

	return $fields;
}

/**
 * Adjust columns for billing form fields.
 *
 * @since 1.0.0
 *
 * @param array $fields Current billing fields.
 * @return array
 */
function bigbox_woocommerce_default_address_fields( $fields ) {
	$fields['address_1']['class'][] = 'form-row-first';
	$fields['address_2']['class'][] = 'form-row-last';
	$fields['address_2']['label']   = __( 'Apartment, suite, etc', 'bigbox' );

	$fields['state']['priority'] = 41;

	// Remove wide from some that can be collapsed.
	foreach ( array( 'address_1', 'address_2', 'city', 'postcode' ) as $field ) {
		$key = array_search( 'form-row-wide', $fields[ $field ]['class'], true );

		if ( false !== $key ) {
			unset( $fields[ $field ]['class'][ $key ] );
		}
	}

	$fields['city']['class'][]     = 'form-row-first';
	$fields['postcode']['class'][] = 'form-row-last';

	// Remove company.
	unset( $fields['company'] );

	return $fields;
}
