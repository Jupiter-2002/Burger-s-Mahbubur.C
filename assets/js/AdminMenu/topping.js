function resetAllActions() {
    hideDivById('divAjaxLoad');
}

////////////////////////////////////////////////////////////
//          Topping Category Segment [ START ]          //
function loadToppingCategoryList() {
    load_ajax_loader("divSelectionCategoryList", "40px", "48.5%");
    setTimeout(function(){
        $.post( "AdminTopping/ajaxToppingCategoryList",
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                        $("#divObjCategoryList").html(responseObj.respond.content).promise().done(function() {
                            //$("#divSelectionCategoryList").show(500)
                        });
                    }
                }
            }
        );
    }, 500);
}


//  For Add Segment [ Start ]
function openToppingCategoryDiv() {
    $("#divAjaxLoad").show("slow");
    load_ajax_loader("divAjaxLoad", "40px", "48.5%");

    $.post( "AdminTopping/ajaxToppingCategoryForm",
        { Action : "addSegment" },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
            }
            else if( responseObj.respond.error_flag == false ) {
                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#divAjaxLoad").fadeOut(250, function () {
                        $("#divAjaxLoad").html(responseObj.respond.content).promise().done(function() {
                            $("#divAjaxLoad").show(250)
                        });
                    });
                }
            }
        }
    );
}

function ajaxAddToppingCategory() {
    var isValid = true;

    if( $( "#ToppCatName" ).val().trim() == "" ) {
        alert("Topping Category Name Must Be Provided");
        $( "#ToppCatName").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminTopping/ajaxAddToppingCategory",
            { PostDataArr : $('#divAjaxLoad :input').serialize() },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "ErrorNameFieldMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Name Missing.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorAlreadyExist" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Name Already exists.");
                    }
                    else if( responseObj.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    //  Successfully inserted
                    if(typeof responseObj.respond.newId != 'undefined' && responseObj.respond.newId != "" ) {
                        $( "#error_msg_div").hide("");
                        $( "#error_msg").html("");

                        $( "#success_msg_div").show("slow");
                        $( "#success_msg").html("Inserted Successfully.");

                        loadToppingCategoryList();
                        clear_form_elements("divAjaxLoad");     //  Clear All The Input Fields [ File Location: js/utility.js ]
                    }
                }
            }
        );
    }
}
//  For Add Segment [ End ]

//  For Edit Segment [ Start ]
function openEditToppingCategoryDiv( ToppCatId ) {
    var isValid = true;

    if(isValid) {
        $("#divAjaxLoad").show("slow");
        load_ajax_loader("divAjaxLoad", "40px", "48.5%");

        $.post( "AdminTopping/ajaxToppingCategoryForm",
            {
                Action : "editSegment",
                ToppCatId : ToppCatId
            },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "invalid_id" || responseObj.respond.error_msg == "no_id" ) {
                        alert("Issue with category id.");

                        $("#divAjaxLoad").fadeOut(250, function () {
                            $("#divAjaxLoad").html("").promise().done(function() {
                                $("#divAjaxLoad").hide(250)
                            });
                        });
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                        $("#divAjaxLoad").fadeOut(250, function () {
                            $("#divAjaxLoad").html(responseObj.respond.content).promise().done(function() {
                                $("#divAjaxLoad").show(250)
                            });
                        });
                    }
                }
            }
        );
    }
}

function ajaxUpdateToppingCategory( ToppCatId ) {
    var isValid = true;

    if( $( "#ToppCatName" ).val().trim() == "" ) {
        alert("Topping Category Name Must Be Provided");
        $( "#ToppCatName").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminTopping/ajaxUpdateToppingCategory/"+ToppCatId,
            { PostDataArr : $('#divAjaxLoad :input').serialize() },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "data_missing_error" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Name Missing.");
                    }
                    else if( responseObj.respond.error_msg == "id_error" ) {
                        alert("ID ERROR");
                    }
                    else if( responseObj.respond.error_msg == "ErrorAlreadyExist" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Toppings Category already exists.");
                    }
                    else if( responseObj.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    //  Successfully inserted

                    $( "#error_msg_div").hide("");
                    $( "#error_msg").html("");

                    $( "#success_msg_div").show("slow");
                    $( "#success_msg").html("Topping Category Updated Successfully.");

                    loadToppingCategoryList();
                }
            }
        );
    }
}
//  For Edit Segment [ End ]

