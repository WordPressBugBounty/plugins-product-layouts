;(function($){

  function wpte_compare_popup(This, product_id, is_retry) {
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
        if ( response && ! response.success && response.data && response.data.nonce_expired && ! is_retry ) {
          wpteGlobal.wpte_nonce = response.data.new_nonce;
          wpte_compare_popup(This, product_id, true);
          return;
        }
        if ( response.data.data ) {
          var icon = (typeof(This.attr('compare_added_icon')) != "undefined" && This.attr('compare_added_icon') !== null) ? `<i class="${This.attr('compare_added_icon')}"></i>` : '',
            ctext = (typeof(This.attr('compare_added_text')) != "undefined" && This.attr('compare_added_text') !== null) ? This.attr('compare_added_text') : '';
          $('.wpte-popup-display').addClass('wpte-popup-display-block');
          $('.wpte-popup-display-block').append(response.data.data);
          This.html( icon + ctext );
          This.removeClass('loading');
        } else if ( response.data.iderror ) {
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
  }

  $(document).on('click', '.wpte-product-layouts-compare a', function(){
    wpte_compare_popup( $(this), $(this).attr('product_id'), false );
  });

  /**
   * Keep the modal coherent after a column is removed: refresh the product
   * count in the header and swap in the empty state once nothing is left.
   */
  function wpte_compare_refresh(context) {
    var $box   = (context || $(document)).find('#wpte-product-compare-box'),
      $count   = $box.find('.wpte-compare-table-count'),
      $table   = $box.find('.wpte-compare-table'),
      $empty   = $box.find('.wpte-compare-empty'),
      remaining = $table.find('.wpte-compare-head-row .wpte-compare-product-col:visible').length;

    if ( $count.length ) {
      if ( remaining === 0 ) {
        $count.text( $count.attr('data-empty') || '' );
      } else {
        var template = remaining === 1 ? $count.attr('data-singular') : $count.attr('data-plural');
        $count.text( (template || '%s').replace('%s', remaining) );
      }
    }

    if ( remaining === 0 ) {
      $table.hide();
      $empty.show();
    }
  }

  function wpte_compare_remove(product_id, is_retry) {
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
        if ( response && ! response.success && response.data && response.data.nonce_expired && ! is_retry ) {
          wpteGlobal.wpte_nonce = response.data.new_nonce;
          wpte_compare_remove(product_id, true);
          return;
        }
        $('.wpte-remove-'+product_id).hide();
        wpte_compare_refresh();
      },
      complete : function() {

      },
      error: function (data) {
          alert(wpteGlobal.error);
      }
    });
  }

  $(document).on('click', '.wpte-compare-product-remove', function(){
    wpte_compare_remove( $(this).attr('product_id'), false );
  });

})(jQuery);