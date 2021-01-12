<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model
{
    public $user_id;
    public $user_fname;
    public $user_lname;
    public $user_email;
    public $user_password;
    public $wishlist_name;
    public $wishlist_description;
    public $wishlist_occasion;

    public function __construct()
    {
        parent::__construct();
        $this->load->dbutil();
        $this->db->query('use w1714855_0');
    }

    function has_registered($data)
    {

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($data['field_name'], $data['value']);
        $query = $this->db->get();
        if ($query->num_rows() === 0) {
            return false;
        } else {
            return true;
        }
    }

    function get_user($data)
    {
        if ($this->has_registered($data)) {
            $query = $this->db->select('*')
                ->where('user_email', $data['user_email'])
                ->get('users');
            return $query->row_array();
        }else{
            return null;
        }
    }
    function insert_record($data)        // function insert_record($data)
    {
        $this->user_email = $data['user_email'];
        $this->user_fname = $data['user_fname'];
        $this->user_lname = $data['user_lname'];
        $this->user_password = password_hash($data['user_password'], PASSWORD_DEFAULT);
        $this->wishlist_name = $data['wishlist_name'];
        $this->wishlist_description = $data['wishlist_description'];
        $this->wishlist_occasion = $data['wishlist_occasion'];
        $details['field_name'] = 'user_email';
        $details['value'] = $data['user_email'];
        $user_registered = $this->has_registered($details);
        if ($user_registered === true) {
            return 'Cannot insert record as email is already in use.';
        } else {
            $this->db->insert('users', $this);
            return 'Registered New User';
        }
    }

    function validate_credentials($data)
    {
        $this->user_email = $data['user_email'];
        $details['field_name'] = 'user_email';
        $details['value'] = $data['user_email'];
        $user_registered = $this->has_registered($details);
        if ($user_registered === true) {
            $query = $this->db->select('*')
                ->where('user_email', $data['user_email'])
                ->get('users');
            $result = $query->row_array();
            if (password_verify($data['user_password'], $result['user_password'])) {
                return $result;
            } else {
                return null;
            }
        } else {
            return 'The email is not registered';
        }
    }
}
