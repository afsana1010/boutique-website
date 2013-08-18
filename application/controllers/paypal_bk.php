<?php
/**
 * PayPal_Lib Controller Class (Paypal IPN Class)
 *
 * Paypal controller that provides functionality to the creation for PayPal forms, 
 * submissions, success and cancel requests, as well as IPN responses.
 *
 * The class requires the use of the PayPal_Lib library and config files.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Commerce
 * @author      Ran Aroussi <ran@aroussi.com>
 * @copyright   Copyright (c) 2006, http://aroussi.com/ci/
 *
 */
 
class Paypal extends CI_Controller {

    var $CI;
    
    public function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
	
        $this->load->library('Paypal_Lib');
        $this->load->model(array('message_model', 'country_code_model', 'product_model'));
    }
	
	public function index()
	{
		$this->form();
	}
	
	public function form()
	{
            $this->paypal_lib->add_field('business', $this->CI->config->item('paypal_business_account'));
            $this->paypal_lib->add_field('return', site_url('paypal/success'));
	    $this->paypal_lib->add_field('cancel_return', site_url('paypal/cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('paypal/ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', '1234567890'); // <-- Verify return

	    $this->paypal_lib->add_field('item_name', 'Upgrading Membership: Advanced Premium');
	    $this->paypal_lib->add_field('item_number', '5001');
	    $this->paypal_lib->add_field('amount', '35');

		// if you want an image button use this:
		$this->paypal_lib->image('button_03.gif');
		
		// otherwise, don't write anything or (if you want to 
		// change the default button text), write this:
		// $this->paypal_lib->button('Click to Pay!');
		
	    $data['paypal_form'] = $this->paypal_lib->paypal_form();
	
		$this->load->view('paypal/form', $data);
        
	}

	public function auto_form()
	{
            if($this->session->userdata('logged_in') != true)
                redirect('register/login', 'refresh');
            
            //gets info from URI
            $payment_type = $this->uri->segment(3);
            $user_id      = $this->uri->segment(4);

            if( $payment_type != 'book_advertisement' )
            {
                $verification_data  = $this->common_model->get_unique_numeric_id('boutique_user_orders','bill_no');
                $return_url         = 'product/confirmation/' . $verification_data;
                $paypal_item_number = $verification_data . '_' . $user_id;
                
                $this->paypal_lib->add_field('business', $this->CI->config->item('paypal_business_account'));
                $this->paypal_lib->add_field('return', site_url($return_url));
                $this->paypal_lib->add_field('cancel_return', site_url('paypal/cancel'));
                $this->paypal_lib->add_field('notify_url', site_url('paypal/ipn')); // <-- IPN url
                $this->paypal_lib->add_field('custom', $verification_data); // <-- Verify return
                
                //$this->paypal_lib->add_field('item_number', $paypal_item_number);
                $cart_id_str = $this->uri->segment(5);
                $cart_ids    = explode('a', $cart_id_str);
                $total_price = 0;
                $total_qtty  = 0;
                for ($i = 0; $i < count($cart_ids); $i++)
                {
                    $cart_details = $this->product_model->get_single_shopping_cart_details($cart_ids[$i]);
                    foreach ($cart_details as $cart_data)
                    {
                        $total_qtty  += $cart_data->quantity;
                        $total_price += ($cart_data->unit_price * $cart_data->quantity);
//                        $this->paypal_lib->add_field('item_name' . $i + 1, $cart_data->product_name);
//                        $this->paypal_lib->add_field('amount' . $i + 1, $cart_data->unit_price);
//                        $this->paypal_lib->add_field('quantity' . $i + 1, $cart_data->quantity);
                    }
                }
                
                
                $this->paypal_lib->add_field('item_name', 'Purchased ' . $total_qtty . ' Products from Boutique Store');
                $this->paypal_lib->add_field('item_number', $paypal_item_number);
                $this->paypal_lib->add_field('amount', $total_price);
            }//end sub-if
            else
            {
                

            }//end sub-else

	    $this->paypal_lib->paypal_auto_form();
	}
    
	public function cancel()
	{
		$this->load->view('paypal/cancel');
	}
	
	public function success()
	{
		// This is where you would probably want to thank the user for their order
		// or what have you.  The order information at this point is in POST 
		// variables.  However, you don't want to "process" the order until you
		// get validation from the IPN.  That's where you would have the code to
		// email an admin, update the database with payment status, activate a
		// membership, etc.
	
		// You could also simply re-direct them to another page, or your own 
		// order status page which presents the user with the status of their
		// order based on a database (which can be modified with the IPN code 
		// below).

		$data['pp_info'] = $_POST;
                $this->load->view('paypal/success', $data);
	}
	
	public function ipn()
	{
		// Payment has been received and IPN is verified.  This is where you
		// update your database to activate or process the order, or setup
		// the database with the user's order details, email an administrator,
		// etc. You can access a slew of information via the ipn_data() array.
 
		// Check the paypal documentation for specifics on what information
		// is available in the IPN POST variables.  Basically, all the POST vars
		// which paypal sends, which we send back for validation, are now stored
		// in the ipn_data() array.
 
		// For this example, we'll just email ourselves ALL the data.
		
                //test if PayPal enter here
                $this->load->library('email');
                $body = "Hello,\n";
                $body .= "Hi, I am from PayPal";
                $body .= "Regards,\n";
                $body .= "A Visitor from Boutique\n";
                $this->email->to("mizanurl@yahoo.com");
                $this->email->from("cicakemizan@gmail.com", 'Boutique Visitor');
                $this->email->subject('PayPal IPN Test');
                $this->email->message($body);
                $this->email->send();
                
                
                $recipient_email = $this->CI->config->item('paypal_email_recipient');
        
		if ($this->paypal_lib->validate_ipn()) 
		{
                    $paypal_item_info            = explode('_', $ipn['item_number']);
                    $user_id                     = $paypal_item_info[1];
                    $ipn                         = $this->paypal_lib->ipn_data;
                    $transaction_id              = $ipn['txn_id'];
                    $bill_no                     = $ipn['custom'];
                    $payment_status              = $ipn['payment_status'];
                    $check_transaction_existence = $this->common_model->query_single_row_by_single_source('boutique_paypal_transactions', 'transaction_id', $transaction_id);
                    if (count($check_transaction_existence) > 0) //transaction exits; just update the payment-status
                    {
                        $update_data                   = array();
                        $update_data['payment_status'] = $payment_status;
                        $this->common_model->update_data('transaction_id', $transaction_id, 'boutique_paypal_transactions', $update_data);
                    }
                    else //found new transaction; so store it, Email & SMS it 
                    {
                        $user_data                   = array();
                        $user_data['id']	     = '' ;
                        $user_data['user_id']        = $user_id;
                        $user_data['transaction_id'] = $transaction_id;
                        $user_data['bill_no']        = $bill_no;
                        $user_data['payment_status'] = $payment_status;
                        $user_data['paid_amount']    = $ipn['mc_gross'];
                        $user_data['paid_currency']  = $ipn['mc_currency'];
                        $user_data['paytime']        = date('Y-m-d h:i:s', strtotime($ipn['payment_date']));
                        $this->common_model->add_data('boutique_paypal_transactions',$user_data);
                        
                        //ads shopping-cart items to the order table
                        $cart_item_list   = $this->product_model->user_shopping_cart_info($user_id);
                        $id               = $this->common_model->get_last_order_without_where_clause('boutique_user_orders','id');
                        $purchase_details = 'Purchase Details:\n\n';
                        foreach($cart_item_list as $row)
                        {
                                $purchase_details .= 'Product Name: ' . $this->common_model->query_single_data('boutique_products', 'id', $row->product_id, 'product_name') . '\n';
                                $purchase_details .= 'Quantity: ' . $row->quantity . '\n';
                                $purchase_details .= 'Price: ' . $this->common_model->query_single_data('boutique_products', 'id', $row->product_id, 'unit_price') * $row->quantity . ' ' . $ipn['mc_currency'] . '\n\n';
                            
                                $id         = $id +1;
                                $order_data = array();

                                $order_data['id']		= $id ;
                                $order_data['user_id']		= $user_id;
                                $order_data['product_id']	= $row->product_id;
                                $order_data['shipment_level_id']= 1;
                                $order_data['order_quantity']	= $row->quantity;
                                $order_data['bill_no']		= $bill_no;
                                $order_data['order_date']	= $row->item_chosen_at;
                                $order_data['is_open']		= 1;
                                $order_data['created_at']	= date('Y-m-d h:i:s');

                                if( $this->common_model->add_data('boutique_user_orders',$order_data) == TRUE )
                                    $this->common_model->delete_data('user_id', $user_id, 'boutique_shopping_cart');
                        }//ends foreach
                    }
                    
                    $customer_name  = $ipn['first_name'] . ' ' . $ipn['last_name'];
                    $customer_email = $ipn['payer_email'];

                    //gathers all necessary SMS & Email messages
                    $msg_greeting = $this->common_model->query_single_data('boutique_messages', 'action_name', 'START GREETING', 'message');
                    $msg_greeting = preg_replace("/NAME/", $customer_name, $msg_greeting);
                    $msg_ending   = $this->common_model->query_single_data('boutique_messages', 'action_name', 'END GREETING', 'message');
                    
                    $msg_sms = $this->common_model->query_single_data('boutique_messages', 'action_name', 'ORDER CONFIRMATION', 'message');
                    //You have successfully placed an order in COMPANY. Check email for details. Your order track id is NUMBER.
                    $msg_sms = preg_replace("/COMPANY/", 'Boutique', $msg_sms);
                    $msg_sms = preg_replace("/NUMBER/", $bill_no, $msg_sms);
                    //ends gathering messages
                    
                    $this->load->library('email');
                    
                    //sends email to the customer
                    $body = $msg_greeting . "\n";
                    $body .= 'You have successfully placed an on Boutique and also placed the payment for that';
                    $body .= ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
                    $body .= $purchase_details . "\n\n";
                    $body .= "You can track the above order by this ID: " . $bill_no . "\n\n";
                    $body .= "Notified By\n";
                    $body .= "Boutique\n";

                    $this->email->to($ipn['payer_email']);
                    $this->email->from($recipient_email, 'Boutique');
                    $this->email->subject('Purchase Confirmation at Boutique by PayPal');
                    $this->email->message($body);	
                    if ($this->email->send()) //email sent
                    {
                        $country_code = $this->country_code_model->get_country_code_by_user_id($user_id);
                        $mobile_no    = $this->common_model->query_single_data('boutique_users', 'id', $user_id, 'mobile_no');
                        $sms          = $msg_greeting . "\r\n" . $msg_sms . "\r\n" . $msg_ending;
                        $this->message_model->process_sms_call($country_code, $mobile_no, $sms); //sends SMS
                    }
                    //ends sending email to the customer
                    
                    //sends email to the merchant
                    $body  = $customer_name . '(' . $customer_email . ') has successfully placed a payment on Boutique';
                    $body .= ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
                    $body .= $purchase_details . "\n\n";
                    $body .= " Customer Details:\n\n";
                    $body .= "--- Name: " . $ipn['address_name'] . "\n";
                    $body .= "--- Address: " . $ipn['address_street'] . ", " . $ipn['address_zip'] . ", " . $ipn['address_state'] . ", " . $ipn['address_city'] . ", " . $ipn['address_country_code'] . "\n";
                    $body .= "--- Address is " . $ipn['address_status'] . "\n";
                    $body .= "--- Email Address: " . $ipn['payer_email'] . "\n\n";
                    
                    $body .= "Notified By\n";
                    $body .= "Boutique\n";

                    $this->email->to($recipient_email);
                    $this->email->from($ipn['payer_email'], $customer_name);
                    $this->email->subject('PayPal Purchase Notification from Boutique');
                    $this->email->message($body);	
                    $this->email->send();
                    //ends sending email to the merchant
		}
	}
}
?>