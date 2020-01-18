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

        acf.addAction('valid_field', function(instance){
            instance.$el.find('label.error').remove();
        });

        acf.add_filter('validation_complete', function (json, $form) {
            if (json.errors) {
                for (var i = 0; i < json.errors.length; i++) {
                    var input_name = json.errors[i].input;
                    var message = json.errors[i].message;
                    var targetElement = jQuery('[name="' + input_name + '"]');
                    if (targetElement.length > 0) {
                        targetElement.first().parent().find('label.error').remove();
                        targetElement.first().parent().append("<label id='buddyforms_form_" + input_name + "-error' class='error' style='color:red; font-weight: bold; font-style: normal;'>" + message + "</label>");
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

        BuddyFormsHooks.addFilter('buddyforms:submit:prevent', function (prevent, args) {
            var stop = jQuery(args[0]).find('label.error:visible').length;
            return (stop && stop > 0);
        });

        BuddyFormsHooks.addAction('buddyforms:submit', function (args) {
            BuddyFormsHooks.doAction('buddyforms:submit:disable');
            acf.validation.fetch({
                form: args,
                complete: function (response) {
                    jQuery('.acf-notice').hide();
                    BuddyFormsHooks.doAction('buddyforms:submit:enable');
                }
            });
        }, 10);

        BuddyFormsHooks.addFilter('buddyforms:validation:ignore', function (ignore, arguments) {
            if (arguments[0] && arguments[1] && arguments[2] && buddyformsGlobal[arguments[2]]) {
                var targetElement = arguments[0][0];
                var targetElementName = jQuery(targetElement).attr('name');
                var isAcfElment = jQuery(targetElement).closest('.bf_field.bf_field_group.acf-field');
                if (isAcfElment.length > 0 || (targetElementName && targetElementName.indexOf('acf[') >= 0)) {
                    return true;
                }
            }
            return ignore;
        }, 10);
    }
});