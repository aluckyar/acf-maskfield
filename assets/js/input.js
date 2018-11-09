jQuery(function ($) {

    var type = 'maskfield';

    /**
     *  initialize_field
     *
     *  This function will initialize the $field.
     *
     *  @date	30/11/17
     *  @since	5.6.5
     *
     *  @param	n/a
     *  @return	n/a
     */
    function initialize_field($field) {
        // get input field
        var $maskInput = $field.find('input.item-mask');
        setMask($maskInput);
    }

    /**
     * Set Mask 
     * @param {type} $field
     * @returns {undefined}
     */
    function setMask($field) {
        $field.inputmask('remove');
        $field.inputmask($field.attr('regexp'));
    }

    if (typeof acf.add_action !== 'undefined') {

        /*
         *  ready & append (ACF5)
         *
         *  These two events are called when a field element is ready for initizliation.
         *  - ready: on page load similar to $(document).ready()
         *  - append: on new DOM elements appended via repeater field or other AJAX calls
         *
         *  @param	n/a
         *  @return	n/a
         */

        acf.addAction('ready_field/type=' + type, initialize_field);
        acf.addAction('append_field/type=' + type, initialize_field);

    }

    /**
     * Apply the initialize_fields in Frontend acf_form
     */
    $('[data-type="' + type + '"]').each(function () {
        initialize_field($(this));
    });
    
});