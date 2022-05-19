function clear_form_elements(class_name) {
    if( jQuery("."+class_name).length > 0 ) {
        jQuery("."+class_name).find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'text':
                case 'textarea':
                case 'file':
                case 'select-one':
                case 'select-multiple':
                case 'date':
                case 'number':
                case 'tel':
                case 'email':
                    jQuery(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
                    break;
            }
        });

    }
    else if( jQuery("#"+class_name).length > 0 ) {
        jQuery("#"+class_name).find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'text':
                case 'textarea':
                case 'file':
                case 'select-one':
                case 'select-multiple':
                case 'date':
                case 'number':
                case 'tel':
                case 'email':
                    jQuery(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
                    break;
            }
        });
    }
}

function load_ajax_loader_front( element_id, padding_X, padding_Y) {
    jQuery("#"+element_id).html('<img src="assets/dist/images/loaders/loader9.gif" alt="" style="padding: '+padding_X+' '+padding_Y+'"/>');
}

function load_ajax_loader( element_id, padding_X, padding_Y) {
    jQuery("#"+element_id).html('<img src="../assets/dist/images/loaders/loader9.gif" alt="" style="padding: '+padding_X+' '+padding_Y+'"/>');
}

function hideDivById( divIdToHide ) {
    $("#"+divIdToHide).slideUp("slow").html("");
}

//  This Function is used for validation of fields based on HTML classes
function addCustomeClassValidator() {
    $('.onlyNumberClass').keypress(function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $('.onlyIntegerClass').keypress(function (event) {
        if(event.which < 48 || event.which > 57) {
            event.preventDefault();
        }
    });
    $('.onlyAlphabateWithSpace').keypress(function (event) {
        if( (event.which != 32 || $(this).val().length == 0) && (event.which < 65 || event.which > 90) && (event.which < 97 || event.which > 122) ) {
            event.preventDefault();
        }
    });
    $('.onlyCharWithSpace').keypress(function (event) {
        if( (event.which != 32 || $(this).val().length == 0) && (event.which < 65 || event.which > 90) && (event.which < 97 || event.which > 122) && (event.which < 48 || event.which > 57) ) {
            event.preventDefault();
        }
    });
    $('.noSpace').keypress(function (event) {
        if( event.which == 32 ) {
            event.preventDefault();
        }
    });
}