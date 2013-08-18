<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage product-inventory. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Inventory extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('inventory_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }


    /**
     * Restricted page to list item-inventory info. 
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
        
        $inventory_record          = $this->common_model->query_all_data('boutique_product_stocks');
        $num_of_rows           = count($inventory_record);
        $data['num_of_inventorys'] = $num_of_rows;
        if ($num_of_rows > 0)
        {
            $data['table_title'] = 'Item inventory List';
            $this->template->write('title', 'Boutique Admin Panel');

            //starts paging configaration
            $limit_from                   = $this->uri->segment(3);
            $list_start                   = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                     = 10;	
            $data['all_inventory']        = $this->inventory_model->get_pagewise($list_start, $list_end);
            $data['inventory_result']     = $data['all_inventory']['inventory_afterPg']; 
            $data['inventory_rownumbers'] = $data['all_inventory']['inventory_rows'];

            $list_config['base_url']   = base_url().'inventory/index/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['inventory_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['inventory_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'inventory/product_list', $data, TRUE);
            $this->template->render();
        }//end if
        else
        {
            redirect('inventory/manage', 'refresh');
        }
    }//end inventory listing


    /**
     * Restricted page to list item-stock.
     * 
     * @return none 
     */
    public function stock_list()
    {
        if( $this->session->userdata('logged_in') != true )
        {
            redirect('siteadmin', 'refresh');
        }
        
        $inventory_record      = $this->common_model->query_all_data('boutique_product_stocks');
        $num_of_stocks         = count($inventory_record);
        $data['num_of_stocks'] = $num_of_stocks;
        if ($num_of_stocks > 0)
        {
            $data['table_title'] = 'Item inventory List';
            $this->template->write('title', 'Boutique Admin Panel');

            //starts paging configaration
            $limit_from                   = $this->uri->segment(3);
            $list_start                   = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                     = 10;	
            $data['all_inventory']        = $this->inventory_model->get_pagewise($list_start, $list_end);
            $data['inventory_result']     = $data['all_inventory']['inventory_afterPg']; 
            $data['inventory_rownumbers'] = $data['all_inventory']['inventory_rows'];

            $list_config['base_url']   = base_url().'inventory/stock_list/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['inventory_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['inventory_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'inventory/stock_list', $data, TRUE);
            $this->template->render();
        }//end if
        else
        {
            redirect('inventory/manage', 'refresh');
        }
    }//end stock listing
    
    
    /**
     * Manages stock information.
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
        
        $this->template->write('title', 'Boutique: Stock Information');
        
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Edit Stock';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $stock_data = $this->common_model->query_single_row_by_single_source('boutique_product_stocks', 'id', $id);
            foreach ($stock_data as $sd)
            {
                $data['product_name'] = $sd->product_name;
                $data['quantity']     = $sd->quantity;
                $data['amount']       = $sd->amount;
                $data['brought_from'] = $sd->brought_from;
            }
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add Stock';
            $data['action']     = 'add';
        }
        
        $config = array(
                            array('field' => 'product_name', 'label' => 'Product Name', 'rules' => 'trim|required|max_length[60]'), 
                            array('field' => 'quantity',     'label' => 'Quantity',     'rules' => 'trim|required|is_natural_no_zero'), 
                            array('field' => 'amount',       'label' => 'Amount(SGD)',  'rules' => 'trim|required|decimal'), 
                            array('field' => 'brought_from', 'label' => 'Brought From', 'rules' => 'trim|required|max_length[60]')
                       );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'inventory/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
                
                /* adds the member */
                $user_data['id']           = '';
                $user_data['product_name'] = $this->input->post('product_name');
                $user_data['quantity']     = $this->input->post('quantity');
                $user_data['amount']       = $this->input->post('amount');
                $user_data['brought_from'] = $this->input->post('brought_from');
                $user_data['bill_no']      = $this->common_model->get_unique_numeric_id('boutique_product_stocks', 'bill_no');
                $user_data['created_at']   = date('Y-m-d h:i:s');

                $stock_id = $this->common_model->add_data('boutique_product_stocks', $user_data);

                if ($stock_id > 0)
                    $this->session->set_flashdata('success_message','Stock Added Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not add the stock! Please try again later.');
            }//ends adding member
            else
            {
                /* gather info */
                $update_data['product_name'] = $this->input->post('product_name');
                $update_data['quantity']     = $this->input->post('quantity');
                $update_data['amount']       = $this->input->post('amount');
                $update_data['brought_from'] = $this->input->post('brought_from');
                $update_data['modified_at']  = date('Y-m-d h:i:s');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_product_stocks', $update_data))
                    $this->session->set_flashdata('success_message','Stock Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not update the stock! Please try again later.');
                
            }//ends updating stock
            
            /* redirects to list page */
            redirect('product_stock', 'refresh');
        } //end main else


        $this->template->render();
    } //ends stock data management
    
    /**
     * Delete single/multiple stock.
     * Restricted for the general users.
     * 
     * @return none 
     */
    public function delete()
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
        {
            redirect('siteadmin', 'refresh');
        }
        
        $stock_deletion_type = $this->input->post('stock_deletion_type');
        
        /* starts to delete multiple members */
        if ($stock_deletion_type == 'multiple') {
            $stock_id = $this->input->post('stock_id');
            $c        = 0;
            for( $i = 0; $i < count($stock_id); $i++ )
            {
                $id = $stock_id[$i];

                if( $this->common_model->delete_data('id', $id, 'boutique_product_stocks') )
                    $c++;
            }
            if( $c == 0 )
                $this->session->set_flashdata('error_message', 'Could not delete any stock!!');
            
            elseif( $c == 1 )
                $this->session->set_flashdata('success_message', 'A stock was deleted successfully');
            
            elseif( $c > 1 )
                $this->session->set_flashdata('success_message', 'Multiple stock were deleted successfully');
        }
        /* ends to delete multiple stock */
        
        /* starts to delete single member */
        else {
            $id = $this->input->post('single_stock_id');

            if( $this->common_model->delete_data('id', $id, 'boutique_product_stocks') == TRUE )
                $this->session->set_flashdata('success_message', 'A stock was deleted successfully');
            
            else
                $this->session->set_flashdata('error_message', 'Could not delete the stock!!');
        }
       /* ends to delete single stock */ 
        
        redirect(base_url().'inventory', 'refresh');
    }
}

/* End of file inventory.php */
/* Location: ./application/controllers/inventory.php */