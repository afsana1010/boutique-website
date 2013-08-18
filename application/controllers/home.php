<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage home of products. 
 * 
 * @author Afsana Rahman Snigdha <afsana101083@gmail.com>
 */
class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
	    $this->load->model(array('common_model','product_model'));
    }

    /**
     * Displays homepage 
     * 
     * @return none 
     */
    public function index()
    {
        $data['category_sections'] = $this->common_model->query_multiple_rows_by_single_source('boutique_product_sections', 'is_active', 1);
        $data['category_list']     = $this->common_model->query_all_data('boutique_categories');
        	
        $this->template->write_view('menu', 'includes/front_end/menu', $data, true);
	$this->template->render();
    }

    /**
     * Displays about_us 
     * 
     * @return none 
     */
    public function about_us()
    {
        $data['form_title'] = 'About Us';
        
        $this->template->write_view('home_main_content', 'front_end/home/about_us', $data, true);
        $this->template->render();
    }  

    /**
     * Displays contact_us 
     * 
     * @return none 
     */
    public function contact_us()
    {
        $data['form_title'] = 'Contact Us';
        
        $this->template->write_view('home_main_content', 'front_end/home/contact_us', $data, true);
        $this->template->render();
    }   
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */