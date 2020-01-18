<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_values extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		$this->output->set_header( "Access-Control-Allow-Origin: *" );
		$this->output->set_header( "Access-Control-Allow-Credentials: true" );
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( "Access-Control-Max-Age: 604800" );
		$this->output->set_header( "Access-Control-Request-Headers: x-requested-with" );
		$this->output->set_header( "Access-Control-Allow-Headers: x-requested-with, x-requested-by" );
		
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		$response = array();
		
	}
	public function index(){
		//$queryValues = $this->Function_model_manually->readDataManuallyController("select distinct a.*, b.*, b.jawaban as jwbn, a.jawaban as jawaban_soal from soal as a left join jawaban_soal_siswa as b on a.id_soal = b.no && a.token_id = 25332 && b.NISN = 12115088 where a.token_id = 25332 order by id_soal asc limit 50");
		
		$NISN = $this->input->post("NISN");
		$NIK = $this->input->post("NIK");
		$token = $this->input->post("token");
		
		$queryValues = $this->Function_model_manually->readDataManuallyController("select a.token, a.nama_ujian as nama_ujian, b.nama_kelas as kelas, c.nama_lengkap as guru, d.nama_mapel as mapel from ujian as a join data_kelas as b join data_pegawai as c join mapel as d on a.kelas = b.id_data_kelas && a.guru = c.id_data_pegawai && a.mapel = d.id_mapel ");
		$response = array();
		foreach($queryValues as $item){
			$values["nama_ujian"] = "Ujian : ".$item["nama_ujian"];
			$values["kelas"] = "Kelas : ".$item["kelas"];
			$values["guru"] = "Guru : ".$item["guru"];
			$values["mapel"] = "Mapel : ".$item["mapel"];
		
			
			$queryNilai = $this->Function_model_manually->readDataManuallyController("select round(sum((a.jawaban = b.jawaban) = 1) * (100 / c.jumlah_soal), 1) as nilaiAhirSiswa, a.token as token  from jawaban_soal_siswa as a join soal as b join ujian as c on c.token = a.token && a.no = b.id_soal where a.NISN = '$NISN' && a.NIK = '$NIK' && a.token = '$token'");
			foreach($queryNilai as $nilai){
				if($item["token"] == $nilai["token"]){
					$values["nilai"] = $nilai["nilaiAhirSiswa"];
				} else {
					$values["nilai"] = "-";
				}
				
			}
			
			array_push($response, $values);
		}
		echo json_encode($response);
	}
}