<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosis extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('excel');
        $this->load->library('form_validation');
        $this->load->model('Auth_model','auth');
        $this->load->model('Dosis_model','Dosis');
    }

    public function index(){
        $getData = $this->Dosis->get_data();
        $data['data'] = $getData;
        $this->load->view('template/header');
        $this->load->view('dosis/index',$data);
        $this->load->view('template/footer');
    }

    public function delete_dosis(){
        $id = $this->input->post('id');
        $get_id =$this->Dosis->delete_dosis($id);
        if($get_id > 0){
            $this->session->set_flashdata('message','Berhasil Menghapus Data');
            redirect('dosis');
        }else{
            $this->session->set_flashdata('message1','Gagal Menghapus Data');
            redirect('dosis');
        }
    }
    
    public function export()
    {
        $tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        if($tgl1 == null && $tgl2 == null){
            $where = "";
        }else if($tgl1 != null && $tgl2 == null){
            $tgl1 = substr($tgl1,0,7);
            $where = "WHERE a.lupddt LIKE '$tgl1%'";
        }else if($tgl2 != null && $tgl1 == null){
            $tgl2 = substr($tgl2,0,7);
            $where = "WHERE a.lupddt LIKE '$tgl2%'";
        }else if($tgl1 != null && $tgl2 != null){
            $where = "WHERE a.lupddt BETWEEN '$tgl1' AND '$tgl2'";
        }
        $object = new PHPExcel();

        $table_columns = array(
            "Tanggal Pemeriksaan",
            "Kode Pasien",
            "Nama Pasien",
            "Umur",
            "Berat Badan",
            "NOP",
            "CTDI",
            "DLP",
            "User",
            "Tanggal Dibuat",
            "Jam Dibuat"
        );

        $column = 0;
        for ($col='A'; $col !=='M' ; $col++) { 
            $object->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $object->getActiveSheet()->mergeCells('A1:K1');
        $object->getActiveSheet()->mergeCells('A2:K2');
        $object->getActiveSheet()->getStyle("A1:A2")->getFont()->setSize(14);
 

        $object->getActiveSheet()->getStyle( "A1" )->getFont()->setBold( true );
        $object->getActiveSheet()->getStyle( "A2" )->getFont()->setBold( true );

        $object->getActiveSheet()->setCellValueByColumnAndRow("A1", 1, "Radiologi Bethesda");
        $object->getActiveSheet()->setCellValueByColumnAndRow("A2", 2, "Yogyakarta");

        $object->getActiveSheet()->getStyle('A4:K4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('F28A8C'); 
        
        $row_judul = 4;

        foreach($table_columns as $field)
        {
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, $row_judul, $field);
        $column++;
        }

        $data = $this->db->query('SELECT a.*,b.username FROM data a JOIN user b ON a.usrnme = b.id '.$where.'')->result_object();
        $excel_row = 5;
        foreach ($data as $row) {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->tglperiksa);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->kdpasien);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->fullnm);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->umur);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->berat_badan);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->nop);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->ctdi);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->dlp);
            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->username);
            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->lupddt);
            $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->lupdtime);

            $excel_row++;
        }
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Export Data.xls"');
        $object_writer->save('php://output');
    }
}