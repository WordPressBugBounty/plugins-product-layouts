;(function($){

	// Have the previously selected tab open
	if ( sessionStorage.activeTab ) {

		$('.wpte-pl-tab-content ' + sessionStorage.activeTab).show().siblings().hide();
		$(".wpte-pl-tab-button li a[href=" + "\"" + sessionStorage.activeTab + "\"" + "]").parent().addClass('active').siblings().removeClass('active');

	}

	// Enable, disable and switch tabs on click
	$('.wpte-pl-tab-button > .btn > a').on('click', function(e)  {

		e.preventDefault();

		var currentAttrValue = $(this).attr('href');
		var activeTab = $(this).attr('href');

		if( activeTab.length ) {	 
			// Show/Hide Tabs
			$('.wpte-pl-tab-content ' + currentAttrValue).fadeIn('fast').siblings().hide();
			sessionStorage.activeTab = currentAttrValue;

			$(this).parent('li').addClass('active').siblings().removeClass('active');  
		}

	});

	$("#wpte-settings-category-select").select2();
	$("#wpte-settings-filter-select").select2();

    function wpte_settings( data ) {
        $.ajax({
            type: 'POST',
            url: wpteSettings.ajaxUrl,
            data: {
                action: "wpte_settings_form",
                _nonce: wpteSettings.wpte_nonce,
                data: data,
            },
            beforeSend: function () {
				$('.wpte-setting-btn-loader').removeClass('dashicons-yes');
                $('.wpte-setting-btn-loader').addClass('dashicons-admin-generic');
                $('.wpte-setting-btn-text').text('Saving...');
            },
            success: function (response) {

				if ( response.success ) {
					$('.wpte-setting-btn-loader').removeClass('dashicons-admin-generic');
					$('.wpte-setting-btn-text').text(response.data.message);
					$('.wpte-setting-btn-loader').addClass('dashicons-yes');
				}
               
            },
            complete: function(){
				setTimeout(() => {
					$('.wpte-setting-btn-text').text('Save Changes');
				}, 3000);
            },
            error: function (data) {
                console.log(wpteSettings.error)
            }
        });
    }

	$('#wpte-settings-form').on('submit', function(e) {
		e.preventDefault();
		const formData = $(this).serializeArray();
		wpte_settings( formData );
	});

	$('.settings-pre-check').each(function(){
		$(this).prepend(`
			<div class="pro-badge">
				<i class="dashicons dashicons-lock"></i>
				<div class="pro-tooltip">Available in Pro</div>
			</div>	
		`);
	});

})(jQuery);