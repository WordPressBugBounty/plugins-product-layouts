;(function ($) {
    $(document).ready(function () {

        /**
         * Wrapper
         */
        var WRAPPER = $('#wpte-preview-wrapper').attr('template-wrapper');
        function WPTERegExp(par = '') {
            return new RegExp(par, "g");
        }

        /**
         * Setting Draggable
         */
        // $( "#wpte_dragable" ).draggable({ handle: ".wpte-single-settings-card-header" });
        $( "#wpte_setting_bar" ).resizable({
            minWidth: 210,
            maxWidth: 500,
            resize: function(event, ui) {
                document.documentElement.style.setProperty('--wpte-sidebar-width', ui.size.width + 'px');
                $('#wpte_setting_bar').attr('data-width', ui.size.width);
            }
        });

        $('.wpte-sidebar-toggler').on('click', function() {
            var data_visibale   = $('#wpte_setting_bar').attr('data-visibale');
            var settingBarWidth = $("#wpte_setting_bar").attr('data-width');

            if ( settingBarWidth ) {
                settingBarWidth = settingBarWidth;
            } else {
                settingBarWidth = 300;
            }

            if( data_visibale == "true" ) {
                $('#wpte_setting_bar').attr('data-visibale', 'false');
                $(this).html('<i class="wpte-icon icon-arrow-7"></i>');
            } else {
                $('#wpte_setting_bar').attr('data-visibale', 'true');
                $(this).html('<i class="wpte-icon icon-arrow-6"></i>');
            }
        });

        $('.wpte-editor-avatar svg').on('mouseover', function(){
            $('.wpte-editor-dropdown-menu').slideDown();
        });
        $('.wpte-single-settings-card-header').on('mouseleave', function(){
            $('.wpte-editor-dropdown-menu').slideUp();
        });

        $('.wpte-editor-go-back').on('click', function() {
            window.history.back();
        });

        // Control Tabs
        function Wpte_control_tabs() {
            $('.wpte-product-control-type-tabs .wpte-product-type-control-tab-child:first-child').addClass('wpte-product-control-tab-active');
            $('.wpte-product-control-type-tabs .wpte-product-form-control-content-tabs:first-child').removeClass('wpte-product-form-control-tabs-close');
            $(document.body).on("click", ".wpte-product-type-control-tab-child", function () {
                $(this).siblings().removeClass("wpte-product-control-tab-active");
                $(this).addClass('wpte-product-control-tab-active');
                var index = $(this).index();
                $(this).parent().parent('.wpte-product-form-control-content-tabs').next().children('.wpte-product-form-control-content-tabs').addClass('wpte-product-form-control-tabs-close');
                $(this).parent().parent('.wpte-product-form-control-content-tabs').next().children('.wpte-product-form-control-content-tabs:eq(' + index + ')').removeClass('wpte-product-form-control-tabs-close');
            
            });
        }

        /**
         * Get Products
         */
        function get_wpte_products(lid, data) {
            $(".wpte-product-load").addClass('wpte-loading');
            setTimeout(() => {
                rawdata = $("#wpte-editor-update-form").serializeArray();
                rawdata = rawdata.filter(function(item) {
                    return item.value.trim() !== ''; // Exclude fields with empty values or only spaces
                });
                $.ajax({
                    type: 'POST',
                    url: wpteEditor.ajaxUrl,
                    data: {
                        action: "wpte_get_productc",
                        id: lid,
                        data: data,
                        rawdata: rawdata,
                        _nonce: wpteEditor.wpte_nonce
                    },
                    beforeSend: function () {
                        $(".wpte-product-load").addClass('wpte-loading');
                    },
                    success: function (response) {
                        $(".wpte-product-load").removeClass('wpte-loading');
                        if ( response ) {
                            if (window.PreviewController) {
                                window.PreviewController.updateContent(response);
                            } else {
                                $(".wpte-product-load").html(response);
                            }
                            cart_icon_text_onload();
                        } else {
                            if (window.PreviewController) {
                                window.PreviewController.updateContent("No product found!");
                            } else {
                                $(".wpte-product-load").html("No product found!");
                            }
                        }
                       
                    },
                    error: function (data) {
                        $(".wpte-product-load").removeClass('wpte-loading');
                    }
                });
            }, 3);
        }

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

        /**
         * Category DropDown using select2
         */
        $('.wpte-product-category-list').each(function (e) {
            var id = $(this).attr('id');
            var eparent = $(this).parent().attr('id');
            $('#' + id).select2({
                dropdownParent: $('#' + eparent)
            });

            $('#' + id).on('change', function (e) {
                var lid = $("#wpte-layouts-id").val();
                var Value = $('#' + id).val();
                get_wpte_products(lid, Value);

                // Condition

            });
        });

        /**
         * Product Per Page
         */
        $('.wpte-product-input-type-number').each(function (e) {
            var id = $(this).attr('id');
            var loader = $('#' + id).attr('loader');
            if (loader) {
                $('#' + id).on('input', function () {
                    var lid = $("#wpte-layouts-id").val();
                    var Value = $('#' + id).val();
                    get_wpte_products(lid, Value);
                });
            }
        });

        /**
         * Settings Main Tabs
         */
        function Wpte_settings_main_tabs() {
            $(".wpte-start-tabs-header li:first").addClass("active");
            $(".wpte-layout-content-tabs:first").addClass("active");
            $(".wpte-start-tabs-header li").on("click", function () {
                $(".wpte-start-tabs-header li").removeClass("active");
                $(".wpte-layout-content-tabs").removeClass("active");
                $(this).addClass("active");
                var activeTab = $(this).attr("ref");
                $(activeTab).addClass("active");
            });
        }

        /**
         * Settings Section Accrodion
         */
        function Wpte_section_admin_accordion() {
            $(".wpte-ac-admin-section-body:first").addClass("wpte-ac-active");
            $(".wpte-ac-admin-section-head .dashicons:first").removeClass("dashicons-arrow-right");
            $(".wpte-ac-admin-section-head .dashicons:first").addClass("dashicons-arrow-down");
            $(".wpte-ac-admin-section-head").on("click", function () {
                if ($(this).next().hasClass('wpte-ac-active')) {
                    $(".wpte-ac-admin-section-body").removeClass("wpte-ac-active");
                    $(this).children('span').removeClass("dashicons-arrow-down");
                    $(this).children('span').addClass("dashicons-arrow-right");
                } else {
                    if ( ! $(this).hasClass('wpte-po-element') ) {
                        $(".wpte-ac-admin-section-body").removeClass("wpte-ac-active");
                        $(this).next().addClass("wpte-ac-active");
                        $(".wpte-ac-admin-section-head .dashicons").addClass("dashicons-arrow-right");
                        $(".wpte-ac-admin-section-head .dashicons").removeClass("dashicons-arrow-down");
                        $(this).children('span').removeClass("dashicons-arrow-right");
                        $(this).children('span').addClass("dashicons-arrow-down");
                    }
                }

            })
        }

        /**
         * Settings Inner Accrodion
         */
        function Wpte_inner_accordion() {
            $(document).on( 'click', '.wpte-product-control-accordion-title', function(){
                if ( ! $(this).hasClass('wpte-po-element') ) {
                    $(this).parent(".wpte-product-control-content").find(".wpte-product-control-accordion-body").slideToggle();
                    $(this).parent(".wpte-product-control-content").find(".wpte-product-control-accordion-title span").toggleClass('dashicons-arrow-right');
                    $(this).parent(".wpte-product-control-content").find(".wpte-product-control-accordion-title span").toggleClass('dashicons-arrow-down');
                    $(this).parent(".wpte-product-control-content").prevAll(".wpte-product-control-content").find(".wpte-product-control-accordion-body").slideUp();
                    $(this).parent(".wpte-product-control-content").nextAll(".wpte-product-control-content").find(".wpte-product-control-accordion-body").slideUp();
                    $(this).parent(".wpte-product-control-content").prevAll(".wpte-product-control-content").find(".wpte-product-control-accordion-title span").removeClass('dashicons-arrow-down');
                    $(this).parent(".wpte-product-control-content").prevAll(".wpte-product-control-content").find(".wpte-product-control-accordion-title span").addClass('dashicons-arrow-right');
                    $(this).parent(".wpte-product-control-content").nextAll(".wpte-product-control-content").find(".wpte-product-control-accordion-title span").removeClass('dashicons-arrow-down');
                    $(this).parent(".wpte-product-control-content").nextAll(".wpte-product-control-content").find(".wpte-product-control-accordion-title span").addClass('dashicons-arrow-right');
                }
            });
        }

        /**
         * Settings Update to DB using AJAX
         */
        function wpte_editor_update_form(id, rawdata, selector, action, saving, saved) {

            $.ajax({
                type: 'POST',
                url: wpteEditor.ajaxUrl,
                data: {
                    action: action,
                    _nonce: wpteEditor.wpte_nonce,
                    wpteid: id,
                    rawdata: rawdata,
                },
                beforeSend: function () {
                    selector.text(saving);
                },
                success: function (response) {
                    selector.text(saved);
                },
                complete: function () {

                },
                error: function (data) {
                    console.log("Error")
                }

            });
        }

        $("#wpte-editor-update-form").on('submit', function (e) {
            e.preventDefault();

            $("#wpte-submit-editor-form").text('Saving...');

            setTimeout(() => {
                var id = $("#wpte-layouts-id").val();
                var rawdata = $(this).serializeArray();
                var selector = $("#wpte-submit-editor-form");
                var action = "wpte_editor_update_form";
                var saving   = 'Saving...';
                var saved   = 'Saved';

                // Filter out fields with empty values
                rawdata = rawdata.filter(function(item) {
                    return item.value.trim() !== ''; // Exclude fields with empty values or only spaces
                });

                wpte_editor_update_form(id, rawdata, selector, action, saving, saved);
            }, 3);
        });

        $(".wpte-change-shortcode-name").on('submit', function(e){
            e.preventDefault();
            var id = $("#wpte-shortcode-name-id").val();
            var data = $("#wpte-shortcode-name").val();
            var selector = $(".wpte-change-shortcode-name button");
            var action = "wpte_shortcode_update_name";
            var saving   = 'Updating...';
            var saved   = 'Updated';
            wpte_editor_update_form(id, data, selector, action, saving, saved);
        });

        // Header shortcode name change (new header layout)
        $("#addonsstylenamechange").on('click', function(e){
            e.preventDefault();
            var $form = $('#wpte-shortcode-name-change-submit');
            var id = $form.find('input[name="addonsstylenameid"]').val();
            var data = $form.find('input[name="addonsstylename"]').val();
            var selector = $(this);
            var action = "wpte_shortcode_update_name";
            var saving   = 'Saving...';
            var saved   = 'Saved';
            wpte_editor_update_form(id, data, selector, action, saving, saved);
        });

        // Copy shortcode from preview sub-header
        $(document.body).on('click', '.wpte-copy-btn', function(e){
            e.preventDefault();
            var $btn = $(this);
            var text = $btn.attr('data-shortcode') || $btn.closest('.wpte-header-shortcode').find('.wpte-shortcode-text').text().trim();
            var orig = $btn.html();
            var checkSVG = '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path></svg>';
            function showCopied(){ $btn.html(checkSVG); setTimeout(function(){ $btn.html(orig); }, 3000); }
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function(){ showCopied(); }).catch(function(){
                    var $temp = $('<textarea>');
                    $('body').append($temp);
                    $temp.val(text).select();
                    document.execCommand('copy');
                    $temp.remove();
                    showCopied();
                });
            } else {
                var $temp = $('<textarea>');
                $('body').append($temp);
                $temp.val(text).select();
                document.execCommand('copy');
                $temp.remove();
                showCopied();
            }
        });

        /**
         * 
         * Responsive Controler
         */
        function Wpte_Product_layout_responsive_control() {
            $('.wpte-product-form-control').each(function (e) {
                if ($(this).hasClass('wpte-product-form-responsive-tab')) {
                    $(this).addClass('wpte-product-responsive-display-none');
                } else if ($(this).hasClass('wpte-product-form-responsive-mobile')) {
                    $(this).addClass('wpte-product-responsive-display-none');
                }
            });
            $(document.body).on("click", ".wpte-form-responsive-switcher-desktop", function () {
                $("#wpte-editor-update-form").toggleClass('wpte-responsive-switchers-open');
                $(".wpte-form-responsive-switcher-tablet").removeClass('active');
                $(".wpte-form-responsive-switcher-mobile").removeClass('active');
                $(".wpte-product-form-responsive-laptop").removeClass('wpte-product-responsive-display-none');
                $(".wpte-product-form-responsive-tab").addClass('wpte-product-responsive-display-none');
                $(".wpte-product-form-responsive-mobile").addClass('wpte-product-responsive-display-none');
                
                if (window.PreviewController) {
                    PreviewController.switchDevice('desktop');
                }
            });
            $(document.body).on("click", ".wpte-form-responsive-switcher-tablet", function () {
                $(".wpte-form-responsive-switcher-tablet").addClass('active');
                $(".wpte-form-responsive-switcher-mobile").removeClass('active');
                $(".wpte-product-form-responsive-laptop").addClass('wpte-product-responsive-display-none');
                $(".wpte-product-form-responsive-tab").removeClass('wpte-product-responsive-display-none');
                $(".wpte-product-form-responsive-mobile").addClass('wpte-product-responsive-display-none');

                if (window.PreviewController) {
                    PreviewController.switchDevice('tablet');
                }
            });
            $(document.body).on("click", ".wpte-form-responsive-switcher-mobile", function () {
                $(".wpte-form-responsive-switcher-tablet").removeClass('active');
                $(".wpte-form-responsive-switcher-mobile").addClass('active');
                $(".wpte-product-form-responsive-laptop").addClass('wpte-product-responsive-display-none');
                $(".wpte-product-form-responsive-tab").addClass('wpte-product-responsive-display-none');
                $(".wpte-product-form-responsive-mobile").removeClass('wpte-product-responsive-display-none');

                if (window.PreviewController) {
                    PreviewController.switchDevice('mobile');
                }
            });
        }

        /**
         * Multiple Selector Handler
         */
        function Wpte_Multiple_Selector_Handler($value) {
            return $value.replace(/{{[0-9a-zA-Z.?:_-]+}}/g, function (match, contents, offset, input_string) {
                var m = match.replace(/{{/g, "").replace(/}}/g, "");
                var arr = m.split('.');
                if (m.indexOf("SIZE") != -1) {
                    m = m.replace(/.SIZE/g, $("#" + arr[0] + '-size').val());
                }
                if (m.indexOf("UNIT") != -1) {
                    m = m.replace(/.UNIT/g, $("#" + arr[0] + '-choices').val());
                }
                if (m.indexOf("VALUE") != -1) {
                    m = m.replace(/.VALUE/g, $("#" + arr[0]).val());
                }
                m = m.replace(WPTERegExp(arr[0]), '');
                return m;
            });
        }

        /**
         * Range Slider
         */
        function WpteFormSliderINT(ID = '') {
            $this = $('.wpte-product-form-slider');
            if (ID !== '') {
                $this = ID.find('.wpte-product-form-slider');
            }

            $this.each(function (key, value) {
                var $This = $(this);

                var $input = $This.siblings('.wpte-product-form-slider-input').children('input');
                var step = parseFloat($(this).siblings('.wpte-product-form-slider-input').children('input').attr('step'));
                var min = parseFloat($(this).siblings('.wpte-product-form-slider-input').children('input').attr('min'));
                var max = parseFloat($(this).siblings('.wpte-product-form-slider-input').children('input').attr('max'));
                if (step % 1 == 0) {
                    decimals = 0;
                } else if (step % 0.1 == 0) {
                    decimals = 1;
                } else if (step % 0.01 == 0) {
                    decimals = 2;
                } else {
                    decimals = 3;
                }

                noUiSlider.create(value, {
                    animate: true,
                    start: $input.val(),
                    step: step,
                    connect: 'lower',
                    range: {
                        'min': min,
                        'max': max
                    },
                    format: wNumb({
                        decimals: decimals
                    })
                });

                value.noUiSlider.on('slide', function (val) {
                    $input.val(val);
                    $custom = $input.attr("custom");
                    if ($input.attr("retundata") !== '') {
                        if ($custom === '') {
                            var $data = JSON.parse($input.attr("retundata"));
                            $.each($data, function (el, obj) {
                                if (el.indexOf('{{KEY}}') != -1) {
                                    el = el.replace(WPTERegExp("{{KEY}}"), $input.attr('name').split('saarsa')[1]);
                                }

                                var cls = el.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                                var Cval = obj.replace(WPTERegExp("{{SIZE}}"), val);
                                Cval = Cval.replace(WPTERegExp("{{UNIT}}"), $input.attr('unit'));
                                if (Cval.indexOf("{{") != -1) {
                                    Cval = Wpte_Multiple_Selector_Handler(Cval);
                                }
                                if (window.PreviewController) {
                                    PreviewController.injectStyles(Cval, cls, $input.attr('responsive'));
                                } else {
                                    if ($input.attr('responsive') === 'tab') {
                                        $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                    } else if ($input.attr('responsive') === 'mobile') {
                                        $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                    } else {
                                        $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                                    }
                                }
                            });

                        } else {
                            var $data = JSON.parse($input.attr("retundata"));
                            $custom = $custom.split("|||||");
                            $id = $custom[0];
                            $VALUE = '';
                            if ($custom[1] === 'text-shadow') {
                                $color = $('#' + $id + "-color").val();
                                $blur = $('#' + $id + "-blur-size").val();
                                $horizontal = $('#' + $id + "-horizontal-size").val();
                                $vertical = $('#' + $id + "-vertical-size").val();
                                $true = (($blur === '0' && $horizontal === '0' && $vertical === '0') || !$blur || !$horizontal || !$vertical) ? true : false;
                                if ($true === false) {
                                    $VALUE = 'text-shadow: ' + $horizontal + 'px ' + $vertical + 'px ' + $blur + 'px ' + $color + ';';
                                }
                            } else if ($custom[1] === 'box-shadow') {
                                var type = $('input[name="' + $id + '-type"]:checked').val(),
                                    color = $('#' + $id + "-color").val(),
                                    blur = $('#' + $id + "-blur-size").val(),
                                    spread = $('#' + $id + "-spread-size").val(),
                                    horizontal = $('#' + $id + "-horizontal-size").val();
                                vertical = $('#' + $id + "-vertical-size").val(),
                                    wtrue = ((blur === '0' && spread === '0' && horizontal === '0' && vertical === '0') || !blur || !spread || !horizontal || !vertical) ? true : false;
                                if (wtrue === false) {
                                    $VALUE = 'box-shadow: ' + type + ' ' + horizontal + 'px ' + vertical + 'px ' + blur + 'px ' + spread + 'px ' + color + ';';
                                }
                            }
                            $.each($data, function (el, obj) {
                                if (el.indexOf('{{KEY}}') != -1) {
                                    el = el.replace(WPTERegExp("{{KEY}}"), $input.attr('name').split('saarsa')[1]);
                                }
                                var cls = el.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                                var Cval = $VALUE;
                                if (Cval.indexOf("{{") != -1) {
                                    Cval = Wpte_Multiple_Selector_Handler(Cval);
                                }

                                if (window.PreviewController) {
                                    PreviewController.injectStyles(Cval, cls, $input.attr('responsive'));
                                } else {
                                    if ($input.attr('responsive') === 'tab') {
                                        $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                    } else if ($input.attr('responsive') === 'mobile') {
                                        $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                    } else {
                                        $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                                    }
                                }
                            });
                        }
                    }
                });
            });

            $(".wpte-product-form-slider-input input").on("keyup", function () {
                var $input = $(this);
                $custom = $input.attr("custom");
                var html5Slider = $(this).parent().siblings('.wpte-product-form-slider');
                html5Slider = html5Slider[0];
                var val = $(this).val();
                html5Slider.noUiSlider.set(val);

                if ($input.attr("retundata") !== '') {
                    if ($custom === '') {
                        var $data = JSON.parse($input.attr("retundata"));
                        $.each($data, function (el, obj) {
                            if (el.indexOf('{{KEY}}') != -1) {
                                el = el.replace(WPTERegExp("{{KEY}}"), $input.attr('name').split('saarsa')[1]);
                            }

                            var cls = el.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                            var Cval = obj.replace(WPTERegExp("{{SIZE}}"), val);
                            Cval = Cval.replace(WPTERegExp("{{UNIT}}"), $input.attr('unit'));
                            if (Cval.indexOf("{{") != -1) {
                                Cval = Wpte_Multiple_Selector_Handler(Cval);
                            }
                            if (window.PreviewController) {
                                PreviewController.injectStyles(Cval, cls, $input.attr('responsive'));
                            } else {
                                if ($input.attr('responsive') === 'tab') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else if ($input.attr('responsive') === 'mobile') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else {
                                    $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                                }
                            }
                        });
                    } else {
                        var $data = JSON.parse($input.attr("retundata"));
                        $custom = $custom.split("|||||");
                        $id = $custom[0];
                        $VALUE = '';
                        if ($custom[1] === 'text-shadow') {
                            $color = $('#' + $id + "-color").val();
                            $blur = $('#' + $id + "-blur-size").val();
                            $horizontal = $('#' + $id + "-horizontal-size").val();
                            $vertical = $('#' + $id + "-vertical-size").val();
                            $true = (($blur === '0' && $horizontal === '0' && $vertical === '0') || !$blur || !$horizontal || !$vertical) ? true : false;
                            if ($true === false) {
                                $VALUE = 'text-shadow: ' + $horizontal + 'px ' + $vertical + 'px ' + $blur + 'px ' + $color + ';';
                            }
                        } else if ($custom[1] === 'box-shadow') {
                            var type = $('input[name="' + $id + '-type"]:checked').val(),
                                color = $('#' + $id + "-color").val(),
                                blur = $('#' + $id + "-blur-size").val(),
                                spread = $('#' + $id + "-spread-size").val(),
                                horizontal = $('#' + $id + "-horizontal-size").val();
                            vertical = $('#' + $id + "-vertical-size").val(),
                                wtrue = ((blur === '0' && spread === '0' && horizontal === '0' && vertical === '0') || !blur || !spread || !horizontal || !vertical) ? true : false;
                            if (wtrue === false) {
                                $VALUE = 'box-shadow: ' + type + ' ' + horizontal + 'px ' + vertical + 'px ' + blur + 'px ' + spread + 'px ' + color + ';';
                            }
                        }
                        $.each($data, function (el, obj) {
                            if (el.indexOf('{{KEY}}') != -1) {
                                el = el.replace(WPTERegExp("{{KEY}}"), $input.attr('name').split('saarsa')[1]);
                            }
                            var cls = el.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                            var Cval = $VALUE;
                            if (Cval.indexOf("{{") != -1) {
                                Cval = Wpte_Multiple_Selector_Handler(Cval);
                            }
                            if (window.PreviewController) {
                                PreviewController.injectStyles(Cval, cls, $input.attr('responsive'));
                            } else {
                                if ($input.attr('responsive') === 'tab') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else if ($input.attr('responsive') === 'mobile') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else {
                                    $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                                }
                            }
                        });
                    }
                }

            });

            $(".wpte-product-control-type-slider .wpte-product-form-units-choices-label").click(function () {
                var id = "#" + $(this).attr('for');
                var input = $(this).parent().siblings('.wpte-product-form-control-input-wrapper').children('.wpte-product-form-slider-input').children('input');
                input.attr('min', $(id).attr('min'));
                input.attr('max', $(id).attr('max'));
                input.attr('step', $(id).attr('step'));
                input.attr('unit', $(id).val());
                var step = parseFloat($(id).attr('step'));
                var min = parseFloat($(id).attr('min'));
                var max = parseFloat($(id).attr('max'));
                var start = input.attr('default-value');
                if (step % 1 == 0) {
                    decimals = 0;
                } else if (step % 0.1 == 0) {
                    decimals = 1;
                } else if (step % 0.01 == 0) {
                    decimals = 2;
                } else {
                    decimals = 3;
                }

                var html5Slider = $(this).parent().siblings('.wpte-product-form-control-input-wrapper').children('.wpte-product-form-slider');
                html5Slider = html5Slider[0];
                html5Slider.noUiSlider.updateOptions({
                    start: start,
                    step: step,
                    range: {
                        'min': min,
                        'max': max
                    },
                    format: wNumb({
                        decimals: decimals
                    })
                });
            });

        }

        /**
         * Dimentions
         */
        function wpte_product_dimention() {
            $(".wpte-product-form-link-dimensions").on("click", function () {
                $(this).toggleClass("link-dimensions-unlink");
            });

            $(".wpte-product-control-type-dimensions .wpte-product-form-units-choices-label").click(function () {
                var id = "#" + $(this).attr('for');
                var input = $(this).parent().siblings('.wpte-product-form-control-input-wrapper').children('.wpte-product-control-dimentions').children('li').children('input');
                input.attr('min', $(id).attr('min'));
                input.attr('max', $(id).attr('max'));
                input.attr('step', $(id).attr('step'));

            });

            $(".wpte-product-control-dimention input").on("input", function () {
                $this = $(this);
                if ($this.parent().siblings('.wpte-product-control-dimention').children('.wpte-product-form-link-dimensions').hasClass('link-dimensions-unlink')) {
                    if ($this.val() === '') {
                        $this.val(0);
                    }
                    $siblings = $this.parent().siblings('.wpte-product-control-dimention').children('input');
                    $.each($siblings, function (e, o) {
                        if ($(this).val() === '') {
                            $(this).val(0);
                        }
                    });
                } else {
                    var value = $this.val();
                    $this.parent().siblings('.wpte-product-control-dimention').children('input').val(value);
                }

                $input = $this;
                $InputID = $input.attr('input-id');
                UNIT = $InputID + '-choices';
                TOP = $InputID + '-top';
                RIGHT = $InputID + '-right';
                BOTTOM = $InputID + '-bottom';
                LEFT = $InputID + '-left';
                if ($input.attr("retundata") !== '' && $input.attr('type') !== 'radio') {
                    var $data = JSON.parse($input.attr("retundata"));
                    $.each($data, function (el, obj) {
                        if (el.indexOf('{{KEY}}') != -1) {
                            el = el.replace(WPTERegExp("{{KEY}}"), $input.attr('name').split('saarsa')[1]);
                        }
                        var cls = el.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                        var type = $("input[name=\"" + UNIT + "\"]").attr('type');
                        if (type === 'hidden') {
                            Cval = obj.replace(WPTERegExp("{{UNIT}}"), $('#' + UNIT).val());
                        } else {
                            var Cval = obj.replace(WPTERegExp("{{UNIT}}"), $("input[name=\"" + UNIT + "\"]:checked").val());
                        }
                        Cval = Cval.replace(WPTERegExp("{{TOP}}"), $('#' + TOP).val());
                        Cval = Cval.replace(WPTERegExp("{{RIGHT}}"), $('#' + RIGHT).val());
                        Cval = Cval.replace(WPTERegExp("{{BOTTOM}}"), $('#' + BOTTOM).val());
                        Cval = Cval.replace(WPTERegExp("{{LEFT}}"), $('#' + LEFT).val());
                        if (window.PreviewController) {
                            PreviewController.injectStyles(Cval, cls, $input.attr('responsive'));
                        } else {
                            if ($input.attr('responsive') === 'tab') {
                                $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                            } else if ($input.attr('responsive') === 'mobile') {
                                $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                            } else {
                                $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                            }
                        }
                    });

                }

            });
        }

        /**
         * Select Field
         */
        function Wpte_selector_control() {
            $('.wpte-product-select-input').each(function (e) {
                var id = $(this).attr('id');
                var elparent = $(this).parent().attr('id');
                var loader = $('#' + id).attr('loader');
                $('#' + id).select2({
                    dropdownParent: $('#' + elparent)
                });

                if (loader) {

                    $('#' + id).on('change', function (e) {
                        var lid = $("#wpte-layouts-id").val();
                        var Value = $('#' + id).val();
                        get_wpte_products(lid, Value);
                    });
                }
            });

            $(".wpte-product-control-type-select select").on("change", function (e) {
                $input = $(this);
                if ($input.attr("retundata") !== '') {
                    id = $(this).attr('id');
                    var arr = [];
                    $("#" + id + " option").each(function () {
                        arr.push($(this).val());
                    });
                    var $data = JSON.parse($input.attr("retundata"));
                    $.each($data, function (key, obj) {
                        if (key.indexOf('{{KEY}}') != -1) {
                            key = key.replace(WPTERegExp("{{KEY}}"), $input.attr('name').split('saarsa')[1]);
                        }
                        $.each(obj, function (k, o) {
                            var cls = key.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                            if (o.type === 'CSS') {
                                var Cval = o.value.replace(WPTERegExp("{{VALUE}}"), $input.val());
                                if (window.PreviewController) {
                                    PreviewController.injectStyles(Cval, cls, $input.attr('responsive'));
                                } else {
                                    if ($input.attr('responsive') === 'tab') {
                                        $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                    } else if ($input.attr('responsive') === 'mobile') {
                                        $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                    } else {
                                        $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                                    }
                                }
                            } else {
                                if (window.PreviewController) {
                                    PreviewController.updateClasses(cls, arr, $input.val());
                                } else {
                                    $.each(arr, function (i, v) {
                                        $(cls).removeClass(v);
                                    });
                                    $(cls).addClass($input.val());
                                }
                            }

                        });
                    });

                }

            });
        }

        /**
         * Mini Color
         */
        function Wpte_product_minicolor_control() {
            $('.wpte-product-minicolor').each(function () {
                $(this).minicolors({
                    control: $(this).attr('data-control') || 'hue',
                    defaultValue: $(this).attr('data-defaultValue') || '',
                    format: $(this).attr('data-format') || 'hex',
                    keywords: $(this).attr('data-keywords') || 'transparent' || 'initial' || 'inherit',
                    inline: $(this).attr('data-inline') === 'true',
                    letterCase: $(this).attr('data-letterCase') || 'lowercase',
                    opacity: $(this).attr('data-opacity'),
                    position: $(this).attr('data-position') || 'bottom left',
                    swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
                    change: function (value, opacity) {
                        if (!value)
                            return;
                        if (opacity)
                            value += ', ' + opacity;
                        if (typeof console === 'object') {
                            // console.log(value);
                        }
                    },
                    theme: 'bootstrap'
                });
            });

            $(".wpte-product-control-type-color input").on("keyup, change", function () {
                $input = $(this);
                $custom = $input.attr("custom");
                if ($input.attr("retundata") !== '') {
                    if ($custom === '') {
                        var $data = JSON.parse($input.attr("retundata"));
                        $.each($data, function (el, obj) {
                            if (el.indexOf('{{KEY}}') != -1) {
                                el = el.replace(WPTERegExp("{{KEY}}"), $input.attr('name').split('saarsa')[1]);
                            }
                            var cls = el.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                            var Cval = obj.replace(WPTERegExp("{{VALUE}}"), $input.val());

                            if (window.PreviewController) {
                                PreviewController.injectStyles(Cval, cls, $input.attr('responsive'));
                            } else {
                                if ($input.attr('responsive') === 'tab') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else if ($input.attr('responsive') === 'mobile') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else {
                                    $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                                }
                            }
                        });
                        if ($input.val() === '') {
                            $input.siblings('.minicolors-swatch').children('.minicolors-swatch-color').css('background-color', 'transparent');
                        }
                    } else {
                        var $data = JSON.parse($input.attr("retundata"));
                        $custom = $custom.split("|||||");
                        $id = $custom[0];
                        $VALUE = '';
                        if ($custom[1] === 'text-shadow') {
                            $color = $('#' + $id + "-color").val();
                            $blur = $('#' + $id + "-blur-size").val();
                            $horizontal = $('#' + $id + "-horizontal-size").val();
                            $vertical = $('#' + $id + "-vertical-size").val();
                            $true = (($blur === '0' && $horizontal === '0' && $vertical === '0') || !$blur || !$horizontal || !$vertical) ? true : false;
                            if ($true === false) {
                                $VALUE = 'text-shadow: ' + $horizontal + 'px ' + $vertical + 'px ' + $blur + 'px ' + $color + ';';
                            }
                        } else if ($custom[1] === 'box-shadow') {
                            $type = $('input[name="' + $id + '-type"]:checked').val();
                            $color = $('#' + $id + "-color").val();
                            $blur = $('#' + $id + "-blur-size").val();
                            $spread = $('#' + $id + "-spread-size").val();
                            $horizontal = $('#' + $id + "-horizontal-size").val();
                            $vertical = $('#' + $id + "-vertical-size").val();
                            $true = (($blur === '0' && $spread === '0' && $horizontal === '0' && $vertical === '0') || !$blur || !$spread || !$horizontal || !$vertical) ? true : false;
                            if ($true === false) {
                                $VALUE = 'box-shadow: ' + $type + ' ' + $horizontal + 'px ' + $vertical + 'px ' + $blur + 'px ' + $spread + 'px ' + $color + ';';
                            }
                        }

                        $.each($data, function (el, obj) {
                            if (el.indexOf('{{KEY}}') != -1) {
                                el = el.replace(WPTERegExp("{{KEY}}"), $input.attr('name').split('saarsa')[1]);
                            }
                            var cls = el.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                            var Cval = $VALUE;
                            if (window.PreviewController) {
                                PreviewController.injectStyles(Cval, cls, $input.attr('responsive'));
                            } else {
                                if ($input.attr('responsive') === 'tab') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else if ($input.attr('responsive') === 'mobile') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else {
                                    $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                                }
                            }
                        });
                    }
                }
            });
        }

        /**
         * Gradient Color
         */
        function Wpte_product_gradient_color_control() {
            $(".wpte-product-gradient-color").each(function (i, v) {
                $(this).coloringPick({
                    "show_input": true,
                    "theme": "dark",
                    'destroy': false,
                    change: function (val) {
                        $data = [];
                        var $This = $(this).children('input');
                        // console.log($(this).children('input'));
                        var _VALUE = $This.val();
                        $id = $This.attr('background');
                        $imagecheck = $("#" + $id + "-img").is(":checked");
                        $imagesource = $('input[name="' + $id + '-select"]:checked').val();
                        $Image = ($imagecheck === true ? ($imagesource === 'media-library' ? $("#" + $id + "-image").val() : $("#" + $id + "-url").val()) : '');
                        var wordcount = val.split(/\b[\s,\.-:;]*/).length;
                        var limitWord = 23;
                        if ($Image === '') {
                            if (wordcount < limitWord) {
                                $BACKGROUND = 'background: ' + _VALUE + ';';
                            } else {
                                $BACKGROUND = ' background:-ms-' + _VALUE + '; background:-webkit-' + _VALUE + '; background:-moz-' + _VALUE + '; background:-o-' + _VALUE + '; background:' + _VALUE + ';';
                            }
                        } else {
                            if (wordcount < limitWord) {
                                $BACKGROUND = 'background:linear-gradient(0deg, ' + _VALUE + ' 0%, ' + _VALUE + ' 100%), url(\'' + $Image + '\') ' + $("#" + $id + "-repeat").val() + ' ' + $("#" + $id + "-position").val() + ';';
                            } else {
                                $BACKGROUND = 'background:' + _VALUE + ', url(\'' + $Image + '\' ) ' + $("#" + $id + "-repeat").val() + ' ' + $("#" + $id + "-position-lap").val() + ';';
                            }
                        }
                        var $data = ($This.attr("retundata") !== '' ? JSON.parse($This.attr("retundata")) : []);
                        $.each($data, function (el, obj) {
                            if (el.indexOf('{{KEY}}') != -1) {
                                el = el.replace(WPTERegExp("{{KEY}}"), $This.attr('name').split('saarsa')[1]);
                            }
                            var cls = el.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                            Cval = $BACKGROUND;
                            if (window.PreviewController) {
                                PreviewController.injectStyles(Cval, cls, $This.attr('responsive'));
                            } else {
                                if ($This.attr('responsive') === 'tab') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else if ($This.attr('responsive') === 'mobile') {
                                    $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                } else {
                                    $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                                }
                            }
                        });
                    },
                });
            });
        }

        /**
         * Popover Control
         */
        function Wpte_popover_control() {
            $(document.body).on("click", ".wpte-product-popover-set", function (event) {
                $(".wpte-product-form-control").not($(this).parents()).removeClass('popover-active');
                $(this).closest(".wpte-product-form-control").toggleClass('popover-active');
                event.stopPropagation();
            });
        }

        /**
         * Choose Control
         */
        function Wpte_product_choose() {
            $(document.body).on("click", ".wpte-product-control-type-choose input", function (e) {
                name = $(this).attr('name');
                $value = $(this).val();
                if ($(this).parent('.wpte-product-form-choices').attr("retundata") !== '') {
                    var arr = [];
                    $("input[name=" + name + "]").each(function () {
                        arr.push($(this).val());
                    });
                    $input = $(this).parent('.wpte-product-form-choices');
                    var $data = JSON.parse($input.attr("retundata"));
                    $.each($data, function (key, obj) {
                        if (key.indexOf('{{KEY}}') != -1) {
                            key = key.replace(WPTERegExp("{{KEY}}"), name.split('saarsa')[1]);
                        }
                        $.each(obj, function (k, o) {
                            var cls = key.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER);
                            if (o.type === 'CSS') {
                                var Cval = o.value.replace(WPTERegExp("{{VALUE}}"), $value);
                                if (window.PreviewController) {
                                    PreviewController.injectStyles(Cval, cls, $input.attr('responsive'));
                                } else {
                                    if ($input.attr('responsive') === 'tab') {
                                        $("#wpte-product-preview-data").append('<style>@media only screen and (min-width : 669px) and (max-width : 993px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                    } else if ($input.attr('responsive') === 'mobile') {
                                        $("#wpte-product-preview-data").append('<style>@media only screen and (max-width : 668px){#wpte-product-preview-data ' + cls + '{' + Cval + '}} < /style>');
                                    } else {
                                        $("#wpte-product-preview-data").append('<style>#wpte-product-preview-data ' + cls + '{' + Cval + '} < /style>');
                                    }
                                }
                            } else {
                                $.each(arr, function (i, v) {
                                    $(cls).removeClass(v);
                                });
                                $(cls).addClass($value);
                            }
                        });
                    });
                }
        
            });
        }

        /**
         * Page Shortcode
         */
        function Wpte_single_page_shortcode() {
            
            $(".wpte-card-info .wpte-card-heading").on('click', function(){
                $(this).next().slideToggle();
                $(this).find(".dashicons-arrow-down").toggleClass("card-icon-hide");
                $(this).find(".dashicons-arrow-right").toggleClass("card-icon-hide");
            });
        }

        /**
         * Product Icons
         */
        function Wpte_product_icons() {

            var SelectorClass = $('.wpte-product-admin-icon-selector');

            SelectorClass.each(function(i, v){

                var IconSelector = $('.wpte-product-admin-icon-selector .'+$(this).children().attr('class'));

                IconSelector.iconpicker();

                IconSelector.on('change', function() {
                    $('.'+$(this).attr('id')).html(`<i class='${IconSelector.val()}'></i>`);
                });
                
            });
        }
        
        /**
         * Product Cart Icons
         */
        function Wpte_product_cart_icon() {

            $('#wpte-product-cart-icon').on('change', function() {
                var cart_icon = $(this).val();
                if (window.PreviewController) {
                    // Update icon attribute directly to preserve text if present
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon .ajax_add_to_cart i', 'class', cart_icon);
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon .product_type_simple i', 'class', cart_icon);
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon-text .ajax_add_to_cart i', 'class', cart_icon);
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon-text .product_type_simple i', 'class', cart_icon);
                } else {
                    $('.wpte-product-add-cart-icon .ajax_add_to_cart').html(`<i class='${cart_icon}'></i>`);
                    $('.wpte-product-add-cart-icon .product_type_simple').html(`<i class='${cart_icon}'></i>`);
                }
            });

            $('#wpte-product-grouped-icon').on('change', function() {
                var groupde_icon = $(this).val();
                if (window.PreviewController) {
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon .product_type_grouped i', 'class', groupde_icon);
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon-text .product_type_grouped i', 'class', groupde_icon);
                } else {
                    $(".wpte-product-add-cart-icon .product_type_grouped").html(`<i class='${groupde_icon}'></i>`);
                }
            });

            $('#wpte-product-external-icon').on('change', function() {
                var external_icon = $(this).val();
                if (window.PreviewController) {
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon .product_type_external i', 'class', external_icon);
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon-text .product_type_external i', 'class', external_icon);
                } else {
                    $(".wpte-product-add-cart-icon .product_type_external").html(`<i class='${external_icon}'></i>`);
                }
            });

            $('#wpte-product-variable-icon').on('change', function() {
                var variable_icon = $(this).val();
                if (window.PreviewController) {
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon .product_type_variable i', 'class', variable_icon);
                    PreviewController.updateAttribute('.wpte-product-add-cart-icon-text .product_type_variable i', 'class', variable_icon);
                } else {
                    $(".wpte-product-add-cart-icon .product_type_variable").html(`<i class='${variable_icon}'></i>`);
                }
            });
        }

        /**
         * Text Render
         */
        function Wpte_product_text_render() {
            var Selector = $('.wpte-product-admin-text');
            Selector.each(function(i, v){
                var TextSelector = $('.wpte-product-admin-text .'+$(this).children().attr('class'));
                TextSelector.on('keyup', function(){
                    $('.'+$(this).attr('id')).html(`${TextSelector.val()}`);
                })
            });
        }

        /**
         * Condition
         */
        function Wpte_product_layout_condition(){
            $("[data-condition]").each(function (index, value) {
                $(this).addClass('wpte-product-form-conditionize');
            });
    
            $('.wpte-product-form-conditionize').conditionize();
        }

        /**
         * Switcher
         */
        function Wpte_product_layout_switcher() {
            $('.wpte-product-layout-switcher').on('change', function(){
                var not_loader = $(this).attr('not_loader'),
                ref_class  = $(this).attr('ref_calss'),
                lid = $("#wpte-layouts-id").val(),
                Value = $('#wpte_product_layout_cart_icon_switcher').val();

                if ( 'yes' === not_loader ) {
                    $('.'+ref_class).toggle();
                } else {
                    get_wpte_products(lid, Value);
                }

            }); 
        }

        /**
         * Font Family
         */
        function Wpte_font_family(){

            function applyFont(font, selector) {

                var cls = selector.replace(WPTERegExp("{{WRAPPER}}"), WRAPPER),
                    data = JSON.parse(cls);
    
                // Replace + signs with spaces for css
                font = font.replace(/\+/g, ' ');
        
                // Split font into family and weight
                font = font.split(':');
        
                var fontFamily = font[0];
                // var fontWeight = font[1] || 400;
    
                $.each(data, function (key, obj) {
                    // Set selected font on paragraphs
                    $(key).css({fontFamily:"'"+fontFamily});
                });
    
            }
    
            $('.wpte-product-font-family').each(function (index, value) {
    
                const id = $(this).attr('id');
                const retundata = $(this).attr('retundata');
    
                $('#'+id).fontselect({
                    // systemFonts: ['Arial','Times+New+Roman', 'Verdana'],
                    // localFonts: ['Action+Man', 'Bauer', 'Bubble'],
                    // googleFonts: ['Piedra', 'Questrial', 'Ribeye'],
                    // localFontsUrl: 'fonts/' // End with a slash!
                 })
                 .on('change', function() {
                    applyFont(this.value, retundata);
                 });
            });
    
        }

        /**
         * Show or Hide Filter
         */
        $('#wpte_product_layout_filter_preset').on('change', function(){
            if ( 'none' !== $(this).val() ) {
                
                $('.wpte-product-filter-wrapper').removeClass('wpte-show-filter wpte-top-bar');
                $('.wpte-product-filter-wrapper').removeClass('wpte-show-filter wpte-left-side-bar');
                $('.wpte-product-filter-wrapper').removeClass('wpte-show-filter wpte-right-side-bar');
                $('.wpte-product-filter-wrapper').parent().removeClass('wpte-left-sidebar-wrapper');
                $('.wpte-product-filter-wrapper').parent().removeClass('wpte-right-sidebar-wrapper');
                
                if ( 'top_bar' === $(this).val() ) {
                    $('.wpte-product-filter-wrapper').addClass('wpte-show-filter wpte-top-bar');
                }
                if ( 'left_side_bar' === $(this).val() ) {
                    $('.wpte-product-filter-wrapper').addClass('wpte-show-filter wpte-left-side-bar');
                    $('.wpte-product-filter-wrapper').parent().addClass('wpte-left-sidebar-wrapper');
                }
                if ( 'right_side_bar' === $(this).val() ) {
                    $('.wpte-product-filter-wrapper').addClass('wpte-show-filter wpte-right-side-bar');
                    $('.wpte-product-filter-wrapper').parent().addClass('wpte-right-sidebar-wrapper');
                }

            } else {
                $('.wpte-product-filter-wrapper').removeClass('wpte-show-filter');
            }
        });

        /**
          * Call Functions
          */
        WpteFormSliderINT();
        Wpte_settings_main_tabs();
        Wpte_section_admin_accordion();
        Wpte_inner_accordion();
        Wpte_Product_layout_responsive_control();
        wpte_product_dimention();
        Wpte_selector_control();
        Wpte_product_minicolor_control();
        
        // Dynamically update the iframe background color when color picker changes
        $("#wpte-preview-bg-color").on("change", function (e) {
            var $input = $(this).val();
            var iframe = document.getElementById('wpte-preview-iframe');
            if (iframe && iframe.contentDocument) {
                $(iframe.contentDocument.body).css('background-color', $input);
            }
        });

        Wpte_product_gradient_color_control();
        Wpte_popover_control();
        Wpte_product_choose();
        Wpte_single_page_shortcode();
        Wpte_product_icons();
        Wpte_product_text_render();
        Wpte_product_cart_icon();
        Wpte_product_layout_condition();
        Wpte_product_layout_switcher();
        Wpte_control_tabs();
        Wpte_font_family();
        
        function Wpte_sync_device_toggle(device){
            var $group = $('.wpte-header-devices .wpte-device-btn');
            $group.removeClass('active');
            $group.filter('[data-device="' + device + '"]').addClass('active');
        }

        $(document.body).on('click', '.wpte-device-btn', function(){
            var device = $(this).data('device');
            
            $('#wpte-editor-update-form').addClass('wpte-responsive-switchers-open');
            Wpte_sync_device_toggle(device);
            $('#wpte-editor-update-form .wpte-form-responsive-switcher-' + device).trigger('click');
            
            // Trigger preview device change
            if (window.PreviewController) {
                window.PreviewController.switchDevice(device);
            } else {
                console.error('PreviewController not found!');
            }
        });

        $(document.body).on('click', '.wpte-form-responsive-switcher-desktop, .wpte-form-responsive-switcher-tablet, .wpte-form-responsive-switcher-mobile', function(){
            var device = $(this).hasClass('wpte-form-responsive-switcher-desktop') ? 'desktop' : ($(this).hasClass('wpte-form-responsive-switcher-tablet') ? 'tablet' : 'mobile');
            Wpte_sync_device_toggle(device);
        });
        
        function Wpte_copy_shortcode(){
            $(document.body).on('click', '.wpte-copy-shortcode', function(e){
                e.preventDefault();
                var $btn = $(this);
                var $pill = $(this).closest('.wpte-shortcode-inline').find('.wpte-shortcode-pill');
                var text = $pill.attr('data-shortcode') || $pill.text().trim();
                text = text.replace(/\\"/g, '"');
                if (!/id\s*=\s*"/.test(text)) {
                    text = text.replace(/id=(["']?)([^\]"']+)(["']?)/, 'id="$2"');
                }
                var copied = false;
                var orig = $btn.html();
                var checkSVG = '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path></svg>';
                function showCopied(){ $btn.html(checkSVG); setTimeout(function(){ $btn.html(orig); }, 3000); }
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(function(){
                        copied = true;
                        showCopied();
                    }).catch(function(){
                        var $temp = $('<textarea>');
                        $('body').append($temp);
                        $temp.val(text).select();
                        copied = document.execCommand('copy');
                        $temp.remove();
                        if (copied) { showCopied(); }
                    });
                } else {
                    var $temp = $('<textarea>');
                    $('body').append($temp);
                    $temp.val(text).select();
                    copied = document.execCommand('copy');
                    $temp.remove();
                    if (copied) { showCopied(); }
                }
            });
        }
        Wpte_copy_shortcode();

    });
})(jQuery);