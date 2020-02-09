<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ParameterFilm extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('excel');
        $this->load->library('form_validation');
        $this->load->model('Auth_model','auth');
    }

    public function index(){
        $this->db->order_by('id','ASC');
        $getData = $this->db->get('film')->result_array();
        $data['user'] = $getData;
        $this->load->view('template/header');
        $this->load->view('film/index',$data);
        $this->load->view('template/footer');
    }

    public function tambahFilm(){
        $ukuran = $this->input->post('ukuran');

        $data = [
            'ukuranfilm' => $ukuran,
            'usrnme' => $this->session->userdata('id'),
            'lupddt' => date('Y-m-d'),
            'lupdtime' => date('H:i:s')
        ];

        $this->db->insert('film',$data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            $this->session->set_flashdata('message','Berhasil Menambahkan Ukuran Film');
            redirect('parameterfilm');
        }
    }

    public function editFilm(){
        $id = $this->input->post('id');
        $ukuran = $this->input->post('ukuran');

        $data = [
            'ukuranfilm' => $ukuran,
            'usrnme' => $this->session->userdata('id'),
            'lupddt' => date('Y-m-d'),
            'lupdtime' => date('H:i:s')
        ];

        $update = $this->db->update('film',$data,array('id'=>$id));
        if($update){
            $this->session->set_flashdata('message','Berhasil Mengubah Ukuran Film');
            redirect('parameterfilm');
        }
    }

    public function hapusFilm($id){
        $hapus = $this->db->delete('film',array('id' => $id));
        if($hapus > 0){
            $this->session->set_flashdata('message','Berhasil Menghapus Ukuran Film');
            redirect('parameterfilm');
        }
    }
}