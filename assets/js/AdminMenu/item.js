/////////////////////////////////////////////////////////
/////           Common Segment [ Start ]            /////
function hideAddEditSegment( BaseId ) {
    $("#divAddEdit_"+BaseId).fadeOut(250);
    if( $("#divList_"+BaseId).is(":hidden") ) {
        $("#TrItmCustomize_"+BaseId).fadeOut(250);
    }
}

function hideListSegment( BaseId ) {
    $("#divList_"+BaseId).fadeOut(250);
    if( $("#divAddEdit_"+BaseId).is(":hidden") ) {
        $("#TrItmCustomize_"+BaseId).fadeOut(250);
    }
}
/////           Common Segment [ End ]             /////
/////////////////////////////////////////////////////////


function loadCategoryDropDown() {
    load_ajax_loader("ajaxSpinner", "0px", "5px");

    setTimeout(function() {
        $.post( "../feed/Category/categoryList/1",
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                        $.each(categoryFormRespond.respond.content.arrCategoryDetails, function(key, value) {
                            $("#dropCategory").append(
                                $('<option></option>').val(value.PK_CatId).html(value.CatName)
                            );
                        });

                        $("#ajaxSpinner").hide(200)
                    }
                }
            }
        );
    }, 100);
}

/*
categoryValue ->    The Category Id
loaderDivId ->  Div/span or other html element that holds the Sub Category dropdown
loderDropDownId ->  Dropdown that will hold the Sub Category data
selectedSub ->  If any Sub Category is by Default Selected
 */
