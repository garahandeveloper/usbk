<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_singkronisasi_data extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		
	}
	public function index(){
		$query1 = $this->crud_function_model->readData("ujian", "", "", "");
		$response = array();
		foreach($query1 as $item){
			$lihat["nama_ujian"] = $item["nama_ujian"];
			$lihat["jumlah_soal"] = $item["jumlah_soal"];
			$lihat["token"] = $item["token"];
			array_push($response, $lihat);
		}
		echo json_encode($response);
	}
}	