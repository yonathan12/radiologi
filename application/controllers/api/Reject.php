<?php

require APPPATH . 'controllers/api/BaseController.php';

use Restserver\Libraries\REST_Controller;

class Reject extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->cektoken();
    }

    public function index_get()
    {
        $id = $this->get('id');

        $method = $this->get('method');
        if ($method) {
            return $this->$method();
        }

        if ($id) {
            $this->db->limit(20);
            $this->db->order_by('lupddt', 'DESC');
            $getData = $this->db->get_where(
                'reject',
                array(
                    'usrnme' => $this->uid(),
                    'id' => $id
                )
            )->result();
            foreach ($getData as $key => $value) {
                $arr = array(
                    'id' => $value->Id,
                    'tglperiksa' => $value->tglperiksa ? date('Y-m-d', strtotime($value->tglperiksa)) : '',
                    'ukuranfilm' => $value->ukuranfilm,
                    'norm' => $value->norm,
                    'fullnm' => $value->fullnm,
                    'nofoto' => $value->no_foto,
                    'jenisperiksa' => $value->jenisperiksa,
                    'alasan' => $value->alasan
                );
            }
        } else {
            $getData = $this->db->get_where('reject', array('usrnme' => $this->uid()))->result();
            foreach ($getData as $key => $value) {
                $arr[] = array(
                    'id' => $value->Id,
                    'norm' => $value->norm,
                    'nofoto' => $value->no_foto
                );
            }
        }

        $this->response([
            'status' => TRUE,
            'data' => $arr
        ], REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $norm = $this->post('no_rm');
        $fullnm = $this->post('nama');
        $ukuran = $this->post('ukuran');
        $no_foto = $this->post('no_foto');
        $jenisPeriksa = $this->post('jenisPeriksa');
        $alasanReject = $this->post('alasanReject');
        $tgl = $this->post('tanggal');

        $data = array(
            'tglperiksa' => $tgl ? $tgl : date('Y-m-d'),
            'norm' => $norm,
            'fullnm' => $fullnm,
            'ukuranfilm' => $ukuran,
            'no_foto' => $no_foto,
            'jenisPeriksa' => $jenisPeriksa,
            'alasan' => $alasanReject,
            'usrnme' => $this->uid(),
            'lupddt' => date('Y-m-d'),
            'lupdtime' => date('H:i:s')
        );

        $insert = $this->db->insert('reject', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $this->response([
                'status' => TRUE,
                'id' => $insert_id
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $norm = $this->put('no_rm');
        $fullnm = $this->put('nama');
        $ukuran = $this->put('ukuran');
        $no_foto = $this->put('no_foto');
        $jenisPeriksa = $this->put('jenisPeriksa');
        $alasanReject = $this->put('alasanReject');
        $tgl = $this->put('tanggal');

        $data = array(
            'tglperiksa' => $tgl ? $tgl : date('Y-m-d'),
            'norm' => $norm,
            'fullnm' => $fullnm,
            'ukuranfilm' => $ukuran,
            'no_foto' => $no_foto,
            'jenisPeriksa' => $jenisPeriksa,
            'alasan' => $alasanReject,
            'usrnme' => $this->uid(),
            'lupddt' => date('Y-m-d'),
            'lupdtime' => date('H:i:s')
        );

        $update = $this->db->update('reject', $data, array('id ' => $id));
        if ($update) {
            $this->response([
                'status' => TRUE,
                'data' => "Data Reject Berhasil Di Ubah"
            ], REST_Controller::HTTP_OK);
        }
    }

    public function searchPasien()
    {
        $keyword = $this->get('search');
        $usrnme = $this->uid();
        $getData = $this->db->query("SELECT Id,norm, fullnm FROM reject
        WHERE usrnme = '$usrnme' AND norm like '%$keyword%'")->result();
        if ($getData) {
            foreach ($getData as $key => $value) {
                $arr[] = array(
                    'id' => $value->Id,
                    'norm' => $value->norm,
                    'fullnm' => $value->fullnm
                );
            }
        } else {
            $arr[] = ['fullnm' => 'Tidak Ada Data', 'umur' => ''];
        }

        $this->response([
            'status' => TRUE,
            'data' => $arr
        ], REST_Controller::HTTP_OK);
    }

    public function getList()
    {
        $getData = $this->db->get('film')->result();
        foreach ($getData as $key => $value) {
            $arr[] = array(
                'id' => $value->Id,
                'ukuranfilm' => $value->ukuranfilm
            );
        }
        $this->response([
            'status' => TRUE,
            'data' => $arr
        ], REST_Controller::HTTP_OK);
    }
}
