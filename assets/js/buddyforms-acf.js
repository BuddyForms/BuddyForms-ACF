jQuery(document).ready(function () {
    if (BuddyFormsHooks && buddyformsGlobal) {
        function getFieldFromSlug(fieldSlug, formSlug) {
            if (fieldSlug && formSlug && buddyformsGlobal && buddyformsGlobal[formSlug] && buddyformsGlobal[formSlug].form_fields) {
                var fieldIdResult = Object.keys(buddyformsGlobal[formSlug].form_fields).filter(function (fieldId) {
                    fieldSlug = fieldSlug.replace('[]', '');
                    fieldSlug = BuddyFormsHooks.applyFilters('buddyforms:field:slug', fieldSlug, [formSlug, fieldId, buddyformsGlobal[formSlug]]);
                    return buddyformsGlobal[formSlug].form_fields[fieldId].slug.toLowerCase() === fieldSlug.toLowerCase();
                });
                if (fieldIdResult) {
                    return buddyformsGlobal[formSlug].form_fields[fieldIdResult];
                }
            }
            return false;
        }

        function getAcfFieldData(fieldSlug, formSlug) {
            var fieldIdResult = Object.keys(buddyformsGlobal[formSlug].form_fields).filter(function (fieldId) {
                fieldSlug = fieldSlug.replace('[]', '');
                var currentFieldData = buddyformsGlobal[formSlug].form_fields[fieldId];
                if (currentFieldData && currentFieldData.type === 'acf-field') {
                    if (currentFieldData.acf_field) {
                        var acfId = 'acf[' + currentFieldData.acf_field + ']';
                    }
                }
                return acfId && fieldSlug.toLowerCase() === acfId.toLowerCase();
            });
            if (fieldIdResult) {
                return buddyformsGlobal[formSlug].form_fields[fieldIdResult];
            }
        }

        acf.add_filter('validation_complete', function (json, $form) {
            if (json.errors) {
                for (var i = 0; i < json.errors.length; i++) {
                    var input_name = json.errors[i].input;
                    var message = json.errors[i].message;
                    var targetError = jQuery('label#id_' + input_name);
                    var targetElement = jQuery('[name="' + input_name + '"]');
                    if (targetElement.length > 0) {
                        targetElement.first().parent().append("<label id='buddyforms_form_" + input_name + "-error' class='error'>" + message + "</label>");
                    }
                }
            }
            return json;
        });

        BuddyFormsHooks.addFilter('buddyforms:validation:field:data', function (fieldData, arguments) {
            if (arguments[0] && arguments[1] && arguments[2] && buddyformsGlobal[arguments[1]]) {
                if (arguments[2]) {
                    return arguments[2];
                } else {
                    fieldData = getAcfFieldData(arguments[0], arguments[1]);
                    return fieldData;
                }
            }
            return fieldData;
        }, 10);

        BuddyFormsHooks.addAction('buddyforms:submit', function (form) {
            acf.validation.fetch({
                form: form,
                complete: function () {
                    jQuery('.acf-notice').hide();
                }
            });
        }, 10);
    }
});