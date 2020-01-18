<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_login_client_usba extends CI_Controller {

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
		if(empty($this->input->post("nisn")) && empty($this->input->post("nik"))){}
		else {
			$response = array();
			$where = array(
				"nisn" => $this->input->post("nisn"),
				"nik" => $this->input->post("nik"),
			);
			$queryLogin = $this->crud_function_model->login("data_siswa", $where);
			if($queryLogin > 0){
				$login["message"] = "1";
				
				$queryCheck = $this->crud_function_model->readData("data_siswa", "", $where, "");
				foreach($queryCheck as $item){
					$login["nisn"] = $item["nisn"];
					$login["nik"] = $item["nik"];
					$login["nama_siswa"] = $item["nama_siswa"];
				}
				$whereToken = array(
					"token" => $this->input->post("token")
				);
				$queryToken = $this->crud_function_model->login("ujian", $whereToken);
				if($queryToken > 0){
					$queryTokenData = $this->crud_function_model->readData("ujian", "", $whereToken, "");
					foreach($queryTokenData as $tokenArray){
						$login["token"] = $tokenArray["token"];
						$whereMateri = array(
							"id_materi" => $tokenArray["materi_id"]
						);
						$queryMateri = $this->crud_function_model->readData("materi", "", $whereMateri, "");
						foreach($queryMateri as $materiUjian){
							$login["materi"] = $materiUjian["nama_materi"];
						}
					}
				} else {
					$login["token"] = "0";
				}
				array_push($response, $login);
			} else {
				
				$login["nisn"] = "0";
				$login["nik"] = "0";
				$login["token"] = "0";
				$login["nama_siswa"] = "0";
				$login["message"] = "0";
				$login["materi"] = "0";
				array_push($response, $login);
			}
			echo json_encode($response);
		}
		
	}
}