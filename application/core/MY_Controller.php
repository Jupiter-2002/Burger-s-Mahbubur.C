<?php
class MY_Controller extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		if( !isset($_SESSION['RestaurantBasic']) ) {
            $this->db->select('RestName, RestUniqueKey, RestWebUrl, RestEMail, RestLogo');
            $this->db->from('restaurant_info');
            $this->db->where('RestId', 1971);

            $query = $this->db->get();
            //echo $this->db->last_query();

            $_SESSION['RestaurantBasic'] = $query->row();
        }

        if( !isset($_SESSION['SiteSettings']) ) {
            $this->db->from('SiteSettings');

            $query = $this->db->get();
            //echo $this->db->last_query();

            $_SESSION['SiteSettings'] = $query->row();
        }


        //printArr($_SESSION);
	}
}
?>
