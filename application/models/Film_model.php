<?php
class Film_model extends CI_Model
{
    public function get_data()
    {
        $this->db->order_by('id','ASC');
        return $this->db->get('film')->result_array();
         
    }

    public function create($data)
    {
        $this->db->insert('film',$data);
        return $this->db->insert_id();
    }

    public function update($data, $id)
    {
        return $this->db->update('film',$data,array('id'=>$id));
    }

    public function delete($id)
    {
        return $this->db->delete('film',array('id' => $id));
    }
}

?>