function loadSubCategoryOfCategory( categoryValue, loaderDivId, loderDropDownId, selectedSub, targetDivId, ajaxSpinnerId ) {
    $("#"+loaderDivId).hide("100");
    $("#"+loderDropDownId).empty();

    //console.log(targetDivId+" "+ajaxSpinnerId);

    $(targetDivId+" "+ajaxSpinnerId).show(200);

    setTimeout(function() {
        $.post( "../feed/Category/subCategoryList/1",
            {
                catId: categoryValue
            },
            function( data ) {
                var subCategoryFormRespond = JSON.parse(data);

                if( subCategoryFormRespond.respond.error_flag ) {
                    if( subCategoryFormRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( subCategoryFormRespond.respond.error_msg == "no_catId" ) {
                        //alert("Should Select Category.");

                        $(targetDivId+" "+ajaxSpinnerId).hide(200);
                    }
                }
                else if( subCategoryFormRespond.respond.error_flag == false ) {
                    if(typeof subCategoryFormRespond.respond.content != 'undefined' && subCategoryFormRespond.respond.content != "" ) {
                        if( subCategoryFormRespond.respond.content.arrSubCategoryDetails.length > 0 ) {
                            $("#"+loderDropDownId).append(
                                $('<option></option>').val("").html("Select Sub Category")
                            );

                            $.each(subCategoryFormRespond.respond.content.arrSubCategoryDetails, function(key, value) {
                                $("#"+loderDropDownId).append(
                                    $('<option></option>').val(value.PK_SubCatId).html(value.SubCatName)
                                );
                            });

                            if( selectedSub != false ) {
                                $('#'+loderDropDownId+' option[value="'+selectedSub+'"]').attr("selected", "selected");
                            }

                            $("#"+loaderDivId).show("200");
                        }
                        else {
                            $("#"+loderDropDownId).append(
                                $('<option></option>').val("").html("Select Sub Category")
                            );
                        }
                        $(targetDivId+" "+ajaxSpinnerId).hide(200);
                    }
                }
            }
        );
    }, 100);





}

/////////////////////////////////////////////////////////
/////           Add Item Segment [ Start ]          /////
function loadAddItemDiv() {
    $("#divAjaxAddItmLoad").show("slow");
    load_ajax_loader("divAjaxAddItmLoad", "40px", "48.5%");

    var CategorId = $("#dropCategory").val();
    var SubCategorId = $("#dropSubCategory").val();

    //  Load 'category_form' contain [ Start ]
    $.post( "AdminItem/ajaxItemForm",
        {
            Action : "addItem",
            CategorId : CategorId,
            SubCategorId : SubCategorId,
        },
        function( data ) {
            var itemFormRespond = JSON.parse(data);

            if( itemFormRespond.respond.error_flag ) {
                if( itemFormRespond.respond.error_msg == "not_logged_in" || itemFormRespond.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
            }
            else if( itemFormRespond.respond.error_flag == false ) {

                if(typeof itemFormRespond.respond.content != 'undefined' && itemFormRespond.respond.content != "" ) {
                    $("#divAjaxAddItmLoad").fadeOut(250, function () {
                        $("#divAjaxAddItmLoad").html(itemFormRespond.respond.content).promise().done(function() {
                            $("#divAjaxAddItmLoad").show(250);
                        });
                    });
                }
            }
        }
    );
    //  Load 'category_form' contain [ End ]
}

function addBaseItem() {
    var isValid = true;

    var FK_CatId = $("#FK_CatId").val();
    var FK_SubCatId = $("#FK_SubCatId").val();

    if( $( "#FK_CatId" ).val().trim() == "" ) {
        alert("Category Must Be Selected.");
        $( "#FK_CatId").focus();
        isValid = false;
    }
    else if( $('#FK_SubCatId option').length > 1 && $( "#FK_SubCatId" ).val().trim() == "" ) {
        alert("Sub Category Must Be Selected.");
        $( "#FK_SubCatId").focus();
        isValid = false;

    }
    else if( $( "#BaseName" ).val().trim() == "" ) {
        alert("Name Must Be Provided.");
        $( "#BaseName").focus();
        isValid = false;
    }
    else if( $( "#BasePrice" ).val().trim() == "" ) {
        alert("Price Must Be Provided.");
        $( "#BasePrice").focus();
        isValid = false;
    }
    else if( $( "#BaseType" ).val().trim() == "" ) {
        alert("Type Must Be Selected.");
        $( "#BaseType").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminItem/ajaxAddItem",
            { AddItemSubmitArr : $('#divAjaxAddItmLoad :input').serialize() },
            function( data ) {
                var addCategoryRespond = JSON.parse(data);

                if( addCategoryRespond.respond.error_flag ) {
                    $( "#itm_form_success_msg_div").hide();
                    $( "#itm_form_success_msg").html("");

                    if( addCategoryRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorInSerializeData" ) {
                        alert("Error In FORM Data");
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorInPostData" ) {
                        alert("Error In POST Data");
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorItmAlreadyExist" ) {
                        $( "#itm_form_error_msg_div").show("slow");
                        $( "#itm_form_error_msg").html("Item already exists.");
                    }
                }
                else if( addCategoryRespond.respond.error_flag == false ) {
                    //  Successfully inserted
                    if(typeof addCategoryRespond.respond.newBaseId != 'undefined' && addCategoryRespond.respond.newBaseId != "" ) {
                        $( "#itm_form_error_msg_div").hide("");
                        $( "#itm_form_error_msg").html("");

                        $( "#itm_form_success_msg_div").show("slow");
                        $( "#itm_form_success_msg").html("Category Inserted Successfully.");

                        loadViewItemDiv(FK_CatId, FK_SubCatId);
                        clear_form_elements("divAjaxAddItmLoad");     //  Clear All The Input Fields [ File Location: js/utility.js ]

                        $('#FK_CatId option[value="'+FK_CatId+'"]').attr("selected", "selected");
                        $('#FK_SubCatId option[value="'+FK_SubCatId+'"]').attr("selected", "selected");
                    }
                }
            }
        );
    }
}
/////           Add Item Segment [ End ]            /////
/////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////
/////           Edit Item Segment [ Start ]         /////
function loadEditItemDiv( BaseId ) {
    $("#divAjaxAddItmLoad").show("slow");
    load_ajax_loader("divAjaxAddItmLoad", "40px", "48.5%");

    $.post( "AdminItem/ajaxItemForm",
        {
            Action : "editItem",
            BaseId : BaseId
        },
        function( data ) {
            var itemFormRespond = JSON.parse(data);

            if( itemFormRespond.respond.error_flag ) {
                if( itemFormRespond.respond.error_msg == "not_logged_in" || itemFormRespond.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( itemFormRespond.respond.error_msg == "no_itm_id" ) {
                    alert("No Item Id Found.");
                }
            }
            else if( itemFormRespond.respond.error_flag == false ) {


                if(typeof itemFormRespond.respond.content != 'undefined' && itemFormRespond.respond.content != "" ) {
                    $("#divAjaxAddItmLoad").fadeOut(250, function () {
                        $("#divAjaxAddItmLoad").html(itemFormRespond.respond.content).promise().done(function() {
                            $("#divAjaxAddItmLoad").show(250);
                        });
                    });
                }
            }
        }
    );
}

function updateBaseItem( BaseId ) {
    var isValid = true;

    var FK_CatId = $("#FK_CatId").val();
    var FK_SubCatId = $("#FK_SubCatId").val();

    if( $( "#FK_CatId" ).val().trim() == "" ) {
        alert("Category Must Be Selected.");
        $( "#FK_CatId").focus();
        isValid = false;
    }
    else if( $('#FK_SubCatId option').length > 1 && $( "#FK_SubCatId" ).val().trim() == "" ) {
        alert("Sub Category Must Be Selected.");
        $( "#FK_SubCatId").focus();
        isValid = false;

    }
    else if( $( "#BaseName" ).val().trim() == "" ) {
        alert("Name Must Be Provided.");
        $( "#BaseName").focus();
        isValid = false;
    }
    else if( $( "#BasePrice" ).val().trim() == "" ) {
        alert("Price Must Be Provided.");
        $( "#BasePrice").focus();
        isValid = false;
    }
    else if( $( "#BaseType" ).val().trim() == "" ) {
        alert("Type Must Be Selected.");
        $( "#BaseType").focus();
        isValid = false;
    }

    if(isValid) {
        $.post( "AdminItem/ajaxUpdateItem/"+BaseId,
            { AddUpdateSubmitArr : $('#divAjaxAddItmLoad :input').serialize() },
            function( data ) {
                var addCategoryRespond = JSON.parse(data);

                if( addCategoryRespond.respond.error_flag ) {
                    $( "#itm_form_success_msg_div").hide();
                    $( "#itm_form_success_msg").html("");

                    if( addCategoryRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorInSerializeData" ) {
                        alert("Error In FORM Data");
                    }
                    else if( addCategoryRespond.respond.error_msg == "base_id_error" ) {
                        alert("Wrong Item Id.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "no_FK_CatId" || addCategoryRespond.respond.error_msg == "invalid_FK_CatId" ) {
                        alert("Invalid Category.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "invalid_FK_SubCatId" || addCategoryRespond.respond.error_msg == "no_FK_SubCatId" ) {
                        alert("Invalid Sub Category.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorItmAlreadyExist" ) {
                        $( "#itm_form_error_msg_div").show("slow");
                        $( "#itm_form_error_msg").html("Item already exists.");
                    }
                    else if( addCategoryRespond.respond.error_msg == "ErrorInPostData" ) {
                        alert("Error In POST Data");
                    }
                }
                else if( addCategoryRespond.respond.error_flag == false ) {
                    //  Successfully Updated
                    $( "#itm_form_error_msg_div").hide("");
                    $( "#itm_form_error_msg").html("");

                    $( "#itm_form_success_msg_div").show("slow");
                    $( "#itm_form_success_msg").html("Item Updated Successfully.");

                    loadViewItemDiv(FK_CatId, FK_SubCatId);

                    $('#FK_CatId option[value="'+FK_CatId+'"]').attr("selected", "selected");
                    $('#FK_SubCatId option[value="'+FK_SubCatId+'"]').attr("selected", "selected");
                }
            }
        );
    }
}
/////           Edit Item Segment [ End ]           /////
/////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////
/////           Load View Item Segment [ Start ]          /////
function loadViewItemDiv( CategorIdValue, SubCategorIdValue ) {
    var CategorId="";
    var SubCategorId="";

    if( CategorIdValue != false ) {
        CategorId = CategorIdValue;
    } else {
        CategorId = $("#dropCategory").val();
    }

    if( SubCategorIdValue != false ) {
        SubCategorId = SubCategorIdValue;
    } else {
        SubCategorId = $("#dropSubCategory").val();
    }

    if( CategorId == "" ) {
        alert("Category Must Be Selected.");
        $( "#dropCategory").focus();
    }
    else {
        $("#divAjaxViewItmLoad").show("slow");
        load_ajax_loader("divAjaxViewItmLoad", "40px", "48.5%");

        //  Load 'category_form' contain [ Start ]
        $.post( "AdminItem/ajaxViewItemList",
            {
                CategorId : CategorId,
                SubCategorId : SubCategorId,
            },
            function( data ) {
                var itemViewRespond = JSON.parse(data);

                if( itemViewRespond.respond.error_flag ) {
                    if( itemViewRespond.respond.error_msg == "not_logged_in" || itemViewRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( itemViewRespond.respond.error_flag == false ) {
                    if(typeof itemViewRespond.respond.content != 'undefined' && itemViewRespond.respond.content != "" ) {
                        $("#divAjaxViewItmLoad").fadeOut(250, function () {
                            $("#divAjaxViewItmLoad").html(itemViewRespond.respond.content).promise().done(function() {
                                $("#divAjaxViewItmLoad").show(250);
                            });
                        });
                    }
                }
            }
        );
        //  Load 'category_form' contain [ End ]
    }
}
/////           Load View Item Segment [ End ]            /////
///////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////
/////           Topping Segment [ Start ]           /////
function loadBaseToppingList( BaseId, AddEditDivHide ) {
    if( AddEditDivHide == true ) {  $("#divAddEdit_"+BaseId).hide("slow");  }

    $("#TrItmCustomize_"+BaseId).show();
    $("#divList_"+BaseId).show("slow");
    load_ajax_loader("divList_"+BaseId, "40px", "48.5%");

    $.post( "AdminItem/ajaxLoadBaseToppingList",
        {
            BaseId : BaseId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_base_id" ) {
                    alert("No Base Id Found.");
                }
                else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                    alert("Invalid Base Id Found.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {

                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#divList_"+BaseId).html(responseObj.respond.content).promise().done(function() {
                        $("#TrItmCustomize_"+BaseId).show(250);
                        $("#divList_"+BaseId).show(250);
                    });
                }

            }
        }
    );
}

function loadToppingBaseForm( BaseId ) {
    $("#TrItmCustomize_"+BaseId).show();
    $("#divAddEdit_"+BaseId).show("slow");
    load_ajax_loader("divAddEdit_"+BaseId, "40px", "48.5%");

    $.post( "AdminItem/ajaxBaseToppingForm",
        {
            Action : "addTopping",
            BaseId : BaseId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_base_id" ) {
                    alert("No Base Id Found.");
                }
                else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                    alert("Invalid Base Id Found.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {

                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#TrItmCustomize_"+BaseId).fadeOut(250, function () {
                        $("#divAddEdit_"+BaseId).html(responseObj.respond.content).promise().done(function() {
                            $("#TrItmCustomize_"+BaseId).show(250);
                            $("#divAddEdit_"+BaseId).show(250);
                        });
                    });
                }

            }
        }
    );
}

