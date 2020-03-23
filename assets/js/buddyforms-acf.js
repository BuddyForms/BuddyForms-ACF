jQuery(document).ready(function () {
    if (BuddyFormsHooks && buddyformsGlobal) {
        var containsAcfFields = jQuery('.acf-field');
        if (containsAcfFields && containsAcfFields.length > 0) {

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

            BuddyFormsHooks.removeAction('buddyforms:submit:click', 'actionFromButton');

            BuddyFormsHooks.addAction('buddyforms:submit:click', function (args) {
                var targetForms = args[0];
                var target = args[1];
                var status = args[2];
                var event = args[3];
                event.preventDefault();
                var formOptions = 'publish';
                var draftAction = false;
                if (buddyformsGlobal && buddyformsGlobal[target] && buddyformsGlobal[target].status) {
                    formOptions = buddyformsGlobal[target].status;
                }
                if (buddyformsGlobal && buddyformsGlobal[target] && buddyformsGlobal[target].draft_action) {
                    draftAction = (buddyformsGlobal[target].draft_action[0] === 'Enable Draft');
                }
                if (targetForms && targetForms.length > 0) {
                    var fieldStatus = getFieldDataBy(target, 'status');
                    if (fieldStatus === false) { //Not exist the field,
                        var statusElement = targetForms.find('input[type="hidden"][name="status"]');
                        if (statusElement && statusElement.length > 0) {
                            var post_status = status || formOptions;
                            statusElement.val(post_status);
                        }
                    }
                    BuddyFormsHooks.doAction('buddyforms:submit:disable');
                    targetForms.valid();

                    acf.validateForm({
                        form: args[0],
                        reset: true,
                        complete: function (response) {
                            jQuery('.acf-notice').hide();
                            BuddyFormsHooks.doAction('buddyforms:submit:enable');
                        }
                    });
                }
                return false;
            });

            acf.addAction('valid_field', function (instance) {
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
                } else {
                    jQuery($form).trigger('submit');
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
    }
});