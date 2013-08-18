<?php

/**
 * Contains the core logic to generate and process product-payment data 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 * Creation Date   : October 5, 2012 
 */
class Profitandloss_model extends CI_Model
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
     * Gets product wise sold amount 
     * 
     * 
     * 
     * @return array 
     */
    public function get_product_sold($from_date,$to_date)
    {
        $sql	= "SELECT SUM(buo.order_quantity*bp.unit_price) AS sold_amount
					FROM boutique_user_orders AS buo, boutique_products bp
					WHERE buo.product_id=bp.id AND 
					order_date BETWEEN '$from_date' AND '$to_date'";
					//GROUP BY buo.product_id";	
        $query 	= $this->db->query($sql);

		$sold_amount= array();
		foreach ($query->result() as $result):
			$sold_amount['sold_amount'] = $result->sold_amount;
		endforeach;
		return $sold_amount;
    }
	
    /**
     * Gets stock wise payment 
	 *
     * @return array 
     */
    public function get_general_payment($from_date,$to_date)
    {
        $sql	= "SELECT SUM(amount) AS product_bought_amount,product_stock_id
					FROM boutique_general_payments
					WHERE payment_date BETWEEN '$from_date' AND '$to_date'
					GROUP BY product_stock_id";	
        $query 	= $this->db->query($sql);
		$payment_array=array();
		
		$count = 0;
		foreach ($query->result() as $result):
			$payment_array[$count]['product_bought_amount'] = $result->product_bought_amount;
			$count++;
		endforeach;
		
        return $payment_array;
    }
    /**
     * Gets expence wise other payment  
     * 
     * @return array 
     */	
    public function get_expense_name($from_date,$to_date)
    {
        $sql	= "SELECT SUM(amount) AS expense_amount,expense_name
					FROM boutique_other_payments
					WHERE payment_date BETWEEN '$from_date' AND '$to_date'
					GROUP BY expense_name";	
        $query 	= $this->db->query($sql);
		
		$expences_array=array();
		
		$count=0;
		foreach ($query->result() as $result):
			$expences_array[$count]['expense_amount'] = $result->expense_amount;
			$expences_array[$count]['expense_name'] = $result->expense_name;
			$count++;
		endforeach;
        return $expences_array;
    }
}

/* End of file Payment_model.php */
/* Location: ./application/models/Payment_model.php */
