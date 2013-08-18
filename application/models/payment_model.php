<?php

/**
 * Contains the core logic to generate and process product-payment data 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 * Creation Date   : October 5, 2012 
 */
class Payment_model extends CI_Model
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
     * Gets page-wise product-payment 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
        $sort                    = "product_name ASC";
        $sql                     = "SELECT * FROM boutique_product_stocks ORDER BY ".$sort ;		
        $sql_paging 	         = "SELECT * FROM boutique_product_stocks ORDER BY $sort LIMIT $start,$end";
        $data['payment_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 	       	     = $this->db->query($sql);
        $data['payment_rows']    = $query1->num_rows();

        return $data;
    }
	
     /**
     * Gets page-wise product-payment 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise_receipt_in_daterange($from_date, $to_date, $start, $end)
    {
        $sort                    = "product_name ASC";
        $sql                     = "SELECT * FROM boutique_product_stocks WHERE created_at BETWEEN '$from_date' AND '$to_date' ORDER BY ".$sort ;		
        $sql_paging 	       	 = "SELECT * FROM boutique_product_stocks WHERE created_at BETWEEN '$from_date' AND '$to_date' ORDER BY $sort LIMIT $start,$end";
        $data['payment_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 	       	     = $this->db->query($sql);
        $data['payment_rows']    = $query1->num_rows();

        return $data;
    }   
	/**
     * Gets page-wise other payment 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise_other_payment($start, $end)
    {
        $sort                  = "id ASC";
        $sql                   = "SELECT * FROM boutique_other_payments ORDER BY ".$sort ;		
        $sql_paging 	       = "SELECT * FROM boutique_other_payments ORDER BY $sort LIMIT $start,$end";
        $data['payment_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 	       	   = $this->db->query($sql);
        $data['payment_rows']    = $query1->num_rows();

        return $data;
    }

    /**
     * Gets page-wise general payment 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise_general_payment($start, $end)
    {

        $sort                  = "bgp.product_stock_id ASC";
        $sql                   = "SELECT bgp.product_stock_id,bgp.amount,bgp.mode_of_payment,bgp.payment_cheque_id,bgp.paypal_transaction_id,bgp.created_at,bgp.modified_at,
                                    bps.id,bps.product_name,bps.quantity,bps.amount,bps.brought_from,bps.bill_no,bps.created_at,bps.modified_at
                                    FROM boutique_product_stocks AS bps, boutique_general_payments AS bgp
                                    WHERE bgp.product_stock_id = bps.id ORDER BY ".$sort ;      
        $sql_paging            = "SELECT bgp.product_stock_id,bgp.amount,bgp.mode_of_payment,bgp.payment_cheque_id,bgp.paypal_transaction_id,bgp.created_at,bgp.modified_at,
                                    bps.id,bps.product_name,bps.quantity,bps.amount,bps.brought_from,bps.bill_no,bps.created_at,bps.modified_at
                                    FROM boutique_product_stocks AS bps, boutique_general_payments AS bgp
                                    WHERE bgp.product_stock_id = bps.id ORDER BY $sort LIMIT $start,$end";
        $data['payment_afterPg'] = $this->db->query($sql_paging)->result();
        $query1                = $this->db->query($sql);
        $data['payment_rows']    = $query1->num_rows();
        
        return $data;
    }
}

/* End of file Payment_model.php */
/* Location: ./application/models/Payment_model.php */
