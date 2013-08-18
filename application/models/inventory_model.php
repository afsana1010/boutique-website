<?php

/**
 * Contains the core logic to generate and process product-inventory data 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Inventory_model extends CI_Model
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
     * Gets page-wise product-inventory 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
        $sort                      = "product_name ASC";
        $sql                       = "SELECT * FROM boutique_product_stocks ORDER BY ".$sort ;		
        $sql_paging                = "SELECT * FROM boutique_product_stocks ORDER BY $sort LIMIT $start,$end";
        $data['inventory_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 	       	   = $this->db->query($sql);
        $data['inventory_rows']    = $query1->num_rows();

        return $data;
    }


    /**
     * Gets the number of a total sold product 
     * 
     * @param integer
     * @return object 
     */
    public function get_total_sold_products($product_id)
    {
        
        $sql    = "SELECT buo.product_id,IFNULL(SUM(buo.order_quantity),0) AS sold_quantity, bp.product_name
                FROM boutique_products AS bp,boutique_user_orders AS buo
                WHERE buo.product_id= bp.id AND buo.product_id =  $product_id
                GROUP BY buo.product_id 
                ORDER BY buo.product_id ASC";

        $query =  $this->db->query($sql);
        if($query->num_rows()>0)
        {
            foreach($query->result() as $sd):
                $row = $sd->sold_quantity;
            endforeach;
        }        
        else
        {
            $row = 0;
        }
        return $row;                          
    }
    
}

/* End of file inventory_model.php */
/* Location: ./application/models/inventory_model.php */