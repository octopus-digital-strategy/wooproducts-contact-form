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
		$filter = new SettingsPage();

		$hook = array();

		if ( ! empty( $filter->getOptionValue( 'filter' ) ) ) {
			$hook['filter'] = $filter->getOptionValue( 'filter' );
		} else {
			$hook['filter'] = 'woocommerce_after_single_product_summary';
		}

		if ( ! empty( $filter->getOptionValue( 'priority' ) ) ) {
			$hook['priority'] = intval($filter->getOptionValue('priority'));
		} else {
			$hook['priority'] = 5;
		}

		add_action( $hook['filter'], array( $this, 'renderCF7Shortcode' ), $hook['priority'] );

	}

	public function registerFilters() {
		return $this;
	}

	public function renderCF7Shortcode() {
		$forms = new SettingsPage();

		$contactFormID = $forms->getOptionValue( 'shortcode' );

		$contactFormShortcode = '[contact-form-7 id="' . $contactFormID . '"]';

		echo do_shortcode( $contactFormShortcode );

	}

}