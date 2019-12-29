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
    private $secretkey = 'jon123';
    private $decode;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
    }

    public function cektoken(){
        $jwt = $this->input->get_request_header('Authorization');
        try {
            $this->decode = JWT::decode($jwt,$this->secretkey,array('HS256'));
            if ($this->Login_model->userLogin($this->decode->username)>0) {
                return true;
            }
        } catch (Exception $e) {
            $this->response([
                'status' => FALSE,
                'data' => 'Wrong Token'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function uid(){
        $jwt = $this->input->get_request_header('Authorization');
        $this->decode = JWT::decode($jwt,$this->secretkey,array('HS256'));
        $getId = $this->db->get_where('user',array('username'=>$this->decode->username))->result()[0]->Id;
        return $getId;
    }
}
