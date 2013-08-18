<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage categories. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Category extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('category_model'));
        
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
        
        $category_record           = $this->common_model->query_all_data('boutique_categories');
        $num_of_categories         = count($category_record);
        $data['num_of_categories'] = $num_of_categories;
        if ($num_of_categories > 0)
        {
            $data['table_title'] = 'List of Categories';
            $this->template->write('title', 'Boutique Admin Panel');

            //starts paging configaration
            $limit_from               = $this->uri->segment(3);
            $list_start               = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                 = 10;	
            $data['all_category']       = $this->category_model->get_pagewise($list_start, $list_end);
            $data['category_result']     = $data['all_category']['category_afterPg']; 
            $data['category_rownumbers'] = $data['all_category']['category_rows'];

            $list_config['base_url']   = base_url().'category/index/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['category_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['category_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'category/list', $data, TRUE);
            $this->template->render();
        }//end if
        else
        {
            redirect('category/manage', 'refresh');
        }
    }//end category listing
    
    
    /**
     * Manages category information.
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
        
        $data['sections'] = $this->common_model->query_all_data('boutique_product_sections');
        
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Edit Category';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $category_data = $this->common_model->query_single_row_by_single_source('boutique_categories', 'id', $id);
            foreach ($category_data as $sd)
            {
                $data['name']               = $sd->name;
                $data['product_section_id'] = $sd->product_section_id;
            }
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add Category';
            $data['action']     = 'add';
        }
        
        $config = array(
                            array('field' => 'name', 'label' => 'Category Name', 'rules' => 'trim|required|max_length[100]')
                       );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'category/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
                
                /* adds the category */
                $user_data['id']                 = '';
                $user_data['name']               = $this->input->post('name');
                $user_data['product_section_id'] = $this->input->post('product_section_id');
                $user_data['created_at']         = date('Y-m-d h:i:s');

                $category_id = $this->common_model->add_data('boutique_categories', $user_data);

                if ($category_id > 0)
                    $this->session->set_flashdata('success_message','Category Added Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not add the category! Please try again later.');
            }//ends adding category
            else
            {
                /* gather info */
                $update_data['name']               = $this->input->post('name');
                $update_data['product_section_id'] = $this->input->post('product_section_id');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_categories', $update_data))
                    $this->session->set_flashdata('success_message','Category Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not update the category! Please try again later.');
                
            }//ends updating category
            
            /* redirects to list page */
            redirect('category', 'refresh');
        } //end main else


        $this->template->render();
    } //ends category data management
    
    /**
     * Delete single/multiple category.
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
        
        $category_deletion_type = $this->input->post('category_deletion_type');
        
        /* starts to delete multiple categories */
        if ($category_deletion_type == 'multiple') 
        {
            $category_id = $this->input->post('category_id');
            $c        	 = 0;
            for( $i = 0; $i < count($category_id); $i++ )
            {
                $id = $category_id[$i];

                $check_category = $this->common_model->query_single_row_by_single_source('boutique_products', 'category_id', $id);
                if (count($check_category) == 0)
                {
                    if( $this->common_model->delete_data('id', $id, 'boutique_categories') )
                        $c++;
                }
            }
            if( $c == 0 )
                $this->session->set_flashdata('error_message', 'Could not delete any category!!');
            
            elseif( $c == 1 )
                $this->session->set_flashdata('success_message', 'A category was deleted successfully');
            
            elseif( $c > 1 )
                $this->session->set_flashdata('success_message', 'Multiple categories were deleted successfully');
        }
        /* ends to delete multiple category */
        
        /* starts to delete single category */
        else {
            $id             = $this->input->post('single_category_id');
            $check_category = $this->common_model->query_single_row_by_single_source('boutique_products', 'category_id', $id);
            if (count($check_category) == 0)
            {
                if( $this->common_model->delete_data('id', $id, 'boutique_categories') )
                    $this->session->set_flashdata('success_message', 'A category was deleted successfully');
                else
                    $this->session->set_flashdata('error_message', 'Could not delete!! The category is in used');
            }
            else
                $this->session->set_flashdata('error_message', 'Could not delete the category!!');
        }
       /* ends to delete single category */ 
        
        redirect(base_url().'category', 'refresh');
    }

}

/* End of file category.php */
/* Location: ./application/controllers/category.php */