<?php

require APPPATH . 'controllers/api/v1/BaseController.php';

use phpDocumentor\Reflection\Types\False_;
use Restserver\Libraries\REST_Controller;

class Dosis extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index_get()
    {
        $id = $this->get('id');

        $method = $this->get('method');
        if ($method) {
            return $this->$method();
        }

        if ($id) {
            $getData = $this->db->get_where(
                'dosis',
                array(
                    'created_by' => $this->uid(),
                    'id' => $id
                )
            )->result();
            foreach ($getData as $key => $value) {
                $arr = array(
                    'id' => $value->id,
                    'tglperiksa' => $value->tglperiksa ? date('Y-m-d', strtotime($value->tglperiksa)) : '',
                    'kdpasien' => $value->kdpasien,
                    'fullnm' => $value->fullnm,
                    'umur' => $value->umur,
                    'berat_badan' => $value->berat_badan,
                    'nop' => $value->nop,
                    'ctdi' => $value->ctdi,
                    'dlp' => $value->dlp,
                    'device_id' => $value->device_id
                );
            }
        } else {
            $uid = $this->uid();
            $getData = $this->db->query(
                "SELECT temp.* from (
                    SELECT id,fullnm, umur,updated_at,created_at FROM dosis
                    WHERE created_by = '$uid'  order by created_at desc, updated_at desc)as temp 
                    where MONTH(created_at) = MONTH(CURDATE()) or MONTH(updated_at) = MONTH(CURDATE())"
            )->result();
            foreach ($getData as $key => $value) {
                $arr[] = array(
                    'id' => $value->id,
                    'fullnm' => $value->fullnm,
                    'umur' => $value->umur
                );
            }
        }
        $this->response([
            'status' => TRUE,
            'data' => $getData ? $arr : null
        ], REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $this->form_validation->set_rules('fullnm', 'Nama Lengkap', 'required');
        if ($this->form_validation->run() == FALSE) {
            return $this->response([
                'status' => False,
                'message' => [
                    'fullnm' => form_error('fullnm')
                ]
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $fullnm = $this->post('fullnm');
        $umur = $this->post('umur');
        $beratBadan = $this->post('beratBadan');
        $nop = $this->post('nop');
        $ctdi = $this->post('ctdi');
        $dlp = $this->post('dlp');
        $kdpasien = $this->post('kdpasien');
        $tgl = $this->post('tanggal');
        $device_id = $this->post('device_id');

        $data = array(
            'tglperiksa' => $tgl ? $tgl : date('Y-m-d'),
            'kdpasien' => $kdpasien,
            'fullnm' => $fullnm,
            'umur' => $umur,
            'berat_badan' => $beratBadan,
            'nop' => $nop,
            'ctdi' => $ctdi,
            'dlp' => $dlp,
            'device_id' => $device_id,
            'created_by' => $this->uid(),
            'created_at' => date('Y-m-d H:i:s')
        );

        $insert = $this->db->insert('dosis', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $this->response([
                'status' => TRUE,
                'message' => 'Data Berhasil Disimpan',
                'data' => [
                    'id' => $insert_id
                ]
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => "Data Gagal DiSimpan"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $this->form_validation->set_rules('fullnm', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('id', 'required');
        if ($this->form_validation->run() == FALSE) {
            return $this->response([
                'status' => False,
                'message' => [
                    'fullnm' => form_error('fullnm'),
                    'id' => form_error('id')
                ]
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $id = $this->put('id');
        $fullnm = $this->put('fullnm');
        $tgl = $this->put('tanggal');
        $umur = $this->put('umur');
        $beratBadan = $this->put('beratBadan');
        $nop = $this->put('nop');
        $ctdi = $this->put('ctdi');
        $dlp = $this->put('dlp');
        $kdpasien = $this->put('kdpasien');
        $device_id = $this->post('device_id');

        $data = array(
            'tglperiksa' => $tgl ? $tgl : date('Y-m-d'),
            'kdpasien' => $kdpasien,
            'fullnm' => $fullnm,
            'umur' => $umur,
            'berat_badan' => $beratBadan,
            'nop' => $nop,
            'ctdi' => $ctdi,
            'dlp' => $dlp,
            'device_id' => $device_id,
            'updated_by' => $this->uid(),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $update = $this->db->update('dosis', $data, array('id ' => $id));
        if ($update) {
            $this->response([
                'status' => TRUE,
                'message' => "Data Berhasil Di Ubah"
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => "Data Gagal Di Ubah"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function searchPasien()
    {
        $keyword = $this->get('search');
        $page = $this->get('page');
        if (!$page)
            $page = 1;
        $offset = (10 * $page) - 10;
        $usrnme = $this->uid();
        $getData = $this->db->query("
        SELECT temp.* from (
        SELECT id,fullnm, umur,updated_at,created_at FROM dosis
        WHERE created_by = '$usrnme' AND fullnm like '%$keyword%' order by created_at desc, updated_at desc)as temp 
        where MONTH(created_at) = MONTH(CURDATE()) or MONTH(updated_at) = MONTH(CURDATE())")->result();
        if ($getData) {
            foreach ($getData as $key => $value) {
                $arr[] = array(
                    'id' => $value->id,
                    'fullnm' => $value->fullnm,
                    'umur' => $value->umur
                );
            }
        } else {
            $arr[] = ['id' => 0, 'fullnm' => 'Tidak Ada Data', 'umur' => ''];
        }
        if ($arr) {
            $this->response([
                'status' => TRUE,
                'data' => $arr
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => "Gagal Mengambil Data"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function get_param_device()
    {
        $getData = $this->db->get('device')->result();
        foreach ($getData as $key => $value) {
            $arr[] = array(
                'id' => $value->id,
                'descr' => $value->descr
            );
        }
        $this->response([
            'status' => TRUE,
            'data' => $arr
        ], REST_Controller::HTTP_OK);
    }
}
