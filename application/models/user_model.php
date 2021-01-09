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
    }

    function has_registered($email){
        $result = $this->db->get_where('users', array('user_email' => $email));	   
        if ($result->num_rows() === 0) {
            return false;    
        }else{
            return true;
        }
    }

    function has_registered_id($id){
        $result = $this->db->get_where('users', array('user_id' => $id));	   
        if ($result->num_rows() === 0) {
            return false;    
        }else{
            return true;
        }
    }

    function insert_record($data)	    // function insert_record($data)
    {	     
        $this->user_email = $data['user_email'];
        $this->user_fname = $data['user_fname'];
        $this->user_lname = $data['user_lname'];        
        $this->user_password = password_hash($data['user_password'],PASSWORD_DEFAULT);
        $this->wishlist_name = $data['wishlist_name'];
        $this->wishlist_description = $data['wishlist_description'];
        $this->wishlist_occasion = $data['wishlist_occasion'];
        $user_registered = $this->has_registered($data['email']);
        if($user_registered === true){
            return 'Cannot insert record as email is already in use.';
        }else{
            $this->db->insert('users', $data);
            return 'Registered New User';
        }
    }

    function validate_credentials($data){
        $this->user_email = $data['email'];
        $this->user_password =password_hash($data['password'],PASSWORD_DEFAULT);
        $user_registered = $this->has_registered($data['email']);
        if($user_registered === true){
            $query = $this->db->select()
            ->where('user_email', $data['email'])
            ->get('users');
            $result = $query->row_array();
            if($result['password'] === $this->user_password){
                return $result;
            }else{
                return null;
            }
        }else{
            return 'The email is not registered';
        }
       
    }

    
}
