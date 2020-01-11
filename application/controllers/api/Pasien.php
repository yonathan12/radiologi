<?php

require APPPATH . 'controllers/api/BaseController.php';
use Restserver\Libraries\REST_Controller;
class Pasien extends BaseController
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
            $this->db->order_by('lupddt', 'DESC');
            $getData = $this->db->get_where('data',
            array(
                'usrnme'=>$this->uid(),
                'id'=>$id
                )
            )->result();
            foreach($getData as $key => $value){
                $arr = array(
                    'id' => $value->Id,
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
            $getData = $this->db->get_where('data',array('usrnme'=>$this->uid()))->result();
            foreach($getData as $key => $value){
                $arr[] = array(
                    'id' => $value->Id,
                    'fullnm' => $value->fullnm,
                    'umur' => $value->umur
                );
            }
        }
        
        $this->response([
            'status' => TRUE,
            'data' => $arr
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
            'usrnme' => $this->uid(),
            'lupddt' => date('Y-m-d'),
            'lupdtime' => date('H:i:s')
        );

        $insert = $this->db->insert('data',$data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            $this->response([
                'status' => TRUE,
                'id' => $insert_id
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
            'usrnme' => $this->uid(),
            'lupddt' => date('Y-m-d'),
            'lupdtime' => date('H:i:s')
        );
        
        $update = $this->db->update('data',$data,array( 'id '=> $id ));
        if($update){
            $this->response([
                'status' => TRUE,
                'data' => "Data Pasien Berhasil Di Ubah"
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_delete(){
        $id = $this->delete('id');
        
        $delete = $this->db->delete('umur',array( 'id '=> $id ));
        if($delete){
            $this->response([
                'status' => TRUE,
                'data' => "Catatan Berhasil Di Hapus"
            ], REST_Controller::HTTP_OK);
        }
    }

    public function searchPasien(){
        $keyword = $this->get('search');
        $usrnme = $this->uid();
        $getData = $this->db->query("SELECT Id,fullnm, umur FROM data
        WHERE usrnme = '$usrnme' AND fullnm like '%$keyword%'")->result();
        if($getData){
            foreach($getData as $key => $value){
                $arr[] = array(
                    'id' => $value->Id,
                    'fullnm' => $value->fullnm,
                    'umur' => $value->umur
                );
            }
        }else{
            $arr[] = ['fullnm' => 'Tidak Ada Data','umur'=>''];
        }
        
        $this->response([
            'status' => TRUE,
            'data' => $arr
        ], REST_Controller::HTTP_OK);
    }
}