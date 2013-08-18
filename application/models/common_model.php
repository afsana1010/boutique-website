<?php

/**
 * Model that contains some commonly used core functions 
 * 
 * @author Mizanur Islam Laskar 
 */
class Common_model extends CI_Model
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
     * Appends associative array elements 
     * 
     * @access public 
     * @param array
     * @param array 
     * @return array|bool(0) 
     */
    public function associative_push($arr, $tmp)
    {
        if (is_array($tmp))
        {
            foreach ($tmp as $key => $value)
                $arr[$key] = $value;

            return $arr;
        }

        return false;
    }


    /**
     * Insert data into DB 
     * 
     * @access public 
     * @param string
     * @param array 
     * @return bool 
     */
    public function add_data($sql_table, $data_set)
    {
        $this->db->insert($sql_table, $data_set);
        if ($this->db->affected_rows() > 0)
            return true;

        else
            return false;
    }


    /**
     * Edit data into DB 
     * 
     * @access public 
     * @param string
     * @param string
     * @param string
     * @param array 
     * @return bool 
     */
    public function update_data($field_name, $field_data, $table_name, $updated_data)
    {
        $this->db->where($field_name, $field_data);
        $this->db->update($table_name, $updated_data);

        if ($this->db->affected_rows() > 0)
            return true;

        else
            return false;
    }


    /**
     * Delete data from DB 
     * 
     * @access public 
     * @param string
     * @param string
     * @param string
     * @return bool 
     */
    public function delete_data($field_name, $field_data, $table_name)
    {
        $this->db->delete($table_name, array($field_name => $field_data));
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }


    /**
     * Select data from DB 
     * 
     * @access public 
     * @param string
     * @return object 
     */
    public function query_all_data($table)
    {
        $query = $this->db->get($table);

        return $query->result();
    }


    /**
     * Select sort-wise data from DB 
     * 
     * @access public 
     * @param string
     * @param string 
     * @return object 
     */
    public function query_sorted_data($table, $sort_by)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($sort_by);
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * Fetch single field-data from DB 
     * 
     * @access public 
     * @param string
     * @param string
     * @param string
     * @param string 
     * @return string 
     */
    public function query_single_data($table, $target_field, $source_data, $desired_data)
    {
        $this->db->select($desired_data);
        $this->db->where($target_field, $source_data);
        $this->db->limit(1);
        $this->db->from($table);
        $query = $this->db->get();
        $row = $query->row();

        return $row->$desired_data;
    }


    /**
     * Fetch single-row data conditionally
     * 
     * @access public 
     * @param string
     * @param string
     * @param string 
     * @return object 
     */
    public function query_single_row_by_single_source($table, $target_field, $source_data)
    {
        $this->db->select('*');
        $this->db->where($target_field, $source_data);
        $this->db->limit(1);
        $this->db->from($table);
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * Fetch multiple-row data conditionally 
     * 
     * @access public 
     * @param string
     * @param string
     * @param string
     * @param string 
     *  
     * @return object 
     */
    public function query_multiple_rows_by_single_source($table, $target_field, $source_data, $sort_index = false)
    {
        $this->db->select('*');
        $this->db->where($target_field, $source_data);
        $this->db->from($table);
        if ($sort_index !== false)
            $this->db->order_by($sort_index, "asc");
        
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * Checkout duplicate data 
     * 
     * @access public 
     * @param string
     * @param string
     * @param string 
     * @return bool 
     */
    public function query_single_duplicate_data($table, $target_field, $data)
    {
        $this->db->select($target_field);
        $this->db->from($table);
        $this->db->where($target_field, $data);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return true;

        else
            return false;
    }


    /**
     * Gets the next auto-increment value of a table 
     * 
     * @access public 
     * @param string
     * @param string
     * @param string
     * @param string 
     * @return string 
     */
    public function get_next_order($table, $source_field, $source_data, $orderable_field)
    {
        $this->db->select($orderable_field);
        $this->db->where($source_field, $source_data);
        $this->db->limit(1);
        $this->db->from($table);
        $this->db->orderby($orderable_field, "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $max_record_order = ($row->$orderable_field) + 1;
        } else
            $max_record_order = 1;

        return $max_record_order;
    }
	
    /**
     * Gets the next auto-increment value of a table without any where clause
     * 
     * @access public 
     * @param string
     * @param string
     * @return string 
     */
    public function get_last_order_without_where_clause($table,  $orderable_field)
    {

		$sql='SELECT '.$orderable_field.' FROM '.$table.' ORDER BY '.$orderable_field.' DESC LIMIT 1';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $max_record_order = $row->$orderable_field;
        } else
            $max_record_order = 0;

        return $max_record_order;
    }


    /**
     * Fetch number of occurences 
     * 
     * @access public 
     * @param string
     * @param string 
     * @return integer 
     */
    public function num_of_data($table, $wh)
    {
        if (!empty($wh))
            $query = $this->db->query("SELECT * FROM " . $table . " " . $wh);
        else
        {
            $this->db->select('*');
            $this->db->from($table);
            $query = $this->db->get();
        }

        return $query->num_rows();
    }


    /**
     * Index-wise sort and paginate data 
     * 
     * @access public 
     * @param string
     * @param string
     * @param integer
     * @param integer
     * @param string
     * @param string 
     * @return object 
     */
    public function sort_data($sidx, $sord, $start, $limit, $table, $wh)
    {
        if (!empty($wh))
        {
            $query = $this->db->query("SELECT * FROM " . $table . " " . $wh . " ORDER BY " .
                $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit . "");
        } else
        {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->order_by($sidx, $sord);
            $this->db->limit($limit, $start);
            $query = $this->db->get();
        }

        return $query->result();
    }


    /**
     * Fetch all enum fields from a table 
     * 
     * @param string
     * @param string 
     * @return string 
     */
    public function get_enum_field_values($table, $field)
    {
        $query = $this->db->query("show columns from $table where Field='$field'");
        if ($query->num_rows <= 0)
            return false;

        $field_detail = $query->result();
        foreach ($field_detail as $rows)
            $type = preg_replace('/(^set\()|(^enum\()/i', '', $rows->Type);

        $enum_fields = substr($type, 0, -1);
        $field_split = explode(',', $enum_fields);

        return $field_split;
    }


    /**
     * Get IP of a user-end pc 
     * 
     * @return string 
     */
    public function get_real_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet

            $ip = $_SERVER['HTTP_CLIENT_IP'];

        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            //to check ip is pass from proxy

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

        else
            $ip = $_SERVER['REMOTE_ADDR'];

        return $ip;
    }


    /**
     * Generates best image-resolution comparing to the maximum and current resolutions 
     * 
     * @access public 
     * @param integer
     * @param integer
     * @param integer
     * @param integer 
     * @return string 
     */
    public function get_image_size($thumbnail_max_width, $thumbnail_max_height, $image_width,
        $image_height)
    {
        if ($image_width > $thumbnail_max_width)
        {
            $w = $thumbnail_max_width;
            $h = ($image_height * $w) / $image_width;

            if ($h > $thumbnail_max_height)
            {
                $h = $thumbnail_max_height;
                $w = ($image_width * $h) / $image_height;
            }
        } else
        {
            $w = $image_width;
            $h = ($image_height * $w) / $image_width;

            if ($h > $thumbnail_max_height)
            {
                $h = $thumbnail_max_height;
                $w = ($image_width * $h) / $image_height;
            }
        }

        return $w . '|' . $h;
    }


    /**
     * Plurarize any given word if applicable 
     * 
     * @access public 
     * @param string 
     * @return string 
     */
    public function depluralize($word)
    {
        $rules = array('ss' => false, 'os' => 'o', 'ies' => 'y', 'xes' => 'x', 'oes' =>
            'o', 'ies' => 'y', 'ves' => 'f', 's' => '');
        foreach (array_keys($rules) as $key)
        {
            if (substr($word, (strlen($key) * -1)) != $key)
                continue;

            if ($key === false)
                return $word;

            return substr($word, 0, strlen($word) - strlen($key)) . $rules[$key];
        }

        return $word;
    }
    
    
    /**
     * Generates a 16-digit unique random number 
     * 
     * @param string 
     * @param string 
     * 
     * @return integer 
     */
    public function get_unique_numeric_id($check_table, $check_field, $is_activation_code = false)
    {
        // creates a random id
        $random_unique_int = mt_rand(1000000000000000,9999999999999999);
        if ($random_unique_int < 0)
            $random_unique_int *= (-1);

        // Make sure the random id isn't already in use
        $this->db->select($check_field);
        $this->db->where($check_field, $random_unique_int);
        $this->db->limit(1);
        $this->db->from($check_table);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $query->free_result();

            // If the random id is already in use, get a new number
            $this->get_unique_numeric_id($check_table, $check_field);
        }

        if ($is_activation_code)
            return substr($random_unique_int, 0, 4);
        else
            return $random_unique_int;
    } 

}

/* End of file common_model.php */
/* Location: ./application/models/common_model.php */