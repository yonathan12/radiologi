<?php
class User_model extends CI_Model
{
    public function create($data)
    {
        $this->db->insert('user',$data);
        return $this->db->insert_id();
    }
}

?>