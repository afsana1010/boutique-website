<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage product-sections. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Product_section extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('product_section_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }


    /**
     * Restricted page to list section info. 
     * Bypass to the entry-form if no data found.
     * 
     * @return none 
     */
    public function index()
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
            redirect('siteadmin', 'refresh');
        
        $section_record          = $this->common_model->query_all_data('boutique_product_sections');
        $num_of_sections         = count($section_record);
        $data['num_of_sections'] = $num_of_sections;
        if ($num_of_sections > 0)
        {
            $data['table_title'] = 'Product Sections List';
            $this->template->write('title', 'Boutique Admin Panel: List of Product Sections');

            //starts paging configaration
            $limit_from               	= $this->uri->segment(3);
            $list_start               	= ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                 	= 10;	
            $data['all_section']       	= $this->product_section_model->get_pagewise($list_start, $list_end);
            $data['section_result']     = $data['all_section']['section_afterPg']; 
            $data['section_rownumbers'] = $data['all_section']['section_rows'];

            $list_config['base_url']   = base_url().'product_section/index/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['section_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['section_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'product_section/list', $data, TRUE);
            $this->template->render();
        }//end if
        
        else
            redirect('product_section/manage', 'refresh');
    }//end product listing
    
    
    /**
     * Manages section information.
     * Restricted for the general users.
     * 
     * @param integer $id 
     * 
     * @return none 
     */
    public function manage($id = NULL)
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
            redirect('siteadmin', 'refresh');    
                
        $this->template->write('title', 'Boutique: Product Section');
        
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Edit Section';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $section_data = $this->common_model->query_single_row_by_single_source('boutique_product_sections', 'id', $id);
            foreach ($section_data as $sd)
            {
                $data['name']      = $sd->name;
                $data['is_active'] = $sd->is_active;
            }
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add Section';
            $data['action']     = 'add'; 
        }
        
        $config = array(
                            array('field' => 'name', 'label' => 'Section Name', 'rules' => 'trim|required|max_length[30]')
                       );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'product_section/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
                /* adds the section */
                $section_data               = array();
                $section_data['id']         = '';
                $section_data['name']       = $this->input->post('name');
                $section_data['is_active']  = 1;
                $section_data['created_at'] = date('Y-m-d h:i:s');
                
                if ($this->common_model->add_data('boutique_product_sections', $section_data))
                   $this->session->set_flashdata('success_message','Section Added Successfuly.');
                else
                   $this->session->set_flashdata('error_message', 'Could not add the section! Please try again later.');
            }//ends adding section
            else
            {
                /* gather info */
                $update_data                 = array();
                $update_data['product_name'] = $this->input->post('product_name');
                $update_data['is_active']    = $this->input->post('is_active');
                $update_data['modified_at']  = date('Y-m-d h:i:s');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_product_sections', $update_data))
                    $this->session->set_flashdata('success_message','Section Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not update the section! Please try again later.');
            }//ends updating section
            
            /* redirects to list page */
            redirect('product_section', 'refresh');
        } //end main else


        $this->template->render();
    } //ends section data management

    /**
     * Active/Inactive a selected section.
     * Restricted for the general users.
     * 
     * @return none 
     */
    public function section_status()
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
            redirect('siteadmin', 'refresh');
        
        $oper = $this->input->post('oper');
        $id   = $this->input->post('section_id');
        
        $updated_data['modified_at'] = date('Y-m-d h:i:s');
        
        /* starts to active section */
        if ($oper == 'active') {
            $updated_data['is_active'] = 1;
            if( $this->common_model->update_data('id', $id, 'boutique_product_sections', $updated_data) == TRUE )
                $this->session->set_flashdata('success_message', ' Activated successfully');
            else
                $this->session->set_flashdata('error_message', 'Could not activate !!');
        }
        /* finishes to active section */
        
        /* starts to inactive section */
        if ($oper == 'inactive') {
            $updated_data['is_active'] = 0;
            if( $this->common_model->update_data('id', $id, 'boutique_product_sections', $updated_data) == TRUE )
                $this->session->set_flashdata('success_message', ' Disabled successfully');
            else
                $this->session->set_flashdata('error_message', 'Could not be disabled !!');
        }
        /* finishes to inactive section */
    }

}

/* End of file product_section.php */
/* Location: ./application/controllers/product_section.php */