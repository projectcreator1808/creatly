jQuery(function($) {
    "use strict";

    $(document).ready(function () {
        // -------------------------------------------------------------
        //  prepare the form when the DOM is ready
        // -------------------------------------------------------------
        $('#gig-overview-form').on('submit', function (e) {
            e.stopPropagation();
            e.preventDefault();

            var error = 0;
            $('#post_error').html('');
            $('.quick-error').hide();

            $('.quick-custom-field').each(function() {
                var $value = $(this).val().trim();
                $(this).parents('.submit-field').removeClass('field-error');
                if($(this).data('req') && $value.length === 0){
                    error = 1;
                    $(this).parents('.submit-field').addClass('field-error');
                    $(this).parents('.submit-field').find('.quick-error').show();
                }
            });

            $('.quick-radioCheck').each(function() {
                var $name = $(this).data('name');
                var $value = $('[data-name="'+$name+'"]:checked').map(function () {
                    return $(this).val().trim();
                }).get();
                if($(this).data('req') && $value.length === 0){
                    error = 1;
                    $(this).siblings('.quick-error').show();
                }
            });

            if(!error){

                $("#submit_gig_button").addClass('button-progress').prop('disabled', true);
                var $this = $('#submit_gig_button');
                var data = new FormData( this );
                var action = $('#gig-overview-form').data('action');
                data.append('action', action);
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: data,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status == "error") {
                            if (response["errors"].length > 0) {
                                for (var i = 0; i < response["errors"].length; i++) {
                                    var $message = response["errors"][i]["message"];
                                    $('#post_error').append('<div class="notification error closeable"><p>' + $message + '</p><a class="close"></a></div>');
                                }
                                $('html, body').animate({
                                    scrollTop: $("#post_error").offset().top
                                }, 2000);
                            }
                            $('#submit_gig_button').removeClass('button-progress').prop('disabled', false);
                        }
                        else if (response.status == "success") {
                            $('#submit_gig_button').removeClass('button-progress').prop('disabled', false);
                            //nextstep($this);
                            $('#gig-overview-form').fadeOut();
                            $('.payment-confirmation-page').fadeIn();
                            $('html, body').animate({
                                scrollTop: $(".payment-confirmation-page").offset().top
                            }, 2000);
                            var delay = 2000;
                            setTimeout(function () {
                                window.location = response.redirect;
                            }, delay);
                        }
                        else{

                        }

                    }
                });

            }else{
                $('html, body').animate({
                    scrollTop: $(".quick-error:visible:first").parents('.submit-field').offset().top
                }, 2000);
            }
            return false;
        });
    });


    function nextstep($this){
        var nextstep = $($this.data("next"));
        //activate next step on progressbar using the index of next_fs
        $("#progressbar li.active").last().next('li').addClass("active");

        $("html, body").animate({
            scrollTop: 0
        }, 200, function() {
            $(".step").stop(true, true).hide();
            nextstep.stop(true, true).fadeIn(1000);
        });
    }

    /*--------------------------------------
     POST SLIDER
     --------------------------------------*/
    if ($('#tg-dbcategoriesslider').length > 0) {
        if ($("body").hasClass("rtl")) var rtl = true;
        else rtl = false;
        var _tg_postsslider = $('#tg-dbcategoriesslider');
        _tg_postsslider.owlCarousel({
            items: 4,
            nav: true,
            rtl: rtl,
            loop: false,
            dots: false,
            autoplay: false,
            dotsClass: 'tg-sliderdots',
            navClass: ['tg-prev', 'tg-next'],
            navContainerClass: 'tg-slidernav',
            navText: ['<span class="icon-chevron-left"></span>', '<span class="icon-chevron-right"></span>'],
            responsive: {
                0: {items: 2},
                640: {items: 3},
                768: {items: 4}
            }
        });
    }
    // -------------------------------------------------------------
    //  select-main-category Change
    // -------------------------------------------------------------
    $('.select-category.post-option .tg-category').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $('.select-category.post-option .tg-category.selected').removeClass('selected');
        $(this).addClass('selected');
        var catid = $(this).data('ajax-catid');
        $('#main-category-text').html($(this).data('cat-name'));
        $('#input-maincatid').val(catid);
        if($(this).data('sub-cat') == 1) {
            $('#sub-category-loader').css("visibility", "visible");
            $("#sub_category").html('');
            var action = $(this).data('ajax-action');
            var data = {action: action, catid: catid};
            getsubcat(catid, action, "");
            $(".tg-subcategories").show();
            $('#input-subcatid').val('');
            $('#sub-category-text').html('--').hide();
            $('#change-category-btn').hide();
        }else{
            $(".tg-subcategories").hide();
            $('#input-subcatid').val(0);
            $('#sub-category-text').html('--').hide();
            $('#change-category-btn').show();
            $('#choose-category').html(lang_edit_cat);
            $.magnificPopup.close();
        }

    });
    // -------------------------------------------------------------
    //  select-sub-category Change
    // -------------------------------------------------------------
    $('#sub_category').on('click', 'li', function (e) {
        e.preventDefault();
        var $item = $(this).closest('li');
        $('#sub_category li.selected').removeClass('selected active');
        $item.addClass('selected');
        var subcatid = $item.data('ajax-subcatid');
        var photoshow = $item.data('photo-show');
        var priceshow = $item.data('price-show');
        $('#input-subcatid').val(subcatid);
        $('#sub-category-text').html($item.text()).show();

        $('#change-category-btn').show();
        // -------------------------------------------------------------
        //  Get custom fields
        // -------------------------------------------------------------
        var catid = $('#input-maincatid').val();
        var action = 'getCustomFieldByCatID';
        var data = {action: action, catid: catid, subcatid: subcatid, post_type: 'gig'};
        $.ajax({
            type: "POST",
            url: ajaxurl + "?action=" + action,
            data: data,
            success: function (result) {
                if (result != 0) {
                    $("#ResponseCustomFields").html(result);
                    $('#custom-field-block').show();
                    $(".selectpicker").selectpicker();
                }
                else {
                    $('#custom-field-block').hide();
                    $("#ResponseCustomFields").html('');
                }

            }
        });
        $('#choose-category').html(lang_edit_cat);
        $.magnificPopup.close();
    });

    function getsubcat(catid, action, selectid) {
        var data = {action: action, catid: catid, selectid: selectid};
        $.ajax({
            type: "POST",
            url: ajaxurl + '?action=' + action,
            data: data,
            success: function (result) {
                $("#sub_category").html(result);
                $('#sub-category-loader').css("visibility", "hidden");
            }
        });
    }

});
$(function(){
    App.Init();
});
/**
 * Main Namespace
 * App
 */
var App = {};
    /**
     * Initialize
     */
    App.Init = function()
    {
        $("body").on("click", ".next-btn", function() {
            /*$this = $(this);
            if ($this.hasClass("disabled")) {
                return false;
            }
            var nextstep = $($this.data("next"));
            console.log(nextstep);
            //activate next step on progressbar using the index of next_fs
            $("#progressbar li.active").last().next('li').addClass("active");

            $("html, body").animate({
                scrollTop: 0
            }, 200, function() {
                $(".step").stop(true, true).hide();
                nextstep.stop(true, true).fadeIn(1000);
            });*/
        });

        $("body").on("click", ".back-btn", function() {

            var backstep = $($(this).data("back"));
            //activate next step on progressbar using the index of next_fs
            $("#progressbar li.active").last().removeClass("active");

            $("html, body").animate({
                scrollTop: 0
            }, 200, function() {
                $(".step").stop(true, true).hide();
                backstep.stop(true, true).fadeIn(1000);
            });
        });
    }


/* FUNCTIONS */

/**
 * Validate email
 * @param  {String}  email 
 * @return {Boolean}       
 */
function isValidEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}
