<?php

/**
 * Contains the core logic to generate and process product-inventory data 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 * Creation Date   : October 5, 2012 
 */
class Advertisement_model extends CI_Model
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
     * Gets page-wise product-inventory 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
        $sort                  = "customer_name ASC";
        $sql                   = "SELECT * FROM boutique_advertisements ORDER BY ".$sort ;		
        $sql_paging 	       = "SELECT * FROM boutique_advertisements ORDER BY $sort LIMIT $start,$end";
        $data['advertisement_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 	       	   = $this->db->query($sql);
        $data['advertisement_rows']    = $query1->num_rows();

        return $data;
    }

    /**
     * Gets advertisement images 
     * 
     * @param integer $advertisement_id
     * @param string $image_file
     * 
     * @return bool 
     */
    public function check_advertisement_image($advertisement_id,$image_file)
    {
        $this->db->select('file_name');
        $this->db->from('boutique_advertisement_images');
        $this->db->where('file_name',$image_file);
        $this->db->where('advertisement_id',$advertisement_id);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) 
            return TRUE;
        else
            return FALSE;   
    }
 
}

/* End of file inventory_model.php */
/* Location: ./application/models/inventory_model.php */
