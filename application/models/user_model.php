<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model
{
    public $user_id;
    public $user_fname;
    public $user_lname;
    public $username;
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
                ->where($data['field_name'], $data['value'])
                ->get('users');
            return $query->row_array();
        } else {
            return null;
        }
    }
    function insert_record($data)        // function insert_record($data)
    {
        $this->username = $data['username'];
        $this->user_fname = $data['user_fname'];
        $this->user_lname = $data['user_lname'];
        $this->user_password = password_hash($data['user_password'], PASSWORD_DEFAULT);
        $this->wishlist_name = $data['wishlist_name'];
        $this->wishlist_description = $data['wishlist_description'];
        $this->wishlist_occasion = $data['wishlist_occasion'];
        $details['field_name'] = 'username';
        $details['value'] = $data['username'];
        $user_registered = $this->has_registered($details);
        if ($user_registered === true) {
            return 'Cannot insert record as username is already in use.';
        } else {
            $this->db->insert('users', $this);
            return 'Registered New User';
        }
    }

    function validate_credentials($data)
    {
        $this->username = $data['username'];
        $details['field_name'] = 'username';
        $details['value'] = $data['username'];
        $user_registered = $this->has_registered($details);
        if ($user_registered === true) {
            $query = $this->db->select('*')
                ->where('username', $data['username'])
                ->get('users');
            $result = $query->row_array();
            if (password_verify($data['user_password'], $result['user_password'])) {
                return $result;
            } else {
                return null;
            }
        } else {
            return 'The username is not registered';
        }
    }
}
