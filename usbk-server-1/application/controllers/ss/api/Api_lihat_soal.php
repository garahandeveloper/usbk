<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_lihat_soal extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		$response = array();
		
	}
	public function index(){
		$response = array();
		
		if(empty($this->input->post("NISN")) && empty($this->input->post("NIK"))){
			echo "Empty page";
		} else {
			$where = array(
				"NISN" => $this->input->post("NISN"),
				"NIK" => $this->input->post("NIK")
			);
			
			$whereToken = array(
				"token_id" => $this->input->post("token")
			);
			
				$dataSoal = $this->Function_model_manually->readDataLimit("soal", "", $whereToken, "rand()", "1");
				
				foreach($dataSoal as $soal){
					$lihat["id_soal"] = $soal["id_soal"];
					$lihat["pertanyaan"] = $soal["pertanyaan"];
					$lihat["a"] = $soal["a"];
					$lihat["b"] = $soal["b"];
					$lihat["c"] = $soal["c"];
					$lihat["d"] = $soal["d"];
					$lihat["e"] = $soal["e"];
					$lihat["token_id"] = $soal["token_id"];
				}
				$whereToken2 = array(
				"token" => $this->input->post("token")
			);
				// untuk mengambil banyak soal yang akan di ujikan
				$queryJumlahSoal = $this->crud_function_model->readData("ujian", "", $whereToken2, "");
				foreach($queryJumlahSoal as $itemJumlah){
					$lihat["jumlah_soal"] = $itemJumlah["jumlah_soal"];
				}
				
				// mengambil banyak soal yang sudah di jawab
				$queryLihatData2 = $this->Function_model_manually->readDataLimit("jawaban_soal_siswa", "count(id_jawaban_soal_siswa) as no_soal", $where, "", "1");
				foreach($queryLihatData2 as $item2){					
					$lihat["no_soal"] = $item2["no_soal"];
				}
				
				if($itemJumlah["jumlah_soal"] <= $item2["no_soal"]){
					$lihat["nilai"] = "1";
				} else {
					$lihat["nilai"] = "0";
				}
				
				array_push($response, $lihat);
			
			echo json_encode($response);
		}
		
		
	}
}