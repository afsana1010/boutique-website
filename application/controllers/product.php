<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * List and manage product of products. 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $data = array();
        $this->load->model(array('product_model'));
        
        if( ($this->session->userdata('logged_in') == 'true') && ($this->session->userdata('logged_in_as') == 'admin') )
            $this->template->set_template('admin');
    }


    /**
     * Restricted page to list item info. 
     * Bypass to the entry-form if no data found.
     * 
     * @return none 
     */
    public function index()
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
            redirect('siteadmin', 'refresh');
        
        $product_record          = $this->common_model->query_all_data('boutique_products');
        $num_of_products         = count($product_record);
        $data['num_of_products'] = $num_of_products;
        if ($num_of_products > 0)
        {
            $data['table_title'] = 'Product List';
            $this->template->write('title', 'Boutique Admin Panel: List of Products');

            //starts paging configaration
            $limit_from               	= $this->uri->segment(3);
            $list_start               	= ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                 	= 10;	
            $data['all_product']       	= $this->product_model->get_pagewise($list_start, $list_end);
            $data['product_result']     = $data['all_product']['product_afterPg']; 
            $data['product_rownumbers'] = $data['all_product']['product_rows'];

            $list_config['base_url']   = base_url().'product/index/';
            $list_config['uri_segment']= '3';
            $list_config['total_rows'] = $data['product_rownumbers'];
            $list_config['per_page']   = '10';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['product_paging'] = $this->pagination->create_links();
            //ends paging configaration

            $this->template->write_view('main_content', 'product/list', $data, TRUE);
            $this->template->render();
        }//end if
        
        else
            redirect('product/manage', 'refresh');
    }//end product listing
    
    
    /**
     * Manages product information.
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
                
        $this->template->write('title', 'Boutique: Product Information');
        
        $data['categories']      = $this->common_model->query_sorted_data('boutique_categories', 'name');
        $data['stocks']          = $this->common_model->query_sorted_data('boutique_product_stocks', 'product_name');
        $data['guarantee_units'] = $this->common_model->get_enum_field_values('boutique_products', 'guarantee_unit');
        $data['images']          = '';
        
        if (!empty($id)) /* checks whether to edit data */
        {
            $data['form_title'] = 'Edit Product';
            $data['id']         = $id;
            $data['action']     = 'edit';
            
            $product_data = $this->common_model->query_single_row_by_single_source('boutique_products', 'id', $id);
            foreach ($product_data as $pd)
            {
                $data['category_id']         = $pd->category_id;
                $data['product_stock_id']    = $pd->product_stock_id;
                $data['product_name']        = $pd->product_name;
                $data['product_no']          = $pd->product_no;
                $data['guarantee']           = $pd->guarantee;
                $data['guarantee_unit']      = $pd->guarantee_unit;
                $data['available_quantity']  = $pd->available_quantity;
                $data['unit_price']          = $pd->unit_price;
                $data['description']         = $pd->description;
                $data['is_active']           = $pd->is_active;
            }
            $check_images = $this->common_model->query_multiple_rows_by_single_source('boutique_product_images', 'product_id', $id);
			
            if(count($check_images) > 0)
            {
                $images  = '';
                $counter = 1;
				
                foreach($check_images as $img)
                    {
						if($img->dimension != 'X')
						{
							if($counter == count($check_images) || $counter == 1)
								$images = $images . $img->file_name;
								
							elseif($counter < count($check_images) && $counter>1)
								$images = $images . '|' . $img->file_name;
						}
						$counter++;
                    }
                $session_data = array('uploaded_files' => $images);
                $this->session->set_userdata($session_data);
                $data['images'] = $images;
            } 
        }
        else /* otherwise, config validation to add data */
        {
            $data['form_title'] = 'Add Product';
            $data['action']     = 'add'; 
        }
        
        $config = array(
                            array('field' => 'product_name',        'label' => 'Product Name',         'rules' => 'trim|required|max_length[60]'),
                            array('field' => 'product_no',          'label' => 'Product No.',          'rules' => 'trim|required|max_length[30]'), 
                            array('field' => 'available_quantity',  'label' => 'Available Quantity',   'rules' => 'trim|required|is_natural_no_zero'), 
                            array('field' => 'unit_price',          'label' => 'Unit Price(SGD)',      'rules' => 'trim|required|decimal'),
                            array('field' => 'description',         'label' => 'Product Description',  'rules' => 'trim|required'), 
                            array('field' => 'guarantee',           'label' => 'Guarantee',            'rules' => 'trim|required|is_natural_no_zero')
                       );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == false)
        {
            /* Show the form */
            $this->template->write_view('main_content', 'product/manage', $data, TRUE);
        } //end main if
        else
        {
            /* when the form is submitted */
            
            if ($id == NULL)
            {
                /* adds the member */
                $product_data['id']                 = '';
                $product_data['category_id']        = $this->input->post('category_id');
                $product_data['product_stock_id']   = $this->input->post('product_stock_id');
                $product_data['product_name']       = $this->input->post('product_name');
                $product_data['product_no']         = $this->input->post('product_no');
                $product_data['guarantee']          = $this->input->post('guarantee');
                $product_data['guarantee_unit']     = $this->input->post('guarantee_unit');
                $product_data['available_quantity'] = $this->input->post('available_quantity');
                $product_data['unit_price']         = $this->input->post('unit_price');
                $product_data['description']        = $this->input->post('description');
                $product_data['is_active']          = 1;
                $product_data['created_at']         = date('Y-m-d h:i:s');
                
                if ($this->common_model->add_data('boutique_products', $product_data))
                    $product_id = mysql_insert_id ();

                if ($product_id > 0)
                {
                    if( $this->input->post('image_position') )
                    {
                        $images    = $this->input->post('image_names');
                        $positions = $this->input->post('image_position');
                        for( $i = 0; $i < count($images); $i++ )
                        {
                            $image_path     = base_url().'assets/uploads/product_images/'.$images[$i];
                            $link_prefix    = '|http://(www\.)?' . str_replace('.', '\.', $_SERVER['HTTP_HOST']) . '|i';
                            $file_path      = $_SERVER['DOCUMENT_ROOT'] . preg_replace($link_prefix, '', $image_path);
                            $image_details  = @getimagesize($file_path);
                            $dimension      = $image_details[0].'X'.$image_details[1];

                            $image_data['id']          = '';  
                            $image_data['product_id']  = $product_id;
                            $image_data['category_id'] = $this->input->post('category_id');
                            $image_data['file_name']   = $images[$i];
                            $image_data['dimension']   = $dimension;
                            $image_data['uploaded_at'] = date('Y-m-d h:i:s');
                            $image_data['image_order'] = $positions[$i];
                            $this->common_model->add_data('boutique_product_images',$image_data); 
                        }
                    }
                    $this->session->set_flashdata('success_message','Product Added Successfuly.');
                }
                
                else
                {
                    $this->session->set_flashdata('error_message', 'Could not add the product! Please try again later.');
                }
            }//ends adding member
            else
            {
                /* gather info */
                $update_data['category_id']        = $this->input->post('category_id');
                $update_data['product_stock_id']   = $this->input->post('product_stock_id');
                $update_data['product_name']       = $this->input->post('product_name');
                $update_data['product_no']         = $this->input->post('product_no');
                $update_data['guarantee']          = $this->input->post('guarantee');
                $update_data['guarantee_unit']     = $this->input->post('guarantee_unit');
                $update_data['available_quantity'] = $this->input->post('available_quantity');
                $update_data['unit_price']         = $this->input->post('unit_price');
                $update_data['description']        = $this->input->post('description');
                $update_data['is_active']          = $this->input->post('is_active');
                $update_data['modified_at']        = date('Y-m-d h:i:s');
                
                /* updates info */
                if ($this->common_model->update_data('id', $id, 'boutique_products', $update_data))
                    $this->session->set_flashdata('success_message','Product Updated Successfuly.');
                else
                    $this->session->set_flashdata('error_message','Could not update the product! Please try again later.');
                
                /* updates images info */
                $images = $this->input->post('images');
                                        
                if( $this->input->post('image_position') )
                {
                    
                    $images    = $this->input->post('image_names');
                    $positions = $this->input->post('image_position');
                    
                    for( $i = 0; $i < count($images); $i++ )
                        {
                            if( $this->product_model->check_product_image($id,$images[$i]) == FALSE )
                                {
                                    $image_path     = base_url().'assets/uploads/product_images/'.$images[$i];
                                    $link_prefix    = '|http://(www\.)?' . str_replace('.', '\.', $_SERVER['HTTP_HOST']) . '|i';
                                    $file_path      = $_SERVER['DOCUMENT_ROOT'] . preg_replace($link_prefix, '', $image_path);
                                    $image_details  = @getimagesize($file_path);
                                    $dimension      = $image_details[0].'X'.$image_details[1];

                                    $image_data['id']          = '';  
                                    $image_data['product_id']  = $id;
                                    $image_data['category_id'] = $this->input->post('category_id');
                                    $image_data['file_name']   = $images[$i];
                                    $image_data['dimension']   = $dimension;
                                    $image_data['uploaded_at'] = date('Y-m-d h:i:s');
                                    $image_data['image_order'] = $positions[$i];
                                    $this->common_model->add_data('boutique_product_images',$image_data);   
                                }
                            else
                                {
                                    $updated_data['image_order'] = $positions[$i];
                                    $this->common_model->update_data('file_name', $images[$i], 'boutique_product_images', $updated_data); 
                                }
                        }    
                }

                if(!empty($images))
                {
                    if($this->session->userdata('uploaded_files'))
                        {
                            $session_data = array('uploaded_files' => '');
                            $this->session->unset_userdata($session_data);
                        }
                    if($this->session->userdata('images'))
                        {
                            $session_data = array('images' => '');
                            $this->session->unset_userdata($session_data);
                        }
                }
                
            }//ends updating product
            
            /* redirects to list page */
            redirect('product', 'refresh');
        } //end main else


        $this->template->render();
    } //ends product data management
    
    /**
     * Delete single/multiple product.
     * Restricted for the general products.
     * 
     * @return none 
     */
    public function delete()
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
            redirect('siteadmin', 'refresh');        
        
        $product_deletion_type = $this->input->post('product_deletion_type');
        
        /* starts to delete multiple members */
        if ($product_deletion_type == 'multiple') {
            $product_id = $this->input->post('product_id');
            $c        = 0;
            for( $i = 0; $i < count($product_id); $i++ )
            {
                $id = $product_id[$i];

                /* deletes any available images first */
                $images = $this->common_model->query_multiple_rows_by_single_source('boutique_product_images','product_id',$id); 
                if(count($images) > 0)
                {
                    foreach($images as $img)
                    {
                        @unlink(realpath('./assets/uploads/product_images/'.$img->file_name));
                        $this->edit_model->delete_data('file_name', $img->file_name, 'boutique_product_images');
                    }
                }
                
                if( $this->common_model->delete_data('id', $id, 'boutique_products') )
                    $c++;
            }
            if( $c == 0 )
                $this->session->set_flashdata('error_message', 'Could not delete any product!!');
            
            elseif( $c == 1 )
                $this->session->set_flashdata('success_message', 'A product was deleted successfully');
            
            elseif( $c > 1 )
                $this->session->set_flashdata('success_message', 'Multiple product were deleted successfully');
        }
        /* ends to delete multiple product */
        
        /* starts to delete single member */
        else {
            $id = $this->input->post('single_product_id');
            
            /* deletes any available images first */
            $images = $this->common_model->query_multiple_rows_by_single_source('boutique_product_images','product_id',$id); 
            if(count($images) > 0)
            {
                foreach($images as $img)
                {
                    if (unlink(realpath('./assets/uploads/product_images/'.$img->file_name)))
                        $this->common_model->delete_data('file_name', $img->file_name, 'boutique_product_images');
                }
            }
            
            if($this->common_model->delete_data('id', $id, 'boutique_products'))
                $this->session->set_flashdata('success_message', 'A product was deleted successfully');
            
            else
                $this->session->set_flashdata('error_message', 'Could not delete the product!!');
        }
       /* ends to delete single product */ 
        
        redirect(base_url().'product', 'refresh');
    }
    
    
   /**
    * Stores uploaded images into database.
    * Restricted for the general products.
    * 
    * @return none 
   */
   public function process_uploaded_image()
   {
       if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
          redirect('siteadmin', 'refresh');  
       
       
       $user_file = $this->input->post('user_file');

       if($this->session->userdata('product_id'))
        {
            $image_path = base_url().'assets/uploads/product_images/'.$user_file;
            if( $this->common_model->query_single_duplicate_data('boutique_product_images','file_name',$user_file) == FALSE )
                {
                    $link_prefix   = '|http://(www\.)?' . str_replace('.', '\.', $_SERVER['HTTP_HOST']) . '|i';
                    $file_path     = $_SERVER['DOCUMENT_ROOT'] . preg_replace($link_prefix, '', $image_path);
                    $image_details = @getimagesize($file_path);

                    $product_id    = $this->session->userdata('product_id');

                    $image_data['id']          = '';  
                    $image_data['product_id']  = $product_id;
                    $image_data['category_id'] = $this->common_model->query_single_data('boutique_product_images','product_id',$product_id,'category_id');
                    $image_data['file_name']   = $user_file;
                    $image_data['dimension']   = $image_details[0].'X'.$image_details[1];
                    $image_data['uploaded_at'] = date('Y-m-d h:i:s');
                    $image_data['image_order'] = $this->custom_methods_model->get_next_order('boutique_product_images','product_id',$product_id,'image_order');
                    $this->insert_model->add_data('boutique_product_images',$image_data);
                }   
        }

        if( $this->session->userdata('uploaded_files') )
            {
                $uploaded_files = $this->session->userdata('uploaded_files');
                if(!empty($uploaded_files))
                    $session_data = $uploaded_files.'|'.$user_file;
                else
                    $session_data = $user_file;

                $files        = $session_data;
                $session_data = array( 'uploaded_files'=> $session_data );
                $this->session->set_userdata($session_data);    
            } 
        else
            {
                $files        = $user_file;
                $session_data = array( 'uploaded_files'=> $user_file );
                $this->session->set_userdata($session_data);
            }
        echo $files;   
   }
       
    
  /**
    * Deletes product-images both physically and from database.
    * Restricted for the general products.
    * 
    * @return none 
   */ 
  public function delete_image()
    {
      if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
          redirect('siteadmin', 'refresh');  
      
		$img = $this->input->post('img');
		$rtn = $this->common_model->delete_data('file_name', $img, 'boutique_product_images');
		//echo $img."---".$rtn;die();
		if( @unlink(realpath('./assets/uploads/product_images/'.$img)) )
        {           
            $uploaded_files     = $this->session->userdata('uploaded_files');
            $updated_files_str  = str_replace($img,'',$uploaded_files);
            $first_character    = substr($updated_files_str, 0, 1);
            $last_character     = substr($updated_files_str, -1);

            if( $first_character == '|' )
                $updated_files = ltrim($updated_files_str,'|');

            else if( $last_character == '|' )
                $updated_files = rtrim($updated_files_str,'|');

            else
                $updated_files = $updated_files_str;

            $session_data = array( 'uploaded_files'=> $updated_files );
            $this->session->set_userdata($session_data);    
            echo $updated_files;	
        } 
      
		else
			echo 'failure';
     }

    /**
     * Active/Inactive a selected product.
     * Restricted for the general users.
     * 
     * @return none 
     */
    public function product_status()
    {
        if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'admin'))
            redirect('siteadmin', 'refresh');
        
        $oper    = $this->input->post('oper');
        $id      = $this->input->post('product_id');
        $product = $this->common_model->query_single_data('boutique_products','id',$id,'product_no');
        
        $updated_data['modified_at'] = date('Y-m-d h:i:s');
        
        /* starts to active product */
        if ($oper == 'active') {
            $updated_data['is_active'] = 1;
            if( $this->common_model->update_data('id', $id, 'boutique_products', $updated_data) == TRUE )
                $this->session->set_flashdata('success_message', $name . ' was activated successfully');
            else
                $this->session->set_flashdata('error_message', 'Could not activate ' . $name . '!!');
        }
        /* finishes to active product */
        
        /* starts to inactive product */
        if ($oper == 'inactive') {
            $updated_data['is_active'] = 0;
            if( $this->common_model->update_data('id', $id, 'boutique_products', $updated_data) == TRUE )
                $this->session->set_flashdata('success_message', $name . ' was disabled successfully');
            else
                $this->session->set_flashdata('error_message', 'Could not disable ' . $name . '!!');
        }
        /* finishes to inactive product */
    }

	
	/**
     * Display products category-wise .
     * For the general users.
     * 
     * @return none 
     */	
    public function display($id)
    {
        //$this->load->model(array('product_model'));
        $this->template->set_template('front');
        // set table title and action
        $data['table_title'] = 'Display Product';
        $data['action']='display';

        // get the data of product list from product and product stock table.        
        $product_record          = $this->product_model->category_wise_product($id, 0, 1);
        $num_of_products         = count($product_record);
        $data['num_of_products'] = $num_of_products;
        if ($num_of_products > 0)
        {
            $data['table_title'] = 'Product List';
            $this->template->write('title', 'Boutique Admin Panel: List of Products');

            //starts paging configaration
            $limit_from               	= $this->uri->segment(4);
            $list_start               	= ($limit_from == NULL) ? 0 : $limit_from;
            $list_end                 	= 30;	
            $data['all_product']       	= $this->product_model->category_wise_product($id, $list_start, $list_end);
            $data['product_result']     = $data['all_product']['product_afterPg']; 
            $data['product_rownumbers'] = $data['all_product']['product_rows'];

            $list_config['base_url']   = base_url().'product/display/' . $id;
            $list_config['uri_segment']= '4';
            $list_config['total_rows'] = $data['product_rownumbers'];
            $list_config['per_page']   = '30';		

            $this->pagination->initialize($list_config);
            $this->pagination->create_links();

            $data['product_paging'] = $this->pagination->create_links();
            //ends paging configaration
        }//end if

        $this->template->write_view('home_main_content', 'front_end/product/display_list', $data, TRUE);  
        $this->template->render();
	}//end display function

    /**
     * Adds item to shopping cart.
     * For the general users.
     * 
     * @return none 
     */		
    function shopping_cart($status = null)
    {
        //set the user template.
	$this->template->set_template('front');
		
	if(($this->session->userdata('logged_in') != true) && ($this->session->userdata('logged_in_as') != 'user'))
        {
            $data['form_title'] = 'Login';
            $data['action']     = 'login';

            $this->template->write_view('home_main_content', 'front_end/register/login',$data, TRUE);    
        }
        elseif($status == null)
        {
            $data['table_title'] = 'Shopping Cart';
            $data['action']      = 'display';
            $data['category_id'] = $this->input->post('category_id');

            /* reduced the chosen quantity */
            $quantity                                  = $this->input->post('quantity');
            $product_id                                = $this->input->post('product_id');
            $product_update_data                       = array(); 
            $product_update_data['available_quantity'] = $this->common_model->query_single_data('boutique_products', 'id', $product_id, 'available_quantity') - $quantity;
            $this->common_model->update_data('id', $product_id, 'boutique_products', $product_update_data);
            
            //add data to shopping-cart table
            $user_data                  = array();
            $user_data['id']            = '';
            $user_data['product_id']    = $product_id;
            $user_data['user_id']       = $this->session->userdata('user_id');
            $user_data['quantity']      = $quantity;
            $user_data['item_chosen_at']= date('Y-m-d h:i:s');

            $user_id = $this->common_model->add_data('boutique_shopping_cart', $user_data);

            if ($user_id > 0)
            {
                $data['quantity']=$this->input->post('quantity');

                // get the data of product list from product and product stock table.
                $data['shopping_cart_list']=$this->product_model->user_shopping_cart_info($this->session->userdata('user_id'));

                $this->template->write_view('home_main_content', 'front_end/product/shopping_cart',$data, TRUE);    
            }
            else
            {
                $this->session->set_flashdata('error_message','Sorry, we could not add the item to your cart!!');
                redirect(base_url().'product/display/'.$this->input->post('product_stock_id'), 'refresh');
            } 
        }

        elseif($status=='remove')
        {
                $data['table_title'] = 'Shopping Cart';
                $data['action']      = 'display';	

                // get the data of product list from product and product stock table.
                $data['shopping_cart_list']=$this->common_model->query_multiple_rows_by_single_source('boutique_shopping_cart', 'user_id', $this->session->userdata('user_id'));

                $this->template->write_view('home_main_content', 'front_end/product/shopping_cart',$data, TRUE); 
        }
        $this->template->render();
    }//end shopping cart function
    
    
    public function display_shopping_cart()
    {
        $data['table_title']        = 'Shopping Cart';
        $data['shopping_cart_list'] = $this->product_model->user_shopping_cart_info($this->session->userdata('user_id'));
        $this->template->write_view('home_main_content', 'front_end/product/shopping_cart',$data, TRUE);
        
        $this->template->render();
    }

    
    /**
     * Add data to order table.
     * For the general users.
     * 
     * @return none 
     */		
    public function checkout()
    {
        //set the user template.
        $this->template->set_template('front');

        $data['table_title']   = 'Check Out';
        $data['action']        = 'display';
        $user_id               = $this->session->userdata('user_id');
        $data['chechout_list'] = $this->product_model->user_shopping_cart_info($user_id);

        $this->template->write_view('home_main_content', 'front_end/product/checkout',$data, TRUE); 
        $this->template->render();
    }//end checkout function

	/**
     * Remove single product order of a user from shopping cart.
     * Use for the general users.
     * 
     * @return none 
     */
    public function remove($shopping_cart_id)
    {      
        /* adjusts back the chosen quantity */
        $quantity                                  = $this->common_model->query_single_data('boutique_shopping_cart', 'id', $shopping_cart_id, 'quantity');
        $product_id                                = $this->common_model->query_single_data('boutique_shopping_cart', 'id', $shopping_cart_id, 'product_id');
        $product_update_data                       = array(); 
        $product_update_data['available_quantity'] = $this->common_model->query_single_data('boutique_products', 'id', $product_id, 'available_quantity') + $quantity;
        $this->common_model->update_data('id', $product_id, 'boutique_products', $product_update_data);

        if( $this->common_model->delete_data('id', $shopping_cart_id, 'boutique_shopping_cart') == TRUE )
            $this->session->set_flashdata('success_message', 'Your selected item was removed from the cart successfully');

        else
            $this->session->set_flashdata('error_message', 'Could not remove the item from your cart!!');

	redirect(base_url().'product/display_shopping_cart', 'refresh');
    }
	
    
    /**
     * Process payment through PayPal with chosen order-items
     * 
     * @access public 
     */
    public function goto_paypal()
    {
        $user_id     = $this->session->userdata('user_id');
        $cart_ids    = $this->input->post('cart_id');
        $cart_id_str = '';
        for ($i = 0; $i < count($cart_ids); $i++)
        {
            $cart_id_str .= $cart_ids[$i];
            if ($i < (count($cart_ids) - 1))
                $cart_id_str .= 'a';
        }
        
        redirect('paypal/auto_form/purchase_item/' . $user_id . '/' . $cart_id_str, 'refresh');
    }
    
    /**
     * Remove single product order of a user from shopping cart.
     * Use for the general users.
     * 
     * @return none 
     */
    public function confirmation($bill_no = NULL)
    {      
        //verifies paypal transaction
        $check_counter               = 0;
        $check_transaction_existence = $this->common_model->query_single_row_by_single_source('boutique_paypal_transactions', 'bill_no', $bill_no);
        $check_order_existence       = $this->common_model->query_single_row_by_single_source('boutique_user_orders', 'bill_no', $bill_no);
        if (count($check_transaction_existence) > 0)
            $check_counter ++;
        if (count($check_order_existence) > 0)
            $check_counter ++;
        
        if ($check_counter == 2) //transaction verified
        {
            $data['success']         = 'success';
            $data['success_message'] = 'Thank you for your order. Your Consignment No. '. $bill_no .' You can track your shipment using this Consignment No. Please checkout your email for transaction details.';
        }
        else
        {
            $data['error']         = 'error';
            $data['error_message'] = 'Your transaction could not be verified!! Please checkout your information while processing through PayPal.';
        }
        
        $data['table_title'] = 'Confirmation';
        $data['form_title']  = 'Confirmation';
        $data['action']      = 'display';
        
        $this->template->write_view('home_main_content', 'front_end/product/confirmation',$data, TRUE); 
        $this->template->render();
    }

}

/* End of file product.php */
/* Location: ./application/controllers/product.php */