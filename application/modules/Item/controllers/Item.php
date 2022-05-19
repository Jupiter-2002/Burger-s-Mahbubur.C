<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends MY_Controller {
	public function __construct() {
		parent::__construct();

        $this->load->model('Customer_model');
        $this->load->model('Front_model');
		$this->load->model('Utility_model');
        $this->load->model('Item_Utility_model');   //  For Item Based Functions
        
        $this->load->model('Cart_Utility_model');   //  For Cart Based Functions
	}

    public function ajaxItemPopUpFrMenu() {
        $returnRespond = array();

        if( isset($_POST['BaseItemId']) && $_POST['BaseItemId'] != "" ) {
            $arrItemDetails = $this->Item_Utility_model->returnItemDetailsBasedOnItemId( $_POST['BaseItemId'] );

            if( $arrItemDetails != false ) {

                //  Base Item Details
                $returnRespond['arrBaseItemDetails'] = $this->Utility_model->returnRecord("Menu_Base", false, array("PK_BaseId"=>$_POST['BaseItemId']));

                //  Settings Items
                $returnRespond['currency'] = get_global_values('OtherSettings', 'Currency');

                //  Return the Selection by category but if the Selection is already added to the item returns that topping details [ START ]
                $arrSelectionByCategoryCond['Menu_Joint_Selections_To_Element.FK_ItemId'] = $_POST['BaseItemId'];
                $tmpArrSelecList = $this->Item_Utility_model->returnAllAddedSelectionByCategoryArr($arrSelectionByCategoryCond);

                if( $tmpArrSelecList != false ) {
                    $tmpSelecObjIdx = 0;
                    foreach ( $tmpArrSelecList as $tmpObjSelec ) {
                        if( isset($returnRespond['arrSelecList'][$tmpObjSelec->PK_SelecCatId]['SelecCatDetails']) ) {
                        }
                        else {
                            $tmpSelecObjIdx = 0;

                            $returnRespond['arrSelecList'][$tmpObjSelec->PK_SelecCatId]['SelecCatDetails']['SelecCatId'] = $tmpObjSelec->PK_SelecCatId;
                            $returnRespond['arrSelecList'][$tmpObjSelec->PK_SelecCatId]['SelecCatDetails']['SelecCatName'] = $tmpObjSelec->SelecCatName;
                            $returnRespond['arrSelecList'][$tmpObjSelec->PK_SelecCatId]['SelecCatDetails']['SelecCatSortNo'] = $tmpObjSelec->SelecCatSortNo;
                        }

                        $returnRespond['arrSelecList'][$tmpObjSelec->PK_SelecCatId]['SelectionDetails'][$tmpSelecObjIdx]['SelecId'] = $tmpObjSelec->PK_SelecId;
                        $returnRespond['arrSelecList'][$tmpObjSelec->PK_SelecCatId]['SelectionDetails'][$tmpSelecObjIdx]['PK_J_SelecToElementID'] = $tmpObjSelec->PK_J_SelecToElementID;
                        $returnRespond['arrSelecList'][$tmpObjSelec->PK_SelecCatId]['SelectionDetails'][$tmpSelecObjIdx]['SelecName'] = $tmpObjSelec->SelecName;
                        $returnRespond['arrSelecList'][$tmpObjSelec->PK_SelecCatId]['SelectionDetails'][$tmpSelecObjIdx]['J_SelecPrice'] = $tmpObjSelec->J_SelecPrice;

                        $tmpSelecObjIdx++;
                    }
                    //printArr($returnRespond['arrSelecList']);
                }
                //  Return the Selection by category but if the Selection is already added to the item returns that topping details [ END ]

                //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ START ]
                $arrToppingByCategoryCond['Menu_Joint_Toppings_To_Element.FK_ItemId'] = $_POST['BaseItemId'];
                $tmpArrToppList = $this->Item_Utility_model->returnAllAddedToppingByCategoryArr($arrToppingByCategoryCond);

                if( $tmpArrToppList != false ) {
                    $tmpToppObjIdx = 0;
                    foreach ( $tmpArrToppList as $tmpObjTopp ) {
                        if( isset($returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppCatDetails']) ) {
                        }
                        else {
                            $tmpToppObjIdx = 0;

                            $returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppCatDetails']['ToppCatId'] = $tmpObjTopp->PK_ToppCatId;
                            $returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppCatDetails']['ToppCatName'] = $tmpObjTopp->ToppCatName;
                            $returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppCatDetails']['ToppCatSortNo'] = $tmpObjTopp->ToppCatSortNo;
                        }

                        $returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppDetails'][$tmpToppObjIdx]['ToppId'] = $tmpObjTopp->PK_ToppId;
                        $returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppDetails'][$tmpToppObjIdx]['PK_J_ToppintToElementID'] = $tmpObjTopp->PK_J_ToppintToElementID;
                        $returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppDetails'][$tmpToppObjIdx]['ToppName'] = $tmpObjTopp->ToppName;
                        $returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppDetails'][$tmpToppObjIdx]['J_ToppPrice'] = $tmpObjTopp->J_ToppPrice;
                        $returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppDetails'][$tmpToppObjIdx]['J_ToppFreeFlag'] = $tmpObjTopp->J_ToppFreeFlag;
                        $returnRespond['arrToppList'][$tmpObjTopp->PK_ToppCatId]['ToppDetails'][$tmpToppObjIdx]['J_ToppDefaultFlag'] = $tmpObjTopp->J_ToppDefaultFlag;

                        $tmpToppObjIdx++;
                    }
                }
                //  Return the toppings by category but if the toppings is already added to the item returns that topping details [ END ]

                //printArr($returnRespond);
                //die();

                echo json_encode(array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('item/itemPopUpFrMenu', $returnRespond, true))));

                die();
            }
            else {
                $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"invalid_BaseItemId"));
            }



        } else {
            $returnRespond = array("respond"=>array("error_flag"=>true, "error_msg"=>"no_BaseItemId"));
        }

        echo json_encode($returnRespond);








    }
}
?>