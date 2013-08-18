<?php

/**
 * Contains the core logic to generate and process member data 
 * 
 * @author Afsana Rahman Snigdha 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 * Creation Date   : September 24, 2012 
 */
class Report_model extends CI_Model
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
     * Verify Access Credential 
     * 
     * @access public
     * @param date $from_date
     * @param date $to_date
     * @return array
     */
    public function get_members_with_inrange($from_date, $to_date)
    {
        $sql ="SELECT * FROM boutique_users WHERE created_at BETWEEN '$from_date' AND '$to_date' AND is_admin !=1";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param date $from_date
     * @param date $to_date
     * @return array
     */
    public function get_categories_with_inrange($from_date, $to_date)
    {
        $sql ="SELECT * FROM boutique_categories WHERE created_at BETWEEN '$from_date' AND '$to_date'";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param date $from_date
     * @param date $to_date
     * @return array
     */
    public function get_products_with_inrange($from_date, $to_date)
    {
        $sql ="SELECT bp.*,c.name AS category_name 
                FROM boutique_products  AS bp, boutique_categories AS c
                WHERE bp.created_at BETWEEN '$from_date' AND '$to_date' AND is_active !=0
                AND bp.category_id=c.id";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }  

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param date $from_date
     * @param date $to_date
     * @return array
     */
    public function get_inventory_with_inrange($from_date, $to_date)
    {
        $sql ="SELECT bps.*, SUM(buo.order_quantity) AS sold_item
                FROM boutique_product_stocks AS bps,boutique_user_orders AS buo
                WHERE bps.id=buo.product_id AND
                bps.`created_at` BETWEEN '$from_date' AND '$to_date'
                GROUP BY buo.product_id";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param date $from_date
     * @param date $to_date
     * @return array
     */
    public function get_orders_with_inrange($from_date, $to_date)
    {
        $sql ="SELECT buo.* , bu.full_name AS member_name, bp.product_name AS product_name,bp.unit_price AS price
                FROM boutique_user_orders AS buo, boutique_users AS bu, boutique_products AS bp
                WHERE buo.order_date BETWEEN '$from_date' AND '$to_date' 
                AND bu.id=buo.user_id
                AND bp.id=buo.product_id";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param date $from_date
     * @param date $to_date
     * @return array
     */
    public function get_shipment_tracking_with_inrange($from_date, $to_date)
    {
        $sql ="SELECT buo.* , bu.full_name AS member_name, bp.product_name AS product_name,bp.unit_price AS price,
                buo.shipment_level_id AS shipment_level
                FROM boutique_user_orders AS buo, boutique_users AS bu, boutique_products AS bp,boutique_shipment_levels AS bsl
                WHERE buo.order_date BETWEEN '$from_date' AND '$to_date'  
                AND bu.id=buo.user_id
                AND bp.id=buo.product_id
                AND bsl.id=buo.shipment_level_id";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param date $from_date
     * @param date $to_date
     * @return array
     */
    public function get_advertisements_with_inrange($from_date, $to_date)
    {
        $sql ="SELECT * FROM boutique_advertisements WHERE created_at BETWEEN '$from_date' AND '$to_date'";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param $from_date
     * @param $to_date
     * @return array
     */
    public function get_stocks_with_inrange($from_date, $to_date)
    {
        $sql ="SELECT bps.product_name AS product_name, bps.quantity AS quantity, bps.created_at AS created_at,
                bps.amount AS amount, bps.brought_from AS brought_from, bps.bill_no AS bill_no,
                SUM(buo.order_quantity) AS total_orders
                FROM boutique_user_orders AS buo, boutique_product_stocks AS bps
                WHERE buo.product_id=bps.id AND 
                buo.order_date BETWEEN '$from_date' AND '$to_date'
                GROUP BY buo.product_id";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param $from_date
     * @param $to_date
     * @return array
     */
    public function get_general_payment_with_inrange($from_date, $to_date)
    {
        $sql ="SELECT bgp.amount AS amount,bgp.payment_date AS payment_date,bgp.mode_of_payment as mode_of_payment,
                bps.product_name AS product_name,bps.quantity AS quantity,
                bps.amount,bps.brought_from AS brought_from,bps.bill_no AS bill_no
                FROM boutique_product_stocks AS bps,boutique_general_payments AS bgp
                WHERE bps.id=bgp.product_stock_id AND 
                bgp.payment_date  BETWEEN '$from_date' AND '$to_date'";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param $from_date
     * @param $to_date
     * @return array
     */
    public function get_other_payment_with_inrange( $from_date, $to_date)
    {
        $sql ="SELECT * FROM `boutique_other_payments`
                WHERE `payment_date` BETWEEN '$from_date' AND '$to_date'";

        $query  = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Verify Access Credential 
     * 
     * @access public
     * @param $from_date
     * @param $to_date
     * @return array
     */
    public function get_profit_and_loss_with_inrange($from_date, $to_date)
    {
		$profit_loss_data= array();
		
		$sql	= "SELECT IFNULL(SUM(buo.order_quantity*bp.unit_price),0.00) AS sold_amount
					FROM boutique_user_orders AS buo, boutique_products bp
					WHERE buo.product_id=bp.id AND 
					order_date BETWEEN '$from_date' AND '$to_date'";
        $query 	= $this->db->query($sql);
		$count = 0;
		
        $result_value=$query->result();

        if(count($result_value)>0)
        {
            foreach ($query->result() as $result):
                if(isset($result->sold_amount))
                {
                    $profit_loss_data['sold'][$count]['sold_amount'] = $result->sold_amount;
                    $count++;                    
                }
            endforeach;
        }       
        else
        {
            $profit_loss_data['sold'][0]['sold_amount'] = 0.00;
        }

        $query  = $this->db->query($sql);
		$sql	= "SELECT IFNULL(SUM(amount),0.00) AS product_bought_amount,product_stock_id
        			FROM boutique_general_payments
        			WHERE payment_date BETWEEN '$from_date' AND '$to_date'
        			GROUP BY product_stock_id";	
        $query 	= $this->db->query($sql);
		
		$count=0;

        $result_value=$query->result();
        if(count($result_value)>0)
        {       
            foreach ($query->result() as $result):
                $profit_loss_data['bought'][$count]['product_bought_amount'] = $result->product_bought_amount;
                $count++;
            endforeach;
        }
        
        else
        {
            $profit_loss_data['bought'][0]['product_bought_amount'] = 0.00;
        }
		
		$sql 	= "SELECT IFNULL(SUM(amount),0.00) AS expense_amount,expense_name
        			FROM boutique_other_payments
        			WHERE payment_date BETWEEN '$from_date' AND '$to_date'
        			GROUP BY expense_name";	
        $query 	= $this->db->query($sql);
		
		$count=0;

        $result_value=$query->result();
        if(count($result_value)>0)
        {
            foreach ($query->result() as $result):
                $profit_loss_data['expense'][$count]['expense_amount'] = $result->expense_amount;
                $profit_loss_data['expense'][$count]['expense_name'] = $result->expense_name;
                $count++;
            endforeach;
        }
        
        else
        {
            $profit_loss_data['expense'][0]['expense_amount'] = 0.00;
            $profit_loss_data['expense'][0]['expense_name'] = "";
        }		
		
        return $profit_loss_data;
    }
	
	public function get_most_sold_products()
	{
		$sql    = "SELECT buo.product_id,SUM(buo.order_quantity) AS quantity, bp.product_name
						FROM boutique_products AS bp,boutique_user_orders AS buo
						WHERE buo.product_id= bp.id  
						GROUP BY buo.product_id 
						ORDER BY buo.order_quantity DESC";
									
        return $this->db->query($sql)->result();
	}
}

/* End of file member.php */
/* Location: ./application/models/member.php */
