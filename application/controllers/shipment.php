<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage Shipment of products. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Shipment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('shipment_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }


    /**
     * Restricted page to list item-Shipment info. 
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
        
        $shipment_record          = $this->common_model->query_all_data('boutique_shipment_levels');
        $num_of_rows              = count($shipment_record);
        $data['num_of_shipments'] = $num_of_rows;
        if ($num_of_rows > 0)
        {
            $data['table_title'] = 'Item Shipment List';
            $this->template->write('title', 'Boutique Admin Panel');

            //starts paging configaration
            $limit_from                  = $this->uri->segment(3);
            $list_start                  = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                    = 10;	
            $data['all_shipment']        = $this->shipment_model->get_pagewise($list_start, $list_end);
            $data['shipment_result']     = $data['all_shipment']['shipment_afterPg']; 
            $data['shipment_rownumbers'] = $data['all_shipment']['shipment_rows'];

            $list_config['base_url']   = base_url().'shipment/index/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['shipment_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['shipment_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'shipment/list', $data, TRUE);
            $this->template->render();
        }//end if
        else
        {
            redirect('shipment/manage', 'refresh');
        }
    }//end shipment listing
    
    
    /**
     * Manages shipment information.
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
        
        $this->template->write('title', 'Boutique: Shipment Information');
        
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Edit Shipment';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $shipment_data = $this->common_model->query_single_row_by_single_source('boutique_shipment_levels', 'id', $id);
            foreach ($shipment_data as $sd)
            {
                $data['level_status_message'] = $sd->level_status_message;
            }
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add shipment';
            $data['action']     = 'add';
        }
        
        $config = array(
                            array('field' => 'level_status_message', 'label' => 'Shipment Level Status Message', 'rules' => 'trim|required|max_length[100]|is_unique[boutique_shipment_levels.level_status_message]')
                       );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'shipment/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
                
                /* adds the member */
                $user_data['id']           = '';
                $user_data['level_status_message'] = $this->input->post('level_status_message');

                $shipment_id = $this->common_model->add_data('boutique_shipment_levels', $user_data);

                if ($shipment_id > 0)
                    $this->session->set_flashdata('success_message','shipment Added Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not add the shipment! Please try again later.');
            }//ends adding member
            else
            {
                /* gather info */
                $update_data['level_status_message'] = $this->input->post('level_status_message');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_shipment_levels', $update_data))
                    $this->session->set_flashdata('success_message','shipment Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not update the shipment! Please try again later.');
                
            }//ends updating shipment
            
            /* redirects to list page */
            redirect('shipment', 'refresh');
        } //end main else


        $this->template->render();
    } //ends shipment data management
    
    /**
     * Delete single/multiple shipment.
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
        
        $shipment_deletion_type = $this->input->post('shipment_deletion_type');
        
        /* starts to delete multiple members */
        if ($shipment_deletion_type == 'multiple') {
            $shipment_id = $this->input->post('shipment_id');
            $c        = 0;
            for( $i = 0; $i < count($shipment_id); $i++ )
            {
                $id = $shipment_id[$i];

                if( $this->common_model->delete_data('id', $id, 'boutique_shipments') )
                    $c++;
            }
            if( $c == 0 )
                $this->session->set_flashdata('error_message', 'Could not delete any shipment!!');
            
            elseif( $c == 1 )
                $this->session->set_flashdata('success_message', 'A shipment was deleted successfully');
            
            elseif( $c > 1 )
                $this->session->set_flashdata('success_message', 'Multiple shipment were deleted successfully');
        }
        /* ends to delete multiple shipment */
        
        /* starts to delete single member */
        else {
            $id = $this->input->post('single_shipment_id');

            if( $this->common_model->delete_data('id', $id, 'boutique_shipments') == TRUE )
                $this->session->set_flashdata('success_message', 'A shipment was deleted successfully');
            
            else
                $this->session->set_flashdata('error_message', 'Could not delete the shipment!!');
        }
       /* ends to delete single shipment */ 
        
        redirect(base_url().'shipment', 'refresh');
    }
	
	/**
     * Restricted page to list item-Shipment info. 
     * Bypass to the entry-form if no data found.
     * 
     * @return none 
     */
    public function shipment_tracking()
    {       
        if(isset($_POST['tracking_number']))
        {
                $this->template->set_template('front');

                $bill_no					= $this->input->post('tracking_number');

                $data['table_title'] = 'Item Shipment List';
                $data['shipment_record']    = $this->shipment_model->get_all_status_against_one_bill_no($bill_no);

                $this->template->write_view('home_main_content', 'front_end/shipment/list', $data, TRUE);
                $this->template->render();
        }
        else
        {
            redirect('home', 'refresh');
        }
		
    }//end shipment listing

}

/* End of file shipment.php */
/* Location: ./application/controllers/shipment.php */