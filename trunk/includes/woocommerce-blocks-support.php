<?php

/**
 * WC Dummy Payment gateway plugin class.
 *
 * @class WC_Block_Payments
 */
class WC_Block_Payments {

	/**
	 * Plugin bootstrapping.
	 */
	public static function init() {

		// Dummy Payments gateway class.
		// Make the Dummy Payments gateway available to WC.
		add_filter('woocommerce_payment_gateways', array(__CLASS__, 'add_gateway'));

		// Registers WooCommerce Blocks integration.
		add_action('woocommerce_blocks_loaded', array(__CLASS__, 'woocommerce_gateway_ikhokha_woocommerce_block_support'));
	}

	/**
	 * Add the Payment gateway to the list of available gateways.
	 *
	 * @param array
	 */
	public static function add_gateway($gateways) {

		return $gateways;
	}

	/**
	 * Plugin includes.
	 */

	/**
	 * Plugin url.
	 *
	 * @return string
	 */
	public static function plugin_url() {
		return untrailingslashit(plugins_url('../', __FILE__));
	}

	/**
	 * Plugin url.
	 *
	 * @return string
	 */
	public static function plugin_abspath() {
		return trailingslashit(plugin_dir_path(__FILE__));
	}

	/**
	 * Registers WooCommerce Blocks integration.
	 *
	 */
	public static function woocommerce_gateway_ikhokha_woocommerce_block_support() {
		if (class_exists('Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType')) {
			require_once plugin_dir_path(__FILE__) . "/blocks/class-wc-payments-blocks.php";
			add_action(
				'woocommerce_blocks_payment_method_type_registration',
				function (Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry) {
					$payment_method_registry->register(new WC_Gateway_Block_Blocks_Support());
				}
			);
		}
	}
}

WC_Block_Payments::init();
