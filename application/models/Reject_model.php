<?php
class Reject_model extends CI_Model
{
    public function get_data()
    {
        $this->db->select('reject.*,film.ukuranfilm as desc_film');
        $this->db->from('reject');
        $this->db->join('film','film.id = reject.film_id');
        return $this->db->get()->result();
    }

    public function delete_reject($id)
    {
        return $this->db->delete('reject',array('id' => $id));
    }
}
?>