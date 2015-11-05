jQuery(document).ready(function(jQuery) {

    jQuery('.bf_acf_field_group_select').on('change', function() {

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "buddyforms_acf_get_fields", "fields_group_id": this.value },
            success: function(data){
                var data = jQuery.parseJSON(data);
                jQuery('.bf_acf_fields_select').closest('select').empty()
                jQuery.each(data, function (i, item) {
                    jQuery('.bf_acf_fields_select').closest('select').append(jQuery('<option>', {
                        value: i,
                        text : item
                    }));
                });
            }
        });
    });


});
