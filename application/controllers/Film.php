<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Film extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Film_model','Film');
    }

    public function index(){
        $getData = $this->Film->get_data();
        $data['data'] = $getData;
        $this->load->view('template/header');
        $this->load->view('parameter/film',$data);
        $this->load->view('template/footer');
    }

    public function create(){
        $descr = $this->input->post('descr');
        $data = [
            'descr' => $descr,
            'created_by' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $get_id = $this->Film->create($data);
        if($get_id){
            $this->session->set_flashdata('message','Berhasil Menambahkan Ukuran Film');
            redirect('film');
        }
    }

    public function update(){
        $id = $this->input->post('id');
        $ukuran = $this->input->post('descr');

        $data = [
            'descr' => $ukuran,
            'updated_by' => $this->session->userdata('id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $get_id = $this->Film->update($data, $id);
        if($get_id){
            $this->session->set_flashdata('message','Berhasil Mengubah Ukuran Film');
            redirect('film');
        }
    }

    public function delete($id){
        $hapus = $this->Film->delete($id);
        if($hapus > 0){
            $this->session->set_flashdata('message','Berhasil Menghapus Ukuran Film');
            redirect('film');
        }
    }
}