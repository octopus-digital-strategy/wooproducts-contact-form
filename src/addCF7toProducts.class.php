<?php
/**
 * Created by PhpStorm.
 * User: JCastro
 * Date: 10/03/17
 * Time: 16:17
 */

namespace WooProductsCF7;


class addCF7toProducts {

	public function __construct() {
		$this->getFilter();
		return $this;
	}

	public function getFilter() {
		$hook = array();

		if ( ! empty( esc_attr(get_option('filter')) ) ) {
			$hook['filter'] = esc_attr(get_option('filter'));
		} else {
			$hook['filter'] = 'woocommerce_after_single_product_summary';
		}

		if ( ! empty( esc_attr(get_option('priority')) ) ) {
			$hook['priority'] = intval(esc_attr(get_option('priority')));
		} else {
			$hook['priority'] = 5;
		}

		add_action( $hook['filter'], array( $this, 'renderCF7Shortcode' ), $hook['priority'] );

	}

	public function registerFilters() {
		return $this;
	}

	public function renderCF7Shortcode() {
		$contactFormID = esc_attr(get_option('shortcode'));

		$contactFormShortcode = '[contact-form-7 id="' . $contactFormID . '"]';

		echo do_shortcode( $contactFormShortcode );

	}

}