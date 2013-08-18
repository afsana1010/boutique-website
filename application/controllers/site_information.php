<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Displays Company's Static Informations and its vision. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Site_information extends CI_Controller
{
    var $CI;
    
    public function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
        $data = array();
    }

    public function index()
    {
        
    }


    /**
     * Displays About Us page.
     * 
     * @return none 
     */
    public function about_us()
    {
        $this->template->write('title', 'Boutique: About Us');       
        
        $data['company_info'] = '';
        
        $this->template->write_view('home_main_content', 'front_end/site_information/about_us', $data, TRUE);
        $this->template->render();
    }


    /**
     * Displays Payment Information page.
     * 
     * @return none 
     */
    public function payment()
    {
        $this->template->write('title', 'Boutique: Payment Information');       
        
        $data['payment_info'] = '';
        
        $this->template->write_view('home_main_content', 'front_end/site_information/payment', $data, TRUE);
        $this->template->render();
    }


    /**
     * Displays Delivery Information page.
     * 
     * @return none 
     */
    public function delivery()
    {
        $this->template->write('title', 'Boutique: Shipment Delivery');       
        
        $data['delivery_info'] = '';
        
        $this->template->write_view('home_main_content', 'front_end/site_information/delivery', $data, TRUE);
        $this->template->render();
    }


    /**
     * Displays Measurement Information page.
     * 
     * @return none 
     */
    public function how_to_measure()
    {
        $this->template->write('title', 'Boutique: How to Measure?');       
        
        $data['measuring_info'] = '';
        
        $this->template->write_view('home_main_content', 'front_end/site_information/measuring', $data, TRUE);
        $this->template->render();
    }


    /**
     * Displays Terms & Condition Information page.
     * 
     * @return none 
     */
    public function terms_and_condition()
    {
        $this->template->write('title', 'Boutique: Terms & Conditions');       
        
        $data['terms_info'] = '';
        
        $this->template->write_view('home_main_content', 'front_end/site_information/terms', $data, TRUE);
        $this->template->render();
    }


    /**
     * Displays Contact Information page.
     * 
     * @return none 
     */
    public function contact_us()
    {
        $this->template->write('title', 'Boutique: Contact Us');       
        
        $data['form_title'] = 'Contact Us';
        
        $config = array(
                            array('field' => 'from_email', 'label' => 'E-mail address', 'rules' => 'trim|required|valid_email|max_length[80]'), 
                            array('field' => 'bill_no',    'label' => 'Order ID',       'rules' => 'trim|required'),
                            array('field' => 'message',    'label' => 'Message',        'rules' => 'trim|required')
                       );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
        } //end main if
        else
        {
            /* gather info */
            $from_email = $this->input->post('from_email');
            $bill_no    = $this->input->post('bill_no');
            $check_bill = $this->common_model->num_of_data("boutique_user_orders", "WHERE bill_no=" . $bill_no . "");
            if ($check_bill)
            {
                $subject          = $this->input->post('subject');
                $message          = $this->input->post('message');
                $to_email         = ($subject == 'Customer Service') ? $this->CI->config->item('customer_care_email') : $this->CI->config->item('webmaster_email');
                $found_attachment = false;
                
                $this->load->library('email');
                    
                //sends email to the customer
                $body = "Hello,\n";
                $body .= $message;
                $body .= "Regards,\n";
                $body .= "A Visitor from Boutique\n";

                $this->email->to($to_email);
                $this->email->from($from_email, 'Boutique Visitor');
                $this->email->subject('User Feedback from Boutique to ' . $subject);
                $this->email->message($body);
                if(!empty($_FILES['userfile']['name'])) // attachment found
                {
                    // upload attachment [if submitted]
                    $config['upload_path']   = 'assets/uploads/temporary_email_attachment/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']      = '1024'; //1 MB
                    $config['max_width']     = '1024';
                    $config['max_height']    = '768';

                    $this->load->library('upload', $config);

                    if ( $this->upload->do_upload())
                    {
                        $file_data        = $this->upload->data();
                        $attachment       = base_url() . 'assets/uploads/temporary_email_attachment/' . $file_data['file_name'];
                        $found_attachment = true;
                        $this->email->attach($attachment);
                    }
                }//ends checking attachment
                    
                if ($this->email->send()) //email sent
                {
                    if ($found_attachment)
                        @unlink(realpath('./assets/uploads/temporary_email_attachment/' . $file_data['file_name']));
                    
                    $this->session->set_flashdata('success_message', 'Your message is sent to our ' . $subject);
                }
                else
                    $this->session->set_flashdata('error_message', 'System failed to send your feedback!! Please try again later');
            }//end sub-if
            else
            {
                $data['error']         = 'error';
                $data['error_message'] = 'Invalid Order ID!!';
            }
            
        }// end main else    
        
        $this->template->write_view('home_main_content', 'front_end/site_information/contact_us', $data, TRUE);
        $this->template->render();
    }


    /**
     * Displays FAQ page.
     * 
     * @return none 
     */
    public function faq()
    {
        $this->template->write('title', 'Boutique: Frequently Asked Questions');       
        
        $data['faq_info'] = '';
        
        $this->template->write_view('home_main_content', 'front_end/site_information/faq', $data, TRUE);
        $this->template->render();
    }
}

/* End of file site_information.php */
/* Location: ./application/controllers/site_information.php */