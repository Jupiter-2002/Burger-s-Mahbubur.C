function resetAllActions() {
    hideDivById('divAjaxLoad');
}

function loadPaymentTypeList() {
    load_ajax_loader("paymentTypeList", "40px", "48.5%");

    setTimeout(function(){
        $.post( "AdminPaymentType/ajaxPaymentTypeList",
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                        $("#paymentTypeList").html(categoryFormRespond.respond.content).promise().done(function() {
                        });
                    }
                }
            }
        );
    }, 500);

}

function ajaxSavePaymentType() {
    var isValid = true;

    if( $( "#PaymentTypeId" ).val().trim() == "" ) {
        alert("Payment Type Must Be Selected.");
        $( "#OrderTypeId").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminPaymentType/ajaxSavePaymentType",
            { PostDataArr : $('#divAjaxLoad :input').serialize() },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "ErrorAlreadyExist" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Payment Type Already exists.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorPaymentTypeIdMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Payment Type Missing.");
                    }
                    else if( responseObj.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    $( "#error_msg_div").hide("");
                    $( "#error_msg").html("");

                    $( "#success_msg_div").show("slow");
                    $( "#success_msg").html("Inserted Successfully.");

                    loadPaymentTypeList();
                }
            }
        );
    }
}

function ajaxDeleteOrderType( PaymentTypeId ) {
    var isValid = true;

    var r = confirm("Are you sure that you want to delete this Payment Type.");
    if (r == true) {
        //  Confirmed
    } else {
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminPaymentType/ajaxDeletePaymentType",
            { PaymentTypeId : PaymentTypeId },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "ErrorDoesNotExist" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Payment Type Does Not Exists.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorPaymentTypeIdMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Payment Type Missing.");
                    }
                    else if( responseObj.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    $( "#error_msg_div").hide("");
                    $( "#error_msg").html("");

                    $( "#success_msg_div").show("slow");
                    $( "#success_msg").html("Deleted Successfully.");

                    loadPaymentTypeList();
                }
            }
        );
    }
}