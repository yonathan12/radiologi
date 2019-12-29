<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('Auth_model','auth');
    }

    public function index(){
        $this->db->order_by('status','DESC');
        $getData = $this->db->get('user')->result_array();
        $data['user'] = $getData;
        $this->load->view('template/header');
        $this->load->view('user/index',$data);
        $this->load->view('template/footer');
    }

    public function tambahUser(){
        $fullnm = $this->input->post('fullnm');
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $admin = $this->input->post('admin')=="on"?"Y":"T";

        $data = [
            'fullnm' => $fullnm,
            'username' => $username,
            'password' => $password,
            'admin' => $admin,
            'status' => 1,
            'usrnme' => $this->session->userdata('id'),
            'lupddt' => date('Y-m-d'),
            'lupdtime' => date('H:i:s')
        ];

        $this->db->insert('user',$data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            $this->session->set_flashdata('message','Berhasil Menambahkan User');
            redirect('master');
        }
    }

    public function editUser(){
        $id = $this->input->post('id');
        $fullnm = $this->input->post('fullnm');
        $username = strtolower($this->input->post('username'));
        $password = md5($this->input->post('password'));
        $admin = $this->input->post('admin')=="on"?"Y":"T";
        $status = $this->input->post('status')=="on"?"1":"0";

        if($password){
            $data = [
                'fullnm' => $fullnm,
                'username' => $username,
                'password' => $password,
                'admin' => $admin,
                'status' => $status,
                'usrnme' => $this->session->userdata('id'),
                'lupddt' => date('Y-m-d'),
                'lupdtime' => date('H:i:s')
            ];
        }else{
            $data = [
                'fullnm' => $fullnm,
                'username' => $username,
                'admin' => $admin,
                'status' => $status,
                'usrnme' => $this->session->userdata('id'),
                'lupddt' => date('Y-m-d'),
                'lupdtime' => date('H:i:s')
            ];
        }

        $update = $this->db->update('user',$data,array('id'=>$id));
        if($update){
            $this->session->set_flashdata('message','Berhasil Mengubah User');
            redirect('master');
        }
    }

    public function hapusUser($id){
        // die(print_r($id,1));
        $hapus = $this->db->delete('user',array('id' => $id));
        if($hapus > 0){
            $this->session->set_flashdata('message','Berhasil Menghapus Data');
            redirect('master');
        }
    }
}