function loadToppingByCategoryForm( BaseId ) {
    var isValid = true;
    var ToppCatId = $("#divAddEdit_"+BaseId+" #PK_ToppCatId").val().trim();

    if( ToppCatId == "" ) {
        alert("Category Must Be Selected.");
        $("#divAddEdit_"+BaseId+" #PK_ToppCatId").focus();
        isValid = false;
    }
    else {
        $("#divAddEdit_"+BaseId+" #spanToppingList").show("slow");
        load_ajax_loader("#divAddEdit_"+BaseId+" #spanToppingList", "40px", "48.5%");
    }

    if( isValid ) {
        $.post( "AdminItem/ajaxToppingByCategory",
            {
                BaseId : BaseId,
                ToppCatId : ToppCatId
            },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "no_base_id" ) {
                        alert("No Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                        alert("Invalid Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "no_cat_id" ) {
                        alert("No Category Selected");
                    }
                    else if( responseObj.respond.error_msg == "invalid_cat_id" ) {
                        alert("Invalid Category");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {

                    if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                        $("#divAddEdit_"+BaseId+" #spanToppingList").fadeOut(250, function () {
                            $("#divAddEdit_"+BaseId+" #spanToppingList").html(responseObj.respond.content).promise().done(function() {
                                $("#divAddEdit_"+BaseId+" #spanToppingList").show(250);
                            });
                        });
                    }

                }
            }
        );
    }
}

