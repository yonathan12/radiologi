<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Device_model','Device');
    }

    public function index(){
        $getData = $this->Device->get_data();
        $data['data'] = $getData;
        $this->load->view('template/header');
        $this->load->view('parameter/device',$data);
        $this->load->view('template/footer');
    }

    public function create(){
        $descr = $this->input->post('descr');
        $data = [
            'descr' => $descr,
            'created_by' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $get_id = $this->Device->create($data);
        if($get_id){
            $this->session->set_flashdata('message','Menambahkan Alat');
            redirect('device');
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
        $get_id = $this->Device->update($data, $id);
        if($get_id){
            $this->session->set_flashdata('message','Mengubah Alat');
            redirect('device');
        }
    }

    public function delete($id){
        $hapus = $this->Device->delete($id);
        if($hapus > 0){
            $this->session->set_flashdata('message','Menghapus Alat');
            redirect('device');
        }
    }
}