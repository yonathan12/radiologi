<?php

require APPPATH . 'controllers/api/BaseController.php';
use Restserver\Libraries\REST_Controller;
class Dosis extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->cektoken();
    }

    public function index_get(){
        $id = $this->get('id');

        $method = $this->get('method');
        if($method){
            return $this->$method();
        }

        if($id){
            $this->db->limit(20);
            $this->db->order_by('created_at', 'DESC');
            $getData = $this->db->get_where('dosis',
            array(
                'created_by'=>$this->uid(),
                'id'=>$id
                )
            )->result();
            foreach($getData as $key => $value){
                $arr = array(
                    'id' => $value->id,
                    'tglperiksa' => $value->tglperiksa?date('Y-m-d',strtotime($value->tglperiksa)):'',
                    'kdpasien' => $value->kdpasien,
                    'fullnm' => $value->fullnm,
                    'umur' => $value->umur,
                    'berat_badan' => $value->berat_badan,
                    'nop' => $value->nop,
                    'ctdi' => $value->ctdi,
                    'dlp' => $value->dlp
                );
            }
        }else{
            $getData = $this->db->get_where('dosis',array('created_by'=>$this->uid()))->result();
            foreach($getData as $key => $value){
                $arr[] = array(
                    'id' => $value->id,
                    'fullnm' => $value->fullnm,
                    'umur' => $value->umur
                );
            }
        }
        $this->response([
            'status' => TRUE,
            'data' => $getData?$arr:null
        ], REST_Controller::HTTP_OK);
        
    }

    public function index_post(){
        $fullnm = $this->post('nama');
        $umur = $this->post('umur');
        $beratBadan = $this->post('beratBadan');
        $nop = $this->post('nop');
        $ctdi = $this->post('ctdi');
        $dlp = $this->post('dlp');
        $kdpasien = $this->post('kdpasien');
        $tgl = $this->post('tanggal');

        $data = array(
            'tglperiksa' => $tgl?$tgl:date('Y-m-d'),
            'kdpasien' => $kdpasien,
            'fullnm' => $fullnm,
            'umur' => $umur,
            'berat_badan' => $beratBadan,
            'nop' => $nop,
            'ctdi' => $ctdi,
            'dlp' => $dlp,
            'created_by' => $this->uid(),
            'created_at' => date('Y-m-d H:i:s')
        );

        $insert = $this->db->insert('dosis',$data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            $this->response([
                'status' => TRUE,
                'message' => 'Data Berhasil Disimpan',
                'data' => [
                    'id' => $insert_id
                ]
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_put(){
        $id = $this->put('id');
        $fullnm = $this->put('nama');
        $tgl = $this->put('tanggal');
        $umur = $this->put('umur');
        $beratBadan = $this->put('beratBadan');
        $nop = $this->put('nop');
        $ctdi = $this->put('ctdi');
        $dlp = $this->put('dlp');
        $kdpasien = $this->put('kdpasien');

        $data = array(
            'tglperiksa' => $tgl?$tgl:date('Y-m-d'),
            'kdpasien' => $kdpasien,
            'fullnm' => $fullnm,
            'umur' => $umur,
            'berat_badan' => $beratBadan,
            'nop' => $nop,
            'ctdi' => $ctdi,
            'dlp' => $dlp,
            'updated_by' => $this->uid(),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $update = $this->db->update('dosis',$data,array( 'id '=> $id ));
        if($update){
            $this->response([
                'status' => TRUE,
                'message' => "Data Berhasil Di Ubah"
            ], REST_Controller::HTTP_OK);
        }
    }

    public function searchPasien(){
        $keyword = $this->get('search');
        $page = $this->get('page');
        $offset = (10 * $page)-10;
        $usrnme = $this->uid();
        $getData = $this->db->query("SELECT id,fullnm, umur FROM dosis
        WHERE created_by = '$usrnme' AND fullnm like '%$keyword%' limit 10 offset $offset")->result();
        if($getData){
            foreach($getData as $key => $value){
                $arr[] = array(
                    'id' => $value->id,
                    'fullnm' => $value->fullnm,
                    'umur' => $value->umur
                );
            }
        }else{
            $arr[] = ['id'=> 0, 'fullnm' => 'Tidak Ada Data','umur'=>''];
        }
        
        $this->response([
            'status' => TRUE,
            'data' => $arr
        ], REST_Controller::HTTP_OK);
    }
}