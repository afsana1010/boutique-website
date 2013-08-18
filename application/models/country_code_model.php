<?php

/**
 * Country Code Model Class 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com> 
 */
class Country_code_model extends CI_Model
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
     * Gets all codes page-wise 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
            $sort                 = "country ASC";
            $sql                  = "SELECT * FROM boutique_country_codes ORDER BY ".$sort ;		
            $sqlPaging            = "SELECT * FROM boutique_country_codes ORDER BY $sort LIMIT $start,$end";
            $data['code_afterPg'] = $this->db->query($sqlPaging)->result();
            $query1               = $this->db->query($sql);
            $data['code_rows']    = $query1->num_rows();
            
            return $data;
    }
    
    /**
     * Gets country-code by user-id
     * 
     * @param integer
     * 
     * @return integer 
     */
    public function get_country_code_by_user_id($user_id)
    {
            $this->db->select('boutique_country_codes.code');
            $this->db->from('boutique_country_codes');
            $this->db->join('boutique_users', 'boutique_users.country_code_id = boutique_country_codes.id');
            $this->db->where('boutique_users.id', $user_id);
            $this->db->limit(1);
            $query = $this->db->get();
            $row   = $query->row();
            
            $country_code = $row->code;
            
            return $country_code;
    }

}

/* End of file country_code_model.php */
/* Location: ./application/models/country_code_model.php */