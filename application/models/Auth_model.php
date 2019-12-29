<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model Extends CI_Model
{
    public function getUser($email)
    {
        return $this->db->get_where('user',['email' => $email,'is_active' => 1])->row_array();
    }

    public function getUserToken($token)
    {
        return $this->db->get_where('user_token',['token' => $token])->row_array();
    }
}
