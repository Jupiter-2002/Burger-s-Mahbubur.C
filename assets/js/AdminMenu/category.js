function resetAllActions() {
    hideDivById('divAjaxLoad');
}

//////////////////////////////////////////////////
//          Category Segment [ START ]          //
//////////////////////////////////////////////////
function loadCategoryList() {
    load_ajax_loader("divCategoryList", "40px", "48.5%");

    setTimeout(function(){
        $.post( "AdminCategory/ajaxCategoryList",
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                        $("#divCategoryList").html(categoryFormRespond.respond.content).promise().done(function() {
                            //$("#divCategoryList").show(500)
                        });
                    }
                }
            }
        );
    }, 500);
}

//  For Add Category Segment [ Start ]
function openAddCategoryDiv() {
    $("#divAjaxLoad").show("slow");
    load_ajax_loader("divAjaxLoad", "40px", "48.5%");

    //  Load 'category_form' contain [ Start ]
    $.post( "AdminCategory/ajaxCategoryForm",
        { Action : "addCategory" },
        function( data ) {
            var categoryFormRespond = JSON.parse(data);

            if( categoryFormRespond.respond.error_flag ) {
                if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
            }
            else if( categoryFormRespond.respond.error_flag == false ) {
                if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                    $("#divAjaxLoad").fadeOut(250, function () {
                        $("#divAjaxLoad").html(categoryFormRespond.respond.content).promise().done(function() {
                            $("#divAjaxLoad").show(250)
                        });
                    });
                }
            }
        }
    );
    //  Load 'category_form' contain [ End ]
}

function addCategory() {
    var isValid = true;

    if( $( "#CatName" ).val().trim() == "" ) {
        alert("Category Name Must Be Provided");
        $( "#CatName").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminCategory/ajaxAddCategory",
            { CatName : $( "#CatName" ).val().trim(), CatDiscount : $( "#CatDiscount" ).val(), CatDesc : $( "#CatDesc" ).val() },
            function( data ) {
                var addCategoryRespond = JSON.parse(data);

                if( addCategoryRespond.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( categoryFormRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorAlreadyExistCategory" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Category already exists.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "NameFieldMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Category Name Missing.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( addCategoryRespond.respond.error_flag == false ) {
                    //  Successfully inserted
                    if(typeof addCategoryRespond.respond.newCatId != 'undefined' && addCategoryRespond.respond.newCatId != "" ) {
                        $( "#error_msg_div").hide("");
                        $( "#error_msg").html("");

                        $( "#success_msg_div").show("slow");
                        $( "#success_msg").html("Category Inserted Successfully.");

                        loadCategoryList();
                        clear_form_elements("divAjaxLoad");     //  Clear All The Input Fields [ File Location: js/utility.js ]
                    }
                }
            }
        );
    }
}
//  For Add Category Segment [ End ]

//  For Edit Category Segment [ START ]
function openEditCategoryDiv( catId ) {
    var isValid = true;

    /*
    if( $("#dropCatId").val().trim() == "" ) {
        alert("Must Select Category");
        $("#dropCatId").focus();
        isValid = false;
    }
    */

    if(isValid) {
        $("#divAjaxLoad").show("slow");
        load_ajax_loader("divAjaxLoad", "40px", "48.5%");

        //  Load 'category_form' contain [ Start ]
        $.post( "AdminCategory/ajaxCategoryForm",
            {
                Action : "editCategory",
                CategoryId : catId
            },
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( categoryFormRespond.respond.error_msg == "invalid_category_id" ) {
                        alert("Issue with category drop down.");
                        $("#dropCatId").focus();

                        $("#divAjaxLoad").fadeOut(250, function () {
                            $("#divAjaxLoad").html("").promise().done(function() {
                                $("#divAjaxLoad").hide(250)
                            });
                        });
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                        $("#divAjaxLoad").fadeOut(250, function () {
                            $("#divAjaxLoad").html(categoryFormRespond.respond.content).promise().done(function() {
                                $("#divAjaxLoad").show(250)
                            });
                        });
                    }
                }
            }
        );
        //  Load 'category_form' contain [ End ]
    }



}