function saveToppingToBase( BaseId ) {
    var isValid = true;

    if( isValid ) {
        $.post( "AdminItem/ajaxSaveToppingToBase/"+BaseId,
            {
                PostDataArr : $("#divAddEdit_"+BaseId+" :input").serialize()
            },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#topp_form_success_msg_div").hide();
                    $( "#topp_form_success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "no_base_id" ) {
                        alert("No Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                        alert("Invalid Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "nothing_to_add" ) {
                        $( "#topp_form_error_msg_div").show("slow");
                        $( "#topp_form_error_msg").html("Nothing to add.");
                    }
                    else if( responseObj.respond.error_msg == "major_issue" ) {
                        alert("Something is wrong please contact with developer.");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    $( "#divAddEdit_"+BaseId+" #topp_form_error_msg_div").hide("");
                    $( "#divAddEdit_"+BaseId+" #topp_form_error_msg").html("");

                    $( "#divAddEdit_"+BaseId+" #topp_form_success_msg_div").show("slow");
                    $( "#divAddEdit_"+BaseId+" #topp_form_success_msg").html("Successfully Saved.");

                    loadBaseToppingList( BaseId, false );
                }
            }
        );
    }
}

/////           Base Selection Topping Segment [ Start ]           /////
function loadBaseSelectionToppingList( BaseId, SelecId, AddEditDivHide ) {
    if( AddEditDivHide == true ) {  $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId).hide("slow");  }

    $("#TrSelecToppingCustomize_"+BaseId+"_"+SelecId).show();
    $("#divSelecToppingList_"+BaseId+"_"+SelecId).show("slow");
    load_ajax_loader("divSelecToppingList_"+BaseId+"_"+SelecId, "40px", "48.5%");


    $.post( "AdminItem/ajaxLoadBaseSelectionToppingList",
        {
            BaseId : BaseId,
            SelecId : SelecId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_base_id" ) {
                    alert("No Base Id Found.");
                }
                else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                    alert("Invalid Base Id Found.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {

                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#divSelecToppingList_"+BaseId+"_"+SelecId).html(responseObj.respond.content).promise().done(function() {
                        $("#TrSelecToppingCustomize_"+BaseId+"_"+SelecId).show(250);
                        $("#divSelecToppingList_"+BaseId+"_"+SelecId).show(250);
                    });
                }

            }
        }
    );

}

