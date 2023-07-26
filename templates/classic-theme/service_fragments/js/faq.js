jQuery(function($) {
    "use strict";
    $('#add-faq-btn').on('click',function(){
        $('#add-faq-form').toggle(500);
        $('#add-faq-btn').hide();
    });
    $('#faq-cancel-btn').on('click',function(){
        $('#add-faq-form').toggle(500);
        $('#add-faq-btn').show();
    });
});