;(function ($) {

    function Product_Layout_Create_New( name, style_name, rawdata, stylesheet) {

        $.ajax({
            type: 'POST',
            url : wpteLayout.ajaxUrl,
            data: {
                action: "wpte_create_new_layout",
                _nonce: wpteLayout.wpte_nonce, 
                name: name,
                style_name: style_name,
                rawdata: rawdata,
                stylesheet: stylesheet,
            },
            beforeSend: function () {
               $("#create-loader").addClass("create-loader");
            },
            success: function(response){
                if ( response.success ) {
                    setTimeout(function(){ 
                        document.location.href = response.data.url;
                    }, 2000);
                } 
            },
            complete: function(){
               
            },
            error: function(data) {
               
            }

        }); 
    }

    function get_product_layout_by_id( id ) {

        $.ajax({
            type: 'POST',
            url : wpteLayout.ajaxUrl,
            data: {
                action: "wpte_clone_layout",
                _nonce: wpteLayout.wpte_nonce, 
                id: id
            },
            beforeSend: function () {

            },
            success: function(response){
                $('.wpte-wpl-list-data-table').append(`<textarea style="display:none" id="wptestyle${id}data">${response}</textarea>`)
            },
            error: function(data) {
                console.log("Error");
            }

        })
    }

    $(".wpte-product-layout-template-create").on("click", function (e) {
        e.preventDefault();
        $('#style-name').val('');
        $('#wptestyledata').val($(this).attr('layouts-data'));
        $("#wpte-product-layout-create-modal").modal("show");
    });

    $(".wpte-shortcode-clone").on("click", function (e) {
        e.preventDefault();
        var id = $(this).attr('datavalue');
        get_product_layout_by_id( id );
        $('#style-name').val('');
        $('#wptestyledata').val($(this).attr('layouts-data'));
        $("#wpte-product-layout-create-modal").modal("show");
    });

    $("#wpte-wpl-create-modal-form").submit(function (e) {
        e.preventDefault();
        $a = $('#wptestyledata').val();
        var s_name = $('#style-name').val(),
            data = JSON.parse($('#' + $a).val()),
            name = s_name,
            style_name = data.style.style_name,
            rawdata = data.style.rawdata,
            stylesheet = data.style.stylesheet;

        Product_Layout_Create_New( name, style_name, rawdata, stylesheet);
    });

})(jQuery)