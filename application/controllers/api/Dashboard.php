<?php
require APPPATH . 'controllers/api/BaseController.php';
use Restserver\Libraries\REST_Controller;
class Dashboard extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->cektoken();
    }

    public function index_get(){

        $count = $this->db->count_all('notes'); 
        if($count){
            $this->response([
                'status' => TRUE,
                'total' => $count
            ], REST_Controller::HTTP_OK);
        }
    }
}