<?php

/**
 * Contains the core logic to generate and process email/sms messages 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Message_model extends CI_Model
{
    var $CI;
    
    /**
     * Model constructor 
     * 
     */
    function __construct()
    {
        parent::__construct();
        
        $this->CI =& get_instance();
        
        $response_values = array(
                                    '0'   => 'Pending',
                                    '1'   => 'Delivered',
                                    '-1'  => 'Undelivered',
                                    '-2'  => 'Expired',
                                    '-3'  => 'Invalid Destination',
                                    '-4'  => 'Country Code Missing',
                                    '-5'  => 'Mobile Number Missing',
                                    '-9'  => 'Insufficient Balance',
                                    '-11' => 'Invalid Sender Id',
                                    '-22' => 'This Country is not Allowed',
                                    '-99' => 'API is Inactive'
                                );
        
        $this->load->database();
    }

    /**
     * Gets page-wise product-message 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
        $sort                    = "action_name ASC";
        $sql                     = "SELECT * FROM boutique_messages ORDER BY ".$sort ;		
        $sql_paging 	         = "SELECT * FROM boutique_messages ORDER BY $sort LIMIT $start,$end";
        $data['message_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 	       	 = $this->db->query($sql);
        $data['message_rows']    = $query1->num_rows();

        return $data;
    }

    /**
     * Processes the SMS Call 
     * 
     * @param integer $country_code
     * @param string $mobile_number
     * @param string $message
     * 
     * @return boolean 
     */
    public function process_sms_call($country_code, $mobile_number, $message)
    {
        $status = false;
        
        // builds the API URL to call
        $params = array(
                            'username' => $this->CI->config->item('sms_username'),
                            'password' => $this->CI->config->item('sms_password'),
                            'code'     => $country_code,
                            'number'   => $mobile_number,
                            'msg'      => $message
                       );

        $encoded_params = array();

        foreach ($params as $k => $v) {
            $encoded_params[] = urlencode($k) . '=' . urlencode($v);
        }

        // calls the API
        $message_send_url = $this->CI->config->item('sms_send_url') . implode('&', $encoded_params);
        $ch               = curl_init ($message_send_url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $message_send_response = curl_exec ($ch);
        
        
        if (strlen($message_send_response) == 8) //if the message sent successfully
            $status = true;

        return $status;
    }
    
}

/* End of file message_model.php */
/* Location: ./application/models/message_model.php */