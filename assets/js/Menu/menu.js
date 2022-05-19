function loadPagecontent() {
    load_ajax_loader_front("categoryList", "40px", "48.5%");
    load_ajax_loader_front("itemList", "40px", "48.5%");
    load_ajax_loader_front("cartLoad", "40px", "48.5%");

    var OrderType = "";
    //var OrderType = 1;

    loadCategoryList(OrderType);
}

function loadOrderTypePopUp() {
    setTimeout(function() {
        $.colorbox({
            inline:true, 
            initialWidth: "100%", 
            href:"#OrderTypePopUpContain",
            onload: setTimeout(function() {
                $('#cboxClose').remove();

                //  Reset POP UP [ START ]
                $("#DivMessageSelectOrderType").hide();
                $("#MessageSelectOrderType").css({ 'color': '' });
                $("#MessageSelectOrderType").html("");
                $("#popUpDeliveryPostCode").val("");

                setTimeout(function() {
                    colorboxResize(true);
                }, 10 );
                //  Reset POP UP [ END ]
            }, 50 )
        })
    },100);
}

function selectOrderType( orderType ) {
    $("#popUpDeliveryPostCode").val($("#popUpDeliveryPostCode").val().trim());

    var postCode = "";

    if( $("#popUpDeliveryPostCode").val() != "" ) {
        postCode = $("#popUpDeliveryPostCode").val();
    }

    if( orderType == 2 && postCode == "" ) {
        $("#popUpDeliveryPostCode").focus();
        $("#MessageSelectOrderType").css({ 'color': 'red' });
        $("#MessageSelectOrderType").html("Address must be provided.");

        $("#DivMessageSelectOrderType").show( "slow" );

        colorboxResize(true);
    }
    else {
        setTimeout(function() {
            $.post( "order/ajaxSelectOrderType",
                { OrderType : orderType, PostCode : postCode },
                function( data ) {
                    var arrResponse = JSON.parse(data);
    
                    if( arrResponse.respond.error_flag ) {
                        if( arrResponse.respond.error_msg == "no_OrderType" ) {
                            alert("InternalError: No Order Type");
                        }
                        else if( arrResponse.respond.error_msg == "invalid_OrderType" ) {
                            alert("InternalError: Invalid Order Type");
                        }
                        else if( arrResponse.respond.error_msg == "not_inside_delivery_area" ) {
                            $("#DivMessageSelectOrderType").show();
                            $("#popUpDeliveryPostCode").focus();
                            $("#MessageSelectOrderType").css({ 'color': 'red' });
                            $("#MessageSelectOrderType").html("Your address is outside our DELIVERY AREA. Please try with another POST CODE.");

                            setTimeout(function() {
                                colorboxResize(true);
                            }, 100 );
                        }
                    }
                    else if( arrResponse.respond.error_flag == false ) {
                        $.colorbox.close();
                        loadPagecontent();
                    }
                }
            );
        }, 100);
    }
}

//////////////////////////////////////////////////
//          Category Segment [ START ]          //
//////////////////////////////////////////////////
function loadCategoryList(OrderType) {
    load_ajax_loader_front("categoryList", "40px", "48.5%");

    setTimeout(function(){
        $.post( "menu/ajaxCategoryList",
            { OrderType : OrderType },
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {

                        //  Using Promiss [ START ]
                        //  DOC: https://www.w3schools.com/Js/js_promise.asp
                        const myPromise = new Promise(function(myResolve, myReject) {
                            myResolve(renderCategoryList(categoryFormRespond.respond.content));
                        });

                        myPromise.then(function(value) {
                                loadItemList(OrderType);
                            },function(error) {
                                /* code if some error */
                            }
                        );
                        //  Using Promiss [ END ]


                        /*
                        $("#categoryList").html(categoryFormRespond.respond.content).promise().done(function() {
                            loadItemList(OrderType);
                        });
                        */
                    }
                }
            }
        );
    }, 500);


}

function renderCategoryList( data ) {
    $("#categoryList").html('<div class="leftpanel_headings">Category Filter</div>');   //  Adding The Title

    if( data.categoryList !== undefined && data.categoryList.length > 0 ) {
        $("#categoryList").append('<div class="cuisinesearch"></div>');     //  Adding The Holder <div>
        $("#categoryList .cuisinesearch").append('<ul id="tabs"></ul>');    //  Adding The <ul>

        let lastCatName = "";
        data.categoryList.forEach((item) => {
            if( lastCatName !== item.CatName ) {
                $("#categoryList .cuisinesearch #tabs").append(
                    '<li><span class="cuisinesearch-text"><a href="#CatItmContainer_'+item.CatName+'" >'+item.CatName+'</a></span></li>'
                );   //  Adding The Title

                lastCatName = item.CatName;
            }
        });

        $( "#categoryList .cuisinesearch #tabs li" ).first().children(".cuisinesearch-text").children("a").addClass("selected").attr('id', 'current');
    } else {
        $("#categoryList").append('<div class="leftpanel_headings">No Category Yet</div>');   //  Adding The Title
    }
}
//////////////////////////////////////////////////
//          Category Segment [ END ]            //
//////////////////////////////////////////////////


