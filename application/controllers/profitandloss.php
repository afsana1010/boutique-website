<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage profitandloss of products. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Profitandloss extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('profitandloss_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }

    /**
    * Display's Search Option of Invoice No.
    * 
    * @return none 
    */
    public function selection_date()
    {       
        $data['form_title']          = 'Select a period';
        $data['action']              = 'search';
        $data['method_name']         = 'profitandloss';

        $this->template->write_view('main_content', 'profitandloss/selection_date', $data, TRUE);
        $this->template->render(); 
    }
	
	
	/**
     * Restricted page to list item-profitandloss info. 
     * Bypass to the entry-form if no data found.
     * 
     * @return none 
     */
	
    public function profitandloss_statement()
    {
        if( $this->session->userdata('logged_in') != true )
        {
            redirect('siteadmin', 'refresh');
        }
		
		$data['table_title'] = 'Profit and Loss Statement';
		$this->template->write('title', ' Admin Panel');
		
		$from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
		
        $data['from_date']		 = $from_date;
        $data['to_date']		 = $to_date;
		$data['product_sold']    = $this->profitandloss_model->get_product_sold($from_date,$to_date);
        $data['payments'] 		 = $this->profitandloss_model->get_general_payment($from_date,$to_date);
        $data['expenses']    	 = $this->profitandloss_model->get_expense_name($from_date,$to_date);
		
		//echo "<pre>";print_r($data);die();
		
		$this->template->write_view('main_content', 'profitandloss/list', $data, TRUE);
        $this->template->render();
    }//end profitandloss function
    
	/**
     * Export Ticket Promotions list to Excel
     * 
     * @return none 
     */
    public function exportprofitandlosssToExcel()
    {
		$profitandloss_record          = $this->common_model->query_all_data('boutique_product_stocks');
        $num_of_rows           	 = count($profitandloss_record);
        
		if ($num_of_rows > 0)
        {
			$columns = array();
			$columns['field'] = array("created_at", "brought_from", "product_name", "quantity", "amount", "bill_no");
			$columns['title'] = array("Date", "Paid To", "Product Name", "Quantity", "Amount", "Bill No.");
			$columns['type']  = array("date", "", "", "", "", "");
			
			$this->common_model->exportToExcel($columns,$profitandloss_record,'profitandlosss_List');
        }//end if
    }//end excel export
}

/* End of file profitandloss.php */
/* Location: ./application/controllers/profitandloss.php */