<?php

/**
 * Product Section Model Class 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com> 
 */
class Product_section_model extends CI_Model
{

    /**
     * Model constructor 
     * 
     */
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Gets all sections page-wise 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
            $sort                    = "name ASC";
            $sql                     = "SELECT * FROM boutique_product_sections ORDER BY ".$sort ;		
            $sqlPaging               = "SELECT * FROM boutique_product_sections ORDER BY $sort LIMIT $start,$end";
            $data['section_afterPg'] = $this->db->query($sqlPaging)->result();
            $query1                  = $this->db->query($sql);
            $data['section_rows']    = $query1->num_rows();
            
            return $data;
    }

}

/* End of file product_section_model.php */
/* Location: ./application/models/product_section_model.php */