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

        if(empty($nama)){
            $userLogin = $this->Login_model->userLogin($username);
            if(($username === $userLogin['username']) && ($password === $userLogin['password'])){
                $payload['username'] = $username;
                $payload['iat'] = $this->date_reg->getTimestamp(); 
                $this->response([
                    'status' => TRUE,
                    'message' => 'Login Sukses',
                    'data' => [
                        'token' => JWT::encode($payload,$this->secretkey),
                        'fullnm' => $userLogin['fullnm'],
                        'photo' => $userLogin['photo']
                    ]
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Login Gagal, Masukan Email & Password yang terdaftar'
                ], REST_Controller::HTTP_OK);
            }
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
                'message' => 'Wrong Token'
            ], REST_Controller::HTTP_OK);
        }
    }
}
