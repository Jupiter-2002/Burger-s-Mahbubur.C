function clear_discount_elements(class_name) {
    $("#submitBtn").attr("onclick","addDiscount()");

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

function addDiscount() {
    var isValid = true;

    if( $( "#OrderTypeId" ).val().trim() == "" ) {
        alert("Order Type Must Be Selected");
        $( "#OrderTypeId").focus();
        isValid = false;
    }
    else if( $( "#DiscountType" ).val().trim() == "" ) {
        alert("Discount Type Must Be Selected");
        $( "#DiscountType").focus();
        isValid = false;
    }
    else if( $( "#DiscountAmount" ).val().trim() == "" ) {
        alert("Discount Amount Must Be Provided");
        $( "#DiscountAmount").focus();
        isValid = false;
    }
    else if( $( "#StartAmount" ).val().trim() == "" ) {
        alert("Minimum Amount Must Be Provided");
        $( "#StartAmount").focus();
        isValid = false;
    }
    else if( $( "#EndAmount" ).val().trim() == "" ) {
        alert("Maximum Amount Must Be Provided");
        $( "#EndAmount").focus();
        isValid = false;
    }
    else if( $( "#StartDate" ).val().trim() == "" ) {
        alert("Start Date Must Be Provided");
        $( "#StartDate").focus();
        isValid = false;
    }
    else if( $( "#EndDate" ).val().trim() == "" ) {
        alert("End Date Must Be Provided");
        $( "#EndDate").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminDiscount/ajaxAddDiscount",
            {
                OrderTypeId : $( "#OrderTypeId" ).val().trim(),
                DiscountType : $( "#DiscountType" ).val().trim(),
                DiscountAmount : $( "#DiscountAmount" ).val().trim(),
                StartAmount : $( "#StartAmount" ).val().trim(),
                EndAmount : $( "#EndAmount" ).val().trim(),
                StartDate : $( "#StartDate" ).val().trim(),
                EndDate : $( "#EndDate" ).val().trim(),
                Description : $( "#Description" ).val().trim()
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

                        loadDiscountList();
                        clear_form_elements("divAjaxLoad");     //  Clear All The Input Fields [ File Location: js/utility.js ]
                    }
                }
            }
        );
    }
}

function loadDiscountList() {
    load_ajax_loader("divDiscountList", "40px", "48.5%");

    setTimeout(function(){
        $.post( "AdminDiscount/ajaxDiscountList",
            function( data ) {
                var ajaxRespond = JSON.parse(data);

                if( ajaxRespond.respond.error_flag ) {
                    if( ajaxRespond.respond.error_msg == "not_logged_in" || ajaxRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( ajaxRespond.respond.error_flag == false ) {
                    if(typeof ajaxRespond.respond.content != 'undefined' && ajaxRespond.respond.content != "" ) {
                        $("#divDiscountList").html(ajaxRespond.respond.content).promise().done(function() {
                            //$("#divCategoryList").show(500)
                        });
                    }
                }
            }
        );
    }, 500);
}

function openEditDiscountDiv( discountId ) {
    var isValid = true;

    if(isValid) {
        $("#divAjaxLoad").hide("slow");
        $("#divAjaxLoaderIcon").show("slow");
        load_ajax_loader("divAjaxLoaderIcon", "20px", "48.5%");

        $.post( "AdminDiscount/ajaxDiscountForm",
            {
                Action : "editDiscount",
                discountId : discountId
            },
            function( data ) {
                var ajaxRespond = JSON.parse(data);

                if( ajaxRespond.respond.error_flag ) {
                    if( ajaxRespond.respond.error_msg == "not_logged_in" || ajaxRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( addCategoryRespond.respond.error_msg == "missing_discount_id" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Missing Discount Id.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "invalid_discount_id" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Invalid Discount Id.");
                    }


                }
                else if( ajaxRespond.respond.error_flag == false ) {
                    if(typeof ajaxRespond.respond.content != 'undefined' && ajaxRespond.respond.content != "" ) {
                        $("#submitBtn").attr("onclick","editDiscount("+discountId+")");

                        $("#SegmentTitle").html(ajaxRespond.respond.content.SegmentTitle);

                        $("#OrderTypeId").val(ajaxRespond.respond.content.discountDetails[0].OrderTypeId);
                        $("#DiscountType").val(ajaxRespond.respond.content.discountDetails[0].DiscountType);
                        $("#DiscountAmount").val(ajaxRespond.respond.content.discountDetails[0].DiscountAmount);
                        $("#StartAmount").val(ajaxRespond.respond.content.discountDetails[0].StartAmount);
                        $("#EndAmount").val(ajaxRespond.respond.content.discountDetails[0].EndAmount);
                        $("#StartDate").val(ajaxRespond.respond.content.discountDetails[0].StartDate);
                        $("#EndDate").val(ajaxRespond.respond.content.discountDetails[0].EndDate);
                        $("#Description").val(ajaxRespond.respond.content.discountDetails[0].Description);


                        $("#divAjaxLoad").show("slow");
                        $("#divAjaxLoaderIcon").hide("slow");
                    }
                }
            }
        );
    }
}

function editDiscount( discountId ) {
    var isValid = true;

    if( $( "#OrderTypeId" ).val().trim() == "" ) {
        alert("Order Type Must Be Selected");
        $( "#OrderTypeId").focus();
        isValid = false;
    }
    else if( $( "#DiscountType" ).val().trim() == "" ) {
        alert("Discount Type Must Be Selected");
        $( "#DiscountType").focus();
        isValid = false;
    }
    else if( $( "#DiscountAmount" ).val().trim() == "" ) {
        alert("Discount Amount Must Be Provided");
        $( "#DiscountAmount").focus();
        isValid = false;
    }
    else if( $( "#StartAmount" ).val().trim() == "" ) {
        alert("Minimum Amount Must Be Provided");
        $( "#StartAmount").focus();
        isValid = false;
    }
    else if( $( "#EndAmount" ).val().trim() == "" ) {
        alert("Maximum Amount Must Be Provided");
        $( "#EndAmount").focus();
        isValid = false;
    }
    else if( $( "#StartDate" ).val().trim() == "" ) {
        alert("Start Date Must Be Provided");
        $( "#StartDate").focus();
        isValid = false;
    }
    else if( $( "#EndDate" ).val().trim() == "" ) {
        alert("End Date Must Be Provided");
        $( "#EndDate").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminDiscount/ajaxUpdateDiscount/"+discountId,
            {
                OrderTypeId : $( "#OrderTypeId" ).val().trim(),
                DiscountType : $( "#DiscountType" ).val().trim(),
                DiscountAmount : $( "#DiscountAmount" ).val().trim(),
                StartAmount : $( "#StartAmount" ).val().trim(),
                EndAmount : $( "#EndAmount" ).val().trim(),
                StartDate : $( "#StartDate" ).val().trim(),
                EndDate : $( "#EndDate" ).val().trim(),
                Description : $( "#Description" ).val().trim()
            },
            function( data ) {
                var ajaxRespond = JSON.parse(data);

                if( ajaxRespond.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( ajaxRespond.respond.error_msg == "not_logged_in" || ajaxRespond.respond.error_msg == "invalidDiscountId" ) {
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
                    $( "#success_msg").html("Discount Updated Successfully.");

                    loadDiscountList();
                }
            }
        );
    }
}

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