//          Topping Category Segment [ END ]            //
////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////
//              Topping Segment [ START ]              //
function loadToppingList( ToppCatId, resetFlag ) {
    if( resetFlag == true ) {   resetAllActions();  }

    load_ajax_loader("divObjList", "40px", "48.5%");
    setTimeout(function(){
        $.post( "AdminTopping/ajaxToppingList/"+ToppCatId,
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    if( responseObj.respond.error_msg == "not_logged_in") {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "topp_cat_id_missing") {
                        alert("Category Missing");
                    }
                    else if( responseObj.respond.error_msg == "invalid_topp_cat_id") {
                        alert("Invalid Category");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                        $("#divObjList").html(responseObj.respond.content).promise().done(function() {});
                    }
                }
            }
        );
    }, 500);


}

//  For Add Segment [ Start ]
function openAddToppingDiv( ToppCatId ) {
    $("#divAjaxLoad").show("slow");
    load_ajax_loader("divAjaxLoad", "40px", "48.5%");

    loadToppingList(ToppCatId, false);

    $.post( "AdminTopping/ajaxToppingForm",
        {
            Action : "addTopping",
            ToppCatId : ToppCatId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_topp_cat_id" ) {
                    alert("No Category ID.");
                }
                else if( responseObj.respond.error_msg == "wrong_topp_cat_id" ) {
                    alert("Invalid Category ID.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {
                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#divAjaxLoad").fadeOut(250, function () {
                        $("#divAjaxLoad").html(responseObj.respond.content).promise().done(function() {
                            $("#divAjaxLoad").show(250);
                        });
                    });
                }
            }
        }
    );
}

function ajaxAddTopping( ToppCatId ) {
    var isValid = true;

    if( $( "#ToppName" ).val().trim() == "" ) {
        alert("Name Must Be Provided");
        $( "#ToppName").focus();
        isValid = false;
    }

    if( isValid ) {
        $.post( "AdminTopping/ajaxAddTopping/"+ToppCatId,
            { PostDataArr : $('#divAjaxLoad :input').serialize() },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "ErrorNameFieldMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Name Missing.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorAlreadyExist" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Already exists.");
                    }
                    else if( responseObj.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    //  Successfully inserted
                    if(typeof responseObj.respond.newId != 'undefined' && responseObj.respond.newId != "" ) {
                        $( "#error_msg_div").hide("");
                        $( "#error_msg").html("");

                        $( "#success_msg_div").show("slow");
                        $( "#success_msg").html("Topping Inserted Successfully.");

                        if( responseObj.respond.firstEntry ) {   loadToppingCategoryList();    }

                        loadToppingList(ToppCatId, false);
                        clear_form_elements("divAjaxLoad");     //  Clear All The Input Fields [ File Location: js/utility.js ]
                    }
                }

















            }
        );
    }
}
//  For Add Segment [ End ]

//  For Edit Segment [ Start ]
function openEditToppingDiv( toppCatId, toppId ) {
    $("#divAjaxLoad").show("slow");
    load_ajax_loader("divAjaxLoad", "40px", "48.5%");

    $.post( "AdminTopping/ajaxToppingForm",
        {
            Action : "editTopping",
            toppCatId : toppCatId,
            toppId : toppId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_topp_cat_id" ) {
                    alert("No Category ID.");
                }
                else if( responseObj.respond.error_msg == "invalid_topp_cat_id" ) {
                    alert("Invalid Category ID.");
                }
                else if( responseObj.respond.error_msg == "no_topp_id" ) {
                    alert("No Topping ID.");
                }
                else if( responseObj.respond.error_msg == "invalid_topp_id" ) {
                    alert("Invalid Topping ID.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {
                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#divAjaxLoad").fadeOut(250, function () {
                        $("#divAjaxLoad").html(responseObj.respond.content).promise().done(function() {
                            $("#divAjaxLoad").show(250)
                        });
                    });
                }
            }
        }
    );
}



function updateTopping( toppId ) {
    var isValid = true;

    if( $( "#ToppName" ).val().trim() == "" ) {
        alert("Name Must Be Provided");
        $( "#ToppName").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminTopping/ajaxUpdateTopping/"+toppId,
            { PostDataArr : $('#divAjaxLoad :input').serialize() },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "ToppName_missing_error" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Name Must Be Provided.");
                    }
                    else if( responseObj.respond.error_msg == "id_error" ) {
                        alert("ID ERROR PLEASE CONTACT WITH DEVELOPER.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorAlreadyExist" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Already exists.");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    //  Successfully updated
                    $( "#error_msg_div").hide("");
                    $( "#error_msg").html("");

                    $( "#success_msg_div").show("slow");
                    $( "#success_msg").html("Updated Successfully.");

                    loadToppingList( $("#FK_ToppCatId").val(), false );
                }
            }
        );
    }
}


//  For Edit Segment [ End ]

//              Topping Segment [ END ]              //
///////////////////////////////////////////////////////////