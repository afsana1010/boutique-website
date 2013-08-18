<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Test & handle the responses from SMS API. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Test_sms_api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
//        $this->load->model(array('product_stock_model'));
//        
//        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
//            $this->template->set_template('admin');
    }


    public function index()
    {
        #
        # build the API URL to call
        #
        $params = array(
                            'username' => 'TestAWH',
                            'password' => 'password',
                            'code'     => '880',
                            'number'   => '01816719318',
                            'msg'      => "This Is A Test Message on SMS API Implementation" . "\r\n" . "--Boutique"
                       );

        $encoded_params = array();

        foreach ($params as $k => $v){

                $encoded_params[] = urlencode($k).'='.urlencode($v);
        }


        #
        # call the API and decode the response
        #

        //initiates respose values
        $response_values = array(
                                    '0' => 'Pending',
                                    '1' => 'Delivered',
                                    '-1' => 'Undelivered',
                                    '-2' => 'Expired',
                                    '-3' => 'Invalid Destination',
                                    '-4' => 'Country Code Missing',
                                    '-5' => 'Mobile Number Missing',
                                    '-9' => 'Insufficient Balance',
                                    '-11' => 'Invalid Sender Id',
                                    '-22' => 'This Country is not Allowed',
                                    '-99' => 'API is Inactive'
                                );
        
        $message_send_url = "http://66.172.38.168/my/api/sms-http.php?".implode('&', $encoded_params);
        
        $ch = curl_init ($message_send_url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $message_send_response = curl_exec ($ch);
        
        
        if (strlen($message_send_response) == 8) { //if the message sent successfully
            $hexacode = $message_send_response;
            
            #
            # build the API URL to call
            #
            $params = array(
                                'username' => 'TestAWH',
                                'password' => 'password',
                                'hexcodes' => $hexacode
                           );

            $encoded_params = array();

            foreach ($params as $k => $v){

                    $encoded_params[] = urlencode($k).'='.urlencode($v);
            } 
            
            $report_url = "http://66.172.38.168/my/api/sms-http-reports.php?".implode('&', $encoded_params);
            $ch         = curl_init ($report_url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
            $response_string = curl_exec ($ch);
            $json_object = json_decode ($response_string);
            foreach ($json_object as $key => $value) {
                echo "Status: " . $value->status. '<br />';
                echo "Message Sent Time: " . $value->date_sent. '<br />';
                echo "Message Delivery Time: " . $value->date_dlvrd. '<br />'; 
            }
            
        }
        else
            echo $response_values[$message_send_response]; die;    
    }

}

/* End of file test_sms_api.php */
/* Location: ./application/controllers/test_sms_api.php */