function loadSelectionToppingBaseForm( BaseId, SelecId ) {
    $("#TrSelecToppingCustomize_"+BaseId+"_"+SelecId).show();
    $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId).show("slow");
    load_ajax_loader("divSelecToppingAddEdit_"+BaseId+"_"+SelecId, "40px", "48.5%");

    $.post( "AdminItem/ajaxBaseSelectionToppingForm",
        {
            Action : "addTopping",
            BaseId : BaseId,
            SelecId : SelecId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_base_id" ) {
                    alert("No Base Id Found.");
                }
                else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                    alert("Invalid Base Id Found.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {

                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#TrSelecToppingCustomize_"+BaseId+"_"+SelecId).fadeOut(250, function () {
                        $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId).html(responseObj.respond.content).promise().done(function() {
                            $("#TrSelecToppingCustomize_"+BaseId+"_"+SelecId).show(250);
                            $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId).show(250);
                        });
                    });
                }

            }
        }
    );
}

function loadSelectionToppingByCategoryForm( BaseId, SelecId ) {
    var isValid = true;
    var ToppCatId = $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #PK_ToppCatId").val().trim();

    if( ToppCatId == "" ) {
        alert("Category Must Be Selected.");
        $("#divSelecToppingAddEdit_"+BaseId+" #PK_ToppCatId").focus();
        isValid = false;
    }
    else {
        $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #spanToppingList").show("slow");
        load_ajax_loader("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #spanToppingList", "40px", "48.5%");
    }

    if( isValid ) {
        $.post( "AdminItem/ajaxSelectionToppingByCategory",
            {
                BaseId : BaseId,
                ToppCatId : ToppCatId,
                SelecId : SelecId
            },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "no_base_id" ) {
                        alert("No Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                        alert("Invalid Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "no_cat_id" ) {
                        alert("No Category Selected");
                    }
                    else if( responseObj.respond.error_msg == "invalid_cat_id" ) {
                        alert("Invalid Category");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {

                    if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                        $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #spanToppingList").fadeOut(250, function () {
                            $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #spanToppingList").html(responseObj.respond.content).promise().done(function() {
                                $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #spanToppingList").show(250);
                            });
                        });
                    }

                }
            }
        );
    }
}

