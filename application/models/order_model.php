<?php

/**
 * Contains the core logic to generate and process product-order data 
 * 
 * @author
 */
class Order_model extends CI_Model
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
     * Gets page-wise product-order 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
        $sort  = "buo.id ASC";
        $sql   = "SELECT buo.id,buo.user_id,buo.product_id,buo.shipment_level_id,
                         buo.order_quantity AS order_quantity,buo.bill_no AS bill_no,buo.order_date AS order_date,
                         buo.is_open AS is_open,buo.created_at,buo.modified_at,
                         bsl.level_status_message AS level_status_message,
                         bp.product_name AS product_name,
                         bp.unit_price,
                         bu.full_name AS member_name,
                         buo.order_quantity AS amount
                         FROM boutique_user_orders AS buo,boutique_shipment_levels AS bsl,boutique_products AS bp,boutique_users AS bu
                         WHERE buo.shipment_level_id = bsl.id
                         AND buo.product_id = bp.id
                         AND bu.id=buo.user_id
                         ORDER BY ".$sort;		
        $sql_paging = "SELECT buo.id,buo.user_id,buo.product_id,buo.shipment_level_id,
                              buo.order_quantity AS order_quantity,buo.bill_no AS bill_no,buo.order_date AS order_date,
                              buo.is_open AS is_open,buo.created_at,buo.modified_at,
                              bsl.level_status_message AS level_status_message,
                              bp.product_name AS product_name,
                              bp.unit_price,
                              bu.full_name AS member_name,
                              buo.order_quantity AS amount
                              FROM boutique_user_orders AS buo,boutique_shipment_levels AS bsl,
                              boutique_products AS bp,boutique_users AS bu
                              WHERE buo.shipment_level_id = bsl.id
                              AND buo.product_id = bp.id
                              AND bu.id=buo.user_id
                              ORDER BY $sort LIMIT $start,$end";
        
        $data['order_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 	       = $this->db->query($sql);
        $data['order_rows']    = $query1->num_rows();

        return $data;
    }
}

/* End of file order_model.php */
/* Location: ./application/models/order_model.php */