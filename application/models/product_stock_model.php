<?php

/**
 * Contains the core logic to generate and process product-stock data 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 * Creation Date   : October 5, 2012 
 */
class Product_stock_model extends CI_Model
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
     * Gets page-wise product-stock 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
        $sort                  = "product_name ASC";
        $sql                   = "SELECT * FROM boutique_product_stocks ORDER BY ".$sort ;		
        $sql_paging 	       = "SELECT * FROM boutique_product_stocks ORDER BY $sort LIMIT $start,$end";
        $data['stock_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 	       = $this->db->query($sql);
        $data['stock_rows']    = $query1->num_rows();

        return $data;
    }
    
}

/* End of file product_stock_model.php */
/* Location: ./application/models/product_stock_model.php */