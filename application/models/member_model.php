<?php

/**
 * Contains the core logic to generate and process member data 
 * 
 * @author Afsana Rahman Snigdha 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 */
class Member_model extends CI_Model
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
     * Verify Access Credential 
     * 
     * @access public
     * @param string
     * @param string
     * @param string 
     * @return array|bool(0) 
     */
    public function verify_login_data($name, $pass, $table)
    {
        $name_field="name";
        $pass_field="password";
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($name_field, $name);
        $this->db->where($pass_field, $pass);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return FALSE;   
    }

    /**
     * Gets all members page-wise 
     * 
     * @param integer $start
     * @param integer $end
     * 
     * @return array 
     */
    public function get_pagewise($start, $end)
    {
        $conditiion             = "WHERE is_admin = 0";
        $sort                   = "full_name ASC";
        $sql                    = "SELECT * FROM boutique_users " . $conditiion . " ORDER BY ".$sort ;		
        $sql_paging 		= "SELECT * FROM boutique_users " . $conditiion . " ORDER BY $sort LIMIT $start,$end";
        $data['member_afterPg'] = $this->db->query($sql_paging)->result();
        $query1 		= $this->db->query($sql);
        $data['member_rows']    = $query1->num_rows();

        return $data;
    }
    
}

/* End of file member.php */
/* Location: ./application/models/member.php */