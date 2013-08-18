<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage payment of products. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Payment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('payment_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }

    /**
    * Display's Search Option of Invoice No.
    * 
    * @return none 
    */
    public function selection_date()
    {       
        $data['form_title']          = 'Sesrch by period of time';
        $data['action']              = 'search';
        $data['method_name']         = 'product_reciept';

        $this->template->write_view('main_content', 'payment/selection_date', $data, TRUE);
        $this->template->render(); 
    }
	
	
	/**
     * Restricted page to list item-payment info. 
     * Bypass to the entry-form if no data found.
     * 
     * @return none 
     */
	
    public function payments()
    {
        if( $this->session->userdata('logged_in') != true )
        {
            redirect('siteadmin', 'refresh');
        }
        
        $payment_record          = $this->common_model->query_all_data('boutique_product_stocks');
        $num_of_rows           	 = count($payment_record);
        $data['num_of_payments'] = $num_of_rows;
        if ($num_of_rows > 0)
        {
            $data['table_title'] = 'Item Payment List';
            $this->template->write('title', ' Admin Panel');

            //starts paging configaration
            $limit_from               = $this->uri->segment(3);
            $list_start               = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                 = 10;	
			
			if(isset($_POST['from_date']) && isset($_POST['to_date']))
			{
			    $from_date 			 = $this->input->post('from_date');
				$to_date 			 = $this->input->post('to_date');
				$data['all_payment'] = $this->payment_model->get_pagewise_receipt_in_daterange($from_date, $to_date, $list_start, $list_end);
			}
			else
			{
				$data['all_payment']       = $this->payment_model->get_pagewise($list_start, $list_end);
			}
			
            $data['payment_result']     = $data['all_payment']['payment_afterPg']; 
            $data['payment_rownumbers'] = $data['all_payment']['payment_rows'];

            $list_config['base_url']   = base_url().'payment/receipt/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['payment_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['payment_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'payment/receipt', $data, TRUE);
            $this->template->render();
        }//end if

    }//end payment listing
    
	/**
     * Export Ticket Promotions list to Excel
     * 
     * @return none 
     */
    public function exportPaymentsToExcel()
    {
		$payment_record          = $this->common_model->query_all_data('boutique_product_stocks');
        $num_of_rows           	 = count($payment_record);
        
		if ($num_of_rows > 0)
        {
			$columns = array();
			$columns['field'] = array("created_at", "brought_from", "product_name", "quantity", "amount", "bill_no");
			$columns['title'] = array("Date", "Paid To", "Product Name", "Quantity", "Amount", "Bill No.");
			$columns['type']  = array("date", "", "", "", "", "");
			
			$this->common_model->exportToExcel($columns,$payment_record,'Payments_List');
        }//end if
    }//end excel export
	
    /**
     * Restricted page to list item-payment info. 
     * Bypass to the entry-form if no data found.
     * 
     * @return none 
     */
    public function receipt()
    {
        if( $this->session->userdata('logged_in') != true )
        {
            redirect('siteadmin', 'refresh');
        }
        
        $payment_record          = $this->common_model->query_all_data('boutique_product_stocks');
        $num_of_rows           	 = count($payment_record);
        $data['num_of_payments'] = $num_of_rows;
        if ($num_of_rows > 0)
        {
            $data['table_title'] = 'Item Payment List';
            $this->template->write('title', ' Admin Panel');

            //starts paging configaration
            $limit_from               = $this->uri->segment(3);
            $list_start               = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                 = 10;	
            $data['all_payment']       = $this->payment_model->get_pagewise($list_start, $list_end);
            $data['payment_result']     = $data['all_payment']['payment_afterPg']; 
            $data['payment_rownumbers'] = $data['all_payment']['payment_rows'];

            $list_config['base_url']   = base_url().'payment/receipt/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['payment_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['payment_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'payment/receipt', $data, TRUE);
            $this->template->render();
        }//end if

    }//end payment listing
    

    /**
     * Manage general payment.
     * Restricted for the general users.
     * 
     * @return integer. 
     */
    public function general_payment()
    {
        if( $this->session->userdata('logged_in') != true )
        {
            redirect('siteadmin', 'refresh');
        }
        
		$data['table_title'] = 'General Payment List';
		$this->template->write('title', ' Admin Panel');
		
        $payment_record          = $this->common_model->query_all_data('boutique_general_payments');
        $num_of_rows           	 = count($payment_record);
        $data['num_of_payments'] = $num_of_rows;
        if ($num_of_rows > 0)
        {
            
            //starts paging configaration
            $limit_from               = $this->uri->segment(3);
            $list_start               = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                 = 10;	
            $data['all_payment']       = $this->payment_model->get_pagewise_general_payment($list_start, $list_end);
            $data['payment_result']     = $data['all_payment']['payment_afterPg']; 
            $data['payment_rownumbers'] = $data['all_payment']['payment_rows'];

            $list_config['base_url']   = base_url().'payment/general_payment/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['payment_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['payment_paging'] = $this->pagination->create_links();


            $this->template->write_view('main_content', 'payment/general_payment', $data, TRUE);
            $this->template->render();
            //ends paging configaration
        }//end if
		
        else
        {
            /* redirects to list page */
            $data['form_title'] = 'Add General Payment';
            $data['action']     = 'add';
            $data['stocks']          = $this->common_model->query_sorted_data('boutique_product_stocks', 'product_name');
            

            $this->template->write_view('main_content', 'payment/manageGeneralPayment', $data, TRUE);
            $this->template->render();
        }
    }


    /**
     * Manages advertisement information.
     * Restricted for the general users.
     * 
     * @param integer $id 
     * 
     * @return none 
     */
    public function manageGeneralPayment($id = NULL)
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
        {
            redirect('siteadmin', 'refresh');
        }
        
        $this->template->write('title', 'boutique: General Payment Information');
        
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Edit General Payment';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $data['stocks']          = $this->common_model->query_sorted_data('boutique_product_stocks', 'product_name');

            $other_payment_data = $this->common_model->query_single_row_by_single_source('boutique_general_payments', 'id', $id);
            
            foreach ($general_payment_data as $gpd)
            {
                $data['product_stock_id']       = $gpd->product_stock_id;
                $data['amount']                 = $gpd->amount;
                $data['payment_date']        	= $gpd->payment_date;
                $data['mode_of_payment']        = $gpd->mode_of_payment;
                $data['payment_cheque_id']      = $gpd->payment_cheque_id;
                $data['paypal_transaction_id']  = $gpd->paypal_transaction_id;
                $data['modified_at']            = $gpd->modified_at;
            }
            if(isset($data['payment_cheque_id']))
            {
                $cheques_data = $this->common_model->query_single_row_by_single_source('boutique_payment_cheques', 'id', $data['payment_cheque_id']);
                
                foreach ($cheques_data as $cd)
                {
                    $data['account_no']         = $cd->account_no;
                    $data['account_name']       = $cd->account_name;
                    $data['bank_name']          = $cd->bank_name;
                    $data['bank_branch']        = $cd->bank_branch;
                    $data['cheque_issue_date']  = $cd->cheque_issue_date;
                }
            }
            
            elseif(isset($data['paypal_transaction_id']))
            {
                $paypals_data = $this->common_model->query_single_row_by_single_source('boutique_paypal_transactions', 'id', $data['paypal_transaction_id']);
                
                foreach ($paypals_data as $pd)
                {
                    $data['user_id']        = $pd->user_id;
                    $data['transaction_id'] = $pd->transaction_id;
                    $data['payment_status'] = $pd->payment_status;
                    $data['paid_amount']    = $pd->paid_amount;
                    $data['paid_currency']  = $pd->paid_currency;
                    $data['paytime']        = $pd->paytime;
                }
            }
            
            //echo "<pre>";print_r($data);die();
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add General Payment';
            $data['action']     = 'add';
            

            $data['stocks']          = $this->common_model->query_sorted_data('boutique_product_stocks', 'product_name');
            // validation set for cheque payment selection 
            if($this->input->post('mode_of_payment')=='cheque')
            {
                $config = array(
                    array('field' => 'amount',              'label' => 'Amount',    'rules' => 'trim|required|decimal'),
                    array('field' => 'account_no',          'label' => 'Account No',    'rules' => 'trim|required|max_length[60]'),
                    array('field' => 'account_name',        'label' => 'Account Name',  'rules' => 'trim|required|max_length[60]'),
                    array('field' => 'bank_name',           'label' => 'Bank Name',     'rules' => 'trim|required|max_length[60]'),
                    array('field' => 'bank_branch',         'label' => 'Branch Name',   'rules' => 'trim|required|max_length[60]'),
                    array('field' => 'cheque_issue_date',   'label' => 'Cheque Issue Date',     'rules' => 'trim|required|date')
               );
            }
            // validation for paypal transaction
            else if($this->input->post('mode_of_payment')=="paypal")
            {
                $data['paytime']        = $pd->paytime;
            
                $config = array(
                    array('field' => 'amount',         'label' => 'Amount',         'rules' => 'trim|required|decimal'),
                    array('field' => 'user_id',        'label' => 'User Id',        'rules' => 'trim|required|max_length[50]'),
                    array('field' => 'transaction_id', 'label' => 'Transaction Id', 'rules' => 'trim|required|max_length[50]'),
                    array('field' => 'payment_status', 'label' => 'Payment Status', 'rules' => 'trim|required|max_length[50]'),
                    array('field' => 'paid_amount',    'label' => 'Paid Amount',    'rules' => 'trim|required|decimal'),
                    array('field' => 'paid_currency',  'label' => 'Paid Currency',  'rules' => 'trim|required|max_length[50]'),
                    array('field' => 'paytime',        'label' => 'Paytime',        'rules' => 'trim|required|date')
               );
            }
            // validation set for cash and other payment selection 
            else
            {
                $config = array( 
                    array('field' => 'amount',       'label' => 'Amount',       'rules' => 'trim|required|decimal')
               );
            }
            
            $this->form_validation->set_rules($config);
        }       
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'payment/manageGeneralPayment', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
                /* adds the cheque information */
                $payment_cheque_id='';
                $paypal_transaction_id='';
                
                if($this->input->post('mode_of_payment')=='cheque')
                {
                    $user_data['id']                    = '';
                    $user_data['account_no']            = $this->input->post('account_no');
                    $user_data['account_name']          = $this->input->post('account_name');
                    $user_data['bank_name']             = $this->input->post('bank_name');
                    $user_data['bank_branch']           = $this->input->post('bank_branch');
                    $user_data['cheque_issue_date']     = $this->input->post('cheque_issue_date');
                    $user_data['created_at']            = date('Y-m-d h:i:s');
                    
                    
                    if($this->common_model->add_data('boutique_payment_cheques', $user_data))
                    {
                        $payment_cheque_id = mysql_insert_id();
                    }
                }
                else if($this->input->post('mode_of_payment')=='paypal')
                {
                    //$user_data['id']                      = '';
                    $user_data['user_id']               = $this->input->post('user_id');
                    $user_data['transaction_id']        = $this->input->post('transaction_id');
                    $user_data['payment_status']        = $this->input->post('payment_status');
                    $user_data['paid_amount']           = $this->input->post('paid_amount');
                    $user_data['paid_currency']         = $this->input->post('paid_currency');
                    
                    //$paypal_transactions_id = $this->common_model->add_data('boutique_paypal_transactions', $user_data);
                    if($this->common_model->add_data('boutique_paypal_transactions', $user_data))
                    {
                        $paypal_transaction_id = mysql_insert_id();
                    }
                }
                
                $user_data=array();
                
                $user_data['id']                    = '';
                $user_data['product_stock_id']      = $this->input->post('product_stock_id');
                $user_data['amount']                = $this->input->post('amount');
                $user_data['mode_of_payment']       = $this->input->post('mode_of_payment');
                $user_data['payment_cheque_id']     = $payment_cheque_id;
                $user_data['paypal_transaction_id'] = $paypal_transaction_id;
                $user_data['created_at']            = date('Y-m-d h:i:s');

                //echo "<pre>";print_r($user_data);die();

                
                if ($this->common_model->add_data('boutique_general_payments', $user_data))
                    $other_payment_id = mysql_insert_id();
                //echo $other_payment_id;die();

                if ($other_payment_id > 0)
                {
                    $this->session->set_flashdata('success_message','General Payment Added Successfuly.');
                    /* redirects to list page */
                    redirect('payment/general_payment', 'refresh');
                }
                
                else
                {
                    $this->session->set_flashdata('error_message', 'Could not add the payment! Please try again later.');
                }
            }//ends adding member
            else
            {
                /* gather info */
                $update_data['amount'] = $this->input->post('amount');
                $update_data['payment_date'] = $this->input->post('payment_date');
                $update_data['modified_at']  = date('Y-m-d h:i:s');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_general_payments', $update_data))
                    $this->session->set_flashdata('success_general_payments','general payments Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_general_payments','Could not update the payment! Please try again later.');

                /* redirects to list page */
                redirect('payment/general_payment', 'refresh');
            } //end main else
        }        
        $this->template->render();
    } //ends general payments data management



	/**
     * Manage other payment.
     * Restricted for the general users.
     * 
     * @return integer. 
     */
    public function other_payment()
    {
        if( $this->session->userdata('logged_in') != true )
        {
            redirect('siteadmin', 'refresh');
        }
        
        $payment_record          = $this->common_model->query_all_data('boutique_other_payments');
        $num_of_rows           	 = count($payment_record);
        $data['num_of_payments'] = $num_of_rows;
        if ($num_of_rows > 0)
        {
			$data['table_title'] = 'Other Payment List';
			$this->template->write('title', ' Admin Panel');
		
            //starts paging configaration
            $limit_from               = $this->uri->segment(3);
            $list_start               = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                 = 10;	
            $data['all_payment']       = $this->payment_model->get_pagewise_other_payment($list_start, $list_end);
            $data['payment_result']     = $data['all_payment']['payment_afterPg']; 
            $data['payment_rownumbers'] = $data['all_payment']['payment_rows'];

            $list_config['base_url']   = base_url().'payment/other_payment/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['payment_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['payment_paging'] = $this->pagination->create_links();
			
			$this->template->write_view('main_content', 'payment/other_payment', $data, TRUE);
			$this->template->render();
            //ends paging configaration
        }//end if
		else
		{
			/* redirects to list page */
			redirect('payment/manageOtherPayment', 'refresh');
		}
    }

	/**
     * Manages advertisement information.
     * Restricted for the general users.
     * 
     * @param integer $id 
     * 
     * @return none 
     */
    public function manageOtherPayment($id = NULL)
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
        {
            redirect('siteadmin', 'refresh');
        }
        
        $this->template->write('title', 'boutique: Other Payment Information');
		
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Edit Other Payment';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $other_payment_data = $this->common_model->query_single_row_by_single_source('boutique_other_payments', 'id', $id);
            foreach ($other_payment_data as $ad)
            {
                $data['expense_name'] 			= $ad->expense_name;
                $data['amount']     			= $ad->amount;
                $data['bill_no']                = $ad->bill_no;
                $data['payment_date']       	= $ad->payment_date;
				$data['mode_of_payment'] 		= $ad->mode_of_payment;
                $data['payment_cheque_id'] 		= $ad->payment_cheque_id;
                $data['paypal_transaction_id'] 	= $ad->paypal_transaction_id;
                $data['modified_at'] 			= $ad->modified_at;
            }
			if(isset($data['payment_cheque_id']))
			{
				$cheques_data = $this->common_model->query_single_row_by_single_source('boutique_payment_cheques', 'id', $data['payment_cheque_id']);
				
				foreach ($cheques_data as $cd)
				{
					$data['account_no'] 		= $cd->account_no;
					$data['account_name'] 		= $cd->account_name;
					$data['bank_name'] 			= $cd->bank_name;
					$data['bank_branch'] 		= $cd->bank_branch;
					$data['cheque_issue_date'] 	= $cd->cheque_issue_date;
				}
			}
			
			elseif(isset($data['paypal_transaction_id']))
			{
				$paypals_data = $this->common_model->query_single_row_by_single_source('boutique_paypal_transactions', 'id', $data['paypal_transaction_id']);
				
				foreach ($paypals_data as $pd)
				{
					$data['user_id'] 		= $pd->user_id;
					$data['transaction_id'] = $pd->transaction_id;
					$data['payment_status'] = $pd->payment_status;
					$data['paid_amount'] 	= $pd->paid_amount;
					$data['paid_currency'] 	= $pd->paid_currency;
					$data['paytime'] 		= $pd->paytime;
				}
			}
			
			//echo "<pre>";print_r($data);die();
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add Other Payment';
            $data['action']     = 'add';
			
			// validation set for cheque payment selection 
			if($this->input->post('mode_of_payment')=='cheque')
			{
				$config = array(
					array('field' => 'expense_name', 		'label' => 'Expense Name', 	'rules' => 'trim|required|max_length[60]'), 
					array('field' => 'amount', 				'label' => 'Amount', 	'rules' => 'trim|required|decimal'),
					array('field' => 'payment_date', 		'label' => 'Payment Date', 	'rules' => 'trim|required|date'),
					array('field' => 'account_no', 			'label' => 'Account No', 	'rules' => 'trim|required|max_length[60]'),
					array('field' => 'account_name', 		'label' => 'Account Name', 	'rules' => 'trim|required|max_length[60]'),
					array('field' => 'bank_name', 			'label' => 'Bank Name', 	'rules' => 'trim|required|max_length[60]'),
					array('field' => 'bank_branch', 		'label' => 'Branch Name', 	'rules' => 'trim|required|max_length[60]'),
					array('field' => 'cheque_issue_date', 	'label' => 'Cheque Issue Date', 	'rules' => 'trim|required|date')
			   );
			}
			// validation for paypal transaction
			else if($this->input->post('mode_of_payment')=="paypal")
			{
				$data['paytime'] 		= $pd->paytime;
			
				$config = array(
					array('field' => 'expense_name',   'label' => 'Expense Name', 	'rules' => 'trim|required|max_length[60]'), 
					array('field' => 'amount', 		   'label' => 'Amount', 	    'rules' => 'trim|required|decimal'),
					array('field' => 'payment_date',   'label' => 'Payment Date', 	'rules' => 'trim|required|date'),
					array('field' => 'user_id', 	   'label' => 'User Id', 	    'rules' => 'trim|required|max_length[50]'),
					array('field' => 'transaction_id', 'label' => 'Transaction Id', 'rules' => 'trim|required|max_length[50]'),
					array('field' => 'payment_status', 'label' => 'Payment Status', 'rules' => 'trim|required|max_length[50]'),
					array('field' => 'paid_amount',    'label' => 'Paid Amount', 	'rules' => 'trim|required|decimal'),
					array('field' => 'paid_currency',  'label' => 'Paid Currency', 	'rules' => 'trim|required|max_length[50]'),
					array('field' => 'paytime', 	   'label' => 'Paytime', 	    'rules' => 'trim|required|date')
			   );
			}
			// validation set for cash and other payment selection 
			else
			{
				$config = array(
					array('field' => 'expense_name', 'label' => 'Expense Name', 'rules' => 'trim|required|max_length[60]'), 
					array('field' => 'amount', 		 'label' => 'Amount', 	    'rules' => 'trim|required|decimal'),
					array('field' => 'payment_date', 'label' => 'Payment Date', 'rules' => 'trim|required|date')
			   );
			}
			
			$this->form_validation->set_rules($config);
        }		
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'payment/manageOtherPayment', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
				/* adds the cheque information */
				$payment_cheque_id='';
				$paypal_transaction_id='';
				
				if($this->input->post('mode_of_payment')=='cheque')
				{
					$user_data['id']           			= '';
					$user_data['account_no']           	= $this->input->post('account_no');
					$user_data['account_name']         	= $this->input->post('account_name');
					$user_data['bank_name']           	= $this->input->post('bank_name');
					$user_data['bank_branch']           = $this->input->post('bank_branch');
					$user_data['cheque_issue_date']     = $this->input->post('cheque_issue_date');
					$user_data['created_at']   			= date('Y-m-d h:i:s');
					
					
					if($this->common_model->add_data('boutique_payment_cheques', $user_data))
					{
						$payment_cheque_id = mysql_insert_id();
					}
				}
				else if($this->input->post('mode_of_payment')=='paypal')
				{
					//$user_data['id']           			= '';
					$user_data['user_id']           	= $this->input->post('user_id');
					$user_data['transaction_id']        = $this->input->post('transaction_id');
					$user_data['payment_status']        = $this->input->post('payment_status');
					$user_data['paid_amount']           = $this->input->post('paid_amount');
					$user_data['paid_currency']     	= $this->input->post('paid_currency');
					
					//$paypal_transactions_id = $this->common_model->add_data('boutique_paypal_transactions', $user_data);
					if($this->common_model->add_data('boutique_paypal_transactions', $user_data))
					{
						$paypal_transaction_id = mysql_insert_id();
					}
				}
				
				$user_data=array();
				
				$user_data['id']           			= '';
                $user_data['expense_name'] 			= $this->input->post('expense_name');
                $user_data['amount'] 				= $this->input->post('amount');
                $user_data['bill_no']               = $this->common_model->get_unique_numeric_id('boutique_other_payments', 'bill_no');
                $user_data['payment_date'] 			= $this->input->post('payment_date');
                $user_data['mode_of_payment'] 		= $this->input->post('mode_of_payment');
                $user_data['payment_cheque_id'] 	= $payment_cheque_id;
				$user_data['paypal_transaction_id'] = $paypal_transaction_id;
				$user_data['created_at']   			= date('Y-m-d h:i:s');

                //echo "<pre>";print_r($user_data);die();

				
                if ($this->common_model->add_data('boutique_other_payments', $user_data))
                    $other_payment_id = mysql_insert_id();
                //echo $other_payment_id;die();

                if ($other_payment_id > 0)
                {
                    $this->session->set_flashdata('success_message','Other Payment Added Successfuly.');
					/* redirects to list page */
					redirect('payment/other_payment', 'refresh');
                }
				
                else
                {
                    $this->session->set_flashdata('error_message', 'Could not add the payment! Please try again later.');
                }
            }//ends adding member
            else
            {
                /* gather info */
                $update_data['amount'] = $this->input->post('amount');
                $update_data['payment_date'] = $this->input->post('payment_date');
                $update_data['modified_at']  = date('Y-m-d h:i:s');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_other_payments', $update_data))
                    $this->session->set_flashdata('success_advertisement','other payments Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_advertisement','Could not update the payment! Please try again later.');

                /* redirects to list page */
				redirect('payment/other_payment', 'refresh');
			} //end main else
        }        
        $this->template->render();
    } //ends other payments data management
	
	/**
     * Export Ticket Promotions list to Excel
     * 
     * @return none 
     */
    public function exportOtherPaymentsToExcel()
    {
		$payment_record          = $this->common_model->query_all_data('boutique_other_payments');
        $num_of_rows           	 = count($payment_record);
        
		if ($num_of_rows > 0)
        {
			$columns = array();
			$columns['field'] = array("payment_date", "expense_name", "amount", "mode_of_payment");
			$columns['title'] = array("Date", "Over Head Expenses", "Amount", "Mode of Payment");
			$columns['type']  = array("date", "", "", "", "", "");
			
			$this->common_model->exportToExcel($columns,$payment_record,'Other_Payments_List');
        }//end if
    }//end excel export
}

/* End of file payment.php */
/* Location: ./application/controllers/payment.php */