function resetAllActions() {
    hideDivById('divAjaxLoad');
}

function loadOrderTypeList() {
    load_ajax_loader("orderTypeList", "40px", "48.5%");

    setTimeout(function(){
        $.post( "AdminOrderType/ajaxOrderTypeList",
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                        $("#orderTypeList").html(categoryFormRespond.respond.content).promise().done(function() {
                        });
                    }
                }
            }
        );
    }, 500);

}

function ajaxSaveOrderType() {
    var isValid = true;

    if( $( "#OrderTypeId" ).val().trim() == "" ) {
        alert("Order Type Must Be Selected.");
        $( "#OrderTypeId").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminOrderType/ajaxSaveOrderType",
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
                        $( "#error_msg").html("Order Type Already exists.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorOrderTypeIdMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Order Type Missing.");
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

                    loadOrderTypeList();
                }
            }
        );
    }
}

function ajaxDeleteOrderType( OrderTypeId ) {
    var isValid = true;

    var r = confirm("Are you sure that you want to delete this Order Type.");
    if (r == true) {
        //  Confirmed
    } else {
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminOrderType/ajaxDeleteOrderType",
            { OrderTypeId : OrderTypeId },
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
                        $( "#error_msg").html("Order Type Does Not Exists.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorOrderTypeIdMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Order Type Missing.");
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

                    loadOrderTypeList();
                }
            }
        );
    }
}