//////////////////////////////////////////////////
//          Item Segment [ START ]              //
//////////////////////////////////////////////////
function loadItemList(OrderType) {
    load_ajax_loader_front("itemList", "40px", "48.5%");

    setTimeout(function(){
        $.post( "menu/ajaxItemList",
            { OrderType : OrderType },
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "not_logged_in" || categoryFormRespond.respond.error_msg == "no_action" ) {
                        window.location.href = "/";
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                        $("#itemList").html(categoryFormRespond.respond.content).promise().done(function() {
                            //$(".inline").colorbox({inline:true, initialWidth: "100%"});
                            //$.colorbox({inline:true, initialWidth: "100%", href:"#newDivValue"});

                            loadCart();
                        });
                    }
                }
            }
        );
    }, 100);
}
//////////////////////////////////////////////////
//          Item Segment [ END ]                //
//////////////////////////////////////////////////

//////////////////////////////////////////////////
//          Popup Segment [ START ]                //
//////////////////////////////////////////////////
function openItemPopUp( ItemId ) {
    setTimeout(function() {
        $.post( "item/ajaxItemPopUpFrMenu", {
                "BaseItemId": ItemId
            },
            function( data ) {
                var categoryFormRespond = JSON.parse(data);

                if( categoryFormRespond.respond.error_flag ) {
                    if( categoryFormRespond.respond.error_msg == "no_BaseItemId" ) {
                        alert("INVALID: No Id")
                    }
                    else if( categoryFormRespond.respond.error_msg == "invalid_BaseItemId" ) {
                        alert("INVALID: Invalid Id")
                    }
                }
                else if( categoryFormRespond.respond.error_flag == false ) {
                    if(typeof categoryFormRespond.respond.content != 'undefined' && categoryFormRespond.respond.content != "" ) {
                        $("#commonPopUpContainer").html(categoryFormRespond.respond.content).promise().done(function() {
                            $.colorbox({inline:true, initialWidth: "100%", href:"#commonPopUpContainer"})
                        });
                    }
                }
            }
        );
    },100);
    
}

function openStaticItemPopUp() {
    setTimeout(function() {
        $.colorbox({inline:true, initialWidth: "100%", href:"#staticItemDetailsLoadDiv_1"})
    },100);
}
//////////////////////////////////////////////////
//          Popup Segment [ END ]                //
//////////////////////////////////////////////////


//////////////////////////////////////////////////
//          Cart Segment [ START ]              //
//////////////////////////////////////////////////
function addToCartPopUp( ItemId ) {
    if( ItemId ) {
        var okFlag = true;

        //  For Selection
        $('.selection_dropdown').removeClass("errorBorder");
        $('.selection_dropdown').each(function(i,j){
            if( $(this).val() == "" ) {
                okFlag = false;
                $(this).addClass("errorBorder");
                $(this).focus();
                alert("Must select a selection");
                return false;
            }
        });

        //  For Quantity
        if( parseInt($("#PopUpQty").val()) == "NaN" || $("#PopUpQty").val() == "" || $("#PopUpQty").val() < 1 ) {
            okFlag = false;
            $("#PopUpQty").addClass("errorBorder");
            $("#PopUpQty").focus();
            alert("Please give valid Quantity");
            return false;
        }

        if( okFlag ) {
            $.post( "cart/ajaxAddToCartFrmPopUp", {
                    ItemId : ItemId,
                    FormData : $("#itemPopUpForm").serialize()
                },
                function( data ) {
                    var categoryFormRespond = JSON.parse(data);

                    if( categoryFormRespond.respond.error_flag ) {
                        if( categoryFormRespond.respond.error_msg == "no_ItemId" ) {
                            alert("InternalError: No ID");
                        }
                        if( categoryFormRespond.respond.error_msg == "no_Qty" ) {
                            alert("InternalError: No Quantity");
                        }
                        else if( categoryFormRespond.respond.error_msg == "invalid_ItemId" ) {
                            alert("InternalError: Invalid ID");
                        }
                        else if( categoryFormRespond.respond.error_msg == "invalid_qty" ) {
                            alert("InternalError: Invalid Quantity");
                        }
                    }
                    else if( categoryFormRespond.respond.error_flag == false ) {
                        colorBoxClose();
                        loadCart();
                    }
                });
        }


    }
    else {  alert("No Item Id.");  }
}

