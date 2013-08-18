<?php

/**
 * Contains the core logic to generate and process product-message data 
 * 
 * @author Mizanur Islam Laskar <cicakemizan@gmail.com>
 * Creation Date   : October 5, 2012 
 */
class Register_model extends CI_Model
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
     * Gets page-wise product-message 
     * 
     * @param string $table
     * @param string $email
     * @param string $password
     * 
     * @return bool 
     */
    
	public function verify_user_login($table, $email,$password)
    {
		$this->db->select('*');
		$this->db->where('email_address', $email);
		$this->db->where('user_password', sha1($password));
                $this->db->where('is_active', 1);
		$this->db->limit(1);
		$this->db->from($table);
		$query = $this->db->get();
		
		return $query->num_rows();
    }
    /**
     * Gets page-wise product-message 
     * 
     * @param string $table
     * @param string $email
     * @param string $password
     * 
     * @return array 
     */
    
	public function logged_in_user_info($table, $email,$password)
    {
		$this->db->select('*');
		$this->db->where('email_address', $email);
		$this->db->where('user_password', sha1($password));
		$this->db->limit(1);
		$this->db->from($table);
		$query = $this->db->get();
		
		return $query->result();
    }  
}

/* End of file message_model.php */
/* Location: ./application/models/message_model.php */