<?php
/**
 * Created by PhpStorm.
 * User: JCastro
 * Date: 10/03/17
 * Time: 15:55
 */

namespace WooProductsCF7;


use WPExpress\Admin\BaseSettingsPage;

class SettingsPage extends BaseSettingsPage {
	public function __construct() {
		parent::__construct( 'WooProducts Contact Form' );
		$this->shortcodeInput();
		$this->filterInput();
	}

	public function filterInput() {
		$this->fields->addTextInput('filter')->addLabel(__('Add the woocommerce hook to add this shortcode. Default: woocommerce_after_single_product_summary', 'wooproducts'));
		$this->fields->addTextInput('priority')->addLabel(__('Add priority', 'wooproducts'));
	}

	public function shortcodeInput() {
		$this->fields->addSelect( 'shortcode', self::getContactForms() )->addLabel( __( 'Select the contact form you want rendered after woocommerce products:', 'wooproducts' ) );;
	}

	private function getContactForms() {
		$cf7          = get_posts( array(
			'posts_per_page'   => - 1,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_type'        => 'wpcf7_contact_form',
			'post_status'      => 'publish',
			'suppress_filters' => true
		) );
		$contactForms = array();

		foreach ( $cf7 as $post ) {
			$contactForms[ $post->ID ] = $post->post_title;
		}

		$dataSource = array();
		foreach ( $contactForms as $value => $text ) {
			$dataSource[] = array( 'value' => $value, 'text' => $text, 'selected' => false );
		}

		return $dataSource;
	}
}