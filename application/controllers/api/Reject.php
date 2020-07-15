<?php

require APPPATH . 'controllers/api/BaseController.php';

use Restserver\Libraries\REST_Controller;

class Reject extends BaseController
{
    public function index_get()
    {
        $id = $this->get('id');

        $method = $this->get('methods');
        if ($method) {
            return $this->$method();
        }

        if ($id) {
            $this->db->limit(20);
            $this->db->order_by('created_at', 'DESC');
            $getData = $this->db->get_where(
                'reject',
                array(
                    'created_by' => $this->uid(),
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
            $getData = $this->db->get_where('reject', array('created_by' => $this->uid()))->result();
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
            'data' => $getData?$arr:null
        ], REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $norm = $this->post('no_rm');
        $fullnm = $this->post('nama');
        $ukuran = $this->post('ukuran');
        $no_foto = $this->post('no_foto');
        $jenisPeriksa = $this->post('jenisperiksa');
        $alasanReject = $this->post('alasanreject');
        $tgl = $this->post('tanggal');

        $data = array(
            'tglperiksa' => $tgl ? $tgl : date('Y-m-d'),
            'norm' => $norm,
            'fullnm' => $fullnm,
            'film_id' => $ukuran,
            'no_foto' => $no_foto,
            'jenisperiksa' => $jenisPeriksa,
            'alasan' => $alasanReject,
            'created_by' => $this->uid(),
            'created_at' => date('Y-m-d H:i:s')
        );

        $insert = $this->db->insert('reject', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $this->response([
                'status' => TRUE,
                'message' => 'Data Berhasil Ditambahkan',
                'data' => ['id' => $insert_id]
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
        $jenisPeriksa = $this->put('jenisperiksa');
        $alasanReject = $this->put('alasanreject');
        $tgl = $this->put('tanggal');

        $data = array(
            'tglperiksa' => $tgl ? $tgl : date('Y-m-d'),
            'norm' => $norm,
            'fullnm' => $fullnm,
            'film_id' => $ukuran,
            'no_foto' => $no_foto,
            'jenisperiksa' => $jenisPeriksa,
            'alasan' => $alasanReject,
            'updated_by' => $this->uid(),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $update = $this->db->update('reject', $data, array('id ' => $id));
        if ($update) {
            $this->response([
                'status' => TRUE,
                'message' => 'Data Reject Berhasil Di Ubah'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function searchPasien()
    {
        $keyword = $this->get('search');
        $usrnme = $this->uid();
        $getData = $this->db->query("SELECT id,norm, fullnm FROM reject
        WHERE created_by = '$usrnme' AND norm like '%$keyword%'")->result();
        if ($getData) {
            foreach ($getData as $key => $value) {
                $arr[] = array(
                    'id' => $value->id,
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

    public function get_param_film()
    {
        $getData = $this->db->get('film')->result();
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
