<?php
class Order_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

    public function returnOrderList( $strSelect = false, $arrCondition = false, $strOrderBy = false ) {
        if( $strSelect != false )
        {	$this->db->select($strSelect);		}
        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        if( $strOrderBy != false )
        {	$this->db->order_by($strOrderBy);		}
        else
        {   $this->db->order_by("OrderSummaryId");		}

        $query = $this->db->get("order_summary");

        //echo "".$this->db->last_query();

        if( $query->num_rows() > 0 )
        {	return $query->result();	}
        else
        {	return FALSE;	}
    }

    public function returnOrderListWithCustomer( $strSelect = false, $arrCondition = false, $strOrderBy = false ) {
        if( $strSelect != false )
        {	$this->db->select($strSelect);		}

        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        if( $strOrderBy != false )
        {	$this->db->order_by($strOrderBy);		}
        else
        {   $this->db->order_by("OrderSummaryId");		}

        $this->db->from("customer");
        $this->db->from("order_summary");

        $this->db->where("order_summary.FK_CustId = customer.PK_CustId");

        $query = $this->db->get();

        //echo "".$this->db->last_query();

        if( $query->num_rows() > 0 )
        {	return $query->result();	}
        else
        {	return FALSE;	}
    }

    public function returnCollectionTimeSlot( $strSelect = false, $arrConditionTime = false, $arrCondition = false, $strOrderBy = false ) {
        if( $strSelect != false )
        {	$this->db->select($strSelect);		}


        if( $arrConditionTime != false ) {
            $this->db->where("( ('".$arrConditionTime."' BETWEEN `StartTime` AND `EndTime`)");
            $this->db->or_where("('".$arrConditionTime."' < `StartTime`) )");
        }


        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $this->db->order_by("StartTime");

        $query = $this->db->get("timeschedule_collection");

        //echo "".$this->db->last_query();

        if( $query->num_rows() > 0 )
        {	return $query->result();	}
        else
        {	return FALSE;	}
    }

    public function returnDeliveryTimeSlot( $strSelect = false, $arrConditionTime = false, $arrCondition = false, $strOrderBy = false ) {
        if( $strSelect != false )
        {	$this->db->select($strSelect);		}


        if( $arrConditionTime != false ) {
            $this->db->where("( ('".$arrConditionTime."' BETWEEN `StartTime` AND `EndTime`)");
            $this->db->or_where("('".$arrConditionTime."' < `StartTime`) )");
        }


        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $this->db->order_by("StartTime");

        $query = $this->db->get("timeschedule_delivery");

        //echo "".$this->db->last_query();

        if( $query->num_rows() > 0 )
        {	return $query->result();	}
        else
        {	return FALSE;	}
    }

    public function returnOrderDetailsById( $orderId = false ) {
        $this->db->where(array(
            'OrderSummaryId' => $orderId
        ));
        $query = $this->db->get("order_summary");


        if( $query->num_rows() > 0 ) {
            $arrReturn['order_summary'] = $query->row();

            //  Order Item Details [ START ]
            $this->db->where(array(
                'FK_OrderSummaryId' => $orderId
            ));
            $query = $this->db->get("order_detail");

            if( $query->num_rows() > 0 ) {
                $arrReturn['order_detail'] = $query->result();
            }
            //  Order Item Details [ END ]

            //printArr($arrReturn);

            return $arrReturn;
        }
        else
        {	return FALSE;	}
    }

    public function returnOrderDetailsByIdWithCustomer( $orderId = false ) {
        $this->db->where(array(
            'OrderSummaryId' => $orderId
        ));
        $query = $this->db->get("order_summary");


        if( $query->num_rows() > 0 ) {
            $arrReturn['order_summary'] = $query->row();

            //  Customer Details [ START ]
            $this->db->where(array(
                'PK_CustId' => $arrReturn['order_summary']->FK_CustId
            ));
            $query = $this->db->get("customer");

            if( $query->num_rows() > 0 ) {
                $arrReturn['customer_detail'] = $query->row();
            }
            //  Customer Details [ END ]

            //  Order Item Details [ START ]
            $this->db->where(array(
                'FK_OrderSummaryId' => $orderId
            ));
            $query = $this->db->get("order_detail");

            if( $query->num_rows() > 0 ) {
                $arrReturn['order_detail'] = $query->result();
            }
            //  Order Item Details [ END ]

            //printArr($arrReturn);

            return $arrReturn;
        }
        else
        {	return FALSE;	}
    }
}
?>
