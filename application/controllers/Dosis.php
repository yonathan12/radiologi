<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . '../vendor/box/spout/src/Spout/Autoloader/autoload.php';

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class Dosis extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('Auth_model', 'auth');
        $this->load->model('Dosis_model', 'Dosis');
    }

    public function index()
    {
        $getData = $this->Dosis->get_data();
        $data['data'] = $getData;
        $this->load->view('template/header');
        $this->load->view('dosis/index', $data);
        $this->load->view('template/footer');
    }

    public function delete_dosis()
    {
        $id = $this->input->post('id');
        $get_id = $this->Dosis->delete_dosis($id);
        if ($get_id > 0) {
            $this->session->set_flashdata('message', 'Berhasil Menghapus Data');
            redirect('dosis');
        } else {
            $this->session->set_flashdata('message1', 'Gagal Menghapus Data');
            redirect('dosis');
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

        $data = $this->db->query('SELECT a.*,b.username FROM dosis a JOIN user b ON a.created_by = b.id ' . $where . '')->result_object();
        
        $writer = WriterEntityFactory::createXLSXWriter();

        $writer->openToBrowser("Export Data Dosis.xlsx");
        $header = WriterEntityFactory::createRowFromArray([
            'Radiologi Bethesda Yogyakarta'
        ]);
        $sub_header = WriterEntityFactory::createRowFromArray(array(
            "Tanggal Pemeriksaan",
            "Kode Pasien",
            "Nama Pasien",
            "Umur",
            "Berat Badan",
            "NOP",
            "CTDI",
            "DLP",
            "User",
            "Tanggal Dibuat"
        ));

        $writer->addRow($header);
        $writer->addRow($sub_header);

        foreach ($data as $key => $value) {
            
            $row = WriterEntityFactory::createRowFromArray([
                $value->tglperiksa,
                $value->kdpasien,
                $value->fullnm,
                $value->umur,
                $value->berat_badan,
                $value->nop,
                $value->ctdi,
                $value->dlp,
                $value->username,
                $value->created_at,
            ]);
            $writer->addRow($row);
        }
        $writer->close();
    }
}
