function clear_delievery_elements(class_name) {
    $("#submitBtn").attr("onclick","addDelivery()");

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

function addDelivery() {
    var isValid = true;

    if( $( "#DeliveryAreaTitle" ).val().trim() == "" ) {
        alert("Address/Title Must Be Selected");
        $( "#DeliveryAreaTitle").focus();
        isValid = false;
    }
    else if( $( "#MinDeliveryAmount" ).val().trim() == "" ) {
        alert("Minimum Amount Must Be Selected");
        $( "#MinDeliveryAmount").focus();
        isValid = false;
    }
    else if( $( "#DeliveryTime" ).val().trim() == "" ) {
        alert("Delivery Time Must Be Provided");
        $( "#DeliveryTime").focus();
        isValid = false;
    }
    else if( $( "#HalfPostCode" ).val().trim() == "" && $( "#PostCodeList" ).val().trim() == "" ) {
        alert("Must Provide a Half Post Code OR the Post Code List");
        $( "#StartAmount").focus();
        isValid = false;
    }

    if(isValid) {
        var tmpFreeDeliveryFlag = 0;
        if( $('#FreeDeliveryFlag').is(':checked') ) {
            tmpFreeDeliveryFlag = 1;
        }

        $.post( "AdminDelivery/ajaxAddDelivery",
            {
                DeliveryAreaTitle : $( "#DeliveryAreaTitle" ).val().trim(),
                DeliveryCharge : $( "#DeliveryCharge" ).val().trim(),
                MinDeliveryAmount : $( "#MinDeliveryAmount" ).val().trim(),
                HalfPostCode : $( "#HalfPostCode" ).val().trim(),
                PostCodeList : $( "#PostCodeList" ).val().trim(),
                DeliveryTime : $( "#DeliveryTime" ).val().trim(),
                FreeDeliveryFlag : tmpFreeDeliveryFlag
            }, function( data ) {
                var ajaxRespond = JSON.parse(data);

                if( ajaxRespond.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( ajaxRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( ajaxRespond.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( ajaxRespond.respond.error_flag == false ) {
                    //  Successfully inserted
                    if(typeof ajaxRespond.respond.newInsertedId != 'undefined' && ajaxRespond.respond.newInsertedId != "" ) {
                        $( "#error_msg_div").hide("");
                        $( "#error_msg").html("");

                        $( "#success_msg_div").show("slow");
                        $( "#success_msg").html("Discount Inserted Successfully.");

                        loadDeliveryList();
                        clear_form_elements("divAjaxLoad");     //  Clear All The Input Fields [ File Location: js/utility.js ]
                    }
                }
            }
        );
    }
}

function loadDeliveryList() {
    load_ajax_loader("divDeliveryList", "40px", "48.5%");

    setTimeout(function(){
        $.post( "AdminDelivery/ajaxDeliveryList",
            function( data ) {
                var ajaxRespond = JSON.parse(data);

                if( ajaxRespond.respond.error_flag ) {
                    if( ajaxRespond.respond.error_msg == "not_logged_in" || ajaxRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( ajaxRespond.respond.error_flag == false ) {
                    if(typeof ajaxRespond.respond.content != 'undefined' && ajaxRespond.respond.content != "" ) {
                        $("#divDeliveryList").html(ajaxRespond.respond.content).promise().done(function() {
                            //$("#divCategoryList").show(500)
                        });
                    }
                }
            }
        );
    }, 500);
}

function openEditDeliveryDiv( DeliveryAreaID ) {
    var isValid = true;

    if(isValid) {
        $("#divAjaxLoad").hide("slow");
        $("#divAjaxLoaderIcon").show("slow");
        load_ajax_loader("divAjaxLoaderIcon", "20px", "48.5%");

        $.post( "AdminDelivery/ajaxDeliveryForm",
            {
                Action : "editDelivery",
                DeliveryAreaID : DeliveryAreaID
            },
            function( data ) {
                var ajaxRespond = JSON.parse(data);

                if( ajaxRespond.respond.error_flag ) {
                    if( ajaxRespond.respond.error_msg == "not_logged_in" || ajaxRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( addCategoryRespond.respond.error_msg == "missing_delivery_id" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Missing Delivery Id.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "invalid_delivery_id" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Invalid Delivery Id.");
                    }
                }
                else if( ajaxRespond.respond.error_flag == false ) {


                    console.log( ajaxRespond.respond.content );

                    if(typeof ajaxRespond.respond.content != 'undefined' && ajaxRespond.respond.content != "" ) {
                        $("#submitBtn").attr("onclick","updateDelivery("+DeliveryAreaID+")");

                        $("#SegmentTitle").html(ajaxRespond.respond.content.SegmentTitle);

                        $("#DeliveryAreaTitle").val(ajaxRespond.respond.content.deliveryDetails[0].DeliveryAreaTitle);
                        $("#DeliveryCharge").val(ajaxRespond.respond.content.deliveryDetails[0].DeliveryCharge);
                        $("#MinDeliveryAmount").val(ajaxRespond.respond.content.deliveryDetails[0].MinDeliveryAmount);
                        $("#HalfPostCode").val(ajaxRespond.respond.content.deliveryDetails[0].HalfPostCode);
                        $("#PostCodeList").val(ajaxRespond.respond.content.deliveryDetails[0].PostCodeList);
                        $("#DeliveryTime").val(ajaxRespond.respond.content.deliveryDetails[0].DeliveryTime);

                        if( ajaxRespond.respond.content.deliveryDetails[0].FreeDeliveryFlag == 1 ) {
                            $('#FreeDeliveryFlag').parent().prop('class', 'checked');
                            $('#FreeDeliveryFlag').prop('checked', true);
                        } else {
                            $('#FreeDeliveryFlag').parent().prop('class', false);
                            $('#FreeDeliveryFlag').prop('checked', false);
                        }


                        $("#divAjaxLoad").show("slow");
                        $("#divAjaxLoaderIcon").hide("slow");
                    }
                }
            }
        );
    }
}


function updateDelivery( DeliveryAreaID ) {
    var isValid = true;

    if( $( "#DeliveryAreaTitle" ).val().trim() == "" ) {
        alert("Address/Title Must Be Selected");
        $( "#DeliveryAreaTitle").focus();
        isValid = false;
    }
    else if( $( "#MinDeliveryAmount" ).val().trim() == "" ) {
        alert("Minimum Amount Must Be Selected");
        $( "#MinDeliveryAmount").focus();
        isValid = false;
    }
    else if( $( "#DeliveryTime" ).val().trim() == "" ) {
        alert("Delivery Time Must Be Provided");
        $( "#DeliveryTime").focus();
        isValid = false;
    }
    else if( $( "#HalfPostCode" ).val().trim() == "" && $( "#PostCodeList" ).val().trim() == "" ) {
        alert("Must Provide a Half Post Code OR the Post Code List");
        $( "#StartAmount").focus();
        isValid = false;
    }

    if(isValid) {
        var tmpFreeDeliveryFlag = 0;
        if( $('#FreeDeliveryFlag').is(':checked') ) {
            tmpFreeDeliveryFlag = 1;
        }

        $.post( "AdminDelivery/ajaxUpdateDelivery/"+DeliveryAreaID,
            {
                DeliveryAreaTitle : $( "#DeliveryAreaTitle" ).val().trim(),
                DeliveryCharge : $( "#DeliveryCharge" ).val().trim(),
                MinDeliveryAmount : $( "#MinDeliveryAmount" ).val().trim(),
                HalfPostCode : $( "#HalfPostCode" ).val().trim(),
                PostCodeList : $( "#PostCodeList" ).val().trim(),
                DeliveryTime : $( "#DeliveryTime" ).val().trim(),
                FreeDeliveryFlag : tmpFreeDeliveryFlag
            },
            function( data ) {
                var ajaxRespond = JSON.parse(data);

                if( ajaxRespond.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( ajaxRespond.respond.error_msg == "not_logged_in" || ajaxRespond.respond.error_msg == "invalidDeliveryAreaId" ) {
                        window.location.href = "/";
                    }
                    else if( ajaxRespond.respond.error_msg == "no_Changes" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("No Changes.");
                    }
                    else if( ajaxRespond.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( ajaxRespond.respond.error_flag == false ) {
                    //  Successfully inserted
                    $( "#error_msg_div").hide("");
                    $( "#error_msg").html("");

                    $( "#success_msg_div").show("slow");
                    $( "#success_msg").html("Delivery Area Updated Successfully.");

                    loadDeliveryList();
                }
            }
        );
    }

}








/*






function ajaxDeleteDiscount( discountId ) {
    var isValid = true;

    var r = confirm("Are you sure that you want to delete this Payment Type.");
    if (r == true) {
        //  Confirmed
    } else {
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminDiscount/ajaxDeleteDiscount",
            { discountId : discountId },
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
                        $( "#error_msg").html("Discount Does Not Exists.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorDiscountIdMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Discount Missing.");
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

                    loadDiscountList();
                }
            }
        );
    }
}
*/