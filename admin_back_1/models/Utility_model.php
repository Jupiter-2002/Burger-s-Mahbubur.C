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
     *	Submit Values by curl with PUT HTTP method
     */
    function curlPutUtilityFunction( $curlHeader, $curlPostStr, $url ) {
        $curlRequest = curl_init(); // initiate curl object
        curl_setopt($curlRequest, CURLOPT_URL, $url);
        curl_setopt($curlRequest, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curlRequest, CURLOPT_HEADER, 0);                           // set to 0 to eliminate header info from response
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, 1);                   // Returns response data instead of TRUE(1)
        curl_setopt($curlRequest, CURLOPT_HTTPHEADER, $curlHeader);             // use HEADER
        curl_setopt($curlRequest, CURLOPT_POSTFIELDS, $curlPostStr);            // use HTTP POST to send form data
        curl_setopt($curlRequest, CURLOPT_SSL_VERIFYPEER, FALSE);               // uncomment this line if you get no gateway response.
        $curlResponse = curl_exec($curlRequest);                                // execute CURL

        //  If ERROR on CURL
        $returnArr = array();
        if ( curl_error($curlRequest) ) {
            $returnArr['flag'] = FALSE;
            $returnArr['returnArr']['curl_error'] = curl_error($curlRequest);
            $returnArr['returnArr']['curl_errno'] = curl_errno($curlRequest);
        } else {
            $returnArr['flag'] = TRUE;
            $returnArr['returnArr'] = json_decode($curlResponse);
        }
        curl_close($curlRequest);

        return $returnArr;
    }

    /*
     *	Submit Values by curl with GET HTTP method
     */
    function curlGetUtilityFunction( $url ) {
        $curlRequest = curl_init(); // initiate curl object
        curl_setopt($curlRequest, CURLOPT_URL, $url);
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, 1);                   // Returns response data instead of TRUE(1)
        curl_setopt($curlRequest, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($curlRequest, CURLOPT_FOLLOWLOCATION, true);

        /*
        curl_setopt($curlRequest, CURLOPT_HEADER, 0);                           // set to 0 to eliminate header info from response
        curl_setopt($curlRequest, CURLOPT_HTTPHEADER, $curlHeader);             // use HEADER
        curl_setopt($curlRequest, CURLOPT_SSL_VERIFYPEER, FALSE);               // uncomment this line if you get no gateway response.
        */

        $curlResponse = curl_exec($curlRequest);                                // execute CURL

        //  If ERROR on CURL
        $returnArr = array();
        if ( curl_error($curlRequest) ) {
            $returnArr['flag'] = FALSE;
            $returnArr['returnArr']['curl_error'] = curl_error($curlRequest);
            $returnArr['returnArr']['curl_errno'] = curl_errno($curlRequest);
        } else {
            $returnArr['flag'] = TRUE;
            $returnArr['returnArr'] = json_decode($curlResponse);
        }
        curl_close($curlRequest);

        return $returnArr;
    }

    /*
     *	Submit Values by curl with POST HTTP method
     */
    function curlPostUtilityFunction( $curlHeader, $curlPostStr, $url ) {
        $curlRequest = curl_init(); // initiate curl object
        curl_setopt($curlRequest, CURLOPT_URL, $url);
        curl_setopt($curlRequest, CURLOPT_POST, 1);                             // for sending data in POST
        curl_setopt($curlRequest, CURLOPT_HEADER, 0);                           // set to 0 to eliminate header info from response
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, 1);                   // Returns response data instead of TRUE(1)
        curl_setopt($curlRequest, CURLOPT_HTTPHEADER, $curlHeader);             // use HEADER
        curl_setopt($curlRequest, CURLOPT_POSTFIELDS, $curlPostStr);            // use HTTP POST to send form data
        curl_setopt($curlRequest, CURLOPT_SSL_VERIFYPEER, FALSE);               // uncomment this line if you get no gateway response.
        $curlResponse = curl_exec($curlRequest);                                // execute CURL

        //  If ERROR on CURL
        $returnArr = array();
        if ( curl_error($curlRequest) ) {
            $returnArr['flag'] = false;
            $returnArr['returnArr']['curl_error'] = curl_error($curlRequest);
            $returnArr['returnArr']['curl_errno'] = curl_errno($curlRequest);
        } else {
            $returnArr['flag'] = true;
            $returnArr['returnArr'] = json_decode($curlResponse);
        }
        curl_close($curlRequest);

        return $returnArr;
    }

    /*
     *	Submit Values by curl with DELETE HTTP method
     */
    function curlDeleteUtilityFunction( $curlHeader, $url ) {
        $curlRequest = curl_init(); // initiate curl object
        curl_setopt($curlRequest, CURLOPT_URL, $url);
        curl_setopt($curlRequest, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curlRequest, CURLOPT_HEADER, 0);                           // set to 0 to eliminate header info from response
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, 1);                   // Returns response data instead of TRUE(1)
        curl_setopt($curlRequest, CURLOPT_HTTPHEADER, $curlHeader);             // use HEADER
        curl_setopt($curlRequest, CURLOPT_SSL_VERIFYPEER, FALSE);               // uncomment this line if you get no gateway response.
        $curlResponse = curl_exec($curlRequest);                                // execute CURL

        //  If ERROR on CURL
        $returnArr = array();
        if ( curl_error($curlRequest) ) {
            $returnArr['flag'] = FALSE;
            $returnArr['returnArr']['curl_error'] = curl_error($curlRequest);
            $returnArr['returnArr']['curl_errno'] = curl_errno($curlRequest);
        } else {
            $returnArr['flag'] = TRUE;
            $returnArr['returnArr'] = json_decode($curlResponse);
        }
        curl_close($curlRequest);

        return $returnArr;
    }

}
?>
