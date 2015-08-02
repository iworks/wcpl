var iworks_wcpl = (function($, w) {
    function init() {
        if ( $('.wpColorPicker').length ) {
            $('.wpColorPicker').wpColorPicker();
        }
    }
    return {
        init: init,
    };
})(jQuery);

jQuery(document).ready(iworks_wcpl.init);

