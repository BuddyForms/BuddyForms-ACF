jQuery(document).ready(function(jQuery) {
    jQuery('body').on('change','.bf_acf_field_group_select',function(){
        var field_id = jQuery(this).attr('data-field_id');
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "buddyforms_acf_get_fields", "fields_group_id": this.value },
            success: function(data){
                var data = jQuery.parseJSON(data);
                jQuery( '.bf_acf_' + field_id ).closest('select').empty()
                jQuery.each(data, function (i, item) {
                    jQuery( '.bf_acf_' + field_id ).closest('select').append(jQuery('<option>', {
                        value: i,
                        text : item
                    }));
                });
            }
        });
    });
});
