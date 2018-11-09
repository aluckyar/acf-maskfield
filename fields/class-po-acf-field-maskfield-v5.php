<?php
// exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}


// check if class already exists
if (!class_exists('po_acf_field_maskfield')) {

    class po_acf_field_maskfield extends acf_field {
        /*
         *  __construct
         *
         *  This function will setup the field type data
         *
         *  @type	function
         *  @date	5/03/2014
         *  @since	5.0.0
         *
         *  @param	n/a
         *  @return	n/a
         */

        function __construct($settings) {

            /*
             *  name (string) Single word, no spaces. Underscores allowed
             */

            $this->name = 'maskfield';


            /*
             *  label (string) Multiple words, can include spaces, visible when selecting a field type
             */

            $this->label = __('Mask Field', 'acf-maskfield');


            /*
             *  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
             */

            $this->category = 'basic';


            /*
             *  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
             */

            $this->defaults = array(
                'input_mask' => '',
            );


            /*
             *  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
             *  var message = acf._e('maskfield', 'error');
             */

            $this->l10n = array(
                'error' => __('Error! Please enter a higher value', 'acf-maskfield'),
            );


            /*
             *  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
             */

            $this->settings = $settings;


            // do not delete!
            parent::__construct();
        }

        /*
         *  render_field_settings()
         *
         *  Create extra settings for your field. These are visible when editing a field
         *
         *  @type	action
         *  @since	3.6
         *  @date	23/01/13
         *
         *  @param	$field (array) the $field being edited
         *  @return	n/a
         */

        function render_field_settings($field) {

            /*
             *  acf_render_field_setting
             *
             *  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
             *  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
             *
             *  More than one setting can be added by copy/paste the above code.
             *  Please note that you must also have a matching $defaults value for the field name (input_mask)
             */

            acf_render_field_setting($field, array(
                'label' => __('Input Mask', 'acf-maskfield'),
                'instructions' => __("Add the input Mask. Example: 'mask': '99-9999999'. More info in https://github.com/RobinHerbots/Inputmask", 'acf-maskfield'),
                'type' => 'text',
                'name' => 'input_mask'
            ));
        }

        /*
         *  render_field()
         *
         *  Create the HTML interface for your field
         *
         *  @param	$field (array) the $field being rendered
         *
         *  @type	action
         *  @since	3.6
         *  @date	23/01/13
         *
         *  @param	$field (array) the $field being edited
         *  @return	n/a
         */

        function render_field($field) {

            /*
             *  Create a simple text input using the 'input_mask' setting.
             */
            ?>
            <input type="text" name="<?php echo esc_attr($field['name']) ?>" regexp="<?php echo esc_attr($field['input_mask']) ?>" value="<?php echo esc_attr($field['value']) ?>" <?php echo $field['required'] ? 'required="required"' : ''; ?> class="item-mask"/>
            <?php
        }

        /*
         *  input_admin_enqueue_scripts()
         *
         *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
         *  Use this action to add CSS + JavaScript to assist your render_field() action.
         *
         *  @type	action (admin_enqueue_scripts)
         *  @since	3.6
         *  @date	23/01/13
         *
         *  @param	n/a
         *  @return	n/a
         */

        function input_admin_enqueue_scripts() {

            // vars
            $url = $this->settings['url'];
            $version = $this->settings['version'];

            // register & include JS
            wp_register_script('acf-' . $this->name, "{$url}assets/js/input.js", array('jquery', 'acf-input'), $version);
            wp_register_script('inputmask', "{$url}assets/vendor/inputmask/jquery.inputmask.bundle.js", array('jquery'), $version);
            wp_enqueue_script('acf-' . $this->name);
            wp_enqueue_script('inputmask');


            // register & include CSS
            wp_register_style('acf-' . $this->name, "{$url}assets/css/input.css", array('acf-input'), $version);
            wp_enqueue_style('acf-' . $this->name);
        }

    }

// initialize
    new po_acf_field_maskfield($this->settings);


// class_exists check
}
?>