function editCategory( catId ) {
    var isValid = true;

    if( $( "#CatName" ).val().trim() == "" ) {
        alert("Category Name Must Be Provided");
        $( "#CatName").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminCategory/ajaxUpdateCategory/"+catId,
            { CatName : $( "#CatName" ).val().trim(), CatDiscount : $( "#CatDiscount" ).val(), CatDesc : $( "#CatDesc" ).val() },
            function( data ) {
                var addCategoryRespond = JSON.parse(data);

                if( addCategoryRespond.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( addCategoryRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorAlreadyExistCategory" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Category already exists.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "NameFieldMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Category Name Missing.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( addCategoryRespond.respond.error_flag == false ) {
                    //  Successfully inserted

                    $( "#error_msg_div").hide("");
                    $( "#error_msg").html("");

                    $( "#success_msg_div").show("slow");
                    $( "#success_msg").html("Category Updated Successfully.");

                    loadCategoryList();
                    //hideDivById('divAjaxLoad');     //  Clear All The Input Fields [ File Location: js/utility.js ]
                }
            }
        );
    }
}
//  For Edit Category Segment [ End ]
//////////////////////////////////////////////////
//          Category Segment [ END ]          //
//////////////////////////////////////////////////



//////////////////////////////////////////////////////
//          Sub Category Segment [ START ]          //
//////////////////////////////////////////////////////
function loadSubCategoryList( catId, resetFlag ) {
    if( resetFlag == true ) {   resetAllActions();  }

    load_ajax_loader("divSubCategoryList", "40px", "48.5%");
    setTimeout(function(){
        $.post( "AdminCategory/ajaxSubCategoryList/"+catId,
            function( data ) {
                var subCategoryListRespond = JSON.parse(data);

                if( subCategoryListRespond.respond.error_flag ) {
                    if( subCategoryListRespond.respond.error_msg == "not_logged_in") {
                        window.location.href = "/";
                    }
                    else if( subCategoryListRespond.respond.error_msg == "category_id_missing") {
                        alert("Category Missing");
                    }
                    else if( subCategoryListRespond.respond.error_msg == "invalid_category_id") {
                        alert("Invalid Category");
                    }
                }
                else if( subCategoryListRespond.respond.error_flag == false ) {
                    if(typeof subCategoryListRespond.respond.content != 'undefined' && subCategoryListRespond.respond.content != "" ) {
                        $("#divSubCategoryList").html(subCategoryListRespond.respond.content).promise().done(function() {});
                    }
                }
            }
        );
    }, 500);
}

//  For Add Sub Category Segment [ Start ]
function openAddSubCategoryDiv( catId ) {
    $("#divAjaxLoad").show("slow");
    load_ajax_loader("divAjaxLoad", "40px", "48.5%");

    loadSubCategoryList(catId, false);

    //  Load 'category_form' contain [ Start ]
    $.post( "AdminCategory/ajaxSubCategoryForm",
        {
            Action : "addSubCategory",
            CategoryId : catId
        },
        function( data ) {
            var categoryFormRespond = JSON.parse(data);

            if( categoryFormRespond.respond.error_flag ) {
                if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( categoryFormRespond.respond.error_msg == "no_cat_id" ) {
                    alert("No Category ID.");
                }
                else if( categoryFormRespond.respond.error_msg == "wrong_cat_id" ) {
                    alert("Invalid Category ID.");
                }
            }
            else if( categoryFormRespond.respond.error_flag == false ) {
                if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                    $("#divAjaxLoad").fadeOut(250, function () {
                        $("#divAjaxLoad").html(categoryFormRespond.respond.content).promise().done(function() {
                            $("#divAjaxLoad").show(250);
                            loadSubCategoryList(catId, false);
                        });
                    });
                }
            }
        }
    );
    //  Load 'category_form' contain [ End ]
}

