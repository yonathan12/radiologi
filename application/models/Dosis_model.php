<?php

class Dosis_model extends CI_Model
{
    public function get_data()
    {
        $date = date('Y-m');
        $this->db->where(['substr(created_at,1,7)' => $date]);
        $get_data = $this->db->get('dosis')->result_array();
        return $get_data;
    }

    public function delete_dosis($id)
    {
        return $this->db->delete('dosis',array('id' => $id));;
    }
}
