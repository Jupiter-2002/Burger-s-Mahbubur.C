function updateRestaurantDetails() {
    var isValid = true;

    if( $( "#RestName" ).val().trim() == "" ) {
        alert("Name Must Be Selected");
        $( "#RestName").focus();
        isValid = false;
    }
    else if( $( "#RestWebUrl" ).val().trim() == "" ) {
        alert("URL Must Be Selected");
        $( "#RestWebUrl").focus();
        isValid = false;
    }
    else if( $( "#RestUniqueKey" ).val().trim() == "" ) {
        alert("Key Must Be Selected");
        $( "#RestUniqueKey").focus();
        isValid = false;
    }
    else if( $( "#RestEMail" ).val().trim() == "" ) {
        alert("E-Mail Must Be Selected");
        $( "#RestEMail").focus();
        isValid = false;
    }
    else if( $( "#RestAddress" ).val().trim() == "" ) {
        alert("Address Must Be Selected");
        $( "#RestAddress").focus();
        isValid = false;
    }
    else if( $( "#RestStreet" ).val().trim() == "" ) {
        alert("Street Must Be Selected");
        $( "#RestStreet").focus();
        isValid = false;
    }
    else if( $( "#RestCity" ).val().trim() == "" ) {
        alert("City Must Be Selected");
        $( "#RestCity").focus();
        isValid = false;
    }
    else if( $( "#RestPostCode" ).val().trim() == "" ) {
        alert("Post Code Must Be Selected");
        $( "#RestPostCode").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "ajaxUpdateRestaurantDetails",
            {
                RestName : $( "#RestName" ).val().trim(),
                RestWebUrl : $( "#RestWebUrl" ).val().trim(),
                RestUniqueKey : $( "#RestUniqueKey" ).val().trim(),
                RestEMail : $( "#RestEMail" ).val().trim(),
                RestPhone : $( "#RestPhone" ).val().trim(),
                RestMobile : $( "#RestMobile" ).val().trim(),
                RestAddress : $( "#RestAddress" ).val().trim(),
                RestStreet : $( "#RestStreet" ).val().trim(),
                RestCity : $( "#RestCity" ).val().trim(),
                RestPostCode : $( "#RestPostCode" ).val().trim(),
                IsHalal : $( "#IsHalal" ).val().trim(),
                RestStarRating : $( "#RestStarRating" ).val().trim(),
                RestHygenicRating : $( "#RestHygenicRating" ).val().trim(),
                RestDescription : $( "#RestDescription" ).val().trim()
            },
            function( data ) {
                var ajaxRespond = JSON.parse(data);

                if( ajaxRespond.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( ajaxRespond.respond.error_msg == "no_Changes" ) {
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
                    $( "#success_msg").html("Restaurant Details Updated Successfully.");
                }
            }
        );
    }
}

function updateRestaurantOwnerDetails() {
    var isValid = true;

    if( $( "#OwnerFirstName" ).val().trim() == "" ) {
        alert("First Name Must Be Selected");
        $( "#OwnerFirstName").focus();
        isValid = false;
    }
    else if( $( "#OwnerLastName" ).val().trim() == "" ) {
        alert("Last Name Must Be Selected");
        $( "#OwnerLastName").focus();
        isValid = false;
    }
    else if( $( "#OwnerAddress" ).val().trim() == "" ) {
        alert("Address Must Be Selected");
        $( "#OwnerAddress").focus();
        isValid = false;
    }
    else if( $( "#OwnerStreet" ).val().trim() == "" ) {
        alert("Street Must Be Selected");
        $( "#OwnerStreet").focus();
        isValid = false;
    }
    else if( $( "#OwnerCity" ).val().trim() == "" ) {
        alert("City Must Be Selected");
        $( "#OwnerCity").focus();
        isValid = false;
    }
    else if( $( "#OwnerPostCode" ).val().trim() == "" ) {
        alert("Post Code Must Be Selected");
        $( "#OwnerPostCode").focus();
        isValid = false;
    }


    if(isValid) {
        $.post( "ajaxUpdateRestaurantOwnerDetails",
            {
                OwnerFirstName : $( "#OwnerFirstName" ).val().trim(),
                OwnerLastName : $( "#OwnerLastName" ).val().trim(),
                OwnerAddress : $( "#OwnerAddress" ).val().trim(),
                OwnerStreet : $( "#OwnerStreet" ).val().trim(),
                OwnerCity : $( "#OwnerCity" ).val().trim(),
                OwnerPostCode : $( "#OwnerPostCode" ).val().trim(),
                OwnerEMail : $( "#OwnerEMail" ).val().trim(),
                OwnerPhone : $( "#OwnerPhone" ).val().trim(),
                OwnerMobile : $( "#OwnerMobile" ).val().trim()
            },
            function( data ) {
                var ajaxRespond = JSON.parse(data);

                if( ajaxRespond.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( ajaxRespond.respond.error_msg == "no_Changes" ) {
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
                    $( "#success_msg").html("Restaurant Details Updated Successfully.");
                }
            }
        );
    }

}