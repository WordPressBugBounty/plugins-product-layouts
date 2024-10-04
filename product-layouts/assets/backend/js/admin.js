(function ($) {
  function delete_layout(id, This) {
    $.ajax({
      type: 'POST',
      url: wpteAdmin.ajaxUrl,
      data: {
        action: 'wpte_delete_shortcode',
        _nonce: wpteAdmin.wpte_nonce,
        id: id,
      },
      beforeSend: function () {
        var element = This.parents('tr');
        element.addClass('before-delete-shortcode-row');
      },
      success: function (response) {
        var element = This.parents('tr');
        element.removeClass('before-delete-shortcode-row');
        element.addClass('delete-shortcode-row');
        setTimeout(() => {
          element.hide();
        }, 100);
      },
      error: function (data) {
        console.log('Error');
      },
    });
  }

  $('.wptesubmitdelete').on('click', function (e) {
    e.preventDefault();
    var confirmation = confirm(wpteAdmin.message);
    if (confirmation) {
      var This = $(this),
        id = $(this).attr('layoutid');
      delete_layout(id, This);
    }
  });

  $('.wpte-wpl-list-data-table #doaction').on('click', function (e) {
    e.preventDefault();
    var selectedvalue = $('.wpte-wpl-list-data-table #bulk-action-selector-top')
      .find(':selected')
      .val();

    if (selectedvalue == 'delete') {
      var confirmation = confirm(wpteAdmin.message);
      if (confirmation) {
        $('.wpte-shortcode-check:checked').each(function () {
          var This = $(this),
            id = $(this).val();
          delete_layout(id, This);
        });
      }
    }
  });

  function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
  }

  $(document).ready(function () {
    $('.fileuploader-input').on('dragenter dragover', function () {
      $(this).addClass('draged');
    });
    $('.fileuploader-input').on('dragleave', function () {
      $(this).removeClass('draged');
    });
    $('.fileuploader-input').on('dragend', function () {
      $(this).removeClass('draged');
    });
    $('.fileuploader-input').on('drop', function () {
      $(this).removeClass('draged');
    });

    $('#wpte-file').change(function (e) {
      var fileName = e.target.files[0].name;
      var fileSize = formatBytes(e.target.files[0].size);
      var extension = $(this).val().replace(/^.*\./, '');

      if (extension === 'json') {
        $('.wpte-fileuploader-items-list').html(`
                    <li class="wpte-file-item">
                        <div class="wpte-file-inner-item">
                            <div class="wpte-file-extension-box">
                                <div class="wpte-file-extension">${extension}</div>
                            </div>
                            <div class="wpte-file-title-area">
                                <div class="wpte-file-title">${fileName}</div>
                                <p>${fileSize}</p>
                            </div>
                            <div class="wpte-file-remove-area">
                                <div class="wpte-file-remove">
                                    <span class="dashicons dashicons-no-alt"></span>
                                </div>
                            </div>
                        </div>
                    </li>
                `);
        $('.fileuploader-button').removeAttr('disabled');
      } else {
        $('.wpte-fileuploader-items-list').html(`
                    <li class="wpte-file-item">
                        <div class="wpte-file-inner-item-error">
                             ${wpteImport.importerror}
                        </div>
                    </li>
                `);
        $('.fileuploader-button').prop('disabled', true);
      }
    });

    $(document).on('click', '.wpte-file-remove', function () {
      $('#wpte-file').val('');
      $('.wpte-fileuploader-items-list').html('');
      $('.fileuploader-button').prop('disabled', true);
    });
  });

  $('form#wpte-import-file-uploader').submit(function (e) {
    e.preventDefault();

    var formData = new FormData();
    var file = $(document).find('input[type="file"]');
    var individual_file = file[0].files[0];
    formData.append('file', individual_file);
    formData.append('action', 'wpte_shortcode_import_layout');
    formData.append('_nonce', wpteImport.wpte_nonce);

    $.ajax({
      type: 'POST',
      url: wpteImport.ajaxUrl,
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('#wpte_product_layout_import').html('Importing...');
      },
      success: function (response) {
        if (response.success) {
          if (response.data.failed) {
            $('.wpte-fileuploader-items-list').html(`
                            <li class="wpte-file-item">
                                <div class="wpte-file-inner-item-error">
                                    ${response.data.failed}
                                </div>
                            </li>
                        `);
            $('#wpte_product_layout_import').html('Import Layout');
          } else {
            setTimeout(function () {
              document.location.href = response.data.url;
            }, 200);
          }
        }
      },
      complete: function () {},
      error: function (data) {
        console.log('Error');
      },
    });
  });

  $(document).ready(function () {
    function wpte_support_reSizeArea(e) {
      var arr = $.makeArray(e);
      var ah = $.map(arr, function (h) {
        return $(h).height();
      });
      var mh = Math.max.apply($(this).height(), ah);
      e.height(mh);
    }

    if ($(window).width() > 768) {
      window.onload = wpte_support_reSizeArea($('.wpte-pl-support-content'));
      window.onresize = wpte_support_reSizeArea($('.wpte-pl-support-content'));
    }
  });

  $(document).ready(function() {
	// Move the admin to bar to the top
	var firstWrapper = $('.wpte-wpl-wrapper').first();
	firstWrapper.insertBefore(firstWrapper.siblings().first());
  });

})(jQuery);
