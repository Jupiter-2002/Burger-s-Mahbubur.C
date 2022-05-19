function resetAllActions() {
    hideDivById('divAjaxLoad');
}

////////////////////////////////////////////////////////////
//          Selection Category Segment [ START ]          //
function loadSelectionCategoryList() {
    load_ajax_loader("divSelectionCategoryList", "40px", "48.5%");
    setTimeout(function(){
        $.post( "AdminSelection/ajaxSelectionCategoryList",
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                        $("#divSelectionCategoryList").html(categoryFormRespond.respond.content).promise().done(function() {
                            //$("#divSelectionCategoryList").show(500)
                        });
                    }
                }
            }
        );
    }, 500);
}

//  For Add Segment [ Start ]
function openSelectionCategoryDiv() {
    $("#divAjaxLoad").show("slow");
    load_ajax_loader("divAjaxLoad", "40px", "48.5%");


    $.post( "AdminSelection/ajaxSelectionCategoryForm",
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

function ajaxAddSelectionCategory() {
    var isValid = true;

    if( $( "#SelecCatName" ).val().trim() == "" ) {
        alert("Selection Category Name Must Be Provided");
        $( "#SelecCatName").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminSelection/ajaxAddSelectionCategory",
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
                        $( "#error_msg").html("Name Already exists.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorNameFieldMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Name Missing.");
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

                        loadSelectionCategoryList();
                        clear_form_elements("divAjaxLoad");     //  Clear All The Input Fields [ File Location: js/utility.js ]
                    }
                }
            }
        );
    }
}
//  For Add Segment [ End ]

//  For Edit Segment [ Start ]
function openEditSelectionCategoryDiv( SelCatId ) {
    var isValid = true;

    if(isValid) {
        $("#divAjaxLoad").show("slow");
        load_ajax_loader("divAjaxLoad", "40px", "48.5%");

        $.post( "AdminSelection/ajaxSelectionCategoryForm",
            {
                Action : "editSegment",
                SelCatId : SelCatId
            },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "invalid_id" || responseObj.respond.error_msg == "no_id" ) {
                        alert("Issue with category drop down.");

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

function ajaxUpdateSelectionCategory( SelCatId ) {
    var isValid = true;

    if( $( "#SelecCatName" ).val().trim() == "" ) {
        alert("Selection Category Name Must Be Provided");
        $( "#SelecCatName").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminSelection/ajaxUpdateSelectionCategory/"+SelCatId,
            { PostDataArr : $('#divAjaxLoad :input').serialize() },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "id_error" ) {
                        alert("ID ERROR");
                    }
                    else if( responseObj.respond.error_msg == "data_missing_error" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Name Missing.");
                    }
                    else if( responseObj.respond.error_msg == "ErrorAlreadyExist" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Selection Category already exists.");
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
                    $( "#success_msg").html("Selection Category Updated Successfully.");

                    loadSelectionCategoryList();
                }
            }
        );
    }
}
//  For Edit Segment [ End ]

//          Selection Category Segment [ END ]            //
////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////
//              Selection Segment [ START ]              //
function loadSelectionList( SelCatId, resetFlag ) {

    if( resetFlag == true ) {   resetAllActions();  }

    load_ajax_loader("divSelectionList", "40px", "48.5%");
    setTimeout(function(){
        $.post( "AdminSelection/ajaxSelectionList/"+SelCatId,
            function( data ) {
                var subCategoryListRespond = JSON.parse(data);

                if( subCategoryListRespond.respond.error_flag ) {
                    if( subCategoryListRespond.respond.error_msg == "not_logged_in") {
                        window.location.href = "/";
                    }
                    else if( subCategoryListRespond.respond.error_msg == "selec_cat_id_missing") {
                        alert("Category Missing");
                    }
                    else if( subCategoryListRespond.respond.error_msg == "invalid_sel_cat_id") {
                        alert("Invalid Category");
                    }
                }
                else if( subCategoryListRespond.respond.error_flag == false ) {
                    if(typeof subCategoryListRespond.respond.content != 'undefined' && subCategoryListRespond.respond.content != "" ) {
                        $("#divSelectionList").html(subCategoryListRespond.respond.content).promise().done(function() {});
                    }
                }
            }
        );
    }, 500);


}

//  For Add Segment [ Start ]
function openAddSelectionDiv( SelCatId ) {
    $("#divAjaxLoad").show("slow");
    load_ajax_loader("divAjaxLoad", "40px", "48.5%");

    loadSelectionList(SelCatId, false);

    $.post( "AdminSelection/ajaxSelectionForm",
        {
            Action : "addSelection",
            SelecCatId : SelCatId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_selec_cat_id" ) {
                    alert("No Category ID.");
                }
                else if( responseObj.respond.error_msg == "wrong_selec_cat_id" ) {
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

function ajaxAddSelection( SelCatId ) {
    var isValid = true;

    if( $( "#SelecName" ).val().trim() == "" ) {
        alert("Name Must Be Provided");
        $( "#SelecName").focus();
        isValid = false;
    }

    if( isValid ) {
        $.post( "AdminSelection/ajaxAddSelection/"+SelCatId,
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
                        $( "#success_msg").html("Selection Inserted Successfully.");

                        if( responseObj.respond.firstEntry ) {   loadSelectionCategoryList();    }

                        loadSelectionList(SelCatId, false);
                        clear_form_elements("divAjaxLoad");     //  Clear All The Input Fields [ File Location: js/utility.js ]
                    }
                }

















            }
        );
    }
}
//  For Add Segment [ End ]





//  For Edit Segment [ Start ]
function openEditSelectionDiv( selCategoryId, selecId ) {
    $("#divAjaxLoad").show("slow");
    load_ajax_loader("divAjaxLoad", "40px", "48.5%");

    $.post( "AdminSelection/ajaxSelectionForm",
        {
            Action : "editSelection",
            SelCategoryId : selCategoryId,
            SelecId : selecId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_category_id" ) {
                    alert("No Category ID.");
                }
                else if( responseObj.respond.error_msg == "invalid_category_id" ) {
                    alert("Invalid Category ID.");
                }
                else if( responseObj.respond.error_msg == "no_selection_id" ) {
                    alert("No Selection ID.");
                }
                else if( responseObj.respond.error_msg == "invalid_selection_id" ) {
                    alert("Invalid Selection ID.");
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

function updateSelection( selecId ) {



    var isValid = true;

    if( $( "#SelecName" ).val().trim() == "" ) {
        alert("Name Must Be Provided");
        $( "#SelecName").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminSelection/ajaxUpdateSelection/"+selecId,
            { PostDataArr : $('#divAjaxLoad :input').serialize() },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    if( responseObj.respond.error_msg == "id_error" ) {
                        alert("ID ERROR PLEASE CONTACT WITH DEVELOPER.");
                    }
                    else if( responseObj.respond.error_msg == "SelecName_missing_error" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Name Must Be Provided.");
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

                    loadSelectionList( $("#FK_SelecCatId").val(), false );
                }
            }
        );
    }
}
//  For Edit Segment [ End ]






//              Selection Segment [ END ]              //
///////////////////////////////////////////////////////////