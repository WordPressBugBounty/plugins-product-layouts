;(function ($) {

    $('.wpte-product-add-cart-icon').each(function () {
        // Cart Icons

        var icon_id = $(this).attr('dataid'),
            cart_icon = $('#' + icon_id).attr('add_cart'),
            view_cart = $('#' + icon_id).attr('view_cart'),
            groupde_icon = $('#' + icon_id).attr('groupde_icon'),
            external_icon = $('#' + icon_id).attr('external_icon'),
            variable_icon = $('#' + icon_id).attr('variable_icon');

        $("#" + icon_id + " .ajax_add_to_cart").html(`<i class='${cart_icon}'></i>`);
        $("#" + icon_id + " .product_type_simple").html(`<i class='${cart_icon}'></i>`);
        $("#" + icon_id + " .product_type_grouped").html(`<i class='${groupde_icon}'></i>`);
        $("#" + icon_id + " .product_type_external").html(`<i class='${external_icon}'></i>`);
        $("#" + icon_id + " .product_type_variable").html(`<i class='${variable_icon}'></i>`);

        $( document.body ).on( 'wc_cart_button_updated', function(){
            $("#" + icon_id + " .added_to_cart").html(`<i class='${view_cart}'></i>`);
            $("#" + icon_id + " .added_to_cart").parent().siblings('.wpte-product-tooltip').text('View Cart');
        });
        
    });
    
    $('.wpte-product-add-cart-text').each(function () {
        var text_id = $(this).attr('dataid'),
            cart_text = $('#' + text_id).attr('add_cart_text'),
            view_cart_text = $('#' + text_id).attr('view_cart_text'),
            groupde_text = $('#' + text_id).attr('groupde_text'),
            external_text = $('#' + text_id).attr('external_text'),
            variable_text = $('#' + text_id).attr('variable_text');

        $("#" + text_id + " .ajax_add_to_cart").html(`${cart_text}`);
        $("#" + text_id + " .product_type_simple").html(`${cart_text}`);
        $("#" + text_id + " .product_type_grouped").html(`${groupde_text}`);
        $("#" + text_id + " .product_type_external").html(`${external_text}`);
        $("#" + text_id + " .product_type_variable").html(`${variable_text}`);

        $( document.body ).on( 'wc_cart_button_updated', function(){
            $("#" + text_id + " .added_to_cart").html(`${view_cart_text}`);
            $("#" + text_id + " .added_to_cart").parent().siblings('.wpte-product-tooltip').text('View Cart');
        });

    });

    $('.wpte-product-add-cart-icon-text').each(function () {
        var icon_text_id = $(this).attr('dataid'),
            cart_icon = $('#' + icon_text_id).attr('add_cart'),
            view_cart = $('#' + icon_text_id).attr('view_cart'),
            groupde_icon = $('#' + icon_text_id).attr('groupde_icon'),
            external_icon = $('#' + icon_text_id).attr('external_icon'),
            variable_icon = $('#' + icon_text_id).attr('variable_icon');
            cart_text = $('#' + icon_text_id).attr('add_cart_text'),
            view_cart_text = $('#' + icon_text_id).attr('view_cart_text'),
            groupde_text = $('#' + icon_text_id).attr('groupde_text'),
            external_text = $('#' + icon_text_id).attr('external_text'),
            variable_text = $('#' + icon_text_id).attr('variable_text');

        $("#" + icon_text_id + " .ajax_add_to_cart").html(`<i class='${cart_icon}'></i><span class='wpte-cart-text'>${cart_text}</span>`);
        $("#" + icon_text_id + " .product_type_simple").html(`<i class='${cart_icon}'></i><span class='wpte-cart-text'>${cart_text}</span>`);
        $("#" + icon_text_id + " .product_type_grouped").html(`<i class='${groupde_icon}'></i><span class='wpte-groupde-text'>${groupde_text}</span>`);
        $("#" + icon_text_id + " .product_type_external").html(`<i class='${external_icon}'></i><span class='wpte-external-text'>${external_text}</span>`);
        $("#" + icon_text_id + " .product_type_variable").html(`<i class='${variable_icon}'></i><span class='wpte-variable-text'>${variable_text}</span>`);

        $( document.body ).on( 'wc_cart_button_updated', function(){
            $("#" + icon_text_id + " .added_to_cart").html(`<i class='${view_cart}'></i><span class='wpte-view-cart-text'>${view_cart_text}</span>`);
            $("#" + icon_text_id + " .added_to_cart").parent().siblings('.wpte-product-tooltip').text('View Cart');
        });

    });

    // Tooltip

    $( document.body ).on( 'wc_cart_button_updated', function(){
        $('.wpte-product-tooltip').each(function(){
            $(this).parent().addClass('wpte-product-tooltip-area');
        });
    });

    $('.wpte-product-tooltip').each(function(){
        $(this).parent().addClass('wpte-product-tooltip-area');
    });

    // Wish List Icon
    $(document).on('click', '.tinvwl_add_to_wishlist_button', function(){

        var This = this,
            addedCart = (typeof( $(This).attr('addedicon')) != "undefined" && $(This).attr('addedicon') !== null) ? `<i class="${$(This).attr('addedicon')}"></i>` : '',
            addedText = (typeof( $(This).attr('addedtext')) != "undefined" && $(This).attr('addedtext') !== null) ? $(This).attr('addedtext') : '',
            id = $(This).attr('id');

        $(document).ajaxComplete(function () {
            $(This).removeClass('inited-add-wishlist');
            if ( addedCart && addedText ) {
                $("#" + id + ' .wpte-product-wishlist-icon').html(addedCart);
                $("#" + id + ' .wpte-product-wishlist-text').html(addedText);
            } else {
                if ( addedCart ) {
                    $("#" + id + ' .wpte-product-wishlist-icon').html(addedCart);
                }
                if ( addedText ) {
                    $("#" + id + ' .wpte-product-wishlist-text').html(addedText);
                }
            }
        })
    });

    $('.tinvwl_add_to_wishlist_button').each(function(){

        var This = this,
            addedCart = (typeof( $(This).attr('addedicon')) != "undefined" && $(This).attr('addedicon') !== null) ? `<i class="${$(This).attr('addedicon')}"></i>` : '',
            addedText = (typeof( $(This).attr('addedtext')) != "undefined" && $(This).attr('addedtext') !== null) ? $(This).attr('addedtext') : '',
            id = $(This).attr('id');

        if ( $("#" + id).hasClass('tinvwl-product-in-list') ) {
            if ( addedCart && addedText ) {
                $("#" + id + ' .wpte-product-wishlist-icon').html(addedCart);
                $("#" + id + ' .wpte-product-wishlist-text').html(addedText);
            } else {
                if ( addedCart ) {
                    $("#" + id + ' .wpte-product-wishlist-icon').html(addedCart);
                }
                if ( addedText ) {
                    $("#" + id + ' .wpte-product-wishlist-text').html(addedText);
                }
            }
        }
    
    });

    // Change Quantity input value to cart button quantity
    $('.quantity .input-text').on('change', function(){
        var id = $(this).attr('name');
        $('[data-product_id='+id+']').attr('data-quantity', $(this).val());
    });


     /**
         * Product Icon or Text Onload
         */
      function cart_icon_text_onload() {

        if ( $(".wpte-product-add-cart-icon").hasClass('wpte-cart-icon') ) {
            var cart_icon = $(".wpte-product-add-cart-icon").attr('add_cart'),
                groupde_icon = $(".wpte-product-add-cart-icon").attr('groupde_icon'),
                external_icon = $(".wpte-product-add-cart-icon").attr('external_icon'),
                variable_icon = $(".wpte-product-add-cart-icon").attr('variable_icon');

            $(".wpte-product-add-cart-icon .ajax_add_to_cart").html(`<i class='${cart_icon}'></i>`);
            $(".wpte-product-add-cart-icon .product_type_simple").html(`<i class='${cart_icon}'></i>`);
            $(".wpte-product-add-cart-icon .product_type_grouped").html(`<i class='${groupde_icon}'></i>`);
            $(".wpte-product-add-cart-icon .product_type_external").html(`<i class='${external_icon}'></i>`);
            $(".wpte-product-add-cart-icon .product_type_variable").html(`<i class='${variable_icon}'></i>`);
        
        } else if ( $('.wpte-product-add-cart-text').hasClass('wpte-cart-text') ) {

            var cart_text = $('.wpte-product-add-cart-text').attr('add_cart_text'),
                groupde_text = $('.wpte-product-add-cart-text').attr('groupde_text'),
                external_text = $('.wpte-product-add-cart-text').attr('external_text'),
                variable_text = $('.wpte-product-add-cart-text').attr('variable_text');

            $(".wpte-product-add-cart-text .ajax_add_to_cart").html(`${cart_text}`);
            $(".wpte-product-add-cart-text .product_type_simple").html(`${cart_text}`);
            $(".wpte-product-add-cart-text .product_type_grouped").html(`${groupde_text}`);
            $(".wpte-product-add-cart-text .product_type_external").html(`${external_text}`);
            $(".wpte-product-add-cart-text .product_type_variable").html(`${variable_text}`);

        } else {

            var cart_icon = $(".wpte-product-add-cart-icon-text").attr('add_cart'),
                groupde_icon = $(".wpte-product-add-cart-icon-text").attr('groupde_icon'),
                external_icon = $(".wpte-product-add-cart-icon-text").attr('external_icon'),
                variable_icon = $(".wpte-product-add-cart-icon-text").attr('variable_icon');
                cart_text = $(".wpte-product-add-cart-icon-text").attr('add_cart_text'),
                view_cart_text = $(".wpte-product-add-cart-icon-text").attr('view_cart_text'),
                groupde_text = $(".wpte-product-add-cart-icon-text").attr('groupde_text'),
                external_text = $(".wpte-product-add-cart-icon-text").attr('external_text'),
                variable_text = $(".wpte-product-add-cart-icon-text").attr('variable_text');

            $(".wpte-product-add-cart-icon-text .ajax_add_to_cart").html(`<i class='${cart_icon}'></i><span class='wpte-cart-text'>${cart_text}</span>`);
            $(".wpte-product-add-cart-icon-text .product_type_simple").html(`<i class='${cart_icon}'></i><span class='wpte-cart-text'>${cart_text}</span>`);
            $(".wpte-product-add-cart-icon-text .product_type_grouped").html(`<i class='${groupde_icon}'></i><span class='wpte-groupde-text'>${groupde_text}</span>`);
            $(".wpte-product-add-cart-icon-text .product_type_external").html(`<i class='${external_icon}'></i><span class='wpte-external-text'>${external_text}</span>`);
            $(".wpte-product-add-cart-icon-text .product_type_variable").html(`<i class='${variable_icon}'></i><span class='wpte-variable-text'>${variable_text}</span>`);
        }
        
    }

    // Product Tabs
    $(document).on('click', '.wpte-product-layouts-tabs li', function(){
        //var id     = $(this).attr('id');
        var catid       = $(this).attr('catid'),
            layoutid    = $(this).attr('layoutid');
            This        = $(this);

        $.ajax({
            type: 'POST',
            url : wpteGlobal.ajaxUrl,
            data: {
                action  : "wpte_load_product_based_on_category",
                _nonce  : wpteGlobal.wpte_nonce,
                catid   : catid,
                layoutid: layoutid,
            },
            beforeSend: function () {
                This.parent().siblings().find('.wpte-product-load').addClass('wpte-loading');
            },
            success: function (response) {
                This.parent().find('li').removeClass('wpte-tab-active');
                This.addClass('wpte-tab-active');
                This.parent().siblings().find('.wpte-product-load').removeClass('wpte-loading');
                if ( response ) {
                    This.parent().siblings().find('.wpte-product-load').html(response.data.data);
                    cart_icon_text_onload();
                } else {
                    This.parent().siblings().find('.wpte-product-load').html("No product found!")
                }
                
            },
            error: function (data) {
                This.parent().siblings().find('.wpte-product-load').removeClass('wpte-loading');
            }
        });
    });

    // Pagination
    $(document).on('click', '.wpte-product-paginations .wpte-product-layout-pagination li', function(){
        var page_id  = $(this).attr('data-id'),
            layoutid = $(this).attr('layoutid'),
            This     = $(this);

            var dataid = [];
            var data = {};

            $('.wpte-product-filter-form').each(function() {
                var daid = $(this).attr('dataid');
                var formId = $(this).attr('classid');
                dataid.push(daid);
                data[formId] = $('.' + formId).serializeJSON();
            });

        $.ajax({
            type: 'POST',
            url : wpteGlobal.ajaxUrl,
            data: {
                action  : "wpte_product_pagination",
                _nonce  : wpteGlobal.wpte_nonce,
                page_id : page_id,
                layoutid: layoutid,
                id      : dataid,
                data    : data,
            },
            beforeSend: function () {
                This.parent().parent().parent('.wpte-product-load').addClass('wpte-loading');
            },
            success: function (response) {
                This.parent().parent().parent('.wpte-product-load').removeClass('wpte-loading');
                if ( response ) {
                    var post_data  = response.data.data;
                    var pagination = `<div class="wpte-product-paginations">${response.data.pagination}</div>`;
                    This.parent().parent().parent('.wpte-product-load').html( post_data + pagination );
                    cart_icon_text_onload();
                } else {
                    This.parent().parent().parent('.wpte-product-load').html("No product found!")
                }
            },
            error: function (data) {
                This.parent().parent().parent('.wpte-product-load').removeClass('wpte-loading');
            }
        });
        
    });

    // Load More
    $(document).on('click', '.wpte-product-layout-load-more-button', function(){
        var post_per_page  = $(this).attr('post-per-page'),
            add_page = $(this).attr('add-page'),
            layoutid = $(this).attr('layoutid'),
            This     = $(this),
            add_page = parseInt( add_page ) + parseInt( post_per_page );

            var dataid = [];
            var data = {};

            $('.wpte-product-filter-form').each(function() {
                var daid = $(this).attr('dataid');
                var formId = $(this).attr('classid');
                dataid.push(daid);
                data[formId] = $('.' + formId).serializeJSON();
            });

        $.ajax({
            type: 'POST',
            url : wpteGlobal.ajaxUrl,
            data: {
                action  : "wpte_product_load_more",
                _nonce  : wpteGlobal.wpte_nonce,
                add_page: add_page,
                layoutid: layoutid,
                id      : dataid,
                data    : data,
            },
            beforeSend: function () {
                This.parent().parent('.wpte-product-load').addClass('wpte-loading');
                var text = This.html();
                This.addClass('loading');
                This.html(text + '<i class="wpte-icon icon-loading-2"></i>');
            },
            success: function (response) {
                This.parent().parent('.wpte-product-load').removeClass('wpte-loading');
                if ( response ) {
                    var post_data  = response.data.data;
                    var load_more = `<div class="wpte-product-load-more">${response.data.load_more}</div>`;
                    This.parent().parent('.wpte-product-load').html( post_data + load_more );
                    cart_icon_text_onload();
                } else {
                    This.parent().parent('.wpte-product-load').html("No product found!")
                }
            },
            error: function (data) {
                This.parent().parent('.wpte-product-load').removeClass('wpte-loading');
            }
        });
        
    });

    // Product Filter
    $('.wpte-product-filter-form').on('change', 'input:radio, input:checkbox', function(){
            var dataid     = [],
            This           = $(this),
            data           = {},
            layoutid       = $(this).attr('layoutid'),
            wpte_attribute = [];

            $('.wpte-product-filter-form').each(function() {
                var daid = $(this).attr('dataid');
                var formId = $(this).attr('classid');
				wpte_attribute[daid] = $(this).find('.wpte-filter-attribute').attr('wpte_attribute');
                dataid.push(daid);
                data[formId] = $('.' + formId).serializeJSON();
            });

			wpte_attribute = 'undefined' != wpte_attribute ? wpte_attribute : [];

            $.ajax({
                type: 'POST',
                url: wpteGlobal.ajaxUrl,
                data: {
                    action: "wpte_load_filter_product",
                    _nonce: wpteGlobal.wpte_nonce,
                    id: dataid,
                    layoutid: layoutid,
                    data: data,
                    wpte_attribute: wpte_attribute,
                },
                beforeSend: function () {
                    $('#wpte-product-layout-wrapper-'+layoutid).find('.wpte-product-load').addClass('wpte-loading');
                },
                success: function (response) {

                    $('#wpte-product-layout-wrapper-'+layoutid).find('.wpte-product-load').removeClass('wpte-loading');
                    if ( response.data.data ) {
                        $('#wpte-product-layout-wrapper-'+layoutid).find('.wpte-product-load').html(response.data.data + response.data.pagination);
                        //$('#wpte-product-filter-form-'+dataid).parents().siblings('.wpte-product-load').find('.wpte-product-filter-wrapper').remove();
                        cart_icon_text_onload();
                    } else {
                        $('#wpte-product-layout-wrapper-'+layoutid).find('.wpte-product-load').html("<h2>No product found!</h2>")
                    }
                   
                },
                error: function (data) {
                    $('#wpte-product-layout-wrapper-'+layoutid).find(".wpte-product-load").removeClass('wpte-loading');
                }
            });
    });

})(jQuery);