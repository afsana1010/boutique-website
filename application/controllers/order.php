<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage order of products. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Order extends CI_Controller
{
    var $CI;
    
    public function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
        $data     = array();
        $this->load->model(array('message_model', 'order_model', 'country_code_model', 'product_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }


    /**
     * Restricted page to list item-order info. 
     * Bypass to the entry-form if no data found.
     * 
     * @return none 
     */
    public function index()
    {
        if( $this->session->userdata('logged_in') != true )
        {
            redirect('siteadmin', 'refresh');
        }
        
        $order_record          = $this->common_model->query_all_data('boutique_user_orders');
        $num_of_rows           = count($order_record);
        $data['num_of_orders'] = $num_of_rows;
        if ($num_of_rows > 0)
        {
            $data['table_title'] = 'View Buy Orders';
            $this->template->write('title', 'Boutique Admin Panel');

            //starts paging configaration
            $limit_from               = $this->uri->segment(3);
            $list_start               = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                 = 10;	
            $data['all_order']       = $this->order_model->get_pagewise($list_start, $list_end);
            $data['order_result']     = $data['all_order']['order_afterPg']; 
            $data['order_rownumbers'] = $data['all_order']['order_rows'];

            $list_config['base_url']   = base_url().'order/index/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['order_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['order_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'order/list', $data, TRUE);
            $this->template->render();
        }//end if
        else
        {
            $data['table_title'] = 'View Buy Orders';
            $this->template->write('title', 'Boutique Admin Panel');
            $this->template->write_view('main_content', 'order/list', $data, TRUE);
            $this->template->render();
        }
    }//end order listing
    
    
    /**
     * Manages order information.
     * Restricted for the general users.
     * 
     * @param integer $id 
     * 
     * @return none 
     */
    public function manage($id = NULL)
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
        {
            redirect('siteadmin', 'refresh');
        }
        
        $this->template->write('title', 'Boutique: order Information');
        
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Update Shipment tracking';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $order_data = $this->common_model->query_single_row_by_single_source('boutique_user_orders', 'id', $id);
            foreach ($order_data as $sd)
            {
                $data['shipment_level_id'] = $sd->shipment_level_id;
            }
        }
        if (isset($_POST['courier_name']) && isset($_POST['courier_no']))
        {
                $config = array(
                                    array('field' => 'courier_name', 'label' => 'Courier Name', 'rules' => 'trim|required'),
                                    array('field' => 'courier_no', 	 'label' => 'Courier No', 'rules' => 'trim|required')
                               );
                $this->form_validation->set_rules($config);
        }
        elseif (isset($_POST['delivered_on']))
        {
                $config = array(
                                    array('field' => 'delivered_on', 'label' => 'Delivered On', 'rules' => 'trim|required')
                               );
                $this->form_validation->set_rules($config);
        }
        
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'order/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            $bill_no      = $this->common_model->query_single_data('boutique_user_orders', 'id', $id, 'bill_no');
            $user_id      = $this->common_model->query_single_data('boutique_user_orders', 'id', $id, 'user_id');
            $user_name    = $this->common_model->query_single_data('boutique_users', 'id', $user_id, 'full_name');
            $user_email   = $this->common_model->query_single_data('boutique_users', 'id', $user_id, 'email_address');
            $mobile_no    = $this->common_model->query_single_data('boutique_users', 'id', $user_id, 'mobile_no');
            $country_code = $this->country_code_model->get_country_code_by_user_id($user_id);
            
            //gathers all necessary SMS & Email greetings
            $msg_greeting = $this->common_model->query_single_data('boutique_messages', 'action_name', 'START GREETING', 'message');
            $msg_greeting = preg_replace("/NAME/", $user_name, $msg_greeting);
            $msg_ending   = $this->common_model->query_single_data('boutique_messages', 'action_name', 'END GREETING', 'message');

            
            //ends gathering messages
            
            /* gathers submitted info */
            if(isset($_POST['courier_name']) && isset($_POST['courier_no'])) // shipment has been couriered
            {
                $courier_name = $this->input->post('courier_name');
                $courier_no   = $this->input->post('courier_no');
                
                $message = $this->common_model->query_single_data('boutique_messages', 'action_name', 'SHIPMENT STATUS', 'message');
                $message = preg_replace("/NUMBER/", $bill_no, $message);
                $message = preg_replace("/COURIER/", $courier_name . " whose number is " . $courier_no, $message);
                $message = preg_replace("/DATE/", date('F j, Y'), $message);
                $sms     = $msg_greeting . "\r\n" . $message . "\r\n" . $msg_ending; 
                
                $email_subject = "Order Shipment Status from Boutique";
                $email_message = $msg_greeting . "\n" . $message . "\n\n" . $msg_ending;
                
                $update_data['shipment_level_id'] = $this->input->post('shipment_level_id');
                $update_data['courier_name'] 	  = $courier_name;
                $update_data['courier_no'] 	  = $courier_no;
            }
            elseif(isset($_POST['delivered_on'])) // shipment has been delivered
            {
                $delivered_on = $this->input->post('delivered_on');
                
                $message = $this->common_model->query_single_data('boutique_messages', 'action_name', 'SHIPMENT CLOSED', 'message');
                $message = preg_replace("/NUMBER/", $bill_no, $message);
                $message = preg_replace("/DATE/", date('F j, Y', strtotime($delivered_on)), $message);
                $sms     = $msg_greeting . "\r\n" . $message . "\r\n" . $msg_ending; 
                
                $email_subject = "Order Delivered from Boutique";
                $email_message = $msg_greeting . "\n" . $message . "\n\n" . $msg_ending;
                
                $update_data['shipment_level_id'] = $this->input->post('shipment_level_id');
                $update_data['delivered_on'] 	  = $delivered_on;
                $update_data['is_open'] 	  = 0;
            }           

            /* updates info */
            if ($this->common_model->update_data('id', $id, 'boutique_user_orders', $update_data))
            {
                $this->session->set_flashdata('success_message','Shipment Status is Updated Successfuly.');
                if ($this->message_model->process_sms_call($country_code, $mobile_no, $sms))  // SMS sent 
                {
                    // loads email lib and email to the customer
                    $this->load->library('email');
                    $this->email->to($user_email);
                    $this->email->from($this->CI->config->item('sender_email'), $this->CI->config->item('sender_name'));
                    $this->email->subject($email_subject);
                    $this->email->message($email_message);	
                    $this->email->send();
                }
            }//end sub-if    
            else
                $this->session->set_flashdata('error_message','Could not update the order! Please try again later.');
            /* redirects to list page */
            redirect('order', 'refresh');
        } //end main else


        $this->template->render();
    } //ends order data management
    
    /**
     * Store payment info from PayPal, when user auto-directed to the site
     * 
     * @access  
     */
    public function confirm()
    {
        $recipient_email  = $this->CI->config->item('paypal_email_recipient');
        $callback_data    = $this->input->get(NULL, TRUE);
        $paypal_item_info = explode('_', $callback_data['item_number']);
        $bill_no          = $paypal_item_info[0];
        $user_id          = $paypal_item_info[1];
        $transaction_id   = $callback_data['tx'];
        $payment_status   = $callback_data['st'];
        $check_transaction_existence = $this->common_model->query_single_row_by_single_source('boutique_paypal_transactions', 'transaction_id', $transaction_id);
        if (count($check_transaction_existence) > 0) //transaction exists; just update the payment-status
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
            $user_data['paid_amount']    = $callback_data['amt'];
            $user_data['paid_currency']  = $callback_data['cc'];
            $user_data['paytime']        = date('Y-m-d h:i:s');
            $this->common_model->add_data('boutique_paypal_transactions',$user_data);

            //ads shopping-cart items to the order table
            $cart_item_list   = $this->product_model->user_shopping_cart_info($user_id);
            $id               = $this->common_model->get_last_order_without_where_clause('boutique_user_orders','id');
            $purchase_details = 'Purchase Details:\n\n';
            foreach($cart_item_list as $row)
            {
                    $purchase_details .= 'Product Name: ' . $this->common_model->query_single_data('boutique_products', 'id', $row->product_id, 'product_name') . '\n';
                    $purchase_details .= 'Quantity: ' . $row->quantity . '\n';
                    $purchase_details .= 'Price: ' . $this->common_model->query_single_data('boutique_products', 'id', $row->product_id, 'unit_price') * $row->quantity . ' ' . $callback_data['cc'] . '\n\n';

                    $id         = $id +1;
                    $order_data = array();

                    $order_data['id']               = $id ;
                    $order_data['user_id']          = $user_id;
                    $order_data['product_id']       = $row->product_id;
                    $order_data['shipment_level_id']= 1;
                    $order_data['order_quantity']   = $row->quantity;
                    $order_data['bill_no']          = $bill_no;
                    $order_data['order_date']       = $row->item_chosen_at;
                    $order_data['is_open']          = 1;
                    $order_data['created_at']       = date('Y-m-d h:i:s');

                    if( $this->common_model->add_data('boutique_user_orders',$order_data) == TRUE )
                        $this->common_model->delete_data('user_id', $user_id, 'boutique_shopping_cart');
            }//ends foreach
        }

        $customer_name    = $this->common_model->query_single_data('boutique_users', 'id', $user_id, 'full_name');
        $customer_email   = $this->common_model->query_single_data('boutique_users', 'id', $user_id, 'email_address');
        $customer_address = $this->common_model->query_single_data('boutique_users', 'id', $user_id, 'residence_address');

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

        $this->email->to($customer_email);
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
        $body .= "--- Name: " . $customer_name . "\n";
        $body .= "--- Address: " . $customer_address . "\n";
        $body .= "--- Email Address: " . $customer_email . "\n\n";

        $body .= "Notified By\n";
        $body .= "Boutique\n";

        $this->email->to($recipient_email);
        $this->email->from($customer_email, $customer_name);
        $this->email->subject('PayPal Purchase Notification from Boutique');
        $this->email->message($body);	
        $this->email->send();
        //ends sending email to the merchant
    }    
    
}

/* End of file order.php */
/* Location: ./application/controllers/order.php */