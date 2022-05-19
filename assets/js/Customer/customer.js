function validateRegistration() {
    if( $( "#CustFirstName" ).val().trim() == "" ) {
        alert("First Name Must Be Provided");

        $( "#CustFirstName" ).val( $( "#CustFirstName" ).val().trim() );
        jQuery("#CustFirstName").attr('style', 'border-color: red !important');
        $( "#CustFirstName").focus();
        return false;
    }
    if( $( "#CustLastName" ).val().trim() == "" ) {
        alert("Last Name Must Be Provided");

        $( "#CustLastName" ).val( $( "#CustLastName" ).val().trim() );
        jQuery("#CustLastName").attr('style', 'border-color: red !important');
        $( "#CustLastName").focus();
        return false;
    }
    if( $( "#CustEmail" ).val().trim() == "" ) {
        alert("E-Mail Must Be Provided");

        $( "#CustEmail" ).val( $( "#CustEmail" ).val().trim() );
        jQuery("#CustEmail").attr('style', 'border-color: red !important');
        $( "#CustEmail").focus();
        return false;
    }
    else {
        var email = $( "#CustEmail" ).val().trim();
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (email != '') {
            if (email.match(emailReg)) {
            } else {
                alert("Sorry Only letters(a-z), numbers(0-9), underscore(_), dash(-) and periods(.) are allowed in E-Mail.");
                jQuery("#CustEmail").attr('style', 'border-color: red !important');

                $( "#CustEmail").focus();
                return false;
            }
        }
    }
    if( $( "#CustPass" ).val().trim() == "" ) {
        alert("Password Must Be Provided");

        $( "#CustPass" ).val( $( "#CustPass" ).val().trim() );
        jQuery("#CustPass").attr('style', 'border-color: red !important');
        $( "#CustPass").focus();
        return false;
    }
    if( $( "#CustPassConfirm" ).val().trim() == "" ) {
        alert("Confirm Password Must Be Provided");

        $( "#CustPassConfirm" ).val( $( "#CustPassConfirm" ).val().trim() );
        jQuery("#CustPassConfirm").attr('style', 'border-color: red !important');
        $( "#CustPassConfirm").focus();
        return false;
    }
    if( $( "#CustPass" ).val().trim() != "" && $( "#CustPassConfirm" ).val().trim() != "" && $( "#CustPass" ).val().trim() != $( "#CustPassConfirm" ).val().trim() ) {
        alert("'Password' and 'Confirm Password' Must Be Same.");

        $( "#CustPass" ).val( $( "#CustPass" ).val().trim() );
        jQuery("#CustPass").attr('style', 'border-color: red !important');
        $( "#CustPass").focus();

        $( "#CustPassConfirm" ).val( $( "#CustPassConfirm" ).val().trim() );
        jQuery("#CustPassConfirm").attr('style', 'border-color: red !important');
        $( "#CustPassConfirm").focus();

        return false;
    }
    if( $( "#CustContact" ).val().trim() == "" ) {
        alert("Contact Must Be Provided");

        $( "#CustContact" ).val( $( "#CustContact" ).val().trim() );
        jQuery("#CustContact").attr('style', 'border-color: red !important');
        $( "#CustContact").focus();
        return false;
    }
    if( $( "#CustAddress1" ).val().trim() == "" ) {
        alert("Address Must Be Provided");

        $( "#CustAddress1" ).val( $( "#CustAddress1" ).val().trim() );
        jQuery("#CustAddress1").attr('style', 'border-color: red !important');
        $( "#CustAddress1").focus();
        return false;
    }
    if( $( "#CustCity" ).val().trim() == "" ) {
        alert("City Must Be Provided");

        $( "#CustCity" ).val( $( "#CustCity" ).val().trim() );
        jQuery("#CustCity").attr('style', 'border-color: red !important');
        $( "#CustCity").focus();
        return false;
    }
    if( $( "#CityPostCode" ).val().trim() == "" ) {
        alert("Post Code Must Be Provided");

        $( "#CityPostCode" ).val( $( "#CityPostCode" ).val().trim() );
        jQuery("#CityPostCode").attr('style', 'border-color: red !important');
        $( "#CityPostCode").focus();
        return false;
    }


    return true;
    
}