<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Siteadmin Class 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Siteadmin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('admin_model'));
        
        if( ($this->session->userdata('logged_in') != 'true') && ($this->session->userdata('logged_in_as') != 'admin') )
        {
            $this->template->set_template('login');
            $this->template->write('title', 'Boutique Admin | Sign In');    
        }
        else
        {
            $this->template->set_template('admin');
            $this->template->write('title', 'Boutique Admin Panel');
        }
    }


    /**
     * Restricted Index page for the Siteadmin
     * 
     * @return none 
     */
    public function index()
    {
        if ($this->session->userdata('logged_in') == true)
        {
            $data = array('admin_home' => 'yes', 
                          'message_1'  => 'Content box', 
                          'message_2'  => 'This is a Content Box.');
            $this->template->write('title', 'Boutique Admin Panel');
            $this->template->write_view('main_content', 'includes/back_end/main_content', $data, true);
        } 
        else
        {
            $data = array('view_login_script'      => 'yes', 
                          'header_title'           => 'Boutique Login Panel', 
                          'admin_logo_message'     => 'Boutique Logo', 
                          'default_status_message' => 'Login to the Admin Section');
            $this->template->write_view('login_top', 'includes/back_end/login_top', $data, true);
            $this->template->write_view('login_panel', 'includes/back_end/login_panel', $data, true);
        }

        $this->template->render();
    }


    /**
     *  Admin login process
     * 
     * @return array 
     */
    public function login()
    {
        $user_email  = $this->input->post('user_email');
        $user_pass1 = $this->input->post('user_pass');

        if (!empty($user_email) && !empty($user_pass1))
        {
            $user_pass = sha1($user_pass1);
            
            $login_match = $this->admin_model->verify_login_data($user_email, $user_pass);
            if ($login_match !== false)
            {
                foreach ($login_match as $lm)
                {
                    $name = $lm->full_name;
                }

                $session_data = array('logged_in'    => 'true', 
                                      'logged_in_as' => 'admin',
                                      'name'         => $name, 
                                      'email'        => $user_email);
                $this->session->set_userdata($session_data);
                
                $data['status'] = 'success';
            } 
            else
                $data['status'] = 'failure';
        } 
        else
            $data['status'] = 'failure';
        
        echo json_encode($data);
    } //ends login


    /**
     *  Admin logout
     * 
     * @return none 
     */
    public function logout()
    {
        if ($this->session->userdata('logged_in') == 'true')
        {
            $session_data = array('logged_in'    => '',
                                  'logged_in_as' => '',
                                  'name'         => '', 
                                  'email'        => '');
            $this->session->unset_userdata($session_data);
            
            redirect('siteadmin', 'refresh');
        }
    }
        
    
    /**
     * Changes User Password
     * 
     * @return array 
     */
    function change_password()
        {
            $user_email = $this->session->userdata('email');
            $old_pass1  = $this->input->post('old_pass');
            $new_pass   = $this->input->post('new_pass');
            $conf_pass  = $this->input->post('conf_pass');
            
            if(!empty($old_pass1) && !empty($new_pass) && !empty($conf_pass))
                {
                    $old_pass = sha1($old_pass1);

                    if( $this->admin_model->verify_login_data($user_email, $old_pass) == FALSE )
                        {
                            $data['status'] = 'failure';
                            $data['message']= 'Invalid password!!';   
                        }
                    elseif( $new_pass != $conf_pass )
                        {
                            $data['status'] = 'failure';
                            $data['message']= 'Failed to confirm your new password!! Please try again.';   
                        }
                    else
                        {
                            $user_data['user_password'] = sha1($conf_pass);
                            if( $this->common_model->update_data('email_address', $user_email, 'boutique_users', $user_data) == TRUE )
                                {
                                    $data['status'] = 'success';
                                    $data['message']= 'Your password is changed to <strong>'.$conf_pass.'</strong>';
                                }
                            else
                                {
                                    $data['status'] = 'failure';
                                    $data['message']= 'Could not change your password!! Please try again later.';    
                                }
                        }    
                }
            else
                {
                    $data['status'] = 'failure';
                    $data['message']= 'Password fields should not be empty!!';
                }
            echo json_encode($data);
        }

}

/* End of file siteadmin.php */
/* Location: ./application/controllers/siteadmin.php */