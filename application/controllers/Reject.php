<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . '../vendor/box/spout/src/Spout/Autoloader/autoload.php';

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class Reject extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('Auth_model', 'auth');
        $this->load->model('Reject_model', 'Reject');
    }

    public function index()
    {
        $getData = $this->Reject->get_data();
        if ($getData) {
            foreach ($getData as $key => $value) {
                $arr[] = array(
                    'id' => $value->id,
                    'tglperiksa' => $value->tglperiksa,
                    'ukuranfilm' => $value->desc_film,
                    'norm' => $value->norm,
                    'fullnm' => $value->fullnm,
                    'no_foto' => $value->no_foto,
                    'jenisperiksa' => $value->jenisperiksa,
                    'alasan' => strlen($value->alasan) > 15 ? substr($value->alasan, 0, 15) : $value->alasan
                );
            }
        } else {
            $arr[] = [];
        }
        $data['data'] = count($arr) > 0 ? $arr : null;
        $this->load->view('template/header');
        $this->load->view('reject/index', $data);
        $this->load->view('template/footer');
    }

    public function delete_reject()
    {
        $id = $this->input->post('id');
        $get_id = $this->Reject->delete_reject($id);
        if ($get_id > 0) {
            $this->session->set_flashdata('message', 'Berhasil Menghapus Data');
            redirect('reject');
        } else {
            $this->session->set_flashdata('message1', 'Gagal Menghapus Data');
            redirect('reject');
        }
    }

    public function export()
    {
        $tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        if ($tgl1 == null && $tgl2 == null) {
            $where = "";
        } else if ($tgl1 != null && $tgl2 == null) {
            $tgl1 = substr($tgl1, 0, 7);
            $where = "WHERE a.created_at LIKE '$tgl1%'";
        } else if ($tgl2 != null && $tgl1 == null) {
            $tgl2 = substr($tgl2, 0, 7);
            $where = "WHERE a.created_at LIKE '$tgl2%'";
        } else if ($tgl1 != null && $tgl2 != null) {
            $where = "WHERE a.created_at >= '$tgl1' AND a.created_at <= '$tgl2'";
        }

        $data = $this->db->query('
            SELECT a.*,b.username, c.descr as descukuran
             FROM reject a 
             JOIN user b ON a.created_by = b.id 
             JOIN film c ON a.film_id = c.id
             ' . $where . '
             ')->result_object();
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser("Export Data Reject.xlsx");
        $header = WriterEntityFactory::createRowFromArray([
            'Radiologi Bethesda Yogyakarta'
        ]);
        $sub_header = WriterEntityFactory::createRowFromArray(array(
            "Tanggal Pemeriksaan",
            "Ukuran Film",
            "No RM",
            "Nama Pasien",
            "No Foto",
            "Jenis Periksa",
            "Alasan",
            "User",
            "Tanggal Dibuat"
        ));

        $writer->addRow($header);
        $writer->addRow($sub_header);

        foreach ($data as $key => $value) {

            $row = WriterEntityFactory::createRowFromArray([
                $value->tglperiksa,
                $value->descukuran,
                $value->norm,
                $value->fullnm,
                $value->no_foto,
                $value->jenisperiksa,
                $value->alasan,
                $value->username,
                $value->created_at,
            ]);
            $writer->addRow($row);
        }
        $writer->close();
    }
}
