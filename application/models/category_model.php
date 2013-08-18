<?php

/**
 * Category Model Class 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com> 
 */
class Category_model extends CI_Model
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
     * Gets all categories page-wise 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
            $sort                     = "name ASC";
            $sql                      = "SELECT * FROM boutique_categories ORDER BY ".$sort ;		
            $sqlPaging                = "SELECT * FROM boutique_categories ORDER BY $sort LIMIT $start,$end";
            $data['category_afterPg'] = $this->db->query($sqlPaging)->result();
            $query1                   = $this->db->query($sql);
            $data['category_rows']    = $query1->num_rows();
            
            return $data;
    }

}

/* End of file category_model.php */
/* Location: ./application/models/category_model.php */