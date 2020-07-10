<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/ExpiredException.php';
require APPPATH . 'libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;
use Restserver\Libraries\REST_Controller;
class Login extends REST_Controller
{
    private $secretkey = 'jon123';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->date_reg = new DateTime();
    }

    public function index_post()
    {
        $username = strtolower($this->post('username'));
        $password = md5($this->post('password'));
        $nama = $this->post('nama');
        $data = [
            'username' => $this->post('username'),
            'password' => md5($this->post('password')),
            'lupddt' => date('Y-m-d'),
            'lupdtime' => date('H:i:s')
        ];

        if($this->post('method') == "register"){
            $this->register($data, $username);
        }

        if(empty($nama)){
            $userLogin = $this->Login_model->userLogin($username);
            if(($username === $userLogin['username']) && ($password === $userLogin['password'])){
                $payload['username'] = $username;
                $payload['iat'] = $this->date_reg->getTimestamp(); 
                $this->response([
                    'status' => TRUE,
                    'data' => 'Login Sukses',
                    'token' => JWT::encode($payload,$this->secretkey),
                    'fullnm' => $userLogin['fullnm']
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'data' => 'Login Gagal, Masukan Email & Password yang terdaftar'
                ], REST_Controller::HTTP_OK);
            }
        }
    }

    public function register($data, $username)
    {
        $checkUser = $this->Login_model->checkUser($username);
        
        if($checkUser){
            $this->response([
                'status' => FALSE,
                'data' => 'User Telah Terdaftar'
            ], REST_Controller::HTTP_OK);
        }
        if ($this->Login_model->addUser($data) > 0) {
            $payload['username'] = $username;
            $payload['iat'] = $this->date_reg->getTimestamp(); 
            $this->response([
                'status' => TRUE,
                'data' => 'Berhasil Melakukan Registrasi',
                'token' => JWT::encode($payload,$this->secretkey)
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'data' => 'Gagal Melakukan Registrasi'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function cektoken(){
        $jwt = $this->input->get_request_header('Authorization');
        try {
            $decode = JWT::decode($jwt,$this->secretkey,array('HS256'));
            if ($this->Login_model->userLogin($decode->username)>0) {
                return true;
            }
        } catch (Exception $e) {
            $this->response([
                'status' => FALSE,
                'data' => 'Wrong Token'
            ], REST_Controller::HTTP_OK);
        }
    }
}