function addSubCategory( catId ) {
    var isValid = true;

    if( $( "#SubCatName" ).val().trim() == "" ) {
        alert("Sub Category Name Must Be Provided");
        $( "#SubCatName").focus();
        isValid = false;
    }

    if( isValid ) {
        $.post( "AdminCategory/ajaxAddSubCategory/"+catId,
            { SubCatName : $( "#SubCatName" ).val().trim(), SubCatDiscount : $( "#SubCatDiscount" ).val(), SubCatDesc : $( "#SubCatDesc" ).val() },
            function( data ) {
                var addCategoryRespond = JSON.parse(data);

                console.log(addCategoryRespond);

                if( addCategoryRespond.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");


                    if( addCategoryRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorNameFieldMissing" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Sub Category Name Missing.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorAlreadyExistSubCategory" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Sub Category already exists.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                }
                else if( addCategoryRespond.respond.error_flag == false ) {
                    //  Successfully inserted
                    if(typeof addCategoryRespond.respond.newSubCatId != 'undefined' && addCategoryRespond.respond.newSubCatId != "" ) {
                        $( "#error_msg_div").hide("");
                        $( "#error_msg").html("");

                        $( "#success_msg_div").show("slow");
                        $( "#success_msg").html("Sub Category Inserted Successfully.");

                        loadSubCategoryList(catId, true);
                        clear_form_elements("divAjaxLoad");     //  Clear All The Input Fields [ File Location: js/utility.js ]
                    }
                }
            }
        );
    }
}
//  For Add Sub Category Segment [ End ]

//  For Edit Category Segment [ START ]
function openEditSubCategoryDiv( catId, subCatId ) {

    $("#divAjaxLoad").show("slow");
    load_ajax_loader("divAjaxLoad", "40px", "48.5%");

    //  Load 'category_form' contain [ Start ]
    $.post( "AdminCategory/ajaxSubCategoryForm",
        {
            Action : "editSubCategory",
            CategoryId : catId,
            SubCategoryId : subCatId
        },
        function( data ) {
            var subCategoryFormRespond = JSON.parse(data);

            if( subCategoryFormRespond.respond.error_flag ) {
                if( subCategoryFormRespond.respond.error_msg == "not_logged_in" || subCategoryFormRespond.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( subCategoryFormRespond.respond.error_msg == "no_category_id" ) {
                    alert("No Category ID.");
                }
                else if( subCategoryFormRespond.respond.error_msg == "invalid_category_id" ) {
                    alert("Invalid Category ID.");
                }
                else if( subCategoryFormRespond.respond.error_msg == "no_sub_category_id" ) {
                    alert("No Sub Category ID.");
                }
                else if( subCategoryFormRespond.respond.error_msg == "invalid_sub_category_id" ) {
                    alert("Invalid Sub Category ID.");
                }
            }
            else if( subCategoryFormRespond.respond.error_flag == false ) {
                if(typeof subCategoryFormRespond.respond.content != 'undefined' && subCategoryFormRespond.respond.content != "" ) {
                    $("#divAjaxLoad").fadeOut(250, function () {
                        $("#divAjaxLoad").html(subCategoryFormRespond.respond.content).promise().done(function() {
                            $("#divAjaxLoad").show(250)
                        });
                    });
                }
            }
        }
    );
    //  Load 'category_form' contain [ End ]
}

function editSubCategory( subCatId ) {
    var isValid = true;

    if( $( "#SubCatName" ).val().trim() == "" ) {
        alert("Sub Category Name Must Be Provided");
        $( "#SubCatName").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminCategory/ajaxUpdateSubCategory/"+subCatId,
            {
                SubCatName : $( "#SubCatName" ).val().trim(),
                SubCatDiscount : $( "#SubCatDiscount" ).val(),
                SubCatDesc : $( "#SubCatDesc" ).val(),
                FK_CatId : $( "#FK_CatId" ).val()
            },
            function( data ) {
                var updateSubCategoryRespond = JSON.parse(data);

                if( updateSubCategoryRespond.respond.error_flag ) {
                    $( "#success_msg_div").hide();
                    $( "#success_msg").html("");

                    if( updateSubCategoryRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( updateSubCategoryRespond.respond.error_msg == "sub_cat_id_error" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Sub Category ID Error, Please contact with developer.");
                    }
                    else if( updateSubCategoryRespond.respond.error_msg == "no_SubCatName" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Sub Category Name Missing.");
                    }
                    else if( updateSubCategoryRespond.respond.error_msg == "no_FK_CatId" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Category Is Missing.");
                    }
                    else if( updateSubCategoryRespond.respond.error_msg == "invalid_FK_CatId" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Invalid Category Selected.");
                    }
                    else if( updateSubCategoryRespond.respond.error_msg == "already_exist_SubCatName" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Sub Category already exists.");
                    }
                    else if( updateSubCategoryRespond.respond.error_msg == "DbInsertError" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("Database Error.");
                    }
                    else if( updateSubCategoryRespond.respond.error_msg == "no_Changes" ) {
                        $( "#error_msg_div").show("slow");
                        $( "#error_msg").html("No Changes.");
                    }
                }
                else if( updateSubCategoryRespond.respond.error_flag == false ) {
                    //  Successfully updated

                    $( "#error_msg_div").hide("");
                    $( "#error_msg").html("");

                    $( "#success_msg_div").show("slow");
                    $( "#success_msg").html("Sub Category Updated Successfully.");

                    loadSubCategoryList($( "#FK_CatId" ).val(), false );
                }
            }
        );
    }
}
//  For Edit Category Segment [ END ]
//////////////////////////////////////////////////////
//          Sub Category Segment [ END ]            //
//////////////////////////////////////////////////////