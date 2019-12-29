<?php
class Login_model extends CI_Model
{
    public function addUser($data){
        $this->db->insert('user',$data);
        return $this->db->affected_rows();
    }

    public function checkUser($username)
    {
        return $this->db->get_where('user',['username' => $username])->row_array()['username'];
        
    }

    public function userLogin($username)
    {
        return $this->db->get_where('user',['username' => $username,'status'=>'1'])->row_array();
    }
}
?>