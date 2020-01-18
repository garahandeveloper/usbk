<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_data_siswa_usba extends CI_Controller {

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
	}
	public function datakelas(){
		$response = array();
		$queryData = $this->crud_function_model->readData("kelas", "", "", "nama_kelas ASC");
		foreach($queryData as $item){
			$kelas["id_kelas"] = $item["id_kelas"];
			$kelas["nama_kelas"] = $item["nama_kelas"];
			array_push($response, $kelas);
		}
		echo json_encode($response);
	}
	public function datasiswa(){
		if (empty($_POST)) {
		} else {
			$response = array();
			if (!empty($this->input->post("id_kelas"))) {
				$postidkelas = $this->input->post("id_kelas");
				$whereParameter = "WHERE b.`id_kelas` = '$postidkelas'";
			} else if(!empty($this->input->post("id_data_siswa"))){
				$id_data_siswa = $this->input->post("id_data_siswa");
				$whereParameter = "WHERE a.`id_data_siswa` = $id_data_siswa";
			} else {
				$whereParameter = "";
			}
			
			$queryData = $this->Function_model_manually->readDataManuallyController("
			
			SELECT
			  a.`id_data_siswa` AS id,
			  a.`nama_siswa` AS nama,
			  a.`nisn` AS nisn,
			  a.`nik` AS nik,
			  b.`nama_kelas` AS kelas
			FROM
			  data_siswa AS a
			  JOIN kelas AS b
				ON a.`kelas_id` = b.`id_kelas`
			 $whereParameter ORDER BY nama_siswa ASC
				
			");
			foreach($queryData as $item){
				$siswa["id"] = $item["id"];
				$siswa["nama"] = $item["nama"];
				$siswa["nisn"] = $item["nisn"];
				$siswa["nik"] = $item["nik"];
				$siswa["kelas"] = $item["kelas"];
				array_push($response, $siswa);
			}
			echo json_encode($response);
		}
	}
	public function inputnewdatasiswa(){
		if (!empty($this->input->post("nama_siswa")) || !empty($this->input->post("nisn")) || !empty($this->input->post("nik")) || !empty($this->input->post("kelas_id"))) {
			$response = array();
			$whereArray = array(
					"nama_siswa" => $this->input->post("nama_siswa"),
					"nisn" => $this->input->post("nisn"),
					"nik" => $this->input->post("nik"),
					"kelas_id" => $this->input->post("kelas_id")
				);
			$this->crud_function_model->insertData("data_siswa", $whereArray);
			$siswa["status"] = "1";
			array_push($response, $siswa);
			echo json_encode($response);
		}
		
	}
	public function deletedatasiswa(){
		if (!empty($this->input->post("id_data_siswa"))) {
			$response = array();

			$whereArray = array(
					"id_data_siswa" => $this->input->post("id_data_siswa")
				);

			$querySelectSiswa = $this->crud_function_model->readData("data_siswa", "", $whereArray, "");

			foreach ($querySelectSiswa as $key) {
				$arrayNisNik = array(
						"nisn" => $key["nisn"],
						"nik" => $key["nik"]
					);
				$querySelectJawabanSiswa = $this->crud_function_model->login("jawaban_siswa", $arrayNisNik);
				if ($querySelectJawabanSiswa == 0) {
					$this->crud_function_model->deleteData("data_siswa", $whereArray);

					$siswa["message"] = "berhasil di hapus";
				} else {
					$siswa["message"] = "tidak bisa di hapus karna ada jawaban siswa belum di hapus";
				}
			}
			array_push($response, $siswa);
			echo json_encode($response);
		}
	}
	public function updatedatasiswa(){
		if (!empty($this->input->post("nama_siswa"))) {
			$response = array();
			$set = array(
					"nama_siswa" => $this->input->post("nama_siswa"),
					"nisn" => $this->input->post("nisn"),
					"nik" => $this->input->post("nik"),
					"kelas_id" => $this->input->post("kelas_id")
				);

			$whereArray = array(
					"id_data_siswa" => $this->input->post("id_data_siswa")
				);

			$this->crud_function_model->updateData("data_siswa", $set, $whereArray);
			$siswa["status"] = "1";
			array_push($response, $siswa);
			echo json_encode($response);
		}
	}	
}