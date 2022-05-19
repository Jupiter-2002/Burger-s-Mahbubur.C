<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {
	public function __construct() {
		parent::__construct();

        $this->load->model('Customer_model');
        $this->load->model('Front_model');
		$this->load->model('Utility_model');
        $this->load->model('Item_Utility_model');   //  For Spacial Item Based Functions
	}

	public function index()	{
	    $dataFrView = array();

        //////////////////////////////////////////////////////
        //      Setting Up View and Child View [ Start ]    //
        //      Template Related Segment [ Start ]
        $dataFrView['dataHead'] = $this->Front_model->getDataHead("|| MENU");
        $dataFrView['dataHeader'] = $this->Front_model->getDataHeader();
        $dataFrView['dataNavigation'] = $this->Front_model->getDataNavigation();
        $dataFrView['dataFooter'] = $this->Front_model->getDataFooter();
        //      Template Related Segment [ End ]

        //      Main Content Related Segment [ Start ]
        $dataFrView['dataCurrentView'] = array();
        $dataFrView['currentView'] = "index";

        $dataFrView['restauranOrderType'] = restauranOrderType();
        //      Main Content Related Segment [ End ]
        //      Setting Up View and Child View [ End ]      //
        //////////////////////////////////////////////////////

        //printArr($_SESSION);
        
        $this->load->view('front/base_theme_frame',$dataFrView);
	}

    //////////////////////////////////////////
    //      Category Actions [ START ]      //
    public function ajaxCategoryList() {
	    $arrValidCategoryForMenuCond = array();

        $OrderType = NULL;
	    if( isset($_POST['OrderType']) && $_POST['OrderType'] != "" ) {
            $OrderType = $_POST['OrderType'];
        }
        
        $data['categoryList'] = $this->Item_Utility_model->returnValidCategoryForMenu($arrValidCategoryForMenuCond, $OrderType);

        $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$data));
        echo json_encode($returnRespond);
    }
    //      Category Actions [ END ]      //
    //////////////////////////////////////////

    //////////////////////////////////////////
    //        Item Actions [ START ]        //
    public function ajaxItemList() {
        $returnRespond = array();
        $arrValidCategoryForMenuCond = array();

        $OrderType = NULL;
        if( isset($_POST['OrderType']) && $_POST['OrderType'] != "" ) {
            $OrderType = $_POST['OrderType'];
        }
        $categoryList = $this->Item_Utility_model->returnValidCategoryForMenu($arrValidCategoryForMenuCond, $OrderType);

        $arrCategoryContent = array();
        foreach ( $categoryList as $objCategory ) {
            //  Category Segment
            $arrCategoryContent['category'][$objCategory->PK_CatId]['CatName'] = $objCategory->CatName;
            $arrCategoryContent['category'][$objCategory->PK_CatId]['CatOrderType'] = $objCategory->CatOrderType;
            $arrCategoryContent['category'][$objCategory->PK_CatId]['CatSortNo'] = $objCategory->CatSortNo;
            $arrCategoryContent['category'][$objCategory->PK_CatId]['CatDesc'] = $objCategory->CatDesc;

            if( $objCategory->PK_SubCatId != null ) {
                $arrCategoryContent['sub_category'][$objCategory->PK_SubCatId]['SubCatName'] = $objCategory->SubCatName;
                $arrCategoryContent['sub_category'][$objCategory->PK_SubCatId]['SubCatOrderType'] = $objCategory->SubCatOrderType;
                $arrCategoryContent['sub_category'][$objCategory->PK_SubCatId]['SubCatSortNo'] = $objCategory->SubCatSortNo;
                $arrCategoryContent['sub_category'][$objCategory->PK_SubCatId]['SubCatDesc'] = $objCategory->SubCatDesc;
            }
        }

        //  Getting the RAW data
        $arrRawItemList = $this->Item_Utility_model->returnItmListByCategoryOrSubCategory(false, $OrderType, array_keys($arrCategoryContent['category']), array_keys($arrCategoryContent['sub_category']));
        
        //  Getting the Formated data
        $returnRespond['arrFormatedItemList'] = $this->Item_Utility_model->returnFormatedItemListWithCategoryAndSubCategory($arrRawItemList);


        //printArr($returnRespond['arrFormatedItemList']);

        //  Settings Items
        $returnRespond['currency'] = get_global_values('OtherSettings', 'Currency');
        
        $returnRespond = array("respond"=>array("error_flag"=>false, "content"=>$this->load->view('menu/item_list', $returnRespond, true)));
        echo json_encode($returnRespond);
    }
    //        Item Actions [ END ]          //
    //////////////////////////////////////////

    
}
