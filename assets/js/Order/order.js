let validAddressFlag = true;
let validDeliveryOrderAmountFlag = true;
let validDeliveryOrderAmountMsg = "";

function loadOrderLoginPagecontent() {
    loadCart();
}

function loadOrderPlacingPageContentFrCollection() {
    loadOrderTimeSegment();
    loadCart();
}

function loadOrderPlacingPageContentFrDelivery() {
    loadOrderTimeSegment();
    getAddressDetails();
}


function orderSubmitValidation() {
    var orderSubmitFlag = true;

    if( validAddressFlag != true ) {
        alert("Unfortunately this Address is not inside delivery area. Please change your address or add a new address.")
        orderSubmitFlag = false;
    }
    else if( validDeliveryOrderAmountFlag != true ) {
        alert(validDeliveryOrderAmountMsg)
        orderSubmitFlag = false;
    }

    return orderSubmitFlag;
}


//////////////////////////////////////////////////////////
//          Address Segment [ START ]              //
//////////////////////////////////////////////////////////
function newAddressForm() {
    $("#tdAddressStatusLable").css("color", "#262626");
    $("#tdAddressStatusLable").html("LOADING....");

    load_ajax_loader("deliveryAddressDetails", "80px", "48.5%");

    setTimeout(function(){
        $.post( "../customer/ajaxNewAddressFrom",
            function( data ) {
                var response = JSON.parse(data);

                if( response.respond.error_flag ) {
                    if( response.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                }
                else if( response.respond.error_flag == false ) {

                    if(typeof response.respond.content != 'undefined' && response.respond.content != "" ) {
                        $("#deliveryAddressDetails").html(response.respond.content).promise().done(function() {
                        });
                    }
                }
            }
        );
    }, 100);
}

function getAddressDetails() {
    $("#tdAddressStatusLable").css("color", "#262626");
    $("#tdAddressStatusLable").html("LOADING....");

    load_ajax_loader("deliveryAddressDetails", "80px", "48.5%");

    var DeliveryAreaTitle = $("#DeliveryAreaTitle").val();

    setTimeout(function(){
        $.post( "../order/ajaxOrderAddress", { "DeliveryAreaTitle": DeliveryAreaTitle },
            function( data ) {
                var response = JSON.parse(data);

                if( response.respond.error_flag ) {
                    if( response.respond.error_msg == "not_logged_in" || response.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( response.respond.error_msg == "no_delivery_label" ) {
                        alert("No Delivery Label.");
                    }
                    else if( response.respond.error_msg == "invalid_delivery_label" ) {
                        alert("Invalid Delivery Label.");
                    }
                }
                else if( response.respond.error_flag == false ) {
                    if( typeof response.respond.content != 'undefined' && response.respond.content != "" ) {
                        $("#deliveryAddressDetails").html(response.respond.content).promise().done(function() {
                            loadCart();
                        });
                    }

                    //  For if Address inside Delivery Address
                    if( typeof response.respond.delivery_details.error_flag != 'undefined' && response.respond.delivery_details.error_flag ) {
                        validAddressFlag = false;
                        //  Error
                        if( response.respond.delivery_details.error_msg == "not_inside_delivery_area" ) {
                            $("#tdAddressStatusLable").css("color", "red");
                            $("#tdAddressStatusLable").html("Unfortunately this Address is not inside delivery area.");
                        }
                    }
                    else if( response.respond.delivery_details.error_flag == false ) {
                        validAddressFlag = true;
                        //  Success
                        $("#tdAddressStatusLable").css("color", "#358f4b");
                        $("#tdAddressStatusLable").html("Congratulations, we deliver to this address.");
                    }

                }
            }
        );
    }, 100);
}

function newAddressFormSubmit() {
    jQuery(".clsAddAddressError").hide();

    var addAddressFlag = true;


    if( $( "#CustAddLabel" ).val().trim() == "" ) {
        jQuery("#Error_CustAddLabel").show();
        jQuery("#Error_CustAddLabel").html("Address Label Must Be Provided");

        $( "#CustAddLabel").focus();
        addAddressFlag = false;
    }
    if( $( "#CustContact" ).val().trim() == "" ) {
        jQuery("#Error_CustContact").show();
        jQuery("#Error_CustContact").html("Contact Number Must Be Provided");

        $( "#CustContact").focus();
        addAddressFlag = false;
    }
    if( $( "#CustAddress1" ).val().trim() == "" ) {
        jQuery("#Error_CustAddress1").show();
        jQuery("#Error_CustAddress1").html("Address Must Be Provided");

        $( "#CustAddress1").focus();
        addAddressFlag = false;
    }
    if( $( "#CustCity" ).val().trim() == "" ) {
        jQuery("#Error_CustCity").show();
        jQuery("#Error_CustCity").html("City Must Be Provided");

        $( "#CustCity").focus();
        addAddressFlag = false;
    }
    if( $( "#CityPostCode" ).val().trim() == "" ) {
        jQuery("#Error_CityPostCode").show();
        jQuery("#Error_CityPostCode").html("Post Code Must Be Provided");

        $( "#CityPostCode").focus();
        addAddressFlag = false;
    }


    if( addAddressFlag == true ) {
        setTimeout(function() {
            $("#AddressForm input").prop("readonly", true);
            $("#AddressForm :input[type='button']").prop("disabled", true);

            $.post( "../customer/ajaxAddAddress", {
                    "postData" : $("#AddressForm").serialize()
                },
                function( data ) {
                    var response = JSON.parse(data);

                    if( response.respond.error_flag ) {
                        if( response.respond.error_type == "not_logged_in" ) {
                            window.location.href = "/";
                        }
                        else if( response.respond.error_type == "FieldDataError" ) {
                            alert("Following fields has issues: "+response.respond.error_msg);
                        }
                        else if( response.respond.error_type == "alreadyExist" ) {
                            $( "#CustAddLabel").focus();
                            alert("Address label already exists.");
                        }
                        else if( response.respond.error_type == "insertError" ) {
                            alert("Something is wrong, please contact site owner.");
                        }
                    }
                    else if( response.respond.error_flag == false ) {
                        alert("Address successfully added.");


                        //  Add as an OPTION in "DeliveryAreaTitle" SELECTION
                        $("#DeliveryAreaTitle").append($('<option>', {
                                value: response.respond.error_msg,
                                text: response.respond.error_msg
                            })).ready(function () {
                                $("#DeliveryAreaTitle").val(response.respond.error_msg).change();
                            });
                    }

                    $("#AddressForm input").prop("readonly", false);
                    $("#AddressForm :input[type='button']").prop("disabled", true);
                }
            );
        }, 100);






    }
}

//////////////////////////////////////////////////////////
//          Address Segment [ END ]                //
//////////////////////////////////////////////////////////


////////////////////////////////////////////////////////
//          Order Time Segment [ START ]              //
////////////////////////////////////////////////////////
function loadOrderTimeSegment() {
    load_ajax_loader("orderTimeSegment", "60px", "48.5%");

    setTimeout(function(){
        $.post( "../order/ajaxOrderTiming",
            function( data ) {
                var response = JSON.parse(data);

                if( response.respond.error_flag ) {
                    if( response.respond.error_msg == "not_logged_in" || response.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( response.respond.error_msg == "no_valid_time" ) {
                        alert("No Valid Time Back Home.")
                        window.location.href = "/";
                    }
                }
                else if( response.respond.error_flag == false ) {
                    if(typeof response.respond.content != 'undefined' && response.respond.content != "" ) {
                        $("#orderTimeSegment").html(response.respond.content).promise().done(function() {
                        });
                    }
                }
            }
        );
    }, 100);
}
////////////////////////////////////////////////////////
//          Order Time Segment [ END ]                //
////////////////////////////////////////////////////////


//////////////////////////////////////////////////
//          Cart Segment [ START ]              //
//////////////////////////////////////////////////
function loadCart() {
    load_ajax_loader("cartLoad", "40px", "48.5%");

    setTimeout(function(){
        $.post( "../cart/ajaxLoadOrderCart",
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                        $("#cartLoad").html(categoryFormRespond.respond.content).promise().done(function() {
                        });

                        if( categoryFormRespond.respond.validDeliveryOrderAmountFlag == false ) {
                            validDeliveryOrderAmountFlag = false;
                            validDeliveryOrderAmountMsg = categoryFormRespond.respond.validDeliveryOrderAmountMsg;
                        }
                        else {
                            validDeliveryOrderAmountFlag = true;
                            validDeliveryOrderAmountMsg = "";
                        }
                    }
                }
            }
        );
    }, 100);
}
//////////////////////////////////////////////////
//          Cart Segment [ END ]                //
//////////////////////////////////////////////////