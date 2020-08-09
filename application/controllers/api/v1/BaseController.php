<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/ExpiredException.php';
require APPPATH . 'libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;
use Restserver\Libraries\REST_Controller;
class BaseController extends REST_Controller
{
    private $secretkey = 'apaanpasswordnya?';
    private $decode;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->cektoken();
    }

    public function cektoken(){
        $jwt = $this->input->get_request_header('Authorization');
        try {
            $this->decode = JWT::decode($jwt,$this->secretkey,array('HS256'));
            die(print_r(['error',$this->decode],1));
            if ($this->Login_model->userLogin($this->decode->username)>0) {
                return true;
            }
        } catch (Exception $e) {
            die(print_r(['error',$jwt],1));
            $this->response([
                'status' => FALSE,
                'message' => 'Wrong Token'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function uid(){
        $jwt = $this->input->get_request_header('Authorization');
        $this->decode = JWT::decode($jwt,$this->secretkey,array('HS256'));
        $getId = $this->db->get_where('user',array('username'=>$this->decode->username))->result()[0]->id;
        return $getId;
    }
}