function saveToppingToBaseSelection( BaseId, SelecId ) {
    var isValid = true;

    if( isValid ) {
        $.post( "AdminItem/ajaxSaveToppingToBaseSelection/"+BaseId+"/"+SelecId,
            {
                PostDataArr : $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" :input").serialize()
            },
            function( data ) {
                var responseObj = JSON.parse(data);
                console.log(responseObj);

                if( responseObj.respond.error_flag ) {
                    $( "#topp_form_success_msg_div").hide();
                    $( "#topp_form_success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "no_base_id" ) {
                        alert("No Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_selec_id" ) {
                        alert("Invalid Selection Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "no_selec_id" ) {
                        alert("No Selection Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                        alert("Invalid Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "nothing_to_add" ) {
                        $( "#topp_form_error_msg_div").show("slow");
                        $( "#topp_form_error_msg").html("Nothing to add.");
                    }
                    else if( responseObj.respond.error_msg == "major_issue" ) {
                        alert("Something is wrong please contact with developer.");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    $( "#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #topp_form_error_msg_div").hide("");
                    $( "#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #topp_form_error_msg").html("");

                    $( "#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #topp_form_success_msg_div").show("slow");
                    $( "#divSelecToppingAddEdit_"+BaseId+"_"+SelecId+" #topp_form_success_msg").html("Successfully Saved.");

                    loadBaseSelectionToppingList( BaseId, SelecId, false );
                }
            }
        );
    }
}

function hideAddEditSelectionSegment( BaseId, SelecId ) {
    $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId).fadeOut(250);
    if( $("#divSelecToppingList_"+BaseId+"_"+SelecId).is(":hidden") ) {
        $("#TrSelecToppingCustomize_"+BaseId+"_"+SelecId).fadeOut(250);
    }
}

function hideListSelectionSegment( BaseId, SelecId ) {
    $("#divSelecToppingList_"+BaseId+"_"+SelecId).fadeOut(250);
    if( $("#divSelecToppingAddEdit_"+BaseId+"_"+SelecId).is(":hidden") ) {
        $("#TrSelecToppingCustomize_"+BaseId+"_"+SelecId).fadeOut(250);
    }
}
/////           Base Selection Topping Segment [ End ]             /////

/////           Topping Segment [ End ]             /////
/////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////
/////           Selection Segment [ Start ]         /////
function loadBaseSelectionList( BaseId, AddEditDivHide ) {
    if( AddEditDivHide == true ) {  $("#divAddEdit_"+BaseId).hide("slow");  }

    $("#TrItmCustomize_"+BaseId).show();
    $("#divList_"+BaseId).show("slow");
    load_ajax_loader("divList_"+BaseId, "40px", "48.5%");

    $.post( "AdminItem/ajaxLoadBaseSelectionList",
        {
            BaseId : BaseId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_base_id" ) {
                    alert("No Base Id Found.");
                }
                else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                    alert("Invalid Base Id Found.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {

                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#divList_"+BaseId).html(responseObj.respond.content).promise().done(function() {
                        $("#TrItmCustomize_"+BaseId).show(250);
                        $("#divList_"+BaseId).show(250);
                    });
                }

            }

        }
    );
}

function loadBaseSelectionForm( BaseId ) {
    $("#TrItmCustomize_"+BaseId).show();
    $("#divAddEdit_"+BaseId).show("slow");
    load_ajax_loader("divAddEdit_"+BaseId, "40px", "48.5%");

    $.post( "AdminItem/ajaxBaseSelectionForm",
        {
            Action : "addSelection",
            BaseId : BaseId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_base_id" ) {
                    alert("No Base Id Found.");
                }
                else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                    alert("Invalid Base Id Found.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {

                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#TrItmCustomize_"+BaseId).fadeOut(250, function () {
                        $("#divAddEdit_"+BaseId).html(responseObj.respond.content).promise().done(function() {
                            $("#TrItmCustomize_"+BaseId).show(250);
                            $("#divAddEdit_"+BaseId).show(250);
                        });
                    });
                }

            }
        }
    );
}

function loadSelectionByCategoryForm( BaseId ) {
    var isValid = true;
    var SelecCatId = $("#divAddEdit_"+BaseId+" #PK_SelecCatId").val().trim();

    if( SelecCatId == "" ) {
        alert("Category Must Be Selected.");
        $("#divAddEdit_"+BaseId+" #PK_SelecCatId").focus();
        isValid = false;
    }
    else {
        $("#divAddEdit_"+BaseId+" #spanToppingList").show("slow");
        load_ajax_loader("#divAddEdit_"+BaseId+" #spanSelectionList", "40px", "48.5%");
    }


    if( isValid ) {
        $.post( "AdminItem/ajaxSelectionByCategory",
            {
                BaseId : BaseId,
                SelecCatId : SelecCatId
            },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "no_base_id" ) {
                        alert("No Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                        alert("Invalid Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "no_cat_id" ) {
                        alert("No Category Selected");
                    }
                    else if( responseObj.respond.error_msg == "invalid_cat_id" ) {
                        alert("Invalid Category");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                        $("#divAddEdit_"+BaseId+" #spanSelectionList").fadeOut(250, function () {
                            $("#divAddEdit_"+BaseId+" #spanSelectionList").html(responseObj.respond.content).promise().done(function() {
                                $("#divAddEdit_"+BaseId+" #spanSelectionList").show(250);
                            });
                        });
                    }
                }
            }
        );
    }


}

