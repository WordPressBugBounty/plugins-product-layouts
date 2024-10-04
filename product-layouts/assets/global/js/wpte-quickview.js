;(function($){

  function Quick_view_popup(product_id, This){
    $.ajax({
      type: 'POST',
      url: wpteGlobal.ajaxUrl,
      data: {
          action: "wpte_quick_view_popup",
          _nonce: wpteGlobal.wpte_nonce,
          product_id: product_id,
      },
      beforeSend: function () {
        This.addClass('loading');
      },
      success: function (response) {
          $('.wpte-popup-display').addClass('wpte-popup-display-block');
          $('.wpte-popup-display-block').append(response.data.data);
          $('.wpte-quick-view-wrapper .woocommerce div.product .wpte_quick_view_product_addtocart_button_container form.cart div.quantity').append(`<div class='wpte-quick-view-quantity-minus'>-</div><div class='wpte-quick-view-quantity-plus'>+</div>`);
          $('.wpte_quick_view_product_addtocart_button_container .variations_form').each(function(){
            $( this ).wc_variation_form();
          })
          setTimeout( function() {
            $( '.wpte-quick-view-image-area .woocommerce-product-gallery' ).each( function() {
              $( this ).wc_product_gallery();
            } );
            $('.wpte-product-layouts-wish-list .tinvwl_add_to_wishlist_button').removeClass('disabled-add-wishlist');
        }, 100 );
        This.removeClass('loading');
        
      },
      complete : function() {

      },
      error: function (data) {
          alert(wpteGlobal.error);
      }
    });
  }

  $(document).on('click', '.wpte-product-layouts-quick-view a', function(e){
    e.preventDefault(), e.stopPropagation();
    var product_id = $(this).attr('productid'),
    This = $(this);
    Quick_view_popup(product_id, This);
  });

  $(document).on('click', 'body', function(e){
    if ( $(e.target).hasClass("wpte-product-popup-bg") ){
      $('.wpte-popup-display-block').html('');
      $('.wpte-popup-display').removeClass('wpte-popup-display-block');
    }
    
  });

  $(document).on('click', '.wpte-product-popup-close', function(e){
    $('.wpte-popup-display-block').html('');
    $('.wpte-popup-display').removeClass('wpte-popup-display-block');
  });

  $(document).on('click', '.wpte-quick-view-quantity-plus', function(){
    var quantity_number = $('.wpte-quick-view-wrapper .woocommerce div.product .wpte_quick_view_product_addtocart_button_container form.cart div.quantity .qty').val(),
    quantity_max = $('.wpte-quick-view-wrapper .wpte_quick_view_product_addtocart_button_container form.cart .quantity .qty').attr('max');
    // console.log($('.quantity .input-text').attr('min'));
    if ( quantity_number < quantity_max || !quantity_max ) {
      quantity_number++ ;
      $('.wpte-quick-view-wrapper .woocommerce div.product .wpte_quick_view_product_addtocart_button_container form.cart div.quantity .qty').val(quantity_number);
    }
    
  });

  $(document).on('click', '.wpte-quick-view-quantity-minus', function(){
    var quantity_number = $('.wpte-quick-view-wrapper .woocommerce div.product .wpte_quick_view_product_addtocart_button_container form.cart div.quantity .qty').val(),
    quantity_min = $('.wpte-quick-view-wrapper .woocommerce div.product .wpte_quick_view_product_addtocart_button_container form.cart div.quantity .qty').attr('min');
    if ( quantity_number > quantity_min ) {
      quantity_number-- ;
      $('.wpte-quick-view-wrapper .woocommerce div.product .wpte_quick_view_product_addtocart_button_container form.cart div.quantity .qty').val(quantity_number);
    }
  });

  function quick_view_add_to_cart(o, p, c) {
      $.ajax({
        type: 'POST',
        url: wpteGlobal.ajaxUrl,
        data: {
            action: "wpte_quick_view_add_to_cart",
            product_data: p,
            _nonce: wpteGlobal.wpte_nonce,
            cart_item_data: c.serializeArray() 
        },
        beforeSend: function () {

        },
        success: function (e) {
          if ( e.data.notices ) {
            $('.wpte-popup-display').attr('id', 'wpte-popup-display-notice');
            $('#wpte-popup-display-notice').prepend(e.data.notices);
            $('#wpte-popup-display-notice ul').prepend('<span class="wpte-quick-view-alert-close">×</span>');
            setTimeout( function() {
              $('#wpte-popup-display-notice ul').hide();
              o.removeClass("wpte-addtocart-loading")
            }, 5000 );
            
          } else {
            e.success && ($(document.body).trigger("wc_fragment_refresh"), 
            o.removeClass("wpte-addtocart-loading"), 
            o.addClass("wpte-addtocart-added"));
          }
        
        },
        complete : function() {

        },
        error: function (data) {
            o.removeClass("wpte-addtocart-loading");
            alert(wpteGlobal.error);
        }
      });
  }

  $(document).on("click", "#wpte-quick-view-box .single_add_to_cart_button", function (e) {
    e.preventDefault(), e.stopImmediatePropagation();
    var o = $(this),
        r = $(this).val(),
        a = o.closest("form.cart").find('input[name="variation_id"]').val() || "",
        n = o.closest("form.cart").find('input[name="quantity"]').val(),
        i = o.closest("form.cart.grouped_form"),
        c = o.closest("form.cart"),
        p = [];
        (i = i.serializeArray()),
        c.hasClass("variations_form") && (r = c.find('input[name="product_id"]').val()),
        i.length > 0
            ? i.forEach(function (e, t) {
                  var o = parseInt(e.name.replace(/[^\d.]/g, ""), 10);
                  e.name.indexOf("quantity[") >= 0 && "" != e.value && o > 0 && (p[p.length] = { product_id: o, quantity: e.value, variation_id: 0 });
              })
            : (p[0] = { product_id: r, quantity: n, variation_id: a }),
        o.removeClass("wpte-addtocart-added"),
        o.addClass("wpte-addtocart-loading"),
        quick_view_add_to_cart(o, p, c);
  });

  $(document).on('click', '.wpte-quick-view-alert-close', function(){
      $('.woocommerce-error').hide();
      $('#wpte-quick-view-box .single_add_to_cart_button').removeClass('wpte-addtocart-loading');
  });
})(jQuery);