<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_nilai_siswa_usba extends CI_Controller {

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
		$response = array();
		$whereUjian = array(
			"id_ujian" =>  $this->input->post("id_ujian")
		);
		$queryUjian = $this->crud_function_model->readData("ujian", "", $whereUjian, "");
		foreach($queryUjian as $forujian){
			$nilai["ujian"] = $forujian["nama_ujian"];
			$whereSiswa = array(
				"kelas_id" => $this->input->post("kelas_id")
			);
			$querySiswa = $this->crud_function_model->readData("data_siswa", "", "", "");
			foreach($querySiswa as $item){
				
				$queryNilai = $this->Function_model_manually->readDataManuallyController("
				
				SELECT
				  FLOOR(
					SUM(
					  ((a.`jawaban_soal` = b.`jawaban`) = 1) * (100 / c.`jumlah_ujian`)
					)
				  ) AS nilai,
				  COUNT(*) AS jumlah_ujian,
				  SUM((a.`jawaban_soal` = b.`jawaban`) = 1) AS benar,
				  SUM((a.`jawaban_soal` != b.`jawaban`) = 1) AS salah,
				  b.`nik` as nik,
				  b.`nisn` as nisn,
				  b.`token` as token
				FROM
				  `soal` AS a
				  JOIN `jawaban_siswa` AS b
				  JOIN `ujian` AS c
					ON a.`id_soal` = b.`no_soal` 
					AND a.`ujian_id` = c.`id_ujian`
				WHERE b.`nisn` = '$item[nisn]' 
					AND b.`nik` = '$item[nik]' 
					AND b.`token` = '$forujian[token]'
				");
				foreach($queryNilai as $nilaiSiswa){
					$nilai["nama_siswa"] = $item["nama_siswa"];
					$nilai["nilai_siswa"] = $nilaiSiswa["nilai"];
					$nilai["jumlah_ujian"] = $nilaiSiswa["jumlah_ujian"];
					$nilai["benar"] = $nilaiSiswa["benar"];
					$nilai["salah"] = $nilaiSiswa["salah"];
					$nilai["nik"] = $nilaiSiswa["nik"];
					$nilai["nisn"] = $nilaiSiswa["nisn"];
					$nilai["token"] = $nilaiSiswa["token"];
				}
				array_push($response, $nilai);
				
			}
		}
		
		echo json_encode($response);
	}
	public function deletenilai(){
		if(!empty($this->input->post("keyId"))){
			$response = array();
			$whereSiswa = array(
				"nisn" => $this->input->post("nisn"),
				"nik" => $this->input->post("nik"),
				"token" => $this->input->post("token")
			);
			$this->crud_function_model->deleteData("jawaban_siswa", $whereSiswa);
			$nilai["message"] = "Data Berhasil Di hapus";
			array_push($response, $nilai);
			echo json_encode($response);
		}
	}
	
}