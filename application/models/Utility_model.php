<?php
class Utility_model extends CI_Model {
	public function __construct() {
		parent::__construct();

		// Your own constructor code
        $this->load->model('Utility_model');
	}

	public function insertRecort( $tableName, $data ) {
		if( $this->db->insert($tableName, $data) ) {
			if ($this->db->trans_status() === FALSE) {
				return 0;
			} else {
				return $this->db->insert_id();
			}
		} else {
			return 0;
		}
	}

	public function updateRecord( $tableName, $arrData, $arrCondition ) {
		return $str = $this->db->update($tableName, $arrData, $arrCondition);
	}

	public function updateRecordReturnAffectedRowCount( $tableName, $arrData, $arrCondition ) {
		$this->db->update($tableName, $arrData, $arrCondition);
		return $this->db->affected_rows();
	}

    public function deleteRecord( $tableName, $arrCondition = false) {
        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}

        $noOfAffectedRows = $this->db->delete($tableName);
    }

    /*
     * Sample Call Format
     * $this->Utility_model->returnRecord("admin_user","AdminUserId, Name, Email, Password", array("AdminUserId"=>1));
     */
    public function returnRecordCount( $tableName, $strSelect = false, $arrCondition = false, $strOrderBy = false ) {
        if( $strSelect != false )
        {	$this->db->select($strSelect);		}
        if( $arrCondition != false )
        {	$this->db->where($arrCondition);	}
        if( $strOrderBy != false )
        {	$this->db->order_by($strOrderBy);		}
        $query = $this->db->get($tableName);

        //echo "".$this->db->last_query();

        if( $query->num_rows() > 0 )
        {	return $query->num_rows();	}
        else
        {	return 0;	}
    }

	/*
	 * Sample Call Format
	 * $this->Utility_model->returnRecord("admin_user","AdminUserId, Name, Email, Password", array("AdminUserId"=>1));
	 */
	public function returnRecord( $tableName, $strSelect = false, $arrCondition = false, $strOrderBy = false ) {
		if( $strSelect != false )
		{	$this->db->select($strSelect);		}
		if( $arrCondition != false )
		{	$this->db->where($arrCondition);	}
		if( $strOrderBy != false )
		{	$this->db->order_by($strOrderBy);		}
		$query = $this->db->get($tableName);

		//echo "".$this->db->last_query();

		if( $query->num_rows() > 0 )
		{	return $query->result();	}
		else
		{	return FALSE;	}
	}

	/*
	 * Sample Call Format
	 */
	public function returnWhereInRecord( $tableName, $strSelect = false, $arrCondition = false, $arrWhereInCondition = false, $strOrderBy = false ) {
		if( $strSelect != false )
		{	$this->db->select($strSelect);		}
		if( $arrCondition != false )
		{	$this->db->where($arrCondition);	}
		if( $arrWhereInCondition != false ) {
			foreach( $arrWhereInCondition as $keyWhereInCondition => $objWhereInCondition ) {
				$this->db->where_in($keyWhereInCondition, $objWhereInCondition);
			}
		}
        if( $strOrderBy != false )
        {	$this->db->order_by($strOrderBy);		}
		$query = $this->db->get($tableName);

		if( $query->num_rows() > 0 )
		{	return $query->result();	}
		else
		{	return FALSE;	}
	}

	/*
	 * Sample Call Format
	 * $this->Utility_model->returnRecord("admin_user","AdminUserId, Name, Email, Password", array("AdminUserId"=>1));
	 */
	public function returnLikeRecord( $tableName, $strSelect = false, $arrCondition = false, $strOrderBy = false ) {
		if( $strSelect != false )
		{	$this->db->select($strSelect);		}
		if( $arrCondition != false )
		{	$this->db->like($arrCondition);	}
		if( $strOrderBy != false )
		{	$this->db->order_by($strOrderBy);		}
		$query = $this->db->get($tableName);

		//echo "".$this->db->last_query();

		if( $query->num_rows() > 0 )
		{	return $query->result();	}
		else
		{	return FALSE;	}
	}

	/*
	 *	Get Bar Id and Name for bars that dont have Admin User Assigned
	 */
	public function getLatLangFromAddress( $address, $googleApiKey ) {
		$wholeRequestString = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=".$googleApiKey;
		$routes = json_decode(file_get_contents($wholeRequestString));

		if( count($routes->results) > 0 && $routes->status == "OK" ) {
			$arrReturn = array();

			//echo "location->lat, ".$routes->results[0]->geometry->location->lat." location->lng, ".$routes->results[0]->geometry->location->lng."<br>";
			$LAT = $routes->results[0]->geometry->location->lat;
			$LANG = $routes->results[0]->geometry->location->lng;
			if( $LAT != "" && $LANG != "" ) {
				$arrReturn[0]['LAT'] = $LAT;
				$arrReturn[0]['LANG'] = $LANG;
				return $arrReturn;
			} else {
				return array();
			}
		} else {
			return array();
		}
	}

    /*
     *	Rendom String Genarator
     */
    function generateRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /*
     *	Get Delivery Details by full post code or partial post code
     */
    public function getDeliveryDetails( $arrAddressDetails ) {
        $deliveryFee = 0;

        $CI =& get_instance();
        $CI->db->from('delivery_area');
        $CI->db->where('DeliveryAreaStatus', 1);

        //  Full Post Code
        if( isset($arrAddressDetails['postcode']) && $arrAddressDetails['postcode'] != "" ) {
            $CI->db->like('PostCodeList', $arrAddressDetails['postcode'].',');
        }

        //  Partial Post Code
        if( isset($arrAddressDetails['postcode']) && $arrAddressDetails['postcode'] != "" ) {
            $CI->db->or_like('HalfPostCode', substr($arrAddressDetails['postcode'],0,4).',');
        }

        $this->db->order_by('DeliveryCharge DESC');
        $this->db->limit(1);

        $query = $CI->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result()[0];
        } else {
            return false;
        }
    }
}
?>
