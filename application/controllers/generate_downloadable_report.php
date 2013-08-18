<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage facilities. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Generate_downloadable_report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('report_model'));
        $this->load->library('excel');

        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }

    /**
     * Generates the excel file that includes the list of Customers Birthday List.
     * 
     * @return none 
     */

    public function excel()
    {
        if( $this->session->userdata('logged_in') != true )
        {
            redirect('siteadmin', 'refresh');
        }
        else
        {
            $data['table_title'] = 'Report List';
            $this->template->write('title', 'Boutique Admin Panel');

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    }
	/**
    * Display's Chart
    * 
    * @return none 
    */
    function chart()
	{
		$data['table_title']='Chart/Graph Report';
		$this->template->write_view('main_content', 'report/chart', $data, TRUE);
		$this->template->render();
	} 
 	/**
    * Get JSON Data for Chart
    * 
    * @return none 
    */
    function getSoldProductData()
	{
		$sold_record = $this->report_model->get_most_sold_products();
        //echo "<pre>"; print_r($sold_record); die();
		$responce->cols[]=array("id"=>"","label"=>"Product Name","pattern"=>"","type"=>"string");
		$responce->cols[]=array("id"=>"","label"=>"Sold Quantity","pattern"=>"","type"=>"number");
		
		foreach($sold_record as $product)
		{
			//$responce->rows[]["c"]=array(array("v"=>$product->product_name),array("v"=>$product->sold_item));
			$responce->rows[]["c"]=array(array("v"=>$product->product_name,"f"=>null),array("v"=>$product->sold_item,"f"=>null));
		}
		
		echo json_encode($responce);
	}
    /**
    * Display's Search Option of Invoice No.
    * 
    * @return none 
    */
    public function selection_date($method_name)
    {
        
        // change the form title according to the method name.


        if ($method_name=='member_management')
            $form_title= "Search members by period of time";
        elseif ($method_name=='category_management')
            $form_title= "Search categories by period of time";
        elseif ($method_name=='product_management')
            $form_title= "Search products by period of time";
        elseif ($method_name=='inventory_management')
            $form_title= "Search inventories by period of time";
        elseif ($method_name=='order_management')
            $form_title= "Search orders by period of time";
        elseif ($method_name=='shipment_tracking_management')
            $form_title= "Search shipments by period of time";
        elseif ($method_name=='advertisement_management')
            $form_title= "Search advertisements by period of time";
        elseif ($method_name=='stock_management')
            $form_title= "Search stocks by period of time";
        elseif ($method_name=='general_payments_management')
            $form_title= "Search payments by period of time";
        elseif ($method_name=='other_payments_management')
            $form_title= "Search other payments by period of time";
        elseif ($method_name=='profit_loss_management')
            $form_title= "Search profit and loss by period of time";
    

        $data['form_title']          = $form_title;
        $data['action']              = 'search';
        $data['method_name']         = $method_name;

        $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
        $this->template->render(); 
    }
    //Member Management, Category Management, Product Management, Inventory Management,
    //Order Management, Shipment Tracking Management, Advertisement Management, Stock &
    //Payment Management, Accounts Management, P&L Statement


    /**
     * Generates the excel file that includes the list of Customers Birthday List.
     * 
     * @return none 
     */
    public function member_management()
    {
        
        //gets all customers sorted by their English names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $members  = $this->report_model->get_members_with_inrange( $from_date, $to_date);
        

        if(count($members)==0)
        {
            $form_title= "Search members by period of time";
            $method_name='member_management';

            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        {       
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Member List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Member Name");
            $this->excel->getActiveSheet()->setCellValue("B1", "Email Address");
            $this->excel->getActiveSheet()->setCellValue("C1", "Mobile Number");
            $this->excel->getActiveSheet()->setCellValue("D1", "Recidence Address");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($members as $cs)
            {
                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->full_name);
                $this->excel->getActiveSheet()->setCellValue("B" . $column_starts, $cs->email_address);
                $this->excel->getActiveSheet()->setCellValue("C" . $column_starts, $cs->mobile_no);
                $this->excel->getActiveSheet()->setCellValue("D" . $column_starts, $cs->residence_address);
                
                $column_starts ++;
            }
            
            $filename = 'member_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends memmber_management

    /**
     * Generates the excel file that includes the list of Customers Birthday List.
     * 
     * @return none 
     */
    public function category_management()
    {
        
        //gets all category sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $categories  = $this->report_model->get_categories_with_inrange( $from_date, $to_date);

        if(count($categories)==0)
        {
            $form_title= "Search categories by period of time";
            $method_name='category_management';

            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        {        

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Category List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Category Name");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($categories as $cs)
            {
                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->name);
                $column_starts ++;
            }
            
            $filename = 'category_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends category management

    /**
     * Generates the excel file that includes the list of Product.
     * 
     * @return none 
     */
    public function product_management()
    {
        
        //gets all product sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $products  = $this->report_model->get_products_with_inrange( $from_date, $to_date);

        if(count($products)==0)
        {
            $form_title= "Search products by period of time";
            $method_name='product_management';



            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        {        

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Product List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Category Name");
            $this->excel->getActiveSheet()->setCellValue("B1", "Product Name");
            $this->excel->getActiveSheet()->setCellValue("C1", "Product No");
            $this->excel->getActiveSheet()->setCellValue("D1", "Guarantee Period");
            $this->excel->getActiveSheet()->setCellValue("E1", "Available Quantity");
            $this->excel->getActiveSheet()->setCellValue("F1", "Price Unit");
            $this->excel->getActiveSheet()->setCellValue("G1", "Description");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);

            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($products as $cs)
            {
                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->category_name);
                $this->excel->getActiveSheet()->setCellValue("B" . $column_starts, $cs->product_name);
                $this->excel->getActiveSheet()->setCellValue("C" . $column_starts, $cs->product_no);
                $this->excel->getActiveSheet()->setCellValue("D" . $column_starts, $cs->guarantee." ".$cs->guarantee_unit);
                $this->excel->getActiveSheet()->setCellValue("E" . $column_starts, $cs->available_quantity);
                $this->excel->getActiveSheet()->setCellValue("F" . $column_starts, $cs->unit_price);
                $this->excel->getActiveSheet()->setCellValue("G" . $column_starts, $cs->description);
                $column_starts ++;
            }
            
            $filename = 'product_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends Product management

    /**
     * Generates the excel file that includes the list of Product.
     * 
     * @return none 
     */
    public function inventory_management()
    {
        //gets all product sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $inventory  = $this->report_model->get_inventory_with_inrange( $from_date, $to_date);        

        if(count($inventory)==0)
        {
            $form_title= "Search inventories by period of time";
            $method_name='inventory_management';



            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        {           

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Inventory List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Date");
            $this->excel->getActiveSheet()->setCellValue("B1", "Product Name");
            $this->excel->getActiveSheet()->setCellValue("C1", "Total");
            $this->excel->getActiveSheet()->setCellValue("D1", "Sold");
            $this->excel->getActiveSheet()->setCellValue("E1", "Stock In Hand");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);

            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($inventory as $cs)
            {
                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->created_at);
                $this->excel->getActiveSheet()->setCellValue("B" . $column_starts, $cs->product_name);
                $this->excel->getActiveSheet()->setCellValue("C" . $column_starts, $cs->quantity);
                $this->excel->getActiveSheet()->setCellValue("D" . $column_starts, $cs->sold_item);
                $this->excel->getActiveSheet()->setCellValue("E" . $column_starts, $cs->quantity-$cs->sold_item);
                $column_starts ++;
            }
            
            $filename = 'inventory_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends Inventory management

    /**
     * Generates the excel file that includes the list of order.
     * 
     * @return none 
     */
    public function order_management()
    {
        
        //gets all product sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $orders  = $this->report_model->get_orders_with_inrange( $from_date, $to_date);

        if(count($orders)==0)
        {
            $form_title= "Search orders by period of time";
            $method_name='order_management';



            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        { 
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Order List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Date");
            $this->excel->getActiveSheet()->setCellValue("B1", "Bill No");
            $this->excel->getActiveSheet()->setCellValue("C1", "Member Name");
            $this->excel->getActiveSheet()->setCellValue("D1", "Product Name");
            $this->excel->getActiveSheet()->setCellValue("E1", "Quantity");
            $this->excel->getActiveSheet()->setCellValue("F1", "Price");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($orders as $cs)
            {
                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->order_date);
                $this->excel->getActiveSheet()->setCellValue("B" . $column_starts, $cs->bill_no);
                $this->excel->getActiveSheet()->setCellValue("C" . $column_starts, $cs->member_name);
                $this->excel->getActiveSheet()->setCellValue("D" . $column_starts, $cs->product_name);
                $this->excel->getActiveSheet()->setCellValue("E" . $column_starts, $cs->order_quantity);
                $this->excel->getActiveSheet()->setCellValue("F" . $column_starts, $cs->price);
                $column_starts ++;
            }
            
            $filename = 'order_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends Order management

    /**
     * Generates the excel file that includes the list of Shipment Tracking management.
     * 
     * @return none 
     */
    public function shipment_tracking_management()
    {
        
        //gets all product sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $shipment_tracking  = $this->report_model->get_shipment_tracking_with_inrange( $from_date, $to_date);

        if(count($shipment_tracking)==0)
        {
            $form_title= "Search shipments by period of time";
            $method_name='shipment_tracking_management';



            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        {        

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Shipment Tracking List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Date");
            $this->excel->getActiveSheet()->setCellValue("B1", "Consignment No");
            $this->excel->getActiveSheet()->setCellValue("C1", "Member Name");
            $this->excel->getActiveSheet()->setCellValue("D1", "Product Name");
            $this->excel->getActiveSheet()->setCellValue("E1", "Quantity");
            $this->excel->getActiveSheet()->setCellValue("F1", "Price");
            $this->excel->getActiveSheet()->setCellValue("G1", "Shipment Level");
            $this->excel->getActiveSheet()->setCellValue("H1", "Status");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);


            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($shipment_tracking as $cs)
            {
                if($cs->is_open==1)
                    $status='Open';
                elseif($cs->is_open==0)
                    $status='Close';

                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->order_date);
                $this->excel->getActiveSheet()->setCellValue("B" . $column_starts, $cs->bill_no);
                $this->excel->getActiveSheet()->setCellValue("C" . $column_starts, $cs->member_name);
                $this->excel->getActiveSheet()->setCellValue("D" . $column_starts, $cs->product_name);
                $this->excel->getActiveSheet()->setCellValue("E" . $column_starts, $cs->order_quantity);
                $this->excel->getActiveSheet()->setCellValue("F" . $column_starts, $cs->price);
                $this->excel->getActiveSheet()->setCellValue("G" . $column_starts, "Level - ".$cs->shipment_level);
                $this->excel->getActiveSheet()->setCellValue("H" . $column_starts, $status);
                $column_starts ++;
            }
            
            $filename = 'shipment_tracking_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends Shipment Tracking management

    /**
     * Generates the excel file that includes the list of Shipment Tracking management.
     * 
     * @return none 
     */
    public function advertisement_management()
    {
        
        //gets all product sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $advertisements  = $this->report_model->get_advertisements_with_inrange( $from_date, $to_date);


        if(count($advertisements)==0)
        {
            $form_title= "Search advertisements by period of time";
            $method_name='advertisement_management';



            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        { 
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Advertisement List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Customer Name");
            $this->excel->getActiveSheet()->setCellValue("B1", "Advertisement Position");
            $this->excel->getActiveSheet()->setCellValue("C1", "Period");
            $this->excel->getActiveSheet()->setCellValue("D1", "Expire On");
            $this->excel->getActiveSheet()->setCellValue("E1", "Status");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);

            //``,``,``,``,`run_from`
            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($advertisements as $cs)
            {
                if($cs->selected_period_unit=='day')
                    $interval = ' +'.(string)$cs->selected_period." days";
                elseif($cs->selected_period_unit=='month')
                    $interval = ' +'.(string)$cs->selected_period." months";
                elseif($cs->selected_period_unit=='year')
                    $interval = ' +'.(string)$cs->selected_period." years";

                $date = $cs->run_from;
                $expire_on = strtotime(date("Y-m-d", strtotime($date)) . $interval);
                
                if($cs->is_active==1)
                    $status='Open';
                elseif($cs->is_active==0)
                    $status='Close';
                

                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->customer_name);
                $this->excel->getActiveSheet()->setCellValue("B" . $column_starts, $cs->selected_position);
                $this->excel->getActiveSheet()->setCellValue("C" . $column_starts, $cs->selected_period.'  '.$cs->selected_period_unit);
                $this->excel->getActiveSheet()->setCellValue("D" . $column_starts, date('F j, Y', $expire_on));
                $this->excel->getActiveSheet()->setCellValue("E" . $column_starts, $status);
                $column_starts ++;
            }
            
            $filename = 'advertisement_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends Advertisement management

    /**
     * Generates the excel file that includes the list of Shipment Tracking management.
     * 
     * @return none 
     */
    public function stock_management()
    {

        //gets all product sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $stock  = $this->report_model->get_stocks_with_inrange( $from_date, $to_date);    

        if(count($stock)==0)
        {
            $form_title= "Search stocks by period of time";
            $method_name='stock_management';



            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        {        

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Stock List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Date");
            $this->excel->getActiveSheet()->setCellValue("B1", "Product Name");
            $this->excel->getActiveSheet()->setCellValue("C1", "Quantity");
            $this->excel->getActiveSheet()->setCellValue("D1", "Amount");
            $this->excel->getActiveSheet()->setCellValue("E1", "Bill No");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);

            //``,``,``,``,`run_from`
            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($stock as $cs)
            {         

                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->created_at);
                $this->excel->getActiveSheet()->setCellValue("B" . $column_starts, $cs->quantity);
                $this->excel->getActiveSheet()->setCellValue("C" . $column_starts, $cs->amount);
                $this->excel->getActiveSheet()->setCellValue("D" . $column_starts, $cs->amount);
                $this->excel->getActiveSheet()->setCellValue("E" . $column_starts, $cs->bill_no);
                $column_starts ++;
            }
            
            $filename = 'stock_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends Stock management

    /**
     * Generates the excel file that includes the list of Shipment Tracking management.
     * 
     * @return none 
     */
    public function general_payments_management()
    {
        
        //gets all product sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $general_payment  = $this->report_model->get_general_payment_with_inrange( $from_date, $to_date);

        
        if(count($general_payment)==0)
        {
            $form_title= "Search payments by period of time";
            $method_name='general_payments_management';



            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        { 
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Product Bought List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Payment Date");
            $this->excel->getActiveSheet()->setCellValue("B1", "Bill No");
            $this->excel->getActiveSheet()->setCellValue("C1", "Amount");
            $this->excel->getActiveSheet()->setCellValue("D1", "Brought From");
            $this->excel->getActiveSheet()->setCellValue("E1", "Mode of Payment");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
    		
            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($general_payment as $cs)
            {         

                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->payment_date);
                $this->excel->getActiveSheet()->setCellValue("B" . $column_starts, $cs->bill_no);
                $this->excel->getActiveSheet()->setCellValue("C" . $column_starts, $cs->amount);
                $this->excel->getActiveSheet()->setCellValue("D" . $column_starts, $cs->brought_from);
                $this->excel->getActiveSheet()->setCellValue("E" . $column_starts, $cs->mode_of_payment);
                $column_starts ++;
            }
            
            $filename = 'general_payments_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends General Payment management
	
	/**
     * Generates the excel file that includes the list of Shipment Tracking management.
     * 
     * @return none 
     */
    public function other_payments_management()
    {
        
        //gets all product sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $other_payments  = $this->report_model->get_other_payment_with_inrange( $from_date, $to_date);

        
        if(count($other_payments)==0)
        {
            $form_title= "Search other payments by period of time";
            $method_name='other_payments_management';



            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        {
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Other Payment List');
            
            //set cell A1, B1 & C1 with bold column-headings
            $this->excel->getActiveSheet()->setCellValue("A1", "Payment Date");
            $this->excel->getActiveSheet()->setCellValue("B1", "Expense Name");
            $this->excel->getActiveSheet()->setCellValue("C1", "Amount");
            $this->excel->getActiveSheet()->setCellValue("D1", "Bill No");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

            //loops names and birthdays, and set to the columns.
            //at first, escapes the 2nd row 
            $column_starts = 3;        
            foreach ($other_payments as $cs)
            {         

                $this->excel->getActiveSheet()->setCellValue("A" . $column_starts, $cs->payment_date);
                $this->excel->getActiveSheet()->setCellValue("B" . $column_starts, $cs->expense_name);
                $this->excel->getActiveSheet()->setCellValue("C" . $column_starts, $cs->amount);
                $this->excel->getActiveSheet()->setCellValue("D" . $column_starts, $cs->bill_no);
                $column_starts ++;
            }
            
            $filename = 'other_payments_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends other payment management
	
	/**
     * Generates the excel file that includes the list of Shipment Tracking management.
     * 
     * @return none 
     */
    public function profit_loss_management()
    {
        
        //gets all product sorted by their names
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $profit_loss_data  = $this->report_model->get_profit_and_loss_with_inrange($from_date, $to_date);
        
        if(count($profit_loss_data)==0)
        {
            $form_title  = "Search profit amd loss by period of time";
            $method_name = 'profit_loss_management';



            $data['form_title']          = $form_title;
            $data['action']              = 'search';
            $data['method_name']         = $method_name;
            $data['error_message']       = "No record found with in this period of time";

            $this->template->write_view('main_content', 'report/selection_date', $data, TRUE);
            $this->template->render();            
        } 

        else
        {
		
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Profit loss Statement');
            
            //set cell A1, B1 & C1 with bold column-headings
    		$col = 0;
    		$row = 1;
            //echo"<pre>";print_r($profit_loss_data);die();
    		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'For Dates submitted between '.$from_date.' to '.$to_date);
    		
    		$row=$row+2;
    		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'INCOME');
    		
    		$row=$row+2;
    		$total_income = 0.00;
    		$expenses = 0.00;
    		foreach($profit_loss_data['sold'] as $sold_data)
    		{
    			$total_income = $total_income + $sold_data['sold_amount'];
    			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Product Sold');
    			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row, $sold_data['sold_amount']);
    			$row++;
    		}		
    		$row=$row+1;

    		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'TOTAL INCOME');
    		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row, $total_income);
            
    		$row=$row+2;		
    		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'EXPENSES');
    		
    		$row=$row+2;
    		foreach($profit_loss_data['bought'] as $bought_data)
    		{
    			$expenses = $expenses + $bought_data['product_bought_amount'];
    			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Product Bought');
    			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row, $bought_data['product_bought_amount']);
    			$row++;
    		}
    		
    		foreach($profit_loss_data['expense'] as $expense_data)
    		{
    			$expenses = $expenses + $expense_data['expense_amount'];
    			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $expense_data['expense_name']);
    			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row, $expense_data['expense_amount']);
    			$row++;
    		}
            
    		$row=$row+1;		
    		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'TOTAL EXPENSES');
    		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row, $expenses);

    		$row=$row+2;		
    		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'OVERALL TOTAL');
    		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row, $total_income-$expenses);
    		
            $filename = 'profit_loss_management.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

            $data['table_title'] = 'Report List';

            $this->template->write_view('main_content', 'report/list', $data, TRUE);
            $this->template->render();
        }
    } //ends other payment management
}

/* End of file generate_downloadable_report.php */
/* Location: ./application/controllers/generate_downloadable_report.php */