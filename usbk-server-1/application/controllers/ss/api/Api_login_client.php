<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_login_client extends CI_Controller {

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
		
		$where = array(
			"NISN" => $this->input->post("NISN"),
			"NIK" => $this->input->post("NIK")
		);
		$response = array();
		$queryLogin = $this->crud_function_model->login("data_siswa", $where);
		if($queryLogin > "0"){
			$login = array();
			
			$login["message"] = "1";
			
			$queryCheck = $this->crud_function_model->readData("data_siswa", "", $where, "");
			foreach($queryCheck as $item){
				$login["NISN"] = $item["NISN"];
				$login["NIK"] = $item["NIK"];
			}
			$whereToken = array(
				"token" => $this->input->post("token")
			);
			$queryCheckToken = $this->crud_function_model->login("ujian", $whereToken);
			if($queryCheckToken){
				
				$token = $this->crud_function_model->readData("ujian", "", $whereToken, "");
				foreach($token as $tokenCetak){
					$login["token"] = $tokenCetak["token"];
				}
			} else {
				$login["token"] = "0";
			}
			array_push($response, $login);
		} else {
			$login = array();
			$login["NISN"] = "";
			$login["NIK"] = "";
			$login["message"] = "0";
			$login["token"] = "0";
			array_push($response, $login);
		}
		
		
		echo json_encode($response);
	}	
}