function addToCart( ItemId, Qty ) {
    $.post( "cart/ajaxAddToCart", {
            ItemId : ItemId,
            Qty : Qty
        },
        function( data ) {
            var categoryFormRespond = JSON.parse(data);

            if( categoryFormRespond.respond.error_flag ) {
                if( categoryFormRespond.respond.error_msg == "no_ItemId" ) {
                    alert("InternalError: No ID");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_ItemId" ) {
                    alert("InternalError: Invalid ID");
                }
                if( categoryFormRespond.respond.error_msg == "no_Qty" ) {
                    alert("InternalError: No QTY");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_qty" ) {
                    alert("InternalError: Invalid QTY");
                }
                else if( categoryFormRespond.respond.error_msg == "type_error" ) {
                    alert("InternalError: Type Error");
                }
            }
            else if( categoryFormRespond.respond.error_flag == false ) {
                loadCart();
            }
        }
    );
}

function loadCart() {
    load_ajax_loader_front("cartLoad", "40px", "48.5%");

    setTimeout(function(){
        $.post( "cart/ajaxLoadCart",
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
                    }
                }
            }
        );
    }, 100);
}

function cartItemIncrease( CatSortNo, SubCatSortNo, ItemSortNo, ItmIdentificationKey, IncreaseQty ) {
    load_ajax_loader_front("cartLoad", "40px", "48.5%");
    
    $.post( "cart/ajaxCartItemIncrease", {
            CatSortNo : CatSortNo, 
            SubCatSortNo : SubCatSortNo,
            ItemSortNo : ItemSortNo,
            ItmIdentificationKey : ItmIdentificationKey,
            IncreaseQty : IncreaseQty,
        },
        function( data ) {
            var categoryFormRespond = JSON.parse(data);

            if( categoryFormRespond.respond.error_flag ) {
                if( categoryFormRespond.respond.error_msg == "no_CatSortNo" ) {
                    alert("InternalError: No CatSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_CatSortNo" ) {
                    alert("InternalError: Invalid CatSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "no_SubCatSortNo" ) {
                    alert("InternalError: No SubCatSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_SubCatSortNo" ) {
                    alert("InternalError: Invalid SubCatSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "no_ItemSortNo" ) {
                    alert("InternalError: No ItemSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_ItemSortNo" ) {
                    alert("InternalError: Invalid ItemSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "no_ItmIdentificationKey" ) {
                    alert("InternalError: No ItmIdentificationKey");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_ItmIdentificationKey" ) {
                    alert("InternalError: Invalid ItmIdentificationKey");
                }
            }
            else if( categoryFormRespond.respond.error_flag == false ) {
                loadCart();
            }
        }
    );
}

function cartItemDecrease( CatSortNo, SubCatSortNo, ItemSortNo, ItmIdentificationKey, DecreaseQty ) {
    load_ajax_loader_front("cartLoad", "40px", "48.5%");
    
    $.post( "cart/ajaxCartItemDecrease", {
            CatSortNo : CatSortNo, 
            SubCatSortNo : SubCatSortNo,
            ItemSortNo : ItemSortNo,
            ItmIdentificationKey : ItmIdentificationKey,
            DecreaseQty : DecreaseQty
        },
        function( data ) {
            var categoryFormRespond = JSON.parse(data);

            if( categoryFormRespond.respond.error_flag ) {
                if( categoryFormRespond.respond.error_msg == "no_CatSortNo" ) {
                    alert("InternalError: No CatSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_CatSortNo" ) {
                    alert("InternalError: Invalid CatSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "no_SubCatSortNo" ) {
                    alert("InternalError: No SubCatSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_SubCatSortNo" ) {
                    alert("InternalError: Invalid SubCatSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "no_ItemSortNo" ) {
                    alert("InternalError: No ItemSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_ItemSortNo" ) {
                    alert("InternalError: Invalid ItemSortNo");
                }
                else if( categoryFormRespond.respond.error_msg == "no_ItmIdentificationKey" ) {
                    alert("InternalError: No ItmIdentificationKey");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_ItmIdentificationKey" ) {
                    alert("InternalError: Invalid ItmIdentificationKey");
                }
                else if( categoryFormRespond.respond.error_msg == "invalid_qty" ) {
                    alert("InternalError: Invalid QTY");
                }
            }
            else if( categoryFormRespond.respond.error_flag == false ) {
                loadCart();
            }
        }
    );
}
//////////////////////////////////////////////////
//          Cart Segment [ END ]                //
//////////////////////////////////////////////////