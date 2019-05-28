<?php

class Meter_reading_input_model extends CORE_Model {
    protected  $table="meter_reading_input";
    protected  $pk_id="meter_reading_input_id";

    function __construct() {
        parent::__construct();
    }

	function meter_reading($period_id=null){
        $query = $this->db->query("SELECT 
			    mri.*,
			    mrp.*,
			    DATE_FORMAT(mri.date_input, '%m/%d/%Y') AS date_input,
			    m.month_name,
			    CONCAT_WS(' ', user.user_fname, user.user_lname) AS posted_by
			FROM
			    meter_reading_input mri
			        LEFT JOIN
			    meter_reading_period mrp ON mrp.meter_reading_period_id = mri.meter_reading_period_id
			        LEFT JOIN
			    months m ON m.month_id = mrp.month_id
			        LEFT JOIN
			    user_accounts user ON user.user_id = mri.posted_by_user
			WHERE
			    mri.is_deleted = FALSE
			        ".($period_id==null?" AND mri.meter_reading_period_id=0":" AND mri.meter_reading_period_id=".$period_id)."");
					return $query->result();
    }    
}
?>