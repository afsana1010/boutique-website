<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage Country Codes. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Country_code extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('country_code_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }


    /**
     * Restricted page to list category info. 
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
        
        $code_record          = $this->common_model->query_all_data('boutique_country_codes');
        $num_of_codes         = count($code_record);
        $data['num_of_codes'] = $num_of_codes;
        if ($num_of_codes > 0)
        {
            $data['table_title'] = 'List of Country Codes';
            $this->template->write('title', 'Boutique Admin Panel');

            //starts paging configaration
            $limit_from              = $this->uri->segment(3);
            $list_start              = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                = 10;	
            $data['all_code']        = $this->country_code_model->get_pagewise($list_start, $list_end);
            $data['code_result']     = $data['all_code']['code_afterPg']; 
            $data['code_rownumbers'] = $data['all_code']['code_rows'];

            $list_config['base_url']   = base_url().'country_code/index/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['code_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['code_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'country_code/list', $data, TRUE);
            $this->template->render();
        }//end if
        else
        {
            redirect('country_code/manage', 'refresh');
        }
    }//end category listing
    
    
    /**
     * Manages Country Code Information.
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
            $data['form_title'] = 'Edit Country Code';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $code_data = $this->common_model->query_single_row_by_single_source('boutique_country_codes', 'id', $id);
            foreach ($code_data as $cd)
            {
                $data['country'] = $cd->country;
                $data['code']    = $cd->code;
            }
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add Country Code';
            $data['action']     = 'add';
        }
        
        $config = array(
                            array('field' => 'country', 'label' => 'Country', 'rules' => 'trim|required|max_length[60]'),
                            array('field' => 'code',    'label' => 'Code',    'rules' => 'trim|required|max_length[6]')
                       );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'country_code/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
                /* adds the code */
                $user_data['id']         = '';
                $user_data['country'] 	 = $this->input->post('country');
                $user_data['code']       = $this->input->post('code');
                $user_data['created_at'] = date('Y-m-d h:i:s');

                $category_id = $this->common_model->add_data('boutique_country_codes', $user_data);

                if ($category_id > 0)
                    $this->session->set_flashdata('success_message','Country Code Added Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not add the code! Please try again later.');
            }//ends adding member
            else
            {
                /* gather info */
                $update_data['country'] = $this->input->post('country');
                $update_data['code']    = $this->input->post('code');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_country_codes', $update_data))
                    $this->session->set_flashdata('success_message','Country Code Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not update the code! Please try again later.');
                
            }//ends updating category
            
            /* redirects to list page */
            redirect('country_code', 'refresh');
        } //end main else


        $this->template->render();
    } //ends category data management
    
    /**
     * Delete single/multiple code.
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
        
        $code_deletion_type = $this->input->post('code_deletion_type');
        
        /* starts to delete multiple categories */
        if ($code_deletion_type == 'multiple') 
        {
            $code_id = $this->input->post('code_id');
            $c       = 0;
            for( $i = 0; $i < count($code_id); $i++ )
            {
                if( $this->common_model->delete_data('id', $code_id[$i], 'boutique_country_codes') )
                    $c++;
            }
            if( $c == 0 )
                $this->session->set_flashdata('error_message', 'Could not delete any code!!');
            
            elseif( $c == 1 )
                $this->session->set_flashdata('success_message', 'A code was deleted successfully');
            
            elseif( $c > 1 )
                $this->session->set_flashdata('success_message', 'Multiple codes were deleted successfully');
        }
        /* ends to delete multiple codes */
        
        /* starts to delete single code */
        else {
            $id = $this->input->post('single_code_id');
            if( $this->common_model->delete_data('id', $id, 'boutique_country_codes') )
                $this->session->set_flashdata('success_message', 'A code was deleted successfully');
            else
                $this->session->set_flashdata('error_message', 'Could not delete!! The code is in used');
        }
       /* ends to delete single category */ 
        
        redirect(base_url().'country_code', 'refresh');
    }

}

/* End of file country_code.php */
/* Location: ./application/controllers/country_code.php */