function saveSelectionToBase( BaseId ) {
    var isValid = true;

    if( isValid ) {
        $.post( "AdminItem/ajaxSaveSelecToBase/"+BaseId,
            {
                PostDataArr : $("#divAddEdit_"+BaseId+" :input").serialize()
            },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#topp_form_success_msg_div").hide();
                    $( "#topp_form_success_msg").html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "no_base_id" ) {
                        alert("No Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                        alert("Invalid Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "nothing_to_add" ) {
                        $( "#topp_form_error_msg_div").show("slow");
                        $( "#topp_form_error_msg").html("Nothing to add.");
                    }
                    else if( responseObj.respond.error_msg == "major_issue" ) {
                        alert("Something is wrong please contact with developer.");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    $( "#divAddEdit_"+BaseId+" #topp_form_error_msg_div").hide("");
                    $( "#divAddEdit_"+BaseId+" #topp_form_error_msg").html("");

                    $( "#divAddEdit_"+BaseId+" #topp_form_success_msg_div").show("slow");
                    $( "#divAddEdit_"+BaseId+" #topp_form_success_msg").html("Successfully Saved.");

                    loadBaseSelectionList( BaseId, false );
                }
            }
        );
    }
}
/////           Selection Segment [ End ]           /////
/////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////
/////           Special Item Segment [ Start ]         /////


function loadCategoryDropDownFrSpecialItm( BaseId ) {
    load_ajax_loader("TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #ajaxSpinnerFrSpecialItm", "0px", "5px");

    setTimeout(function() {
        $.post( "../feed/Category/categoryList/1",
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {

                        $.each(categoryFormRespond.respond.content.arrCategoryDetails, function(key, value) {
                            $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #dropCategoryFrSpecialItm").append(
                                $('<option></option>').val(value.PK_CatId).html(value.CatName)
                            );
                        });

                        $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #ajaxSpinnerFrSpecialItm").hide(200)
                    }
                }
            }
        );
    }, 100);
}

function loadBaseSpecialForm( BaseId, AddEditDivHide ) {
    $("#TrSpacialItmCustomize_"+BaseId).show();
    $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId).show("slow");
    load_ajax_loader("TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId, "40px", "48.5%");

    $.post( "AdminItem/ajaxBaseSpecialForm",
        {
            Action : "addSpecial",
            BaseId : BaseId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" || responseObj.respond.error_msg == "no_action" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_base_id" ) {
                    alert("No Base Id Found.");
                }
                else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                    alert("Invalid Base Id Found.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {
                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#TrSpacialItmCustomize_"+BaseId).fadeOut(250, function () {
                        $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId).html(responseObj.respond.content).promise().done(function() {
                            $("#TrSpacialItmCustomize_"+BaseId).show(250);
                            $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId).show(250);

                            setTimeout(loadCategoryDropDownFrSpecialItm( BaseId ), 200);
                        });
                    });
                }
            }
        }
    );
}

function loadViewItemFrSpacialItemDiv( CategorIdValue, SubCategorIdValue, BaseId ) {
    var CategorId = "";
    var SubCategorId = "";

    if( CategorIdValue != false ) {
        CategorId = CategorIdValue;
    } else {
        CategorId = $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #dropCategoryFrSpecialItm").val();
    }

    if( SubCategorIdValue != false ) {
        SubCategorId = SubCategorIdValue;
    } else {
        SubCategorId = $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #divSubCategoryFrSpecialItm #dropSubCategoryFrSpecialItm").val();
    }

    if( CategorId == "" ) {
        alert("Category Must Be Selected.");
        $( "#dropCategory").focus();
    }
    /*
    //  Sub Category Checker
    else if( $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #divSubCategoryFrSpecialItm #dropSubCategoryFrSpecialItm option").length > 1 && SubCategorId == "" ) {
        alert("Sub Category Must Be Selected.");
        $( "#dropCategory").focus();
    }
    */
    else {
        $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail").show("slow");
        load_ajax_loader("TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail", "40px", "48.5%");

        //  Load 'category_form' contain [ Start ]
        $.post( "AdminItem/ajaxItemListFrSpecial",
            {
                CategorId : CategorId,
                SubCategorId : SubCategorId,
                BaseId : BaseId
            },
            function( data ) {
                var itemViewRespond = JSON.parse(data);

                if( itemViewRespond.respond.error_flag ) {
                    if( itemViewRespond.respond.error_msg == "not_logged_in" || itemViewRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( itemViewRespond.respond.error_flag == false ) {
                    if(typeof itemViewRespond.respond.content != 'undefined' && itemViewRespond.respond.content != "" ) {

                        $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail").fadeOut(250, function () {
                            $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail").html(itemViewRespond.respond.content).promise().done(function() {
                                $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail").show(250);
                            });
                        });

                    }
                }
            }
        );

        //  Load 'category_form' contain [ End ]
    }
}

