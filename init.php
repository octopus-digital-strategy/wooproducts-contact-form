<?php
/**
 * Plugin name: Woo Products Contact Form
 * Plugin URI: https://github.com/octopus-digital-strategy/wooproducts-contact-form
 * Description: Adds a contact form to every woocommerce product
 * Version: 0.1
 * Author: JCastro91
 * Author URI: https://jorgecastro.mx
 */

// No direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Composer implementation
require_once('vendor/autoload.php');

// Instance the Setup
new \WooProductsCF7\SetupPlugin();