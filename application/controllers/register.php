<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage register of products. 
 * 
 * @author Afsana Rahman Snigdha <afsana101083@gmail.com>
 */
class Register extends CI_Controller
{
    var $CI;
    
    public function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
        $data     = array();
        $this->load->model(array('register_model','product_model', 'message_model'));
    }

    /**
     * Manages register information.
     * Restricted for the general users.
     * 
     * @param integer $id 
     * 
     * @return none 
     */
    public function index()
    {
        $this->template->write('title', 'Member Registration Form');
        
        /* otherwise, config validation to add data */
        $data['country_codes'] = $this->common_model->query_sorted_data('boutique_country_codes', 'country');
        $data['form_title']    = 'Member Registration';
        $data['action']        = 'add';
        
        $config = array(
                            array('field' => 'full_name', 	  'label' => 'Name', 		  'rules' => 'trim|required|max_length[60]'), 
                            array('field' => 'email_address',     'label' => 'Email',     	  'rules' => 'trim|required'), 
                            array('field' => 'mobile_no',         'label' => 'Mobile No',     	  'rules' => 'trim|required'), 
                            array('field' => 'residence_address', 'label' => 'Residence Address', 'rules' => 'trim|required')
                       );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('home_main_content', 'front_end/register/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */

            $activation_code = $this->common_model->get_unique_numeric_id('boutique_temporary_activation_codes', 'activation_code', true);
            $email        	= $this->input->post('email_address');
            /* adds the member */
            $user_full_name                                     = $this->input->post('full_name');
            $user_email                                         = $this->input->post('email_address');
            $country_code_id                                    = $this->input->post('country_code_id');
            $country_code                                       = $this->common_model->query_single_data('boutique_country_codes', 'id', $country_code_id, 'code');
            $mobile_no                                          = $this->input->post('mobile_no');
            $user_data['id']                                    = '';
            $user_data['full_name']                             = $user_full_name;
            $user_data['user_password']                         = $activation_code;
            $user_data['email_address']                         = $user_email;
            $user_data['mobile_no']     						= $mobile_no;
            $user_data['residence_address']     				= $this->input->post('residence_address');
            $user_data['office_address']                        = $this->input->post('office_address');
            $user_data['country_code_id']                       = $country_code_id;
            $user_data['is_residence_preferred_delivery_place'] = $this->input->post('is_residence_preferred_delivery_place');
            $user_data['is_admin']                              = 0;
            $user_data['is_active']     			= 0;
            $user_data['created_at']                            = date('Y-m-d h:i:s');

            $register_id = $this->common_model->add_data('boutique_users', $user_data);

            if ($register_id > 0) // member is added
            {
                    //stores user's activation code
                    $code_data['id']              = '';
                    $code_data['user_email']      = $user_email;
                    $code_data['activation_code'] = $activation_code;
                    $this->common_model->add_data('boutique_temporary_activation_codes', $code_data);
                    
                    
                    //gathers all necessary SMS & Email messages
                    $msg_greeting = $this->common_model->query_single_data('boutique_messages', 'action_name', 'START GREETING', 'message');
                    $msg_greeting = preg_replace("/NAME/", $user_full_name, $msg_greeting);
                    
                    $msg_ending = $this->common_model->query_single_data('boutique_messages', 'action_name', 'END GREETING', 'message');
                    
                    $msg_email = $this->common_model->query_single_data('boutique_messages', 'action_name', 'ACCOUNT ACTIVATION', 'message');
                    $msg_email = preg_replace("/COMPANY/", 'Boutique', $msg_email);
                    
                    $msg_sms = $this->common_model->query_single_data('boutique_messages', 'action_name', 'SMS 2FA', 'message');
                    $msg_sms = preg_replace("/2FA/", $activation_code, $msg_sms);
                    //ends gathering messages
                    
                    // performs SMS to the user
                    $sms = $msg_greeting . "\r\n" . $msg_sms . "\r\n" . $msg_ending;
                    if ($this->message_model->process_sms_call($country_code, $mobile_no, $sms))  // SMS sent 
                    {
                        // loads email lib and email results
                        $masked_email  = preg_replace("/@/", 'AT', $user_email);
                        $email_message = $msg_greeting . "\n" . $msg_email . "\n" . base_url() . "register/activate_account/" . $masked_email . "\n\n" . $msg_ending;
                        $this->load->library('email');
                        $this->email->to($user_email);
                        $this->email->from($this->CI->config->item('sender_email'), $this->CI->config->item('sender_name'));
                        $this->email->subject('Member Registration at Boutique');
                        $this->email->message($email_message);	
                        if ($this->email->send()) // Email sent 
                        {
                            $data['form_title']      = 'Member Login Panel';
                            $data['action']          = 'login';
                            $data['success']         = 'success';
                            $data['success_message'] = 'Please checkout your SMS and Email boxes to get the instructions to activate your account.';
                        }
                    }
                    else
                    {
                        $data['form_title']    = 'Member Registration';
                        $data['action']        = 'add';
                        $data['error']         = 'error';
                        $data['error_message'] = "System failed to process your registration!! Don't worry, contact with us so that we can take some immediate steps.";
                    }
            }
            else
            {
                    $data['form_title']    = 'Member Registration';
                    $data['action']        = 'add';
                    $data['error']         = 'error';
                    $data['error_message'] = 'Could not register successfully! Please try again later.';                    
            }
            
            $this->template->write_view('home_main_content', 'front_end/register/registration_status', $data, true);
            
        } //end main else

        $this->template->render();
    } //ends register data management
    
    
    /**
     * Activates User Account.
     * @param string
     * 
     * @return none 
     */
    function activate_account($user_email)
    {
        $data['user_email'] = $user_email;
        $user_email         = preg_replace("/AT/", '@', $user_email);
        $check_user         = $this->common_model->num_of_data("boutique_temporary_activation_codes", "WHERE user_email='" . $user_email . "' LIMIT 1");
        
        if ($check_user) // user found
        {
            $this->template->write('title', 'Member Registration');
            $data['form_title'] = 'Member Activation';
            $config             = array(
                                            array('field' => 'activation_code', 'label' => 'Activation Code', 'rules' => 'trim|required|min_length[4]|max_length[4]')
                                       );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == false)
            {
                /* Show the form */
                $this->template->write_view('home_main_content', 'front_end/register/activate_account', $data, TRUE);
            }
            else
            {
                $code           = $this->input->post('activation_code');
                $validate_user  = $this->common_model->num_of_data("boutique_temporary_activation_codes", "WHERE user_email='" . $user_email . "' AND activation_code='" . $code . "' LIMIT 1");
                if ($validate_user) //user verified
                {
                    /* activates user */
                    $pass                       = substr(sha1(str_shuffle($user_email)),0,5);
                    $user_password              = sha1($pass);
                    $user_data['user_password'] = $user_password;
                    $user_data['is_active']     = 1;
                    if ($this->common_model->update_data('email_address', $user_email, 'boutique_users', $user_data))
                    {
                        $this->common_model->delete_data('user_email', $user_email, 'boutique_temporary_activation_codes');
                        $data['success']         = 'success';
                        $data['success_message'] = 'Congratulations!! Your account is activated now. You can login with the email: '.$user_email.' and passwod : '.$pass;
                    }
                }
                else
                {
                    $data['warning']         = 'warning';
                    $data['warning_message'] = 'Invalid Code!! Try again.';
                }
            }
        }
        else // user not found
        {
            $this->template->write('title', 'Unauthorised Access');
            $data['form_title']    = 'Member Registration';
            $data['error']         = 'error';
            $data['error_message'] = 'You are not authorized to visit this section!!';
        }
        
        $this->template->write_view('home_main_content', 'front_end/register/activate_account', $data, TRUE);
        $this->template->render();
    }
    
	
    /**
     * Manages login information.
     * 
     * @return none 
     */
    public function login()
    {
        $this->template->write('title', 'Member Login Form');       
        
        /* otherwise, config validation to add data */
        $data['form_title'] = 'Login';
        $data['action']     = 'login';
        
        $config = array(
                            array('field' => 'user_password', 'label' => 'Password', 'rules' => 'trim|required'), 
                            array('field' => 'email_address', 'label' => 'Email',    'rules' => 'trim|required|valid_email|max_length[80]')
                       );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('home_main_content', 'front_end/register/login', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            $email         = $this->input->post('email_address');
            $user_password = $this->input->post('user_password');

            $register_id = $this->register_model->verify_user_login('boutique_users', $email, $user_password);

            if ($register_id > 0)
            {
                $data['form_title']      = 'Member Page';
                $data['action']          = 'login';
                $data['success']         = 'success';
                $data['success_message'] = 'You Have Successfuly Login.';
                if(isset($_POST['previously_browse_page']))
                {
                    $data['previously_browse_page']=$this->input->post('previously_browse_page');
                }

                $user_info = $this->register_model->logged_in_user_info('boutique_users', $email, $user_password);

                foreach($user_info as $ud)
                {
                    $user_id   = $ud->id;
                    $user_name = $ud->full_name;
                }
                
                $this->product_model->delete_old_orders($user_id);

                $session_data = array('logged_in_as' => 'user',
                                      'logged_in'    => 'true',
                                      'user_id'      => $user_id,
                                      'name'         => $user_name,
                                      'email'        => $email
                                      );
										
                $this->session->set_userdata($session_data);
				
                /* redirects to register page */
                $this->template->set_template('front');

                if(isset($_POST['previously_browse_page']))
                {
                    redirect($this->input->post('previously_browse_page'), 'refresh');
                }
                else
                {
                    $user_id            = $this->session->userdata('user_id');
                    $data['user_order'] = $this->product_model->user_order_info($user_id);
                    $this->template->write_view('home_main_content', 'front_end/register/member_page', $data, true);
                }
            }
            else
            {
                $data['form_title']    = 'Member login Panel';
                $data['action']        = 'login';
                $data['error']         = 'error';
                $data['error_message'] ='Invalid email or password! Please try again later.';

                /* redirects to register page */
                $this->template->write_view('home_main_content', 'front_end/register/login', $data, true);
            }           
            
        } //end main else

        $this->template->render();
    } //ends register data management
 
   /**
    * Member logout Page.
    * 
    * @return none 
    */
    public function logout()
    {
        $this->session->sess_destroy();
		
        redirect('home', 'refresh');
    }
    
   /**
    * Creates New Password if forgotten
    * 
    * @return none 
    */
    public function forgot_password()
    {
        $this->template->write('title', 'Member Forgets Password');
        $data['form_title'] = 'Member Forgets Password';
        $config             = array(
                                        array('field' => 'email_address', 'label' => 'Email Address', 'rules' => 'trim|required|max_length[80]')
                                   );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('home_main_content', 'front_end/register/forgot_password', $data, TRUE);
        }
        else
        {
            $email_address = $this->input->post('email_address');
            $validate_user = $this->common_model->num_of_data("boutique_users", "WHERE email_address='" . $email_address . "'");
            if ($validate_user) //user verified
            {
                /* reset password */
                $pass                       = substr(sha1(str_shuffle($email_address)),0,5);
                $user_password              = sha1($pass);
                $user_data['user_password'] = $user_password;
                if ($this->common_model->update_data('email_address', $email_address, 'boutique_users', $user_data))
                {
                    $data['success']         = 'success';
                    $data['success_message'] = 'Your password is reset it is now '.$pass;
                }
            }
            else
            {
                $data['warning']         = 'warning';
                $data['warning_message'] = 'Invalid Email Address!! Try again.';
            }
        }
        
        $this->template->write_view('home_main_content', 'front_end/register/forgot_password', $data, TRUE);
        $this->template->render();
    }
}

/* End of file register.php */
/* Location: ./application/controllers/register.php */