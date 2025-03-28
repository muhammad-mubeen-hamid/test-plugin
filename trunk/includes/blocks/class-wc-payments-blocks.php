<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

/**
 * Payments Blocks integration
 *
 * @since 1.0.3
 */

final class WC_Gateway_Block_Blocks_Support extends AbstractPaymentMethodType
{

    /**
     * The gateway instance.
     *
     * @var WC_Gateway_Block
     */
    private $gateway;

    /**
     * Payment method name/id/slug.
     *
     * @var string
     */
    protected $name = 'ikhokha';

    /**
     * Initializes the payment method type.
     */
    public function initialize()
    {
        $this->settings = get_option('woocommerce_ikhokha_settings', []);
        $this->gateway  = new WC_iKhokha_Gateway();
    }


    /**
     * Returns an array of scripts/handles to be registered for this payment method.
     *
     * @return array
     */
    public function get_payment_method_script_handles()
    {
        $script_path       = '/assets/js/frontend/blocks.js';
        $script_asset_path = WC_Block_Payments::plugin_abspath() . 'assets/js/frontend/blocks.asset.php';
        $script_asset      = file_exists($script_asset_path)
            ? require($script_asset_path)
            : array(
                'dependencies' => array(),
                'version'      => '1.2.0'
            );
        $script_url        = WC_Block_Payments::plugin_url() . $script_path;

        wp_register_script(
            'wc-ikhokha-payments-blocks',
            $script_url,
            $script_asset['dependencies'],
            $script_asset['version'],
            true
        );

        if (function_exists('wp_set_script_translations')) {
            wp_set_script_translations('wc-ikhokha-payments-blocks', 'woocommerce-gatewayy', WC_Block_Payments::plugin_abspath() . 'languages/');
        }

        return ['wc-ikhokha-payments-blocks'];
    }

    /**
     * Returns an array of key=>value pairs of data made available to the payment methods script.
     *
     * @return array
     */
    public function get_payment_method_data()
    {
        return [
            'title'       => $this->get_setting('title'),
            'description' => $this->get_setting('description'),
            'supports'    => array_filter($this->gateway->supports, [$this->gateway, 'supports'])
        ];
    }
}
