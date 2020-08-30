<?php

class Dosis_model extends CI_Model
{
    public function get_data()
    {
        $date = date('Y-m');
        $this->db->select('dosis.id,dosis.tglperiksa,dosis.kdpasien, dosis.berat_badan,
        dosis.dlp, dosis.fullnm, dosis.umur, dosis.nop, dosis.ctdi, device.descr');
        $this->db->from('dosis');
        $this->db->join('device', 'device.id = dosis.device_id');
        $this->db->where(['substr(dosis.created_at,1,7)' => $date]);
        $get_data = $this->db->get()->result_array();
        return $get_data;
    }

    public function delete_dosis($id)
    {
        return $this->db->delete('dosis',array('id' => $id));;
    }
}
