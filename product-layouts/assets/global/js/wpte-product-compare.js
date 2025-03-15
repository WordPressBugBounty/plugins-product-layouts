;(function($){

  $(document).on('click', '.wpte-product-layouts-compare a', function(){

    var This = $(this),
        product_id = $(this).attr('product_id');

        $.ajax({
          type: 'POST',
          url: wpteGlobal.ajaxUrl,
          data: {
              action: "wpte_product_compare_popup",
              _nonce: wpteGlobal.wpte_nonce,
              product_id: product_id,
          },
          beforeSend: function () {
            This.addClass('loading');
          },
          success: function (response) {
            if ( response.data.nonceerror ) {
              console.log( response.data.nonceerror );
            } else if ( response.data.data ) {
              var icon = (typeof(This.attr('compare_added_icon')) != "undefined" && This.attr('compare_added_icon') !== null) ? `<i class="${This.attr('compare_added_icon')}"></i>` : '',
                ctext = (typeof(This.attr('compare_added_text')) != "undefined" && This.attr('compare_added_text') !== null) ? This.attr('compare_added_text') : '';
              $('.wpte-popup-display').addClass('wpte-popup-display-block');
              $('.wpte-popup-display-block').append(response.data.data);
              This.html( icon + ctext );
              This.removeClass('loading');
            } else if ( response.data.iderror) {
               console.log( response.data.iderror );
            } else {
              console.log( response.data.error );
            }
            
          },
          complete : function() {
  
          },
          error: function (data) {
              alert(wpteGlobal.error);
          }
      });
  });

  $(document).on('click', '.wpte-compare-product-remove', function(){

        var This = $(this),
        product_id = $(this).attr('product_id');

        $.ajax({
          type: 'POST',
          url: wpteGlobal.ajaxUrl,
          data: {
              action: "wpte_compare_product_remove",
              _nonce: wpteGlobal.wpte_nonce,
              product_id: product_id,
          },
          beforeSend: function () {
            $('.wpte-remove-'+product_id).css('opacity', '0.6');
          },
          success: function (response) {
            $('.wpte-remove-'+product_id).hide();
          },
          complete : function() {

          },
          error: function (data) {
              alert(wpteGlobal.error);
          }
      });
  });

})(jQuery);