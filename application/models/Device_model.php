<?php
class Device_model extends CI_Model
{
    public function get_data()
    {
        $this->db->order_by('id','ASC');
        return $this->db->get('device')->result_array();
         
    }

    public function create($data)
    {
        $this->db->insert('device',$data);
        return $this->db->insert_id();
    }

    public function update($data, $id)
    {
        return $this->db->update('device',$data,array('id'=>$id));
    }

    public function delete($id)
    {
        return $this->db->delete('device',array('id' => $id));
    }
}

?>