<?php

/**
 * Member Class 
 * 
 * @package Derplist 
 * @subpackage front-end, back-end 
 * @category model 
 * @author Afsana Rahman Snigdha 
 * Creation Date   : September 24, 2012 
 */
class Product_model extends CI_Model
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
        $sort                    = "product_no ASC";
        $sql                     = "SELECT * FROM boutique_products ORDER BY ".$sort ;		
        $sql_paging              = "SELECT * FROM boutique_products ORDER BY $sort LIMIT $start,$end";
        $data['product_afterPg'] = $this->db->query($sql_paging)->result();
        $query1                  = $this->db->query($sql);
        $data['product_rows']    = $query1->num_rows();

        return $data;
    }
    
    
    /**
     * Gets product-wise images 
     * 
     * @param integer $product_id
     * @param string $image_file
     * 
     * @return bool 
     */
    public function check_product_image($product_id,$image_file)
    {
        $this->db->select('file_name');
        $this->db->from('boutique_product_images');
        $this->db->where('file_name',$image_file);
        $this->db->where('product_id',$product_id);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) 
            return TRUE;
        else
            return FALSE;   
    }
	
    /**
     * Fetch multiple-row data conditionally and joined with multiple table
     * 
     * @access public 
     * @param integer
     * @param $start
     * @param $start 
     * @return object 
     */
    public function category_wise_product($id, $start, $end)
    {
        $sql = "SELECT bps.id as product_id, bps.product_name, bps.quantity as quantity, bps.amount, bps.brought_from, bps.bill_no,
                       bp.id, bp.available_quantity, bp.unit_price, bp.category_id, bp.product_stock_id, bp.product_name as product_name, bp.product_no, bp.guarantee, bp.guarantee_unit, bp.available_quantity, bp.description, bp.is_active
                FROM boutique_product_stocks AS bps, boutique_products AS bp
                WHERE bps.id=bp.product_stock_id 
                AND   bp.category_id=$id 
                AND   bp.is_active=1";
        
        $sql_paging = "SELECT bps.id as product_id, bps.product_name, bps.quantity as quantity, bps.amount, bps.brought_from, bps.bill_no,
                              bp.id, bp.available_quantity, bp.unit_price, bp.category_id, bp.product_stock_id, bp.product_name as product_name, bp.product_no, bp.guarantee, bp.guarantee_unit, bp.available_quantity, bp.description, bp.is_active
                       FROM boutique_product_stocks AS bps, boutique_products AS bp
                       WHERE bps.id=bp.product_stock_id 
                       AND   bp.category_id=$id 
                       AND   bp.is_active=1 LIMIT $start,$end";
        
        $data['product_afterPg'] = $this->db->query($sql_paging)->result();
        $query1                  = $this->db->query($sql);
        $data['product_rows']    = $query1->num_rows();

        return $data;
    }
	
    /**
     * Fetch multiple-row data conditionally and joined with multiple table
     * 
     * @access public 
     * @param integer
     * @return array 
     */
    public function poduct_id_wise_information($id)
    {
        $query=$this->db->query("SELECT bps.id,
                                        bps.product_name,
                                        bps.quantity,
                                        bps.amount,
                                        bps.brought_from,
                                        bps.bill_no,
                                        bp.category_id as category_id,
                                        bp.product_stock_id,
                                        bp.product_name as product_name,
                                        bp.product_no,
                                        bp.guarantee,
                                        bp.guarantee_unit,
                                        bp.available_quantity,
                                        bp.description,
                                        bp.is_active
                                  FROM boutique_product_stocks AS bps, 
                                       boutique_products AS bp
                                  WHERE bps.id=bp.product_stock_id 
                                  AND bp.product_stock_id=$id 
                                  AND bp.is_active=1");
        return $query->result();
    }

    /**
     * Fetch multiple-row data of user order table conditionally and joined with multiple table
     * 
     * @access public 
     * @param integer
     * @return array 
     */	
    public function user_order_info($user_id)
    {
        $this->db->select('boutique_user_orders.order_date, boutique_user_orders.bill_no, boutique_user_orders.courier_name, boutique_user_orders.courier_no, boutique_user_orders.delivered_on, boutique_products.product_name, boutique_user_orders.order_quantity, boutique_shipment_levels.id as shipment_level, boutique_shipment_levels.level_status_message');
        $this->db->from('boutique_user_orders');
        $this->db->join('boutique_products', 'boutique_user_orders.product_id = boutique_products.id');
        $this->db->join('boutique_shipment_levels', 'boutique_user_orders.shipment_level_id = boutique_shipment_levels.id');
        $this->db->where('boutique_user_orders.user_id', $user_id);
        $query = $this->db->get();

        return $query->result(); 
    }
    
    /**
     * Deletes user-orders from the shopping-cart which is more than 1-day old
     * 
     * @param integer
     * 
     * @return array 
     */	
    public function delete_old_orders($user_id)
    {
        /* selects all user-chosen items */
        $this->db->select('*');
        $this->db->from('boutique_shopping_cart');
        $this->db->where('user_id',$user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            $query_old_items = $this->db->query("SELECT * FROM boutique_shopping_cart 
                                                 WHERE DATE_SUB(CURDATE(),INTERVAL 1 DAY) >= item_chosen_at");
            $old_items = $query_old_items->result();
            foreach ($old_items as $oi)
            {
                $cart_id    = $oi->id;
                $product_id = $oi->product_id;
                $quantity   = $oi->quantity;
                
                /* adjusts back the chosen quantity */
                $this->db->query("UPDATE boutique_products
                                  SET available_quantity = available_quantity + $quantity  
                                  WHERE id = $product_id
                                  LIMIT 1");
                
                $this->db->query("DELETE FROM boutique_shopping_cart WHERE id = $cart_id");
            }
            
            return TRUE;
        }
        else
            return FALSE;
    }
    
    /**
     * Fetch multiple-row data conditionally and joined with multiple table
     * 
     * @access public 
     * @param integer
     * 
     * @return array 
     */
    public function user_shopping_cart_info($user_id)
    {
            $this->db->select('boutique_shopping_cart.id as shopping_cart_id, boutique_shopping_cart.product_id, boutique_shopping_cart.quantity, boutique_shopping_cart.item_chosen_at, boutique_products.product_name, boutique_products.unit_price, boutique_categories.name');
            $this->db->from('boutique_shopping_cart');
            $this->db->join('boutique_products', 'boutique_products.id = boutique_shopping_cart.product_id');
            $this->db->join('boutique_categories', 'boutique_products.category_id = boutique_categories.id');
            $this->db->where('boutique_shopping_cart.user_id', $user_id);
            $query = $this->db->get();
            
            return $query->result();
    }
    
    /**
     * Fetch specific shopping-cart details
     * 
     * @access public 
     * @param integer
     * 
     * @return array 
     */
    public function get_single_shopping_cart_details($cart_id)
    {
            $this->db->select('boutique_shopping_cart.quantity, boutique_products.product_name, boutique_products.unit_price');
            $this->db->from('boutique_shopping_cart');
            $this->db->join('boutique_products', 'boutique_products.id = boutique_shopping_cart.product_id');
            $this->db->where('boutique_shopping_cart.id', $cart_id);
            $this->db->limit(1);
            $query = $this->db->get();
            
            return $query->result();
    }
    
    /**
     * Gets user's particular shopping-cart info 
     * 
     * @param integer
     * @param string
     * 
     * @return integer|float 
     */
    public function get_specific_shopping_cart_info($user_id, $info_type)
    {
        $this->db->select_sum('quantity');
        $query            = $this->db->get_where('boutique_shopping_cart', array('user_id' => $user_id));
        $purchase_data    = $query; 
        $row              = $query->row();
        $total_quantities = $row->quantity;
        
        if ($info_type == 'total_quantities')
        {
            return $total_quantities;
        }    
        else
        {
            $q = $this->db->get_where('boutique_shopping_cart', array('user_id' => $user_id));
            $r = $q->result();
            
            $total_price = 0;
            foreach ($r as $p)
            {
                $product_id = $p->product_id;
                $quantity   = $p->quantity;
                
                $this->db->select('boutique_products.unit_price');
                $this->db->from('boutique_products');
                $this->db->join('boutique_shopping_cart', 'boutique_shopping_cart.product_id = boutique_products.id');
                $this->db->where('boutique_products.id', $product_id);
                $this->db->where('boutique_shopping_cart.user_id', $user_id);
                $this->db->limit(1);
                $query        = $this->db->get();
                $row          = $query->row();
                $unit_price   = $row->unit_price;
                $total_price += $quantity * $unit_price;
            }
            
            return $total_price;
        }
    }
}

/* End of file member.php */
/* Location: ./application/models/member.php */
