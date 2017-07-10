<?php
/**
 * Created by PhpStorm.
 * User: JCastro
 * Date: 10/07/17
 * Time: 18:12
 */

namespace WooProductsCF7;


class SettingsPage
{
    public function __construct()
    {
        $this->registerFilters();
    }

    public function registerFilters()
    {
        add_action('admin_menu', array($this, 'WooProductsContactFormMenu'));
        add_action('admin_init', array($this, 'WooProductsContactFormSettings'));
        return $this;
    }

    public function WooProductsContactFormMenu()
    {
        add_options_page(__('Woo Products Contact Forms Menu', 'wooproducts'), 'WooProducts Contact Form', 'manage_options', 'wooproducts-contactform', array($this, 'wooProductsContactFormSettingsPage'));
    }

    public function wooProductsContactFormSettingsPage()
    {
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        ?>
        <div class="wrap">
            <h1>WooProducts Contact Form</h1>
            <p>This plugin adds a custom contact form 7 shortcode in woocommerce products.</p>
            <form method="post" action="options.php">

                <?php settings_fields('wooProductsContactForm');
                do_settings_sections('wooProductsContactForm'); ?>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Add the woocommerce hook to add this shortcode. Default: woocommerce_after_single_product_summary', 'wooproducts'); ?></th>
                        <td><input type="text" name="filter" value="<?php echo esc_attr(get_option('filter')); ?>"/></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php _e('Add priority', 'wooproducts'); ?></th>
                        <td><input type="text" name="priority" value="<?php echo esc_attr(get_option('priority')); ?>"/>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php _e('Select the contact form you want rendered after woocommerce products:', 'wooproducts'); ?></th>
                        <td>
                            <select name="shortcode">
                                <?php
                                $contactForms = self::getContactForms();
                                foreach ($contactForms as $contactForm){
                                    $option = '<option'. selected( esc_attr(get_option('shortcode')), $contactForm['value'] ) .' value="'. $contactForm['value'] . '">' . $contactForm['text'] . '</option>';
                                    echo $option;
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>

            </form>
        </div>
        <?php
    }

    public function WooProductsContactFormSettings()
    {
        register_setting('wooProductsContactForm', 'filter');
        register_setting('wooProductsContactForm', 'priority');
        register_setting('wooProductsContactForm', 'shortcode');
    }

    private function getContactForms()
    {
        $cf7 = get_posts(array(
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'wpcf7_contact_form',
            'post_status' => 'publish',
            'suppress_filters' => true
        ));
        $contactForms = array();
        foreach ($cf7 as $post) {
            $contactForms[$post->ID] = $post->post_title;
        }
        $dataSource = array();
        foreach ($contactForms as $value => $text) {
            $dataSource[] = array('value' => $value, 'text' => $text, 'selected' => false);
        }
        return $dataSource;
    }

}