<?php

/**
 * Admin Model Class 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com> 
 */
class Admin_model extends CI_Model
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
     * @param string
     * @param string
     * @param string 
     * @return array|bool(0) 
     */
    public function verify_login_data($email, $pass)
    {
        $this->db->select('*');
	$this->db->from('boutique_users');
	$this->db->where('email_address', $email);
        $this->db->where('user_password', $pass);
        $this->db->where('is_active', 1);
        $this->db->limit(1);
	
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return FALSE;   
    }

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */