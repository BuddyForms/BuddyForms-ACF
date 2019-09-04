if (BuddyFormsHooks && buddyformsGlobal) {
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

    BuddyFormsHooks.addFilter('buddyforms:validation:field:data', function (fieldData, arguments) {
        if (arguments[0] && arguments[1] && arguments[2] && buddyformsGlobal[arguments[1]]) {
            if(arguments[2]){
                return arguments[2];
            } else {
                fieldData = getAcfFieldData(arguments[0], arguments[1]);
                return fieldData;
            }
        }
        return fieldData;
    }, 10);
}