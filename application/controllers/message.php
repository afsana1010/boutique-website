<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage SMS/Email messages. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Message extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('message_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }


    /**
     * Restricted page to list all messages. 
     * Bypass to the entry-form if no data found.
     * 
     * @return none 
     */
    public function index()
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
            redirect('siteadmin', 'refresh');
        
        $message_record          = $this->common_model->query_all_data('boutique_messages');
        $num_of_rows             = count($message_record);
        $data['num_of_messages'] = $num_of_rows;
        if ($num_of_rows > 0)
        {
            $data['table_title'] = 'SMS/Email Messages';
            $this->template->write('title', 'Boutique Admin Panel');

            //starts paging configaration
            $limit_from                 = $this->uri->segment(3);
            $list_start                 = ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                   = 10;	
            $data['all_message']        = $this->message_model->get_pagewise($list_start, $list_end);
            $data['message_result']     = $data['all_message']['message_afterPg']; 
            $data['message_rownumbers'] = $data['all_message']['message_rows'];

            $list_config['base_url']    = base_url().'message/index/';
            $list_config['uri_segment'] = '3';
            $list_config['total_rows']  = $data['message_rownumbers'];
            $list_config['per_page']    = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['message_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'message/list', $data, TRUE);
            $this->template->render();
        }//end if
        else
        {
            redirect('message/manage', 'refresh');
        }
    }//end message listing
    
    
    /**
     * Manages message information.
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
        
        $this->template->write('title', 'Boutique: SMS/Email Messages');
        
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Edit Message';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $message_data = $this->common_model->query_single_row_by_single_source('boutique_messages', 'id', $id);
            foreach ($message_data as $sd)
            {
                $data['action_name']   = $sd->action_name;
                $data['message']       = $sd->message;
                $data['message_media'] = $sd->message_media;
            }
            
            $config = array(
                                array('field' => 'message', 'label' => 'Message', 'rules' => 'trim|required')
                           );
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add Message';
            $data['action']     = 'add';
            $config             = array(
                                            array('field' => 'action_name',   'label' => 'Action Name', 'rules' => 'trim|required|max_length[60]'), 
                                            array('field' => 'message',       'label' => 'Message',     'rules' => 'trim|required'), 
                                            array('field' => 'message_media', 'label' => 'Email/SMS',   'rules' => 'trim|required|bool')
                                       );
        }
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'message/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
                
                /* adds the message */
                $user_data['id']            = '';
                $user_data['action_name']   = $this->input->post('action_name');
                $user_data['message']       = $this->input->post('message');
                $user_data['message_media'] = $this->input->post('message_media');
                $user_data['created_at']    = date('Y-m-d h:i:s');

                $message_id = $this->common_model->add_data('boutique_messages', $user_data);

                if ($message_id > 0)
                    $this->session->set_flashdata('success_message','Message Added Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not add the Message! Please try again later.');
            }//ends adding member
            else
            {
                /* gather info */
                $update_data['message']      = $this->input->post('message');
                $update_data['modified_at']  = date('Y-m-d h:i:s');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_messages', $update_data))
                    $this->session->set_flashdata('success_message','Message Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not update the message! Please try again later.');
                
            }//ends updating message
            
            /* redirects to list page */
            redirect('message', 'refresh');
        } //end main else


        $this->template->render();
    } //ends message data management
    
    /**
     * Delete single/multiple message.
     * Restricted for the general users.
     * 
     * @return none 
     */
    public function delete()
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
           redirect('siteadmin', 'refresh');
        
        $message_deletion_type = $this->input->post('message_deletion_type');
        
        /* starts to delete multiple members */
        if ($message_deletion_type == 'multiple') 
        {
            $message_id = $this->input->post('message_id');
            $c          = 0;
            for( $i = 0; $i < count($message_id); $i++ )
            {
                $id = $message_id[$i];

                if( $this->common_model->delete_data('id', $id, 'boutique_messages') )
                    $c++;
            }
            if( $c == 0 )
                $this->session->set_flashdata('error_message', 'Could not delete any message!!');
            
            elseif( $c == 1 )
                $this->session->set_flashdata('success_message', 'A message was deleted successfully');
            
            elseif( $c > 1 )
                $this->session->set_flashdata('success_message', 'Multiple message were deleted successfully');
        }
        /* ends to delete multiple message */
        
        /* starts to delete single member */
        else 
        {
            $id = $this->input->post('single_message_id');

            if( $this->common_model->delete_data('id', $id, 'boutique_messages') == TRUE )
                $this->session->set_flashdata('success_message', 'A message was deleted successfully');
            
            else
                $this->session->set_flashdata('error_message', 'Could not delete the message!!');
        }
       /* ends to delete single message */ 
        
        redirect(base_url().'message', 'refresh');
    }
	

}

/* End of file message.php */
/* Location: ./application/controllers/message.php */