function saveBaseAndSelectionToSpecial( BaseId ) {
    isValid = true;

    if( $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail input[name='flagAddToSpacial_Itm[]']:checked").length > 0 ) {
        $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail input[name='flagAddToSpacial_Itm[]']:checked")
            .each(function () {
                if( $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail input[name='flagAddToSpacial_Itm_Selection["+parseInt($(this).val())+"][]']").length > 0 ) {
                    if( $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail input[name='flagAddToSpacial_Itm_Selection["+parseInt($(this).val())+"][]']:checked").length > 0 ) {

                    }
                    else {
                        //console.log(this);
                        this.focus();

                        window.scrollTo({
                            top: $(window).scrollTop()-150,
                            behavior: 'smooth'
                        });

                        isValid = false;
                        alert("You must select minimum one selection to add the item to the spacial");
                        return false;
                    }
                }
            });
    }
    else {
        isValid = false;
        alert("You must select minimum one item");
    }


    if( isValid && $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail #selectionName").val() == "" ) {
        isValid = false;
        $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail #selectionName").focus();
        alert("You must provide a Selection Name");
    }


    if( isValid) {
        $.post( "AdminItem/ajaxSaveBaseToSpacialItem_MainForm/"+BaseId,
            {
                PostDataArr : $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #spanAddEditSpacialItemDetail :input").serialize(),
                Category : $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #dropCategoryFrSpecialItm").val(),
                SubCategory :
                    ( $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #dropSubCategoryFrSpecialItm").val() > 0 ) ?
                        $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #dropSubCategoryFrSpecialItm").val() : 0
            },
            function( data ) {
                var responseObj = JSON.parse(data);

                if( responseObj.respond.error_flag ) {
                    $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_success_msg_div" ).hide();
                    $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_success_msg" ).html("");

                    if( responseObj.respond.error_msg == "not_logged_in" ) {
                        window.location.href = "/";
                    }
                    else if( responseObj.respond.error_msg == "no_base_id" ) {
                        alert("No Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "no_Category_id" ) {
                        alert("No Category Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                        alert("Invalid Base Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_category_id" ) {
                        alert("Invalid Category Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "invalid_sub_category_id" ) {
                        alert("Invalid Sub Category Id Found.");
                    }
                    else if( responseObj.respond.error_msg == "databaseError" ) {
                        alert("Database Error: Contact Developer.");
                    }
                    else if( responseObj.respond.error_msg == "nothing_to_add" ) {
                        $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_error_msg_div" ).show("slow");
                        $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_error_msg" ).html("Nothing to add.");
                    }
                    else if( responseObj.respond.error_msg == "no_selectionName" ) {
                        $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_error_msg_div" ).show("slow");
                        $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_error_msg" ).html("Selection Name Must Be Provided");
                    }
                }
                else if( responseObj.respond.error_flag == false ) {
                    $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_error_msg_div" ).hide("slow");
                    $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_error_msg" ).html();

                    $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_success_msg_div" ).show("slow");
                    $( "#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId+" #special_item_form_success_msg" ).html("Successfully Added");





                    //loadBaseSelectionList( BaseId, false );
                }
            }
        );
    }




}





function loadBaseSpecialItmDetailsList( BaseId ) {
    $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmAddEdit_"+BaseId).hide("slow");

    $("#TrSpacialItmCustomize_"+BaseId).show();
    $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmList_"+BaseId).show("slow");
    load_ajax_loader("TrSpacialItmCustomize_"+BaseId+" #SpacialItmList_"+BaseId, "40px", "48.5%");

    $.post( "AdminItem/ajaxLoadBaseSpecialItmDetailsList",
        {
            BaseId : BaseId
        },
        function( data ) {
            var responseObj = JSON.parse(data);

            if( responseObj.respond.error_flag ) {
                if( responseObj.respond.error_msg == "not_logged_in" ) {
                    window.location.href = "/";
                }
                else if( responseObj.respond.error_msg == "no_base_id" ) {
                    alert("No Base Id Found.");
                }
                else if( responseObj.respond.error_msg == "invalid_base_id" ) {
                    alert("Invalid Base Id Found.");
                }
            }
            else if( responseObj.respond.error_flag == false ) {

                if(typeof responseObj.respond.content != 'undefined' && responseObj.respond.content != "" ) {
                    $("#TrSpacialItmCustomize_"+BaseId).fadeOut(250, function () {
                        $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmList_"+BaseId).html(responseObj.respond.content).promise().done(function() {
                            $("#TrSpacialItmCustomize_"+BaseId).show(250);
                            $("#TrSpacialItmCustomize_"+BaseId+" #SpacialItmList_"+BaseId).show(250);
                        });
                    });
                }

            }

        }
    );





}


/////           Special Item Segment [ End ]           /////
////////////////////////////////////////////////////////////