<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_data_kelas_usba extends CI_Controller {

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
	public function inputkelas(){
		if (!empty($this->input->post("nama_kelas"))) {
			$arrayWherekelas = array(
					"nama_kelas" => $this->input->post("nama_kelas")
				);
			$response = array();
			$queryData = $this->crud_function_model->insertData("kelas", $arrayWherekelas);
			$kelas["status"] = "1";
			array_push($response, $kelas);
			echo json_encode($response);
		}
		
	}
	public function deletekelas(){
		if (!empty($this->input->post("id_kelas"))) {
			$response = array();
			$arrayWherekelas = array(
					"id_kelas" => $this->input->post("id_kelas")
				);
			$whereUjianSelectIdKelas = array(
				"kelas_id" => $this->input->post("id_kelas")
			);
			$query = $this->crud_function_model->login("ujian", $whereUjianSelectIdKelas);
			if ($query == 0) {
				$this->crud_function_model->deleteData("kelas", $arrayWherekelas);
				$kelas["message"] = "berhasil di hapus";
			} else {
				$kelas["message"] = "tidak bisa di hapus ada ujian yang menggunakan id kelas ini";
			}
			array_push($response, $kelas);
			echo json_encode($response);
		}
		
	}
}