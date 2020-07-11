<?php
class User_model extends CI_Model
{
    public function create($data)
    {
        $this->db->insert('user',$data);
        return $this->db->insert_id();
    }

    public function update($data, $id)
    {
        return $this->db->update('user',$data,array('id'=>$id));
    }

    public function delete($id)
    {
        return $this->db->delete('user',array('id' => $id));
    }
}

?>