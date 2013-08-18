<?php

/**
 * Contains the core logic to generate and process product-Shipment data 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 * Creation Date   : October 5, 2012 
 */
class Shipment_model extends CI_Model
{

    /**
     * Model constructor 
     * 
     */
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Gets page-wise product-Shipment 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
        $sort                  = "id ASC";
        $sql                   = "SELECT * FROM boutique_shipment_levels ORDER BY ".$sort ;		
        $sql_paging 	       = "SELECT * FROM boutique_shipment_levels ORDER BY $sort LIMIT $start,$end";
        $data['shipment_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 	       	   = $this->db->query($sql);
        $data['shipment_rows']    = $query1->num_rows();

        return $data;
    }
    

	/**
     * Gets page-wise User Shipment Status
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_all_status_against_one_bill_no($bill_no)
    {

        $sql = "SELECT buo.*,bsl.level_status_message AS level_status_message,bp.product_name AS product_name
                FROM boutique_user_orders AS buo, boutique_shipment_levels AS bsl,boutique_products AS bp
                WHERE buo.bill_no=$bill_no
                AND buo.shipment_level_id = bsl.id
                AND bp.id=buo.product_id
                ORDER BY buo.id";
        
        return $this->db->query($sql)->result();
    }    
}

/* End of file shipment_model.php */
/* Location: ./application/models/shipment_model.php */