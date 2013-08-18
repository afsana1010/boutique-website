<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage site-members. 
 * Also contains memer's registration and authentication process. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Member extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('member_model','product_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }


    /**
     * Restricted page to list existing members other than admin info. 
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
        
        $member_record          = $this->common_model->query_all_data('boutique_users');
        $num_of_members         = count($member_record);
        $data['num_of_members'] = $num_of_members;
        if ($num_of_members > 1) /* Get the members excluding the one that holds the admin */
        {
            $data['table_title'] = 'Member List';
            $this->template->write('title', 'Boutique Admin Panel');

            //starts paging configaration
            $limit_from                = $this->uri->segment(3);
            $list_start                = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                  = 10;	
            $data['all_member']        = $this->member_model->get_pagewise($list_start, $list_end);
            $data['member_result']     = $data['all_member']['member_afterPg']; 
            $data['member_rownumbers'] = $data['all_member']['member_rows'];

            $list_config['base_url']   = base_url().'member/index/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['member_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['member_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'member/list', $data, TRUE);
            $this->template->render();
        }//end if
        else
        {
            redirect('member/manage', 'refresh');
        }
    }//end members' listing
    
    
    /**
     * Manages member information.
     * Restricted for the general users from updating data.
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
        
        $this->template->write('title', 'Boutique: Member Information');
        
        $data['country_codes'] = $this->common_model->query_sorted_data('boutique_country_codes', 'country');
        
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Edit Member';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $member_data = $this->common_model->query_single_row_by_single_source('boutique_users', 'id', $id);
            foreach ($member_data as $md)
            {
                $data['full_name']                             = $md->full_name;
                $data['email_address']                         = $md->email_address;
                $data['mobile_no']                             = $md->mobile_no;
                $data['residence_address']                     = $md->residence_address;
                $data['office_address']                        = $md->office_address;
                $data['country_code_id']                       = $md->country_code_id;
                $data['is_residence_preferred_delivery_place'] = $md->is_residence_preferred_delivery_place;
            }
            
            $config = array(
                                array('field' => 'full_name',         'label' => 'Full Name',         'rules' => 'trim|required|max_length[100]'), 
                                array('field' => 'email_address',     'label' => 'Email Address',     'rules' => 'trim|required|valid_email|max_length[80]'), 
                                array('field' => 'mobile_no',         'label' => 'Mobile No',         'rules' => 'trim|max_length[100]|required'), 
                                array('field' => 'residence_address', 'label' => 'Residence Address', 'rules' => 'trim|required')
                           );
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add Member';
            $data['action']     = 'add';
            
            $this->form_validation->set_message('is_unique','The %s you provided is not acceeptable. Please try for another one.');
            $config = array(
                                array('field' => 'full_name',         'label' => 'Full Name',         'rules' => 'trim|required|max_length[100]'), 
                                array('field' => 'email_address',     'label' => 'Email Address',     'rules' => 'trim|required|valid_email|max_length[80]|is_unique[boutique_users.email_address]'), 
                                array('field' => 'user_password',     'label' => 'Password',          'rules' => 'trim|required|min_length[5]|max_length[100]|matches[password_conf]'), 
                                array('field' => 'password_conf',     'label' => 'Confirm Password',  'rules' => 'trim|required'),
                                array('field' => 'mobile_no',         'label' => 'Mobile No',         'rules' => 'trim|max_length[100]|required'), 
                                array('field' => 'residence_address', 'label' => 'Residence Address', 'rules' => 'trim|required')
                            );
        }
        
        $this->form_validation->set_rules($config);

        $data['form_title'] = 'Member Information';
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'member/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
                /* adds the member */
                $user_data['id']                                    = '';
                $user_data['full_name']                             = $this->input->post('full_name');
                $user_data['user_password']                         = sha1($this->input->post('user_password'));
                $user_data['email_address']                         = $this->input->post('email_address');
                $user_data['mobile_no']                             = $this->input->post('mobile_no');
                $user_data['residence_address']                     = $this->input->post('residence_address');
                $user_data['office_address']                        = $this->input->post('office_address');
                $user_data['country_code_id']                       = $this->input->post('country_code_id');
                $user_data['is_residence_preferred_delivery_place'] = $this->input->post('is_residence_preferred_delivery_place');
                $user_data['is_admin']                              = 0;
                $user_data['is_active']                             = 1;
                $user_data['created_at']                            = date('Y-m-d h:i:s');

                $user_id = $this->common_model->add_data('boutique_users', $user_data);

                if ($user_id > 0)
                    $this->session->set_flashdata('success_message','Member Added Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not add the member! Please try again later.');
            }//ends adding member
            else
            {
                /* updates member info */
                $update_info = false;
                
                /* starts checking email address */
                $new_email = $this->input->post('email_address');
                $old_email = $this->common_model->query_single_data('boutique_users', 'id', $id, 'email_address'); 
                if ($new_email != $old_email)
                {
                    $check_duplicate_email = $this->common_model->query_single_row_by_single_source('boutique_users', 'email_address', $new_email);
                    if (count($check_duplicate_email) > 0)
                        $this->session->set_flashdata('error_message','The email address you provided not acceptable.');
                    else
                        $update_data['email_address'] = $new_email;
                }
                /* ends checking email address */
                
                /* starts checking password */
                if ($this->input->post('change_password'))
                {
                    if ($this->input->post('change_password') == 'yes')
                    {
                        $new_password  = $this->input->post('user_password');
                        $conf_password = $this->input->post('password_conf');
                        if (empty ($new_password) || (strlen($new_password) < 5))
                            $this->session->set_flashdata('error_message','Insufficient password data; could not be stored');
                        elseif ($conf_password != $new_password)
                            $this->session->set_flashdata('error_message','Could not confirm the new password');
                        else
                            $update_data['user_password'] = sha1($new_password);
                    }
                }
                /* ends checking password */
                
                /* gather other info */
                $update_data['full_name']                             = $this->input->post('full_name');
                $update_data['mobile_no']                             = $this->input->post('mobile_no');
                $update_data['residence_address']                     = $this->input->post('residence_address');
                $update_data['office_address']                        = $this->input->post('office_address');
                $update_data['country_code_id']                       = $this->input->post('country_code_id');
                $update_data['is_residence_preferred_delivery_place'] = $this->input->post('is_residence_preferred_delivery_place');
                $update_data['modified_at']                           = date('Y-m-d h:i:s');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_users', $update_data))
                    $this->session->set_flashdata('success_message','Member Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not update the member! Please try again later.');
                
            }//ends updating member
            
            /* redirects to list page */
            redirect('member', 'refresh');
        } //end main else


        $this->template->render();
    } //ends member's data management
    
    /**
     * Delete single/multiple members.
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
        
        //$oper = $this->input->post('oper');
        $member_deletion_type = $this->input->post('member_deletion_type');
        
        /* starts to delete multiple members */
        if ($member_deletion_type == 'multiple') {
            $member_id = $this->input->post('member_id');
            $c = 0;
            for( $i = 0; $i < count($member_id); $i++ )
            {
                $id = $member_id[$i];

                if( $this->common_model->delete_data('id', $id, 'boutique_users') )
                    $c++;
            }
            if( $c == 0 )
                $this->session->set_flashdata('error_message', 'Could not delete any member!!');
            
            elseif( $c == 1 )
                $this->session->set_flashdata('success_message', 'A member was deleted successfully');
            
            elseif( $c > 1 )
                $this->session->set_flashdata('success_message', 'Multiple members were deleted successfully');
        }
        /* ends to delete multiple members */
        
        /* starts to delete single member */
        else {
            $id = $this->input->post('single_member_id');

            if( $this->common_model->delete_data('id', $id, 'boutique_users') == TRUE )
                $this->session->set_flashdata('success_message', 'A member was deleted successfully');
            
            else
                $this->session->set_flashdata('error_message', 'Could not delete the member!!');
        }
       /* ends to delete single member */ 
        
        redirect(base_url().'member/', 'refresh');
    }
    
    /**
     * Active/Inactive a selected member.
     * Restricted for the general users.
     * 
     * @return none 
     */
    public function member_status()
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
        {
            redirect('siteadmin', 'refresh');
        }
        
        $oper = $this->input->post('oper');
        $id   = $this->input->post('member_id');
        $name = $this->common_model->query_single_data('boutique_users','id',$id,'full_name');
        
        $updated_data['modified_at'] = date('Y-m-d h:i:s');
        
        /* starts to active members */
        if ($oper == 'active') {
            $updated_data['is_active'] = 1;
            if( $this->common_model->update_data('id', $id, 'boutique_users', $updated_data) == TRUE )
                $this->session->set_flashdata('success_message', $name . ' was activated successfully');
            else
                $this->session->set_flashdata('error_message', 'Could not activate ' . $name . '!!');
        }
        /* finishes to active members */
        
        /* starts to inactive members */
        if ($oper == 'inactive') {
            $updated_data['is_active'] = 0;
            if( $this->common_model->update_data('id', $id, 'boutique_users', $updated_data) == TRUE )
                $this->session->set_flashdata('success_message', $name . ' was disabled successfully');
            else
                $this->session->set_flashdata('error_message', 'Could not disable ' . $name . '!!');
        }
        /* finishes to inactive members */
    }
    
    /**
     * Member Page.
     * 
     * @return none 
     */
    public function member_page()
    {
        $data['form_title'] = 'Member Page';
        $data['action']     = 'member_page';
		
        if($this->session->userdata('logged_in'))
        {
            $user_id            = $this->session->userdata('user_id');
            $data['user_order'] = $this->product_model->user_order_info($user_id);
        }

        else
        {
            $data['user_order_empty']="There is no order placed by you";
        }
		
        $this->template->write_view('home_main_content', 'front_end/register/member_page', $data, true);
        $this->template->render();
    }
    /**
     * Member Profile Page.
     * 
     * @return none 
     */
    public function member_profile_page()
    {
        $data['form_title'] = 'Member Profile Page';
        $data['action']     = 'member_profile_page';
		
		$data['country_codes'] = $this->common_model->query_sorted_data('boutique_country_codes', 'country');
        if($this->session->userdata('logged_in') && $this->input->post('user_id')=="")
        {
            $user_id            = $this->session->userdata('user_id');
            //$data['user_order'] = $this->product_model->user_order_info($user_id);
			
			$member_data = $this->common_model->query_single_row_by_single_source('boutique_users', 'id', $user_id);
            foreach ($member_data as $md)
            {
				$data['user_id']                               = $user_id;
				$data['full_name']                             = $md->full_name;
                $data['email_address']                         = $md->email_address;
                $data['mobile_no']                             = $md->mobile_no;
                $data['residence_address']                     = $md->residence_address;
                $data['office_address']                        = $md->office_address;
                $data['country_code_id']                       = $md->country_code_id;
                $data['is_residence_preferred_delivery_place'] = $md->is_residence_preferred_delivery_place;
            }
			
			$this->template->write_view('home_main_content', 'front_end/register/member_profile_page', $data, true);
			$this->template->render();
        }
		elseif($this->input->post('user_id')!="")
            {
                /* updates member info */
                
				$update_info = false;
                $id = $this->input->post('user_id');
                /* starts checking email address */
                $new_email = $this->input->post('email_address');
                $old_email = $this->common_model->query_single_data('boutique_users', 'id', $id, 'email_address'); 
                if ($new_email != $old_email)
                {
                    $check_duplicate_email = $this->common_model->query_single_row_by_single_source('boutique_users', 'email_address', $new_email);
                    if (count($check_duplicate_email) > 0)
                        $this->session->set_flashdata('error_message','The email address you provided not acceptable.');
                    else
                        $update_data['email_address'] = $new_email;
                }
                /* ends checking email address */
                
                /* starts checking password */
                if ($this->input->post('change_password'))
                {
                    if ($this->input->post('change_password') == 'yes')
                    {
                        $new_password  = $this->input->post('user_password');
                        $conf_password = $this->input->post('password_conf');
                        if (empty ($new_password) || (strlen($new_password) < 5))
                            $this->session->set_flashdata('error_message','Insufficient password data; could not be stored');
                        elseif ($conf_password != $new_password)
                            $this->session->set_flashdata('error_message','Could not confirm the new password');
                        else
                            $update_data['user_password'] = sha1($new_password);
                    }
                }
                /* ends checking password */
                
                /* gather other info */
                $update_data['full_name']                             = $this->input->post('full_name');
                $update_data['mobile_no']                             = $this->input->post('mobile_no');
                $update_data['residence_address']                     = $this->input->post('residence_address');
                $update_data['office_address']                        = $this->input->post('office_address');
                $update_data['country_code_id']                       = $this->input->post('country_code_id');
                $update_data['is_residence_preferred_delivery_place'] = $this->input->post('is_residence_preferred_delivery_place');
                $update_data['modified_at']                           = date('Y-m-d h:i:s');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_users', $update_data))
                    $this->session->set_flashdata('success_message','Your Profile Data Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not update the profile data! Please try again later.');
                
				    $user_id            = $this->session->userdata('user_id');
					//$data['user_order'] = $this->product_model->user_order_info($user_id);
					
					$member_data = $this->common_model->query_single_row_by_single_source('boutique_users', 'id', $user_id);
					foreach ($member_data as $md)
					{
						$data['user_id']                               = $user_id;
						$data['full_name']                             = $md->full_name;
						$data['email_address']                         = $md->email_address;
						$data['mobile_no']                             = $md->mobile_no;
						$data['residence_address']                     = $md->residence_address;
						$data['office_address']                        = $md->office_address;
						$data['country_code_id']                       = $md->country_code_id;
						$data['is_residence_preferred_delivery_place'] = $md->is_residence_preferred_delivery_place;
					}
					
					$this->template->write_view('home_main_content', 'front_end/register/member_profile_page', $data, true);
					$this->template->render();
            }//ends updating profile data
        else
        {
            $data['user_order_empty']="There is no order placed by you";
			$this->template->write_view('home_main_content', 'front_end/register/member_profile_page', $data, true);
			$this->template->render();
        }
    }
}

/* End of file member.php */
/* Location: ./application/controllers/member.php */